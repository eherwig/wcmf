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

use wcmf\lib\core\ObjectFactory;
use wcmf\lib\config\ConfigurationException;
use wcmf\lib\model\Node;
use wcmf\lib\model\NodeUtil;
use wcmf\lib\persistence\BuildDepth;
use wcmf\lib\persistence\ObjectId;
use wcmf\lib\persistence\PersistenceAction;
use wcmf\lib\presentation\Controller;

/**
 * TreeController is used to visualize nodes in a tree view.
 *
 * The controller supports the following actions:
 *
 * <div class="controller-action">
 * <div> __Action__ _default_ </div>
 * <div>
 * Load the cild nodes of the given Node.
 * | Parameter              | Description
 * |------------------------|-------------------------
 * | _in_ `oid`             | The object id of the parent Node whose children should be loaded (optional)
 * | _in_ `sort`            | The attribute to sort the children by (optional)
 * | _in_ `rootTypes`       | Name of a configuration value in configuration section 'application', that defines an array of root types of the tree (optional, defaults to 'rootTypes')
 * | _out_ `list`           | An array of associative arrays with keys 'oid', 'displayText', 'isFolder', 'hasChildren'
 * | __Response Actions__   | |
 * | `ok`                   | In all cases
 * </div>
 * </div>
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class TreeController extends Controller {

  /**
   * @see Controller::doExecute()
   */
  protected function doExecute() {
    $request = $this->getRequest();
    $response = $this->getResponse();

    $oidStr = $request->getValue('oid');
    if ($oidStr == 'root') {
      // types below root node
      $objects = $this->getRootTypes();
    }
    else {
      $oid = ObjectId::parse($oidStr);
      if ($oid != null) {
        // load children
        $objects = $this->getChildren($oid);
      }
    }

    // sort nodes if requested
    if ($request->hasValue('sort')) {
      $objects = Node::sort($objects, $request->getValue('sort'));
    }

    // create response
    $responseObjects = array();
    for ($i=0, $count=sizeof($objects); $i<$count; $i++) {
      $object = $objects[$i];
      if ($this->isVisible($object)) {
        $responseObjects[] = $this->getViewNode($object);
      }
    }
    $response->setValue('list', $responseObjects);

    // success
    $response->setAction('ok');
  }

  /**
   * Get the children for a given oid.
   * @param $oid The object id
   * @return Array of Node instances.
   */
  protected function getChildren($oid) {

    $permissionManager = ObjectFactory::getInstance('permissionManager');
    $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');

    // check read permission on type
    $type = $oid->getType();
    if (!$permissionManager->authorize($type, '', PersistenceAction::READ)) {
      return array();
    }

    $objectsTmp = array();
    if ($this->isRootTypeNode($oid)) {
      // load instances of type
      $objectsTmp = $persistenceFacade->loadObjects($type, BuildDepth::SINGLE);
    }
    else {
      // load children of node
      if ($permissionManager->authorize($oid, '', PersistenceAction::READ)) {
        $node = $persistenceFacade->load($oid, 1);
        if ($node) {
          $objectsTmp = $node->getChildren();
        }
      }
    }

    // check read permission on instances
    $objects = array();
    foreach ($objectsTmp as $object) {
      if ($permissionManager->authorize($object->getOID(), '', PersistenceAction::READ)) {
        $objects[] = $object;
      }
    }

    return $objects;
  }

  /**
   * Get the oids of the root nodes.
   * @return An array of object ids.
   */
  protected function getRootOIDs() {
    // types below root node
    return $this->getRootTypes();
  }

  /**
   * Get the view of a Node
   * @param $node The Node to create the view for
   * @param $displayText The text to display (will be taken from TreeController::getDisplayText() if not specified) (default: '')
   * @return An associative array whose keys correspond to Ext.tree.TreeNode config parameters
   */
  protected function getViewNode(Node $node, $displayText='') {
    if (strlen($displayText) == 0) {
      $displayText = trim($this->getDisplayText($node));
    }
    if (strlen($displayText) == 0) {
      $displayText = '-';
    }
    $oid = $node->getOID();
    $isFolder = $oid->containsDummyIds();
    $hasChildren = $this->isRootTypeNode($oid) || sizeof($node->getNumChildren()) > 0;
    return array(
      'oid' => $node->getOID()->__toString(),
      'displayText' => $displayText,
      'isFolder' => $isFolder,
      'hasChildren' => $hasChildren
    );
  }

  /**
   * Test if a Node should be displayed in the tree
   * @param $node Node to display
   * @return Boolean
   */
  protected function isVisible(Node $node) {
    return true;
  }

  /**
   * Get the display text for a Node
   * @param $node Node to display
   * @return The display text.
   */
  protected function getDisplayText(Node $node) {
    if ($this->isRootTypeNode($node->getOID())) {
      return $node->getObjectDisplayName();
    }
    else {
      return strip_tags(preg_replace("/[\r\n']/", " ", NodeUtil::getDisplayValue($node)));
    }
  }

  /**
   * Get all root types
   * @return Array of Node instances
   */
  protected function getRootTypes() {
    $request = $this->getRequest();
    $config = ObjectFactory::getConfigurationInstance();
    $appConfig = $config->getSection('application');

    // get root types from configuration
    // try request value first
    $rootTypeVar = $request->getValue('rootTypes');
    if (isset($appConfig[$rootTypeVar]) && is_array($appConfig[$rootTypeVar])) {
      $types = $appConfig[$rootTypeVar];
    }
    else if (isset($appConfig['rootTypes']) && is_array($appConfig['rootTypes'])) {
      // fall back to root types
      $types = $appConfig['rootTypes'];
    }
    else {
      throw new ConfigurationException("No root types defined.");
    }

    // filter types by read permission
    $permissionManager = ObjectFactory::getInstance('permissionManager');
    $persistenceFacade = ObjectFactory::getInstance('persistenceFacade');
    $nodes = array();
    foreach($types as $type) {
      if ($permissionManager->authorize($type, '', PersistenceAction::READ)) {
        $node = $persistenceFacade->create($type, BuildDepth::SINGLE);
        $nodes[] = $node;
      }
    }
    return $nodes;
  }

  /**
   * Check if the given oid belongs to a root type node
   * @param $oid The object id
   * @return Boolean
   */
  protected function isRootTypeNode(ObjectId $oid) {
    if ($oid->containsDummyIds()) {
      $type = $oid->getType();
      $rootTypes = $this->getRootTypes();
      foreach ($rootTypes as $rootType) {
        if ($rootType->getType() == $type) {
          return true;
        }
      }
    }
    return false;
  }
}
?>