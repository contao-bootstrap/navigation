<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2015 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Navigation;

use Module;
use Netzmacht\Bootstrap\Core\Bootstrap;

/**
 * Navbar frontend module.
 *
 * @package Netzmacht\Bootstrap\Components\Contao\Module
 */
class NavbarModule extends \Module
{
    /**
     * Template name.
     *
     * @var string
     */
    protected $strTemplate = 'mod_navbar';

    /**
     * Construct.
     *
     * @param \ModuleModel $module Module model.
     * @param string       $column Column type.
     */
    public function __construct($module, $column = 'main')
    {
        parent::__construct($module, $column);

        if ($this->bootstrap_navbarTemplate != '') {
            $this->strTemplate = $this->bootstrap_navbarTemplate;
        }
    }

    /**
     * Compile the navbar.
     *
     * @return void
     */
    protected function compile()
    {
        $config  = deserialize($this->bootstrap_navbarModules, true);
        $modules = array();
        $ids     = array();

        // get ids
        foreach ($config as $index => $module) {
            $ids[$index] = intval($module['module']);
        }

        // prefetch modules, so only 1 query is required
        $ids        = implode(',', $ids);
        $collection = \ModuleModel::findBy(array('tl_module.id IN(' . $ids . ')'), array());
        $models     = array();

        if ($collection) {
            while ($collection->next()) {
                $model                     = $collection->current();
                $model->bootstrap_inNavbar = true;
                $models[$model->id]        = $model;
            }
        }

        foreach ($config as $module) {
            $id = $module['module'];

            if ($id != '' && array_key_exists($id, $models)) {
                $modules[] = $this->generateModule($module, $models[$id]);
            }
        }

        if ($this->cssID[1] == '') {
            $cssID    = $this->cssID;
            $cssID[1] = 'navbar-default';

            $this->cssID = $cssID;
        }

        $this->Template->modules = $modules;
    }

    /**
     * Generate a frontend module.
     *
     * @param array        $module Module configuration.
     * @param \ModuleModel $model  Module model.
     *
     * @return array
     */
    protected function generateModule($module, \ModuleModel $model)
    {
        $class = $module['cssClass'];

        if ($module['floating']) {
            if ($class != '') {
                $class .= ' ';
            }

            $class .= 'navbar-' . $module['floating'];
        }

        // @codingStandardsIgnoreStart
        // TODO: Do we have to make this list configurable?
        // @codingStandardsIgnoreEnd
        if (in_array($model->type, array('navigation', 'customnav', 'quicklink'))) {
            $navClass = 'nav navbar-nav';

            if ($module['floating']) {
                $navClass .= ' navbar-' . $module['floating'];
            }

            Bootstrap::setConfigVar('runtime.nav-class', $navClass);
        }

        $rendered = $this->getFrontendModule($model);
        Bootstrap::setConfigVar('runtime.nav-class', '');

        return array(
            'type'   => 'module',
            'module' => $rendered,
            'id'     => $module['module'],
            'class'  => $class,
        );
    }
}
