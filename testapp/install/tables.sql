#
# This file was generated by ChronosGenerator  from cwm-export.uml on Sun Apr 28 21:58:00 CEST 2013. 
# Manual modifications should be placed inside the protected regions.
#
#
# Structure of Table `dbsequence`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `dbsequence`;
CREATE TABLE `dbsequence` # entityType=DBSequence tableId=Chi046Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi046Nod.id 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#
# Structure of Table `language`
# A llanguage for which a translation of the model can be created. The code is arbitrary but it is recommended to use the ISO language codes (en, de, it, ...).
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` # entityType=Language tableId=Chi047Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi047Nod.id 
  `name` VARCHAR(255), # columnId=Chi047Nod.name 
  `code` VARCHAR(255), # columnId=Chi047Nod.code 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#
# Structure of Table `locktable`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `locktable`;
CREATE TABLE `locktable` # entityType=Locktable tableId=Chi048Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi048Nod.id 
  `fk_user_id` INT(11), # columnId=Chi048Nod.fk_user_id referencedTable=UserRDB
  `objectid` VARCHAR(255), # columnId=Chi048Nod.objectid 
  `sessionid` VARCHAR(255), # columnId=Chi048Nod.sessionid 
  `since` DATETIME, # columnId=Chi048Nod.since 
  PRIMARY KEY (`id`)
  ,KEY `fk_user_id` (`fk_user_id`)
) ENGINE=MyISAM;
#
# Structure of Table `role`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` # entityType=RoleRDB tableId=Chi049Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi049Nod.id 
  `name` VARCHAR(255), # columnId=Chi049Nod.name 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#
# Structure of Table `translation`
# Instances of this class are used to localize entity attributes. Each instance defines a translation of one attribute of one entity into one language.
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `translation`;
CREATE TABLE `translation` # entityType=Translation tableId=Chi050Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi050Nod.id 
  `objectid` VARCHAR(255), # columnId=Chi050Nod.objectid 
  `attribute` VARCHAR(255), # columnId=Chi050Nod.attribute 
  `translation` TEXT, # columnId=Chi050Nod.translation 
  `language` VARCHAR(255), # columnId=Chi050Nod.language 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#
# Structure of Table `user_config`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `user_config`;
CREATE TABLE `user_config` # entityType=UserConfig tableId=Chi051Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi051Nod.id 
  `fk_user_id` INT(11), # columnId=Chi051Nod.fk_user_id referencedTable=UserRDB
  `key` VARCHAR(255), # columnId=Chi051Nod.key 
  `val` VARCHAR(255), # columnId=Chi051Nod.val 
  PRIMARY KEY (`id`)
  ,KEY `fk_user_id` (`fk_user_id`)
) ENGINE=MyISAM;
#
# Structure of Table `user`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` # entityType=UserRDB tableId=Chi052Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi052Nod.id 
  `login` VARCHAR(255), # columnId=Chi052Nod.login 
  `password` VARCHAR(255), # columnId=Chi052Nod.password 
  `name` VARCHAR(255), # columnId=Chi052Nod.name 
  `firstname` VARCHAR(255), # columnId=Chi052Nod.firstname 
  `config` VARCHAR(255), # columnId=Chi052Nod.config 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#
# Structure of Table `nm_user_role`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `nm_user_role`;
CREATE TABLE `nm_user_role` # entityType=NMUserRole tableId=Chi001
(
  `fk_user_id` INT(11), # columnId=Chi001.fk_user_id referencedTable=UserRDB
  `fk_role_id` INT(11), # columnId=Chi001.fk_role_id referencedTable=RoleRDB
  PRIMARY KEY (`fk_user_id`,`fk_role_id`)
) ENGINE=MyISAM;
#
# Structure of Table `Publisher`
# ?A publisher publishes books.
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `Publisher`;
CREATE TABLE `Publisher` # entityType=Publisher tableId=Chi222Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi222Nod.id 
  `name` VARCHAR(255), # columnId=Chi222Nod.name 
  `created` DATETIME, # columnId=Chi222Nod.created 
  `creator` VARCHAR(255), # columnId=Chi222Nod.creator 
  `modified` DATETIME, # columnId=Chi222Nod.modified 
  `last_editor` VARCHAR(255), # columnId=Chi222Nod.last_editor 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#
# Structure of Table `Author`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `Author`;
CREATE TABLE `Author` # entityType=Author tableId=Chi041Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi041Nod.id 
  `name` VARCHAR(255), # columnId=Chi041Nod.name 
  `created` DATETIME, # columnId=Chi041Nod.created 
  `creator` VARCHAR(255), # columnId=Chi041Nod.creator 
  `modified` DATETIME, # columnId=Chi041Nod.modified 
  `last_editor` VARCHAR(255), # columnId=Chi041Nod.last_editor 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
