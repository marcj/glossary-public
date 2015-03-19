<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Touch\Business;

use Generated\Zed\Ide\FactoryAutoCompletion\TouchBusiness;
use ProjectA\Zed\Kernel\Business\AbstractDependencyContainer;
use SprykerCore\Zed\Touch\Business\Model\TouchRecordInterface;
use SprykerCore\Zed\Touch\Persistence\TouchQueryContainerInterface;

class TouchDependencyContainer extends AbstractDependencyContainer
{
    /**
     * @var TouchBusiness
     */
    protected $factory;

    /**
     * @return TouchRecordInterface
     */
    public function getTouchRecordModel()
    {
        return $this->factory->createModelTouchRecord(
            $this->getQueryContainer()
        );
    }

    /**
     * @return TouchQueryContainerInterface
     */
    protected function getQueryContainer()
    {
        return $this->locator->touch()->queryContainer();
    }
}
