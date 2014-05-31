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
namespace wcmf\test\app\src\model\wcmf;

use wcmf\lib\model\Node;

use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;

/**
 * @class Language
 * Language description: A language for which a translation of the model can be created. The code is arbitrary but it is recommended to use the ISO language codes (en, de, it, ...).
 *
 * @author 
 * @version 1.0
 */
class LanguageBase extends Node {

    /**
     * Constructor
     * @param oid ObjectId instance (optional)
     */
    public function __construct($oid=null) {
      if ($oid == null) {
        $oid = new ObjectId('Language');
    }
      parent::__construct($oid);
    }

    /**
     * @see PersistentObject::getObjectDisplayName()
     */
    public function getObjectDisplayName() {
      return Message::get("Language");
    }

    /**
     * @see PersistentObject::getObjectDescription()
     */
    public function getObjectDescription() {
      return Message::get("A language for which a translation of the model can be created. The code is arbitrary but it is recommended to use the ISO language codes (en, de, it, ...).");
    }

    /**
     * @see PersistentObject::getValueDisplayName()
     */
    public function getValueDisplayName($name) {
      $displayName = $name;
      if (false) {}
      elseif ($name == 'id') { $displayName = Message::get("id"); }
      elseif ($name == 'name') { $displayName = Message::get("name"); }
      elseif ($name == 'code') { $displayName = Message::get("code"); }
      return $displayName;
    }

    /**
     * @see PersistentObject::getValueDescription()
     */
    public function getValueDescription($name) {
      $description = $name;
      if (false) {}
      elseif ($name == 'id') { $description = Message::get(""); }
      elseif ($name == 'name') { $description = Message::get(""); }
      elseif ($name == 'code') { $description = Message::get(""); }
      return $description;
    }

}
?>