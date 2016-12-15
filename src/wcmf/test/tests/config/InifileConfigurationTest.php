<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2016 wemove digital solutions GmbH
 *
 * Licensed under the terms of the MIT License.
 *
 * See the LICENSE file distributed with this work for
 * additional information.
 */
namespace wcmf\test\tests\config;

use wcmf\lib\config\ConfigChangeEvent;
use wcmf\lib\core\ObjectFactory;
use wcmf\test\lib\BaseTestCase;

/**
 * InifileConfigurationTest.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class InifileConfigurationTest extends BaseTestCase {

  const INI_FILE = WCMF_BASE.'app/config/config.ini';

  protected function setUp() {
    parent::setUp();
    session_save_path(WCMF_BASE.'app/cache');
  }

  public function testConfigFileNotChanged() {
    $config = ObjectFactory::getInstance('configuration');
    $config->addConfiguration('config.ini');

    $hasChanged = false;
    ObjectFactory::getInstance('eventManager')->addListener(ConfigChangeEvent::NAME, function($event) use (&$hasChanged) {
      $hasChanged = true;
    });

    // test
    $config->addConfiguration('config.ini');
    $this->assertFalse($hasChanged);
  }

  public function testConfigFileChanged() {
    $config = ObjectFactory::getInstance('configuration');
    $config->addConfiguration('config.ini');

    $hasChanged = false;
    ObjectFactory::getInstance('eventManager')->addListener(ConfigChangeEvent::NAME, function($event) use (&$hasChanged) {
      $hasChanged = true;
    });

    sleep(5);
    $this->changeInifile(self::INI_FILE);

    // test
    $config->addConfiguration('config.ini');
    $this->assertTrue($hasChanged);

    $this->resetInifile(self::INI_FILE);
  }

  private function changeInifile($file) {
    $content = file_get_contents($file);
    $content .= "\n; test";
    file_put_contents($file, $content);
  }

  private function resetInifile($file) {
    $content = file_get_contents($file);
    $content = preg_replace("/\n; test/", "", $content);
    file_put_contents($file, $content);
  }
}
?>