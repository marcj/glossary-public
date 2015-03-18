<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Locale\Communication\Plugin;

use SprykerCore\Zed\Locale\Communication\LocaleDependencyContainer;
use ProjectA\Zed\Installer\Business\Model\InstallerInterface;
use ProjectA\Zed\Kernel\Communication\AbstractPlugin;

class Installer extends AbstractPlugin implements InstallerInterface
{

    /**
     * @var LocaleDependencyContainer
     */
    protected $dependencyContainer;

    public function install()
    {
        $this->dependencyContainer->getInstallerFacade()->install();
    }
}
