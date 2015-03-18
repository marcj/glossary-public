<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Dependency\Facade;

use SprykerCore\Zed\Locale\Business\Exception\MissingLocaleException;

interface GlossaryToLocaleInterface
{
    /**
     * @param $localeName
     * @return int
     * @throws MissingLocaleException
     */
    public function getLocaleIdentifier($localeName);

    /**
     * @return string
     */
    public function getCurrentLocale();

    /**
     * @return int
     */
    public function getCurrentLocaleIdentifier();

    /**
     * @return array
     */
    public function getRelevantLocales();
}
