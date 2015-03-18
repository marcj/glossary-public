<?php

namespace SprykerFeature\Zed\Glossary\Persistence\Propel\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocale;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation as ChildGlossaryTranslation;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery as ChildGlossaryTranslationQuery;
use SprykerFeature\Zed\Glossary\Persistence\Propel\Map\GlossaryTranslationTableMap;

/**
 * Base class that represents a query for the 'spy_glossary_translation' table.
 *
 *
 *
 * @method     ChildGlossaryTranslationQuery orderByIdGlossaryTranslation($order = Criteria::ASC) Order by the id_glossary_translation column
 * @method     ChildGlossaryTranslationQuery orderByFkGlossaryKey($order = Criteria::ASC) Order by the fk_glossary_key column
 * @method     ChildGlossaryTranslationQuery orderByFkLocale($order = Criteria::ASC) Order by the fk_locale column
 * @method     ChildGlossaryTranslationQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildGlossaryTranslationQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 *
 * @method     ChildGlossaryTranslationQuery groupByIdGlossaryTranslation() Group by the id_glossary_translation column
 * @method     ChildGlossaryTranslationQuery groupByFkGlossaryKey() Group by the fk_glossary_key column
 * @method     ChildGlossaryTranslationQuery groupByFkLocale() Group by the fk_locale column
 * @method     ChildGlossaryTranslationQuery groupByValue() Group by the value column
 * @method     ChildGlossaryTranslationQuery groupByIsActive() Group by the is_active column
 *
 * @method     ChildGlossaryTranslationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGlossaryTranslationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGlossaryTranslationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGlossaryTranslationQuery leftJoinGlossaryKey($relationAlias = null) Adds a LEFT JOIN clause to the query using the GlossaryKey relation
 * @method     ChildGlossaryTranslationQuery rightJoinGlossaryKey($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GlossaryKey relation
 * @method     ChildGlossaryTranslationQuery innerJoinGlossaryKey($relationAlias = null) Adds a INNER JOIN clause to the query using the GlossaryKey relation
 *
 * @method     ChildGlossaryTranslationQuery leftJoinGlossaryLocale($relationAlias = null) Adds a LEFT JOIN clause to the query using the GlossaryLocale relation
 * @method     ChildGlossaryTranslationQuery rightJoinGlossaryLocale($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GlossaryLocale relation
 * @method     ChildGlossaryTranslationQuery innerJoinGlossaryLocale($relationAlias = null) Adds a INNER JOIN clause to the query using the GlossaryLocale relation
 *
 * @method     \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKeyQuery|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGlossaryTranslation findOne(ConnectionInterface $con = null) Return the first ChildGlossaryTranslation matching the query
 * @method     ChildGlossaryTranslation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGlossaryTranslation matching the query, or a new ChildGlossaryTranslation object populated from the query conditions when no match is found
 *
 * @method     ChildGlossaryTranslation findOneByIdGlossaryTranslation(int $id_glossary_translation) Return the first ChildGlossaryTranslation filtered by the id_glossary_translation column
 * @method     ChildGlossaryTranslation findOneByFkGlossaryKey(int $fk_glossary_key) Return the first ChildGlossaryTranslation filtered by the fk_glossary_key column
 * @method     ChildGlossaryTranslation findOneByFkLocale(int $fk_locale) Return the first ChildGlossaryTranslation filtered by the fk_locale column
 * @method     ChildGlossaryTranslation findOneByValue(string $value) Return the first ChildGlossaryTranslation filtered by the value column
 * @method     ChildGlossaryTranslation findOneByIsActive(boolean $is_active) Return the first ChildGlossaryTranslation filtered by the is_active column
 *
 * @method     ChildGlossaryTranslation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGlossaryTranslation objects based on current ModelCriteria
 * @method     ChildGlossaryTranslation[]|ObjectCollection findByIdGlossaryTranslation(int $id_glossary_translation) Return ChildGlossaryTranslation objects filtered by the id_glossary_translation column
 * @method     ChildGlossaryTranslation[]|ObjectCollection findByFkGlossaryKey(int $fk_glossary_key) Return ChildGlossaryTranslation objects filtered by the fk_glossary_key column
 * @method     ChildGlossaryTranslation[]|ObjectCollection findByFkLocale(int $fk_locale) Return ChildGlossaryTranslation objects filtered by the fk_locale column
 * @method     ChildGlossaryTranslation[]|ObjectCollection findByValue(string $value) Return ChildGlossaryTranslation objects filtered by the value column
 * @method     ChildGlossaryTranslation[]|ObjectCollection findByIsActive(boolean $is_active) Return ChildGlossaryTranslation objects filtered by the is_active column
 * @method     ChildGlossaryTranslation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GlossaryTranslationQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \SprykerFeature\Zed\Glossary\Persistence\Propel\Base\GlossaryTranslationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'zed', $modelName = '\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryTranslation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGlossaryTranslationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGlossaryTranslationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGlossaryTranslationQuery) {
            return $criteria;
        }
        $query = new ChildGlossaryTranslationQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildGlossaryTranslation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GlossaryTranslationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GlossaryTranslationTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGlossaryTranslation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id_glossary_translation`, `fk_glossary_key`, `fk_locale`, `value`, `is_active` FROM `spy_glossary_translation` WHERE `id_glossary_translation` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildGlossaryTranslation $obj */

            /* @var $locator \Generated\Zed\Ide\AutoCompletion */
            $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
            $obj = $locator->glossary()->entityGlossaryTranslation();

            $obj->hydrate($row);
            GlossaryTranslationTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildGlossaryTranslation|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_glossary_translation column
     *
     * Example usage:
     * <code>
     * $query->filterByIdGlossaryTranslation(1234); // WHERE id_glossary_translation = 1234
     * $query->filterByIdGlossaryTranslation(array(12, 34)); // WHERE id_glossary_translation IN (12, 34)
     * $query->filterByIdGlossaryTranslation(array('min' => 12)); // WHERE id_glossary_translation > 12
     * </code>
     *
     * @param     mixed $idGlossaryTranslation The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByIdGlossaryTranslation($idGlossaryTranslation = null, $comparison = null)
    {
        if (is_array($idGlossaryTranslation)) {
            $useMinMax = false;
            if (isset($idGlossaryTranslation['min'])) {
                $this->addUsingAlias(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION, $idGlossaryTranslation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGlossaryTranslation['max'])) {
                $this->addUsingAlias(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION, $idGlossaryTranslation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION, $idGlossaryTranslation, $comparison);
    }

    /**
     * Filter the query on the fk_glossary_key column
     *
     * Example usage:
     * <code>
     * $query->filterByFkGlossaryKey(1234); // WHERE fk_glossary_key = 1234
     * $query->filterByFkGlossaryKey(array(12, 34)); // WHERE fk_glossary_key IN (12, 34)
     * $query->filterByFkGlossaryKey(array('min' => 12)); // WHERE fk_glossary_key > 12
     * </code>
     *
     * @see       filterByGlossaryKey()
     *
     * @param     mixed $fkGlossaryKey The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByFkGlossaryKey($fkGlossaryKey = null, $comparison = null)
    {
        if (is_array($fkGlossaryKey)) {
            $useMinMax = false;
            if (isset($fkGlossaryKey['min'])) {
                $this->addUsingAlias(GlossaryTranslationTableMap::COL_FK_GLOSSARY_KEY, $fkGlossaryKey['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkGlossaryKey['max'])) {
                $this->addUsingAlias(GlossaryTranslationTableMap::COL_FK_GLOSSARY_KEY, $fkGlossaryKey['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GlossaryTranslationTableMap::COL_FK_GLOSSARY_KEY, $fkGlossaryKey, $comparison);
    }

    /**
     * Filter the query on the fk_locale column
     *
     * Example usage:
     * <code>
     * $query->filterByFkLocale(1234); // WHERE fk_locale = 1234
     * $query->filterByFkLocale(array(12, 34)); // WHERE fk_locale IN (12, 34)
     * $query->filterByFkLocale(array('min' => 12)); // WHERE fk_locale > 12
     * </code>
     *
     * @see       filterByGlossaryLocale()
     *
     * @param     mixed $fkLocale The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByFkLocale($fkLocale = null, $comparison = null)
    {
        if (is_array($fkLocale)) {
            $useMinMax = false;
            if (isset($fkLocale['min'])) {
                $this->addUsingAlias(GlossaryTranslationTableMap::COL_FK_LOCALE, $fkLocale['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkLocale['max'])) {
                $this->addUsingAlias(GlossaryTranslationTableMap::COL_FK_LOCALE, $fkLocale['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GlossaryTranslationTableMap::COL_FK_LOCALE, $fkLocale, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GlossaryTranslationTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the is_active column
     *
     * Example usage:
     * <code>
     * $query->filterByIsActive(true); // WHERE is_active = true
     * $query->filterByIsActive('yes'); // WHERE is_active = true
     * </code>
     *
     * @param     boolean|string $isActive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByIsActive($isActive = null, $comparison = null)
    {
        if (is_string($isActive)) {
            $isActive = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GlossaryTranslationTableMap::COL_IS_ACTIVE, $isActive, $comparison);
    }

    /**
     * Filter the query by a related \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey object
     *
     * @param \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey|ObjectCollection $glossaryKey The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByGlossaryKey($glossaryKey, $comparison = null)
    {
        if ($glossaryKey instanceof \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey) {
            return $this
                ->addUsingAlias(GlossaryTranslationTableMap::COL_FK_GLOSSARY_KEY, $glossaryKey->getIdGlossaryKey(), $comparison);
        } elseif ($glossaryKey instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GlossaryTranslationTableMap::COL_FK_GLOSSARY_KEY, $glossaryKey->toKeyValue('PrimaryKey', 'IdGlossaryKey'), $comparison);
        } else {
            throw new PropelException('filterByGlossaryKey() only accepts arguments of type \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GlossaryKey relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function joinGlossaryKey($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GlossaryKey');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GlossaryKey');
        }

        return $this;
    }

    /**
     * Use the GlossaryKey relation GlossaryKey object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKeyQuery A secondary query class using the current class as primary query
     */
    public function useGlossaryKeyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGlossaryKey($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GlossaryKey', '\SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKeyQuery');
    }

    /**
     * Filter the query by a related \SprykerCore\Zed\Locale\Persistence\Propel\PacLocale object
     *
     * @param \SprykerCore\Zed\Locale\Persistence\Propel\PacLocale|ObjectCollection $pacLocale The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function filterByGlossaryLocale($pacLocale, $comparison = null)
    {
        if ($pacLocale instanceof \SprykerCore\Zed\Locale\Persistence\Propel\PacLocale) {
            return $this
                ->addUsingAlias(GlossaryTranslationTableMap::COL_FK_LOCALE, $pacLocale->getIdLocale(), $comparison);
        } elseif ($pacLocale instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GlossaryTranslationTableMap::COL_FK_LOCALE, $pacLocale->toKeyValue('PrimaryKey', 'IdLocale'), $comparison);
        } else {
            throw new PropelException('filterByGlossaryLocale() only accepts arguments of type \SprykerCore\Zed\Locale\Persistence\Propel\PacLocale or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GlossaryLocale relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function joinGlossaryLocale($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GlossaryLocale');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GlossaryLocale');
        }

        return $this;
    }

    /**
     * Use the GlossaryLocale relation PacLocale object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery A secondary query class using the current class as primary query
     */
    public function useGlossaryLocaleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGlossaryLocale($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GlossaryLocale', '\SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGlossaryTranslation $glossaryTranslation Object to remove from the list of results
     *
     * @return $this|ChildGlossaryTranslationQuery The current query, for fluid interface
     */
    public function prune($glossaryTranslation = null)
    {
        if ($glossaryTranslation) {
            $this->addUsingAlias(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION, $glossaryTranslation->getIdGlossaryTranslation(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the spy_glossary_translation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GlossaryTranslationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GlossaryTranslationTableMap::clearInstancePool();
            GlossaryTranslationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GlossaryTranslationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GlossaryTranslationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GlossaryTranslationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GlossaryTranslationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GlossaryTranslationQuery
