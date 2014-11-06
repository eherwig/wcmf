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
namespace wcmf\lib\security\principal\impl;

use wcmf\lib\security\principal\User;

/**
 * Anonymous user
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class AnonymousUser implements User {

  const USER_GROUP_NAME = 'anonymous';

  private $_config = null;

  /**
   * @see User::getOID()
   */
  public function getOID() {
    return null;
  }

  /**
   * @see User::setLogin()
   */
  public function setLogin($login) {}

  /**
   * @see User::getLogin()
   */
  public function getLogin() {
    return self::USER_GROUP_NAME;
  }

  /**
   * @see User::setPassword()
   */
  public function setPassword($password) {}

  /**
   * @see User::getPassword()
   */
  public function getPassword() {
    return null;
  }

  /**
   * @see User::verifyPassword
   */
  public function verifyPassword($password, $passwordHash) {
    return false;
  }

  /**
   * @see User::setConfig()
   */
  public function setConfig($config) {
    $this->_config = $config;
  }

  /**
   * @see User::getConfig()
   */
  public function getConfig() {
    return $this->_config;
  }

  /**
   * @see User::hasRole()
   */
  public function hasRole($rolename) {
    return $rolename == self::USER_GROUP_NAME;
  }

  /**
   * @see User::getRoles()
   */
  public function getRoles() {
    return array(self::USER_GROUP_NAME);
  }
}
?>
