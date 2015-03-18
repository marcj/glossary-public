<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Touch\Persistence;

use SprykerCore\Zed\Touch\Persistence\Propel\PacTouchQuery;

interface TouchQueryContainerInterface
{
    /**
     * @param string $itemType
     *
     * @return PacTouchQuery
     */
    public function queryTouchListByItemType($itemType);

    /**
     * @param string $itemType
     * @param string $itemId
     *
     * @return PacTouchQuery
     */
    public function queryTouchEntry($itemType, $itemId);
}