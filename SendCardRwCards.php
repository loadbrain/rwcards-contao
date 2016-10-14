<?php
if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2011 Ralf Weber
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
 * @package    Comments
 * @license    LGPL
 * @filesource
 */

/**
 * Class SendCardRwCards
 *
 * @copyright  LoadBrain 2011
 * @author     Ralf Weber <http://www.loadbrain.de>
 * @package    Controller
 */
class SendCardRwCards extends Frontend
{
    protected $module;

    public function setModule($module)
    {
        $this->module = $module;
    }

    public function getModule()
    {
        return $this->module;
    }

	/**
	 * Add all cards of one category to a template
	 * @param object
	 * @param object
	 * @param string
	 * @param integer
	 */
	public function addToTemplate($objTemplate, $objConfig, $strSource, $intParent, $alias)
    {
		$objPage = $this->Database->prepare('SELECT id, alias FROM tl_page WHERE id=?')->execute($intParent);
		$this->nextPage = $objPage->fetchAssoc();
		
		$this->import("Session");
		$this->sessionData = $this->Session->getData();

		$this->firstReceiver = true;
		$this->lastId = array();
		$this->linkToRWCards = array();
		$this->is_enduser = (\Input::get('sessionId') != "") ? 1 : 0;
		$this->sessionId = (\Input::get('sessionId') != "" ) ? \Input::get('sessionId') : false;
		$this->category_id = (\Input::get('category_id') > 0 ) ? \Input::get('category_id') : false;
		$this->card_id = (\Input::get('id') > 0 ) ? \Input::get('id') : false;
		$this->viewCardOnly = (\Input::get('view') == 'rwcardsReWriteCard' ) ? true : false;
		$this->additionalReceivers = $this->Session->get('additionalReceivers');

		if ($objConfig->template == '')
		{
			$objTemplate->template = 'rwcards_sendcard';
		}

		/**
		 * set some vars
		 */
		$GLOBALS['TL_CSS'][''] = \Environment::get('base') . "system/modules/rwcards/assets/css/rwcards.previewandsend.css";
		$objTemplate->data = $this->sessionData;
		$objTemplate->rwcards_sendcard_invalid_code = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_invalid_code'];
		$objTemplate->rwcards_sendcard_sucessfully_sent = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_sucessfully_sent'];
		$objTemplate->rwcards_sendcard_view_your_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_view_your_card'];
		$objTemplate->rwcards_sendcard_congratulations = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_congratulations'];
		$objTemplate->rwcards_sendcard_congatulations_hint = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_congatulations_hint'];
		$objTemplate->rwcards_sendcard_view_your_card_hint = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_view_your_card_hint'];
		$objTemplate->rwcards_sendcard_show_front_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_show_front_card'];
		$objTemplate->rwcards_sendcard_show_back_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_show_back_card'];
		$objTemplate->rwcards_sendcard_from = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_from'];
		$objTemplate->rwcards_sendcard_name_from = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_name_from'];
		$objTemplate->rwcards_sendcard_message = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_message'];
		$objTemplate->rwcards_sendcard_to = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_to'];
		$objTemplate->rwcards_sendcard_name_to = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_name_to'];
		$objTemplate->rwcards_sendcard_reply = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_reply'];
		$objTemplate->is_enduser = $this->is_enduser;
		$objTemplate->reWritetoSender = (\Input::get('view') == "rwcardsReWriteCard") ? 1 : 0;
		$objTemplate->sessionId = (\Input::get('view') == "rwcardsReWriteCard") ? \Input::get('sessionId') : null;
		$objTemplate->alias = $alias;
		$objTemplate->nextPage = $this->nextPage;
		$objTemplate->objPage = clone $objPage;

		if (\Input::get('view') == "rwcardsReWriteCard")
		{
			// New Card or someone answers
			if ( $this->sessionId != "")
			{
				$resCats = $this->Database->prepare("select * from tl_rwcardsdata where id = '" . $this->card_id . "' and tl_rwcardsdata.sessionId = '" . $this->sessionId ."'");
				$this->data = $resCats->execute()->fetchAllAssoc();
                $reWritetoSenderId = $this->Database->prepare("select id from tl_rwcards where picture = '" . $this->data[0]['picture'] . "'")->execute()->row();
				$objTemplate->reWritetoSenderId = $reWritetoSenderId['id'];
				$objTemplate->data = $this->data;
				$this->setCardStatusToRead();
			}
		}
		else
		{
			//Send Card -> view: rwcardssendcard
			if (count($this->Session->getData()) > 0)
			{
				$objRes = $this->Database->prepare("INSERT INTO tl_rwcardsdata SET picture= '" . $this->Session->get('picture')
				. "', nameTo = '" . $this->Session->get('rwcardsReceiver')
				. "', nameFrom = '" . $this->Session->get('rwNameFrom')
				. "', emailTo = '" . $this->Session->get('rwCardsFormEmailTo')
				. "', emailFrom = '" . $this->Session->get('rwEmailFrom')
				. "', message = '" . addslashes($this->Session->get('rwMessage'))
				. "', sessionId = '" . $_SESSION['rwcards']['rwcards_session']
				. "' , writtenOn = '" . date("Y-m-d")
				. "' , cardSent = '0'")->execute();
				// Get the ID generated from the previous INSERT operation

				array_push($this->lastId, $objRes->insertId);

				// All receivers are stored in tbe database
				for ($i = 1; $i <= $this->additionalReceivers; $i++)
				{
					$this->Database->prepare("INSERT INTO tl_rwcardsdata SET picture= '" . $this->Session->get('picture')
					. "', nameTo = '" . $this->Session->get('rwcardsReceiver' . $i)
					. "', nameFrom = '" . $this->Session->get('rwNameFrom')
					. "', emailTo = '" . $this->Session->get('rwCardsFormEmailTo' . $i)
					. "', emailFrom = '" . $this->Session->get('rwEmailFrom')
					. "', message = '" . addslashes($this->Session->get('rwMessage'))
					. "', sessionId = '" . $_SESSION['rwcards']['rwcards_session']
					. "' , writtenOn = '" . date("Y-m-d")
					. "' , cardSent = '0'")->execute();

					// Get the ID generated from the previous INSERT operation
					$this->lastId[$i] = $objRes->insertId;
				}
				$this->sendEcardPerMail($objTemplate);
			}
			return;
		}
	}

