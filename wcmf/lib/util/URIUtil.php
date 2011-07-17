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

/**
 * @class URIUtil
 * @ingroup Util
 * @brief URIUtil provides support for uri manipulation.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class URIUtil
{
  /**
   * Convert an absolute URI to a relative
   * code from http://www.webmasterworld.com/forum88/334.htm
   * @param abs_uri Absolute URI to convert
   * @param base Base URI
   */
  public static function makeRelative($abs_uri, $base)
  {
    $abs_uri = preg_replace("{^[^:]+://[^/]+}", '', $abs_uri);
    $base = preg_replace("{^[^:]+://[^/]+}", '', $base);

    $abs_array = explode('/', $abs_uri);
    $base_array = explode('/', $base);

    // remove trailing file names
    $fileName = '';
    if (strrpos($abs_uri, '/') !== strlen($abs_uri)) {
      $fileName = array_pop($abs_array);
    }
    if (strrpos($base, '/') !== strlen($base)) {
      array_pop($base_array);
    }
    // ignore common path
    while ($abs_array[0] == $base_array[0] && sizeof($abs_array) > 0)
    {
      array_shift($abs_array);
      array_shift($base_array);
    }

    // construct connecting path
    $rel_uri = str_repeat('../', sizeof($base_array)).join('/', $abs_array).'/'.$fileName;
    return $rel_uri;
  }
  /**
   * Convert a relative URI to an absolute
   * code from http://www.webmasterworld.com/forum88/334.htm
   * @param rel_uri Relative URI to convert
   * @param base Base URI
   * @param REMOVE_LEADING_DOTS True/False wether to remove leading dots or not [default: true]
   */
  public static function makeAbsolute($rel_uri, $base, $REMOVE_LEADING_DOTS = true)
  {
    preg_match("'^([^:]+://[^/]+)/'", $base, $m);
    $base_start = $m[1];
    if (preg_match("'^/'", $rel_uri)) {
      return $base_start.$rel_uri;
    }
    $base = preg_replace("{[^/]+$}", '', $base);
    $base .= $rel_uri;
    $base = preg_replace("{^[^:]+://[^/]+}", '', $base);
    $base_array = explode('/', $base);
    if (count($base_array) && !strlen($base_array[0])) {
      array_shift($base_array);
    }
    $i = 1;
    while ($i < count($base_array))
    {
      if ($base_array[$i - 1] == ".")
      {
        array_splice($base_array, $i - 1, 1);
        if ($i > 1) $i--;
      }
      elseif ($base_array[$i] == ".." && $base_array[$i - 1]!= "..")
      {
        array_splice($base_array, $i - 1, 2);
        if ($i > 1)
        {
          $i--;
          if ($i == count($base_array)) {
            array_push($base_array, "");
          }
        }
      }
      else {
        $i++;
      }
    }

    if (count($base_array) && isset($base_array[-1]) && $base_array[-1] == ".") {
      $base_array[-1] = "";
    }
    /* How do we treat the case where there are still some leading ../
       segments left? According to RFC2396 we are free to handle that
       any way we want. The default is to remove them.
     #
       "If the resulting buffer string still begins with one or more
       complete path segments of "..", then the reference is considered
       to be in error. Implementations may handle this error by
       retaining these components in the resolved path (i.e., treating
       them as part of the final URI), by removing them from the
       resolved path (i.e., discarding relative levels above the root),
       or by avoiding traversal of the reference."
     #
       http://www.faqs.org/rfcs/rfc2396.html  5.2.6.g
    */

    if ($REMOVE_LEADING_DOTS)
    {
      while (count($base_array) && preg_match("/^\.\.?$/", $base_array[0]))
        array_shift($base_array);
    }
    return($base_start . '/' . implode("/", $base_array));
  }
  /**
   * Translate a relative URI from one location to the script location.
   * For example if a file path is stored relative to location A and should be
   * translated to the script URI (location B), use
   * URIUtil::translate($filepathAsSeenFromA, $pathFromBtoA)
   * @param rel_uri Relative URI to translate as seen from base
   * @param base Base URI
   * @return An associtative array with keys 'absolute' and 'relative'
   * and the absolute and relative URI (as seen from the executed script) as values
   */
  public static function translate($rel_uri, $base)
  {
    $self = UriUtil::getProtocolStr().$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
    $path = dirname($self).'/';
    $absUrl = URIUtil::makeAbsolute($rel_uri, $path.$base);
    $relUrl = URIUtil::makeRelative($absUrl, $self);

    return array('absolute' => $absUrl, 'relative' => $relUrl);
  }
  /**
   * Check if an url is available (HTTP-Code: 200)
   * code from http://de.php.net/fsockopen
   * @param url The url to check
   * @param timeout The timeout in seconds (default: 10)
   * @return True/False wether the url is available
   */
  public static function validateUrl($url, $timeout=10)
  {
    $url_parts = @parse_url($url);
    if (empty($url_parts["host"]))
    {
      // check local relative url
      $fh = @fopen($url, "r");
      if ($fh === false) {
        return(false);
      }
      else {
        return(true);
      }
    }

    if (!empty($url_parts["path"])) {
      $documentpath = $url_parts["path"];
    }
    else {
      $documentpath = "/";
    }
    if (!empty($url_parts["query"])) {
      $documentpath .= "?" . $url_parts["query"];
    }
    $host = $url_parts["host"];
    $port = $url_parts["port"];

    // Now (HTTP-)GET $documentpath at $host";
    if (empty($port)) {
      $port = "80";
    }
    $socket = @fsockopen($host, $port, $errno, $errstr, $timeout);
    if (!$socket) {
      return(false);
    }
    else
    {
      fwrite ($socket, "HEAD ".$documentpath." HTTP/1.0\r\nHost: $host\r\n\r\n");
      $http_response = fgets($socket, 22);
      preg_match('/.+ ([0-9]{3}) .+/', $http_response, $matches);
      if (intval($matches[1]) < 400)
      {
        fclose($socket);
        return(true);
      }
      else
      {
        if (Log::isDebugEnabled(__CLASS__)) {
          Log::debug("$url: HTTP-Response: $http_response", __CLASS__);
        }
        return(false);
      }
    }
  }
  /*
   * Get the protocol string (http:// or https://)
   * @return The protocol string
   */
  public static function getProtocolStr()
  {
    if (isset($_SERVER['HTTPS']) && strlen($_SERVER['HTTPS']) > 0 && $_SERVER['HTTPS'] != 'off') {
      return 'https://';
    }
    else {
      return 'http://';
    }
  }
  /**
   * Get the current page url
   * @return The url of the page
   */
  public static function getPageURL()
  {
    $pageURL = URIUtil::getProtocolStr();
    if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    }
    else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
   }
   return $pageURL;
  }
}
?>