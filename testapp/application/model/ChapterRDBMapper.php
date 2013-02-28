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
namespace testapp\application\model;

use testapp\application\model\Chapter;

use wcmf\lib\model\mapper\NodeUnifiedRDBMapper;
use wcmf\lib\model\mapper\RDBAttributeDescription;
use wcmf\lib\model\mapper\RDBManyToManyRelationDescription;
use wcmf\lib\model\mapper\RDBManyToOneRelationDescription;
use wcmf\lib\model\mapper\RDBOneToManyRelationDescription;
use wcmf\lib\persistence\ReferenceDescription;
use wcmf\lib\persistence\ObjectId;

/**
 * @class ChapterRDBMapper
 * ChapterRDBMapper maps Chapter Nodes to the database.
 * Chapter description: A book is divided into chapters. A chapter may contain subchapters.
 *
 * @author 
 * @version 1.0
 */
class ChapterRDBMapper extends NodeUnifiedRDBMapper {

  /**
   * @see RDBMapper::getType()
   */
  public function getType() {
    return 'Chapter';
  }

  /**
   * @see PersistenceMapper::getPkNames()
   */
  public function getPkNames() {
    return array('id');
  }

  /**
   * @see PersistenceMapper::getProperties()
   */
  public function getProperties() {
    return array(
      'is_searchable' => true,
      'display_value' => 'name',
      'parent_order' => '',
      'child_order' => '',
// PROTECTED REGION ID(testapp/application/model/ChapterRDBMapper.php/Properties) ENABLED START
// PROTECTED REGION END
    );
  }

  /**
   * @see RDBMapper::getOwnDefaultOrder()
   */
  public function getOwnDefaultOrder($roleName=null) {
    if ($roleName == 'Author') {
      return array('sortFieldName' => 'sortkey_author', 'sortDirection' => 'ASC', 'isSortkey' => true);
  }
    if ($roleName == 'Book') {
      return array('sortFieldName' => 'sortkey_book', 'sortDirection' => 'ASC', 'isSortkey' => true);
  }
    if ($roleName == 'ParentChapter') {
      return array('sortFieldName' => 'sortkey_parentchapter', 'sortDirection' => 'ASC', 'isSortkey' => true);
  }
    return array('sortFieldName' => 'sortkey', 'sortDirection' => 'ASC', 'isSortkey' => true);
  }

  /**
   * @see RDBMapper::getRelationDescriptions()
   */
  protected function getRelationDescriptions() {
    return array(
      'SubChapter' => new RDBOneToManyRelationDescription('Chapter', 'ParentChapter', 'Chapter', 'SubChapter', '1', '1', '0', 'unbounded', 'none', 'composite', 'true', 'true', 'child', 'id', 'fk_chapter_id'),
      'TitleImage' => new RDBOneToManyRelationDescription('Chapter', 'TitleChapter', 'Image', 'TitleImage', '1', '1', '0', '1', 'none', 'shared', 'true', 'true', 'child', 'id', 'fk_titlechapter_id'),
      'NormalImage' => new RDBOneToManyRelationDescription('Chapter', 'NormalChapter', 'Image', 'NormalImage', '1', '1', '0', 'unbounded', 'none', 'shared', 'true', 'true', 'child', 'id', 'fk_chapter_id'),
      'Author' => new RDBManyToOneRelationDescription('Chapter', 'Chapter', 'Author', 'Author', '0', 'unbounded', '1', '1', 'composite', 'none', 'true', 'true', 'parent', 'id', 'fk_author_id'),
      'Book' => new RDBManyToOneRelationDescription('Chapter', 'Chapter', 'Book', 'Book', '0', 'unbounded', '1', '1', 'shared', 'none', 'true', 'true', 'parent', 'id', 'fk_book_id'),
      'ParentChapter' => new RDBManyToOneRelationDescription('Chapter', 'SubChapter', 'Chapter', 'ParentChapter', '0', 'unbounded', '1', '1', 'composite', 'none', 'true', 'true', 'parent', 'id', 'fk_chapter_id'),
    );
  }

