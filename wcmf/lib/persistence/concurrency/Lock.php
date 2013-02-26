<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2009 wemove digital solutions GmbH
 *
 * Licensed under the terms of any of the following licenses
 * at your choice:
 *
 * - GNU Lesser General Public License (LGPL)
 *   http://www.gnu.org/licenses/lgpl.html
 * - Eclipse Public License (EPL)
 *   http://www.eclipse.org/org/documents/epl-v10.php
 *
 * See the license.txt file distributed with this work for
 * additional information.
 *
 * $Id$
 */
namespace wcmf\lib\persistence\concurrency;

/**
 * Lock represents a lock on an object.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class Lock {

  const TYPE_OPTIMISTIC = 0;
  const TYPE_PESSIMISTIC = 1; // pessimistic write lock

  private $_oid = null;
  private $_useroid = null;
  private $_login = "";
  private $_sessid = "";
  private $_created = "";
  private $_currentState = null;

  /**
   * Creates a lock on a given object.
   * @param type One of the Lock::Type constants
   * @param oid ObjectId of the object to lock
   * @param useroid ObjectId of the user who holds the lock
   * @param login Login name of the user who holds the lock
   * @param sessid Id of the session of the user
   * @param created Creation date of the lock. If omitted the current date will be taken.
   */
  public function __construct($type, $oid, $useroid, $login, $sessid, $created='') {
    $this->_type = $type;
    $this->_oid = $oid;
    $this->_useroid = $useroid;
    $this->_login = $login;
    $this->_sessid = $sessid;
    if ($created == '') {
      $this->_created = date("Y-m-d H:i:s");
    }
    else {
      $this->_created = $created;
    }
  }

  /**
   * Get the type of the lock.
   * @return One of the Lock::Type constants.
   */
  public function getType() {
    return $this->_type;
  }

  /**
   * Get the oid of the locked object.
   * @return ObjectId of the locked object.
   */
  public function getOID() {
    return $this->_oid;
  }

  /**
   * Get the oid of the user who holds the lock.
   * @return ObjectId of the user.
   */
  public function getUserOID()
  {
    return $this->_useroid;
  }

  /**
   * Get the login of the user who holds the lock.
   * @return The login of the user.
   */
  public function getLogin()
  {
    return $this->_login;
  }

  /**
   * Get the session id of the user who holds the lock.
   * @return The session id of the user.
   */
  public function getSessionID()
  {
    return $this->_sessid;
  }

  /**
   * Get the creation date/time of the lock.
   * @return The creation date/time of the lock.
   */
  public function getCreated()
  {
    return $this->_created;
  }

  /**
   * Get the original state of the object in case of an
   * optimistic lock.
   * @return PersistentObject instance
   */
  public function setCurrentState($_currentState) {
    $this->_currentState = serialize($_currentState);
  }

  /**
   * Get the original state of the object in case of an
   * optimistic lock.
   * @return PersistentObject instance
   */
  public function getCurrentState() {
    return unserialize($this->_currentState);
  }
}
?>