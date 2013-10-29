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
namespace test\tests\persistence;

use test\lib\ArrayDataSet;
use test\lib\DatabaseTestCase;
use test\lib\TestUtil;
use wcmf\lib\persistence\ObjectId;
use wcmf\lib\persistence\PersistentObject;
use wcmf\lib\persistence\PersistentObjectProxy;

/**
 * PersistentObjectProxyTest.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class PersistentObjectProxyTest extends DatabaseTestCase {

  private $_chapter1OidStr = 'Chapter:123451';

  protected function getDataSet() {
    return new ArrayDataSet(array(
      'dbsequence' => array(
        array('id' => 1),
      ),
      'Chapter' => array(
        array('id' => 123451, 'fk_chapter_id' => null, 'name' => 'Chapter1', 'sortkey' => 123451),
        array('id' => 123452, 'fk_chapter_id' => 123451, 'name' => 'Chapter2', 'sortkey' => 123452),
      ),
    ));
  }

  public function testLoadSimple() {
    TestUtil::runAnonymous(true);
    $proxy1 = new PersistentObjectProxy(ObjectId::parse($this->_chapter1OidStr));
    $this->assertEquals("Chapter1", $proxy1->getName());
    $this->assertEquals(123451, $proxy1->getSortkey());
    $this->assertTrue($proxy1->getRealSubject() instanceof PersistentObject, "Real subject is PersistentObject instance");

    $proxy2 = PersistentObjectProxy::fromObject($proxy1->getRealSubject());
    $this->assertEquals("Chapter1", $proxy2->getName());
    $this->assertEquals(123451, $proxy2->getSortkey());
    $this->assertTrue($proxy2->getRealSubject() instanceof PersistentObject, "Real subject is PersistentObject instance");
    TestUtil::runAnonymous(false);
  }

  public function testLoadRelation() {
    TestUtil::runAnonymous(true);
    $proxy = new PersistentObjectProxy(ObjectId::parse($this->_chapter1OidStr));
    $chapter1 = $proxy->getRealSubject();
    $this->assertEquals("Chapter1", $proxy->getName());
    $this->assertEquals(123451, $proxy->getSortkey());
    $this->assertTrue($chapter1 instanceof PersistentObject, "Real subject is PersistentObject instance");

    // implicitly load relation
    $subChapters = $chapter1->getValue("SubChapter");
    $chapter2 = $subChapters[0];
    $this->assertEquals("Chapter2", $chapter2->getName());
    $this->assertEquals(123452, $chapter2->getSortkey());
  }
}
?>