  /**
   * @see RDBMapper::getAttributeDescriptions()
   */
  protected function getAttributeDescriptions() {
    return array(
     /**
      * Value description: 
      */
      'id' => new RDBAttributeDescription('id', '', array('DATATYPE_IGNORE'), null, '', '', '', false, 'text', 'text', 'Chapter', 'id'),
     /**
      * Value description: 
      */
      'fk_chapter_id' => new RDBAttributeDescription('fk_chapter_id', '', array('DATATYPE_IGNORE'), null, '', '', '', false, 'text', 'text', 'Chapter', 'fk_chapter_id'),
     /**
      * Value description: 
      */
      'fk_book_id' => new RDBAttributeDescription('fk_book_id', '', array('DATATYPE_IGNORE'), null, '', '', '', false, 'text', 'text', 'Chapter', 'fk_book_id'),
     /**
      * Value description: 
      */
      'fk_author_id' => new RDBAttributeDescription('fk_author_id', '', array('DATATYPE_IGNORE'), null, '', '', '', false, 'text', 'text', 'Chapter', 'fk_author_id'),
     /**
      * Value description: ?
      */
      'name' => new RDBAttributeDescription('name', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', true, 'text', 'text', 'Chapter', 'name'),
     /**
      * Value description: 
      */
      'created' => new RDBAttributeDescription('created', 'Date', array('DATATYPE_ATTRIBUTE'), null, '', '', '', false, 'text', 'text', 'Chapter', 'created'),
     /**
      * Value description: ?
      */
      'creator' => new RDBAttributeDescription('creator', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', false, 'text', 'text', 'Chapter', 'creator'),
     /**
      * Value description: ?
      */
      'modified' => new RDBAttributeDescription('modified', 'Date', array('DATATYPE_ATTRIBUTE'), null, '', '', '', false, 'text', 'text', 'Chapter', 'modified'),
     /**
      * Value description: ?
      */
      'last_editor' => new RDBAttributeDescription('last_editor', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', false, 'text', 'text', 'Chapter', 'last_editor'),
      /**
       * Value description: Sort key for ordering in relation to Author
       */
      'sortkey_author' => new RDBAttributeDescription('sortkey_author', 'integer', array('DATATYPE_IGNORE'), null, '[0-9]*', '', '', true, 'text[class="tiny"]', 'text', 'Chapter', 'sortkey_author'),
      /**
       * Value description: Sort key for ordering in relation to Book
       */
      'sortkey_book' => new RDBAttributeDescription('sortkey_book', 'integer', array('DATATYPE_IGNORE'), null, '[0-9]*', '', '', true, 'text[class="tiny"]', 'text', 'Chapter', 'sortkey_book'),
      /**
       * Value description: Sort key for ordering in relation to ParentChapter
       */
      'sortkey_parentchapter' => new RDBAttributeDescription('sortkey_parentchapter', 'integer', array('DATATYPE_IGNORE'), null, '[0-9]*', '', '', true, 'text[class="tiny"]', 'text', 'Chapter', 'sortkey_parentchapter'),
      /**
       * Value description: Sort key for ordering
       */
      'sortkey' => new RDBAttributeDescription('sortkey', 'integer', array('DATATYPE_IGNORE'), null, '[0-9]*', '', '', true, 'text[class="tiny"]', 'text', 'Chapter', 'sortkey'),
     /* 
      * Value description: A book is divided into chapters. A chapter may contain subchapters. 
      */
      'author_name' => new ReferenceDescription('author_name', 'Author', 'name'),
    );
  }

  /**
   * @see RDBMapper::createObject()
   */
  protected function createObject(ObjectId $oid=null) {
    return new Chapter($oid);
  }

  /**
   * @see NodeUnifiedRDBMapper::getTableName()
   */
  protected function getTableName() {
    return 'Chapter';
  }
}
?>
