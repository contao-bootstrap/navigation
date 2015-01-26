<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Navigation;

use Netzmacht\Bootstrap\Navigation\ItemHelper;
use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;

/**
 * Class Helper is the main helper being accessed in navigation templates. It creates the item helpers.
 *
 * @package Netzmacht\Bootstrap\Navigation
 */
class Helper
{

    /**
     * Navigation item template.
     *
     * @var \FrontendTemplate
     */
    protected $template;

    /**
     * Create a new list.
     *
     * @var bool
     */
    protected $newList = true;

    /**
     * List attributes.
     *
     * @var Attributes
     */
    protected $listAttributes;

    /**
     * News module model.
     *
     * @var \ModuleModel
     */
    protected $module;

    /**
     * Item helper factory.
     *
     * @var callable
     */
    protected $itemHelperFactory;

    /**
     * Construct.
     *
     * @param \FrontendTemplate $template          Navigation template.
     * @param \Callable         $itemHelperFactory Item helper factory.
     */
    public function __construct(\FrontendTemplate $template, $itemHelperFactory)
    {
        $this->template          = $template;
        $this->listAttributes    = new Attributes();
        $this->itemHelperFactory = $itemHelperFactory;

        $this->initialize();
    }

    /**
     * Create a helper instance for current navigation template.
     *
     * @param \FrontendTemplate $template   Navigation template.
     * @param string            $itemHelper Item helper name.
     *
     * @throws \InvalidArgumentException If item helper is not registered.
     *
     * @return static
     */
    public static function create(\FrontendTemplate $template, $itemHelper)
    {
        $factory = Bootstrap::getConfigVar('navigation.item-helper.' . $itemHelper);

        if (!$factory) {
            throw new \InvalidArgumentException(sprintf('Navigation item helper "%s" is not registered', $itemHelper));
        }

        return new static($template, $factory);
    }

    /**
     * Get the navigation template.
     *
     * @return \FrontendTemplate
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Get an item helper.
     *
     * @param array $item Current item.
     *
     * @return ItemHelper
     */
    public function getItemHelper(array $item)
    {
        if (is_string($this->itemHelperFactory)) {
            $class  = $this->itemHelperFactory;
            $helper = new $class($item, $this->template);
        } else {
            $helper = call_user_func($this->itemHelperFactory, $item, $this->template);
        }

        return $helper;
    }

    /**
     * Consider if navigation should create a new list.
     *
     * @return bool
     */
    public function isChildrenList()
    {
        return $this->newList;
    }

    /**
     * Enable or disable new list.
     *
     * @param boolean $newList Enable new list.
     *
     * @return $this
     */
    public function setChildrenList($newList)
    {
        $this->newList = $newList;

        return $this;
    }

    /**
     * Set list attributes.
     *
     * @param Attributes $listAttributes List attributes.
     *
     * @return $this
     */
    public function setListAttributes(Attributes $listAttributes)
    {
        $this->listAttributes = $listAttributes;

        return $this;
    }

    /**
     * Get list attributes.
     *
     * @return Attributes
     */
    public function getListAttributes()
    {
        return $this->listAttributes;
    }

    /**
     * Initialize the helper.
     *
     * @return void
     */
    private function initialize()
    {
        $level      = substr($this->template->level, 6);
        $attributes = $this->listAttributes;

        $attributes->addClass($this->template->level);

        if ($level === '1') {
            $class = Bootstrap::getConfigVar('runtime.nav-class');

            if ($class) {
                $attributes->addClass('nav');
                $attributes->addClass($class);
                Bootstrap::setConfigVar('runtime.nav-class', '');
            }
        } elseif ($level === '2') {
            $attributes->addClass('dropdown-menu');
        }

        if ($level > 1 && $this->template->items) {
            // get the current page id
            $pageId = $this->template->items[0]['pid'];
            $page   = \PageModel::findByPk($pageId);

            if ($this->disableChildrenList($level, $page)) {
                $this->setChildrenList(false);
            }
        }
    }

    /**
     * Should children list be disabled.
     *
     * @param int             $level Current level.
     * @param \PageModel|null $page  Parent page.
     *
     * @return bool
     */
    private function disableChildrenList($level, $page)
    {
        return $level > 2 && $page && ($page->type == 'm17Folder' || $page->type == 'folder');
    }
}
