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
namespace wcmf\lib\persistence\output\impl;

use wcmf\lib\core\LogManager;
use wcmf\lib\core\Session;
use wcmf\lib\persistence\output\OutputStrategy;
use wcmf\lib\persistence\PersistentObject;

/**
 * AuditingOutputStrategy outputs object changes to the logger category
 * AuditingOutputStrategy, loglevel info
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class AuditingOutputStrategy implements OutputStrategy {

  private static $_logger = null;
  private $_session = null;

  /**
   * Constructor
   * @param $session
   */
  public function __construct(Session $session) {
    $this->_session = $session;
    if (self::$_logger == null) {
      self::$_logger = LogManager::getLogger(__CLASS__);
    }
  }

  /**
   * @see OutputStrategy::writeHeader
   */
  public function writeHeader() {
    // do nothing
  }

  /**
   * @see OutputStrategy::writeFooter
   */
  public function writeFooter() {
    // do nothing
  }

  /**
   * @see OutputStrategy::writeObject
   */
  public function writeObject(PersistentObject $obj) {
    if (self::$_logger->isInfoEnabled()) {
      $user = $this->_session->getAuthUser();

      switch ($state = $obj->getState()) {
        // log insert action
        case PersistentObject::STATE_NEW:
          self::$_logger->info('INSERT '.$obj->getOID().': '.str_replace("\n", " ", $obj->__toString()).' USER: '.$user->getLogin());
          break;
        // log update action
        case PersistentObject::STATE_DIRTY:
          // get original values
          $orignialValues = $obj->getOriginalValues();
          // collect differences
          $values = array();
          $valueNames = $obj->getValueNames(true);
          foreach($valueNames as $name) {
            $values[$name]['name'] = $name;
            $values[$name]['new'] = $obj->getValue($name);
            $values[$name]['old'] = isset($orignialValues[$name]) ? $orignialValues[$name] : null;
          }
          // make diff string
          $diff = '';
          foreach ($values as $value) {
            if ($value['old'] != $value['new']) {
              $diff .= $value['name'].':'.serialize($value['old']).'->'.serialize($value['new']).' ';
            }
          }
          self::$_logger->info('SAVE '.$obj->getOID().': '.$diff.' USER: '.$user->getLogin());
          break;
        // log delete action
        case PersistentObject::STATE_DELETED:
          // get old object from storage
          self::$_logger->info('DELETE '.$obj->getOID().': '.str_replace("\n", " ", $obj->__toString()).' USER: '.$user->getLogin());
          break;
      }
    }
  }
}
?>
