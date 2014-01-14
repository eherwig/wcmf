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
namespace wcmf\application\controller;

use wcmf\application\controller\BatchController;
use wcmf\lib\core\ObjectFactory;
use wcmf\lib\i18n\Message;
use wcmf\lib\io\FileUtil;
use wcmf\lib\model\PersistentIterator;
use wcmf\lib\presentation\Request;
use wcmf\lib\presentation\Response;

/**
 * XMLExportController exports the content tree into an XML file.
 *
 * <b>Input actions:</b>
 * - @em continue Continue export
 * - unspecified: Initiate the export
 *
 * <b>Output actions:</b>
 * - see BatchController
 *
 * @param[in] docfile The name of the file to write to (path relative to script main location), default: 'export.xml'
 * @param[in] doctype The document type (will be written into XML header), default: ''
 * @param[in] dtd The dtd (will be written into XML header), default: ''
 * @param[in] docrootelement The root element of the document (use this to enclose different root types if necessary), default: 'Root'
 * @param[in] doclinebreak The linebreak character(s) to use, default: '\n'
 * @param[in] docindent The indent character(s) to use, default: '  '
 * @param[in] nodes_per_call The number of nodes to process in one call, default: 10
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class XMLExportController extends BatchController {

  // session name constants
  private $ROOT_OIDS = 'XMLExportController.rootoids';
  private $EXPORTED_OIDS = 'XMLExportController.exportedoids';
  private $ITERATOR_ID = 'XMLExportController.iteratorid';

  // documentInfo passes the current document info/status from one call to the next:
  // An assoziative array with keys 'docFile', 'doctype', 'dtd', 'docLinebreak', 'docIndent', 'nodesPerCall',
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

  /**
   * @see Controller::initialize()
   */
  public function initialize(Request $request, Response $response) {
    parent::initialize($request, $response);

    // construct initial document info
    if ($request->getAction() != 'continue') {
      $session = ObjectFactory::getInstance('session');

      $docFile = $request->hasValue('docfile') ? $request->getValue('docfile') : $this->_DOCFILE;
      $docType = $request->hasValue('doctype') ? $request->getValue('doctype') : $this->_DOCTYPE;
      $dtd = $request->hasValue('dtd') ? $request->getValue('dtd') : $this->_DTD;
      $docRootElement = $request->hasValue('docrootelement') ? $request->getValue('docrootelement') : $this->_DOCROOTELEMENT;
      $docLinebreak = $request->hasValue('doclinebreak') ? $request->getValue('doclinebreak') : $this->_DOCLINEBREAK;
      $docIndent = $request->hasValue('docindent') ? $request->getValue('docindent') : $this->_DOCINDENT;
      $nodesPerCall = $request->hasValue('nodes_per_call') ? $request->getValue('nodes_per_call') : $this->_NODES_PER_CALL;

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
      return array('name' => Message::get('Initialization'), 'size' => 1, 'oids' => array(1), 'callback' => 'initExport');
    }
    else {
      return null;
    }
  }

  /**
   * Initialize the XML export (oids parameter will be ignored)
   * @param oids The oids to process
   * @note This is a callback method called on a matching work package, see BatchController::addWorkPackage()
   */
  protected function initExport($oids) {
    $session = ObjectFactory::getInstance('session');
    // restore document state from session
    $documentInfo = $session->get($this->DOCUMENT_INFO);
    $filename = $documentInfo['docFile'];

    // delete export file
    if (file_exists($filename)) {
      unlink($filename);
    }

    // start document
    $fileHandle = fopen($filename, "a");
    FileUtil::fputsUnicode($fileHandle, '<?xml version="1.0" encoding="UTF-8"?>'.$documentInfo['docLinebreak']);
    if ($documentInfo['docType'] != "") {
      FileUtil::fputsUnicode($fileHandle, '<!DOCTYPE '.$documentInfo['docType'].' SYSTEM "'.$documentInfo['dtd'].'">'.$documentInfo['docLinebreak']);
    }
    FileUtil::fputsUnicode($fileHandle, '<'.$documentInfo['docRootElement'].'>'.$documentInfo['docLinebreak']);
    fclose($fileHandle);

    // get root types from ini file
    $rootOIDs = array();
    $config = ObjectFactory::getConfigurationInstance();
    $rootTypes = $config->getValue('rootTypes', 'application');

    if (is_array($rootTypes)) {
      $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');
      foreach($rootTypes as $rootType) {
        $rootOIDs = array_merge($rootOIDs, $persistenceFacade->getOIDs($rootType));
      }
    }

    // store root object ids in session
    $nextOID = array_shift($rootOIDs);
    $session->set($this->ROOT_OIDS, $rootOIDs);

    // empty exported oids
    $tmp = array();
    $session->set($this->EXPORTED_OIDS, $tmp);

    // create work package for first root node
    $this->addWorkPackage(Message::get('Exporting tree: start with %0%', array($nextOID)), 1, array($nextOID), 'exportNodes');
  }

  /**
   * Serialize all Nodes with given oids to XML
   * @param oids The oids to process
   * @note This is a callback method called on a matching work package, see BatchController::addWorkPackage()
   */
  protected function exportNodes($oids) {
    // Export starts from root oids and iterates over all children.
    // On every call we have to decide what to do:
    // - If there is an iterator stored in the session we are inside a tree and continue iterating (_NODES_PER_CALL nodes)
    //   until the iterator finishes
    // - If the oids array holds one value!=null this is assumed to be an root oid and a new iterator is constructed
    // - If there is no iterator and no oid given, we return

    $session = ObjectFactory::getInstance('session');
    // restore document state from session
    $documentInfo = $session->get($this->DOCUMENT_INFO);

    // check for iterator in session
    $iterator = null;
    $iteratorID = $session->get($this->ITERATOR_ID);
    if ($iteratorID != null) {
      $iterator = PersistentIterator::load($iteratorID);
    }
    // no iterator but oid given, start with new root oid
    if ($iterator == null && $oids[0] != null) {
      $iterator = new PersistentIterator($oids[0]);
    }
    // no iterator, no oid, finish
    if ($iterator == null) {
      $this->addWorkPackage(Message::get('Finish'), 1, array(null), 'finishExport');
      return;
    }

    // process _NODES_PER_CALL nodes
    $fileHandle = fopen($documentInfo['docFile'], "a");
    $counter = 0;
    $documentInfo['endTag'] = false;
    while ($iterator->valid() && $counter < $documentInfo['nodesPerCall']) {
      // write node
      $documentInfo = $this->writeNode($fileHandle, $iterator->current(), $iterator->key()+1, $documentInfo);
      $iterator->next();
      $counter++;
    }
    fclose($fileHandle);

    // save document state to session
    $session->set($this->DOCUMENT_INFO, $documentInfo);

    // decide what to do next
    $rootOIDs = $session->get($this->ROOT_OIDS);
    if (!$iterator->valid() && sizeof($rootOIDs) > 0) {
      // if the current iterator is finished, set iterator null and proceed with the next root oid
      $nextOID = array_shift($rootOIDs);
      $iterator = null;
      // store remaining root oids in session
      $session->set($this->ROOT_OIDS, $rootOIDs);
      // unset iterator id to start with new root oid
      $tmp = null;
      $session->set($this->ITERATOR_ID, $tmp);

      $name = Message::get('Exporting tree: start with %0%', array($nextOID));
      $this->addWorkPackage($name, 1, array($nextOID), 'exportNodes');
    }
    elseif ($iterator->valid()) {
      // proceed with current iterator
      $iteratorID = $iterator->save();
      $session->set($this->ITERATOR_ID, $iteratorID);

      $name = Message::get('Exporting tree: continue with %0%', array($iterator->current()));
      $this->addWorkPackage($name, 1, array(null), 'exportNodes');
    }
    else {
      // finish
      $this->addWorkPackage(Message::get('Finish'), 1, array(null), 'finishExport');
    }
  }

  /**
   * Finish the XML export (oids parameter will be ignored)
   * @param oids The oids to process
   * @note This is a callback method called on a matching work package, see BatchController::addWorkPackage()
   */
  protected function finishExport($oids) {
    $session = ObjectFactory::getInstance('session');
    // restore document state from session
    $documentInfo = $session->get($this->DOCUMENT_INFO);

    // end document
    $fileHandle = fopen($documentInfo['docFile'], "a");
    $this->endTags($fileHandle, 1, $documentInfo);
    FileUtil::fputsUnicode($fileHandle, '</'.$documentInfo['docRootElement'].'>'.$documentInfo['docLinebreak']);
    fclose($fileHandle);

    // clear session variables
    $tmp = null;
    $session->set($this->ROOT_OIDS, $tmp);
    $session->set($this->ITERATOR_ID, $tmp);
    $session->set($this->DOCUMENT_INFO, $tmp);
  }

  /**
   * Ends all tags up to $curIndent level
   * @param fileHandle The file handle to write to
   * @param curIndent The depth of the node in the tree
   * @param documentInfo An assoziative array (see DOCUMENT_INFO)
   */
  protected function endTags($fileHandle, $curIndent, $documentInfo) {
    $lastIndent = $documentInfo['lastIndent'];

    // write last opened and not closed tags
    if ($curIndent < $lastIndent) {
      for ($i=$lastIndent-$curIndent; $i>0; $i--) {
        $closeTag = array_shift($documentInfo['tagsToClose']);
        FileUtil::fputsUnicode($fileHandle, str_repeat($documentInfo['docIndent'], $closeTag["indent"]).'</'.$closeTag["name"].'>'.$documentInfo['docLinebreak']);
      }
    }
  }

  /**
   * Serialize a Node to XML
   * @param fileHandle The file handle to write to
   * @param oid The oid of the node
   * @param depth The depth of the node in the tree
   * @param documentInfo An assoziative array (see DOCUMENT_INFO)
   * @return The updated document state
   */
  protected function writeNode($fileHandle, $oid, $depth, $documentInfo) {
    $session = ObjectFactory::getInstance('session');
    $exportedOids = $session->get($this->EXPORTED_OIDS);
    if (in_array($oid->__toString(), $exportedOids)) {
      return $documentInfo;
    }
    $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');
    $node = $persistenceFacade->load($oid);
    $mapper = $node->getMapper();

    $numChildren = sizeof($node->getChildren(false));
    $lastIndent = $documentInfo['lastIndent'];
    $curIndent = $depth;
    $this->endTags($fileHandle, $curIndent, $documentInfo);

    $tagName = $persistenceFacade->getSimpleType($node->getType());

    if (!$documentInfo['endTag']) {
      if ($numChildren > 0) {
        $closeTag = array("name" => $tagName, "indent" => $curIndent);
        array_unshift($documentInfo['tagsToClose'], $closeTag);
        $documentInfo['endTag'] = true;
      }
    }

    // write object's content
    // open tag
    FileUtil::fputsUnicode($fileHandle, str_repeat($documentInfo['docIndent'], $curIndent).'<'.$tagName);
    // write object id
    FileUtil::fputsUnicode($fileHandle, ' id="'.$node->getOID().'"');
    // write object attributes
    $attributes = $mapper->getAttributes();
    foreach ($attributes as $curAttribute) {
      $attributeName = $curAttribute->getName();
      $value = $node->getValue($attributeName);
      if ($value != '') {
        FileUtil::fputsUnicode($fileHandle, ' '.$attributeName.'="'.$this->formatValue($value).'"');
      }
    }
    // close tag
    FileUtil::fputsUnicode($fileHandle, '>');
    if ($numChildren > 0) {
      FileUtil::fputsUnicode($fileHandle, $documentInfo['docLinebreak']);
    }

    // remember open tag if not closed
    if ($numChildren > 0) {
      $closeTag = array("name" => $tagName, "indent" => $curIndent);
      array_unshift($documentInfo['tagsToClose'], $closeTag);
    }
    else {
      FileUtil::fputsUnicode($fileHandle, '</'.$tagName.'>'.$documentInfo['docLinebreak']);
    }
    // remember current indent
    $documentInfo['lastIndent'] = $curIndent;

    // register exported node
    $exportedOids[] = $oid->__toString();
    $session->set($this->EXPORTED_OIDS, $exportedOids);

    // return the updated document info
    return $documentInfo;
  }

  /**
   * Format a value for XML output
   * @param value The value to format
   * @return The formatted value
   * @note Subclasses may overrite this for special application requirements
   */
  protected function formatValue($value) {
    return htmlentities(str_replace(array("\r", "\n"), array("", ""), nl2br($value)), ENT_QUOTES);
  }
}
?>