#
# Structure of Table `Book`
# A book is published by a publisher and consists of chapters.
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `Book`;
CREATE TABLE `Book` # entityType=Book tableId=Chi042Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi042Nod.id 
  `fk_publisher_id` INT(11), # columnId=Chi042Nod.fk_publisher_id referencedTable=Publisher
  `title` VARCHAR(255), # columnId=Chi042Nod.title 
  `description` VARCHAR(255), # columnId=Chi042Nod.description 
  `year` VARCHAR(255), # columnId=Chi042Nod.year 
  `created` DATETIME, # columnId=Chi042Nod.created 
  `creator` VARCHAR(255), # columnId=Chi042Nod.creator 
  `modified` DATETIME, # columnId=Chi042Nod.modified 
  `last_editor` VARCHAR(255), # columnId=Chi042Nod.last_editor 
  PRIMARY KEY (`id`)
  ,KEY `fk_publisher_id` (`fk_publisher_id`)
) ENGINE=MyISAM;
#
# Structure of Table `Chapter`
# A book is divided into chapters. A chapter may contain subchapters.
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `Chapter`;
CREATE TABLE `Chapter` # entityType=Chapter tableId=Chi045Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi045Nod.id 
  `fk_chapter_id` INT(11), # columnId=Chi045Nod.fk_chapter_id referencedTable=Chapter
  `fk_book_id` INT(11), # columnId=Chi045Nod.fk_book_id referencedTable=Book
  `fk_author_id` INT(11), # columnId=Chi045Nod.fk_author_id referencedTable=Author
  `name` VARCHAR(255), # columnId=Chi045Nod.name 
  `created` DATETIME, # columnId=Chi045Nod.created 
  `creator` VARCHAR(255), # columnId=Chi045Nod.creator 
  `modified` DATETIME, # columnId=Chi045Nod.modified 
  `last_editor` VARCHAR(255), # columnId=Chi045Nod.last_editor 
  `sortkey_author` INT(11), # columnId=sortkey_author
  `sortkey_book` INT(11), # columnId=sortkey_book
  `sortkey_parentchapter` INT(11), # columnId=sortkey_parentchapter
  `sortkey` INT(11), # columnId=sortkey
  PRIMARY KEY (`id`)
  ,KEY `fk_chapter_id` (`fk_chapter_id`)
  ,KEY `fk_book_id` (`fk_book_id`)
  ,KEY `fk_author_id` (`fk_author_id`)
) ENGINE=MyISAM;
#
# Structure of Table `Image`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `Image`;
CREATE TABLE `Image` # entityType=Image tableId=Chi044Nod
(
  `id` INT(11) NOT NULL, # columnId=Chi044Nod.id 
  `fk_chapter_id` INT(11), # columnId=Chi044Nod.fk_chapter_id referencedTable=Chapter
  `fk_titlechapter_id` INT(11), # columnId=Chi044Nod.fk_titlechapter_id referencedTable=Chapter
  `file` VARCHAR(255), # columnId=Chi044Nod.filename 
  `created` DATETIME, # columnId=Chi044Nod.created 
  `creator` VARCHAR(255), # columnId=Chi044Nod.creator 
  `modified` DATETIME, # columnId=Chi044Nod.modified 
  `last_editor` VARCHAR(255), # columnId=Chi044Nod.last_editor 
  `sortkey_titlechapter` INT(11), # columnId=sortkey_titlechapter
  `sortkey_normalchapter` INT(11), # columnId=sortkey_normalchapter
  `sortkey` INT(11), # columnId=sortkey
  PRIMARY KEY (`id`)
  ,KEY `fk_chapter_id` (`fk_chapter_id`)
  ,KEY `fk_titlechapter_id` (`fk_titlechapter_id`)
) ENGINE=MyISAM;
#
# Structure of Table `NMPublisherAuthor`
# ?
# version 1.0
# init params database
#
DROP TABLE IF EXISTS `NMPublisherAuthor`;
CREATE TABLE `NMPublisherAuthor` # entityType=NMPublisherAuthor tableId=Chi001
(
  `id` INT(11) NOT NULL, # columnId=Chi001.id 
  `fk_author_id` INT(11), # columnId=Chi001.fk_author_id referencedTable=Author
  `fk_publisher_id` INT(11), # columnId=Chi001.fk_publisher_id referencedTable=Publisher
  `sortkey_publisher` INT(11), # columnId=sortkey_publisher
  `sortkey_author` INT(11), # columnId=sortkey_author
  `sortkey` INT(11), # columnId=sortkey
  PRIMARY KEY (`id`)
  ,KEY `fk_author_id` (`fk_author_id`)
  ,KEY `fk_publisher_id` (`fk_publisher_id`)
) ENGINE=MyISAM;
