<?php
/**
 * This file was generated by wCMFGenerator 3.0.0017 from newroles.uml on Tue Aug 24 08:05:29 CEST 2010. 
 * Manual modifications should be placed inside the protected regions.
 */
require_once(WCMF_BASE."wcmf/lib/model/mapper/class.NodeUnifiedRDBMapper.php");
require_once(WCMF_BASE."application/include/model/class.EntityBase.php");

/**
 * @class EntityBaseRDBMapper
 * EntityBaseRDBMapper maps EntityBase Nodes to the database.
 * EntityBase description: 
 *
 * @author 
 * @version 1.0
 */
class EntityBaseRDBMapper extends NodeUnifiedRDBMapper
{
  /**
   * @see RDBMapper::getType()
   */
  public function getType()
  {
    return 'EntityBase';
  }
  /**
   * @see PersistenceMapper::getPkNames()
   */
  public function getPkNames()
  {
    return array('id');
  }
  /**
   * @see PersistenceMapper::getProperties()
   */
  public function getProperties()
  {
  	return array(
      'is_searchable' => true,
// PROTECTED REGION ID(application/include/model/class.EntityBaseRDBMapper.php/Properties) ENABLED START
// PROTECTED REGION END
	);
  }
  /**
   * @see PersistenceMapper::getDefaultOrder()
   */
  public function getDefaultOrder()
  {
    return array();
  }
  /**
   * @see RDBMapper::getRelationDescriptions()
   */
  protected function getRelationDescriptions()
  {
    return array(
    );
  }
  /**
   * @see RDBMapper::getAttributeDescriptions()
   */
  protected function getAttributeDescriptions()
  {
    return array(
     /**
      * Value description: 
      */
      'id' => new RDBAttributeDescription('id', '', array(DATATYPE_IGNORE), null, '', '', '', false, 'text', 'text', 'EntityBase', 'id'),
     /**
      * Value description: 
      */
      'created' => new RDBAttributeDescription('created', 'string', array(DATATYPE_ATTRIBUTE), null, '', '', '', false, 'text', 'text', 'EntityBase', 'created'),
     /**
      * Value description: 
      */
      'creator' => new RDBAttributeDescription('creator', 'string', array(DATATYPE_ATTRIBUTE), null, '', '', '', false, 'text', 'text', 'EntityBase', 'creator'),
     /**
      * Value description: 
      */
      'modified' => new RDBAttributeDescription('modified', 'string', array(DATATYPE_ATTRIBUTE), null, '', '', '', false, 'text', 'text', 'EntityBase', 'modified'),
     /**
      * Value description: 
      */
      'last_editor' => new RDBAttributeDescription('last_editor', 'string', array(DATATYPE_ATTRIBUTE), null, '', '', '', false, 'text', 'text', 'EntityBase', 'last_editor'),
    );
  }
  /**
   * @see RDBMapper::createObject()
   */
  protected function createObject(ObjectId $oid=null)
  {
    return new EntityBase($oid);
  }
  /**
   * @see NodeUnifiedRDBMapper::getTableName()
   */
  protected function getTableName()
  {
    return 'EntityBase';
  }
}
?>
