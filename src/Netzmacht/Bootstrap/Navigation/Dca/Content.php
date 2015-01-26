<?php

/**
 * @package   contao-bootstrap
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @license   LGPL 3+
 * @copyright 2013-2014 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\Navigation\Dca;

use Netzmacht\Bootstrap\Core\Contao\ContentElement\Wrapper\Helper;

/**
 * Class Content provides callbacks for tl_content dca.
 *
 * @package Netzmacht\Bootstrap\Components\Contao\DataContainer
 */
class Content
{
    /**
     * Count existing tab separators elements.
     *
     * @param \Database\Result $model  Current row.
     * @param Helper           $helper Wrapper helper.
     *
     * @return int
     */
    public function countExistingTabSeparators(\Database\Result $model, Helper $helper)
    {
        if ($helper->isTypeOf(Helper::TYPE_START)) {
            $modelId = $model->id;
        } else {
            $modelId = $model->bootstrap_parentId;
        }

        $number = \ContentModel::countBy(
            'type=? AND bootstrap_parentId',
            array($helper->getTypeName(Helper::TYPE_SEPARATOR), $modelId)
        );

        return $number;
    }

    /**
     * Count required tab separator elements.
     *
     * @param \Database\Result $model  Current row.
     * @param Helper           $helper Wrapper helper.
     *
     * @return int
     */
    public function countRequiredTabSeparators(\Database\Result $model, Helper $helper)
    {
        if (!$helper->isTypeOf(Helper::TYPE_START)) {
            $model = \ContentModel::findByPk($model->bootstrap_parentId);
        }

        $tabs = array();

        if ($model->bootstrap_tabs) {
            $tabs = deserialize($model->bootstrap_tabs, true);
        } elseif (\Input::post('bootstrap_tabs')) {
            $tabs = \Input::post('bootstrap_tabs');
        }

        $count = 0;

        foreach ($tabs as $tab) {
            if ($tab['type'] != 'dropdown') {
                $count++;
            }
        }

        return $count > 0 ? ($count - 1 ) : 0;
    }
}
