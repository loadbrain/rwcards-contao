-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************



-- --------------------------------------------------------

--
-- Table `tl_rwcards`
--

CREATE TABLE `tl_rwcards` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` tinyint(3) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `autor` varchar(150) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `picture` binary(16) DEFAULT NULL,
  `description` text NOT NULL,
  `published` char(1) NOT NULL default '1',
  `size` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


--
-- Table `tl_module`
--

CREATE TABLE `tl_module` (
  `rwcards_cards_per_row` tinyint(3) unsigned NOT NULL default '3',
  `rwcards_rows_per_page` tinyint(3) unsigned NOT NULL default '3',
  `rwcards_keep_cards` tinyint(3) unsigned NOT NULL default '7',
  `rwcards_thumb_box_width` int(10) unsigned NOT NULL default '260',
  `rwcards_thumb_box_height` int(10) unsigned NOT NULL default '260',
  `rwcards_per_attachement` char(1) NOT NULL default '0',
  `rwcards_view_categories` char(1) NOT NULL default '0',
  `rwcards_thumbnail_width` int(10) unsigned NOT NULL default '80',
  `rwcards_thumbnail_height` int(10) unsigned NOT NULL default '80',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table `tl_rwcards_category`
--

CREATE TABLE `tl_rwcards_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `category_kategorien_name` varchar(50) NOT NULL default '',
  `category_description` text NOT NULL,
  `published` char(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table `tl_rwcardsdata`
--

CREATE TABLE `tl_rwcardsdata` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `nameTo` varchar(50) NOT NULL default '',
  `nameFrom` varchar(50) NOT NULL default '',
  `emailTo` varchar(50) NOT NULL default '',
  `emailFrom` varchar(50) NOT NULL default '',
  `picture` varchar(50) NOT NULL default '',
  `sessionId` varchar(50) NOT NULL default '',
  `message` text NOT NULL,
  `writtenOn` date NOT NULL default '1999-01-01',
  `readOn` date NOT NULL default '1999-01-01',
  `cardSent` enum('0','1') NOT NULL default '0',
  `cardRead` enum('0','1') NOT NULL default '0'
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

