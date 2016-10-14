<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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

/*
 * Module Names
 */
$GLOBALS['TL_LANG']['MOD']['RWCards']          = array( 'E-Cards', 'Configure E-Cards.' );
$GLOBALS['TL_LANG']['MOD']['RWCardsSentCards'] = array( 'Sent E-Cards ', 'View sent E-Cards.' );

/**
 * ListCards
 */
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_listcards_see_all_cards']                    = 'Show all cards of this category';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_listcards_no_category_published_or_created'] = "Not yet any categories or cards published or created!";

/**
 * One category -> ListCards
 */
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_one_category_listcards']       = 'Click on card for full view';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_one_category_chosen_category'] = "Chosen category";
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_one_category_send_this_image'] = "Send this card";

/**
 * Fill out card
 */
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_please_fill_out'] = 'Please fill out all fields';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_name_from']       = 'Your name';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_email_from']      = 'Your e-mail address';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_message']         = 'Your message';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_name_to']         = 'Recipient name';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_email_to']        = 'Recipient e-mail address';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_add_receiver']    = 'Add reveiver';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_remove_receiver'] = 'Remove reveiver';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_back']            = '<< Back to cards';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_preview_card']    = 'Preview';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_send_card']       = 'Send';

/**
 * Preview Cards
 */
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_card']            = 'Preview Card';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_show_front_card'] = 'Show front';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_show_back_card']  = 'Show back';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_from']            = 'From:';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_message']         = 'Message:';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_to']              = 'To:';

/**
 * Send Cards
 */
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_invalid_code']        = 'You entered an invalid code. Please check your e-mail message for the correct URL.';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_sucessfully_sent']    = 'Your card was successfully sent!';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_view_your_card']      = 'Personal EC-ard for';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_congratulations']     = 'Congratulations!';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_view_your_card_hint'] = 'Click on "Show Back" to reply!';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_congatulations_hint'] = 'You will be sent a confirmation e-mail when the recipient has viewed the card.';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_show_front_card']     = 'Show front';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_show_back_card']      = 'Show back';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_from']                = 'From:';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_name_from']           = 'Name';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_message']             = 'Message';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_to']                  = 'To:';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_name_to']             = 'Name of receiver';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_reply']               = 'reply now';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_subject']             = 'You received an E-Card from ';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_greeting']            = 'Hello';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_attachement_1']   = 'has sent you an E-Card.';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_attachement_2']   = 'View the image in the attachement.';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_attachement_3']   = 'Message:';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_separator']       = '----------------------------------------------------------------------';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_copyright']       = 'RWCards - Copyright Ralf Weber / LoadBrain - http://www.loadbrain.de/';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_part_1']          = 'has sent you an E-Card.';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_part_2']          = 'Please click on the following link to view your E-Card:';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_read_subject']        = 'Your E-Card was read!';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_read_msg_1']          = 'has read your card on';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_read_msg_2']          = '.';
$GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_read_msg_3']          = 'Have fun with RWCards!';