	/**
	 * Send an email to the receiver(s)
	 */
	public function sendEcardPerMail($objTemplate)
    {
	    global $objPage;
		$this->import("String");
		$objEmail = new \Email();

		for ($i = 0; $i < count($this->lastId); $i++)
		{
			$this->linkToRWCards[$i] = \Environment::get('base') . \Controller::generateFrontendUrl($objPage->row()). '?view=rwcardsReWriteCard&sessionId=' . $_SESSION['rwcards']['rwcards_session'] . '&id=' . $this->lastId[$i] . '&read=1&sendmail=1';
			$this->linkToViewOnly[$i] = \Environment::get('base') . \Controller::generateFrontendUrl($objPage->row()) . '?view=rwcardsReWriteCard&sessionId=' . $_SESSION['rwcards']['rwcards_session'] . '&id=' . $this->lastId[$i] . '&sendmail=0';

			// send card as attachement
			if ($_SESSION['rwcards']['config']['rwcards_per_attachement'])
			{
				$message[$i] = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_greeting'] . " "
				. $this->Session->get('rwcardsReceiver' . $i) . ",\n\n"
				. $this->Session->get('rwNameFrom') . " " . $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_attachement_1'] . "\n"
				. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_attachement_2'] . "\n"
				. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_attachement_3'] . "\n\n"
				. nl2br($this->Session->get('rwMessage'))
				. "\n\n" . $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_separator'] . "\n\n"
				. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_copyright'];
				$objEmail->attachFile($this->Session->get('picture'));
			}
			else {
                $module = $this->getModule();
                $text   = trim(html_entity_decode($module->rwcards_email_text));

                $sender   = trim($this->Session->get('rwNameFrom'));
                $receiver = ($i > 0 ) ? trim($this->Session->get('rwcardsReceiver' . $i))  : trim($this->Session->get('rwcardsReceiver'));
                $link     = trim($this->linkToRWCards[$i]);

                $text = \String::parseSimpleTokens($text,array('sender'    =>  $sender,
                                                               'receiver'  =>  $receiver,
                                                                'link'     => $link));

                if(strlen($text)==0)
                {
                    // If email text is not set in backend create deafult text here
                    $text  = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_greeting'] . " ";
                    $text .= ($i > 0 ) ? trim($this->Session->get('rwcardsReceiver' . $i)) . "\n\n" : trim($this->Session->get('rwcardsReceiver'));
                    $text .= ",\n\n".$this->Session->get('rwNameFrom');
                    $text .= " " . $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_part_1'] . "\n\n";
                    $text .= $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_part_2'] . "\n\n";
                    $text .= $this->linkToRWCards[$i] . "\n";
                }

                $message[$i] = $text. "\n";

                $message[$i] .= $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_separator'] . "\n"
				. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_copyright'] . "\n\n";
			}

			$objEmail->from = $this->Session->get('rwEmailFrom');
			$objEmail->fromName = $this->Session->get('rwNameFrom');
			$objEmail->subject = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_subject'] . $this->Session->get('rwNameFrom');

            $message[$i] = strip_tags($message[$i]);
            $message[$i] = $this->String->decodeEntities($message[$i]);
       		$message[$i] = str_replace(array('&', '<', '>'), array('&', '<', '>'), $message[$i]);
       		$objEmail->text = sprintf($message[$i]);

			// Send for additional reveivers
			for ($a = 1; $a <= $this->additionalReceivers; $a++)
			{
				$objEmail->sendTo($this->Session->get('rwCardsFormEmailTo' . $a)); //'ralf@localhost'
				$res = $this->Database->prepare("update tl_rwcardsdata set cardSent = '1' WHERE id = '" . $this->lastId[$a] . "'")->execute();
				if ($this->additionalReceivers == $a)
				{
					$this->additionalReceivers = null;
				}
			}
		}

        // Send to first receiver
		$objEmail->sendTo($this->Session->get('rwCardsFormEmailTo')); //'ralf@localhost';
        $res = $this->Database->prepare("update tl_rwcardsdata set cardSent = '1' WHERE id = '" . $this->lastId[0] . "'")->execute();
        session_destroy();
        return;
	}

	/**
	 * Set the status of the card to read and send an email to the receiver that the card was read
	 */
	public function setCardStatusToRead()
    {
		if ( $this->data[0]['cardRead'] == '0')
		{
			$res = $this->Database->prepare("update tl_rwcardsdata set cardRead = '1', readOn = '" . date("Y-m-d") . "' WHERE id = '" . \Input::get('id') . "' and sessionId = '" . $this->sessionId . "'")->execute();

			$objEmail = new Email();
			$objEmail->subject =  $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_read_subject'];
			$message = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_greeting'] . " "
			. $this->data[0]['nameTo'] . ",\n\n"
			. $this->data[0]['nameFrom'] . " <" . $this->data[0]['emailFrom'] . "> "
			. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_read_msg_1'] . " "
			. date("d.m.Y") . " "
			. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_read_msg_2'] . "\n\n"
			. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_read_msg_3'] . "\n\n"
			. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_separator'] . "\n"
			. $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_sendcard_msg_copyright'] . "\n\n";

			$objEmail->text = sprintf($message);
			$objEmail->from = $this->data[0]['emailTo'] ;
			$objEmail->fromName = $this->data[0]['nameTo'];
			$objEmail->sendTo($this->data[0]['emailFrom']);
		}
	}
}
