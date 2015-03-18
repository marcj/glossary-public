<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Locale\Business\Manager;

use Generated\Zed\Ide\AutoCompletion;
use ProjectA\Shared\Kernel\LocatorLocatorInterface;
use Propel\Runtime\Exception\PropelException;
use SprykerCore\Zed\Locale\Business\Exception\LocaleExistsException;
use SprykerCore\Zed\Locale\Business\Exception\MissingLocaleException;
use SprykerCore\Zed\Locale\Persistence\LocaleQueryContainerInterface;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocale;

class LocaleManager
{
    /**
     * @var LocaleQueryContainerInterface
     */
    protected $localeQueryContainer;

    /**
     * @var AutoCompletion
     */
    protected $locator;

    public function __construct(LocaleQueryContainerInterface $localeQueryContainer, LocatorLocatorInterface $locator)
    {
        $this->localeQueryContainer = $localeQueryContainer;
        $this->locator = $locator;
    }

    /**
     * @param string $localeName
     *
     * @return PacLocale
     * @throws MissingLocaleException
     */
    public function getLocale($localeName)
    {
        $localeQuery = $this->localeQueryContainer->queryLocaleByName($localeName);
        $locale = $localeQuery->findOne();
        if (!$locale) {
            throw new MissingLocaleException(
                sprintf(
                    'Tried to retrieve locale %s, but it does not exist',
                    $localeName
                )
            );
        }

        return $locale;
    }

    /**
     * @param string $localeName
     * @return int
     * @throws LocaleExistsException
     * @throws \Exception
     * @throws PropelException
     */
    public function createLocale($localeName)
    {
        if ($this->hasLocale($localeName)) {
            throw new LocaleExistsException(
                sprintf(
                    'Tried to create locale %s, but it already exists',
                    $localeName
                )
            );
        }

        $locale = $this->locator->locale()->entityPacLocale();
        $locale->setLocaleName($localeName);

        $locale->save();

        return $locale->getPrimaryKey();
    }

    /**
     * @param string $localeName
     *
     * @return bool
     */
    public function hasLocale($localeName)
    {
        $localeQuery = $this->localeQueryContainer->queryLocaleByName($localeName);
        return $localeQuery->count() > 0;
    }

    /**
     * @param string $localeName
     *
     * @return bool
     * @throws PropelException
     */
    public function deleteLocale($localeName)
    {
        if (!$this->hasLocale($localeName)) {
            return true;
        }

        $locale = $this->localeQueryContainer
            ->queryLocaleByName($localeName)
            ->findOne();

        $locale->setIsActive(false);
        $locale->save();

        return true;
    }
}
