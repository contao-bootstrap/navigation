<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Navigation\Dca;

/**
 * Class Module provides callbacks being used in the tl_module dca.
 *
 * @package Netzmacht\Bootstrap\Components\Contao\DataContainer
 */
class Module
{
    /**
     * Get all articles and return them as array.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getAllArticles()
    {
        $user     = \BackendUser::getInstance();
        $pids     = array();
        $articles = array();

        // Limit pages to the user's pagemounts
        if ($user->isAdmin) {
            $objArticle = \Database::getInstance()->execute(
                'SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent FROM tl_article a
                LEFT JOIN tl_page p ON p.id=a.pid ORDER BY parent, a.sorting'
            );
        } else {
            foreach ($user->pagemounts as $id) {
                $pids[] = $id;
                $pids   = array_merge($pids, \Database::getInstance()->getChildRecords($id, 'tl_page'));
            }

            if (empty($pids)) {
                return $articles;
            }

            $pids = implode(',', array_map('intval', array_unique($pids)));

            $objArticle = \Database::getInstance()->execute(
                'SELECT a.id, a.pid, a.title, a.inColumn, p.title AS parent
                FROM tl_article a LEFT JOIN tl_page p ON p.id=a.pid WHERE a.pid IN(' . $pids . ')
                ORDER BY parent, a.sorting'
            );
        }

        // Edit the result
        if ($objArticle->numRows) {
            \Controller::loadLanguageFile('tl_article');

            while ($objArticle->next()) {
                $key                             = $objArticle->parent . ' (ID ' . $objArticle->pid . ')';
                $articles[$key][$objArticle->id] = $objArticle->title
                    . ' (' . ($GLOBALS['TL_LANG']['tl_article'][$objArticle->inColumn] ?: $objArticle->inColumn)
                    . ', ID ' . $objArticle->id . ')';
            }
        }

        return $articles;
    }

    /**
     * Get all modules prepared for select wizard.
     *
     * @return array
     */
    public function getAllModules()
    {
        $modules = array();
        $query   = 'SELECT m.id, m.name, t.name AS theme FROM tl_module m LEFT JOIN tl_theme t ON m.pid=t.id';

        if (\Input::get('table') == 'tl_module' && \Input::get('act') == 'edit') {
            $query .= ' WHERE m.id != ?';
        }

        $query .= ' ORDER BY t.name, m.name';
        $result = \Database::getInstance()
            ->prepare($query)
            ->execute(\Input::get('id'));

        while ($result->next()) {
            $modules[$result->theme][$result->id] = $result->name . ' (ID ' . $result->id . ')';
        }

        return $modules;
    }
}
