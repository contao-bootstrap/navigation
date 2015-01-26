<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

// Frontend modules
$GLOBALS['FE_MOD']['navigationMenu']['bootstrap_navbar'] = 'Netzmacht\Bootstrap\Navigation\NavbarModule';

// Hooks
$GLOBALS['TL_HOOKS']['isVisibleElement'][] = array('Netzmacht\Bootstrap\Navigation\Hooks', 'setRuntimeNavClass');
