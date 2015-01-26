<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Navigation;

use Netzmacht\Html\CastsToString;

/**
 * Interface ItemHelper describes helpers which are used in navigation templates.
 *
 * @package Netzmacht\Bootstrap\Components\Navigation
 */
interface ItemHelper extends CastsToString
{

    /**
     * Get the navigation template.
     *
     * @return \FrontendTemplate
     */
    public function getTemplate();

    /**
     * Consider if current item is used as header.
     *
     * @return bool
     */
    public function isHeader();

    /**
     * Get current item.
     *
     * @return array
     */
    public function getItem();

    /**
     * Get the dropdown toggle element.
     *
     * @return string
     */
    public function getDropdownToggle();

    /**
     * Consider if item is a dropdown.
     *
     * @return boolean
     */
    public function isDropdown();

    /**
     * Get item class.
     *
     * @param bool $asArray If true class is returned as array. Otherwise as string.
     *
     * @return string|array
     */
    public function getItemClass($asArray = false);
}
