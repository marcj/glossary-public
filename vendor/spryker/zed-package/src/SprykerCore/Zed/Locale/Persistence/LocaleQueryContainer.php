<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerCore\Zed\Locale\Persistence;

use ProjectA\Zed\Kernel\Persistence\AbstractQueryContainer;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery;

class LocaleQueryContainer extends AbstractQueryContainer implements LocaleQueryContainerInterface
{
    /**
     * @param string $localeName
     *
     * @return PacLocaleQuery
     */
    public function queryLocaleByName($localeName)
    {
        $query = PacLocaleQuery::create();
        $query
            ->filterByLocaleName($localeName)
        ;

        return $query;
    }

    /**
     * @return PacLocaleQuery
     */
    public function queryLocales()
    {
        $query = PacLocaleQuery::create();

        return $query;
    }
}
