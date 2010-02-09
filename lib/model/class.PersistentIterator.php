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
require_once(BASE."wcmf/lib/persistence/class.PersistenceFacade.php");
require_once(BASE."wcmf/lib/util/class.SessionData.php");

/**
 * @class PersistentIterator
 * @ingroup Model
 * @brief PersistentIterator is used to iterate over a tree/list build of oids
 * using a Depth-First-Algorithm. To persist its state use the PersistentIterator::save() method,
 * to restore its state use the static PersistentIterator::load() method, which returns the loaded instance.
 * States are identified by an unique id, which is provided after saving.
 * PersistentIterator implements the 'Iterator Pattern'.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class PersistentIterator
{
  var $_end;        // indicates if the iteration is ended
  var $_oidList;    // the list of oids to process
  var $_allList;    // the list of all seen object ids
  var $_currentOID; // the oid the iterator points to
  var $_currentDepth; // the depth in the tree of the oid the iterator points to
  /**
   * Constructor.
   * @param oid The oid to start from.
   */
  function PersistentIterator($oid)
  {
    $this->_end = false;
    $this->_oidList = array();
    $this->_allList = array();
    $this->_currentOID = $oid;
    $this->_currentDepth = 0;
  }  
  /**
   * Save the iterator state to the session
   * @return A unique id to provide for load, see PersistentIterator::load()
   */
  function save()
  {
    $session = &SessionData::getInstance();

    $uid = md5(uniqid(""));
    $state = array('end' => $this->_end, 'oidList' => $this->_oidList, 'allList' => $this->_allList, 'currentOID' => $this->_currentOID, 
      'currentDepth' => $this->_currentDepth);
    $session->set('PersistentIterator.'.$uid, $state);
    return $uid;
  }  
  /**
   * Load an iterator state from the session
   * @note static method
   * @param uid The unique id returned from the save method, see PersistentIterator::save()
   * @return A reference to an PersistentIterator instance holding the saved state or null if unique id is not found
   */
  function &load($uid)
  {
    // get state from session
    $session = &SessionData::getInstance();
    $state = $session->get('PersistentIterator.'.$uid);
    if ($state == null) {
      return null;
    }
    // create instance
    $instance = new PersistentIterator($state['currentOID']);
    $instance->_end = $state['end'];
    $instance->_oidList = $state['oidList'];
    $instance->_allList = $state['allList'];
    $instance->_currentDepth = $state['currentDepth'];
    return $instance;
  }  
  /**
   * Proceed to next oid.
   * @return A reference to the Iterator.
   */
  function &proceed()
  {
    $persistenceFacade = &PersistenceFacade::getInstance();
    $node = &$persistenceFacade->load($this->_currentOID, BUILDDEPTH_SINGLE);

    $childOIDs = $node->getProperty('childoids');
    $this->addToSeenList($childOIDs, ++$this->_currentDepth);
    
    if (sizeOf($this->_oidList) != 0) {
      list($this->_currentOID, $this->_currentDepth) = array_pop($this->_oidList);
    }
    else {
      $this->_end = true;
    }
    return $this;
  } 
  /**
   * Get the current oid.
   * @return The current oid.
   */
  function getCurrentOID()
  {
    return $this->_currentOID;
  }
  /**
   * Get the current depth.
   * @return The current depth.
   */
  function getCurrentDepth()
  {
    return $this->_currentDepth;
  }
  /**
   * Find out whether iteration is finished.
   * @return 'True' if iteration is finished, 'False' alternatively.
   */  
  function isEnd()
  { 
    return $this->_end;
  } 
  /**
   * Reset the iterator to given oid.
   * @param oid The oid of the object to start from.
   */
  function reset($oid)
  {   
    $this->_end = false;
    $this->_oidList= array();
    $this->_allList = array();
    $this->_currentOID = $oid;
    $this->_currentDepth = 0;
  } 
  /**
   * Add oids to the internal processed oid list.
   * @attention Internal use only.
   * @param oidList An array of oids.
   * @param depth The depth of the oids in the tree.
   */  
  function addToSeenList($oidList, $depth)
  {
    for ($i=sizeOf($oidList)-1;$i>=0;$i--)
    {
      if (!in_array($oidList[$i], $this->_allList)) {
        array_push($this->_oidList, array($oidList[$i], $depth));
        array_push($this->_allList, $oidList[$i]);
      }
    }
  } 
  /**
   */  
  function dumpOIDList()
  {
    $str = '';
    for ($i=0; $i<sizeOf($this->_oidList); $i++)
    {
      $str .= $this->_oidList[$i][0].",";
    }
    return $str;
  } 
}
?>