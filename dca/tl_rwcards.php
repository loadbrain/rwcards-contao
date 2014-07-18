<?php

$GLOBALS['TL_DCA']['tl_rwcards'] = array
(

// Config
  'config' => array
(
    'dataContainer'               => 'Table',
    'ptable'                      => 'tl_rwcards_category',
),
// List
  'list' => array
(
  'sorting' => array
(
      'mode'                    => 4,
      'fields'                  => array('autor'),
      'flag'                    => 1,
      'headerFields'            => array('category_kategorien_name'),
      'panelLayout'             => 'search,limit, filter',
      'child_record_callback'   => array('tl_rwcards', 'listCards')
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
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards']['edit'],
        'href'                => 'act=edit',
        'icon'                => 'edit.gif'
        ),
      'copy' => array
        (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards']['copy'],
        'href'                => 'act=copy',
        'icon'                => 'copy.gif'
        ),
      'delete' => array
        (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards']['delete'],
        'href'                => 'act=delete',
        'icon'                => 'delete.gif',
        'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
        ),
      'show' => array
        (
        'label'               => &$GLOBALS['TL_LANG']['tl_rwcards']['show'],
        'href'                => 'act=show',
        'icon'                => 'show.gif'
        )
        ),
        ), // end of list array
        // Palettes
  'palettes' => array
        (
  'default'                     => '{autor_legend},autor,email;{picture_legend},picture;;size;{description_legend},description;published'
  ),
  // Fields
  'fields' => array
  (
    'autor' => array
  (
      'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards']['autor'],
      'inputType'               => 'text',
      'search'                  => true,
      'eval'                    => array('mandatory'=>true, 'maxlength'=>64, 'tl_class'=>'w50')
  ),
    'email' => array
  (
      'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards']['email'],
      'inputType'               => 'text',
      'search'                  => true,
      'eval'                    => array('mandatory'=>true, 'maxlength'=>64, 'tl_class'=>'w50')
  ),
    'picture' => array
  (
      'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards']['picture'],
      'inputType'               => 'fileTree',
      'eval'                    => array('files'=>true, 'filesOnly'=>true, 'fieldType'=>'radio')
  ),
    'size' => array
  (
		'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards']['size'],
    	'default'					=> array('260', '220'),
		'exclude'                 => true,
		'inputType'               => 'imageSize',
		'options'                 =>  array('box', 'proportional', 'crop'),
		'reference'               => &$GLOBALS['TL_LANG']['MSC'],
		'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
  ),
    'description' => array
  (
      'label'                   => &$GLOBALS['TL_LANG']['tl_rwcards']['description'],
      'inputType'               => 'textarea',
      'eval'                    => array('rte'=>'tinyFlash')
  ),
	'published' => array
  (
		'label'                 => &$GLOBALS['TL_LANG']['tl_rwcards']['published'],
		'exclude'               => true,
		'filter'                => true,
		'inputType'             => 'checkbox',
		'eval'                  => array('doNotCopy'=>true)
  )
  )
  ); // end of $GLOBALS['TL_DCA']['tl_cds'] array


  class tl_rwcards extends Backend {

  	/**
  	 * List cds of our collection
  	 * @param array
  	 * @return string
  	 */
  	public function listCards($arrRow)
  	{
  		return '<div>
    <img src=" ' . $arrRow['picture'] . '  " style="height:100px; width:100px; float:left; margin-right: 1em;" /><p><strong>' . $arrRow['autor'] . '</strong> (' . $arrRow['email'] . ')</p>' . $arrRow['description']
  		. '</div>' . "\n";
  	}

  }
  ?>