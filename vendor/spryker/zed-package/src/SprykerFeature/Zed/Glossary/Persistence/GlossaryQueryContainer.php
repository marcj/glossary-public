<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace SprykerFeature\Zed\Glossary\Persistence;

use ProjectA\Zed\Kernel\Persistence\AbstractQueryContainer;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use SprykerCore\Zed\Locale\Persistence\Propel\Map\PacLocaleTableMap;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKeyQuery;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery;
use SprykerFeature\Zed\Glossary\Persistence\Propel\Map\GlossaryKeyTableMap;
use SprykerFeature\Zed\Glossary\Persistence\Propel\Map\GlossaryTranslationTableMap;

/**
 * Class GlossaryQueryContainer
 *
 * @package ProjectA\Zed\Glossary\Persistence
 */
class GlossaryQueryContainer extends AbstractQueryContainer implements GlossaryQueryContainerInterface
{
    const TRANSLATION = 'translation';
    const TRANSLATION_IS_ACTIVE = 'translation_is_active';
    const KEY_IS_ACTIVE = 'key_is_active';
    const GLOSSARY_KEY = 'glossary_key';
    const GLOSSARY_KEY_IS_ACTIVE = 'glossary_key_is_active';
    const LOCALE = 'locale';

    /**
     * @param string $keyName
     *
     * @return GlossaryKeyQuery
     */
    public function queryKey($keyName)
    {
        $query = GlossaryKeyQuery::create();
        $query->filterByKey($keyName);

        return $query;
    }

    /**
     * @param string $keyName
     * @param string $localeName
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationByNames($keyName, $localeName)
    {
        $query = GlossaryTranslationQuery::create();
        $query
            ->useGlossaryKeyQuery()
                ->filterByKey($keyName)
            ->endUse();

        $query
            ->useGlossaryLocaleQuery()
                ->filterByLocaleName($localeName)
            ->endUse();

        return $query;
    }

    /**
     * @param int $keyId
     * @param int $localeId
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationByIds($keyId, $localeId)
    {
        $query = GlossaryTranslationQuery::create();
        $query
            ->filterByFkGlossaryKey($keyId)
            ->filterByFkLocale($localeId);

        return $query;
    }

    /**
     * @param int $idGlossaryTranslation
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationByPk($idGlossaryTranslation)
    {
        $query = GlossaryTranslationQuery::create();
        $query
            ->filterByIdGlossaryTranslation($idGlossaryTranslation)
        ;

        return $query;
    }

    /**
     * @return GlossaryTranslationQuery
     */
    public function queryTranslations()
    {
        return GlossaryTranslationQuery::create();
    }

    /**
     * @param string $localeName
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationsByLocale($localeName)
    {
        $query = GlossaryTranslationQuery::create();
        $query
            ->useGlossaryLocaleQuery()
                ->filterByLocaleName($localeName)
            ->endUse();

        return $query;
    }

    /**
     * @param string $keyName
     *
     * @return GlossaryTranslationQuery
     */
    public function queryTranslationsByKey($keyName)
    {
        $query = GlossaryTranslationQuery::create();
        $query
            ->useGlossaryKeyQuery()
                ->filterByKey($keyName)
            ->endUse();

        return $query;
    }

    /**
     * @param GlossaryTranslationQuery $query
     *
     * @return ModelCriteria
     */
    public function joinTranslationQueryWithKeysAndLocales(GlossaryTranslationQuery $query)
    {
        $query
            ->joinGlossaryLocale()
                ->withColumn(PacLocaleTableMap::COL_LOCALE_NAME, self::LOCALE)

            ->joinGlossaryKey()
                ->withColumn(GlossaryTranslationTableMap::COL_VALUE, self::TRANSLATION)
                ->withColumn(GlossaryTranslationTableMap::COL_IS_ACTIVE, self::TRANSLATION_IS_ACTIVE)
                ->withColumn(GlossaryKeyTableMap::COL_KEY, self::GLOSSARY_KEY)
                ->withColumn(GlossaryKeyTableMap::COL_IS_ACTIVE, self::GLOSSARY_KEY_IS_ACTIVE)
        ;

        return $query;
    }

