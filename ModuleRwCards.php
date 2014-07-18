<?php

if (!defined('TL_ROOT'))
    die('You cannot access this file directly!');

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
class ModuleRwCards extends \Module {

    protected $strTemplate = '';

    public function _getTemplate() {
		//print_r(\Input::get('view')); 
        if (\Input::get('view') == "rwconecategory") {
            $this->strTemplate = "rwcards_onecategory";
        }
        if ($this->Input->get('view') == "rwcardsfilloutcard") {
            $this->strTemplate = "rwcards_filloutcard";
        }
        if ($this->Input->get('view') == "rwcardspreview") {
            $this->strTemplate = "rwcards_preview";
        }
        if ($this->Input->get('view') == "rwcardssendcard" or $this->Input->get('view') == "rwcardsReWriteCard") {
            $this->strTemplate = "rwcards_sendcard";
        }
        if ($this->Input->get('view') == "" or $this->Input->get('view') == "reWritetoSender") {
            $this->strTemplate = "rwcards_list";
			$this->Template = new \FrontendTemplate($this->strTemplate);
        }
    }

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate() {
		if (TL_MODE == 'BE')
		{

			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### RWCARDS ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		
		$this->_getTemplate();
        return parent::generate();
    }

    protected function compile() {

        global $objPage;
        //var_dump($this->Input->get('view')); exit;
		//var_dump(\Input::get('view')); exit;
        /**
         * Global Session Array for config values
         */
        $this->_getTemplate();

        if(\Input::get('view') == ""){
            session_destroy();
        }
		
        if ($_SESSION['rwcards']['config'] == "") {
            $_SESSION['rwcards']['rwcards_session'] = session_id();
            $res = $this->Database->execute("select rwcards_view_categories, rwcards_cards_per_row, rwcards_rows_per_page, rwcards_keep_cards, rwcards_thumb_box_width, rwcards_thumb_box_height, rwcards_per_attachement,rwcards_thumbnail_width, rwcards_thumbnail_height from tl_module where type = 'RWCards'");
            $data = $res->fetchAssoc();
            $_SESSION['rwcards']['config']['rwcards_view_categories'] = $data['rwcards_view_categories'];
            $_SESSION['rwcards']['config']['rwcards_cards_per_row'] = $data['rwcards_cards_per_row'];
            $_SESSION['rwcards']['config']['rwcards_rows_per_page'] = $data['rwcards_rows_per_page'];
            $_SESSION['rwcards']['config']['rwcards_keep_cards'] = $data['rwcards_keep_cards'];
            $_SESSION['rwcards']['config']['rwcards_thumb_box_width'] = $data['rwcards_thumb_box_width'];
            $_SESSION['rwcards']['config']['rwcards_thumb_box_height'] = $data['rwcards_thumb_box_height'];
            $_SESSION['rwcards']['config']['rwcards_per_attachement'] = $data['rwcards_per_attachement'];
            $_SESSION['rwcards']['config']['rwcards_thumbnail_width'] = $data['rwcards_thumbnail_width'];
            $_SESSION['rwcards']['config']['rwcards_thumbnail_height'] = $data['rwcards_thumbnail_height'];
        }


        /**
         * List RwCards
         */
		 
		// all categories or directly all cards (only one cat exisists)
		$this->view = ($this->rwcards_view_categories == 0 ) ? "" : "rwconecategory";
        if ( (\Input::get('view') == "" and $this->view == "") or \Input::get('view') == "reWritetoSender" ) {
            $this->import('ListRwCards');
            $objConfig = new stdClass();
            $objConfig->perPage = $this->perPage;
			$objConfig->view = $this->view;
            $objConfig->template = $this->strTemplate;
			$this->Template->setData($this->arrData);
            $this->ListRwCards->addCardsToTemplate($this->Template, $objConfig, 'tl_page', $objPage->id, $objPage->alias);
        }

        /**
         * Show Cards of one category RwCards
         */
        if (\Input::get('view') == "rwconecategory" or $this->view == "rwconecategory") {
            $this->import('OneCategoryRwCards');
            $objConfig = new stdClass();
            $objConfig->perPage = $this->perPage;
			$objConfig->view = $this->view;
            $objTemplate = new \FrontendTemplate("rwcards_onecategory");
            $objConfig->template = $this->strTemplate;
            $this->OneCategoryRwCards->addToTemplate($this->Template, $objConfig, 'tl_page', $objPage->id, $objPage->alias);
        }
        /**
         * Fill out Cards of one category RwCards
         */
        if (\Input::get('view') == "rwcardsfilloutcard") {
            $this->import('FillOutCardRwCards');
            $objConfig = new stdClass();
            $objConfig->perPage = $this->perPage;
            $objTemplate = new FrontendTemplate("rwcards_filloutcard");
            $objConfig->template = $this->strTemplate;
            $this->FillOutCardRwCards->addToTemplate($this->Template, $objConfig, 'tl_page', $objPage->id, $objPage->alias);
        }
        /**
         * Preview Cards of one category RwCards
         */
        if (\Input::get('view') == "rwcardspreview") {
            $this->import('PreviewCardRwCards');
            $objConfig = new stdClass();
            $objConfig->perPage = $this->perPage;
            $objTemplate = new FrontendTemplate("rwcards_preview");
            $objConfig->template = $this->strTemplate;
            $this->PreviewCardRwCards->addToTemplate($this->Template, $objConfig, 'tl_page', $objPage->id, $objPage->alias);
        }
        /**
         * Send Card of one category RwCards
         */
        if (\Input::get('view') == "rwcardssendcard" or \Input::get('view') == "rwcardsReWriteCard") {
            $this->import('SendCardRwCards');
            $objConfig = new stdClass();
            $objConfig->perPage = $this->perPage;
            $objTemplate = new FrontendTemplate("rwcards_sendcard");
            $objConfig->template = $this->strTemplate;
            $this->SendCardRwCards->addToTemplate($this->Template, $objConfig, 'tl_page', $objPage->id, $objPage->alias);
        }
    }

}

?>