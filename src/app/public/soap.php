<?php
/**
 * This file was generated by ChronosGenerator  from cwm-export.uml.
 * Manual modifications should be placed inside the protected regions.
 * NOTE: This file was created in the application root directory to
 *       ensure that everything is working correctly
 */
error_reporting(E_ALL ^ E_NOTICE);
require_once("base_dir.php");
require_once(WCMF_BASE."wcmf/lib/core/ClassLoader.php");

use wcmf\lib\service\SoapServer;
// PROTECTED REGION ID(/soap/Import) ENABLED START
// PROTECTED REGION END

// instantiate server
$server = new SoapServer();

// register search method
$server->register('search',
  array('query' => 'xsd:string'), array('return' => 'tns:SearchResultList'),
  $server::TNS, $server->wsdl->endpoint.'#search', 'document', 'literal'
);

/**
 * Search
 * @param query The search term
 * @return Array of SearchResultItem
 */
function search($query) {
  global $server;
  $response = $server->doCall('search', array('query' => $query), 'list');
  if ($response) {
    $result = array();
    foreach ($response->getValue('list') as $item) {
      $result[] = array('type' => $item->getType(), 'oid' => $item->getOID()->__toString(),
        'displayValue' => $item->getValue('displayValue'), 'summary' => $item->getValue('summary')
      );
    }
    return array('return' => $result);
  }
}

/**
 * WSDL definition for Publisher
 */
$server->wsdl->addComplexType('Publisher', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'Book' => array('name' => 'Book', 'type' => 'tns:BookList'),
        'NMPublisherAuthor' => array('name' => 'NMPublisherAuthor', 'type' => 'tns:NMPublisherAuthorList'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('PublisherList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Publisher[]')
    ),
    'tns:Publisher'
);

/**
 * WSDL definition for Author
 */
$server->wsdl->addComplexType('Author', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
        'NMPublisherAuthor' => array('name' => 'NMPublisherAuthor', 'type' => 'tns:NMPublisherAuthorList'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('AuthorList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Author[]')
    ),
    'tns:Author'
);
$server->register('getAuthorList',
  array(),
  array('return'=>'tns:AuthorList'), $server::TNS, $server->wsdl->endpoint.'#getAuthorList', 'document', 'literal');

