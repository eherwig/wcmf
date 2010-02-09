<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2009 wemove digital solutions GmbH
 *
 * Licensed under the terms of any of the following licenses 
 * at your choice:
 *
 * - GNU Lesser General Public License (LGPL)
 *   http://www.gnu.org/licenses/lgpl.html
 * - Eclipse Public License (EPL)
 *   http://www.eclipse.org/org/documents/epl-v10.php
 *
 * See the license.txt file distributed with this work for 
 * additional information.
 *
 * $Id$
 */
require_once(BASE."wcmf/lib/persistence/class.LockManager.php");
require_once(BASE."wcmf/lib/util/class.InifileParser.php");
require_once(BASE."wcmf/lib/persistence/class.PersistenceFacade.php");

/**
 * @class LockManagerRDB
 * @ingroup Persistence
 * @brief LockManagerRDB implements a LockManager for relational databases.
 * Locks are represented by the entity type 'Locktable' with attributes
 * 'sessionid', 'objectid', 'since' (all DATATYPE_ATTRIBUTE). Locktable
 * instances are children of the user entity.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class LockManagerRDB extends LockManager
{
  /**
   * Load the user with the given oid
   */
  function &getUserByOID($useroid)
  {
    // get the user with the given oid
    $persistenceFacade = &PersistenceFacade::getInstance();
    return $persistenceFacade->load($useroid, BUILDDEPTH_SINGLE);
  }
  /**
   * @see LockManager::aquireLockImpl();
   */
  function aquireLockImpl($useroid, $sessid, $oid, $lockDate)
  {
    $persistenceFacade = &PersistenceFacade::getInstance();
    $lock = &$persistenceFacade->create('Locktable', BUILDDEPTH_REQUIRED);
    $lock->setValue('sessionid', $sessid, DATATYPE_ATTRIBUTE);
    $lock->setValue('objectid', $oid, DATATYPE_ATTRIBUTE);
    $lock->setValue('since', $lockDate, DATATYPE_ATTRIBUTE);
    $user = &$this->getUserByOID($useroid);
    $user->addChild($lock);
    $lock->save();
  }
  /**
   * @see LockManager::releaseLockImpl();
   */
  function releaseLockImpl($useroid, $sessid, $oid)
  {
    $persistenceFacade = &PersistenceFacade::getInstance();
    $query = &$persistenceFacade->createObjectQuery('Locktable');
    $tpl = &$query->getObjectTemplate('Locktable');
    if ($sessid != null) {
      $tpl->setValue('sessionid', "= '".$sessid."'", DATATYPE_ATTRIBUTE);
    }
    if ($oid != null) {
      $tpl->setValue('objectid', "= '".$oid."'", DATATYPE_ATTRIBUTE);
    }
    if ($useroid != null)
    {
      $user = &$this->getUserByOID($useroid);
      if ($user != null)
      {
        $userTpl = &$query->getObjectTemplate(UserManager::getUserClassName());
        $userTpl->setOID($useroid);
        $userTpl->addChild($tpl);
      }
    }
    $locks = $query->execute(BUILDDEPTH_SINGLE);
    foreach($locks as $lock)
      $lock->delete();
  }
  /**
   * @see LockManager::releaseAllLocksImpl();
   */
  function releaseAllLocksImpl($useroid, $sessid)
  {
    $this->releaseLockImpl($useroid, $sessid, null);
  }
  /**
   * @see LockManager::getLockImpl();
   */
  function getLockImpl($oid)
  {
    // deactivate locking
    $parser = &InifileParser::getInstance();
    $oldLocking = $parser->getValue('locking', 'cms');
    $parser->setValue('locking', false, 'cms');

    // load locks
    $persistenceFacade = &PersistenceFacade::getInstance();
    $query = &$persistenceFacade->createObjectQuery(UserManager::getUserClassName());
    $tpl1 = &$query->getObjectTemplate(UserManager::getUserClassName());
    $tpl2 = &$query->getObjectTemplate('Locktable');
    $tpl2->setValue('objectid', "= '".$oid."'", DATATYPE_ATTRIBUTE);
    $tpl1->addChild($tpl2);
    $users = $query->execute(1);

    // reactivate locking
    $parser->setValue('locking', $oldLocking, 'cms');

    if (sizeof($users) == 0) {
      return null;
    }
    else
    {
      $user = &$users[0];
      $locks = $user->getChildrenEx(null, 'Locktable', array('objectid' => $oid), null);
      if (sizeof($locks) > 0) {
        $lock = &$locks[0];
      }
      else {
        $lock = &$tpl2;
      }
      return new Lock($oid, $user->getOID(), $user->getLogin(),
                  $lock->getValue('sessionid', DATATYPE_ATTRIBUTE), 
                  $lock->getValue('since', DATATYPE_ATTRIBUTE));
    }
  }
}
?>
