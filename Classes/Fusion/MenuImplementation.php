<?php
namespace Js\TherapieOx\Fusion;

/*
 * This file is part of the Neos.Neos package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Fusion\Exception as TypoScriptException;
use Neos\Fusion\Exception;

/**
 * A TypoScript Menu object
 */
class MenuImplementation extends \Neos\Neos\Fusion\MenuImplementation
{

    /**
     * Prepare the menu item with state and sub items if this isn't the last menu level.
     *
     * @param NodeInterface $currentNode
     * @return array
     */
    protected function buildMenuItemRecursive(NodeInterface $currentNode)
    {
        if ($this->isNodeHidden($currentNode)) {
            return null;
        }

        $item = array(
            'node' => $currentNode,
            'state' => self::STATE_NORMAL,
            'label' => $currentNode->getLabel(),
            // 'area' => $currentNode->getProperty('area'),
            'property' => $currentNode->getProperties(),
            'menuLevel' => $this->currentLevel
        );

        $item['state'] = $this->calculateItemState($currentNode);
        if (!$this->isOnLastLevelOfMenu($currentNode)) {
            $this->currentLevel++;
            $item['subItems'] = $this->buildMenuLevelRecursive($currentNode->getChildNodes($this->getFilter()));
            $this->currentLevel--;
        }

        return $item;
    }
}
