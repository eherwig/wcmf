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
 * This file was generated by ChronosGenerator  from model.uml.
 * Manual modifications should be placed inside the protected regions.
 */
namespace app\src\model;

use app\src\model\EntityBase;

use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;

/**
 * @class Image
 * Image description: 
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
      return Message::get("");
    }

    /**
     * @see PersistentObject::getValueDisplayName()
     */
    public function getValueDisplayName($name) {
      $displayName = $name;
      if ($name == 'id') { $displayName = Message::get("id"); }
      if ($name == 'fk_chapter_id') { $displayName = Message::get("fk_chapter_id"); }
      if ($name == 'fk_titlechapter_id') { $displayName = Message::get("fk_titlechapter_id"); }
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
      if ($name == 'fk_chapter_id') { $description = Message::get(""); }
      if ($name == 'fk_titlechapter_id') { $description = Message::get(""); }
      if ($name == 'filename') { $description = Message::get(""); }
      if ($name == 'created') { $description = Message::get(""); }
      if ($name == 'creator') { $description = Message::get(""); }
      if ($name == 'modified') { $description = Message::get(""); }
      if ($name == 'last_editor') { $description = Message::get(""); }
      return Message::get($description);
    }

    /**
     * Get the Chapter instances in the TitleChapter relation
     * @return Array of Chapter instances
     */
    public function getTitleChapterList() {
      return $this->getValue('TitleChapter');
    }

    /**
     * Set the Chapter instances in the TitleChapter relation
     * @param nodeList Array of Chapter instances
     */
    public function setTitleChapterList(array $nodeList) {
      $this->setValue('TitleChapter', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'TitleChapter');
      }
    }
    /**
     * Get the Chapter instances in the NormalChapter relation
     * @return Array of Chapter instances
     */
    public function getNormalChapterList() {
      return $this->getValue('NormalChapter');
    }

    /**
     * Set the Chapter instances in the NormalChapter relation
     * @param nodeList Array of Chapter instances
     */
    public function setNormalChapterList(array $nodeList) {
      $this->setValue('NormalChapter', null);
      foreach ($nodeList as $node) {
        $this->addNode($node, 'NormalChapter');
      }
    }
}
?>
