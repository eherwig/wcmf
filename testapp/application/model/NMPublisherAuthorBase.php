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
 * This file was generated by ChronosGenerator  from cwm-export.uml on Wed Mar 20 21:58:20 CET 2013. 
 * Manual modifications should be placed inside the protected regions.
 */
namespace testapp\application\model;

use wcmf\lib\model\Node;

use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;

/**
 * @class NMPublisherAuthor
 * NMPublisherAuthor description: ?
 *
 * @author 
 * @version 1.0
 */
class NMPublisherAuthorBase extends Node {

    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    public function __construct($oid=null) {
      if ($oid == null) {
        $oid = new ObjectId('NMPublisherAuthor');
    }
      parent::__construct($oid);
    }

    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    public function getObjectDisplayName() {
      return Message::get("NMPublisherAuthor");
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
      if ($name == 'fk_author_id') { $displayName = Message::get("fk_author_id"); }
      if ($name == 'fk_publisher_id') { $displayName = Message::get("fk_publisher_id"); }
      return Message::get($displayName);
    }

    /**
     * @see PersistentObject::getValueDescription()
     */
    public function getValueDescription($name) {
      $description = $name;
      if ($name == 'id') { $description = Message::get(""); }
      if ($name == 'fk_author_id') { $description = Message::get(""); }
      if ($name == 'fk_publisher_id') { $description = Message::get(""); }
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
     * Get the value of the fk_author_id attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getFkAuthorId($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('fk_author_id'); }
      else { $value = $this->getValue('fk_author_id'); }
      return $value;
    }

    /**
     * Set the value of the fk_author_id attribute
     * @param fk_author_id The value to set
     */
    public function setFkAuthorId($fk_author_id) {
      return $this->setValue('fk_author_id', $fk_author_id);
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
     * Get the sortkey for the Publisher relation
     * @return Number
     */
    public function getSortkeyPublisher() {
      return $this->getValue('sortkey_publisher');
    }

    /**
     * Set the sortkey for the Publisher relation
     * @param sortkey The sortkey value
     */
    public function setSortkeyPublisher($sortkey) {
      return $this->setValue('sortkey_publisher', $sortkey);
    }
    /**
     * Get the sortkey for the Author relation
     * @return Number
     */
    public function getSortkeyAuthor() {
      return $this->getValue('sortkey_author');
    }

    /**
     * Set the sortkey for the Author relation
     * @param sortkey The sortkey value
     */
    public function setSortkeyAuthor($sortkey) {
      return $this->setValue('sortkey_author', $sortkey);
    }

    /**
     * Get the default sortkey
     * @return Number
     */
    public function getSortkey() {
      return $this->getValue('sortkey');
    }

    /**
     * Set the default sortkey
     * @param sortkey The sortkey value
     */
    public function setSortkey($sortkey) {
      return $this->setValue('sortkey', $sortkey);
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
     * Get the Author instances in the Author relation
     * @return Array of Author instances
     */
    public function getAuthorList() {
      return $this->getParentsEx(null, 'Author');
        }

    /**
     * Set the Author instances in the Author relation
     * @param nodeList Array of Author instances
     */
    public function setAuthorList(array $nodeList) {
      $this->setValue('Author', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'Author');
      }
      }
}
?>
