<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Persistence;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Exception\PropelException;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKeyQuery;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery;

/**
 * Class GlossaryQueryContainer
 *
 * @package ProjectA\Zed\Glossary\Persistence
 */
interface GlossaryQueryContainerInterface
{
    /**
     * @param string $keyName
     *
     * @return GlossaryKeyQuery
     */
    public function queryKey($keyName);

    /**
     * @return GlossaryKeyQuery
     */
    public function queryKeys();

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationByNames($keyName, $localeName);

    /**
     * @param int $keyId
     * @param int $localeId
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationByIds($keyId, $localeId);

    /**
     * @return GlossaryTranslationQuery
     */
    public function queryTranslations();

    /**
     * @param string $keyName
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationsByKey($keyName);

    /**
     * @param string $localeName
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationsByLocale($localeName);

    /**
     * @param int $idGlossaryTranslation
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationByPk($idGlossaryTranslation);

    /**
     * @param GlossaryTranslationQuery $query
     *
     * @return ModelCriteria
     */
    public function joinTranslationQueryWithKeysAndLocales(GlossaryTranslationQuery $query);

    /**
     * @param array $relevantLocales
     *
     * @return ModelCriteria
     * @throws PropelException
     */
    public function queryAllPossibleTranslations(array $relevantLocales);

    /**
     * @param array $relevantLocales
     *
     * @return ModelCriteria
     */
    public function queryAllMissingTranslations(array $relevantLocales);

    /**
     * @param $idKey
     * @param array $relevantLocales
     *
     * @return ModelCriteria
     */
    public function queryMissingTranslationsForKey($idKey, array $relevantLocales);

    /**
     * @param ModelCriteria $query
     *
     * @return ModelCriteria
     */
    public function queryDistinctKeysFromQuery(ModelCriteria $query);

    /**
     * @param ModelCriteria $query
     *
     * @return ModelCriteria
     */
    public function queryDistinctLocalesFromQuery(ModelCriteria $query);
}