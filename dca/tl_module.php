<?php
if(!defined('TL_ROOT')) { die('You cannot access this file directly!'); }

/**
 * Contao Open Source CMS
 * Copyright (C) 2011 Ralf Weber
 * Formerly known as TYPOlight Open Source CMS.
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 * PHP version 5
 *
 * @copyright  LoadBrain 2011
 * @author     Ralf Weber <http://www.loadbrain.de>
 * @package    Comments
 * @license    LGPL
 * @filesource
 */

/**
 * Add palette
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['RWCards'] .= '{title_legend},name,headline,type;rwcards_view_categories;rwcards_per_attachement;rwcards_cards_per_row,rwcards_rows_per_page;rwcards_keep_cards;rwcards_thumb_box_width,rwcards_thumb_box_height;rwcards_thumbnail_width,rwcards_thumbnail_height;rwcards_email_text';

/**
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_view_categories'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_view_categories'],
    'exclude'   => true,
    'inputType' => 'radio',
    'options'   => array( 0, 1 ),
    'default'   => 1,
    'eval'      => array( 'mandatory' => true, ),
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['rwcards_view_categories']['options'],
    'sql'       => "char(1) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_per_attachement'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_per_attachement'],
    'exclude'   => true,
    'inputType' => 'radio',
    'options'   => array( 0, 1 ),
    'default'   => 0,
    'eval'      => array( 'mandatory' => true, ),
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'sql'       => "char(1) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_cards_per_row'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_cards_per_row'],
    'inputType' => 'text',
    'eval'      => array( 'mandatory' => true, ),
    'default'   => 3,
    'sql'       => "tinyint(1) default '3'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_rows_per_page'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_rows_per_page'],
    'inputType' => 'text',
    'eval'      => array( 'mandatory' => true, ),
    'default'   => 3,
    'sql'       => "tinyint(1) default '3'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_keep_cards'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_keep_cards'],
    'inputType' => 'text',
    'eval'      => array( 'mandatory' => true, ),
    'default'   => 7,
    'sql'       => "tinyint(1) default '7'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_thumb_box_width'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_thumb_box_width'],
    'inputType' => 'text',
    'eval'      => array( 'mandatory' => true, ),
    'default'   => 260,
    'sql'       => "int(10) unsigned NOT NULL default '260'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_thumb_box_height'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_thumb_box_height'],
    'inputType' => 'text',
    'eval'      => array( 'mandatory' => true, ),
    'default'   => 260,
    'sql'       => "int(10) unsigned NOT NULL default '260'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_thumbnail_width']  = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_thumbnail_width'],
    'inputType' => 'text',
    'eval'      => array( 'mandatory' => true, ),
    'default'   => 160,
    'sql'       => "int(10) unsigned NOT NULL default '80'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_thumbnail_height'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_thumbnail_height'],
    'inputType' => 'text',
    'eval'      => array( 'mandatory' => true, ),
    'default'   => 120,
    'sql'       => "int(10) unsigned NOT NULL default '80'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['rwcards_email_text'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_module']['rwcards_email_text'],
    'exclude'   => true,
    'filter'    => false,
    'inputType' => 'textarea',
    'eval'      => array( 'mandatory' => false, 'rows' => 15 ),
    'sql'       => "text NOT NULL"
);
