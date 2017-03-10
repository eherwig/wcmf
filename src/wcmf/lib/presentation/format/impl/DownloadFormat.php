<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2017 wemove digital solutions GmbH
 *
 * Licensed under the terms of the MIT License.
 *
 * See the LICENSE file distributed with this work for
 * additional information.
 */
namespace wcmf\lib\presentation\format\impl;

use wcmf\lib\presentation\format\Format;
use wcmf\lib\presentation\Request;
use wcmf\lib\presentation\Response;
use Zend\Stdlib\DateTime;

/**
 * DownloadFormat is used for downloads. It will be automatically chosen, if
 * a file is set using the Response::setFile() method.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class DownloadFormat extends AbstractFormat {

  /**
   * @see Format::getMimeType()
   */
  public function getMimeType() {
    return 'application/octet-stream';
  }

  /**
   * @see Format::isCached()
   */
  public function isCached(Response $response) {
    $file = $response->getFile();
    return $file ? file_exists($file['filename']) : false;
  }

  /**
   * @see Format::getCacheDate()
   */
  public function getCacheDate(Response $response) {
    $file = $response->getFile();
    return $file && file_exists($file['filename']) ?
            DateTime::createFromFormat('U', filemtime($file['filename'])) : null;
  }

  /**
   * @see Format::getResponseHeaders()
   */
  public function getResponseHeaders(Response $response) {
    $file = $response->getFile();
    if ($file) {
      $response->setHeader("Content-Type", $file['type']);
      if ($file['isDownload']) {
        $response->setHeader('Content-Disposition", "attachment; filename="'.basename($file['filename']).'"');
      }
      $response->setHeader("Pragma", "no-cache");
      $response->setHeader("Expires", 0);
    }
    return $response->getHeaders();
  }

  /**
   * @see AbstractFormat::deserializeValues()
   */
  protected function deserializeValues(Request $request) {
    return $request->getValues();
  }

  /**
   * @see AbstractFormat::serializeValues()
   */
  protected function serializeValues(Response $response) {
    $file = $response->getFile();
    if ($file) {
      echo $file['content'];
    }
    return $response->getValues();
  }
}
?>
