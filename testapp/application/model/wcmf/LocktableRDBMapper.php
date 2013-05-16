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
 * This file was generated by ChronosGenerator  from cwm-export.uml on Thu May 16 18:48:42 CEST 2013.
 * Manual modifications should be placed inside the protected regions.
 */
namespace testapp\application\model\wcmf;

use testapp\application\model\wcmf\Locktable;

use wcmf\lib\model\mapper\NodeUnifiedRDBMapper;
use wcmf\lib\model\mapper\RDBAttributeDescription;
use wcmf\lib\model\mapper\RDBManyToManyRelationDescription;
use wcmf\lib\model\mapper\RDBManyToOneRelationDescription;
use wcmf\lib\model\mapper\RDBOneToManyRelationDescription;
use wcmf\lib\persistence\ReferenceDescription;
use wcmf\lib\persistence\ObjectId;

/**
 * @class LocktableRDBMapper
 * LocktableRDBMapper maps Locktable Nodes to the database.
 * Locktable description: ?
 *
 * @author 
 * @version 1.0
 */
class LocktableRDBMapper extends NodeUnifiedRDBMapper {

  /**
   * @see RDBMapper::getType()
   */
  public function getType() {
    return 'testapp.application.model.wcmf.Locktable';
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
      'is_searchable' => false,
      'display_value' => '',
      'parent_order' => '',
      'child_order' => '',
// PROTECTED REGION ID(testapp/application/model/wcmf/LocktableRDBMapper.php/Properties) ENABLED START
// PROTECTED REGION END
    );
  }

  /**
   * @see RDBMapper::getOwnDefaultOrder()
   */
  public function getOwnDefaultOrder($roleName=null) {
    return null;
  }

  /**
   * @see RDBMapper::getRelationDescriptions()
   */
  protected function getRelationDescriptions() {
    return array(
      'UserRDB' => new RDBManyToOneRelationDescription(
        'testapp.application.model.wcmf.Locktable', 'Locktable', 'testapp.application.model.wcmf.UserRDB', 'UserRDB',
        '0', 'unbounded', '1', '1', 'composite', 'none', 'true', 'true', 'parent', 'id', 'fk_user_id'
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
      'id' => new RDBAttributeDescription('id', '', array('DATATYPE_IGNORE'), null, '', '', '', false, 'text', 'text', 'locktable', 'id'),
     /**
      * Value description: 
      */
      'fk_user_id' => new RDBAttributeDescription('fk_user_id', '', array('DATATYPE_IGNORE'), null, '', '', '', false, 'text', 'text', 'locktable', 'fk_user_id'),
     /**
      * Value description: ?
      */
      'objectid' => new RDBAttributeDescription('objectid', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', false, 'text', 'text', 'locktable', 'objectid'),
     /**
      * Value description: ?
      */
      'sessionid' => new RDBAttributeDescription('sessionid', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', false, 'text', 'text', 'locktable', 'sessionid'),
     /**
      * Value description: ?
      */
      'since' => new RDBAttributeDescription('since', 'Date', array('DATATYPE_ATTRIBUTE'), null, '', '', '', false, 'text', 'text', 'locktable', 'since'),
    );
  }

  /**
   * @see RDBMapper::createObject()
   */
  protected function createObject(ObjectId $oid=null) {
    return new Locktable($oid);
  }

  /**
   * @see NodeUnifiedRDBMapper::getTableName()
   */
  protected function getTableName() {
    return 'locktable';
  }
}
?>
