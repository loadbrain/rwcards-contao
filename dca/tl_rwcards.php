<?php

$GLOBALS['TL_DCA']['tl_rwcards'] = array(

    // Config
    'config'   => array(
        'dataContainer' => 'Table',
        'ptable'        => 'tl_rwcards_category',
        'sql'           => array(
            'keys' => array(
                'id' => 'primary',
                'pid' => 'index'
            )
        )
    ),
    // List
    'list'     => array(
        'sorting'           => array(
            'mode'                  => 4,
            'fields'                => array( 'autor' ),
            'flag'                  => 1,
            'headerFields'          => array( 'category_kategorien_name' ),
            'panelLayout'           => 'search,limit, filter',
            'child_record_callback' => array( 'tl_rwcards', 'listCards' )
        ),
        'global_operations' => array(
            'all' => array(
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations'        => array(
            'edit'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_rwcards']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif'
            ),
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_rwcards']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif'
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_rwcards']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\'' .
                                $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] .
                                '\')) return false; Backend.getScrollOffset();"'
            ),
            'toggle' => array(
                'label'           => &$GLOBALS['TL_LANG']['tl_calendar_events']['toggle'],
                'icon'            => 'visible.gif',
                'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => array( 'tl_rwcards', 'toggleIcon' )
            ),
            'show'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_rwcards']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            )
        )
    ), // end of list array
    // Palettes
    'palettes' => array(
        'default' => '{autor_legend},autor,email;{picture_legend},picture;;size;{description_legend},description;published'
    ),
    // Fields
    'fields'   => array(
        'id'          => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid'         => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp'      => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'autor'       => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_rwcards']['autor'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array( 'mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w50' ),
            'sql'       => "varchar(150) NOT NULL default ''"
        ),
        'email'       => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_rwcards']['email'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array( 'mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w50' ),
            'sql'       => "varchar(50) NOT NULL default ''"
        ),
        'picture'     => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_rwcards']['picture'],
            'inputType' => 'fileTree',
            'eval'      => array( 'files' => true, 'filesOnly' => true, 'fieldType' => 'radio' ),
            'sql'       => "binary(16) NULL"
        ),
        'size'        => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_rwcards']['size'],
            'default'   => array( '260', '220' ),
            'exclude'   => true,
            'inputType' => 'imageSize',
            'options'   => array( 'box', 'proportional', 'crop' ),
            'reference' => &$GLOBALS['TL_LANG']['MSC'],
            'eval'      => array( 'rgxp' => 'digit', 'nospace' => true, 'tl_class' => 'w50' ),
            'sql'       => "varchar(64) NOT NULL default ''"
        ),
        'description' => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_rwcards']['description'],
            'inputType' => 'textarea',
            'eval'      => array( 'rte' => 'tinyFlash' ),
            'sql'       => "text NOT NULL"
        ),
        'published'   => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_rwcards']['published'],
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => array( 'doNotCopy' => true ),
            'sql'       => "char(1) NOT NULL default '1'"
        )
    )
); // end of $GLOBALS['TL_DCA']['tl_cds'] array

class tl_rwcards extends Backend
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
     *
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     *
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if(strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if(!$this->User->isAdmin && !$this->User->hasAccess('tl_rwcards::published', 'alexf'))
        {
            return '';
        }

        $href .= '&tid=' . $row['id'] . '&state=' . ($row['published'] ? '' : 1);

        if(!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        return '<a href="' .
               $this->addToUrl($href) .
               '" title="' .
               specialchars($title) .
               '"' .
               $attributes .
               '>' .
               Image::getHtml($icon, $label) .
               '</a> ';
    }

    /**
     * Disable/enable a user group
     *
     * @param integer
     * @param boolean
     */
    public function toggleVisibility($intId, $blnVisible)
    {
        // Check permissions to edit
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        // Update the database
        $this->Database->prepare("UPDATE tl_rwcards SET tstamp=" . time() . ", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
                       ->execute($intId);
    }

    /**
     * List cds of our collection
     *
     * @param array
     *
     * @return string
     */
    public function listCards($arrRow)
    {
        if($arrRow['picture'] == '')
        {
            return '';
        }

        $objFile = \FilesModel::findByUuid($arrRow['picture']);

        if($objFile === null)
        {
            if(!Validator::isUuid($arrRow['picture']))
            {
                return '<p class="error">' . $GLOBALS['TL_LANG']['ERR']['version2format'] . '</p>';
            }

            return '';
        }

        if(!is_file(TL_ROOT . '/' . $objFile->path))
        {
            return '';
        }

        return '<div><img src=" ' .
               $objFile->path .
               '  " style="height:100px; width:100px; float:left; margin-right: 1em;" /><p><strong>' .
               $arrRow['autor'] .
               '</strong> (' .
               $arrRow['email'] .
               ')</p>' .
               $arrRow['description'] .
               '</div>' .
               "\n";
    }
}
