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
        $models  = $this->prefetchModules($config);

        foreach ($config as $module) {
            $id = $module['module'];

            if ($id != '' && !$module['inactive'] && array_key_exists($id, $models)) {
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

    /**
     * Extract module ids from navbar config.
     *
     * @param array $config The navbar config.
     *
     * @return array
     */
    protected function extractModuleIds($config)
    {
        $ids = array();

        foreach ($config as $index => $module) {
            if ($module['inactive']) {
                continue;
            }
            $ids[$index] = intval($module['module']);
        }

        return $ids;
    }

    /**
     * Prefetch modules.
     *
     * @param array $config Navbar config.
     *
     * @return array
     */
    protected function prefetchModules($config)
    {
        $ids    = $this->extractModuleIds($config);
        $models = array();

        if ($ids) {
            // prefetch modules, so only 1 query is required
            $ids        = implode(',', $ids);
            $collection = \ModuleModel::findBy(array('tl_module.id IN(' . $ids . ')'), array());

            if ($collection) {
                while ($collection->next()) {
                    $model                     = $collection->current();
                    $model->bootstrap_inNavbar = true;
                    $models[$model->id]        = $model;
                }
            }
        }

        return $models;
    }
}
