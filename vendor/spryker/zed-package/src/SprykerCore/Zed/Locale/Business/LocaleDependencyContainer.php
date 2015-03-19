<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Locale\Business;

use Generated\Zed\Ide\FactoryAutoCompletion\LocaleBusiness;
use ProjectA\Zed\Kernel\Business\AbstractDependencyContainer;
use SprykerCore\Zed\Locale\Business\Internal\Install\LocaleInstaller;
use SprykerCore\Zed\Locale\Business\Manager\LocaleManager;
use SprykerCore\Zed\Locale\Persistence\LocaleQueryContainerInterface;

class LocaleDependencyContainer extends AbstractDependencyContainer
{

    /**
     * @var LocaleBusiness
     */
    protected $factory;

    /**
     * @return LocaleManager
     */
    public function getLocaleManager()
    {
        return $this->factory->createManagerLocaleManager(
            $this->getQueryContainer()
        );
    }

    /**
     * @return LocaleQueryContainerInterface
     */
    protected function getQueryContainer()
    {
        return $this->locator->locale()->queryContainer();
    }

    /**
     * @return LocaleInstaller
     */
    public function getInstaller()
    {
        return $this->factory->createInternalInstallLocaleInstaller(
            $this->getQueryContainer(),
            $this->getSettings()->getLocaleFile()
        );
    }

    /**
     * @return LocaleSettings
     */
    protected function getSettings()
    {
        return $this->factory->createLocaleSettings();
    }
}
