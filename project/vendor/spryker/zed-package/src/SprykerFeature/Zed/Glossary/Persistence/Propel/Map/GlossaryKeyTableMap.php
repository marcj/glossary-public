<?php

namespace SprykerFeature\Zed\Glossary\Persistence\Propel\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use SprykerFeature\Zed\Cms\Persistence\Propel\Map\SprykerFeatureGlossaryKeyMappingTableMap;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKeyQuery;


/**
 * This class defines the structure of the 'spy_glossary_key' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class GlossaryKeyTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'vendor.spryker.zed-package.src.SprykerFeature.Zed.Glossary.Persistence.Propel.Map.GlossaryKeyTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'zed';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'spy_glossary_key';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryKey';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'vendor.spryker.zed-package.src.SprykerFeature.Zed.Glossary.Persistence.Propel.GlossaryKey';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 3;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 3;

    /**
     * the column name for the id_glossary_key field
     */
    const COL_ID_GLOSSARY_KEY = 'spy_glossary_key.id_glossary_key';

    /**
     * the column name for the key field
     */
    const COL_KEY = 'spy_glossary_key.key';

    /**
     * the column name for the is_active field
     */
    const COL_IS_ACTIVE = 'spy_glossary_key.is_active';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('IdGlossaryKey', 'Key', 'IsActive', ),
        self::TYPE_CAMELNAME     => array('idGlossaryKey', 'key', 'isActive', ),
        self::TYPE_COLNAME       => array(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, GlossaryKeyTableMap::COL_KEY, GlossaryKeyTableMap::COL_IS_ACTIVE, ),
        self::TYPE_FIELDNAME     => array('id_glossary_key', 'key', 'is_active', ),
        self::TYPE_NUM           => array(0, 1, 2, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdGlossaryKey' => 0, 'Key' => 1, 'IsActive' => 2, ),
        self::TYPE_CAMELNAME     => array('idGlossaryKey' => 0, 'key' => 1, 'isActive' => 2, ),
        self::TYPE_COLNAME       => array(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY => 0, GlossaryKeyTableMap::COL_KEY => 1, GlossaryKeyTableMap::COL_IS_ACTIVE => 2, ),
        self::TYPE_FIELDNAME     => array('id_glossary_key' => 0, 'key' => 1, 'is_active' => 2, ),
        self::TYPE_NUM           => array(0, 1, 2, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('spy_glossary_key');
        $this->setPhpName('GlossaryKey');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryKey');
        $this->setPackage('vendor.spryker.zed-package.src.SprykerFeature.Zed.Glossary.Persistence.Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_glossary_key', 'IdGlossaryKey', 'INTEGER', true, null, null);
        $this->addColumn('key', 'Key', 'VARCHAR', true, 255, null);
        $this->addColumn('is_active', 'IsActive', 'BOOLEAN', true, 1, true);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SprykerFeatureGlossaryKeyMapping', '\\SprykerFeature\\Zed\\Cms\\Persistence\\Propel\\SprykerFeatureGlossaryKeyMapping', RelationMap::ONE_TO_MANY, array('id_glossary_key' => 'fk_glossary_key', ), 'CASCADE', null, 'SprykerFeatureGlossaryKeyMappings');
        $this->addRelation('GlossaryTranslation', '\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryTranslation', RelationMap::ONE_TO_MANY, array('id_glossary_key' => 'fk_glossary_key', ), 'CASCADE', null, 'GlossaryTranslations');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to spy_glossary_key     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SprykerFeatureGlossaryKeyMappingTableMap::clearInstancePool();
        GlossaryTranslationTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdGlossaryKey', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdGlossaryKey', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IdGlossaryKey', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? GlossaryKeyTableMap::CLASS_DEFAULT : GlossaryKeyTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (GlossaryKey object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GlossaryKeyTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GlossaryKeyTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GlossaryKeyTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GlossaryKeyTableMap::OM_CLASS;
            /** @var GlossaryKey $obj */

                /* @var $locator \Generated\Zed\Ide\AutoCompletion */
                $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
                $obj = $locator->glossary()->entityGlossaryKey();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GlossaryKeyTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = GlossaryKeyTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GlossaryKeyTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var GlossaryKey $obj */

                /* @var $locator \Generated\Zed\Ide\AutoCompletion */
                $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
                $obj = $locator->glossary()->entityGlossaryKey();
                $obj->hydrate($row);
                $results[] = $obj;
                GlossaryKeyTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY);
            $criteria->addSelectColumn(GlossaryKeyTableMap::COL_KEY);
            $criteria->addSelectColumn(GlossaryKeyTableMap::COL_IS_ACTIVE);
        } else {
            $criteria->addSelectColumn($alias . '.id_glossary_key');
            $criteria->addSelectColumn($alias . '.key');
            $criteria->addSelectColumn($alias . '.is_active');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(GlossaryKeyTableMap::DATABASE_NAME)->getTable(GlossaryKeyTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(GlossaryKeyTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(GlossaryKeyTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new GlossaryKeyTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a GlossaryKey or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or GlossaryKey object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GlossaryKeyTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryKey) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GlossaryKeyTableMap::DATABASE_NAME);
            $criteria->add(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY, (array) $values, Criteria::IN);
        }

        $query = GlossaryKeyQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GlossaryKeyTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GlossaryKeyTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the spy_glossary_key table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GlossaryKeyQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a GlossaryKey or Criteria object.
     *
     * @param mixed               $criteria Criteria or GlossaryKey object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GlossaryKeyTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from GlossaryKey object
        }

        if ($criteria->containsKey(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY) && $criteria->keyContainsValue(GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GlossaryKeyTableMap::COL_ID_GLOSSARY_KEY.')');
        }


        // Set the correct dbName
        $query = GlossaryKeyQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GlossaryKeyTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
GlossaryKeyTableMap::buildTableMap();
