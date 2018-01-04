<?php
$GLOBALS['TL_DCA']['tl_rwcardsdata'] = array(

    'config' => array(
        'dataContainer' => 'Table',
        'switchToEdit'  => false,
        'closed'        => true,
        'sql'           => array(
            'keys' => array(
                'id' => 'primary'
            )
        )
    ),

    'list'     => array(
        // all settings that are applied to records listing
        // we can define here: sorting, panel layout (filter, search, limit fields), label format, global operations, operations on each record
        'sorting'           => array(
            'mode'        => 2,
            'fields'      => array( 'nameTo', 'emailTo', 'nameFrom', 'emailFrom', 'writtenOn', 'readOn', 'cardSent', 'cardRead' ),
            'flag'        => 1,
            'panelLayout' => 'sort, filter; search, limit',
        ),
        'label'             => array(
            'fields'         => array( 'nameFrom', 'emailFrom', 'picture', 'message', 'writtenOn', 'readOn', 'cardSent', 'cardRead' ),
            'format'         => $GLOBALS['TL_LANG']['tl_rwcardsdata']['nameFrom'][0] .
                                ': %s <span style="color:#b3b3b3; padding-left:3px;">[%s]</span><br/>' .
                                '<img src="%s" style="padding:5px 0px;" /><br/>' .
                                '<strong>' .
                                $GLOBALS['TL_LANG']['tl_rwcardsdata']['message'][0] .
                                '</strong><br/>%s<br/><br/>' .
                                '#cardSent# ' .
                                $GLOBALS['TL_LANG']['tl_rwcardsdata']['writtenOn'][0] .
                                ': %s<br/>' .
                                '#cardRead# ' .
                                $GLOBALS['TL_LANG']['tl_rwcardsdata']['readOn'][0] .
                                ': %s<br/>',
            'label_callback' => array( 'tl_rwcardsdata', 'addIcon' )
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
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\'' .
                                $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] .
                                '\')) return false; Backend.getScrollOffset();"',
            ),
        )
    ),
    'palettes' => array(
        'default' => '{nameTo},nameTo, emailTo,{nameFrom},nameFrom'
    ),
    'fields'   => array(
        'id'          => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp'      => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sessionId'      => array(
            'sql' => "varchar(50) NOT NULL default ''"
        ),
        'nameTo'    => array(
            'label'   => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['nameTo'],
            'search'  => true,
            'sorting' => true,
            'sql' => "varchar(50) NOT NULL default ''"
        ),
        'emailTo'   => array(
            'label'   => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['emailTo'],
            'search'  => true,
            'sorting' => true,
            'sql' => "varchar(50) NOT NULL default ''"
        ),
        'nameFrom'  => array(
            'label'   => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['nameFrom'],
            'search'  => true,
            'sorting' => true,
            'sql' => "varchar(50) NOT NULL default ''"
        ),
        'emailFrom' => array(
            'label'   => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['emailFrom'],
            'search'  => true,
            'sorting' => true,
            'sql' => "varchar(50) NOT NULL default ''"
        ),
        'picture'   => array(
            'label'  => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['picture'],
            'search' => true,
            'sql' => "varchar(400) NOT NULL default ''"
        ),
        'message'   => array(
            'label'  => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['message'],
            'search' => true,
            'sql' => "text NOT NULL"
        ),
        'writtenOn' => array(
            'label'   => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['writtenOn'],
            'search'  => true,
            'sorting' => true,
            'sql' => "date NOT NULL default '1999-01-01'"
        ),
        'readOn'    => array(
            'label'   => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['readOn'],
            'search'  => true,
            'sorting' => true,
            'sql' => "date NOT NULL default '1999-01-01'"
        ),
        'cardSent'  => array(
            'label'   => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['cardSent'],
            'search'  => true,
            'sorting' => true,
            'sql' => "SET('0','1') NOT NULL"
        ),
        'cardRead'  => array(
            'label'         => &$GLOBALS['TL_LANG']['tl_rwcardsdata']['cardRead'],
            'search'        => true,
            'sorting'       => true,
            'load_callback' => array( array( 'tl_rwcardsdata', 'cardRead' ) ),
            'sql' => "SET('0','1') NOT NULL"
        )
    )
);

class tl_rwcardsdata extends Backend
{
    /**
     * Add an image to each page in the tree
     *
     * @param array
     * @param string
     *
     * @return string
     */
    public function addIcon($row, $label)
    {
        //cardRead
        $trueGif  = $this->generateImage('visible.gif');
        $falseGif = $this->generateImage('delete.gif');

        $label = str_replace('#cardSent#', ($row['cardSent']) ? $trueGif : $falseGif, $label);
        $label = str_replace('#cardRead#', ($row['cardRead']) ? $trueGif : $falseGif, $label);

        return $label;
    }
}
