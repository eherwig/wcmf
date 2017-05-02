<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2015 wemove digital solutions GmbH
 *
 * Licensed under the terms of the MIT License.
 *
 * See the LICENSE file distributed with this work for
 * additional information.
 */
namespace wcmf\lib\persistence\impl;

use Exception;
use wcmf\lib\core\EventManager;
use wcmf\lib\core\LogManager;
use wcmf\lib\persistence\ObjectId;
use wcmf\lib\persistence\PersistenceException;
use wcmf\lib\persistence\PersistenceFacade;
use wcmf\lib\persistence\PersistentObject;
use wcmf\lib\persistence\StateChangeEvent;
use wcmf\lib\persistence\Transaction;

/**
 * Default implementation of Transaction.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class DefaultTransaction implements Transaction {

  private static $isInfoEnabled = false;
  private static $isDebugEnabled = false;
  private static $logger = null;

  private $persistenceFacade = null;
  private $eventManager = null;

  private $id = '';
  private $isActive = false;
  private $isInCommit = false;
  private $observedObjects = array();

  protected $newObjects = array();
  protected $dirtyObjects = array();
  protected $deletedObjects = array();
  protected $detachedObjects = array();

  /**
   * Contains all loaded objects no matter which state they have
   */
  protected $loadedObjects = array();

  /**
   * Constructor
   * @param $persistenceFacade
   * @param $eventManager
   */
  public function __construct(PersistenceFacade $persistenceFacade,
          EventManager $eventManager) {
    if (self::$logger == null) {
      self::$logger = LogManager::getLogger(__CLASS__);
    }
    $this->persistenceFacade = $persistenceFacade;
    $this->eventManager = $eventManager;

    $this->id = __CLASS__.'_'.ObjectId::getDummyId();
    $this->eventManager->addListener(StateChangeEvent::NAME,
      array($this, 'stateChanged'));
    self::$isInfoEnabled = self::$logger->isInfoEnabled();
    self::$isDebugEnabled = self::$logger->isDebugEnabled();
  }

  /**
   * Destructor.
   */
  public function __destruct() {
    $this->eventManager->removeListener(StateChangeEvent::NAME,
      array($this, 'stateChanged'));
  }

  /**
   * @see Transaction::registerLoaded()
   */
  public function registerLoaded(PersistentObject $object) {
    $oid = $object->getOID();
    $key = $oid->__toString();
    if (self::$isDebugEnabled) {
      self::$logger->debug("New Data:\n".$object->dump());
      self::$logger->debug("Registry before:\n".$this->dump());
    }
    // register the object if it is newly loaded or
    // merge the attributes, if it is already loaded
    $registeredObject = null;
    if (isset($this->loadedObjects[$key])) {
      $registeredObject = $this->loadedObjects[$key];
      // merge existing attributes with new attributes
      if (self::$isDebugEnabled) {
        self::$logger->debug("Merging data of ".$key);
      }
      $registeredObject->mergeValues($object);
    }
    else {
      if (self::$isDebugEnabled) {
        self::$logger->debug("Register loaded object: ".$key);
      }
      $this->loadedObjects[$key] = $object;
      // start to listen to changes if the transaction is active
      if ($this->isActive) {
        if (self::$isDebugEnabled) {
          self::$logger->debug("Start listening to: ".$key);
        }
        $this->observedObjects[$key] = $object;
      }
      $registeredObject = $object;
    }
    if (self::$isDebugEnabled) {
      self::$logger->debug("Registry after:\n".$this->dump());
    }
    return $registeredObject;
  }

  /**
   * @see Transaction::registerNew()
   */
  public function registerNew(PersistentObject $object) {
    if (!$this->isActive) {
      return;
    }
    $key = $object->getOID()->__toString();
    if (self::$isDebugEnabled) {
      self::$logger->debug("Register new object: ".$key);
    }
    $this->newObjects[$key] = $object;
    $this->observedObjects[$key] = $object;
  }

  /**
   * @see Transaction::registerDirty()
   */
  public function registerDirty(PersistentObject $object) {
    if (!$this->isActive) {
      return;
    }
    $key = $object->getOID()->__toString();
    // if it was a new or deleted object, we return immediatly
    if (isset($this->newObjects[$key]) || isset($this->deletedObjects[$key])) {
      return;
    }
    if (self::$isDebugEnabled) {
      self::$logger->debug("Register dirty object: ".$key);
    }
    $this->dirtyObjects[$key] = $object;
  }

  /**
   * @see Transaction::registerDeleted()
   */
  public function registerDeleted(PersistentObject $object) {
    if (!$this->isActive) {
      return;
    }
    $key = $object->getOID()->__toString();
    // if it was a new object, we remove it from the registry and
    // return immediatly
    if (isset($this->newObjects[$key])) {
      unset($this->newObjects[$key]);
      return;
    }
    // if it was a dirty object, we remove it from the registry
    if (isset($this->dirtyObjects[$key])) {
      unset($this->dirtyObjects[$key]);
    }
    if (self::$isDebugEnabled) {
      self::$logger->debug("Register deleted object: ".$key);
    }
    $this->deletedObjects[$key] = $object;
  }

  /**
   * @see Transaction::begin()
   */
  public function begin() {
    if (self::$isInfoEnabled) {
      self::$logger->info("Starting transaction");
    }
    $this->isActive = true;
  }

  /**
   * @see Transaction::commit()
   */
  public function commit() {
    if ($this->isInCommit) {
      return;
    }
    if (self::$isInfoEnabled) {
      self::$logger->info("Commit transaction");
    }
    $this->isInCommit = true;
    $changedOids = array();
    if ($this->isActive) {
      $knowTypes = $this->persistenceFacade->getKnownTypes();
      try {
        // start transaction for each mapper
        foreach ($knowTypes as $type) {
          $mapper = $this->persistenceFacade->getMapper($type);
          $mapper->beginTransaction();
        }
        // process the recorded object changes, since new
        // object changes may occure during the commit, we
        // loop until all queues are empty
        $commitDone = false;
        $emptyState = '0:0:0';
        while (!$commitDone) {
          // check queues before processing
          $oldState = sizeof($this->newObjects).':'.
                  sizeof($this->dirtyObjects).':'.
                  sizeof($this->deletedObjects);
          $changedOids = array_merge($changedOids, $this->processInserts());
          $this->processUpdates();
          $this->processDeletes();
          // check queues after processing
          $newState = sizeof($this->newObjects).':'.
                  sizeof($this->dirtyObjects).':'.
                  sizeof($this->deletedObjects);
          // prevent recursion (queue sizes didn't change)
          if ($oldState != $emptyState && $oldState == $newState) {
            throw new PersistenceException("Recursion in transaction commit");
          }
          // check if all queues are empty
          $commitDone = $newState == $emptyState;
        }
        // commit transaction for each mapper
        if (self::$isInfoEnabled) {
          self::$logger->info("Committing transaction");
        }
        foreach ($knowTypes as $type) {
          $mapper = $this->persistenceFacade->getMapper($type);
          $mapper->commitTransaction();
        }
      }
      catch (Exception $ex) {
        // rollback transaction for each mapper
        self::$logger->error("Rolling back transaction. Exception: ".$ex->__toString());
        foreach ($knowTypes as $type) {
          $mapper = $this->persistenceFacade->getMapper($type);
          $mapper->rollbackTransaction();
        }
        $this->rollback();
        throw $ex;
      }
    }
    // forget changes
    $this->rollback();
    return $changedOids;
  }

  /**
   * @see Transaction::rollback()
   */
  public function rollback() {
    if (self::$isInfoEnabled) {
      self::$logger->info("Rollback transaction");
    }
    // forget changes
    $this->clear();
    $this->isActive = false;
    $this->isInCommit = false;
  }

  /**
   * @see Transaction::isActive()
   */
  public function isActive() {
    return $this->isActive;
  }

  /**
   * @see Transaction::getLoaded()
   */
  public function getLoaded(ObjectId $oid) {
    $registeredObject = null;
    $key = $oid->__toString();
    if (isset($this->loadedObjects[$key])) {
      $registeredObject = $this->loadedObjects[$key];
    }
    return $registeredObject;
  }

  /**
   * @see Transaction::detach()
   */
  public function detach(ObjectId $oid) {
    $key = $oid->__toString();
    if (isset($this->newObjects[$key])) {
      unset($this->newObjects[$key]);
    }
    if (isset($this->dirtyObjects[$key])) {
      unset($this->dirtyObjects[$key]);
    }
    if (isset($this->deletedObjects[$key])) {
      unset($this->deletedObjects[$key]);
    }
    if (isset($this->loadedObjects[$key])) {
      unset($this->loadedObjects[$key]);
    }
    unset($this->observedObjects[$key]);
    $this->detachedObjects[$key] = $oid;
  }

  /**
   * Dump the registry content into a string
   * @return String
   */
  protected function dump() {
    $str = '';
    foreach (array_values($this->loadedObjects) as $curObject) {
      $str .= $curObject->dump();
    }
    return $str;
  }

  /**
   * Clear all internal
   */
  protected function clear() {
    foreach ($this->newObjects as $object) {
      unset($this->observedObjects[$object->getOID()->__toString()]);
    }
    $this->newObjects = array();

    foreach ($this->dirtyObjects as $object) {
      unset($this->observedObjects[$object->getOID()->__toString()]);
    }
    $this->dirtyObjects = array();

    foreach ($this->deletedObjects as $object) {
      unset($this->observedObjects[$object->getOID()->__toString()]);
    }
    $this->deletedObjects = array();

    foreach ($this->loadedObjects as $object) {
      unset($this->observedObjects[$object->getOID()->__toString()]);
    }
    $this->loadedObjects = array();

    $this->detachedObjects = array();
  }

  /**
   * Process the new objects queue
   * @return Map of oid changes (key: oid string before commit, value: oid string after commit)
   */
  protected function processInserts() {
    $changedOids = array();
    $pendingInserts = array();
    $insertOids = array_keys($this->newObjects);
    while (sizeof($insertOids) > 0) {
      $key = array_shift($insertOids);
      if (self::$isDebugEnabled) {
        self::$logger->debug("Process insert on object: ".$key);
      }
      $object = $this->newObjects[$key];
      // postpone insert, if the object has required objects that are
      // not persisted yet
      $canInsert = true;
      $requiredObjects = $object->getIndispensableObjects();
      foreach ($requiredObjects as $requiredObject) {
        if ($requiredObject->getState() == PersistentObject::STATE_NEW) {
          if (self::$isDebugEnabled) {
            self::$logger->debug("Postpone insert of object: ".$key.". Required objects are not saved yet.");
          }
          $pendingInserts[] = $object;
          $canInsert = false;
          break;
        }
      }
      if ($canInsert) {
        $oldOid = $object->getOID();
        $object->getMapper()->save($object);
        $changedOids[$oldOid->__toString()] = $object->getOID()->__toString();
      }
      unset($this->newObjects[$key]);
      $insertOids = array_keys($this->newObjects);
      unset($this->observedObjects[$key]);
      $this->observedObjects[$object->getOID()->__toString()] = $object;
    }
    // re-add pending inserts
    foreach ($pendingInserts as $object) {
      $key = $object->getOID()->__toString();
      $this->newObjects[$key] = $object;
    }
    return $changedOids;
  }

  /**
   * Process the dirty objects queue
   */
  protected function processUpdates() {
    $updateOids = array_keys($this->dirtyObjects);
    while (sizeof($updateOids) > 0) {
      $key = array_shift($updateOids);
      if (self::$isDebugEnabled) {
        self::$logger->debug("Process update on object: ".$key);
      }
      $object = $this->dirtyObjects[$key];
      $object->getMapper()->save($object);
      unset($this->dirtyObjects[$key]);
      $updateOids = array_keys($this->dirtyObjects);
    }
  }

  /**
   * Process the deleted objects queue
   */
  protected function processDeletes() {
    $deleteOids = array_keys($this->deletedObjects);
    while (sizeof($deleteOids) > 0) {
      $key = array_shift($deleteOids);
      if (self::$isDebugEnabled) {
        self::$logger->debug("Process delete on object: ".$key);
      }
      $object = $this->deletedObjects[$key];
      $object->getMapper()->delete($object);
      unset($this->deletedObjects[$key]);
      $deleteOids = array_keys($this->deletedObjects);
    }
  }

  /**
   * Listen to StateChangeEvents
   * @param $event StateChangeEvent instance
   */
  public function stateChanged(StateChangeEvent $event) {
    $object = $event->getObject();

    // don't listen to detached object changes
    $key = $object->getOID()->__toString();
    if (isset($this->detachedObjects[$key])) {
      return;
    }
    //if (isset($this->observedObjects[$object->getOID()->__toString()])) {
      $oldState = $event->getOldValue();
      $newState = $event->getNewValue();
      if (self::$isDebugEnabled) {
        self::$logger->debug("State changed: ".$object->getOID()." old:".$oldState." new:".$newState);
      }
      switch ($newState) {
        case PersistentObject::STATE_NEW:
          $this->registerNew($object);
          break;

        case PersistentObject::STATE_DIRTY:
          $this->registerDirty($object);
          break;

        case PersistentObject::STATE_DELETED:
          $this->registerDeleted($object);
          break;
      }
    //}
  }

  /**
   * @see Transaction::getObjects()
   */
  public function getObjects() {
    return $this->observedObjects;
  }
}
?>