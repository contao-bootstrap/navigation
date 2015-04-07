<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_module']['metapalettes']['bootstrap_navbar'] = array
(
    'title'                     => array('name', 'type'),
    'config'                    => array('bootstrap_isResponsive', 'bootstrap_addHeader', 'bootstrap_navbarModules'),
    'protected'                 => array(':hide', 'protected'),
    'expert'                    => array(':hide', 'guests', 'cssID', 'space'),
    'template'                  => array(':hide', 'bootstrap_navbarTemplate'),
);

\MetaPalettes::appendFields('tl_module', 'navigation', 'template', array('bootstrap_navClass'));
\MetaPalettes::appendFields('tl_module', 'customnav', 'template', array('bootstrap_navClass'));
\MetaPalettes::appendFields('tl_module', 'quicklink', 'template', array('bootstrap_navClass'));


/**
 * subpalettes
 */
$GLOBALS['TL_DCA']['tl_module']['metasubpalettes']['bootstrap_addHeader'] = array
(
    'bootstrap_navbarBrandTemplate',
);


/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(100) NOT NULL default ''",
);


$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_isResponsive'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_isResponsive'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'default'                 => true,
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_addHeader'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_addHeader'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class' => 'w50', 'submitOnChange' => true),
    'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarModules'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules'],
    'exclude'                 => true,
    'inputType'               => 'multiColumnWizard',
    'eval'                    => array(
        'tl_class'     => '" style="clear:both;',
        'columnFields' => array
        (
            'module'   => array
            (
                'label'            => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_module'],
                'inputType'        => 'select',
                'options_callback' => array('Netzmacht\Bootstrap\Core\Contao\DataContainer\Module', 'getAllModules'),
                'eval'             => array('style' => 'width: 250px', 'includeBlankOption' => true, 'chosen' => true),
            ),

            'floating' => array
            (
                'label'     => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_floating'],
                'inputType' => 'select',
                'options'   => array('left', 'right'),
                'reference' => &$GLOBALS['TL_LANG']['MSC'],
                'eval'      => array('style' => 'width: 80px', 'includeBlankOption' => true, 'chosen' => true),
            ),

            'cssClass' => array
            (
                'label'     => $GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_cssClass'],
                'inputType' => 'text',
                'eval'      => array('style' => 'width: 180px', 'rgxp' => 'txt'),
            ),

            'inactive' => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarModules_inactive'],
                'inputType' => 'checkbox',
                'eval'      => array('style' => 'width: 80px'),
            ),
        )
    ),
    'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarTemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarTemplate'],
    'default'                 => 'mod_navbar',
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('Netzmacht\Bootstrap\Core\Contao\DataContainer\Module', 'getTemplates'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
    'eval'                    => array('templatePrefix' => 'mod_navbar'),
    'sql'                     => "varchar(32) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bootstrap_navbarBrandTemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['bootstrap_navbarBrandTemplate'],
    'default'                 => 'mod_navbar',
    'exclude'                 => true,
    'inputType'               => 'select',
    'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
    'options_callback'        => array('Netzmacht\Bootstrap\Core\Contao\DataContainer\Module', 'getTemplates'),
    'eval'                    => array('templatePrefix' => 'navbar_brand', 'chosen' => true, 'tl_class' => 'clr'),
    'sql'                     => "varchar(64) NOT NULL default ''",
);
