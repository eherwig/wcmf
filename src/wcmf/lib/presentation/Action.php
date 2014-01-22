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
namespace wcmf\lib\presentation;

use wcmf\lib\core\ObjectFactory;

/**
 * Action helps parsing values from action key configurations.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class Action {

  private static $_actionDelimiter = '?';

  /**
   * Create an action from the given values
   * @param resource The resource
   * @param context The context
   * @param action The action
   * @return String
   */
  public static function createKey($resource, $context, $action) {
    return $resource.self::$_actionDelimiter.$context.self::$_actionDelimiter.$action;
  }

  /**
   * Get a configuration key that matches a given combination of resource, context, action best.
   * @param section The section to search in
   * @param resource The given resource
   * @param context The given context
   * @param action The given action
   * @return The best matching key or an empty string if nothing matches.
   */
  public static function getBestMatch($section, $resource, $context, $action) {
    $config = ObjectFactory::getConfigurationInstance();
    // check resource?context?action
    if (strlen($resource) > 0 && strlen($context) > 0 && strlen($action) > 0) {
      $key = self::createKey($resource, $context, $action);
      if ($config->hasValue($key, $section)) {
        return $key;
      }
    }

    // check resource??action
    if (strlen($resource) > 0 && strlen($action) > 0) {
      $key = self::createKey($resource, '', $action);
      if ($config->hasValue($key, $section)) {
        return $key;
      }
    }

    // check resource?context?
    if (strlen($resource) > 0 && strlen($context) > 0) {
      $key = self::createKey($resource, $context, '');
      if ($config->hasValue($key, $section)) {
        return $key;
      }
    }

    // check ?context?action
    if (strlen($context) > 0 && strlen($action) > 0) {
      $key = self::createKey('', $context, $action);
      if ($config->hasValue($key, $section)) {
        return $key;
      }
    }

    // check ??action
    if (strlen($action) > 0) {
      $key = self::createKey('', '', $action);
      if ($config->hasValue($key, $section)) {
        return $key;
      }
    }

    // check resource??
    if (strlen($resource) > 0) {
      $key = self::createKey($resource, '', '');
      if ($config->hasValue($key, $section)) {
        return $key;
      }
    }

    // check ?context?
    if (strlen($context) > 0) {
      $key = self::createKey('', $context, '');
      if ($config->hasValue($key, $section)) {
        return $key;
      }
    }

    // check ??
    $key = self::createKey('', '', '');
    if ($config->hasValue($key, $section)) {
      return $key;
    }
    return '';
  }
}
?>
