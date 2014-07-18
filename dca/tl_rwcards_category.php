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
$GLOBALS['TL_DCA']['tl_rwcards_category'] = array
(

  'config' => array
  (
    'dataContainer'               => 'Table',
    'ctable'                      => array('tl_rwcards'),
    'switchToEdit'                => true
  ),

  'list' => array
  (
    // all settings that are applied to records listing
    // we can define here: sorting, panel layout (filter, search, limit fields), label format, global operations, operations on each record
    'sorting' => array
    (
      'mode'                    => 1,
      'fields'                  => array('category_kategorien_name'),
      'flag'                    => 1,
      'panelLayout'             => 'filter, search,limit'
    ),
    'label' => array
    (
      'fields'                  => array('category_kategorien_name'),
      'format'                  => '%s'
    ),
    'global_operations' => array
    (
      'all' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
        'href'                => 'act=select',
        'class'               => 'header_edit_all',
        'attributes'          => 'onclick="Backend.getScrollOffset();"'
      )
    ),
    'operations' => array
    (
      'edit' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards_category']['edit'],
        'href'                => 'table=tl_rwcards',
        'icon'                => 'edit.gif',
      ),
      'copy' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards_category']['copy'],
        'href'                => 'act=copy',
        'icon'                => 'copy.gif',
      ),
      'delete' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards_category']['delete'],
        'href'                => 'act=delete',
        'icon'                => 'delete.gif',
        'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
      ),
      'show' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards_category']['show'],
        'href'                => 'act=show',
        'icon'                => 'show.gif'
      )
    )
  ),

  'palettes' => array
  (
    'default'                     => '{category_kategorien_name_legend},category_kategorien_name,category_description;{published_legend},published'
  ),

  'fields' => array
  (
     'category_kategorien_name' => array
    (
      'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards_category']['category_kategorien_name'],
      'inputType'               => 'text',
      'search'                  => true,
      'eval'                    => array('mandatory'=>true, 'maxlength'=>64)
    ),
    'category_description' => array
    (
      'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards_category']['category_description'],
      'inputType'               => 'textarea',
      'eval'                    => array('rte' => 'tinyFlash')
    ),
	'published' => array
	(
		'label'                 => &$GLOBALS['TL_LANG']['tl_rwcards_category']['published'],
		'exclude'               => true,
		'filter'                => true,
		'inputType'             => 'checkbox',
		'eval'                  => array('doNotCopy'=>true)
	)
  )
);

?><?php
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
$GLOBALS['TL_DCA']['tl_rwcards_category'] = array
(

  'config' => array
  (
    'dataContainer'               => 'Table',
    'ctable'                      => array('tl_rwcards'),
    'switchToEdit'                => true
  ),

  'list' => array
  (
    // all settings that are applied to records listing
    // we can define here: sorting, panel layout (filter, search, limit fields), label format, global operations, operations on each record
    'sorting' => array
    (
      'mode'                    => 1,
      'fields'                  => array('category_kategorien_name'),
      'flag'                    => 1,
      'panelLayout'             => 'filter, search,limit'
    ),
    'label' => array
    (
      'fields'                  => array('category_kategorien_name'),
      'format'                  => '%s'
    ),
    'global_operations' => array
    (
      'all' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
        'href'                => 'act=select',
        'class'               => 'header_edit_all',
        'attributes'          => 'onclick="Backend.getScrollOffset();"'
      )
    ),
    'operations' => array
    (
      'edit' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards_category']['edit'],
        'href'                => 'table=tl_rwcards',
        'icon'                => 'edit.gif',
      ),
      'copy' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards_category']['copy'],
        'href'                => 'act=copy',
        'icon'                => 'copy.gif',
      ),
      'delete' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards_category']['delete'],
        'href'                => 'act=delete',
        'icon'                => 'delete.gif',
        'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
      ),
	'toggle' => array
	(
		'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events']['toggle'],
		'icon'                => 'visible.gif',
		'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
		'button_callback'     => array('tl_rwcards_category', 'toggleIcon')
	), 
      'show' => array
      (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards_category']['show'],
        'href'                => 'act=show',
        'icon'                => 'show.gif'
      )
    )
  ),

  'palettes' => array
  (
    'default'                     => '{category_kategorien_name_legend},category_kategorien_name,category_description;{published_legend},published'
  ),

  'fields' => array
  (
     'category_kategorien_name' => array
    (
      'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards_category']['category_kategorien_name'],
      'inputType'               => 'text',
      'search'                  => true,
      'eval'                    => array('mandatory'=>true, 'maxlength'=>64)
    ),
    'category_description' => array
    (
      'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards_category']['category_description'],
      'inputType'               => 'textarea',
      'eval'                    => array('rte' => 'tinyFlash')
    ),
	'published' => array
	(
		'label'                 => &$GLOBALS['TL_LANG']['tl_rwcards_category']['published'],
		'exclude'               => true,
		'filter'                => true,
		'inputType'             => 'checkbox',
		'eval'                  => array('doNotCopy'=>true)
	)
  )
);

class tl_rwcards_category extends Backend
{
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{ 
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_rwcards_category::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}
	
	/**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');

	
		// Update the database
		$this->Database->prepare("UPDATE tl_rwcards_category SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

	}	
}
?>