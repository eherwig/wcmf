<?php
/*
 * Copyright (c) 2013 The Olympos Development Team.
 * 
 * http://sourceforge.net/projects/olympos/
 * 
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html. If redistributing this code,
 * this entire header must remain intact.
 */

/**
 * This file was generated by ChronosGenerator  from cwm-export.uml on Thu Feb 28 18:34:48 CET 2013. 
 * Manual modifications should be placed inside the protected regions.
 */
namespace testapp\application\model\wcmf;

use wcmf\lib\model\Node;

use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;

/**
 * @class UserConfig
 * UserConfig description: ?
 *
 * @author 
 * @version 1.0
 */
class UserConfigBase extends Node {

    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    public function __construct($oid=null) {
      if ($oid == null) {
        $oid = new ObjectId('UserConfig');
    }
      parent::__construct($oid);
    }

    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    public function getObjectDisplayName() {
      return Message::get("UserConfig");
    }

    /**
     * @see PersistentObject::getObjectDescription()
     */
    public function getObjectDescription() {
      return Message::get("?");
    }

    /**
     * @see PersistentObject::getValueDisplayName()
     */
    public function getValueDisplayName($name) {
      $displayName = $name;
      if ($name == 'id') { $displayName = Message::get("id"); }
      if ($name == 'fk_user_id') { $displayName = Message::get("fk_user_id"); }
      if ($name == 'key') { $displayName = Message::get("key"); }
      if ($name == 'val') { $displayName = Message::get("val"); }
      return Message::get($displayName);
    }

    /**
     * @see PersistentObject::getValueDescription()
     */
    public function getValueDescription($name) {
      $description = $name;
      if ($name == 'id') { $description = Message::get(""); }
      if ($name == 'fk_user_id') { $description = Message::get(""); }
      if ($name == 'key') { $description = Message::get("?"); }
      if ($name == 'val') { $description = Message::get("?"); }
      return Message::get($description);
    }

    /**
     * Get the value of the id attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getId($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('id'); }
      else { $value = $this->getValue('id'); }
      return $value;
    }

    /**
     * Set the value of the id attribute
     * @param id The value to set
     */
    public function setId($id) {
      return $this->setValue('id', $id);
    }
    /**
     * Get the value of the fk_user_id attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getFkUserId($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('fk_user_id'); }
      else { $value = $this->getValue('fk_user_id'); }
      return $value;
    }

    /**
     * Set the value of the fk_user_id attribute
     * @param fk_user_id The value to set
     */
    public function setFkUserId($fk_user_id) {
      return $this->setValue('fk_user_id', $fk_user_id);
    }
    /**
     * Get the value of the key attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getKey($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('key'); }
      else { $value = $this->getValue('key'); }
      return $value;
    }

    /**
     * Set the value of the key attribute
     * @param key The value to set
     */
    public function setKey($key) {
      return $this->setValue('key', $key);
    }
    /**
     * Get the value of the val attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getVal($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('val'); }
      else { $value = $this->getValue('val'); }
      return $value;
    }

    /**
     * Set the value of the val attribute
     * @param val The value to set
     */
    public function setVal($val) {
      return $this->setValue('val', $val);
    }
     
    /**
     * Get the UserRDB instances in the UserRDB relation
     * @return Array of UserRDB instances
     */
    public function getUserRDBList() {
      return $this->getParentsEx(null, 'UserRDB');
        }

    /**
     * Set the UserRDB instances in the UserRDB relation
     * @param nodeList Array of UserRDB instances
     */
    public function setUserRDBList(array $nodeList) {
      $this->setValue('UserRDB', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'UserRDB');
      }
      }
}
?>
