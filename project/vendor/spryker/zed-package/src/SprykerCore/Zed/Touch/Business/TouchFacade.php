<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Touch\Business;

use ProjectA\Zed\Kernel\Business\AbstractFacade;
use SprykerCore\Zed\Touch\Persistence\Propel\Map\PacTouchTableMap;

class TouchFacade extends AbstractFacade
{
    /**
     * @var TouchDependencyContainer
     */
    protected $dependencyContainer;

    /**
     * @param string $itemType
     * @param int $itemId
     *
     * @return bool
     */
    public function touchActive($itemType, $itemId)
    {
        $touchRecordModel = $this->dependencyContainer->getTouchRecordModel();

        return $touchRecordModel->saveTouchRecord(
            $itemType,
            PacTouchTableMap::COL_ITEM_EVENT_ACTIVE,
            $itemId
        );
    }

    /**
     * @param string $itemType
     * @param int $itemId
     *
     * @return bool
     */
    public function touchInactive($itemType, $itemId)
    {
        $touchRecordModel = $this->dependencyContainer->getTouchRecordModel();
        return $touchRecordModel->saveTouchRecord(
            $itemType,
            PacTouchTableMap::COL_ITEM_EVENT_INACTIVE,
            $itemId
        );
    }

    /**
     * @param string $itemType
     * @param int $itemId
     *
     * @return bool
     */
    public function touchDeleted($itemType, $itemId)
    {
        $touchRecordModel = $this->dependencyContainer->getTouchRecordModel();
        return $touchRecordModel->saveTouchRecord(
            $itemType,
            PacTouchTableMap::COL_ITEM_EVENT_DELETED,
            $itemId
        );
    }
}
