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

use wcmf\lib\presentation\Controller;
use wcmf\lib\service\SoapServer;

/**
 * Global server instance used by the generated soap interface
 */
$server = null;

/**
 * SOAPController handles SOAP requests. The controller delegates action
 * processing to a global instance of wcmf::lib::service::SoapServer.
 *
 * The controller supports the following actions:
 *
 * <div class="controller-action">
 * <div> __Action__ _default_ </div>
 * <div>
 * Handle action according to soap request.
 * </div>
 * </div>
 *
 * The controller expects the definition of the soap interface in a file called
 * __soap-interface.php__ in the application directory. The definition is done
 * by adding types and methods to the global `$server` instance
 *
 @code
   // add type to soap interface
   $server->wsdl->addComplexType(...);

   // add method to soap interface
   $server->register();
 @endcode
 *
 * @see http://sourceforge.net/projects/nusoap/
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class SOAPController extends Controller {

  /**
   * @see Controller::doExecute()
   */
  protected function doExecute() {
    global $server;

    // instantiate server
    $server = new SoapServer();

    // register search method
    $server->register('wcmf\application\controller\SOAPController.search',
      array('query' => 'xsd:string'), array('return' => 'tns:SearchResultList'),
      $server::TNS, $server->wsdl->endpoint.'#search', 'document', 'literal'
    );

    // include the generated interface
    require("soap-interface.php");

    // invoke the service
    if (!isset($HTTP_RAW_POST_DATA)) {
      $HTTP_RAW_POST_DATA = implode("\r\n", file('php://input'));
    }
    $server->service($HTTP_RAW_POST_DATA);
    exit;
  }

  /**
   * Search
   * @param $query The search term
   * @return Array of SearchResultItem on success
   */
  public static function search($query) {
    global $server;
    $response = $server->doCall('search', array('query' => $query));
    $result = array();
    foreach ($response->getValue('list') as $item) {
      $result[] = array('type' => $item['type'], 'oid' => $item['oid'],
        'displayValue' => $item['displayValue'], 'summary' => $item['summary']
      );
    }
    return array('return' => $result);
  }
}
?>