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

use app\src\model\Publisher;

use wcmf\lib\model\mapper\NodeUnifiedRDBMapper;
use wcmf\lib\model\mapper\RDBAttributeDescription;
use wcmf\lib\model\mapper\RDBManyToManyRelationDescription;
use wcmf\lib\model\mapper\RDBManyToOneRelationDescription;
use wcmf\lib\model\mapper\RDBOneToManyRelationDescription;
use wcmf\lib\persistence\ReferenceDescription;
use wcmf\lib\persistence\ObjectId;

/**
 * @class PublisherRDBMapper
 * PublisherRDBMapper maps Publisher Nodes to the database.
 * Publisher description: A publisher publishes books.
 *
 * @author 
 * @version 1.0
 */
class PublisherRDBMapper extends NodeUnifiedRDBMapper {

  /**
   * @see RDBMapper::getType()
   */
  public function getType() {
    return 'app.src.model.Publisher';
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
// PROTECTED REGION ID(app/src/model/PublisherRDBMapper.php/Properties) ENABLED START
// PROTECTED REGION END
    );
  }

  /**
   * @see RDBMapper::getOwnDefaultOrder()
   */
  public function getOwnDefaultOrder($roleName=null) {
    $orderDefs = array();
    $orderDefs[] = array('sortFieldName' => 'name', 'sortDirection' => 'ASC', 'isSortkey' => false);
    return $orderDefs;
  }

  /**
   * @see RDBMapper::getRelationDescriptions()
   */
  protected function getRelationDescriptions() {
    return array(
      'Book' => new RDBOneToManyRelationDescription(
        'app.src.model.Publisher', 'Publisher', 'app.src.model.Book', 'Book',
        '1', '1', '1', 'unbounded', 'none', 'composite', 'true', 'true', 'child', 'id', 'fk_publisher_id'
      ),
      'Author' => new RDBManyToManyRelationDescription(
      /* this -> nm  */ new RDBOneToManyRelationDescription(
        'app.src.model.Publisher', 'Publisher', 'app.src.model.NMPublisherAuthor', 'NMPublisherAuthor',
        '1', '1', '0', 'unbounded', 'none', 'composite', 'true', 'true', 'child', 'id', 'fk_publisher_id'
      ),
      /* nm -> other */ new RDBManyToOneRelationDescription(
        'app.src.model.NMPublisherAuthor', 'NMPublisherAuthor', 'app.src.model.Author', 'Author',
        '0', 'unbounded', '1', '1', 'composite', 'none', 'true', 'true', 'parent', 'id', 'fk_author_id'
      )
      ),
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
      'id' => new RDBAttributeDescription('id', '', array('DATATYPE_IGNORE'), null, '', '', false, 'text', 'text', 'Publisher', 'id'),
     /**
      * Value description: 
      */
      'name' => new RDBAttributeDescription('name', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', true, 'text', 'text', 'Publisher', 'name'),
     /**
      * Value description: 
      */
      'created' => new RDBAttributeDescription('created', 'Date', array('DATATYPE_ATTRIBUTE'), null, '', '', false, 'text', 'text', 'Publisher', 'created'),
     /**
      * Value description: 
      */
      'creator' => new RDBAttributeDescription('creator', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', false, 'text', 'text', 'Publisher', 'creator'),
     /**
      * Value description: 
      */
      'modified' => new RDBAttributeDescription('modified', 'Date', array('DATATYPE_ATTRIBUTE'), null, '', '', false, 'text', 'text', 'Publisher', 'modified'),
     /**
      * Value description: 
      */
      'last_editor' => new RDBAttributeDescription('last_editor', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', false, 'text', 'text', 'Publisher', 'last_editor'),
    );
  }

  /**
   * @see RDBMapper::createObject()
   */
  protected function createObject(ObjectId $oid=null) {
    return new Publisher($oid);
  }

  /**
   * @see NodeUnifiedRDBMapper::getTableName()
   */
  protected function getTableName() {
    return 'Publisher';
  }
}
?>