    /**
     * @param array $relevantLocales
     *
     * @return ModelCriteria
     */
    public function queryAllMissingTranslations(array $relevantLocales)
    {
        $keyQuery = $this->queryAllPossibleTranslations($relevantLocales);
        $keyQuery
            ->where(GlossaryTranslationTableMap::COL_VALUE . '' . ModelCriteria::ISNULL);

        return $keyQuery;
    }

    /**
     * @param array $relevantLocales
     *
     * @return ModelCriteria
     * @throws PropelException
     */
    public function queryAllPossibleTranslations(array $relevantLocales)
    {
        $keyQuery = $this->queryKeys();

        return $this->joinKeyQueryWithRelevantLocalesAndTranslations($keyQuery, $relevantLocales);
    }

    /**
     * @return GlossaryKeyQuery
     */
    public function queryKeys()
    {
        return GlossaryKeyQuery::create();
    }

    /**
     * @param GlossaryKeyQuery $keyQuery
     * @param array $relevantLocales
     *
     * @return GlossaryKeyQuery
     * @throws PropelException
     */
    protected function joinKeyQueryWithRelevantLocalesAndTranslations(GlossaryKeyQuery $keyQuery, array $relevantLocales)
    {
        $keyLocaleCrossJoin = new ModelJoin();
        $keyLocaleCrossJoin->setJoinType(Criteria::JOIN);

        $keyLocaleCrossJoin
            ->setTableMap(new TableMap())
            ->setLeftTableName('pac_glossary_key')
            ->setRightTableName('pac_locale')
            ->addCondition('id_glossary_key', 'id_locale', ModelCriteria::NOT_EQUAL)
        ;

        $translationLeftJoin = new ModelJoin();
        $translationLeftJoin->setJoinType(Criteria::LEFT_JOIN);
        $translationLeftJoin
            ->setTableMap(new TableMap())
            ->setLeftTableName('pac_glossary_key')
            ->setRightTableName('pac_glossary_translation')
            ->addCondition('id_glossary_key', 'fk_glossary_key')
        ;

        return $keyQuery
            ->addJoinObject($keyLocaleCrossJoin, 'pac_locale')
            ->addJoinObject($translationLeftJoin, 'pac_glossary_translation')
            ->addJoinCondition('pac_glossary_translation', 'pac_locale.id_locale = pac_glossary_translation.fk_locale')
            ->addJoinCondition('pac_locale', 'pac_locale.locale_name IN ?', $relevantLocales);
    }

    /**
     * @param ModelCriteria $query
     *
     * @return ModelCriteria
     */
    public function queryDistinctKeysFromQuery(ModelCriteria $query)
    {
        $query
        ->distinct('key')
        ->withColumn(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, 'value')
        ->withColumn(GlossaryKeyTableMap::COL_KEY, 'label');

        return $query;
    }

    /**
     * @param ModelCriteria $query
     *
     * @return ModelCriteria
     */
    public function queryDistinctLocalesFromQuery(ModelCriteria $query)
    {
        $query
            ->distinct('locale_name')
            ->withColumn(PacLocaleTableMap::COL_ID_LOCALE, 'value')
            ->withColumn(PacLocaleTableMap::COL_LOCALE_NAME, 'label');

        return $query;
    }

    /**
     * @param $idKey
     * @param array $relevantLocales
     *
     * @return ModelCriteria
     */
    public function queryMissingTranslationsForKey($idKey, array $relevantLocales)
    {
        $keyQuery = $this->queryKeyById($idKey);
        $keyQuery = $this->joinKeyQueryWithRelevantLocalesAndTranslations($keyQuery, $relevantLocales);
        $keyQuery
            ->where(GlossaryTranslationTableMap::COL_VALUE . '' . ModelCriteria::ISNULL);

        return $keyQuery;
    }

    /**
     * @param int $idKey
     *
     * @return GlossaryKeyQuery
     */
    protected function queryKeyById($idKey)
    {
        $query = GlossaryKeyQuery::create();
        $query->filterByIdGlossaryKey($idKey);

        return $query;
    }
}
