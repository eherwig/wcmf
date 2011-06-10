<?php
/**
 * This file was generated by wCMFGenerator 3.0.0017 from newroles.uml on Fri Jun 10 17:44:16 CEST 2011.
 * Manual modifications should be placed inside the protected regions.
 */
require_once(WCMF_BASE."wcmf/lib/model/class.Node.php");

/**
 * @class Translation
 * Translation description: Instances of this class are used to localize entity attributes. Each instance defines a translation of one attribute of one entity into one language.
 *
 * @author 
 * @version 1.0
 */
class TranslationBase extends Node
{
    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    function __construct($oid=null)
    {
      if ($oid == null) {
        $oid = new ObjectId('Translation');
      }
      parent::__construct($oid);
    }
    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    function getObjectDisplayName()
    {
      return Message::get("Translation");
    }
    /**
     * @see PersistentObject::getObjectDescription()
     */
    function getObjectDescription()
    {
      return Message::get("Instances of this class are used to localize entity attributes. Each instance defines a translation of one attribute of one entity into one language.");
    }
    /**
     * @see PersistentObject::getValueDisplayName()
     */
    function getValueDisplayName($name, $type=null)
    {
      $displayName = $name;
      if ($name == 'id') { $displayName = Message::get("id"); }
      if ($name == 'objectid') { $displayName = Message::get("objectid"); }
      if ($name == 'attribute') { $displayName = Message::get("attribute"); }
      if ($name == 'translation') { $displayName = Message::get("translation"); }
      if ($name == 'language') { $displayName = Message::get("language"); }
      return Message::get($displayName);
    }
    /**
     * @see PersistentObject::getValueDescription()
     */
    function getValueDescription($name, $type=null)
    {
      $description = $name;
      if ($name == 'id') { $description = Message::get(""); }
      if ($name == 'objectid') { $description = Message::get("The object id of the object to which the translation belongs"); }
      if ($name == 'attribute') { $description = Message::get("The attribute of the object that is translated"); }
      if ($name == 'translation') { $description = Message::get("The translation"); }
      if ($name == 'language') { $description = Message::get("The language of the translation"); }
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
     * Get the value of the objectid attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    function getObjectid($unconverted=false)
    {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('objectid'); }
      else { $value = $this->getValue('objectid'); }
      return $value;
    }
    /**
     * Set the value of the objectid attribute
     * @param objectid The value to set
     */
    function setObjectid($objectid)
    {
      return $this->setValue('objectid', $objectid);
    }
    /**
     * Get the value of the attribute attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    function getAttribute($unconverted=false)
    {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('attribute'); }
      else { $value = $this->getValue('attribute'); }
      return $value;
    }
    /**
     * Set the value of the attribute attribute
     * @param attribute The value to set
     */
    function setAttribute($attribute)
    {
      return $this->setValue('attribute', $attribute);
    }
    /**
     * Get the value of the translation attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    function getTranslation($unconverted=false)
    {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('translation'); }
      else { $value = $this->getValue('translation'); }
      return $value;
    }
    /**
     * Set the value of the translation attribute
     * @param translation The value to set
     */
    function setTranslation($translation)
    {
      return $this->setValue('translation', $translation);
    }
    /**
     * Get the value of the language attribute
     * @param unconverted Boolean wether to get the converted or stored value (default: false)
     * @return Mixed
     */
    function getLanguage($unconverted=false)
    {
      $value = null;
      if ($unconverted) { $value = $this->getUnconvertedValue('language'); }
      else { $value = $this->getValue('language'); }
      return $value;
    }
    /**
     * Set the value of the language attribute
     * @param language The value to set
     */
    function setLanguage($language)
    {
      return $this->setValue('language', $language);
    }
}
?>
