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

use app\src\model\EntityBaseBase;
// PROTECTED REGION ID(app/src/model/EntityBase.php/Import) ENABLED START
use wcmf\lib\core\ObjectFactory;
// PROTECTED REGION END

/**
 * @class EntityBase
 * EntityBase description: 
 *
 * @author 
 * @version 1.0
 */
class EntityBase extends EntityBaseBase {
// PROTECTED REGION ID(app/src/model/EntityBase.php/Body) ENABLED START

  /**
   * Set creator and created attribute on the node.
   */
  public function beforeInsert() {
    parent::beforeInsert();

    // set creation date on nodes with appropriate attribute
    $mapper = $this->getMapper();
    if ($mapper->hasAttribute('created')) {
      $this->setValue('created', date("Y-m-d H:i:s"));
    }
    // set creator on nodes with appropriate attribute
    if ($mapper->hasAttribute('creator')) {
      $permissionManager = ObjectFactory::getInstance('permissionManager');
      $authUser = $permissionManager->getAuthUser();
      $this->setValue('creator', $authUser->getLogin());
    }
    $this->beforeUpdate();
  }

  /**
   * Set last_editor and modified attribute on the node.
   */
  public function beforeUpdate() {
    parent::beforeUpdate();

    // set modified date on nodes with appropriate attribute
    $mapper = $this->getMapper();
    if ($mapper->hasAttribute('modified')) {
      $this->setValue('modified', date("Y-m-d H:i:s"));
    }
    // set last_editor on nodes with appropriate attribute
    if ($mapper->hasAttribute('last_editor')) {
      $permissionManager = ObjectFactory::getInstance('permissionManager');
      $authUser = $permissionManager->getAuthUser();
      $this->setValue('last_editor', $authUser->getLogin());
    }
  }
// PROTECTED REGION END
}
?>
