<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Touch\Business\Model;

use Propel\Runtime\Exception\PropelException;
use SprykerCore\Zed\Touch\Persistence\TouchQueryContainerInterface;

class TouchRecord
{
    /**
     * @var TouchQueryContainerInterface
     */
    protected $touchQueryContainer;

    /**
     * @param TouchQueryContainerInterface $queryContainer
     */
    public function __construct(TouchQueryContainerInterface $queryContainer)
    {
        $this->touchQueryContainer = $queryContainer;
    }

    /**
     * @param string $itemType
     * @param int $itemEvent
     * @param string $itemId
     *
     * @return bool
     * @throws \Exception
     * @throws PropelException
     */
    public function saveTouchRecord($itemType, $itemEvent, $itemId)
    {
        $touchQuery = $this->touchQueryContainer->queryTouchEntry($itemType, $itemId);
        $touchEntity = $touchQuery->findOneOrCreate();

        $touchEntity
            ->setItemType($itemType)
            ->setItemEvent($itemEvent)
            ->setItemId($itemId)
            ->setTouched(new \DateTime());

        $touchEntity->save();

        return true;
    }
}