$server->register('createAuthor',
  array('Author'=>'tns:Author'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#createAuthor', 'document', 'literal');

$server->register('readAuthor',
  array('oid'=>'xsd:string', 'depth'=>'xsd:integer'),
  array('return'=>'tns:Author'), $server::TNS, $server->wsdl->endpoint.'#readAuthor', 'document', 'literal');

$server->register('updateAuthor',
  array('Author'=>'tns:Author', 'oid'=>'xsd:string'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#updateAuthor', 'document', 'literal');

$server->register('deleteAuthor',
  array('oid'=>'xsd:string'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deleteAuthor', 'document', 'literal');

/**
 * WSDL definition for Book
 */
$server->wsdl->addComplexType('Book', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_publisher_id' => array('name' => 'fk_publisher_id', 'type' => 'xsd:string'),
        'title' => array('name' => 'title', 'type' => 'xsd:string'),
        'description' => array('name' => 'description', 'type' => 'xsd:string'),
        'year' => array('name' => 'year', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('BookList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Book[]')
    ),
    'tns:Book'
);
$server->register('getBookList',
  array(),
  array('return'=>'tns:BookList'), $server::TNS, $server->wsdl->endpoint.'#getBookList', 'document', 'literal');

$server->register('createBook',
  array('Book'=>'tns:Book'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#createBook', 'document', 'literal');

$server->register('readBook',
  array('oid'=>'xsd:string', 'depth'=>'xsd:integer'),
  array('return'=>'tns:Book'), $server::TNS, $server->wsdl->endpoint.'#readBook', 'document', 'literal');

$server->register('updateBook',
  array('Book'=>'tns:Book', 'oid'=>'xsd:string'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#updateBook', 'document', 'literal');

$server->register('deleteBook',
  array('oid'=>'xsd:string'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deleteBook', 'document', 'literal');

/**
 * WSDL definition for Chapter
 */
$server->wsdl->addComplexType('Chapter', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_chapter_id' => array('name' => 'fk_chapter_id', 'type' => 'xsd:string'),
        'fk_book_id' => array('name' => 'fk_book_id', 'type' => 'xsd:string'),
        'fk_author_id' => array('name' => 'fk_author_id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'sortkey' => array('name' => 'sortkey', 'type' => 'xsd:string'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
        'Image' => array('name' => 'Image', 'type' => 'tns:ImageList'),
        'Image' => array('name' => 'Image', 'type' => 'tns:ImageList'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('ChapterList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Chapter[]')
    ),
    'tns:Chapter'
);
$server->register('getChapterList',
  array(),
  array('return'=>'tns:ChapterList'), $server::TNS, $server->wsdl->endpoint.'#getChapterList', 'document', 'literal');

$server->register('createChapter',
  array('Chapter'=>'tns:Chapter'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#createChapter', 'document', 'literal');

$server->register('readChapter',
  array('oid'=>'xsd:string', 'depth'=>'xsd:integer'),
  array('return'=>'tns:Chapter'), $server::TNS, $server->wsdl->endpoint.'#readChapter', 'document', 'literal');

$server->register('updateChapter',
  array('Chapter'=>'tns:Chapter', 'oid'=>'xsd:string'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#updateChapter', 'document', 'literal');

$server->register('deleteChapter',
  array('oid'=>'xsd:string'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deleteChapter', 'document', 'literal');

/**
 * WSDL definition for Image
 */
$server->wsdl->addComplexType('Image', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_chapter_id' => array('name' => 'fk_chapter_id', 'type' => 'xsd:string'),
        'fk_titlechapter_id' => array('name' => 'fk_titlechapter_id', 'type' => 'xsd:string'),
        'filename' => array('name' => 'filename', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'sortkey' => array('name' => 'sortkey', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('ImageList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Image[]')
    ),
    'tns:Image'
);
$server->register('getImageList',
  array(),
  array('return'=>'tns:ImageList'), $server::TNS, $server->wsdl->endpoint.'#getImageList', 'document', 'literal');

$server->register('createImage',
  array('Image'=>'tns:Image'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#createImage', 'document', 'literal');

$server->register('readImage',
  array('oid'=>'xsd:string', 'depth'=>'xsd:integer'),
  array('return'=>'tns:Image'), $server::TNS, $server->wsdl->endpoint.'#readImage', 'document', 'literal');

$server->register('updateImage',
  array('Image'=>'tns:Image', 'oid'=>'xsd:string'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#updateImage', 'document', 'literal');

$server->register('deleteImage',
  array('oid'=>'xsd:string'),
  array('return'=>'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deleteImage', 'document', 'literal');

/**
 * WSDL definition for EntityBase
 */
$server->wsdl->addComplexType('EntityBase', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('EntityBaseList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:EntityBase[]')
    ),
    'tns:EntityBase'
);

/**
 * WSDL definition for NMPublisherAuthor
 */
$server->wsdl->addComplexType('NMPublisherAuthor', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_author_id' => array('name' => 'fk_author_id', 'type' => 'xsd:string'),
        'fk_publisher_id' => array('name' => 'fk_publisher_id', 'type' => 'xsd:string'),
        'sortkey' => array('name' => 'sortkey', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('NMPublisherAuthorList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:NMPublisherAuthor[]')
    ),
    'tns:NMPublisherAuthor'
);

/**
 * WSDL definition for DBSequence
 */
$server->wsdl->addComplexType('DBSequence', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('DBSequenceList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:DBSequence[]')
    ),
    'tns:DBSequence'
);

/**
 * WSDL definition for Language
 */
$server->wsdl->addComplexType('Language', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'code' => array('name' => 'code', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('LanguageList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Language[]')
    ),
    'tns:Language'
);

/**
 * WSDL definition for Locktable
 */
$server->wsdl->addComplexType('Locktable', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_user_id' => array('name' => 'fk_user_id', 'type' => 'xsd:string'),
        'objectid' => array('name' => 'objectid', 'type' => 'xsd:string'),
        'sessionid' => array('name' => 'sessionid', 'type' => 'xsd:string'),
        'since' => array('name' => 'since', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('LocktableList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Locktable[]')
    ),
    'tns:Locktable'
);

/**
 * WSDL definition for Role
 */
$server->wsdl->addComplexType('Role', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'NMUserRole' => array('name' => 'NMUserRole', 'type' => 'tns:NMUserRoleList'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('RoleList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Role[]')
    ),
    'tns:Role'
);

/**
 * WSDL definition for Translation
 */
$server->wsdl->addComplexType('Translation', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'objectid' => array('name' => 'objectid', 'type' => 'xsd:string'),
        'attribute' => array('name' => 'attribute', 'type' => 'xsd:string'),
        'translation' => array('name' => 'translation', 'type' => 'xsd:string'),
        'language' => array('name' => 'language', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('TranslationList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:Translation[]')
    ),
    'tns:Translation'
);

/**
 * WSDL definition for UserConfig
 */
$server->wsdl->addComplexType('UserConfig', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_user_id' => array('name' => 'fk_user_id', 'type' => 'xsd:string'),
        'key' => array('name' => 'key', 'type' => 'xsd:string'),
        'val' => array('name' => 'val', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('UserConfigList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:UserConfig[]')
    ),
    'tns:UserConfig'
);

/**
 * WSDL definition for User
 */
$server->wsdl->addComplexType('User', 'complexType', 'struct', 'sequence', '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'login' => array('name' => 'login', 'type' => 'xsd:string'),
        'password' => array('name' => 'password', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'firstname' => array('name' => 'firstname', 'type' => 'xsd:string'),
        'config' => array('name' => 'config', 'type' => 'xsd:string'),
        'Locktable' => array('name' => 'Locktable', 'type' => 'tns:LocktableList'),
        'UserConfig' => array('name' => 'UserConfig', 'type' => 'tns:UserConfigList'),
        'NMUserRole' => array('name' => 'NMUserRole', 'type' => 'tns:NMUserRoleList'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('UserList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:User[]')
    ),
    'tns:User'
);

/**
 * WSDL definition for NMUserRole
 */
$server->wsdl->addComplexType('NMUserRole', 'complexType', 'struct', 'sequence', '',
    array(
        'fk_user_id' => array('name' => 'fk_user_id', 'type' => 'xsd:string'),
        'fk_role_id' => array('name' => 'fk_role_id', 'type' => 'xsd:string'),
        'parentoids' => array('name' => 'parentoids', 'type' => 'tns:OidList'),
        'childoids' => array('name' => 'childoids', 'type' => 'tns:OidList')
    )
);
$server->wsdl->addComplexType('NMUserRoleList', 'complexType', 'array', '', 'SOAP-ENC:Array', array(),
    array(
        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:NMUserRole[]')
    ),
    'tns:NMUserRole'
);

/**
 * SOAP Method getAuthorList
 * @return Array of tns:Author instances
 */
function getAuthorList() {
  global $server;
// PROTECTED REGION ID(soap/Methods/getAuthorList) ENABLED START
  $response = $server->doCall('list', array());
  return array('return' => $response->getValue('objects'));
// PROTECTED REGION END
}

/**
 * SOAP Method createAuthor
 * @param Author The serialized object data
 * @return String (object id)
 */
function createAuthor($Author) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createAuthor) ENABLED START
  $response = $server->doCall('create', array($server->getDummyOid('Author') => $Author));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}

/**
 * SOAP Method readAuthor
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Author
 */
function readAuthor($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readAuthor) ENABLED START
  $response = $server->doCall('read', array('oid' => $oid, 'depth' => $depth));
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}

/**
 * SOAP Method updateAuthor
 * @param Author The serialized object data
 * @param oid The object id of the object to update
 * @return tns:Author
 */
function updateAuthor($Author, $oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updateAuthor) ENABLED START
  $response = $server->doCall('update', array($oid => $Author));
  return array('return' => $response->getValue($oid));
// PROTECTED REGION END
}

/**
 * SOAP Method deleteAuthor
 * @param oid The object id of the object to delete
 * @return String (object id)
 */
function deleteAuthor($oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/deleteAuthor) ENABLED START
  $response = $server->doCall('delete', array('oid' => $oid));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}

/**
 * SOAP Method getBookList
 * @return Array of tns:Book instances
 */
function getBookList() {
  global $server;
// PROTECTED REGION ID(soap/Methods/getBookList) ENABLED START
  $response = $server->doCall('list', array());
  return array('return' => $response->getValue('objects'));
// PROTECTED REGION END
}

/**
 * SOAP Method createBook
 * @param Book The serialized object data
 * @return String (object id)
 */
function createBook($Book) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createBook) ENABLED START
  $response = $server->doCall('create', array($server->getDummyOid('Book') => $Book));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}

/**
 * SOAP Method readBook
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Book
 */
function readBook($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readBook) ENABLED START
  $response = $server->doCall('read', array('oid' => $oid, 'depth' => $depth));
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}

/**
 * SOAP Method updateBook
 * @param Book The serialized object data
 * @param oid The object id of the object to update
 * @return tns:Book
 */
function updateBook($Book, $oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updateBook) ENABLED START
  $response = $server->doCall('update', array($oid => $Book));
  return array('return' => $response->getValue($oid));
// PROTECTED REGION END
}

/**
 * SOAP Method deleteBook
 * @param oid The object id of the object to delete
 * @return String (object id)
 */
function deleteBook($oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/deleteBook) ENABLED START
  $response = $server->doCall('delete', array('oid' => $oid));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}

/**
 * SOAP Method getChapterList
 * @return Array of tns:Chapter instances
 */
function getChapterList() {
  global $server;
// PROTECTED REGION ID(soap/Methods/getChapterList) ENABLED START
  $response = $server->doCall('list', array());
  return array('return' => $response->getValue('objects'));
// PROTECTED REGION END
}

/**
 * SOAP Method createChapter
 * @param Chapter The serialized object data
 * @return String (object id)
 */
function createChapter($Chapter) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createChapter) ENABLED START
  $response = $server->doCall('create', array($server->getDummyOid('Chapter') => $Chapter));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}

/**
 * SOAP Method readChapter
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Chapter
 */
function readChapter($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readChapter) ENABLED START
  $response = $server->doCall('read', array('oid' => $oid, 'depth' => $depth));
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}

/**
 * SOAP Method updateChapter
 * @param Chapter The serialized object data
 * @param oid The object id of the object to update
 * @return tns:Chapter
 */
function updateChapter($Chapter, $oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updateChapter) ENABLED START
  $response = $server->doCall('update', array($oid => $Chapter));
  return array('return' => $response->getValue($oid));
// PROTECTED REGION END
}

/**
 * SOAP Method deleteChapter
 * @param oid The object id of the object to delete
 * @return String (object id)
 */
function deleteChapter($oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/deleteChapter) ENABLED START
  $response = $server->doCall('delete', array('oid' => $oid));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}

/**
 * SOAP Method getImageList
 * @return Array of tns:Image instances
 */
function getImageList() {
  global $server;
// PROTECTED REGION ID(soap/Methods/getImageList) ENABLED START
  $response = $server->doCall('list', array());
  return array('return' => $response->getValue('objects'));
// PROTECTED REGION END
}

/**
 * SOAP Method createImage
 * @param Image The serialized object data
 * @return String (object id)
 */
function createImage($Image) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createImage) ENABLED START
  $response = $server->doCall('create', array($server->getDummyOid('Image') => $Image));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}

/**
 * SOAP Method readImage
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Image
 */
function readImage($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readImage) ENABLED START
  $response = $server->doCall('read', array('oid' => $oid, 'depth' => $depth));
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}

/**
 * SOAP Method updateImage
 * @param Image The serialized object data
 * @param oid The object id of the object to update
 * @return tns:Image
 */
function updateImage($Image, $oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updateImage) ENABLED START
  $response = $server->doCall('update', array($oid => $Image));
  return array('return' => $response->getValue($oid));
// PROTECTED REGION END
}

/**
 * SOAP Method deleteImage
 * @param oid The object id of the object to delete
 * @return String (object id)
 */
function deleteImage($oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/deleteImage) ENABLED START
  $response = $server->doCall('delete', array('oid' => $oid));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}

// PROTECTED REGION ID(/soap/Body) ENABLED START
// invoke the service
if (!isset($HTTP_RAW_POST_DATA)) {
  $HTTP_RAW_POST_DATA = implode("\r\n", file('php://input'));
}
$server->service($HTTP_RAW_POST_DATA);
// PROTECTED REGION END
?>
