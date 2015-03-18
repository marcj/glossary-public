<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Touch\Business\Model;

use Propel\Runtime\Exception\PropelException;

interface TouchRecordInterface
{
    /**
     * @param string $itemType
     * @param int $itemEvent
     * @param string $itemId
     *
     * @return bool
     * @throws \Exception
     * @throws PropelException
     */
    public function saveTouchRecord($itemType, $itemEvent, $itemId);
}