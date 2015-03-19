<?php

namespace SprykerCore\Zed\Touch\Persistence\Propel\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use SprykerCore\Zed\Touch\Persistence\Propel\PacTouch as ChildPacTouch;
use SprykerCore\Zed\Touch\Persistence\Propel\PacTouchQuery as ChildPacTouchQuery;
use SprykerCore\Zed\Touch\Persistence\Propel\Map\PacTouchTableMap;

/**
 * Base class that represents a query for the 'pac_touch' table.
 *
 *
 *
 * @method     ChildPacTouchQuery orderByIdTouch($order = Criteria::ASC) Order by the id_touch column
 * @method     ChildPacTouchQuery orderByItemType($order = Criteria::ASC) Order by the item_type column
 * @method     ChildPacTouchQuery orderByItemEvent($order = Criteria::ASC) Order by the item_event column
 * @method     ChildPacTouchQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildPacTouchQuery orderByTouched($order = Criteria::ASC) Order by the touched column
 *
 * @method     ChildPacTouchQuery groupByIdTouch() Group by the id_touch column
 * @method     ChildPacTouchQuery groupByItemType() Group by the item_type column
 * @method     ChildPacTouchQuery groupByItemEvent() Group by the item_event column
 * @method     ChildPacTouchQuery groupByItemId() Group by the item_id column
 * @method     ChildPacTouchQuery groupByTouched() Group by the touched column
 *
 * @method     ChildPacTouchQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPacTouchQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPacTouchQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPacTouch findOne(ConnectionInterface $con = null) Return the first ChildPacTouch matching the query
 * @method     ChildPacTouch findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPacTouch matching the query, or a new ChildPacTouch object populated from the query conditions when no match is found
 *
 * @method     ChildPacTouch findOneByIdTouch(int $id_touch) Return the first ChildPacTouch filtered by the id_touch column
 * @method     ChildPacTouch findOneByItemType(string $item_type) Return the first ChildPacTouch filtered by the item_type column
 * @method     ChildPacTouch findOneByItemEvent(int $item_event) Return the first ChildPacTouch filtered by the item_event column
 * @method     ChildPacTouch findOneByItemId(int $item_id) Return the first ChildPacTouch filtered by the item_id column
 * @method     ChildPacTouch findOneByTouched(string $touched) Return the first ChildPacTouch filtered by the touched column
 *
 * @method     ChildPacTouch[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPacTouch objects based on current ModelCriteria
 * @method     ChildPacTouch[]|ObjectCollection findByIdTouch(int $id_touch) Return ChildPacTouch objects filtered by the id_touch column
 * @method     ChildPacTouch[]|ObjectCollection findByItemType(string $item_type) Return ChildPacTouch objects filtered by the item_type column
 * @method     ChildPacTouch[]|ObjectCollection findByItemEvent(int $item_event) Return ChildPacTouch objects filtered by the item_event column
 * @method     ChildPacTouch[]|ObjectCollection findByItemId(int $item_id) Return ChildPacTouch objects filtered by the item_id column
 * @method     ChildPacTouch[]|ObjectCollection findByTouched(string $touched) Return ChildPacTouch objects filtered by the touched column
 * @method     ChildPacTouch[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PacTouchQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \SprykerCore\Zed\Touch\Persistence\Propel\Base\PacTouchQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'zed', $modelName = '\\SprykerCore\\Zed\\Touch\\Persistence\\Propel\\PacTouch', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPacTouchQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPacTouchQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPacTouchQuery) {
            return $criteria;
        }
        $query = new ChildPacTouchQuery();
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
     * @return ChildPacTouch|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PacTouchTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PacTouchTableMap::DATABASE_NAME);
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
     * @return ChildPacTouch A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_touch, item_type, item_event, item_id, touched FROM pac_touch WHERE id_touch = :p0';
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
            /** @var ChildPacTouch $obj */

            /* @var $locator \Generated\Zed\Ide\AutoCompletion */
            $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
            $obj = $locator->touch()->entityPacTouch();

            $obj->hydrate($row);
            PacTouchTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPacTouch|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPacTouchQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PacTouchTableMap::COL_ID_TOUCH, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPacTouchQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PacTouchTableMap::COL_ID_TOUCH, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_touch column
     *
     * Example usage:
     * <code>
     * $query->filterByIdTouch(1234); // WHERE id_touch = 1234
     * $query->filterByIdTouch(array(12, 34)); // WHERE id_touch IN (12, 34)
     * $query->filterByIdTouch(array('min' => 12)); // WHERE id_touch > 12
     * </code>
     *
     * @param     mixed $idTouch The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPacTouchQuery The current query, for fluid interface
     */
    public function filterByIdTouch($idTouch = null, $comparison = null)
    {
        if (is_array($idTouch)) {
            $useMinMax = false;
            if (isset($idTouch['min'])) {
                $this->addUsingAlias(PacTouchTableMap::COL_ID_TOUCH, $idTouch['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idTouch['max'])) {
                $this->addUsingAlias(PacTouchTableMap::COL_ID_TOUCH, $idTouch['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacTouchTableMap::COL_ID_TOUCH, $idTouch, $comparison);
    }

    /**
     * Filter the query on the item_type column
     *
     * Example usage:
     * <code>
     * $query->filterByItemType('fooValue');   // WHERE item_type = 'fooValue'
     * $query->filterByItemType('%fooValue%'); // WHERE item_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $itemType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPacTouchQuery The current query, for fluid interface
     */
    public function filterByItemType($itemType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($itemType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $itemType)) {
                $itemType = str_replace('*', '%', $itemType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PacTouchTableMap::COL_ITEM_TYPE, $itemType, $comparison);
    }

    /**
     * Filter the query on the item_event column
     *
     * @param     mixed $itemEvent The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPacTouchQuery The current query, for fluid interface
     */
    public function filterByItemEvent($itemEvent = null, $comparison = null)
    {
        $valueSet = PacTouchTableMap::getValueSet(PacTouchTableMap::COL_ITEM_EVENT);
        if (is_scalar($itemEvent)) {
            if (!in_array($itemEvent, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $itemEvent));
            }
            $itemEvent = array_search($itemEvent, $valueSet);
        } elseif (is_array($itemEvent)) {
            $convertedValues = array();
            foreach ($itemEvent as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $itemEvent = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacTouchTableMap::COL_ITEM_EVENT, $itemEvent, $comparison);
    }

    /**
     * Filter the query on the item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemId(1234); // WHERE item_id = 1234
     * $query->filterByItemId(array(12, 34)); // WHERE item_id IN (12, 34)
     * $query->filterByItemId(array('min' => 12)); // WHERE item_id > 12
     * </code>
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPacTouchQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(PacTouchTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(PacTouchTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacTouchTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the touched column
     *
     * Example usage:
     * <code>
     * $query->filterByTouched('2011-03-14'); // WHERE touched = '2011-03-14'
     * $query->filterByTouched('now'); // WHERE touched = '2011-03-14'
     * $query->filterByTouched(array('max' => 'yesterday')); // WHERE touched > '2011-03-13'
     * </code>
     *
     * @param     mixed $touched The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPacTouchQuery The current query, for fluid interface
     */
    public function filterByTouched($touched = null, $comparison = null)
    {
        if (is_array($touched)) {
            $useMinMax = false;
            if (isset($touched['min'])) {
                $this->addUsingAlias(PacTouchTableMap::COL_TOUCHED, $touched['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($touched['max'])) {
                $this->addUsingAlias(PacTouchTableMap::COL_TOUCHED, $touched['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacTouchTableMap::COL_TOUCHED, $touched, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPacTouch $pacTouch Object to remove from the list of results
     *
     * @return $this|ChildPacTouchQuery The current query, for fluid interface
     */
    public function prune($pacTouch = null)
    {
        if ($pacTouch) {
            $this->addUsingAlias(PacTouchTableMap::COL_ID_TOUCH, $pacTouch->getIdTouch(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pac_touch table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PacTouchTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PacTouchTableMap::clearInstancePool();
            PacTouchTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PacTouchTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PacTouchTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PacTouchTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PacTouchTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PacTouchQuery
