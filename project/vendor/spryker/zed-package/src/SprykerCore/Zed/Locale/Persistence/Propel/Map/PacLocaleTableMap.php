<?php

namespace SprykerCore\Zed\Locale\Persistence\Propel\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocale;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery;
use SprykerCore\Zed\Url\Persistence\Propel\Map\SprykerCoreUrlTableMap;
use SprykerFeature\Zed\Glossary\Persistence\Propel\Map\GlossaryTranslationTableMap;


/**
 * This class defines the structure of the 'pac_locale' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PacLocaleTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'vendor.spryker.zed-package.src.SprykerCore.Zed.Locale.Persistence.Propel.Map.PacLocaleTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'zed';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'pac_locale';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SprykerCore\\Zed\\Locale\\Persistence\\Propel\\PacLocale';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'vendor.spryker.zed-package.src.SprykerCore.Zed.Locale.Persistence.Propel.PacLocale';

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
     * the column name for the id_locale field
     */
    const COL_ID_LOCALE = 'pac_locale.id_locale';

    /**
     * the column name for the locale_name field
     */
    const COL_LOCALE_NAME = 'pac_locale.locale_name';

    /**
     * the column name for the is_active field
     */
    const COL_IS_ACTIVE = 'pac_locale.is_active';

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
        self::TYPE_PHPNAME       => array('IdLocale', 'LocaleName', 'IsActive', ),
        self::TYPE_CAMELNAME     => array('idLocale', 'localeName', 'isActive', ),
        self::TYPE_COLNAME       => array(PacLocaleTableMap::COL_ID_LOCALE, PacLocaleTableMap::COL_LOCALE_NAME, PacLocaleTableMap::COL_IS_ACTIVE, ),
        self::TYPE_FIELDNAME     => array('id_locale', 'locale_name', 'is_active', ),
        self::TYPE_NUM           => array(0, 1, 2, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdLocale' => 0, 'LocaleName' => 1, 'IsActive' => 2, ),
        self::TYPE_CAMELNAME     => array('idLocale' => 0, 'localeName' => 1, 'isActive' => 2, ),
        self::TYPE_COLNAME       => array(PacLocaleTableMap::COL_ID_LOCALE => 0, PacLocaleTableMap::COL_LOCALE_NAME => 1, PacLocaleTableMap::COL_IS_ACTIVE => 2, ),
        self::TYPE_FIELDNAME     => array('id_locale' => 0, 'locale_name' => 1, 'is_active' => 2, ),
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
        $this->setName('pac_locale');
        $this->setPhpName('PacLocale');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\SprykerCore\\Zed\\Locale\\Persistence\\Propel\\PacLocale');
        $this->setPackage('vendor.spryker.zed-package.src.SprykerCore.Zed.Locale.Persistence.Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_locale', 'IdLocale', 'INTEGER', true, null, null);
        $this->addColumn('locale_name', 'LocaleName', 'VARCHAR', true, 5, null);
        $this->addColumn('is_active', 'IsActive', 'BOOLEAN', true, 1, true);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('PacCategoryAttribute', '\\ProjectA\\Zed\\Category\\Persistence\\Propel\\PacCategoryAttribute', RelationMap::ONE_TO_MANY, array('id_locale' => 'locale_id', ), null, null, 'PacCategoryAttributes');
        $this->addRelation('PacLocalizedAbstractProductAttributes', '\\ProjectA\\Zed\\Product\\Persistence\\Propel\\PacLocalizedAbstractProductAttributes', RelationMap::ONE_TO_MANY, array('id_locale' => 'locale_id', ), null, null, 'PacLocalizedAbstractProductAttributess');
        $this->addRelation('PacLocalizedProductAttributes', '\\ProjectA\\Zed\\Product\\Persistence\\Propel\\PacLocalizedProductAttributes', RelationMap::ONE_TO_MANY, array('id_locale' => 'locale_id', ), null, null, 'PacLocalizedProductAttributess');
        $this->addRelation('PacTax', '\\ProjectA\\Zed\\Product\\Persistence\\Propel\\PacTax', RelationMap::ONE_TO_MANY, array('id_locale' => 'locale_id', ), null, null, 'PacTaxes');
        $this->addRelation('PacTypeValue', '\\ProjectA\\Zed\\Product\\Persistence\\Propel\\PacTypeValue', RelationMap::ONE_TO_MANY, array('id_locale' => 'locale_id', ), null, null, 'PacTypeValues');
        $this->addRelation('PacSearchableProducts', '\\ProjectA\\Zed\\ProductSearch\\Persistence\\Propel\\PacSearchableProducts', RelationMap::ONE_TO_MANY, array('id_locale' => 'fk_locale', ), null, null, 'PacSearchableProductss');
        $this->addRelation('SprykerCoreUrl', '\\SprykerCore\\Zed\\Url\\Persistence\\Propel\\SprykerCoreUrl', RelationMap::ONE_TO_MANY, array('id_locale' => 'fk_locale', ), 'CASCADE', null, 'SprykerCoreUrls');
        $this->addRelation('GlossaryTranslation', '\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryTranslation', RelationMap::ONE_TO_MANY, array('id_locale' => 'fk_locale', ), 'CASCADE', null, 'GlossaryTranslations');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to pac_locale     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SprykerCoreUrlTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdLocale', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdLocale', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdLocale', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PacLocaleTableMap::CLASS_DEFAULT : PacLocaleTableMap::OM_CLASS;
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
     * @return array           (PacLocale object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PacLocaleTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PacLocaleTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PacLocaleTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PacLocaleTableMap::OM_CLASS;
            /** @var PacLocale $obj */

                /* @var $locator \Generated\Zed\Ide\AutoCompletion */
                $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
                $obj = $locator->locale()->entityPacLocale();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PacLocaleTableMap::addInstanceToPool($obj, $key);
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
            $key = PacLocaleTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PacLocaleTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PacLocale $obj */

                /* @var $locator \Generated\Zed\Ide\AutoCompletion */
                $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
                $obj = $locator->locale()->entityPacLocale();
                $obj->hydrate($row);
                $results[] = $obj;
                PacLocaleTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PacLocaleTableMap::COL_ID_LOCALE);
            $criteria->addSelectColumn(PacLocaleTableMap::COL_LOCALE_NAME);
            $criteria->addSelectColumn(PacLocaleTableMap::COL_IS_ACTIVE);
        } else {
            $criteria->addSelectColumn($alias . '.id_locale');
            $criteria->addSelectColumn($alias . '.locale_name');
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
        return Propel::getServiceContainer()->getDatabaseMap(PacLocaleTableMap::DATABASE_NAME)->getTable(PacLocaleTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PacLocaleTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PacLocaleTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PacLocaleTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PacLocale or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PacLocale object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PacLocaleTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SprykerCore\Zed\Locale\Persistence\Propel\PacLocale) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PacLocaleTableMap::DATABASE_NAME);
            $criteria->add(PacLocaleTableMap::COL_ID_LOCALE, (array) $values, Criteria::IN);
        }

        $query = PacLocaleQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PacLocaleTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PacLocaleTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the pac_locale table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PacLocaleQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PacLocale or Criteria object.
     *
     * @param mixed               $criteria Criteria or PacLocale object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PacLocaleTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PacLocale object
        }

        if ($criteria->containsKey(PacLocaleTableMap::COL_ID_LOCALE) && $criteria->keyContainsValue(PacLocaleTableMap::COL_ID_LOCALE) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PacLocaleTableMap::COL_ID_LOCALE.')');
        }


        // Set the correct dbName
        $query = PacLocaleQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PacLocaleTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PacLocaleTableMap::buildTableMap();
