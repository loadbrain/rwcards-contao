<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Rwcards
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'FillOutCardRwCards' => 'system/modules/rwcards/FillOutCardRwCards.php',
	'ListRwCards'        => 'system/modules/rwcards/ListRwCards.php',
	'ModuleRwCards'      => 'system/modules/rwcards/ModuleRwCards.php',
	'MyClass'            => 'system/modules/rwcards/MyClass.php',
	'OneCategoryRwCards' => 'system/modules/rwcards/OneCategoryRwCards.php',
	'PreviewCardRwCards' => 'system/modules/rwcards/PreviewCardRwCards.php',
	'SendCardRwCards'    => 'system/modules/rwcards/SendCardRwCards.php',
	// Models
	'RwcardsModel'		=> 'system/modules/rwcards/models/RwcardsModel.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'rwcards_filloutcard' => 'system/modules/rwcards/templates',
	'rwcards_list'        => 'system/modules/rwcards/templates',
	'rwcards_onecategory' => 'system/modules/rwcards/templates',
	'rwcards_preview'     => 'system/modules/rwcards/templates',
	'rwcards_sendcard'    => 'system/modules/rwcards/templates',
));
