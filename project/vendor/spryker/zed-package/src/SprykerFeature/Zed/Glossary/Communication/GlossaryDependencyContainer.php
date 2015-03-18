<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Communication;

use Generated\Zed\Ide\FactoryAutoCompletion\GlossaryCommunication;
use ProjectA\Zed\Kernel\Communication\AbstractDependencyContainer;
use SprykerCore\Zed\Locale\Business\LocaleFacade;
use SprykerFeature\Zed\Glossary\Business\GlossaryFacade;
use SprykerFeature\Zed\Glossary\Communication\Form\TranslationForm;
use SprykerFeature\Zed\Glossary\Persistence\GlossaryQueryContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator;

class GlossaryDependencyContainer extends AbstractDependencyContainer
{
    /**
     * @var GlossaryCommunication
     */
    protected $factory;

    /**
     * @return GlossaryFacade
     */
    public function getGlossaryFacade()
    {
        return $this->locator->glossary()->facade();
    }

    /**
     * @param Request $request
     *
     * @return TranslationForm
     */
    public function getTranslationForm(Request $request)
    {
        return $this->factory->createFormTranslationForm(
            $this->locator,
            $this->getLocaleFacade(),
            $request,
            $this->getQueryContainer()
        );
    }

    /**
     * @param Request $request
     * @return object
     */
    public function getGlossaryKeyTranslationGrid(Request $request)
    {
        return $this->factory->createGridTranslationGrid(
            $this->getQueryContainer()->joinTranslationQueryWithKeysAndLocales($this->getQueryContainer()->queryTranslations()),
            $request,
            $this->locator
        );
    }

    /**
     * @return GlossaryQueryContainerInterface
     */
    public function getQueryContainer()
    {
        return $this->locator->glossary()->queryContainer();
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->locator->application()->pluginPimple()->getApplication()['validator'];
    }

    /**
     * @return LocaleFacade
     */
    protected function getLocaleFacade()
    {
        return $this->locator->locale()->facade();
    }

}
