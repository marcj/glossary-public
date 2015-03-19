<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Locale\Communication;

use ProjectA\Zed\Installer\Business\Model\InstallerInterface;
use ProjectA\Zed\Kernel\Communication\AbstractDependencyContainer;

class LocaleDependencyContainer extends AbstractDependencyContainer
{

    /**
     * @return InstallerInterface
     */
    public function getInstallerFacade()
    {
        return $this->locator->locale()->facade();
    }
}
