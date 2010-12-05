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
require_once(WCMF_BASE."wcmf/lib/model/class.NodeIterator.php");
/**
 * @class Visitor
 * @ingroup Visitor
 * @brief Visitor is used to extend an object's functionality by not extending
 * its interface. Classes to use with the Visitor must implement the acceptVisitor() method.
 * Visitor implements the 'Visitor Pattern'.
 * It implements the 'Template Method Pattern' to allow subclasses
 * to do any Pre- and Post Visit operations (doPreVisit() and doPostVisit() methods).
 * The abstract base class Visitor defines the interface for all
 * specialized Visitor classes.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
abstract class Visitor
{
  /**
   * Start the visiting process by iterating over all objects using
   * the given NodeIterator. The visit() method is called by every
   * visited object.
   * @param iterator A reference to the NodeIterator to use (configured with the start object).
   */
  public function startIterator($iterator)
  {
    $this->doPreVisit();
    while(!($iterator->isEnd()))
    {
      $currentObject = & $iterator->getCurrentObject();
      $currentObject->acceptVisitor($this);
      $iterator->proceed();
    }
    $this->doPostVisit();
  }
  /**
   * Start the visiting process by iterating over all elements of a given array.
   * The visit() method is called by every visited object.
   * @param array An array holding references to the objects to visit.
   */
  public function startArray($array)
  {
    $this->doPreVisit();
    foreach($array as $currentObject) {
      $currentObject->acceptVisitor($this);
    }
    $this->doPostVisit();
  }
  /**
   * Visit the current object in iteration.
   * Subclasses of Visitor override this method to implement the specialized
   * functionality.
   * @param obj A reference to the current object.
   */
  public abstract function visit($obj);
  /**
   * Subclasses may override this method to do any operations before the visiting process here.
   */
  public function doPreVisit() {}
  /**
   * Subclasses may override this method to do any operations after the visiting process here.
   */
  public function doPostVisit() {}
}
?>
