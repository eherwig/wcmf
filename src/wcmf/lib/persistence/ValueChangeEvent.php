<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2015 wemove digital solutions GmbH
 *
 * Licensed under the terms of the MIT License.
 *
 * See the LICENSE file distributed with this work for
 * additional information.
 */
namespace wcmf\lib\persistence;

use wcmf\lib\core\Event;
use wcmf\lib\persistence\PersistentObject;

/**
 * ValueChangeEvent signals a change of a value of
 * a PersistentObject instance.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class ValueChangeEvent extends Event {

  const NAME = __CLASS__;

  private $object = null;
  private $name = null;
  private $oldValue = null;
  private $newValue = null;

  /**
   * Constructor.
   * @param $object A reference to the PersistentObject object that whose value has changed.
   * @param $name The name of the item that has changed.
   * @param $oldValue The old value of the item that has changed.
   * @param $newValue The new value of the item that has changed.
   */
  public function __construct(PersistentObject $object, $name, $oldValue, $newValue) {
    $this->object = $object;
    $this->name = $name;
    $this->oldValue = $oldValue;
    $this->newValue = $newValue;
  }

  /**
   * Get the object whose value has changed.
   * @return PersistentObject instance
   */
  public function getObject() {
    return $this->object;
  }

  /**
   * Get the name of the value that has changed.
   * @return String
   */
  public function getValueName() {
    return $this->name;
  }

  /**
   * Get the old value.
   * @return Mixed
   */
  public function getOldValue() {
    return $this->oldValue;
  }

  /**
   * Get the new value.
   * @return Mixed
   */
  public function getNewValue() {
    return $this->newValue;
  }
}
?>
