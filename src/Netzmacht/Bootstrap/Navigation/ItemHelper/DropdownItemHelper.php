<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Navigation\ItemHelper;

use Netzmacht\Bootstrap\Navigation\ItemHelper;
use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;

/**
 * Class NavbarItemHelper is made for dropdown navigation link in the navbar.
 *
 * @package Netzmacht\Bootstrap\Navigation\ItemHelper
 */
class DropdownItemHelper extends Attributes implements ItemHelper
{
    /**
     * Current item.
     *
     * @var array
     */
    protected $item;

    /**
     * Item template.
     *
     * @var \FrontendTemplate
     */
    protected $template;

    /**
     * Item is a header.
     *
     * @var bool
     */
    protected $isHeader = false;

    /**
     * Item is a dropdown.
     *
     * @var bool
     */
    protected $isDropdown = false;

    /**
     * Item classes.
     *
     * @var array
     */
    protected $itemClass = array();

    /**
     * Construct.
     *
     * @param array             $item       Current navigation item.
     * @param \FrontendTemplate $template   Parent template.
     * @param array             $attributes Additional attributes.
     */
    public function __construct(array $item, \FrontendTemplate $template, $attributes = array())
    {
        $this->item     = $item;
        $this->template = $template;

        parent::__construct($attributes);

        $this->initialize();
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    public function isHeader()
    {
        return $this->isHeader;
    }

    /**
     * {@inheritdoc}
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropdownToggle()
    {
        return Bootstrap::getConfigVar('dropdown.toggle');
    }

    /**
     * {@inheritdoc}
     */
    public function isDropdown()
    {
        return $this->isDropdown;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemClass($asArray = false)
    {
        if ($asArray) {
            return $this->itemClass;
        }

        return implode(' ', $this->itemClass);
    }

    /**
     * Initialize the helper.
     *
     * @return void
     */
    private function initialize()
    {
        $level = (intval(substr($this->template->level, 6)) + 1);

        $this->initializeAttributes();
        $this->initializeCssClass();

        if ($this->item['type'] == 'm17Folder' || $this->item['type'] == 'folder') {
            $this->isHeader = ($level != 1 && ($level % 2) == 1);
        }

        if ($this->item['subitems'] && $level == 2) {
            $this->isDropdown = true;
        }
    }

    /**
     * Initialize attributes.
     *
     * @return void
     */
    private function initializeAttributes()
    {
        $pass = array('href', 'accesskey', 'tabindex');
        foreach ($pass as $attribute) {
            $this->setAttribute($attribute, $this->item[$attribute]);
        }

        $title = $this->item['pageTitle'] ?: $this->item['title'];
        $this->setAttribute('title', $title);

        if ($this->item['nofollow']) {
            $this->setAttribute('rel', 'nofollow');
        }
    }

    /**
     * Initialize css classes.
     *
     * @return void
     */
    private function initializeCssClass()
    {
        if ($this->item['class']) {
            $classes = trimsplit(' ', $this->item['class']);
            foreach ($classes as $class) {
                $this->itemClass[] = $class;
            }

            if (in_array('trail', $this->itemClass)) {
                $this->itemClass[] = 'active';
            }
        }
    }
}
