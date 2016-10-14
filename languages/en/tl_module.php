<?php
if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Ralf Weber
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  LoadBrain 2011
 * @author     Ralf Weber <http://www.loadbrain.de>
 * @package    Calendar
 * @license    LGPL
 * @filesource
 */
/**
 * Language
 */

$GLOBALS['TL_LANG']['tl_module']['rwcards_view_categories']['0']            = "Show categories or directly all cards on one page (only one category exists)?";
$GLOBALS['TL_LANG']['tl_module']['rwcards_view_categories']['1']            = "Show categories or directly all cards on one page (only one category exists)?";
$GLOBALS['TL_LANG']['tl_module']['rwcards_view_categories']['options']['0'] = "Show categories";
$GLOBALS['TL_LANG']['tl_module']['rwcards_view_categories']['options']['1'] = "Directly show all cards from one category (only ONE category should exists!!)";
$GLOBALS['TL_LANG']['tl_module']['rwcards_cards_per_row'] = array( 'How many cards per row?', 'How many cards per row to show on a page?' );
$GLOBALS['TL_LANG']['tl_module']['rwcards_rows_per_page'] = array( 'How many rows per page?', 'How many rows per page to show?' );
$GLOBALS['TL_LANG']['tl_module']['rwcards_keep_cards']    = array(
    'How many days should sent cards be kept?',
    'How many days should sent cards be kept? 0 = never delete'
);

$GLOBALS['TL_LANG']['tl_module']['rwcards_thumb_box_width']  = array(
    'How large should the box for the cards in the preview be?',
    'How large should the box for the cards in the preview be?'
);
$GLOBALS['TL_LANG']['tl_module']['rwcards_thumb_box_height'] = array(
    'How high should the box for the cards in the preview be?',
    'How high should the box for the cards in the preview be?'
);

$GLOBALS['TL_LANG']['tl_module']['rwcards_thumbnail_width']  = array(
    'How large should the thumbnails for the cards in the preview be?',
    'How large should the thumbnails for the cards in the preview be?'
);
$GLOBALS['TL_LANG']['tl_module']['rwcards_thumbnail_height'] = array(
    'How high should the thumbnails for the cards in the preview be?',
    'How high should the thumbnails for the cards in the preview be?'
);
$GLOBALS['TL_LANG']['tl_module']['rwcards_per_attachement']  = array(
    'Sending card as attachement?',
    'Sending card as attachement or as link to the page (prefered)?'
);
$GLOBALS['TL_LANG']['tl_module'][0]                          = 'No, URL send the URL to the card directly in the email';
$GLOBALS['TL_LANG']['tl_module'][1]                          = 'Yes, send as attachement';
$GLOBALS['TL_LANG']['tl_module']['rwcards_email_text']       = array(
    'Receivermail-Text',
    'Text which is send by mail to the receiver. You can use the simple tokens ##sender##,##receiver## and ##link## here. Leave field empty to send default text.'
);
