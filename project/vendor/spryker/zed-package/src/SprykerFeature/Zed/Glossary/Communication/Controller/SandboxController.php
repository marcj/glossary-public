<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Communication\Controller;

use ProjectA\Zed\Application\Communication\Controller\AbstractController;
use ProjectA\Zed\Kernel\Communication\Factory;
use ProjectA\Zed\Kernel\Locator;
use SprykerFeature\Zed\Glossary\Business\GlossaryFacade;
use SprykerFeature\Zed\Glossary\Persistence\GlossaryQueryContainerInterface;

class SandboxController extends AbstractController
{
    const BUNDLE_NAME = 'Glossary';

    /**
     * @var GlossaryFacade
     */
    protected $glossaryFacade;

    /**
     * @var GlossaryQueryContainerInterface
     */
    protected $glossaryQueryContainer;

    public function __construct(\Pimple $application, Factory $factory, Locator $locator)
    {
        parent::__construct($application, $factory, $locator);
        $this->glossaryFacade = $this->locator->glossary()->facade();
        $this->glossaryQueryContainer = $this->locator->glossary()->queryContainer();
    }


    public function syncAction()
    {
        $this->glossaryFacade->synchronizeKeys();
    }

    public function keysAction()
    {
        $twigData = [
            'glossaryKeys' => $this->glossaryQueryContainer->queryKeys()->orderBy('key')->find(),
        ];
        return $this->viewResponse($twigData);
    }

    public function insertAction()
    {
        $this->glossaryFacade->createTranslation('FileKey1', 'de_DE', 'A Random translation', true);

        return $this->jsonResponse(['success' => true]);
    }

    public function insertInactiveAction()
    {
        $this->glossaryFacade->createTranslation('FileKey2', 'de_DE', 'The next random translation', false);

        return $this->jsonResponse(['success' => true]);
    }

    public function updateInactiveAction()
    {
        $this->glossaryFacade->updateTranslation('FileKey2', 'de_DE', 'Just the next random translation', false);

        return $this->jsonResponse(['success' => true]);
    }

    public function activateInactiveAction()
    {
        $this->glossaryFacade->updateTranslation('FileKey2', 'de_DE', 'Just the next random translation', true);

        return $this->jsonResponse(['success' => true]);
    }

    public function reactivateAction()
    {
        $this->glossaryFacade->updateTranslation('FileKey1', 'de_DE', 'A Random translation', true);

        return $this->jsonResponse(['success' => true]);
    }

    public function deleteAction()
    {
        $this->glossaryFacade->deleteTranslation('FileKey1', 'de_DE');

        return $this->jsonResponse(['success' => true]);
    }

    public function updateAction()
    {
        $this->glossaryFacade->updateTranslation('customer.logout', 'de_DE', 'irgendetwas anderes random mäßiges', true);

        return $this->jsonResponse(['success' => true]);
    }
}
