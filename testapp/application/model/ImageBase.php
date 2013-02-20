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
 * This file was generated by ChronosGenerator  from cwm-export.uml on Wed Feb 20 01:32:17 CET 2013. 
 * Manual modifications should be placed inside the protected regions.
 */
namespace testapp\application\model;

use testapp\application\model\EntityBase;

use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;

/**
 * @class Image
 * Image description: ?
 *
 * @author 
 * @version 1.0
 */
class ImageBase extends EntityBase {

    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    public function __construct($oid=null) {
      if ($oid == null) {
        $oid = new ObjectId('Image');
    }
      parent::__construct($oid);
    }

    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    public function getObjectDisplayName() {
      return Message::get("Image");
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
      if ($name == 'fk_page_id') { $displayName = Message::get("fk_page_id"); }
      if ($name == 'fk_titlepage_id') { $displayName = Message::get("fk_titlepage_id"); }
      if ($name == 'filename') { $displayName = Message::get("filename"); }
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
      if ($name == 'fk_page_id') { $description = Message::get(""); }
      if ($name == 'fk_titlepage_id') { $description = Message::get(""); }
      if ($name == 'filename') { $description = Message::get("?"); }
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
     * Get the value of the fk_page_id attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getFkPageId($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('fk_page_id'); }
      else { $value = $this->getValue('fk_page_id'); }
      return $value;
    }

    /**
     * Set the value of the fk_page_id attribute
     * @param fk_page_id The value to set
     */
    public function setFkPageId($fk_page_id) {
      return $this->setValue('fk_page_id', $fk_page_id);
    }
    /**
     * Get the value of the fk_titlepage_id attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getFkTitlepageId($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('fk_titlepage_id'); }
      else { $value = $this->getValue('fk_titlepage_id'); }
      return $value;
    }

    /**
     * Set the value of the fk_titlepage_id attribute
     * @param fk_titlepage_id The value to set
     */
    public function setFkTitlepageId($fk_titlepage_id) {
      return $this->setValue('fk_titlepage_id', $fk_titlepage_id);
    }
    /**
     * Get the value of the filename attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    public function getFilename($unconverted=false) {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('filename'); }
      else { $value = $this->getValue('filename'); }
      return $value;
    }

    /**
     * Set the value of the filename attribute
     * @param filename The value to set
     */
    public function setFilename($filename) {
      return $this->setValue('filename', $filename);
    }
    /**
     * Get the sortkey for the TitlePage relation
     * @return Number
     */
    public function getSortkeyTitlepage() {
      return $this->getValue('sortkey_titlepage');
    }

    /**
     * Set the sortkey for the TitlePage relation
     * @param sortkey The sortkey value
     */
    public function setSortkeyTitlepage($sortkey) {
      return $this->setValue('sortkey_titlepage', $sortkey);
    }
    /**
     * Get the sortkey for the NormalPage relation
     * @return Number
     */
    public function getSortkeyNormalpage() {
      return $this->getValue('sortkey_normalpage');
    }

    /**
     * Set the sortkey for the NormalPage relation
     * @param sortkey The sortkey value
     */
    public function setSortkeyNormalpage($sortkey) {
      return $this->setValue('sortkey_normalpage', $sortkey);
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
     * Get the Page instances in the TitlePage relation
     * @return Array of Page instances
     */
    public function getTitlePageList() {
      return $this->getParentsEx(null, 'TitlePage');
        }

    /**
     * Set the Page instances in the TitlePage relation
     * @param nodeList Array of Page instances
     */
    public function setTitlePageList(array $nodeList) {
      $this->setValue('TitlePage', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'TitlePage');
      }
      }
    /**
     * Get the Page instances in the NormalPage relation
     * @return Array of Page instances
     */
    public function getNormalPageList() {
      return $this->getParentsEx(null, 'NormalPage');
        }

    /**
     * Set the Page instances in the NormalPage relation
     * @param nodeList Array of Page instances
     */
    public function setNormalPageList(array $nodeList) {
      $this->setValue('NormalPage', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'NormalPage');
      }
      }
}
?>
