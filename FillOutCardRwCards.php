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
 * Class OneCategoryRwCards
 *
 * @copyright  LoadBrain 2011
 * @author     Ralf Weber <http://www.loadbrain.de>
 * @package    Controller
 */
class FillOutCardRwCards extends Frontend
{

	/**
	 * Add all cards of one category to a template
	 * @param object
	 * @param object
	 * @param string
	 * @param integer
	 */
	public function addToTemplate($objTemplate, $objConfig, $strSource, $intParent, $alias){

		$this->import("Session");

		$limit = null;
		$data = array();
		$this->sessionId = ($this->Input->get('sessionId') != "" ) ? $this->Input->get('sessionId') : false;
		$this->category_id = ($this->Input->get('category_id') > 0 ) ? $this->Input->get('category_id') : false;
		$this->card_id = ($this->Input->get('id') > 0 ) ? $this->Input->get('id') : false;

		// New Card or someone answers
		if ( $this->sessionId != ""){
		//$resCats = $this->Database->prepare("select * from tl_rwcardsdata where id = '" . $this->card_id . "' and tl_rwcardsdata.sessionId = '" . $this->sessionId ."'");
		$resCats = $this->Database->prepare("select tl_rwcardsdata.*, tl_rwcards.* from tl_rwcardsdata, tl_rwcards where tl_rwcards.id = '" . $this->card_id . "' and tl_rwcardsdata.sessionId = '" . $this->sessionId ."'");

			$this->data = $resCats->execute()->fetchAllAssoc();
		}
		else{
		$resCats = $this->Database->prepare("select tl_rwcards.* from tl_rwcards where tl_rwcards.id = '" . $this->card_id . "'");

		$this->data = $resCats->execute()->fetchAllAssoc();
		}



		if (count($this->data) > 0){
			$count = 0;

			if ($objConfig->template == '')
			{
				$objTemplate->template = 'rwcards_filloutcard';
			}
		}

		/**
		 * set some vars
		 */
		$GLOBALS['TL_CSS'][''] = $this->Environment->base . "system/modules/rwcards/html/css/rwcards.filloutform.css";
		$objTemplate->data = $this->data;
		$objTemplate->rwcards_fillout_cards_please_fill_out = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_please_fill_out'] ;


		$objTemplate->rwcards_fillout_cards_name_to = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_name_to'];
		$objTemplate->rwcards_fillout_cards_email_to = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_email_to'];
		$objTemplate->rwcards_fillout_cards_add_receiver = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_add_receiver'];
		$objTemplate->rwcards_fillout_cards_remove_receiver = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_remove_receiver'];
		$objTemplate->rwcards_fillout_cards_back = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_back'];
		$objTemplate->rwcards_fillout_cards_preview_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_preview_card'];
		$objTemplate->rwcards_fillout_cards_send_card = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_send_card'];

		$objTemplate->reWritetoSender = ($this->Input->get('reWritetoSender')) ? 1 : 0;
		$objTemplate->category_id = $this->category_id;
		$objTemplate->sessionId;
		$objTemplate->alias = $alias;
		$objTemplate->formId = 'rwcards_fillout_form';
		$objTemplate->action = ampersand($this->Environment->request);


		// Form fields
		$arrFields = array
		(
			'rwNameFrom' => array
			(
				'name' => 'rwNameFrom',
				'label' => $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_name_from'],
				'value' => ($objTemplate->sessionId != "") ? trim($this->Session->get('rwNameFrom')) : trim($this->data[0]['nameTo']),
				'inputType' => 'text',
				'eval' => array('mandatory'=>true, 'maxlength'=>64)
			),
			'rwEmailFrom' => array
			(
				'name' => 'rwEmailFrom',
				'label' => $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_email_from'],
				'value' => ($objTemplate->sessionId != "") ? trim($this->Session->get('rwEmailFrom')) : trim($this->data[0]['emailTo']),
				'inputType' => 'text',
				'eval' => array('rgxp'=>'email', 'mandatory'=>true, 'maxlength'=>128, 'decodeEntities'=>true)
			),
			'rwMessage' => array
			(
				'name' => 'rwMessage',
				'id' => 'rwCardsFormMessage',
				'label' =>  $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_message'],
      			'inputType'    => 'textarea',
      			'eval'  => array('rte'=>'tinyFlash', 'decodeEntities'=>true, 'mandatory'=>true,),
				'value' => $this->Session->get('rwMessage')
			),
			'rwcardsReceiver' => array
			(
				'name' => 'rwcardsReceiver',
				'label' => $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_name_to'],
				'value' => ($objTemplate->sessionId != "") ? trim($this->Session->get('rwcardsReceiver')): trim($this->data[0]['nameFrom']),
				'inputType' => 'text',
				'eval' => array('mandatory'=>true, 'maxlength'=>64)
			),
			'rwCardsFormEmailTo' => array
			(
				'name' => 'rwCardsFormEmailTo',
				'label' => $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_email_to'],
				'value' => ($objTemplate->sessionId != "") ? $this->Session->get('rwCardsFormEmailTo'): trim($this->data[0]['emailFrom']),
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
;
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

//			$this->import("Session");
//
//			$this->Session->set($arrField['name'], $this->Input->post($arrField['name']));

		}
		$objTemplate->fields  = $arrWidgets;

		if ($this->Input->post('FORM_SUBMIT') == $objTemplate->formId && !$doNotSubmit)
		{

			foreach ( $_POST as $key=>$value ) {
			$this->Session->set($key, $this->Input->post($key));
			}

			// Preview button clicked
			if($this->Input->post('submit') == $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_preview_card'] ){

				$this->redirect($this->generateFrontendUrl('',  $objTemplate->alias . '/view/rwcardspreview/id/' . $this->data[0]['id'] .'/category_id/' . $this->category_id . '/reWritetoSender/' . $objTemplate->reWritetoSender . '/sessionId/' . @$this->sessionId . '/'. $objTemplate->alias ));
			}
			// Sending button clicked
			if($this->Input->post('submit') == $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_fillout_cards_send_card'] ){
				$this->redirect($this->generateFrontendUrl('',  $objTemplate->alias . '/view/rwcardssendcard/id/' . $this->data[0]['id'] .'/category_id/' . $this->category_id . '/'. $this->alias));
			}
		}
	}
}

?>