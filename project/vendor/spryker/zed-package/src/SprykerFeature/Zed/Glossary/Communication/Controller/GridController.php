<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Communication\Controller;

use ProjectA\Zed\Application\Communication\Controller\AbstractController;
use SprykerFeature\Zed\Glossary\Communication\GlossaryDependencyContainer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GridController extends AbstractController
{

    /**
     * @var GlossaryDependencyContainer
     */
    protected $dependencyContainer;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function translationAction(Request $request)
    {
        $grid = $this->dependencyContainer->getGlossaryKeyTranslationGrid($request);

        return $this->jsonResponse($grid->getData());
    }

}