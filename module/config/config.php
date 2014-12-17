<?php

// Frontend modules
$GLOBALS['FE_MOD']['navigationMenu']['bootstrap_navbar'] = 'Netzmacht\Bootstrap\Navbar\Navbar';

// Hooks
$GLOBALS['TL_HOOKS']['isVisibleElement'][] = array('Netzmacht\Bootstrap\Navbar\Hooks', 'setRuntimeNavClass');
