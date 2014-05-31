<?php
/**
 * This file was generated by ChronosGenerator  from model.uml.
 * Manual modifications should be placed inside the protected regions.
 * NOTE: This file was created in the application root directory to 
 *       ensure that everything is working correctly
 */
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
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
 * @return Array of SearchResultItem on success
 */
function search($query) {
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

/**
 * WSDL definition for DBSequence
 */
$server->wsdl->addComplexType('DBSequence', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
    )
);
$server->wsdl->addComplexType('DBSequenceList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:DBSequence[]')
    ),
    'tns:DBSequence'
);
$server->wsdl->addComplexType('DBSequenceListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:DBSequenceList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for Locktable
 */
$server->wsdl->addComplexType('Locktable', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_user_id' => array('name' => 'fk_user_id', 'type' => 'xsd:string'),
        'objectid' => array('name' => 'objectid', 'type' => 'xsd:string'),
        'sessionid' => array('name' => 'sessionid', 'type' => 'xsd:string'),
        'since' => array('name' => 'since', 'type' => 'xsd:string'),
        'User' => array('name' => 'User', 'type' => 'tns:UserList'),
    )
);
$server->wsdl->addComplexType('LocktableList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Locktable[]')
    ),
    'tns:Locktable'
);
$server->wsdl->addComplexType('LocktableListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:LocktableList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for Language
 */
$server->wsdl->addComplexType('Language', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'code' => array('name' => 'code', 'type' => 'xsd:string'),
    )
);
$server->wsdl->addComplexType('LanguageList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Language[]')
    ),
    'tns:Language'
);
$server->wsdl->addComplexType('LanguageListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:LanguageList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for Translation
 */
$server->wsdl->addComplexType('Translation', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'objectid' => array('name' => 'objectid', 'type' => 'xsd:string'),
        'attribute' => array('name' => 'attribute', 'type' => 'xsd:string'),
        'translation' => array('name' => 'translation', 'type' => 'xsd:string'),
        'language' => array('name' => 'language', 'type' => 'xsd:string'),
    )
);
$server->wsdl->addComplexType('TranslationList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Translation[]')
    ),
    'tns:Translation'
);
$server->wsdl->addComplexType('TranslationListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:TranslationList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for User
 */
$server->wsdl->addComplexType('User', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'login' => array('name' => 'login', 'type' => 'xsd:string'),
        'password' => array('name' => 'password', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'firstname' => array('name' => 'firstname', 'type' => 'xsd:string'),
        'config' => array('name' => 'config', 'type' => 'xsd:string'),
        'Locktable' => array('name' => 'Locktable', 'type' => 'tns:LocktableList'),
        'UserConfig' => array('name' => 'UserConfig', 'type' => 'tns:UserConfigList'),
        'Role' => array('name' => 'Role', 'type' => 'tns:RoleList'),
    )
);
$server->wsdl->addComplexType('UserList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:User[]')
    ),
    'tns:User'
);
$server->wsdl->addComplexType('UserListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:UserList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for UserConfig
 */
$server->wsdl->addComplexType('UserConfig', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_user_id' => array('name' => 'fk_user_id', 'type' => 'xsd:string'),
        'key' => array('name' => 'key', 'type' => 'xsd:string'),
        'val' => array('name' => 'val', 'type' => 'xsd:string'),
        'User' => array('name' => 'User', 'type' => 'tns:UserList'),
    )
);
$server->wsdl->addComplexType('UserConfigList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:UserConfig[]')
    ),
    'tns:UserConfig'
);
$server->wsdl->addComplexType('UserConfigListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:UserConfigList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for Role
 */
$server->wsdl->addComplexType('Role', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'User' => array('name' => 'User', 'type' => 'tns:UserList'),
    )
);
$server->wsdl->addComplexType('RoleList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Role[]')
    ),
    'tns:Role'
);
$server->wsdl->addComplexType('RoleListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:RoleList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for NMUserRole
 */
$server->wsdl->addComplexType('NMUserRole', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'fk_role_id' => array('name' => 'fk_role_id', 'type' => 'xsd:string'),
        'fk_user_id' => array('name' => 'fk_user_id', 'type' => 'xsd:string'),
        'User' => array('name' => 'User', 'type' => 'tns:UserList'),
        'Role' => array('name' => 'Role', 'type' => 'tns:RoleList'),
    )
);
$server->wsdl->addComplexType('NMUserRoleList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:NMUserRole[]')
    ),
    'tns:NMUserRole'
);
$server->wsdl->addComplexType('NMUserRoleListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:NMUserRoleList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for EntityBase
 */
$server->wsdl->addComplexType('EntityBase', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
    )
);
$server->wsdl->addComplexType('EntityBaseList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:EntityBase[]')
    ),
    'tns:EntityBase'
);
$server->wsdl->addComplexType('EntityBaseListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:EntityBaseList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**
 * WSDL definition for Publisher
 */
$server->wsdl->addComplexType('Publisher', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'Book' => array('name' => 'Book', 'type' => 'tns:BookList'),
        'Author' => array('name' => 'Author', 'type' => 'tns:AuthorList'),
    )
);
$server->wsdl->addComplexType('PublisherList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Publisher[]')
    ),
    'tns:Publisher'
);
$server->wsdl->addComplexType('PublisherListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:PublisherList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);
$server->register('getPublisherList',
  array('limit' => 'xsd:integer', 'offset' => 'xsd:integer', 'sortFieldName' => 'xsd:string', 'sortDirection' => 'xsd:string', 'query' => 'xsd:string'),
  array('return' => 'tns:PublisherListResult'), $server::TNS, $server->wsdl->endpoint.'#getPublisherList', 'document', 'literal');
  
$server->register('createPublisher',
  array('Publisher' => 'tns:Publisher'),
  array('return' => 'tns:Publisher'), $server::TNS, $server->wsdl->endpoint.'#createPublisher', 'document', 'literal');
  
$server->register('readPublisher',
  array('oid' => 'xsd:string', 'depth' => 'xsd:integer'),
  array('return' => 'tns:Publisher'), $server::TNS, $server->wsdl->endpoint.'#readPublisher', 'document', 'literal');
  
$server->register('updatePublisher',
  array('Publisher' => 'tns:Publisher'),
  array('return' => 'tns:Publisher'), $server::TNS, $server->wsdl->endpoint.'#updatePublisher', 'document', 'literal');
  
$server->register('deletePublisher',
  array('oid' => 'xsd:string'),
  array('return' => 'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deletePublisher', 'document', 'literal');

/**
 * WSDL definition for Author
 */
$server->wsdl->addComplexType('Author', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
        'Publisher' => array('name' => 'Publisher', 'type' => 'tns:PublisherList'),
    )
);
$server->wsdl->addComplexType('AuthorList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Author[]')
    ),
    'tns:Author'
);
$server->wsdl->addComplexType('AuthorListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:AuthorList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);
$server->register('getAuthorList',
  array('limit' => 'xsd:integer', 'offset' => 'xsd:integer', 'sortFieldName' => 'xsd:string', 'sortDirection' => 'xsd:string', 'query' => 'xsd:string'),
  array('return' => 'tns:AuthorListResult'), $server::TNS, $server->wsdl->endpoint.'#getAuthorList', 'document', 'literal');
  
$server->register('createAuthor',
  array('Author' => 'tns:Author'),
  array('return' => 'tns:Author'), $server::TNS, $server->wsdl->endpoint.'#createAuthor', 'document', 'literal');
  
$server->register('readAuthor',
  array('oid' => 'xsd:string', 'depth' => 'xsd:integer'),
  array('return' => 'tns:Author'), $server::TNS, $server->wsdl->endpoint.'#readAuthor', 'document', 'literal');
  
$server->register('updateAuthor',
  array('Author' => 'tns:Author'),
  array('return' => 'tns:Author'), $server::TNS, $server->wsdl->endpoint.'#updateAuthor', 'document', 'literal');
  
$server->register('deleteAuthor',
  array('oid' => 'xsd:string'),
  array('return' => 'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deleteAuthor', 'document', 'literal');

/**
 * WSDL definition for Book
 */
$server->wsdl->addComplexType('Book', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_publisher_id' => array('name' => 'fk_publisher_id', 'type' => 'xsd:string'),
        'title' => array('name' => 'title', 'type' => 'xsd:string'),
        'description' => array('name' => 'description', 'type' => 'xsd:string'),
        'year' => array('name' => 'year', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'Publisher' => array('name' => 'Publisher', 'type' => 'tns:PublisherList'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
    )
);
$server->wsdl->addComplexType('BookList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Book[]')
    ),
    'tns:Book'
);
$server->wsdl->addComplexType('BookListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:BookList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);
$server->register('getBookList',
  array('limit' => 'xsd:integer', 'offset' => 'xsd:integer', 'sortFieldName' => 'xsd:string', 'sortDirection' => 'xsd:string', 'query' => 'xsd:string'),
  array('return' => 'tns:BookListResult'), $server::TNS, $server->wsdl->endpoint.'#getBookList', 'document', 'literal');
  
$server->register('createBook',
  array('Book' => 'tns:Book'),
  array('return' => 'tns:Book'), $server::TNS, $server->wsdl->endpoint.'#createBook', 'document', 'literal');
  
$server->register('readBook',
  array('oid' => 'xsd:string', 'depth' => 'xsd:integer'),
  array('return' => 'tns:Book'), $server::TNS, $server->wsdl->endpoint.'#readBook', 'document', 'literal');
  
$server->register('updateBook',
  array('Book' => 'tns:Book'),
  array('return' => 'tns:Book'), $server::TNS, $server->wsdl->endpoint.'#updateBook', 'document', 'literal');
  
$server->register('deleteBook',
  array('oid' => 'xsd:string'),
  array('return' => 'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deleteBook', 'document', 'literal');

/**
 * WSDL definition for Chapter
 */
$server->wsdl->addComplexType('Chapter', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_chapter_id' => array('name' => 'fk_chapter_id', 'type' => 'xsd:string'),
        'fk_book_id' => array('name' => 'fk_book_id', 'type' => 'xsd:string'),
        'fk_author_id' => array('name' => 'fk_author_id', 'type' => 'xsd:string'),
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'author_name' => array('name' => 'author_name', 'type' => 'xsd:string'),
        'sortkey' => array('name' => 'sortkey', 'type' => 'xsd:string'),
        'Author' => array('name' => 'Author', 'type' => 'tns:AuthorList'),
        'Book' => array('name' => 'Book', 'type' => 'tns:BookList'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
        'Image' => array('name' => 'Image', 'type' => 'tns:ImageList'),
        'Image' => array('name' => 'Image', 'type' => 'tns:ImageList'),
    )
);
$server->wsdl->addComplexType('ChapterList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Chapter[]')
    ),
    'tns:Chapter'
);
$server->wsdl->addComplexType('ChapterListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:ChapterList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);
$server->register('getChapterList',
  array('limit' => 'xsd:integer', 'offset' => 'xsd:integer', 'sortFieldName' => 'xsd:string', 'sortDirection' => 'xsd:string', 'query' => 'xsd:string'),
  array('return' => 'tns:ChapterListResult'), $server::TNS, $server->wsdl->endpoint.'#getChapterList', 'document', 'literal');
  
$server->register('createChapter',
  array('Chapter' => 'tns:Chapter'),
  array('return' => 'tns:Chapter'), $server::TNS, $server->wsdl->endpoint.'#createChapter', 'document', 'literal');
  
$server->register('readChapter',
  array('oid' => 'xsd:string', 'depth' => 'xsd:integer'),
  array('return' => 'tns:Chapter'), $server::TNS, $server->wsdl->endpoint.'#readChapter', 'document', 'literal');
  
$server->register('updateChapter',
  array('Chapter' => 'tns:Chapter'),
  array('return' => 'tns:Chapter'), $server::TNS, $server->wsdl->endpoint.'#updateChapter', 'document', 'literal');
  
$server->register('deleteChapter',
  array('oid' => 'xsd:string'),
  array('return' => 'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deleteChapter', 'document', 'literal');

/**
 * WSDL definition for Image
 */
$server->wsdl->addComplexType('Image', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_chapter_id' => array('name' => 'fk_chapter_id', 'type' => 'xsd:string'),
        'fk_titlechapter_id' => array('name' => 'fk_titlechapter_id', 'type' => 'xsd:string'),
        'filename' => array('name' => 'filename', 'type' => 'xsd:string'),
        'created' => array('name' => 'created', 'type' => 'xsd:string'),
        'creator' => array('name' => 'creator', 'type' => 'xsd:string'),
        'modified' => array('name' => 'modified', 'type' => 'xsd:string'),
        'last_editor' => array('name' => 'last_editor', 'type' => 'xsd:string'),
        'sortkey' => array('name' => 'sortkey', 'type' => 'xsd:string'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
        'Chapter' => array('name' => 'Chapter', 'type' => 'tns:ChapterList'),
    )
);
$server->wsdl->addComplexType('ImageList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Image[]')
    ),
    'tns:Image'
);
$server->wsdl->addComplexType('ImageListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:ImageList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);
$server->register('getImageList',
  array('limit' => 'xsd:integer', 'offset' => 'xsd:integer', 'sortFieldName' => 'xsd:string', 'sortDirection' => 'xsd:string', 'query' => 'xsd:string'),
  array('return' => 'tns:ImageListResult'), $server::TNS, $server->wsdl->endpoint.'#getImageList', 'document', 'literal');
  
$server->register('createImage',
  array('Image' => 'tns:Image'),
  array('return' => 'tns:Image'), $server::TNS, $server->wsdl->endpoint.'#createImage', 'document', 'literal');
  
$server->register('readImage',
  array('oid' => 'xsd:string', 'depth' => 'xsd:integer'),
  array('return' => 'tns:Image'), $server::TNS, $server->wsdl->endpoint.'#readImage', 'document', 'literal');
  
$server->register('updateImage',
  array('Image' => 'tns:Image'),
  array('return' => 'tns:Image'), $server::TNS, $server->wsdl->endpoint.'#updateImage', 'document', 'literal');
  
$server->register('deleteImage',
  array('oid' => 'xsd:string'),
  array('return' => 'xsd:string'), $server::TNS, $server->wsdl->endpoint.'#deleteImage', 'document', 'literal');

/**
 * WSDL definition for NMPublisherAuthor
 */
$server->wsdl->addComplexType('NMPublisherAuthor', 'complexType', 'struct', 'sequence', '',
    array(
        'oid' => array('name' => 'oid', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:string'),
        'fk_author_id' => array('name' => 'fk_author_id', 'type' => 'xsd:string'),
        'fk_publisher_id' => array('name' => 'fk_publisher_id', 'type' => 'xsd:string'),
        'sortkey' => array('name' => 'sortkey', 'type' => 'xsd:string'),
        'Publisher' => array('name' => 'Publisher', 'type' => 'tns:PublisherList'),
        'Author' => array('name' => 'Author', 'type' => 'tns:AuthorList'),
    )
);
$server->wsdl->addComplexType('NMPublisherAuthorList', 'complexType', 'array', '', 'SOAP-ENC:Array',
    array(),
    array(
        array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:NMPublisherAuthor[]')
    ),
    'tns:NMPublisherAuthor'
);
$server->wsdl->addComplexType('NMPublisherAuthorListResult', 'complexType', 'struct', 'sequence', '',
    array(
        'list' => array('name' => 'list', 'type' => 'tns:NMPublisherAuthorList'),
        'totalCount' => array('name' => 'totalCount', 'type' => 'xsd:integer')
    )
);

/**  
 * SOAP Method getPublisherList 
 * @return Array of tns:Publisher instances on success
 */  
function getPublisherList($limit, $offset, $sortFieldName, $sortDirection, $query) {
  global $server;
// PROTECTED REGION ID(soap/Methods/getPublisherList) ENABLED START
  $params = array('className' => 'Publisher', 'completeObjects' => true);
  if ($limit) { $params['limit'] = $limit; }
  if ($offset) { $params['offset'] = $offset; }
  if ($sortFieldName) { $params['sortFieldName'] = $sortFieldName; }
  if ($sortDirection) { $params['sortDirection'] = $sortDirection; }
  if ($query) { $params['query'] = $query; }
  $response = $server->doCall('list', $params);
  return array('return' => array('list' => $response->getValue('list'), 'totalCount' => $response->getValue('totalCount')));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method createPublisher
 * @param Publisher The serialized object data
 * @return String (object id) on success
 */  
function createPublisher($Publisher) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createPublisher) ENABLED START
  $oidStr = $server->getDummyOid('Publisher')->__toString();
  $Publisher['oid'] = $oidStr;
  $response = $server->doCall('create', array($oidStr => $Publisher));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method readPublisher 
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Publisher on success
 */  
function readPublisher($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readPublisher) ENABLED START
  $params = array('oid' => $oid);
  if ($depth) { $params['depth'] = $depth; }
  $response = $server->doCall('read', $params);
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method updatePublisher 
 * @param Publisher The serialized object data
 * @return tns:Publisher on success
 */  
function updatePublisher($Publisher) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updatePublisher) ENABLED START
  $response = $server->doCall('update', array($Publisher['oid'] => $Publisher));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method deletePublisher
 * @param oid The object id of the object to delete
 * @return String (object id) on success
 */  
function deletePublisher($oid) {
  global $server;
// PROTECTED REGION ID(soap/Methods/deletePublisher) ENABLED START
  $response = $server->doCall('delete', array('oid' => $oid));
  return array('return' => $response->getValue('oid')->__toString());
// PROTECTED REGION END
}  

/**  
 * SOAP Method getAuthorList 
 * @return Array of tns:Author instances on success
 */  
function getAuthorList($limit, $offset, $sortFieldName, $sortDirection, $query) {
  global $server;
// PROTECTED REGION ID(soap/Methods/getAuthorList) ENABLED START
  $params = array('className' => 'Author', 'completeObjects' => true);
  if ($limit) { $params['limit'] = $limit; }
  if ($offset) { $params['offset'] = $offset; }
  if ($sortFieldName) { $params['sortFieldName'] = $sortFieldName; }
  if ($sortDirection) { $params['sortDirection'] = $sortDirection; }
  if ($query) { $params['query'] = $query; }
  $response = $server->doCall('list', $params);
  return array('return' => array('list' => $response->getValue('list'), 'totalCount' => $response->getValue('totalCount')));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method createAuthor
 * @param Author The serialized object data
 * @return String (object id) on success
 */  
function createAuthor($Author) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createAuthor) ENABLED START
  $oidStr = $server->getDummyOid('Author')->__toString();
  $Author['oid'] = $oidStr;
  $response = $server->doCall('create', array($oidStr => $Author));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method readAuthor 
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Author on success
 */  
function readAuthor($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readAuthor) ENABLED START
  $params = array('oid' => $oid);
  if ($depth) { $params['depth'] = $depth; }
  $response = $server->doCall('read', $params);
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method updateAuthor 
 * @param Author The serialized object data
 * @return tns:Author on success
 */  
function updateAuthor($Author) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updateAuthor) ENABLED START
  $response = $server->doCall('update', array($Author['oid'] => $Author));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method deleteAuthor
 * @param oid The object id of the object to delete
 * @return String (object id) on success
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
 * @return Array of tns:Book instances on success
 */  
function getBookList($limit, $offset, $sortFieldName, $sortDirection, $query) {
  global $server;
// PROTECTED REGION ID(soap/Methods/getBookList) ENABLED START
  $params = array('className' => 'Book', 'completeObjects' => true);
  if ($limit) { $params['limit'] = $limit; }
  if ($offset) { $params['offset'] = $offset; }
  if ($sortFieldName) { $params['sortFieldName'] = $sortFieldName; }
  if ($sortDirection) { $params['sortDirection'] = $sortDirection; }
  if ($query) { $params['query'] = $query; }
  $response = $server->doCall('list', $params);
  return array('return' => array('list' => $response->getValue('list'), 'totalCount' => $response->getValue('totalCount')));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method createBook
 * @param Book The serialized object data
 * @return String (object id) on success
 */  
function createBook($Book) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createBook) ENABLED START
  $oidStr = $server->getDummyOid('Book')->__toString();
  $Book['oid'] = $oidStr;
  $response = $server->doCall('create', array($oidStr => $Book));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method readBook 
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Book on success
 */  
function readBook($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readBook) ENABLED START
  $params = array('oid' => $oid);
  if ($depth) { $params['depth'] = $depth; }
  $response = $server->doCall('read', $params);
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method updateBook 
 * @param Book The serialized object data
 * @return tns:Book on success
 */  
function updateBook($Book) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updateBook) ENABLED START
  $response = $server->doCall('update', array($Book['oid'] => $Book));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method deleteBook
 * @param oid The object id of the object to delete
 * @return String (object id) on success
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
 * @return Array of tns:Chapter instances on success
 */  
