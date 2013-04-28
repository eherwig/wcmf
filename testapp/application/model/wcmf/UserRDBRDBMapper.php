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

use testapp\application\model\wcmf\UserRDB;

use wcmf\lib\model\mapper\NodeUnifiedRDBMapper;
use wcmf\lib\model\mapper\RDBAttributeDescription;
use wcmf\lib\model\mapper\RDBManyToManyRelationDescription;
use wcmf\lib\model\mapper\RDBManyToOneRelationDescription;
use wcmf\lib\model\mapper\RDBOneToManyRelationDescription;
use wcmf\lib\persistence\ReferenceDescription;
use wcmf\lib\persistence\ObjectId;

/**
 * @class UserRDBRDBMapper
 * UserRDBRDBMapper maps UserRDB Nodes to the database.
 * UserRDB description: ?
 *
 * @author 
 * @version 1.0
 */
class UserRDBRDBMapper extends NodeUnifiedRDBMapper {

  /**
   * @see RDBMapper::getType()
   */
  public function getType() {
    return 'testapp.application.model.wcmf.UserRDB';
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
      'display_value' => 'login',
      'parent_order' => '',
      'child_order' => '',
// PROTECTED REGION ID(testapp/application/model/wcmf/UserRDBRDBMapper.php/Properties) ENABLED START
// PROTECTED REGION END
    );
  }

  /**
   * @see RDBMapper::getOwnDefaultOrder()
   */
  public function getOwnDefaultOrder($roleName=null) {
    return array('sortFieldName' => 'name', 'sortDirection' => 'ASC', 'isSortkey' => false);
  }

  /**
   * @see RDBMapper::getRelationDescriptions()
   */
  protected function getRelationDescriptions() {
    return array(
      'Locktable' => new RDBOneToManyRelationDescription(
        'testapp.application.model.wcmf.UserRDB', 'UserRDB', 'testapp.application.model.wcmf.Locktable', 'Locktable',
        '1', '1', '0', 'unbounded', 'none', 'composite', 'true', 'true', 'child', 'id', 'fk_user_id'
      ),
      'UserConfig' => new RDBOneToManyRelationDescription(
        'testapp.application.model.wcmf.UserRDB', 'UserRDB', 'testapp.application.model.wcmf.UserConfig', 'UserConfig',
        '1', '1', '0', 'unbounded', 'none', 'composite', 'true', 'true', 'child', 'id', 'fk_user_id'
      ),
      'RoleRDB' => new RDBManyToManyRelationDescription(
      /* this -> nm  */ new RDBOneToManyRelationDescription(
        'testapp.application.model.wcmf.UserRDB', 'UserRDB', 'testapp.application.model.wcmf.NMUserRole', 'NMUserRole',
        '1', '1', '0', 'unbounded', 'none', 'composite', 'true', 'true', 'child', 'id', 'fk_user_id'
      ),
      /* nm -> other */ new RDBManyToOneRelationDescription(
        'testapp.application.model.wcmf.NMUserRole', 'NMUserRole', 'testapp.application.model.wcmf.RoleRDB', 'RoleRDB',
        '0', 'unbounded', '1', '1', 'composite', 'none', 'true', 'true', 'parent', 'id', 'fk_role_id'
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
      'id' => new RDBAttributeDescription('id', '', array('DATATYPE_IGNORE'), null, '', '', '', false, 'text', 'text', 'user', 'id'),
     /**
      * Value description: ?
      */
      'login' => new RDBAttributeDescription('login', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', true, 'text', 'text', 'user', 'login'),
     /**
      * Value description: ?
      */
      'password' => new RDBAttributeDescription('password', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', true, 'password', 'text', 'user', 'password'),
     /**
      * Value description: ?
      */
      'name' => new RDBAttributeDescription('name', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', true, 'text', 'text', 'user', 'name'),
     /**
      * Value description: ?
      */
      'firstname' => new RDBAttributeDescription('firstname', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', true, 'text', 'text', 'user', 'firstname'),
     /**
      * Value description: ?
      */
      'config' => new RDBAttributeDescription('config', 'String', array('DATATYPE_ATTRIBUTE'), null, '', '', '', true, 'text', 'text', 'user', 'config'),
    );
  }

  /**
   * @see RDBMapper::createObject()
   */
  protected function createObject(ObjectId $oid=null) {
    return new UserRDB($oid);
  }

  /**
   * @see NodeUnifiedRDBMapper::getTableName()
   */
  protected function getTableName() {
    return 'user';
  }
}
?>
