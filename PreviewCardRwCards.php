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
 * Class PreviewCardRwCards
 *
 * @copyright  LoadBrain 2011
 * @author     Ralf Weber <http://www.loadbrain.de>
 * @package    Controller
 */
class PreviewCardRwCards extends Frontend
{

	/**
	 * Add all cards of one category to a template
	 * @param object
	 * @param object
	 * @param string
	 * @param integer
	 */
	public function addToTemplate($objTemplate, $objConfig, $strSource, $intParent, $alias){
		$objPage = new stdClass();
		$objPage = $this->Database->prepare('SELECT id, alias FROM tl_page WHERE id=?')->execute($intParent);
		$this->nextPage = $objPage->fetchAssoc();

		$limit = null;

		$data = array();
		$this->sessionId = (\Input::get('sessionId') != "" ) ? \Input::get('sessionId') : false;
		$this->category_id = (\Input::get('category_id') > 0 ) ? \Input::get('category_id') : false;
		$this->card_id = (\Input::get('id') > 0 ) ? \Input::get('id') : false;
		$this->import("Session");


			if ($objConfig->template == '')
			{
				$objTemplate->template = 'rwcards_preview';
			}


		/**
		 * set some vars
		 */
		$GLOBALS['TL_CSS'][''] = \Environment::get('base') . "system/modules/rwcards/assets/css/rwcards.previewandsend.css";
		$objTemplate->data = $this->data;
		$objTemplate->rwcards_preview_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_card'] ;
		$objTemplate->rwcards_preview_show_front_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_show_front_card'];
		$objTemplate->rwcards_preview_show_back_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_show_back_card'];
		$objTemplate->rwcards_preview_from = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_from'];
		$objTemplate->rwcards_preview_message = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_message'];
		$objTemplate->rwcards_preview_to = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_preview_to'];
		$objTemplate->rwcards_preview_cards_back = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_back'];
		$objTemplate->rwcards_preview_cards_send_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_send_card'];

		$objTemplate->reWritetoSender = 0;
		$objTemplate->category_id = $this->category_id;
		$objTemplate->sessionId;
		$objTemplate->alias = $alias;
		$objTemplate->formId = 'rwcards_fillout_form';
		$objTemplate->action = ampersand($this->Environment->request);
		$objTemplate->card_id = $this->card_id;
		$objTemplate->nextPage = $this->nextPage;

		// Form fields
		$arrFields = array
		(
			'rwNameFrom' => array
			(
				'name' => 'rwNameFrom',
				'label' => $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_name_from'],
				'value' => trim($this->User->firstname . ' ' . $this->User->lastname),
				'inputType' => 'text',
				'eval' => array('mandatory'=>true, 'maxlength'=>64)
			),
			'rwEmailFrom' => array
			(
				'name' => 'rwEmailFrom',
				'label' => $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_email_from'],
				'value' => $this->User->email,
				'inputType' => 'text',
				'eval' => array('rgxp'=>'email', 'mandatory'=>true, 'maxlength'=>128, 'decodeEntities'=>true)
			),
			'rwMessage' => array
			(
				'name' => 'rwMessage',
				'id' => 'rwCardsFormMessage',
				'label' =>  $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_message'],
      			'inputType'    => 'textarea',
      			'eval'  => array('rte'=>'tinyFlash', 'decodeEntities'=>true, 'mandatory'=>true,)
			),
			'rwcardsReceiver' => array
			(
				'name' => 'rwcardsReceiver',
				'label' => $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_name_to'],
				'value' => trim($this->User->firstname . ' ' . $this->User->lastname),
				'inputType' => 'text',
				'eval' => array('mandatory'=>true, 'maxlength'=>64)
			),
			'rwCardsFormEmailTo' => array
			(
				'name' => 'rwCardsFormEmailTo',
				'label' => $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_email_to'],
				'value' => $this->User->email,
				'inputType' => 'text',
				'eval' => array('rgxp'=>'email', 'mandatory'=>true, 'maxlength'=>128, 'decodeEntities'=>true)
			),
			'rwCardsCaptcha' => array
			(
				'name' => 'rwCardsCaptcha',
				'inputType' => 'captcha',
				'eval' => array('mandatory'=>true)
			)
		);

		$doNotSubmit = false;
		$arrWidgets = array();


		$objTemplate->hasError = $doNotSubmit;

		// Initialize widgets
		foreach ($arrFields as $arrField)
		{

			$strClass = $GLOBALS['TL_FFL'][$arrField['inputType']];

			// Continue if the class is not defined
			if (!$this->classFileExists($strClass))
			{
				continue;
			}

			$arrField['eval']['required'] = $arrField['eval']['mandatory'];
			$objWidget = new $strClass($this->prepareForWidget($arrField, $arrField['name'], $arrField['value']));

			// Validate the widget
			if ($this->Input->post('FORM_SUBMIT') == 'rwcards_fillout_form')
			{
				$objWidget->validate();

				if ($objWidget->hasErrors())
				{
					$doNotSubmit = true;
				}
			}

			$arrWidgets[$arrField['name']] = $objWidget;
		}
		$objTemplate->fields  = $arrWidgets;

		if ($this->Input->post('FORM_SUBMIT') == $objTemplate->formId && !$doNotSubmit)
		{
			// Preview button clicked
			if($this->Input->post('submit') == $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_preview_card'] ){
				$this->redirect(\Controller::generateFrontendUrl($objPage->row()) . '?view=rwcardspreview&id=' . $this->data[0]['id'] .'&category_id=' . $this->category_id . '&reWritetoSender=' . $objTemplate->reWritetoSender . '&sessionId=' . @$this->sessionId);
			}
			// Sending button clicked
			if($this->Input->post('submit') == $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_send_card'] ){
				$this->redirect(\Controller::generateFrontendUrl($objPage->row()) . '?view=rwcardssendcard&id=' . $this->data[0]['id'] .'&category_id=' . $this->category_id . '&reWritetoSender=' . $objTemplate->reWritetoSender . '&sessionId=' . @$this->sessionId);
			}
		}
	}
}
