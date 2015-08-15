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
namespace wcmf\application\controller;

use wcmf\application\controller\BatchController;
use wcmf\lib\config\Configuration;
use wcmf\lib\core\Session;
use wcmf\lib\i18n\Localization;
use wcmf\lib\i18n\Message;
use wcmf\lib\io\Cache;
use wcmf\lib\io\FileUtil;
use wcmf\lib\model\Node;
use wcmf\lib\model\PersistentIterator;
use wcmf\lib\persistence\ObjectId;
use wcmf\lib\persistence\PersistenceFacade;
use wcmf\lib\presentation\ActionMapper;
use wcmf\lib\presentation\Controller;
use wcmf\lib\presentation\Request;
use wcmf\lib\presentation\Response;
use wcmf\lib\security\PermissionManager;

/**
 * XMLExportController exports the content tree into an XML file.
 *
 * The controller supports the following actions:
 *
 * <div class="controller-action">
 * <div> __Action__ _default_ </div>
 * <div>
 * Initiate the export.
 * | Parameter              | Description
 * |------------------------|-------------------------
 * | _in_ `docFile`         | The name of the file to write to (path relative to script main location) (default: 'export.xml')
 * | _in_ `docType`         | The document type (will be written into XML header) (default: '')
 * | _in_ `dtd`             | The dtd (will be written into XML header) (default: '')
 * | _in_ `docRootElement`  | The root element of the document (use this to enclose different root types if necessary) (default: 'Root')
 * | _in_ `docLinebreak`    | The linebreak character(s) to use (default: '\n')
 * | _in_ `docIndent`       | The indent character(s) to use (default: '  ')
 * | _in_ `nodesPerCall`    | The number of nodes to process in one call (default: 10)
 * </div>
 * </div>
 *
 * For additional actions and parameters see [BatchController actions](@ref BatchController).
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class XMLExportController extends BatchController {
  const CACHE_SECTION = 'xmlexport';
  const CACHE_KEY_ROOT_OIDS = 'rootOids';
  const CACHE_KEY_EXPORTED_OIDS = 'exportedOids';

  // session name constants
  private $ITERATOR_ID = 'XMLExportController.iteratorid';

  // documentInfo passes the current document info/status from one call to the next:
  // An assoziative array with keys 'docFile', 'docType', 'dtd', 'docLinebreak', 'docIndent', 'nodesPerCall',
  // 'lastIndent' and 'tagsToClose' where the latter is an array of assoziative arrays with keys 'indent', 'name'
  private $DOCUMENT_INFO = 'XMLExportController.documentinfo';

  // default values, maybe overriden by corresponding request values (see above)
  private $_DOCFILE = "export.xml";
  private $_DOCTYPE = "";
  private $_DTD = "";
  private $_DOCROOTELEMENT = "Root";
  private $_DOCLINEBREAK = "\n";
  private $_DOCINDENT = "  ";
  private $_NODES_PER_CALL = 10;

  private $_cache = null;
  private $_fileUtil = null;

  /**
   * Constructor
   * @param $session
   * @param $persistenceFacade
   * @param $permissionManager
   * @param $actionMapper
   * @param $localization
   * @param $message
   * @param $configuration
   * @param $cache
   */
  public function __construct(Session $session,
          PersistenceFacade $persistenceFacade,
          PermissionManager $permissionManager,
          ActionMapper $actionMapper,
          Localization $localization,
          Message $message,
          Configuration $configuration,
          Cache $cache) {
    parent::__construct($session, $persistenceFacade, $permissionManager,
            $actionMapper, $localization, $message, $configuration);
    $this->_cache = $cache;
  }

  /**
   * Get the FileUtil instance
   * @return FileUtil
   */
  protected function getFileUtil() {
    if ($this->_fileUtil == null) {
      $this->_fileUtil = new FileUtil();
    }
    return $this->_fileUtil;
  }

  /**
   * @see Controller::initialize()
   */
  public function initialize(Request $request, Response $response) {
    parent::initialize($request, $response);

    // construct initial document info
    if ($request->getAction() != 'continue') {
      $session = $this->getSession();

      $docFile = $request->hasValue('docFile') ? $request->getValue('docFile') : $this->getDownloadFile();
      $docType = $request->hasValue('docType') ? $request->getValue('docType') : $this->_DOCTYPE;
      $dtd = $request->hasValue('dtd') ? $request->getValue('dtd') : $this->_DTD;
      $docRootElement = $request->hasValue('docRootElement') ? $request->getValue('docRootElement') : $this->_DOCROOTELEMENT;
      $docLinebreak = $request->hasValue('docLinebreak') ? $request->getValue('docLinebreak') : $this->_DOCLINEBREAK;
      $docIndent = $request->hasValue('docIndent') ? $request->getValue('docIndent') : $this->_DOCINDENT;
      $nodesPerCall = $request->hasValue('nodesPerCall') ? $request->getValue('nodesPerCall') : $this->_NODES_PER_CALL;

      $documentInfo = array('docFile' => $docFile, 'docType' => $docType, 'dtd' => $dtd, 'docRootElement' => $docRootElement,
        'docLinebreak' => $docLinebreak, 'docIndent' => $docIndent, 'nodesPerCall' => $nodesPerCall,
        'lastIndent' => 0, 'tagsToClose' => array());

      // store document info in session
      $session->set($this->DOCUMENT_INFO, $documentInfo);
    }
  }

  /**
   * @see BatchController::getWorkPackage()
   */
  protected function getWorkPackage($number) {
    if ($number == 0) {
      return array('name' => $this->getMessage()->getText('Initialization'),
          'size' => 1, 'oids' => array(1), 'callback' => 'initExport');
    }
    else {
      return null;
    }
  }

  /**
   * @see BatchController::getDownloadFile()
   */
  protected function getDownloadFile() {
    $cacheDir = session_save_path().DIRECTORY_SEPARATOR;
    return $cacheDir.$this->_DOCFILE;
  }

  /**
   * Initialize the XML export (oids parameter will be ignored)
   * @param $oids The oids to process
   * @note This is a callback method called on a matching work package, see BatchController::addWorkPackage()
   */
  protected function initExport($oids) {
    $session = $this->getSession();
    $fileUtil = $this->getFileUtil();
    // restore document state from session
    $documentInfo = $session->get($this->DOCUMENT_INFO);
    $filename = $documentInfo['docFile'];

    // delete export file
    if (file_exists($filename)) {
      unlink($filename);
    }

    // start document
    $fileHandle = fopen($filename, "a");
    $fileUtil->fputsUnicode($fileHandle, '<?xml version="1.0" encoding="UTF-8"?>'.$documentInfo['docLinebreak']);
    if ($documentInfo['docType'] != "") {
      $fileUtil->fputsUnicode($fileHandle, '<!DOCTYPE '.$documentInfo['docType'].' SYSTEM "'.$documentInfo['dtd'].'">'.$documentInfo['docLinebreak']);
    }
    $fileUtil->fputsUnicode($fileHandle, '<'.$documentInfo['docRootElement'].'>'.$documentInfo['docLinebreak']);
    fclose($fileHandle);

    // get root types from ini file
    $rootOIDs = array();
    $config = $this->getConfiguration();
    $rootTypes = $config->getValue('rootTypes', 'application');
    if (is_array($rootTypes)) {
      $persistenceFacade = $this->getPersistenceFacade();
      foreach($rootTypes as $rootType) {
        $rootOIDs = array_merge($rootOIDs, $persistenceFacade->getOIDs($rootType));
      }
    }

    // store root object ids in session
    $nextOID = array_shift($rootOIDs);
    $this->_cache->put(self::CACHE_SECTION, self::CACHE_KEY_ROOT_OIDS, $rootOIDs);

    // empty exported oids
    $tmp = array();
    $this->_cache->put(self::CACHE_SECTION, self::CACHE_KEY_EXPORTED_OIDS, $tmp);

    // create work package for first root node
    $this->addWorkPackage(
            $this->getMessage()->getText('Exporting tree: start with %0%', array($nextOID)),
            1, array($nextOID), 'exportNodes');
  }

  /**
   * Serialize all Nodes with given oids to XML
   * @param $oids The oids to process
   * @note This is a callback method called on a matching work package, see BatchController::addWorkPackage()
   */
  protected function exportNodes($oids) {
    // Export starts from root oids and iterates over all children.
    // On every call we have to decide what to do:
    // - If there is an iterator stored in the session we are inside a tree and continue iterating (_NODES_PER_CALL nodes)
    //   until the iterator finishes
    // - If the oids array holds one value!=null this is assumed to be an root oid and a new iterator is constructed
    // - If there is no iterator and no oid given, we return

    $session = $this->getSession();
    $persistenceFacade = $this->getPersistenceFacade();
    $message = $this->getMessage();

    // restore document state from session
    $documentInfo = $session->get($this->DOCUMENT_INFO);

    // check for iterator in session
    $iterator = null;
    $iteratorID = $session->get($this->ITERATOR_ID);
    if ($iteratorID != null) {
      $iterator = PersistentIterator::load($persistenceFacade, $session, $iteratorID);
    }
    // no iterator but oid given, start with new root oid
    if ($iterator == null && sizeof($oids) > 0 && $oids[0] != null) {
      $iterator = new PersistentIterator($persistenceFacade, $session, $oids[0]);
    }
    // no iterator, no oid, finish
    if ($iterator == null) {
      $this->addWorkPackage($message->getText('Finish'), 1, array(null), 'finishExport');
      return;
    }

    // process _NODES_PER_CALL nodes
    $fileHandle = fopen($documentInfo['docFile'], "a");
    $counter = 0;
    while ($iterator->valid() && $counter < $documentInfo['nodesPerCall']) {
      // write node
      $documentInfo = $this->writeNode($fileHandle, $iterator->current(), $iterator->key()+1, $documentInfo);
      $iterator->next();
      $counter++;
    }
    $this->endTags($fileHandle, 0, $documentInfo);
    fclose($fileHandle);

    // save document state to session
    $session->set($this->DOCUMENT_INFO, $documentInfo);

    // decide what to do next
    $rootOIDs = $this->_cache->get(self::CACHE_SECTION, self::CACHE_KEY_ROOT_OIDS);
    if (!$iterator->valid() && sizeof($rootOIDs) > 0) {
      // if the current iterator is finished, set iterator null and proceed with the next root oid
      $nextOID = array_shift($rootOIDs);
      $iterator = null;
      // store remaining root oids in session
      $this->_cache->put(self::CACHE_SECTION, self::CACHE_KEY_ROOT_OIDS, $rootOIDs);
      // unset iterator id to start with new root oid
      $tmp = null;
      $session->set($this->ITERATOR_ID, $tmp);

      $name = $message->getText('Exporting tree: start with %0%', array($nextOID));
      $this->addWorkPackage($name, 1, array($nextOID), 'exportNodes');
    }
    elseif ($iterator->valid()) {
      // proceed with current iterator
      $iteratorID = $iterator->save();
      $session->set($this->ITERATOR_ID, $iteratorID);

      $name = $message->getText('Exporting tree: continue with %0%', array($iterator->current()));
      $this->addWorkPackage($name, 1, array(null), 'exportNodes');
    }
    else {
      // finish
      $this->addWorkPackage($message->getText('Finish'), 1, array(null), 'finishExport');
    }
  }

  /**
   * Finish the XML export (oids parameter will be ignored)
   * @param $oids The oids to process
   * @note This is a callback method called on a matching work package, see BatchController::addWorkPackage()
   */
  protected function finishExport($oids) {
    $session = $this->getSession();
    $fileUtil = $this->getFileUtil();
    // restore document state from session
    $documentInfo = $session->get($this->DOCUMENT_INFO);

    // end document
    $fileHandle = fopen($documentInfo['docFile'], "a");
    $this->endTags($fileHandle, 0, $documentInfo);
    $fileUtil->fputsUnicode($fileHandle, '</'.$documentInfo['docRootElement'].'>'.$documentInfo['docLinebreak']);
    fclose($fileHandle);

    // clear session variables
    $tmp = null;
    $this->_cache->put(self::CACHE_SECTION, self::CACHE_KEY_ROOT_OIDS, $tmp);
    $session->set($this->ITERATOR_ID, $tmp);
    $session->set($this->DOCUMENT_INFO, $tmp);
  }

  /**
   * Ends all tags up to $curIndent level
   * @param $fileHandle The file handle to write to
   * @param $curIndent The depth of the node in the tree
   * @param $documentInfo A reference to an assoziative array (see DOCUMENT_INFO)
   */
  protected function endTags($fileHandle, $curIndent, &$documentInfo) {
    $fileUtil = $this->getFileUtil();
    $lastIndent = $documentInfo['lastIndent'];

    // write last opened and not closed tags
    if ($curIndent < $lastIndent) {
      for ($i=$lastIndent-$curIndent; $i>0; $i--) {
        $closeTag = array_shift($documentInfo['tagsToClose']);
        if ($closeTag) {
          $fileUtil->fputsUnicode($fileHandle, str_repeat($documentInfo['docIndent'], $closeTag["indent"]).'</'.$closeTag["name"].'>'.$documentInfo['docLinebreak']);
        }
      }
    }
  }

  /**
   * Serialize a Node to XML
   * @param $fileHandle The file handle to write to
   * @param $oid The oid of the node
   * @param $depth The depth of the node in the tree
   * @param $documentInfo An assoziative array (see DOCUMENT_INFO)
   * @return The updated document state
   */
  protected function writeNode($fileHandle, ObjectId $oid, $depth, $documentInfo) {
    $persistenceFacade = $this->getPersistenceFacade();
    $fileUtil = $this->getFileUtil();

    // load node and get element name
    $node = $persistenceFacade->load($oid);
    $elementName = $persistenceFacade->getSimpleType($node->getType());

    // check if the node is written already
    $exportedOids = $this->_cache->get(self::CACHE_SECTION, self::CACHE_KEY_EXPORTED_OIDS);
    if (!in_array($oid->__toString(), $exportedOids)) {
      // write node
      $mapper = $node->getMapper();

      $hasUnvisitedChildren = $this->getNumUnvisitedChildren($node) > 0;

      $curIndent = $depth;
      $this->endTags($fileHandle, $curIndent, $documentInfo);

      // write object's content
      // open start tag
      $fileUtil->fputsUnicode($fileHandle, str_repeat($documentInfo['docIndent'], $curIndent).'<'.$elementName);
      // write object attributes
      $attributes = $mapper->getAttributes();
      foreach ($attributes as $curAttribute) {
        $attributeName = $curAttribute->getName();
        $value = $node->getValue($attributeName);
        if ($value) {
          $fileUtil->fputsUnicode($fileHandle, ' '.$attributeName.'="'.$this->formatValue($value).'"');
        }
      }
      // close start tag
      $fileUtil->fputsUnicode($fileHandle, '>');
      if ($hasUnvisitedChildren) {
        $fileUtil->fputsUnicode($fileHandle, $documentInfo['docLinebreak']);
      }

      // remember end tag if not closed
      if ($hasUnvisitedChildren) {
        $closeTag = array("name" => $elementName, "indent" => $curIndent);
        array_unshift($documentInfo['tagsToClose'], $closeTag);
      }
      else {
        $fileUtil->fputsUnicode($fileHandle, '</'.$elementName.'>'.$documentInfo['docLinebreak']);
      }
      // remember current indent
      $documentInfo['lastIndent'] = $curIndent;

      // register exported node
      $exportedOids[] = $oid->__toString();
      $this->_cache->put(self::CACHE_SECTION, self::CACHE_KEY_EXPORTED_OIDS, $exportedOids);
    }
    // return the updated document info
    return $documentInfo;
  }

  /**
   * Get number of children of the given node, that were not visited yet
   * @param $node
   * @return Integer
   */
  protected function getNumUnvisitedChildren(Node $node) {
    $exportedOids = $this->_cache->get(self::CACHE_SECTION, self::CACHE_KEY_EXPORTED_OIDS);

    $childOIDs = array();
    $mapper = $node->getMapper();
    $relations = $mapper->getRelations('child');
    foreach ($relations as $relation) {
      if ($relation->getOtherNavigability()) {
        $childValue = $node->getValue($relation->getOtherRole());
        if ($childValue != null) {
          $children = $relation->isMultiValued() ? $childValue : array($childValue);
          foreach ($children as $child) {
            $childOIDs[] = $child->getOID();
          }
        }
      }
    }
    $numUnvisitedChildren = 0;
    foreach ($childOIDs as $childOid) {
      if (!in_array($childOid->__toString(), $exportedOids)) {
        $numUnvisitedChildren++;
      }
    }
    return $numUnvisitedChildren;
  }

  /**
   * Format a value for XML output
   * @param $value The value to format
   * @return The formatted value
   * @note Subclasses may overrite this for special application requirements
   */
  protected function formatValue($value) {
    return htmlentities(str_replace(array("\r", "\n"), array("", ""), nl2br($value)), ENT_QUOTES);
  }
}
?>
