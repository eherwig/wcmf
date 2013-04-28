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
 * This file was generated by ChronosGenerator  from cwm-export.uml on Sun Apr 28 21:58:27 CEST 2013. 
 * Manual modifications should be placed inside the protected regions.
 */
namespace testapp\application\model\wcmf;

use wcmf\lib\model\Node;

use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;

/**
 * @class NMUserRole
 * NMUserRole description: ?
 *
 * @author 
 * @version 1.0
 */
class NMUserRoleBase extends Node {

    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    public function __construct($oid=null) {
      if ($oid == null) {
        $oid = new ObjectId('NMUserRole');
    }
      parent::__construct($oid);
    }

    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    public function getObjectDisplayName() {
      return Message::get("NMUserRole");
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
      if ($name == 'fk_user_id') { $displayName = Message::get("fk_user_id"); }
      if ($name == 'fk_role_id') { $displayName = Message::get("fk_role_id"); }
      return Message::get($displayName);
    }

    /**
     * @see PersistentObject::getValueDescription()
     */
    public function getValueDescription($name) {
      $description = $name;
      if ($name == 'fk_user_id') { $description = Message::get(""); }
      if ($name == 'fk_role_id') { $description = Message::get(""); }
      return Message::get($description);
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
     * Get the value of the fk_role_id attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getFkRoleId($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('fk_role_id'); }
      else { $value = $this->getValue('fk_role_id'); }
      return $value;
    }

    /**
     * Set the value of the fk_role_id attribute
     * @param fk_role_id The value to set
     */
    public function setFkRoleId($fk_role_id) {
      return $this->setValue('fk_role_id', $fk_role_id);
    }
     
    /**
     * Get the RoleRDB instances in the RoleRDB relation
     * @return Array of RoleRDB instances
     */
    public function getRoleRDBList() {
      return $this->getParentsEx(null, 'RoleRDB');
        }

    /**
     * Set the RoleRDB instances in the RoleRDB relation
     * @param nodeList Array of RoleRDB instances
     */
    public function setRoleRDBList(array $nodeList) {
      $this->setValue('RoleRDB', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'RoleRDB');
      }
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