function getChapterList($limit, $offset, $sortFieldName, $sortDirection, $query) {
  global $server;
// PROTECTED REGION ID(soap/Methods/getChapterList) ENABLED START
  $params = array('className' => 'Chapter', 'completeObjects' => true);
  if ($limit) { $params['limit'] = $limit; }
  if ($offset) { $params['offset'] = $offset; }
  if ($sortFieldName) { $params['sortFieldName'] = $sortFieldName; }
  if ($sortDirection) { $params['sortDirection'] = $sortDirection; }
  if ($query) { $params['query'] = $query; }
  $response = $server->doCall('list', $params);
  return array('return' => array('list' => $response->getValue('list'), 'totalCount' => $response->getValue('totalCount')));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method createChapter
 * @param Chapter The serialized object data
 * @return String (object id) on success
 */  
function createChapter($Chapter) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createChapter) ENABLED START
  $oidStr = $server->getDummyOid('Chapter')->__toString();
  $Chapter['oid'] = $oidStr;
  $response = $server->doCall('create', array($oidStr => $Chapter));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method readChapter 
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Chapter on success
 */  
function readChapter($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readChapter) ENABLED START
  $params = array('oid' => $oid);
  if ($depth) { $params['depth'] = $depth; }
  $response = $server->doCall('read', $params);
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method updateChapter 
 * @param Chapter The serialized object data
 * @return tns:Chapter on success
 */  
