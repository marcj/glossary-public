<?php

namespace SprykerCore\Zed\Locale\Persistence\Propel\Base;

use \Exception;
use \PDO;
use ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttribute;
use ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProducts;
use ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributes;
use ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributes;
use ProjectA\Zed\Product\Persistence\Propel\PacTax;
use ProjectA\Zed\Product\Persistence\Propel\PacTypeValue;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocale as ChildPacLocale;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery as ChildPacLocaleQuery;
use SprykerCore\Zed\Locale\Persistence\Propel\Map\PacLocaleTableMap;
use SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrl;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation;

/**
 * Base class that represents a query for the 'pac_locale' table.
 *
 *
 *
 * @method     ChildPacLocaleQuery orderByIdLocale($order = Criteria::ASC) Order by the id_locale column
 * @method     ChildPacLocaleQuery orderByLocaleName($order = Criteria::ASC) Order by the locale_name column
 * @method     ChildPacLocaleQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 *
 * @method     ChildPacLocaleQuery groupByIdLocale() Group by the id_locale column
 * @method     ChildPacLocaleQuery groupByLocaleName() Group by the locale_name column
 * @method     ChildPacLocaleQuery groupByIsActive() Group by the is_active column
 *
 * @method     ChildPacLocaleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPacLocaleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPacLocaleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPacLocaleQuery leftJoinPacCategoryAttribute($relationAlias = null) Adds a LEFT JOIN clause to the query using the PacCategoryAttribute relation
 * @method     ChildPacLocaleQuery rightJoinPacCategoryAttribute($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PacCategoryAttribute relation
 * @method     ChildPacLocaleQuery innerJoinPacCategoryAttribute($relationAlias = null) Adds a INNER JOIN clause to the query using the PacCategoryAttribute relation
 *
 * @method     ChildPacLocaleQuery leftJoinPacLocalizedAbstractProductAttributes($relationAlias = null) Adds a LEFT JOIN clause to the query using the PacLocalizedAbstractProductAttributes relation
 * @method     ChildPacLocaleQuery rightJoinPacLocalizedAbstractProductAttributes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PacLocalizedAbstractProductAttributes relation
 * @method     ChildPacLocaleQuery innerJoinPacLocalizedAbstractProductAttributes($relationAlias = null) Adds a INNER JOIN clause to the query using the PacLocalizedAbstractProductAttributes relation
 *
 * @method     ChildPacLocaleQuery leftJoinPacLocalizedProductAttributes($relationAlias = null) Adds a LEFT JOIN clause to the query using the PacLocalizedProductAttributes relation
 * @method     ChildPacLocaleQuery rightJoinPacLocalizedProductAttributes($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PacLocalizedProductAttributes relation
 * @method     ChildPacLocaleQuery innerJoinPacLocalizedProductAttributes($relationAlias = null) Adds a INNER JOIN clause to the query using the PacLocalizedProductAttributes relation
 *
 * @method     ChildPacLocaleQuery leftJoinPacTax($relationAlias = null) Adds a LEFT JOIN clause to the query using the PacTax relation
 * @method     ChildPacLocaleQuery rightJoinPacTax($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PacTax relation
 * @method     ChildPacLocaleQuery innerJoinPacTax($relationAlias = null) Adds a INNER JOIN clause to the query using the PacTax relation
 *
 * @method     ChildPacLocaleQuery leftJoinPacTypeValue($relationAlias = null) Adds a LEFT JOIN clause to the query using the PacTypeValue relation
 * @method     ChildPacLocaleQuery rightJoinPacTypeValue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PacTypeValue relation
 * @method     ChildPacLocaleQuery innerJoinPacTypeValue($relationAlias = null) Adds a INNER JOIN clause to the query using the PacTypeValue relation
 *
 * @method     ChildPacLocaleQuery leftJoinPacSearchableProducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the PacSearchableProducts relation
 * @method     ChildPacLocaleQuery rightJoinPacSearchableProducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PacSearchableProducts relation
 * @method     ChildPacLocaleQuery innerJoinPacSearchableProducts($relationAlias = null) Adds a INNER JOIN clause to the query using the PacSearchableProducts relation
 *
 * @method     ChildPacLocaleQuery leftJoinSprykerCoreUrl($relationAlias = null) Adds a LEFT JOIN clause to the query using the SprykerCoreUrl relation
 * @method     ChildPacLocaleQuery rightJoinSprykerCoreUrl($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SprykerCoreUrl relation
 * @method     ChildPacLocaleQuery innerJoinSprykerCoreUrl($relationAlias = null) Adds a INNER JOIN clause to the query using the SprykerCoreUrl relation
 *
 * @method     ChildPacLocaleQuery leftJoinGlossaryTranslation($relationAlias = null) Adds a LEFT JOIN clause to the query using the GlossaryTranslation relation
 * @method     ChildPacLocaleQuery rightJoinGlossaryTranslation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GlossaryTranslation relation
 * @method     ChildPacLocaleQuery innerJoinGlossaryTranslation($relationAlias = null) Adds a INNER JOIN clause to the query using the GlossaryTranslation relation
 *
 * @method     \ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttributeQuery|\ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributesQuery|\ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributesQuery|\ProjectA\Zed\Product\Persistence\Propel\PacTaxQuery|\ProjectA\Zed\Product\Persistence\Propel\PacTypeValueQuery|\ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProductsQuery|\SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrlQuery|\SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPacLocale findOne(ConnectionInterface $con = null) Return the first ChildPacLocale matching the query
 * @method     ChildPacLocale findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPacLocale matching the query, or a new ChildPacLocale object populated from the query conditions when no match is found
 *
 * @method     ChildPacLocale findOneByIdLocale(int $id_locale) Return the first ChildPacLocale filtered by the id_locale column
 * @method     ChildPacLocale findOneByLocaleName(string $locale_name) Return the first ChildPacLocale filtered by the locale_name column
 * @method     ChildPacLocale findOneByIsActive(boolean $is_active) Return the first ChildPacLocale filtered by the is_active column
 *
 * @method     ChildPacLocale[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPacLocale objects based on current ModelCriteria
 * @method     ChildPacLocale[]|ObjectCollection findByIdLocale(int $id_locale) Return ChildPacLocale objects filtered by the id_locale column
 * @method     ChildPacLocale[]|ObjectCollection findByLocaleName(string $locale_name) Return ChildPacLocale objects filtered by the locale_name column
 * @method     ChildPacLocale[]|ObjectCollection findByIsActive(boolean $is_active) Return ChildPacLocale objects filtered by the is_active column
 * @method     ChildPacLocale[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PacLocaleQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \SprykerCore\Zed\Locale\Persistence\Propel\Base\PacLocaleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'zed', $modelName = '\\SprykerCore\\Zed\\Locale\\Persistence\\Propel\\PacLocale', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPacLocaleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPacLocaleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPacLocaleQuery) {
            return $criteria;
        }
        $query = new ChildPacLocaleQuery();
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
     * @return ChildPacLocale|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PacLocaleTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PacLocaleTableMap::DATABASE_NAME);
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
     * @return ChildPacLocale A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_locale, locale_name, is_active FROM pac_locale WHERE id_locale = :p0';
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
            /** @var ChildPacLocale $obj */

            /* @var $locator \Generated\Zed\Ide\AutoCompletion */
            $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
            $obj = $locator->locale()->entityPacLocale();

            $obj->hydrate($row);
            PacLocaleTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPacLocale|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_locale column
     *
     * Example usage:
     * <code>
     * $query->filterByIdLocale(1234); // WHERE id_locale = 1234
     * $query->filterByIdLocale(array(12, 34)); // WHERE id_locale IN (12, 34)
     * $query->filterByIdLocale(array('min' => 12)); // WHERE id_locale > 12
     * </code>
     *
     * @param     mixed $idLocale The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByIdLocale($idLocale = null, $comparison = null)
    {
        if (is_array($idLocale)) {
            $useMinMax = false;
            if (isset($idLocale['min'])) {
                $this->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $idLocale['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idLocale['max'])) {
                $this->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $idLocale['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $idLocale, $comparison);
    }

    /**
     * Filter the query on the locale_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLocaleName('fooValue');   // WHERE locale_name = 'fooValue'
     * $query->filterByLocaleName('%fooValue%'); // WHERE locale_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $localeName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByLocaleName($localeName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($localeName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $localeName)) {
                $localeName = str_replace('*', '%', $localeName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PacLocaleTableMap::COL_LOCALE_NAME, $localeName, $comparison);
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
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByIsActive($isActive = null, $comparison = null)
    {
        if (is_string($isActive)) {
            $isActive = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PacLocaleTableMap::COL_IS_ACTIVE, $isActive, $comparison);
    }

    /**
     * Filter the query by a related \ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttribute object
     *
     * @param \ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttribute|ObjectCollection $pacCategoryAttribute  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByPacCategoryAttribute($pacCategoryAttribute, $comparison = null)
    {
        if ($pacCategoryAttribute instanceof \ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttribute) {
            return $this
                ->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $pacCategoryAttribute->getLocaleId(), $comparison);
        } elseif ($pacCategoryAttribute instanceof ObjectCollection) {
            return $this
                ->usePacCategoryAttributeQuery()
                ->filterByPrimaryKeys($pacCategoryAttribute->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPacCategoryAttribute() only accepts arguments of type \ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttribute or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PacCategoryAttribute relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function joinPacCategoryAttribute($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PacCategoryAttribute');

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
            $this->addJoinObject($join, 'PacCategoryAttribute');
        }

        return $this;
    }

    /**
     * Use the PacCategoryAttribute relation PacCategoryAttribute object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttributeQuery A secondary query class using the current class as primary query
     */
    public function usePacCategoryAttributeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPacCategoryAttribute($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PacCategoryAttribute', '\ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttributeQuery');
    }

    /**
     * Filter the query by a related \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributes object
     *
     * @param \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributes|ObjectCollection $pacLocalizedAbstractProductAttributes  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByPacLocalizedAbstractProductAttributes($pacLocalizedAbstractProductAttributes, $comparison = null)
    {
        if ($pacLocalizedAbstractProductAttributes instanceof \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributes) {
            return $this
                ->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $pacLocalizedAbstractProductAttributes->getLocaleId(), $comparison);
        } elseif ($pacLocalizedAbstractProductAttributes instanceof ObjectCollection) {
            return $this
                ->usePacLocalizedAbstractProductAttributesQuery()
                ->filterByPrimaryKeys($pacLocalizedAbstractProductAttributes->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPacLocalizedAbstractProductAttributes() only accepts arguments of type \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PacLocalizedAbstractProductAttributes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function joinPacLocalizedAbstractProductAttributes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PacLocalizedAbstractProductAttributes');

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
            $this->addJoinObject($join, 'PacLocalizedAbstractProductAttributes');
        }

        return $this;
    }

    /**
     * Use the PacLocalizedAbstractProductAttributes relation PacLocalizedAbstractProductAttributes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributesQuery A secondary query class using the current class as primary query
     */
    public function usePacLocalizedAbstractProductAttributesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPacLocalizedAbstractProductAttributes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PacLocalizedAbstractProductAttributes', '\ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributesQuery');
    }

    /**
     * Filter the query by a related \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributes object
     *
     * @param \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributes|ObjectCollection $pacLocalizedProductAttributes  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByPacLocalizedProductAttributes($pacLocalizedProductAttributes, $comparison = null)
    {
        if ($pacLocalizedProductAttributes instanceof \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributes) {
            return $this
                ->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $pacLocalizedProductAttributes->getLocaleId(), $comparison);
        } elseif ($pacLocalizedProductAttributes instanceof ObjectCollection) {
            return $this
                ->usePacLocalizedProductAttributesQuery()
                ->filterByPrimaryKeys($pacLocalizedProductAttributes->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPacLocalizedProductAttributes() only accepts arguments of type \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributes or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PacLocalizedProductAttributes relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function joinPacLocalizedProductAttributes($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PacLocalizedProductAttributes');

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
            $this->addJoinObject($join, 'PacLocalizedProductAttributes');
        }

        return $this;
    }

    /**
     * Use the PacLocalizedProductAttributes relation PacLocalizedProductAttributes object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributesQuery A secondary query class using the current class as primary query
     */
    public function usePacLocalizedProductAttributesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPacLocalizedProductAttributes($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PacLocalizedProductAttributes', '\ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributesQuery');
    }

    /**
     * Filter the query by a related \ProjectA\Zed\Product\Persistence\Propel\PacTax object
     *
     * @param \ProjectA\Zed\Product\Persistence\Propel\PacTax|ObjectCollection $pacTax  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByPacTax($pacTax, $comparison = null)
    {
        if ($pacTax instanceof \ProjectA\Zed\Product\Persistence\Propel\PacTax) {
            return $this
                ->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $pacTax->getLocaleId(), $comparison);
        } elseif ($pacTax instanceof ObjectCollection) {
            return $this
                ->usePacTaxQuery()
                ->filterByPrimaryKeys($pacTax->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPacTax() only accepts arguments of type \ProjectA\Zed\Product\Persistence\Propel\PacTax or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PacTax relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function joinPacTax($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PacTax');

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
            $this->addJoinObject($join, 'PacTax');
        }

        return $this;
    }

    /**
     * Use the PacTax relation PacTax object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjectA\Zed\Product\Persistence\Propel\PacTaxQuery A secondary query class using the current class as primary query
     */
    public function usePacTaxQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPacTax($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PacTax', '\ProjectA\Zed\Product\Persistence\Propel\PacTaxQuery');
    }

    /**
     * Filter the query by a related \ProjectA\Zed\Product\Persistence\Propel\PacTypeValue object
     *
     * @param \ProjectA\Zed\Product\Persistence\Propel\PacTypeValue|ObjectCollection $pacTypeValue  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByPacTypeValue($pacTypeValue, $comparison = null)
    {
        if ($pacTypeValue instanceof \ProjectA\Zed\Product\Persistence\Propel\PacTypeValue) {
            return $this
                ->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $pacTypeValue->getLocaleId(), $comparison);
        } elseif ($pacTypeValue instanceof ObjectCollection) {
            return $this
                ->usePacTypeValueQuery()
                ->filterByPrimaryKeys($pacTypeValue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPacTypeValue() only accepts arguments of type \ProjectA\Zed\Product\Persistence\Propel\PacTypeValue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PacTypeValue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function joinPacTypeValue($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PacTypeValue');

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
            $this->addJoinObject($join, 'PacTypeValue');
        }

        return $this;
    }

    /**
     * Use the PacTypeValue relation PacTypeValue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjectA\Zed\Product\Persistence\Propel\PacTypeValueQuery A secondary query class using the current class as primary query
     */
    public function usePacTypeValueQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPacTypeValue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PacTypeValue', '\ProjectA\Zed\Product\Persistence\Propel\PacTypeValueQuery');
    }

    /**
     * Filter the query by a related \ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProducts object
     *
     * @param \ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProducts|ObjectCollection $pacSearchableProducts  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByPacSearchableProducts($pacSearchableProducts, $comparison = null)
    {
        if ($pacSearchableProducts instanceof \ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProducts) {
            return $this
                ->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $pacSearchableProducts->getFkLocale(), $comparison);
        } elseif ($pacSearchableProducts instanceof ObjectCollection) {
            return $this
                ->usePacSearchableProductsQuery()
                ->filterByPrimaryKeys($pacSearchableProducts->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPacSearchableProducts() only accepts arguments of type \ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProducts or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PacSearchableProducts relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function joinPacSearchableProducts($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PacSearchableProducts');

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
            $this->addJoinObject($join, 'PacSearchableProducts');
        }

        return $this;
    }

    /**
     * Use the PacSearchableProducts relation PacSearchableProducts object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProductsQuery A secondary query class using the current class as primary query
     */
    public function usePacSearchableProductsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPacSearchableProducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PacSearchableProducts', '\ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProductsQuery');
    }

    /**
     * Filter the query by a related \SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrl object
     *
     * @param \SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrl|ObjectCollection $sprykerCoreUrl  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterBySprykerCoreUrl($sprykerCoreUrl, $comparison = null)
    {
        if ($sprykerCoreUrl instanceof \SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrl) {
            return $this
                ->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $sprykerCoreUrl->getFkLocale(), $comparison);
        } elseif ($sprykerCoreUrl instanceof ObjectCollection) {
            return $this
                ->useSprykerCoreUrlQuery()
                ->filterByPrimaryKeys($sprykerCoreUrl->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySprykerCoreUrl() only accepts arguments of type \SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrl or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SprykerCoreUrl relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function joinSprykerCoreUrl($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SprykerCoreUrl');

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
            $this->addJoinObject($join, 'SprykerCoreUrl');
        }

        return $this;
    }

    /**
     * Use the SprykerCoreUrl relation SprykerCoreUrl object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrlQuery A secondary query class using the current class as primary query
     */
    public function useSprykerCoreUrlQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSprykerCoreUrl($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SprykerCoreUrl', '\SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrlQuery');
    }

    /**
     * Filter the query by a related \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation object
     *
     * @param \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation|ObjectCollection $glossaryTranslation  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPacLocaleQuery The current query, for fluid interface
     */
    public function filterByGlossaryTranslation($glossaryTranslation, $comparison = null)
    {
        if ($glossaryTranslation instanceof \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation) {
            return $this
                ->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $glossaryTranslation->getFkLocale(), $comparison);
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
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
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
     * @param   ChildPacLocale $pacLocale Object to remove from the list of results
     *
     * @return $this|ChildPacLocaleQuery The current query, for fluid interface
     */
    public function prune($pacLocale = null)
    {
        if ($pacLocale) {
            $this->addUsingAlias(PacLocaleTableMap::COL_ID_LOCALE, $pacLocale->getIdLocale(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pac_locale table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PacLocaleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PacLocaleTableMap::clearInstancePool();
            PacLocaleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PacLocaleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PacLocaleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PacLocaleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PacLocaleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PacLocaleQuery
