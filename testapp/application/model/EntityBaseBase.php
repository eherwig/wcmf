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
 * This file was generated by ChronosGenerator  from cwm-export.uml on Wed Mar 27 12:47:19 CET 2013. 
 * Manual modifications should be placed inside the protected regions.
 */
namespace testapp\application\model;

use wcmf\lib\model\Node;

use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;

/**
 * @class EntityBase
 * EntityBase description: ?
 *
 * @author 
 * @version 1.0
 */
class EntityBaseBase extends Node {

    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    public function __construct($oid=null) {
      if ($oid == null) {
        $oid = new ObjectId('EntityBase');
    }
      parent::__construct($oid);
    }

    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    public function getObjectDisplayName() {
      return Message::get("EntityBase");
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
      if ($name == 'created') { $displayName = Message::get("created"); }
      if ($name == 'creator') { $displayName = Message::get("creator"); }
      if ($name == 'modified') { $displayName = Message::get("modified"); }
      if ($name == 'last_editor') { $displayName = Message::get("last_editor"); }
      return Message::get($displayName);
    }

    /**
     * @see PersistentObject::getValueDescription()
     */
    public function getValueDescription($name) {
      $description = $name;
      if ($name == 'id') { $description = Message::get(""); }
      if ($name == 'created') { $description = Message::get(""); }
      if ($name == 'creator') { $description = Message::get("?"); }
      if ($name == 'modified') { $description = Message::get("?"); }
      if ($name == 'last_editor') { $description = Message::get("?"); }
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
     * Get the value of the created attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getCreated($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('created'); }
      else { $value = $this->getValue('created'); }
      return $value;
    }

    /**
     * Set the value of the created attribute
     * @param created The value to set
     */
    public function setCreated($created) {
      return $this->setValue('created', $created);
    }
    /**
     * Get the value of the creator attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getCreator($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('creator'); }
      else { $value = $this->getValue('creator'); }
      return $value;
    }

    /**
     * Set the value of the creator attribute
     * @param creator The value to set
     */
    public function setCreator($creator) {
      return $this->setValue('creator', $creator);
    }
    /**
     * Get the value of the modified attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getModified($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('modified'); }
      else { $value = $this->getValue('modified'); }
      return $value;
    }

    /**
     * Set the value of the modified attribute
     * @param modified The value to set
     */
    public function setModified($modified) {
      return $this->setValue('modified', $modified);
    }
    /**
     * Get the value of the last_editor attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getLastEditor($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('last_editor'); }
      else { $value = $this->getValue('last_editor'); }
      return $value;
    }

    /**
     * Set the value of the last_editor attribute
     * @param last_editor The value to set
     */
    public function setLastEditor($last_editor) {
      return $this->setValue('last_editor', $last_editor);
    }
     
}
?>
