<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace Pyz\Zed\Locale\Business;

use SprykerCore\Zed\Locale\Business\LocaleFacade as CoreLocaleFacade;
use SprykerFeature\Zed\Glossary\Dependency\Facade\GlossaryToLocaleInterface;

class LocaleFacade extends CoreLocaleFacade implements GlossaryToLocaleInterface
{

}
