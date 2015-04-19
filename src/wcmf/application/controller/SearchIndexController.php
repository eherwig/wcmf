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
namespace wcmf\application\controller;

use wcmf\application\controller\BatchController;

use wcmf\lib\core\ObjectFactory;
use wcmf\lib\i18n\Message;
use wcmf\lib\persistence\ObjectId;
use wcmf\lib\search\IndexedSearch;

/**
 * SearchIndexController creates a Lucene index from the complete datastore.
 *
 * The controller supports the following actions:
 *
 * <div class="controller-action">
 * <div> __Action__ _default_ </div>
 * <div>
 * Create the index.
 * </div>
 * </div>
 *
 * For additional actions and parameters see [BatchController actions](@ref BatchController).
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class SearchIndexController extends BatchController {

  /**
   * @see BatchController::getWorkPackage()
   */
  protected function getWorkPackage($number) {
    if ($number == 0) {
      $search = ObjectFactory::getInstance('search');
      if ($search instanceof IndexedSearch) {
        // get all types to index
        $types = array();
        $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');
        foreach ($persistenceFacade->getKnownTypes() as $type) {
          $tpl = $persistenceFacade->create($type);
          if ($search->isSearchable($tpl)) {
            $types[] = $type;
          }
        }
        $search->resetIndex();
        return array('name' => Message::get('Collect objects'), 'size' => 1, 'oids' => $types, 'callback' => 'collect');
      }
      else {
        // no index to be updated
        return null;
      }
    }
    else {
      return null;
    }
  }

  /**
   * Collect all oids of the given types
   * @param $types The types to process
   * @note This is a callback method called on a matching work package @see BatchController::addWorkPackage()
   */
  protected function collect($types) {
    $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');
    foreach ($types as $type) {
      $oids = $persistenceFacade->getOIDs($type);
      if (sizeof($oids) == 0) {
        $oids = array(1);
      }
      $this->addWorkPackage(Message::get('Indexing %0%', array($type)), 10, $oids, 'index');
    }
  }

  /**
   * Create the lucene index from the given objects
   * @param $oids The oids to process
   * @note This is a callback method called on a matching work package @see BatchController::addWorkPackage()
   */
  protected function index($oids) {
    $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');
    $search = ObjectFactory::getInstance('search');
    foreach($oids as $oid) {
      if (ObjectId::isValid($oid)) {
        $obj = $persistenceFacade->load($oid);
        $search->addToIndex($obj);
      }
    }
    $search->commitIndex(false);

    if ($this->getStepNumber() == $this->getNumberOfSteps()) {
      $this->addWorkPackage(Message::get('Optimizing index'), 1, array(0), 'optimize');
    }
  }

  /**
   * Optimize the search index
   * @param $oids The oids to process
   * @note This is a callback method called on a matching work package @see BatchController::addWorkPackage()
   */
  protected function optimize($oids) {
    $search = ObjectFactory::getInstance('search');
    $search->optimizeIndex();
  }
  // PROTECTED REGION END
}
?>