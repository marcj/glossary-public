<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Locale\Persistence;

use SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery;

interface LocaleQueryContainerInterface
{
    /**
     * @param $localeName
     *
     * @return PacLocaleQuery
     */
    public function queryLocaleByName($localeName);

    /**
     * @return PacLocaleQuery
     */
    public function queryLocales();
}
