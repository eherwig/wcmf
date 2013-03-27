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
 * This file was generated by ChronosGenerator  from cwm-export.uml on Wed Mar 27 23:06:12 CET 2013. 
 * Manual modifications should be placed inside the protected regions.
 */
namespace testapp\application\model;

use testapp\application\model\EntityBase;

use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;

/**
 * @class Book
 * Book description: A book is published by a publisher and consists of chapters.
 *
 * @author 
 * @version 1.0
 */
class BookBase extends EntityBase {

    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    public function __construct($oid=null) {
      if ($oid == null) {
        $oid = new ObjectId('Book');
    }
      parent::__construct($oid);
    }

    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    public function getObjectDisplayName() {
      return Message::get("Book");
    }

    /**
     * @see PersistentObject::getObjectDescription()
     */
    public function getObjectDescription() {
      return Message::get("A book is published by a publisher and consists of chapters.");
    }

    /**
     * @see PersistentObject::getValueDisplayName()
     */
    public function getValueDisplayName($name) {
      $displayName = $name;
      if ($name == 'id') { $displayName = Message::get("id"); }
      if ($name == 'fk_publisher_id') { $displayName = Message::get("fk_publisher_id"); }
      if ($name == 'title') { $displayName = Message::get("title"); }
      if ($name == 'description') { $displayName = Message::get("description"); }
      if ($name == 'year') { $displayName = Message::get("year"); }
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
      if ($name == 'fk_publisher_id') { $description = Message::get(""); }
      if ($name == 'title') { $description = Message::get("?"); }
      if ($name == 'description') { $description = Message::get("?"); }
      if ($name == 'year') { $description = Message::get("?"); }
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
     * Get the value of the fk_publisher_id attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getFkPublisherId($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('fk_publisher_id'); }
      else { $value = $this->getValue('fk_publisher_id'); }
      return $value;
    }

    /**
     * Set the value of the fk_publisher_id attribute
     * @param fk_publisher_id The value to set
     */
    public function setFkPublisherId($fk_publisher_id) {
      return $this->setValue('fk_publisher_id', $fk_publisher_id);
    }
    /**
     * Get the value of the title attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getTitle($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('title'); }
      else { $value = $this->getValue('title'); }
      return $value;
    }

    /**
     * Set the value of the title attribute
     * @param title The value to set
     */
    public function setTitle($title) {
      return $this->setValue('title', $title);
    }
    /**
     * Get the value of the description attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getDescription($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('description'); }
      else { $value = $this->getValue('description'); }
      return $value;
    }

    /**
     * Set the value of the description attribute
     * @param description The value to set
     */
    public function setDescription($description) {
      return $this->setValue('description', $description);
    }
    /**
     * Get the value of the year attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getYear($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('year'); }
      else { $value = $this->getValue('year'); }
      return $value;
    }

    /**
     * Set the value of the year attribute
     * @param year The value to set
     */
    public function setYear($year) {
      return $this->setValue('year', $year);
    }
     
    /**
     * Get the Publisher instances in the Publisher relation
     * @return Array of Publisher instances
     */
    public function getPublisherList() {
      return $this->getParentsEx(null, 'Publisher');
        }

    /**
     * Set the Publisher instances in the Publisher relation
     * @param nodeList Array of Publisher instances
     */
    public function setPublisherList(array $nodeList) {
      $this->setValue('Publisher', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'Publisher');
      }
      }
    /**
     * Get the Chapter instances in the Chapter relation
     * @return Array of Chapter instances
     */
    public function getChapterList() {
      return $this->getChildrenEx(null, 'Chapter', null, null, null, false);
    }

    /**
     * Set the Chapter instances in the Chapter relation
     * @param nodeList Array of Chapter instances
     */
    public function setChapterList(array $nodeList) {
      $this->setValue('Chapter', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'Chapter');
        }
      }
}
?>
