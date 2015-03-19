<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Communication\Controller;

use ProjectA\Zed\Application\Communication\Controller\AbstractController;
use SprykerFeature\Zed\Glossary\Communication\GlossaryDependencyContainer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormController
 *
 * @package ProjectA\Zed\Glossary\Communication\Controller
 */
class FormController extends AbstractController
{
    /**
     * @var GlossaryDependencyContainer
     */
    protected $dependencyContainer;

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function translationAction(Request $request)
    {
        $form = $this->dependencyContainer->getTranslationForm($request);
        $form->init();

        if ($form->isValid()) {
            $translation = $this->locator->glossary()->transferTranslation();
            $translation->fromArray($form->getStateContainer()->getRequestData());

            $this->locator->glossary()->facade()->saveTranslation($translation);
        }

        return $this->jsonResponse($form->getOutput());
    }

}