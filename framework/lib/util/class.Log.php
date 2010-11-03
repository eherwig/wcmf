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
require_once(BASE."wcmf/3rdparty/log4php/Logger.php");
Logger::configure(dirname($_SERVER['SCRIPT_FILENAME']).'/log4php.properties');

/**
 * @class Log
 * @ingroup Util
 * @brief Log is used to log application events. The implementation
 * is a wrapper over log4php. All methods may be called in a static way.
 * @note The only reason, why this class inherits from Logger is to get the
 * correct location information.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class Log
{
  /**
   * Print a debug message for a category
   * @param message The message
   * @param category The category
   */
  public static function debug($message, $category)
  {
    $logger = Log::getLogger($category);
    $logger->debug($message);
  }
  /**
   * Print a info message for a category
   * @param message The message
   * @param category The category
   */
  public static function info($message, $category)
  {
    $logger = Log::getLogger($category);
    $logger->info($message);
  }
  /**
   * Print a warn message for a category
   * @param message The message
   * @param category The category
   */
  public static function warn($message, $category)
  {
    $logger = Log::getLogger($category);
    $logger->warn($message);
  }
  /**
   * Print a error message for a category
   * @param message The message
   * @param category The category
   */
  public static function error($message, $category)
  {
    $logger = Log::getLogger($category);
    $logger->error($message);
  }
  /**
   * Print a fatal message for a category
   * @param message The message
   * @param category The category
   */
  public static function fatal($message, $category)
  {
    $logger = Log::getLogger($category);
    $logger->fatal($message);
  }
  /**
   * Check if debug level is enabled for a category
   * @param category The category
   * @return True/False
   */
  public static function isDebugEnabled($category)
  {
    $logger = Log::getLogger($category);
    return $logger->isDebugEnabled();
  }
  /**
   * Check if info level is enabled for a category
   * @param category The category
   * @return True/False
   */
  public static function isInfoEnabled($category)
  {
    $logger = Log::getLogger($category);
    return $logger->isInfoEnabled();
  }
  /**
   * Check if warn level is enabled for a category
   * @param category The category
   * @return True/False
   */
  public static function isWarnEnabled($category)
  {
    $logger = Log::getLogger($category);
    return $logger->isWarnEnabled();
  }
  /**
   * Check if error level is enabled for a category
   * @param category The category
   * @return True/False
   */
  public static function isErrorEnabled($category)
  {
    $logger = Log::getLogger($category);
    return $logger->isErrorEnabled();
  }
  /**
   * Check if fatal level is enabled for a category
   * @param category The category
   * @return True/False
   */
  public static function isFatalEnabled($category)
  {
    $logger = Log::getLogger($category);
    return $logger->isFatalEnabled();
  }

  /**
   * Get the log4php Logger instance for a specified category
   * @param category The category
   * @return A Logger  The category
   */
  public static function getLogger($category)
  {
    $logger = Logger::getLogger($category);
    return $logger;
  }
}
?>