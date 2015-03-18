<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Locale\Business;

use ProjectA\Zed\Kernel\Business\AbstractFacade;

class LocaleFacade extends AbstractFacade
{
    /**
     * @var LocaleDependencyContainer
     */
    protected $dependencyContainer;

    /**
     * @param string $localeName
     * @return bool
     */
    public function hasLocale($localeName)
    {
        $localeManager = $this->dependencyContainer->getLocaleManager();
        return $localeManager->hasLocale($localeName);
    }

    /**
     * @param $localeName
     *
     * @return int
     * @throws Exception\MissingLocaleException
     */
    public function getLocaleIdentifier($localeName)
    {
        $localeManager = $this->dependencyContainer->getLocaleManager();
        return $localeManager->getLocale($localeName)->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getCurrentLocale()
    {
        //TODO rethink this
        return \ProjectA_Shared_Library_Store::getInstance()->getCurrentLocale();
    }

    /**
     * @return array
     */
    public function getRelevantLocales()
    {
        //TODO retrieve this
        //just some different locales
        return ['de_DE', 'en_US', 'fr_FR', 'de_CH', 'fr_CH'];
    }

    /**
     * @return int
     */
    public function getCurrentLocaleIdentifier()
    {
        $localeName = $this->getCurrentLocale();

        return $this->getLocaleIdentifier($localeName);
    }

    /**
     * @param string $localeName
     * @throws Exception\LocaleExistsException
     * @return int
     */
    public function createLocale($localeName)
    {
        $localeManager = $this->dependencyContainer->getLocaleManager();

        return $localeManager->createLocale($localeName);
    }

    /**
     * @param string $localeName
     */
    public function deleteLocale($localeName)
    {
        $localeManager = $this->dependencyContainer->getLocaleManager();
        $localeManager->deleteLocale($localeName);
    }

    public function install()
    {
        return $this->dependencyContainer->getInstaller()->install();
    }
}
