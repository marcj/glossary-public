<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Locale\Business\Internal\Install;

use ProjectA\Zed\Installer\Business\Model\InstallerInterface;
use ProjectA\Zed\Library\Business\InstallInterface;
use Propel\Runtime\Exception\PropelException;
use SprykerCore\Zed\Locale\Persistence\LocaleQueryContainerInterface;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocale;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery;

class LocaleInstaller implements InstallerInterface
{
    /**
     * @var string
     */
    protected $localeFile;

    /**
     * @var LocaleQueryContainerInterface
     */
    protected $localeQueryContainer;

    /**
     * @param LocaleQueryContainerInterface $localeQueryContainer
     * @param string $localeFile
     */
    public function __construct(LocaleQueryContainerInterface $localeQueryContainer, $localeFile)
    {
        $this->localeFile = $localeFile;
        $this->localeQueryContainer = $localeQueryContainer;
    }

    /**
     * @return void
     */
    public function install()
    {
        $this->installLocales();
    }

    /**
     * @throws PropelException
     */
    protected function installLocales()
    {
        $localeFile = fopen($this->localeFile, 'r');

        while (!feof($localeFile)) {
            $locale = trim(fgets($localeFile));

            $query = $this->localeQueryContainer->queryLocaleByName($locale);

            if (!$query->count()) {
                $entity = new PacLocale();
                $entity->setLocaleName($locale);
                $entity->setIsActive(1);
                $entity->save();
            }
        }
    }
}
