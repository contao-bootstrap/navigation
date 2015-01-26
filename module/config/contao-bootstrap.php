<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

return array(
    'navigation' => array(
        'item-helper' => array(
            'dropdown' => 'Netzmacht\Bootstrap\Navigation\ItemHelper\DropdownItemHelper'
        ),
    ),
    'templates'  => array(
        'parsers'   => array(
            'callback_replace-classes' => array(
                'templates' => array('mod_bootstrap_modal*'),
            ),
        ),
        'modifiers' => array(
            'callback_replace-image-classes' => array(
                'templates' => array('mod_bootstrap_modal*'),
            ),
            'callback_replace-table-classes' => array(
                'templates' => array('mod_bootstrap_modal*'),
            ),
        ),
    ),
    'config'     => array(
        'options' => array(
            'dropdown' => array(
                'formless' => array(
                    'mod_quicklink',
                    'mod_quicknav',
                ),
            ),
        ),
    ),
);
