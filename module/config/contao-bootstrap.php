<?php

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
