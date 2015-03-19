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
use SprykerFeature\Zed\Cms\Persistence\Propel\SprykerFeatureGlossaryKeyMapping;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey as ChildGlossaryKey;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKeyQuery as ChildGlossaryKeyQuery;
use SprykerFeature\Zed\Glossary\Persistence\Propel\Map\GlossaryKeyTableMap;

/**
 * Base class that represents a query for the 'spy_glossary_key' table.
 *
 *
 *
 * @method     ChildGlossaryKeyQuery orderByIdGlossaryKey($order = Criteria::ASC) Order by the id_glossary_key column
 * @method     ChildGlossaryKeyQuery orderByKey($order = Criteria::ASC) Order by the key column
 * @method     ChildGlossaryKeyQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 *
 * @method     ChildGlossaryKeyQuery groupByIdGlossaryKey() Group by the id_glossary_key column
 * @method     ChildGlossaryKeyQuery groupByKey() Group by the key column
 * @method     ChildGlossaryKeyQuery groupByIsActive() Group by the is_active column
 *
 * @method     ChildGlossaryKeyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGlossaryKeyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGlossaryKeyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGlossaryKeyQuery leftJoinSprykerFeatureGlossaryKeyMapping($relationAlias = null) Adds a LEFT JOIN clause to the query using the SprykerFeatureGlossaryKeyMapping relation
 * @method     ChildGlossaryKeyQuery rightJoinSprykerFeatureGlossaryKeyMapping($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SprykerFeatureGlossaryKeyMapping relation
 * @method     ChildGlossaryKeyQuery innerJoinSprykerFeatureGlossaryKeyMapping($relationAlias = null) Adds a INNER JOIN clause to the query using the SprykerFeatureGlossaryKeyMapping relation
 *
 * @method     ChildGlossaryKeyQuery leftJoinGlossaryTranslation($relationAlias = null) Adds a LEFT JOIN clause to the query using the GlossaryTranslation relation
 * @method     ChildGlossaryKeyQuery rightJoinGlossaryTranslation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GlossaryTranslation relation
 * @method     ChildGlossaryKeyQuery innerJoinGlossaryTranslation($relationAlias = null) Adds a INNER JOIN clause to the query using the GlossaryTranslation relation
 *
 * @method     \SprykerFeature\Zed\Cms\Persistence\Propel\SprykerFeatureGlossaryKeyMappingQuery|\SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGlossaryKey findOne(ConnectionInterface $con = null) Return the first ChildGlossaryKey matching the query
 * @method     ChildGlossaryKey findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGlossaryKey matching the query, or a new ChildGlossaryKey object populated from the query conditions when no match is found
 *
 * @method     ChildGlossaryKey findOneByIdGlossaryKey(int $id_glossary_key) Return the first ChildGlossaryKey filtered by the id_glossary_key column
 * @method     ChildGlossaryKey findOneByKey(string $key) Return the first ChildGlossaryKey filtered by the key column
 * @method     ChildGlossaryKey findOneByIsActive(boolean $is_active) Return the first ChildGlossaryKey filtered by the is_active column
 *
 * @method     ChildGlossaryKey[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGlossaryKey objects based on current ModelCriteria
 * @method     ChildGlossaryKey[]|ObjectCollection findByIdGlossaryKey(int $id_glossary_key) Return ChildGlossaryKey objects filtered by the id_glossary_key column
 * @method     ChildGlossaryKey[]|ObjectCollection findByKey(string $key) Return ChildGlossaryKey objects filtered by the key column
 * @method     ChildGlossaryKey[]|ObjectCollection findByIsActive(boolean $is_active) Return ChildGlossaryKey objects filtered by the is_active column
 * @method     ChildGlossaryKey[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GlossaryKeyQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \SprykerFeature\Zed\Glossary\Persistence\Propel\Base\GlossaryKeyQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'zed', $modelName = '\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryKey', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGlossaryKeyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGlossaryKeyQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGlossaryKeyQuery) {
            return $criteria;
        }
        $query = new ChildGlossaryKeyQuery();
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
     * @return ChildGlossaryKey|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GlossaryKeyTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GlossaryKeyTableMap::DATABASE_NAME);
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
     * @return ChildGlossaryKey A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id_glossary_key`, `key`, `is_active` FROM `spy_glossary_key` WHERE `id_glossary_key` = :p0';
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
            /** @var ChildGlossaryKey $obj */

            /* @var $locator \Generated\Zed\Ide\AutoCompletion */
            $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
            $obj = $locator->glossary()->entityGlossaryKey();

            $obj->hydrate($row);
            GlossaryKeyTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildGlossaryKey|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_glossary_key column
     *
     * Example usage:
     * <code>
     * $query->filterByIdGlossaryKey(1234); // WHERE id_glossary_key = 1234
     * $query->filterByIdGlossaryKey(array(12, 34)); // WHERE id_glossary_key IN (12, 34)
     * $query->filterByIdGlossaryKey(array('min' => 12)); // WHERE id_glossary_key > 12
     * </code>
     *
     * @param     mixed $idGlossaryKey The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function filterByIdGlossaryKey($idGlossaryKey = null, $comparison = null)
    {
        if (is_array($idGlossaryKey)) {
            $useMinMax = false;
            if (isset($idGlossaryKey['min'])) {
                $this->addUsingAlias(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, $idGlossaryKey['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idGlossaryKey['max'])) {
                $this->addUsingAlias(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, $idGlossaryKey['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, $idGlossaryKey, $comparison);
    }

    /**
     * Filter the query on the key column
     *
     * Example usage:
     * <code>
     * $query->filterByKey('fooValue');   // WHERE key = 'fooValue'
     * $query->filterByKey('%fooValue%'); // WHERE key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $key The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function filterByKey($key = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($key)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $key)) {
                $key = str_replace('*', '%', $key);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GlossaryKeyTableMap::COL_KEY, $key, $comparison);
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
     * @return $this|ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function filterByIsActive($isActive = null, $comparison = null)
    {
        if (is_string($isActive)) {
            $isActive = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(GlossaryKeyTableMap::COL_IS_ACTIVE, $isActive, $comparison);
    }

    /**
     * Filter the query by a related \SprykerFeature\Zed\Cms\Persistence\Propel\SprykerFeatureGlossaryKeyMapping object
     *
     * @param \SprykerFeature\Zed\Cms\Persistence\Propel\SprykerFeatureGlossaryKeyMapping|ObjectCollection $sprykerFeatureGlossaryKeyMapping  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function filterBySprykerFeatureGlossaryKeyMapping($sprykerFeatureGlossaryKeyMapping, $comparison = null)
    {
        if ($sprykerFeatureGlossaryKeyMapping instanceof \SprykerFeature\Zed\Cms\Persistence\Propel\SprykerFeatureGlossaryKeyMapping) {
            return $this
                ->addUsingAlias(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, $sprykerFeatureGlossaryKeyMapping->getFkGlossaryKey(), $comparison);
        } elseif ($sprykerFeatureGlossaryKeyMapping instanceof ObjectCollection) {
            return $this
                ->useSprykerFeatureGlossaryKeyMappingQuery()
                ->filterByPrimaryKeys($sprykerFeatureGlossaryKeyMapping->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySprykerFeatureGlossaryKeyMapping() only accepts arguments of type \SprykerFeature\Zed\Cms\Persistence\Propel\SprykerFeatureGlossaryKeyMapping or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SprykerFeatureGlossaryKeyMapping relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function joinSprykerFeatureGlossaryKeyMapping($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SprykerFeatureGlossaryKeyMapping');

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
            $this->addJoinObject($join, 'SprykerFeatureGlossaryKeyMapping');
        }

        return $this;
    }

    /**
     * Use the SprykerFeatureGlossaryKeyMapping relation SprykerFeatureGlossaryKeyMapping object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SprykerFeature\Zed\Cms\Persistence\Propel\SprykerFeatureGlossaryKeyMappingQuery A secondary query class using the current class as primary query
     */
    public function useSprykerFeatureGlossaryKeyMappingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSprykerFeatureGlossaryKeyMapping($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SprykerFeatureGlossaryKeyMapping', '\SprykerFeature\Zed\Cms\Persistence\Propel\SprykerFeatureGlossaryKeyMappingQuery');
    }

    /**
     * Filter the query by a related \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation object
     *
     * @param \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation|ObjectCollection $glossaryTranslation  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function filterByGlossaryTranslation($glossaryTranslation, $comparison = null)
    {
        if ($glossaryTranslation instanceof \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation) {
            return $this
                ->addUsingAlias(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, $glossaryTranslation->getFkGlossaryKey(), $comparison);
        } elseif ($glossaryTranslation instanceof ObjectCollection) {
            return $this
                ->useGlossaryTranslationQuery()
                ->filterByPrimaryKeys($glossaryTranslation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGlossaryTranslation() only accepts arguments of type \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GlossaryTranslation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function joinGlossaryTranslation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GlossaryTranslation');

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
            $this->addJoinObject($join, 'GlossaryTranslation');
        }

        return $this;
    }

    /**
     * Use the GlossaryTranslation relation GlossaryTranslation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery A secondary query class using the current class as primary query
     */
    public function useGlossaryTranslationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGlossaryTranslation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GlossaryTranslation', '\SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGlossaryKey $glossaryKey Object to remove from the list of results
     *
     * @return $this|ChildGlossaryKeyQuery The current query, for fluid interface
     */
    public function prune($glossaryKey = null)
    {
        if ($glossaryKey) {
            $this->addUsingAlias(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, $glossaryKey->getIdGlossaryKey(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the spy_glossary_key table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GlossaryKeyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GlossaryKeyTableMap::clearInstancePool();
            GlossaryKeyTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GlossaryKeyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GlossaryKeyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GlossaryKeyTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GlossaryKeyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GlossaryKeyQuery
