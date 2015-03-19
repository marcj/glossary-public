<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Touch\Persistence;

use ProjectA\Zed\Kernel\Persistence\AbstractQueryContainer;
use SprykerCore\Zed\Touch\Persistence\Propel\PacTouchQuery;

class TouchQueryContainer extends AbstractQueryContainer implements TouchQueryContainerInterface
{
    /**
     * @param string $itemType
     *
     * @return PacTouchQuery
     */
    public function queryTouchListByItemType($itemType)
    {
        $query = PacTouchQuery::create();
        $query->filterByItemType($itemType);

        return $query;
    }

    /**
     * @param string $itemType
     * @param string $itemId
     *
     * @return PacTouchQuery
     */
    public function queryTouchEntry($itemType, $itemId)
    {
        $query = PacTouchQuery::create();
        $query
            ->filterByItemType($itemType)
            ->filterByItemId($itemId);

        return $query;
    }
}
