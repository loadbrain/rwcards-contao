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
 * Class ListRwCards 
 *
 * @copyright  LoadBrain 2011
 * @author     Ralf Weber <http://www.loadbrain.de>
 * @package    Controller
 */
class ListRwCards extends Frontend
{

	/**
	 * Add comments to a template
	 * @param object
	 * @param object
	 * @param string
	 * @param integer
	 */
	public function addCardsToTemplate($objTemplate, $objConfig, $strSource, $intParent, $alias){
		#global $objPage;
		$objPage = new stdClass();

		$limit = null;
		$this->data = array();
		$this->sessionId = (\Input::get('sessionId') != "" ) ? \Input::get('sessionId') : false;
		$objPage = $this->Database->prepare('SELECT id, alias FROM tl_page WHERE id=?')->execute($intParent);
		//$objPage = $this->Database->prepare('SELECT * FROM tl_page WHERE id=47')->execute()->fetchAllAssoc();
		$this->nextPage = $objPage->fetchAssoc();
//print_r($objPage); exit;
		 
		// Pagination

		if ($objConfig->perPage > 0)
		{
			$page = \Input::get('page') ? \Input::get('page') : 1;
			$limit = $objConfig->perPage;
			$offset = ($page - 1) * $objConfig->perPage;

			// Get total number of comments
			$objTotal = $this->Database->prepare("SELECT COUNT(*) AS count FROM tl_rwcards WHERE published=1")->execute();
			// Add pagination menu
			$objPagination = new Pagination($objTotal->count, $objConfig->perPage);
			$objTemplate->pagination = $objPagination->generate("\n  ");
		}


		//Get all published categories
		$resCats = $this->Database->prepare("SELECT tl_rwcards_category.* FROM tl_rwcards_category WHERE tl_rwcards_category.published = 1")->execute();
		
		$this->categories = $resCats->fetchAllAssoc();

		// Get all Cards for each category to build a slideshow with them
		$i = 0;
		foreach ($this->categories as $val){
			$obListRwCardsStmt = $this->Database->prepare("select tl_rwcards.*, tl_rwcards_category.id, tl_rwcards_category.category_kategorien_name, tl_rwcards_category.category_description, tl_files.path from " .
			"tl_rwcards left join tl_rwcards_category on tl_rwcards_category.id = " . (int)$val['id'] . " left join tl_files on tl_files.uuid =  tl_rwcards.picture where (tl_rwcards.pid = " . (int)$val['id'] . " and tl_rwcards.published  = 1) " .
			"order by tl_rwcards.id");
			if ($limit){
				$obListRwCardsStmt->limit($limit, $offset);
			}
			//$obListRwCardsStmt;
			$this->data[$i++] = $obListRwCardsStmt->execute()->fetchAllAssoc();
		}


		if (count($this->data) > 0){
			$count = 0;//

			if ($objConfig->template == '' or $objConfig->template == 'rwcardsReWriteCard')
			{

				$objConfig->template = 'rwcards_list';
                                         //var_dump($objConfig->template); exit;
			}
		}


		
		/**
		 * set some vars
		 */
		//$GLOBALS['TL_JAVASCRIPT'][''] = $this->Environment->base . "system/modules/rwcards/assets/slideshow_rwcards/js/slideshow.js";
		$GLOBALS['TL_CSS'][''] = \Environment::get('base') . "system/modules/rwcards/assets/slideshow_rwcards/css/slideshow.css";
		$objTemplate->seeAllCards = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_listcards_see_all_cards'];
		$objTemplate->noCategoriesPublished = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_listcards_no_category_published_or_created'];
		$objTemplate->data = $this->data;
		$objTemplate->categories = $this->categories;
		$objTemplate->pageId = $intParent;
		$objTemplate->view = $objConfig->view;
        $objTemplate->reWritetoSenderId = (\Input::get('view') == "reWritetoSender") ? \Input::get('id') : null;
		$objTemplate->alias = $alias;
		$objTemplate->reWritetoSender = (\Input::get('view') == "reWritetoSender") ? 1 : 0;
		$objTemplate->sessionId = $this->sessionId;
		$objTemplate->nextPage = $this->nextPage;
		++$count;
	}
}

?>
