<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2014 wemove digital solutions GmbH
 *
 * Licensed under the terms of the MIT License.
 *
 * See the LICENSE file distributed with this work for
 * additional information.
 */
namespace wcmf\lib\core;

use wcmf\lib\config\ConfigurationException;

/**
 * ObjectFactory wraps a Factory instance to provide static access.
 * It delegates all work to the configured Factory instance.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class ObjectFactory {

  private static $_factory = null;

  /**
   * Configure the factory.
   * @param $factory Factory instance that actually does the instantiation.
   */
  public static function configure(Factory $factory) {
    self::$_factory = $factory;
  }

  /**
   * @see Factory::getInstance()
   */
  public static function getInstance($name, $dynamicConfiguration=array()) {
    self::checkConfig();
    return self::$_factory->getInstance($name, $dynamicConfiguration);
  }

  /**
   * @see Factory::getClassInstance()
   */
  public static function getClassInstance($class, $dynamicConfiguration=array()) {
    self::checkConfig();
    return self::$_factory->getClassInstance($class, $dynamicConfiguration);
  }

  /**
   * @see Factory::registerInstance()
   */
  public static function registerInstance($name, $instance) {
    self::checkConfig();
    self::$_factory->registerInstance($name, $instance);
  }

  /**
   * @see Factory::addInterfaces()
   */
  public function addInterfaces($interfaces) {
    self::checkConfig();
    self::$_factory->addInterfaces($interfaces);
  }

  /**
   * @see Factory::clear()
   */
  public static function clear() {
    self::checkConfig();
    self::$_factory->clear();
  }

  /**
   * Check if the configuration is valid.
   */
  private static function checkConfig() {
    if (self::$_factory == null) {
      throw new ConfigurationException('No Factory instance provided. Do this by calling the configure() method.');
    }
  }
}
?>