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
 * $Id: LocalizationTest.php 998 2009-05-29 01:29:20Z iherwig $
 */
require_once(WCMF_BASE."wcmf/lib/i18n/class.Localization.php");
require_once(WCMF_BASE."wcmf/lib/persistence/class.PersistenceFacade.php");
require_once(WCMF_BASE."wcmf/lib/persistence/class.Criteria.php");
require_once(WCMF_BASE."test/lib/WCMFTestCase.php");

/**
 * @class LocalizationTest
 * @ingroup test
 * @brief LocalizationTest tests the localization.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class LocalizationTest extends WCMFTestCase
{
  const EXPECTED_DEFAULT_LANGUAGE_CODE = 'en';
  const EXPECTED_DEFAULT_LANGUAGE_NAME = 'English';
  const TEST_OID1 = 'UserRDB:301';
  const TEST_OID2 = 'UserRDB:302';
  const TRANSLATION_TYPE = 'Translation';

  protected function setUp()
  {
    $this->runAnonymous(true);

    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $transaction->begin();
    $user1 = $this->createTestObject(ObjectId::parse(LocalizationTest::TEST_OID1), array());
    $user1->setValue('name', 'Herwig');
    $user1->setValue('firstname', 'Ingo');
    $this->createTestObject(ObjectId::parse(LocalizationTest::TEST_OID2), array());
    $transaction->commit();

    $this->runAnonymous(false);
  }

  protected function tearDown()
  {
    $this->runAnonymous(true);
    $transaction = PersistenceFacade::getInstance()->getTransaction();
    $transaction->begin();
    $this->deleteTestObject(ObjectId::parse(LocalizationTest::TEST_OID1), array());
    $this->deleteTestObject(ObjectId::parse(LocalizationTest::TEST_OID2), array());
    $localization = Localization::getInstance();
    $localization->deleteTranslation(ObjectId::parse(LocalizationTest::TEST_OID1));
    $localization->deleteTranslation(ObjectId::parse(LocalizationTest::TEST_OID2));
    $transaction->commit();
    $this->runAnonymous(false);
  }

  public function testGetDefaultLanguage()
  {
    $defaultLanguage = Localization::getInstance()->getDefaultLanguage();

    $this->assertEquals(LocalizationTest::EXPECTED_DEFAULT_LANGUAGE_CODE, $defaultLanguage,
      "The default language is '".LocalizationTest::EXPECTED_DEFAULT_LANGUAGE_CODE."'");
  }

  public function testGetSupportedLanguages()
  {
    $languages = Localization::getInstance()->getSupportedLanguages();

    $this->assertTrue(is_array($languages), "Languages is an array");

    $this->assertTrue(array_key_exists(LocalizationTest::EXPECTED_DEFAULT_LANGUAGE_CODE,
      $languages), "The language '".LocalizationTest::EXPECTED_DEFAULT_LANGUAGE_CODE."' is supported");

    $this->assertEquals(LocalizationTest::EXPECTED_DEFAULT_LANGUAGE_NAME,
        $languages[LocalizationTest::EXPECTED_DEFAULT_LANGUAGE_CODE],
        "The name of '".LocalizationTest::EXPECTED_DEFAULT_LANGUAGE_CODE."' is '".
        LocalizationTest::EXPECTED_DEFAULT_LANGUAGE_NAME."'");
  }

  public function testCreateTranslationInstance()
  {
    $instance = Localization::createTranslationInstance();
    $this->assertEquals(LocalizationTest::TRANSLATION_TYPE, $instance->getType(),
      "The translation type is '".LocalizationTest::TRANSLATION_TYPE."'");
  }

  public function testTranslation()
  {
    $this->runAnonymous(true);
    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $translationType = Localization::getTranslationType();
    $localization = Localization::getInstance();

    // create a new object
    $transaction->begin();
    $oid = ObjectId::parse(LocalizationTest::TEST_OID1);
    $testObj = $persistenceFacade->load($oid);

    // there must be no translation for the object in the translation table
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString())));
    $this->assertEquals(0, sizeof($oids),
      "There must be no translation for the object in the translation table");

    // store a translation
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [de]');
    $tmp->setValue('firstname', 'Ingo [de]');
    $localization->saveTranslation($tmp, 'de');
    $transaction->commit();

    // get a value in the default language
    $transaction->begin();
    $testObjUntranslated = $testObj->duplicate();
    $localization->loadTranslation($testObjUntranslated, $localization->getDefaultLanguage());
    $this->assertTrue($testObjUntranslated != null,
      "The untranslated object could be retrieved by Localization class");
    $this->assertEquals('Herwig', $testObjUntranslated->getValue('name'),
      "The untranslated name is 'Herwig'");

    // get a value in the translation language
    $testObjTranslated = $testObj->duplicate();
    $localization->loadTranslation($testObjTranslated, 'de');
    $this->assertTrue($testObjTranslated != null,
      "The translated object could be retrieved by Localization class");
    $this->assertEquals('Herwig [de]', $testObjTranslated->getValue('name'),
      "The translated name is 'Herwig [de]'");
    $transaction->rollback();

    $this->runAnonymous(false);
  }

  public function testTranslationForNonTranslatableValues()
  {
    $this->runAnonymous(true);
    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $translationType = Localization::getTranslationType();
    $localization = Localization::getInstance();

    // create a new object
    $transaction->begin();
    $oid = ObjectId::parse(LocalizationTest::TEST_OID1);
    $testObj = $persistenceFacade->load($oid);
    $originalValue = $testObj->getValue('name');

    // set the input type of an attribute to a not translatable type
    $testObj->setValueProperty('name', 'input_type', 'notTranslatable');

    // store a translation for an untranslatable value
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', "Herwig [de]");
    $tmp->setValue('firstname', "Ingo [de]");
    $localization->saveTranslation($tmp, 'de');
    $transaction->commit();

    // there must be no translation for the untranslatable value in the translation table
    $transaction->begin();
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString()),
      new Criteria($translationType, "attribute", "=", "name")));
    $this->assertEquals(0, sizeof($oids),
      "There must be no translation for the untranslatable value in the translation table");
    $transaction->rollback();

    $this->runAnonymous(false);
  }

  public function testDontCreateEntriesForDefaultLanguage()
  {
    $this->runAnonymous(true);
    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $translationType = Localization::getTranslationType();
    $localization = Localization::getInstance();

    // create a new object
    $transaction->begin();
    $oid = ObjectId::parse(LocalizationTest::TEST_OID1);
    $testObj = $persistenceFacade->load($oid);

    // store a translation in the default language with saveEmptyValues = true
    $tmp = $testObj->duplicate();
    $localization->saveTranslation($tmp, $localization->getDefaultLanguage(), true);
    $transaction->commit();

    // there must be no translation for the default language in the translation table
    $transaction->begin();
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString())));
    $this->assertEquals(0, sizeof($oids),
      "There must be no translation for the default language in the translation table");
    $transaction->rollback();

    $this->runAnonymous(false);
  }

  public function testDontSaveUntranslatedValues()
  {
    $this->runAnonymous(true);
    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $translationType = Localization::getTranslationType();
    $localization = Localization::getInstance();

    // create a new object
    $transaction->begin();
    $oid = ObjectId::parse(LocalizationTest::TEST_OID1);
    $testObj = $persistenceFacade->load($oid);

    // store a translation all values empty and saveEmptyValues = false
    $tmp = $testObj->duplicate();
    $tmp->clearValues();
    $localization->saveTranslation($tmp, 'de', false);
    $transaction->commit();

    // there must be no translation for the untranslated values in the translation table
    $transaction->begin();
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString())));
    $this->assertEquals(0, sizeof($oids),
      "There must be no translation for the untranslated values in the translation table");

    // store a translation all values empty and saveEmptyValues = true
    $localization->saveTranslation($tmp, 'de', true);
    $transaction->commit();

    // there must be translations for the untranslated values in the translation table
    $transaction->begin();
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString())));
    $this->assertTrue(sizeof($oids) > 0,
      "There must be translations for the untranslated values in the translation table");
    $transaction->rollback();

    $this->runAnonymous(false);
  }

  public function testDontCreateDuplicateEntries()
  {
    $this->runAnonymous(true);
    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $translationType = Localization::getTranslationType();
    $localization = Localization::getInstance();

    // create a new object
    $transaction->begin();
    $oid = ObjectId::parse(LocalizationTest::TEST_OID1);
    $testObj = $persistenceFacade->load($oid);

    // store a translation
    $tmp = $testObj->duplicate();
    $localization->saveTranslation($tmp, 'de');
    $transaction->commit();

    // store a translation a second time
    $transaction->begin();
    $tmp = $testObj->duplicate();
    $localization->saveTranslation($tmp, 'de');
    $transaction->commit();

    // there must be only one entry in the translation table
    $transaction->begin();
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString()),
      new Criteria($translationType, "attribute", "=", "name")));
    $this->assertEquals(1, sizeof($oids),
      "There must be only one entry in the translation table");
    $transaction->rollback();

    $this->runAnonymous(false);
  }

  public function testTranslationWithDefaults()
  {
    $this->runAnonymous(true);
    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $localization = Localization::getInstance();

    // create a new object
    $transaction->begin();
    $oid = ObjectId::parse(LocalizationTest::TEST_OID1);
    $testObj = $persistenceFacade->load($oid);
    $originalValue = $testObj->getValue('name');

    // store a translation for only one value
    $tmp = $testObj->duplicate();
    $tmp->clearValues();
    $tmp->setValue('firstname', "Ingo [de]");
    $localization->saveTranslation($tmp, 'de');
    $transaction->commit();

    // get the value in the translation language with loading defaults
    $transaction->begin();
    $testObjTranslated = $testObj->duplicate();
    $localization->loadTranslation($testObjTranslated, 'de', true);
    $this->assertEquals($originalValue, $testObjTranslated->getValue('name'),
      "The translated value is the default value");

    // get the value in the translation language without loading defaults
    $testObjTranslated = $testObj->duplicate();
    $localization->loadTranslation($testObjTranslated, 'de', false);
    $this->assertEquals(0, strlen($testObjTranslated->getValue('name')),
      "The translated value is empty");
    $transaction->rollback();

    $this->runAnonymous(false);
  }

  public function testDeleteTranslation()
  {
    $this->runAnonymous(true);
    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $translationType = Localization::getTranslationType();
    $localization = Localization::getInstance();

    // create a new object
    $transaction->begin();
    $oid = ObjectId::parse(LocalizationTest::TEST_OID1);
    $testObj = $persistenceFacade->load($oid);

    // store a translation in two languages
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [de]');
    $localization->saveTranslation($tmp, 'de', true);
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [it]');
    $localization->saveTranslation($tmp, 'it', true);
    $transaction->commit();

    // delete one translation
    $transaction->begin();
    $localization->deleteTranslation($oid, 'de');
    $transaction->commit();

    // there must be no entry in the translation table for the deleted language
    $transaction->begin();
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString()),
        new Criteria($translationType, "language", "=", "de")));
    $this->assertEquals(0, sizeof($oids),
      "There must be no entry in the translation table for the deleted language");
    // there must be entries in the translation table for the not deleted language
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString()),
        new Criteria($translationType, "language", "=", "it")));
    $this->assertTrue(sizeof($oids) > 0,
      "There must be entries in the translation table for the not deleted language");

    // store a translation in two languages
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [de]');
    $localization->saveTranslation($tmp, 'de', true);
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [it]');
    $localization->saveTranslation($tmp, 'it', true);
    $transaction->commit();

    // delete all translations
    $transaction->begin();
    $localization->deleteTranslation($oid);
    $transaction->commit();

    // there must be no entry in the translation table for the object
    $transaction->begin();
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "objectid", "=", $oid->__toString())));
    $this->assertEquals(0, sizeof($oids),
      "There must be no entry in the translation table for the object");
    $transaction->rollback();

    $this->runAnonymous(false);
  }

  public function testDeleteLanguage()
  {
    $this->runAnonymous(true);
    $persistenceFacade = PersistenceFacade::getInstance();
    $transaction = $persistenceFacade->getTransaction();
    $translationType = Localization::getTranslationType();
    $localization = Localization::getInstance();

    // create a new object
    $transaction->begin();
    $oid1 = ObjectId::parse(LocalizationTest::TEST_OID1);
    $testObj = $persistenceFacade->load($oid1);

    // store a translation in two languages
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [de]');
    $localization->saveTranslation($tmp, 'de', true);
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [it]');
    $localization->saveTranslation($tmp, 'it', true);
    $transaction->commit();

    // create a new object
    $transaction->begin();
    $oid2 = ObjectId::parse(LocalizationTest::TEST_OID2);
    $testObj = $persistenceFacade->load($oid2);

    // store a translation in two languages
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [de]');
    $localization->saveTranslation($tmp, 'de', true);
    $tmp = $testObj->duplicate();
    $tmp->setValue('name', 'Herwig [it]');
    $localization->saveTranslation($tmp, 'it', true);
    $transaction->commit();

    // delete one language
    $transaction->begin();
    $localization->deleteLanguage('de');
    $transaction->commit();

    // there must be no entries in the translation table for the deleted language
    $transaction->begin();
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "language", "=", "de")));
    $this->assertEquals(0, sizeof($oids),
      "There must be no entries in the translation table for the deleted language");
    // there must be entries in the translation table for the not deleted language
    $oids = $persistenceFacade->getOIDs($translationType, array(new Criteria($translationType, "language", "=", "it")));
    $this->assertTrue(sizeof($oids) > 0,
      "There must be entries in the translation table for the not deleted language");
    $transaction->rollback();

    $this->runAnonymous(false);
  }
}
?>