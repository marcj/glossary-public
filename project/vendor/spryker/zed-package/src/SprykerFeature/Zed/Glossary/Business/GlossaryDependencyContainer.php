<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Business;

use Generated\Zed\Ide\FactoryAutoCompletion\GlossaryBusiness;
use ProjectA\Zed\Kernel\Business\AbstractDependencyContainer;
use SprykerFeature\Zed\Glossary\Business\Key\KeyManagerInterface;
use SprykerFeature\Zed\Glossary\Business\Key\KeySourceInterface;
use SprykerFeature\Zed\Glossary\Business\Translation\TranslationManagerInterface;
use SprykerFeature\Zed\Glossary\Dependency\Facade\GlossaryToLocaleInterface;
use SprykerFeature\Zed\Glossary\Dependency\Facade\GlossaryToTouchInterface;
use SprykerFeature\Zed\Glossary\Persistence\GlossaryQueryContainerInterface;

/**
 * Class GlossaryDependencyContainer
 *
 * @package ProjectA\Zed\Glossary\Business
 */
class GlossaryDependencyContainer extends AbstractDependencyContainer
{
    /**
     * @var GlossaryBusiness
     */
    protected $factory;

    /**
     * @return TranslationManagerInterface
     */
    public function getTranslationManager()
    {
        return $this->factory->createTranslationTranslationManager(
            $this->getQueryContainer(),
            $this->getTouchFacade(),
            $this->getLocaleFacade(),
            $this->getKeyManager(),
            $this->locator
        );
    }

    /**
     * @return GlossaryQueryContainerInterface
     */
    protected function getQueryContainer()
    {
        return $this->locator->glossary()->queryContainer();
    }

    /**
     * @return GlossaryToTouchInterface
     */
    protected function getTouchFacade()
    {
        return $this->locator->touch()->facade();
    }

    /**
     * @return GlossaryToLocaleInterface
     */
    protected function getLocaleFacade()
    {
        return $this->locator->locale()->facade();
    }

    /**
     * @return KeyManagerInterface
     */
    public function getKeyManager()
    {
        return $this->factory->createKeyKeyManager(
            $this->getKeySource(),
            $this->getQueryContainer(),
            $this->locator
        );
    }

    /**
     * @return KeySourceInterface
     */
    protected function getKeySource()
    {
        return $this->factory->createKeyFileKeySource(
            $this->getSettings()->getGlossaryKeyFileName()
        );
    }

    /**
     * @return GlossarySettings
     */
    protected function getSettings()
    {
        return $this->factory->createGlossarySettings();
    }
}
