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
class OneCategoryRwCards extends \Frontend
{
	/**
	 * Add all cards of one category to a template
	 * @param object
	 * @param object
	 * @param string
	 * @param integer
	 */
	public function addToTemplate($objTemplate, $objConfig, $strSource, $intParent, $alias){
		$this->import('ImageSize');
		$objPage = new stdClass();


		$objPage = $this->Database->prepare('SELECT id, alias FROM tl_page WHERE id=?')->execute($intParent);
		$this->nextPage = $objPage->fetchAssoc();
		
		$limit = null;
		$data = array();
		$this->sessionId = (\Input::get('sessionId') != "" ) ? \Input::get('sessionId') : false;
		$this->category_id = (\Input::get('category_id') > 0 ) ? \Input::get('category_id') : false;
		// get the total number of records
		$this->cardsPerLine = $_SESSION['rwcards']['config']['rwcards_cards_per_row'];
		$this->limit = $_SESSION['rwcards']['config']['rwcards_rows_per_page'];
        $objTemplate->rewriteCardId = (\Input::get('reWritetoSender')) ? \Input::get('id') : null;

		// Get total number of comments
		$objTotal = $this->Database->prepare("select count(*) from tl_rwcards where tl_rwcards.pid = '" . $this->category_id . "' and tl_rwcards.published = '1' order by tl_rwcards.id asc")->execute();

		// Add pagination menu
		$objPagination = new Pagination($objTotal->count, $this->limit);
		$objTemplate->pagination = $objPagination->generate("\n  ");

		if ($objConfig->view == 'rwconecategory'){
		$resCats = $this->Database->prepare("SELECT tl_rwcards_category.* FROM tl_rwcards_category WHERE tl_rwcards_category.published = 1")->execute();
		$this->category = $resCats->fetchAssoc();
		$this->category_id = $this->category['id'];
		$resCats = $this->Database->prepare("select tl_rwcards.*, tl_files.path from tl_rwcards left join tl_files on tl_files.uuid =  tl_rwcards.picture  where tl_rwcards.pid = '" . $this->category_id . "' and tl_rwcards.published = '1' order by id");
		$objConfig->template = '';
		$objTemplate->template = 'rwcards_onecategory';
			//document.location.href= '<?php echo $this->Environment->base . $this->generateFrontendUrl(array(),  $alias . '/view/rwconecategory/category_id/' . $this->category_id  . '/reWritetoSender/' . $this->sessionId . '/reWritetoSenderId/' . $this->data[$i]['id'] . '/sessionId/' . $this->sessionId. '/' . $alias); 

		} else{		// All published pictures from this category
			$resCats = $this->Database->prepare("select tl_rwcards.*, tl_files.path from tl_rwcards left join tl_files on tl_files.uuid =  tl_rwcards.picture  where tl_rwcards.pid = '" . $this->category_id . "' and tl_rwcards.published = '1' order by id");
			//echo "one cat: select tl_rwcards.*, tl_files.path from tl_rwcards  left join tl_files on tl_files.uuid =  tl_rwcards.picture where tl_rwcards.pid = '1' and tl_rwcards.published = '1'  order by id";
		}
		$this->data = $resCats->execute()->fetchAllAssoc();

		if (count($this->data) > 0){
			$count = 0;

			if ($objConfig->template == '')
			{
				$objTemplate->template = 'rwcards_onecategory';
			}
		}

		/**
		 * set some vars
		 */
		$GLOBALS['TL_CSS'][''] = \Environment::get('base') . "system/modules/rwcards/assets/css/rwcards.onecategory.css";
		$objTemplate->data = $this->data;
		$objTemplate->rwcards_one_category_listcards_click_on_card_to_preview = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_one_category_listcards'] ;
		$objTemplate->rwcards_one_category_listcards_category_chosen_category = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_one_category_chosen_category'];
		$objTemplate->rwcards_one_category_listcards_rwcards_one_category_send_this_image = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_one_category_send_this_image'];
		$objTemplate->noCategoriesPublished = $GLOBALS['TL_LANG']['tl_rwcards']['rwcards_listcards_no_category_published_or_created'];
		$objTemplate->cardsPerLine = $this->cardsPerLine;
		$objTemplate->reWritetoSender = (\Input::get('reWritetoSender')) ? 1 : 0;
		$objTemplate->sessionId = $this->sessionId;
		$objTemplate->alias = $alias;
		$objTemplate->view = $objConfig->view;
		$objTemplate->category_id = $this->category_id;

	if ($objConfig->view != 'rwconecategory'){
			$objTemplate->categories = $this->getCategories();
			$objTemplate->category_ids = $this->_catIds();
		//		$objTemplate->categories = $this->categories;
		}
		
		$objTemplate->nextPage = $this->nextPage;
		$objTemplate->objPage = clone $objPage;
//var_dump($objTemplate->data);
	}

	public function getCategories(){
		// First all categories;

		$this->category_id = \Input::get('category_id');
		$categories = array();

		$resCats = $this->Database->prepare("SELECT id AS value, category_kategorien_name AS label FROM tl_rwcards_category where published > 0 order by category_kategorien_name asc");
		$this->categories = $resCats->execute()->fetchAllAssoc();

		$widget = new FormSelectMenu();
		$widget->id = 'category_id';
		$widget->label = 'Kategorie';
		$widget->options = serialize($this->categories) ;
		$widget->value = ($this->category_id != "") ? $this->category_id : '';
		$widget->optionSelected($this->category_id, $this->category_id);
		return $widget->generate();

	}

	public function _catIds(){
		$resCats = $this->Database->prepare("SELECT id AS value FROM tl_rwcards_category where published > 0 order by category_kategorien_name asc");
		return $resCats->execute()->fetchAllAssoc();
	}
}

?>