function updateChapter($Chapter) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updateChapter) ENABLED START
  $response = $server->doCall('update', array($Chapter['oid'] => $Chapter));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method deleteChapter
 * @param oid The object id of the object to delete
 * @return String (object id) on success
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
 * @return Array of tns:Image instances on success
 */  
function getImageList($limit, $offset, $sortFieldName, $sortDirection, $query) {
  global $server;
// PROTECTED REGION ID(soap/Methods/getImageList) ENABLED START
  $params = array('className' => 'Image', 'completeObjects' => true);
  if ($limit) { $params['limit'] = $limit; }
  if ($offset) { $params['offset'] = $offset; }
  if ($sortFieldName) { $params['sortFieldName'] = $sortFieldName; }
  if ($sortDirection) { $params['sortDirection'] = $sortDirection; }
  if ($query) { $params['query'] = $query; }
  $response = $server->doCall('list', $params);
  return array('return' => array('list' => $response->getValue('list'), 'totalCount' => $response->getValue('totalCount')));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method createImage
 * @param Image The serialized object data
 * @return String (object id) on success
 */  
function createImage($Image) {
  global $server;
// PROTECTED REGION ID(soap/Methods/createImage) ENABLED START
  $oidStr = $server->getDummyOid('Image')->__toString();
  $Image['oid'] = $oidStr;
  $response = $server->doCall('create', array($oidStr => $Image));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method readImage 
 * @param oid The object id of the object to load
 * @param depth The number of generations to load
 * @return tns:Image on success
 */  
function readImage($oid, $depth) {
  global $server;
// PROTECTED REGION ID(soap/Methods/readImage) ENABLED START
  $params = array('oid' => $oid);
  if ($depth) { $params['depth'] = $depth; }
  $response = $server->doCall('read', $params);
  return array('return' => $response->getValue('object'));
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method updateImage 
 * @param Image The serialized object data
 * @return tns:Image on success
 */  
function updateImage($Image) {
  global $server;
// PROTECTED REGION ID(soap/Methods/updateImage) ENABLED START
  $response = $server->doCall('update', array($Image['oid'] => $Image));
  return array('return' => $response->getValues());
// PROTECTED REGION END
}  
  
/**  
 * SOAP Method deleteImage
 * @param oid The object id of the object to delete
 * @return String (object id) on success
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