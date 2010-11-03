<?php
/**
 * This file was generated by wCMFGenerator 3.0.0017 from newroles.uml on Tue Aug 24 08:05:29 CEST 2010. 
 * Manual modifications should be placed inside the protected regions.
 */
require_once(BASE."wcmf/lib/security/class.Role.php");

/**
 * @class RoleRDB
 * RoleRDB description: 
 *
 * @author 
 * @version 1.0
 */
class RoleRDBBase extends Role
{
    function __construct($oid=null, $type=null)
    {
      if ($type == null)
        parent::__construct($oid, 'RoleRDB');
      else
        parent::__construct($oid, $type);
    }
    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    function getObjectDisplayName()
    {
      return Message::get("RoleRDB");
    }
    /**
     * @see PersistentObject::getObjectDescription()
     */
    function getObjectDescription()
    {
      return Message::get("");
    }
    /**
     * @see PersistentObject::getValueDisplayName()
     */
    function getValueDisplayName($name, $type=null)
    {
      $displayName = $name;
      if ($name == 'id') $displayName = Message::get("id");
      if ($name == 'name') $displayName = Message::get("name");
      return Message::get($displayName);
    }
    /**
     * @see PersistentObject::getValueDescription()
     */
    function getValueDescription($name, $type=null)
    {
      $description = $name;
      if ($name == 'id') $description = Message::get("");
      if ($name == 'name') $description = Message::get("");
      return Message::get($description);
    }
    /**
     * See if the node is an association object, that implements a many to many relation
     */
    function isManyToManyObject()
    {
      return false;
    }
    /**
     * Getter/Setter for properties
     */
    function getId($unconverted=false)
    {
      if ($unconverted) {
        return $this->getUnconvertedValue('id', DATATYPE_IGNORE);
      }
      else {
        return $this->getValue('id', DATATYPE_IGNORE);
      }
    }
    function setId($id)
    {
      return $this->setValue('id', $id, DATATYPE_IGNORE);
    }
    function getName($unconverted=false)
    {
      if ($unconverted) {
        return $this->getUnconvertedValue('name', DATATYPE_ATTRIBUTE);
      }
      else {
        return $this->getValue('name', DATATYPE_ATTRIBUTE);
      }
    }
    function setName($name)
    {
      return $this->setValue('name', $name, DATATYPE_ATTRIBUTE);
    }
    /**
     * Getter/Setter for related objects
     */
    function __call($name, $arguments)
    {
      // child: NMUserRole
      if ($name == 'getNMUserRoleList')
      {
        Log::warn("use of deprecated method getNMUserRoleList. use getNMUserRoleChildren() instead.\n".Application::getStackTrace(), __CLASS__);
        return $this->getNMUserRoleChildren();
      }
      if ($name == 'getNMUserRoleChildren') {
        return $this->getChildrenEx(null, 'NMUserRole', array('fk_role_id' => $this->getDBID()), null, false);
      }
      if ($name == 'getUserRDBList')
      {
        Log::warn("use of deprecated method getUserRDBList. use getUserRDBChildren() instead.\n".Application::getStackTrace(), __CLASS__);
        return $this->getUserRDBChildren();
      }
      if ($name == 'getUserRDBChildren')
      {
        // the foreign key column does not exist
        return $this->getChildrenEx(null, 'UserRDB', null, null, false);
      }
    }
}
?>