<?php
/**
 * This file was generated by wCMFGenerator 3.0.0017 from newroles.uml on Fri Jun 10 17:44:16 CEST 2011.
 * Manual modifications should be placed inside the protected regions.
 */
require_once(WCMF_BASE."wcmf/lib/model/class.Node.php");

/**
 * @class Language
 * Language description: A llanguage for which a translation of the model can be created. The code is arbitrary but it is recommended to use the ISO language codes (en, de, it, ...).
 *
 * @author 
 * @version 1.0
 */
class LanguageBase extends Node
{
    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    function __construct($oid=null)
    {
      if ($oid == null) {
        $oid = new ObjectId('Language');
      }
      parent::__construct($oid);
    }
    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    function getObjectDisplayName()
    {
      return Message::get("Language");
    }
    /**
     * @see PersistentObject::getObjectDescription()
     */
    function getObjectDescription()
    {
      return Message::get("A llanguage for which a translation of the model can be created. The code is arbitrary but it is recommended to use the ISO language codes (en, de, it, ...).");
    }
    /**
     * @see PersistentObject::getValueDisplayName()
     */
    function getValueDisplayName($name, $type=null)
    {
      $displayName = $name;
      if ($name == 'id') { $displayName = Message::get("id"); }
      if ($name == 'code') { $displayName = Message::get("code"); }
      if ($name == 'name') { $displayName = Message::get("name"); }
      return Message::get($displayName);
    }
    /**
     * @see PersistentObject::getValueDescription()
     */
    function getValueDescription($name, $type=null)
    {
      $description = $name;
      if ($name == 'id') { $description = Message::get(""); }
      if ($name == 'code') { $description = Message::get(""); }
      if ($name == 'name') { $description = Message::get(""); }
      return Message::get($description);
    }
    /**
     * Get the value of the id attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    function getId($unconverted=false)
    {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('id'); }
      else { $value = $this->getValue('id'); }
      return $value;
    }
    /**
     * Set the value of the id attribute
     * @param id The value to set
     */
    function setId($id)
    {
      return $this->setValue('id', $id);
    }
    /**
     * Get the value of the code attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    function getCode($unconverted=false)
    {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('code'); }
      else { $value = $this->getValue('code'); }
      return $value;
    }
    /**
     * Set the value of the code attribute
     * @param code The value to set
     */
    function setCode($code)
    {
      return $this->setValue('code', $code);
    }
    /**
     * Get the value of the name attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    function getName($unconverted=false)
    {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('name'); }
      else { $value = $this->getValue('name'); }
      return $value;
    }
    /**
     * Set the value of the name attribute
     * @param name The value to set
     */
    function setName($name)
    {
      return $this->setValue('name', $name);
    }
}
?>
