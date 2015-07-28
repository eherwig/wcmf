<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2014 wemove digital solutions GmbH
 *
 * Licensed under the terms of the MIT License.
 *
 * See the LICENSE file distributed with this work for
 * additional information.
 */
namespace wcmf\lib\persistence\concurrency\impl;

use wcmf\lib\core\IllegalArgumentException;
use wcmf\lib\core\LogManager;
use wcmf\lib\core\ObjectFactory;
use wcmf\lib\model\NodeValueIterator;
use wcmf\lib\persistence\BuildDepth;
use wcmf\lib\persistence\concurrency\ConcurrencyManager;
use wcmf\lib\persistence\concurrency\Lock;
use wcmf\lib\persistence\concurrency\LockHandler;
use wcmf\lib\persistence\concurrency\OptimisticLockException;
use wcmf\lib\persistence\concurrency\PessimisticLockException;
use wcmf\lib\persistence\ObjectId;
use wcmf\lib\persistence\PersistentObject;
use wcmf\lib\persistence\ReferenceDescription;

/**
 * Default ConcurrencyManager implementation.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class DefaultConcurrencyManager implements ConcurrencyManager {

  private $_lockHandler = null;

  private static $_logger = null;

  /**
   * Set the LockHandler used for locking.
   * @param $lockHandler
   */
  public function setLockHandler(LockHandler $lockHandler) {
    $this->_lockHandler = $lockHandler;
    if (self::$_logger == null) {
      self::$_logger = LogManager::getLogger(__CLASS__);
    }
  }

  /**
   * @see ConcurrencyManager::aquireLock()
   */
  public function aquireLock(ObjectId $oid, $type, PersistentObject $currentState=null) {
    if (!ObjectId::isValid($oid) || ($type != Lock::TYPE_OPTIMISTIC &&
            $type != Lock::TYPE_PESSIMISTIC)) {
      throw new IllegalArgumentException("Invalid object id or locktype given");
    }

    // load the current state if not provided
    if ($type == Lock::TYPE_OPTIMISTIC && $currentState == null) {
      $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');
      $currentState = $persistenceFacade->load($oid, BuildDepth::SINGLE);
    }

    $this->_lockHandler->aquireLock($oid, $type, $currentState);
  }

  /**
   * @see ConcurrencyManager::releaseLock()
   */
  public function releaseLock(ObjectId $oid, $type=null) {
    if (!ObjectId::isValid($oid)) {
      throw new IllegalArgumentException("Invalid object id given");
    }
    $this->_lockHandler->releaseLock($oid, $type);
  }

  /**
   * @see ConcurrencyManager::releaseLocks()
   */
  public function releaseLocks(ObjectId $oid) {
    if (!ObjectId::isValid($oid)) {
      throw new IllegalArgumentException("Invalid object id given");
    }
    $this->_lockHandler->releaseLocks($oid);
  }

  /**
   * @see ConcurrencyManager::releaseAllLocks()
   */
  public function releaseAllLocks() {
    $this->_lockHandler->releaseAllLocks();
  }

  /**
   * @see ConcurrencyManager::getLock()
   */
  public function getLock(ObjectId $oid) {
    return $this->_lockHandler->getLock($oid);
  }

  /**
   * @see ConcurrencyManager::checkPersist()
   */
  public function checkPersist(PersistentObject $object) {
    $oid = $object->getOID();
    $lock = $this->_lockHandler->getLock($oid);
    if ($lock != null) {
      $type = $lock->getType();

      // if there is a pessimistic lock on the object and it's not
      // owned by the current user, throw a PessimisticLockException
      if ($type == Lock::TYPE_PESSIMISTIC) {
        $session = ObjectFactory::getInstance('session');
        $currentUser = $session->getAuthUser();
        if ($lock->getLogin() != $currentUser->getLogin()) {
            throw new PessimisticLockException($lock);
        }
      }

      // if there is an optimistic lock on the object and the object was updated
      // in the meantime, throw a OptimisticLockException
      if ($type == Lock::TYPE_OPTIMISTIC) {
        $originalState = $lock->getCurrentState();
        // temporarily detach the object from the transaction in order to get
        // the latest version from the store
        $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');
        $transaction = $persistenceFacade->getTransaction();
        $transaction->detach($object->getOID());
        $currentState = $persistenceFacade->load($oid, BuildDepth::SINGLE);
        // check for deletion
        if ($currentState == null) {
          throw new OptimisticLockException(null);
        }
        // check for modifications
        $mapper = $persistenceFacade->getMapper($object->getType());
        $it = new NodeValueIterator($originalState, false);
        foreach($it as $valueName => $originalValue) {
          $attribute = $mapper->getAttribute($valueName);
          // ignore references
          if (!($attribute instanceof ReferenceDescription)) {
            $currentValue = $currentState->getValue($valueName);
            if (strval($currentValue) != strval($originalValue)) {
              if (self::$_logger->isDebugEnabled()) {
                self::$_logger->debug("Current state is different to original state: ".$object->getOID()."-".$valueName.": current[".
                        serialize($currentValue)."], original[".serialize($originalValue)."]");
              }
              throw new OptimisticLockException($currentState);
            }
          }
        }
        // if there was no concurrent update, attach the object again
        if ($object->getState() == PersistentObject::STATE_DIRTY) {
          $transaction->registerDirty($object);
        }
        elseif ($object->getState() == PersistentObject::STATE_DELETED) {
          $transaction->registerDeleted($object);
        }
      }
    }
    // everything is ok
  }

  /**
   * @see ConcurrencyManager::updateLock()
   */
  public function updateLock(ObjectId $oid, PersistentObject $object) {
    return $this->_lockHandler->updateLock($oid, $object);
  }
}
?>
