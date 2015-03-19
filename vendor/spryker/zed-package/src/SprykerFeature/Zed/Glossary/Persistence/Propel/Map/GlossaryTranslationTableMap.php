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
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery;


/**
 * This class defines the structure of the 'spy_glossary_translation' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class GlossaryTranslationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'vendor.spryker.zed-package.src.SprykerFeature.Zed.Glossary.Persistence.Propel.Map.GlossaryTranslationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'zed';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'spy_glossary_translation';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryTranslation';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'vendor.spryker.zed-package.src.SprykerFeature.Zed.Glossary.Persistence.Propel.GlossaryTranslation';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id_glossary_translation field
     */
    const COL_ID_GLOSSARY_TRANSLATION = 'spy_glossary_translation.id_glossary_translation';

    /**
     * the column name for the fk_glossary_key field
     */
    const COL_FK_GLOSSARY_KEY = 'spy_glossary_translation.fk_glossary_key';

    /**
     * the column name for the fk_locale field
     */
    const COL_FK_LOCALE = 'spy_glossary_translation.fk_locale';

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'spy_glossary_translation.value';

    /**
     * the column name for the is_active field
     */
    const COL_IS_ACTIVE = 'spy_glossary_translation.is_active';

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
        self::TYPE_PHPNAME       => array('IdGlossaryTranslation', 'FkGlossaryKey', 'FkLocale', 'Value', 'IsActive', ),
        self::TYPE_CAMELNAME     => array('idGlossaryTranslation', 'fkGlossaryKey', 'fkLocale', 'value', 'isActive', ),
        self::TYPE_COLNAME       => array(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION, GlossaryTranslationTableMap::COL_FK_GLOSSARY_KEY, GlossaryTranslationTableMap::COL_FK_LOCALE, GlossaryTranslationTableMap::COL_VALUE, GlossaryTranslationTableMap::COL_IS_ACTIVE, ),
        self::TYPE_FIELDNAME     => array('id_glossary_translation', 'fk_glossary_key', 'fk_locale', 'value', 'is_active', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdGlossaryTranslation' => 0, 'FkGlossaryKey' => 1, 'FkLocale' => 2, 'Value' => 3, 'IsActive' => 4, ),
        self::TYPE_CAMELNAME     => array('idGlossaryTranslation' => 0, 'fkGlossaryKey' => 1, 'fkLocale' => 2, 'value' => 3, 'isActive' => 4, ),
        self::TYPE_COLNAME       => array(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION => 0, GlossaryTranslationTableMap::COL_FK_GLOSSARY_KEY => 1, GlossaryTranslationTableMap::COL_FK_LOCALE => 2, GlossaryTranslationTableMap::COL_VALUE => 3, GlossaryTranslationTableMap::COL_IS_ACTIVE => 4, ),
        self::TYPE_FIELDNAME     => array('id_glossary_translation' => 0, 'fk_glossary_key' => 1, 'fk_locale' => 2, 'value' => 3, 'is_active' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('spy_glossary_translation');
        $this->setPhpName('GlossaryTranslation');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryTranslation');
        $this->setPackage('vendor.spryker.zed-package.src.SprykerFeature.Zed.Glossary.Persistence.Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_glossary_translation', 'IdGlossaryTranslation', 'INTEGER', true, null, null);
        $this->addForeignKey('fk_glossary_key', 'FkGlossaryKey', 'INTEGER', 'spy_glossary_key', 'id_glossary_key', true, null, null);
        $this->addForeignKey('fk_locale', 'FkLocale', 'INTEGER', 'pac_locale', 'id_locale', true, null, null);
        $this->addColumn('value', 'Value', 'LONGVARCHAR', true, null, null);
        $this->addColumn('is_active', 'IsActive', 'BOOLEAN', true, 1, true);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('GlossaryKey', '\\SprykerFeature\\Zed\\Glossary\\Persistence\\Propel\\GlossaryKey', RelationMap::MANY_TO_ONE, array('fk_glossary_key' => 'id_glossary_key', ), 'CASCADE', null);
        $this->addRelation('GlossaryLocale', '\\SprykerCore\\Zed\\Locale\\Persistence\\Propel\\PacLocale', RelationMap::MANY_TO_ONE, array('fk_locale' => 'id_locale', ), 'CASCADE', null);
    } // buildRelations()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdGlossaryTranslation', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdGlossaryTranslation', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IdGlossaryTranslation', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? GlossaryTranslationTableMap::CLASS_DEFAULT : GlossaryTranslationTableMap::OM_CLASS;
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
     * @return array           (GlossaryTranslation object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GlossaryTranslationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GlossaryTranslationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GlossaryTranslationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GlossaryTranslationTableMap::OM_CLASS;
            /** @var GlossaryTranslation $obj */

                /* @var $locator \Generated\Zed\Ide\AutoCompletion */
                $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
                $obj = $locator->glossary()->entityGlossaryTranslation();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GlossaryTranslationTableMap::addInstanceToPool($obj, $key);
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
            $key = GlossaryTranslationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GlossaryTranslationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var GlossaryTranslation $obj */

                /* @var $locator \Generated\Zed\Ide\AutoCompletion */
                $locator = \ProjectA\Zed\Kernel\Locator::getInstance();
                $obj = $locator->glossary()->entityGlossaryTranslation();
                $obj->hydrate($row);
                $results[] = $obj;
                GlossaryTranslationTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION);
            $criteria->addSelectColumn(GlossaryTranslationTableMap::COL_FK_GLOSSARY_KEY);
            $criteria->addSelectColumn(GlossaryTranslationTableMap::COL_FK_LOCALE);
            $criteria->addSelectColumn(GlossaryTranslationTableMap::COL_VALUE);
            $criteria->addSelectColumn(GlossaryTranslationTableMap::COL_IS_ACTIVE);
        } else {
            $criteria->addSelectColumn($alias . '.id_glossary_translation');
            $criteria->addSelectColumn($alias . '.fk_glossary_key');
            $criteria->addSelectColumn($alias . '.fk_locale');
            $criteria->addSelectColumn($alias . '.value');
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
        return Propel::getServiceContainer()->getDatabaseMap(GlossaryTranslationTableMap::DATABASE_NAME)->getTable(GlossaryTranslationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(GlossaryTranslationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(GlossaryTranslationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new GlossaryTranslationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a GlossaryTranslation or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or GlossaryTranslation object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GlossaryTranslationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GlossaryTranslationTableMap::DATABASE_NAME);
            $criteria->add(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION, (array) $values, Criteria::IN);
        }

        $query = GlossaryTranslationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GlossaryTranslationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GlossaryTranslationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the spy_glossary_translation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GlossaryTranslationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a GlossaryTranslation or Criteria object.
     *
     * @param mixed               $criteria Criteria or GlossaryTranslation object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GlossaryTranslationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from GlossaryTranslation object
        }

        if ($criteria->containsKey(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION) && $criteria->keyContainsValue(GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GlossaryTranslationTableMap::COL_ID_GLOSSARY_TRANSLATION.')');
        }


        // Set the correct dbName
        $query = GlossaryTranslationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GlossaryTranslationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
GlossaryTranslationTableMap::buildTableMap();
