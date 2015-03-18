<?php

namespace SprykerCore\Zed\Locale\Persistence\Propel\Base;

use \Exception;
use \PDO;
use ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttribute;
use ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttributeQuery;
use ProjectA\Zed\Category\Persistence\Propel\Base\PacCategoryAttribute as BasePacCategoryAttribute;
use ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProducts;
use ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProductsQuery;
use ProjectA\Zed\ProductSearch\Persistence\Propel\Base\PacSearchableProducts as BasePacSearchableProducts;
use ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributes;
use ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributesQuery;
use ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributes;
use ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributesQuery;
use ProjectA\Zed\Product\Persistence\Propel\PacTax;
use ProjectA\Zed\Product\Persistence\Propel\PacTaxQuery;
use ProjectA\Zed\Product\Persistence\Propel\PacTypeValue;
use ProjectA\Zed\Product\Persistence\Propel\PacTypeValueQuery;
use ProjectA\Zed\Product\Persistence\Propel\Base\PacLocalizedAbstractProductAttributes as BasePacLocalizedAbstractProductAttributes;
use ProjectA\Zed\Product\Persistence\Propel\Base\PacLocalizedProductAttributes as BasePacLocalizedProductAttributes;
use ProjectA\Zed\Product\Persistence\Propel\Base\PacTax as BasePacTax;
use ProjectA\Zed\Product\Persistence\Propel\Base\PacTypeValue as BasePacTypeValue;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocale as ChildPacLocale;
use SprykerCore\Zed\Locale\Persistence\Propel\PacLocaleQuery as ChildPacLocaleQuery;
use SprykerCore\Zed\Locale\Persistence\Propel\Map\PacLocaleTableMap;
use SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrl;
use SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrlQuery;
use SprykerCore\Zed\Url\Persistence\Propel\Base\SprykerCoreUrl as BaseSprykerCoreUrl;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation;
use SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery;
use SprykerFeature\Zed\Glossary\Persistence\Propel\Base\GlossaryTranslation as BaseGlossaryTranslation;

/**
 * Base class that represents a row from the 'pac_locale' table.
 *
 *
 *
* @package    propel.generator.vendor.spryker.zed-package.src.SprykerCore.Zed.Locale.Persistence.Propel.Base
*/
abstract class PacLocale implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\SprykerCore\\Zed\\Locale\\Persistence\\Propel\\Map\\PacLocaleTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id_locale field.
     * @var        int
     */
    protected $id_locale;

    /**
     * The value for the locale_name field.
     * @var        string
     */
    protected $locale_name;

    /**
     * The value for the is_active field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $is_active;

    /**
     * @var        ObjectCollection|PacCategoryAttribute[] Collection to store aggregation of PacCategoryAttribute objects.
     */
    protected $collPacCategoryAttributes;
    protected $collPacCategoryAttributesPartial;

    /**
     * @var        ObjectCollection|PacLocalizedAbstractProductAttributes[] Collection to store aggregation of PacLocalizedAbstractProductAttributes objects.
     */
    protected $collPacLocalizedAbstractProductAttributess;
    protected $collPacLocalizedAbstractProductAttributessPartial;

    /**
     * @var        ObjectCollection|PacLocalizedProductAttributes[] Collection to store aggregation of PacLocalizedProductAttributes objects.
     */
    protected $collPacLocalizedProductAttributess;
    protected $collPacLocalizedProductAttributessPartial;

    /**
     * @var        ObjectCollection|PacTax[] Collection to store aggregation of PacTax objects.
     */
    protected $collPacTaxes;
    protected $collPacTaxesPartial;

    /**
     * @var        ObjectCollection|PacTypeValue[] Collection to store aggregation of PacTypeValue objects.
     */
    protected $collPacTypeValues;
    protected $collPacTypeValuesPartial;

    /**
     * @var        ObjectCollection|PacSearchableProducts[] Collection to store aggregation of PacSearchableProducts objects.
     */
    protected $collPacSearchableProductss;
    protected $collPacSearchableProductssPartial;

    /**
     * @var        ObjectCollection|SprykerCoreUrl[] Collection to store aggregation of SprykerCoreUrl objects.
     */
    protected $collSprykerCoreUrls;
    protected $collSprykerCoreUrlsPartial;

    /**
     * @var        ObjectCollection|GlossaryTranslation[] Collection to store aggregation of GlossaryTranslation objects.
     */
    protected $collGlossaryTranslations;
    protected $collGlossaryTranslationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|PacCategoryAttribute[]
     */
    protected $pacCategoryAttributesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|PacLocalizedAbstractProductAttributes[]
     */
    protected $pacLocalizedAbstractProductAttributessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|PacLocalizedProductAttributes[]
     */
    protected $pacLocalizedProductAttributessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|PacTax[]
     */
    protected $pacTaxesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|PacTypeValue[]
     */
    protected $pacTypeValuesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|PacSearchableProducts[]
     */
    protected $pacSearchableProductssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|SprykerCoreUrl[]
     */
    protected $sprykerCoreUrlsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|GlossaryTranslation[]
     */
    protected $glossaryTranslationsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_active = true;
    }

    /**
     * Initializes internal state of SprykerCore\Zed\Locale\Persistence\Propel\Base\PacLocale object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>PacLocale</code> instance.  If
     * <code>obj</code> is an instance of <code>PacLocale</code>, delegates to
     * <code>equals(PacLocale)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|PacLocale The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id_locale] column value.
     *
     * @return int
     */
    public function getIdLocale()
    {
        return $this->id_locale;
    }

    /**
     * Get the [locale_name] column value.
     *
     * @return string
     */
    public function getLocaleName()
    {
        return $this->locale_name;
    }

    /**
     * Get the [is_active] column value.
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Get the [is_active] column value.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->getIsActive();
    }

    /**
     * Set the value of [id_locale] column.
     *
     * @param  int $v new value
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function setIdLocale($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_locale !== $v) {
            $this->id_locale = $v;
            $this->modifiedColumns[PacLocaleTableMap::COL_ID_LOCALE] = true;
        }

        return $this;
    } // setIdLocale()

    /**
     * Set the value of [locale_name] column.
     *
     * @param  string $v new value
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function setLocaleName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->locale_name !== $v) {
            $this->locale_name = $v;
            $this->modifiedColumns[PacLocaleTableMap::COL_LOCALE_NAME] = true;
        }

        return $this;
    } // setLocaleName()

    /**
     * Sets the value of the [is_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function setIsActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_active !== $v) {
            $this->is_active = $v;
            $this->modifiedColumns[PacLocaleTableMap::COL_IS_ACTIVE] = true;
        }

        return $this;
    } // setIsActive()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->is_active !== true) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PacLocaleTableMap::translateFieldName('IdLocale', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_locale = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PacLocaleTableMap::translateFieldName('LocaleName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locale_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PacLocaleTableMap::translateFieldName('IsActive', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_active = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = PacLocaleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SprykerCore\\Zed\\Locale\\Persistence\\Propel\\PacLocale'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PacLocaleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPacLocaleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collPacCategoryAttributes = null;

            $this->collPacLocalizedAbstractProductAttributess = null;

            $this->collPacLocalizedProductAttributess = null;

            $this->collPacTaxes = null;

            $this->collPacTypeValues = null;

            $this->collPacSearchableProductss = null;

            $this->collSprykerCoreUrls = null;

            $this->collGlossaryTranslations = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see PacLocale::setDeleted()
     * @see PacLocale::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PacLocaleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPacLocaleQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PacLocaleTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PacLocaleTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->pacCategoryAttributesScheduledForDeletion !== null) {
                if (!$this->pacCategoryAttributesScheduledForDeletion->isEmpty()) {
                    \ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttributeQuery::create()
                        ->filterByPrimaryKeys($this->pacCategoryAttributesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pacCategoryAttributesScheduledForDeletion = null;
                }
            }

            if ($this->collPacCategoryAttributes !== null) {
                foreach ($this->collPacCategoryAttributes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pacLocalizedAbstractProductAttributessScheduledForDeletion !== null) {
                if (!$this->pacLocalizedAbstractProductAttributessScheduledForDeletion->isEmpty()) {
                    \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributesQuery::create()
                        ->filterByPrimaryKeys($this->pacLocalizedAbstractProductAttributessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pacLocalizedAbstractProductAttributessScheduledForDeletion = null;
                }
            }

            if ($this->collPacLocalizedAbstractProductAttributess !== null) {
                foreach ($this->collPacLocalizedAbstractProductAttributess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pacLocalizedProductAttributessScheduledForDeletion !== null) {
                if (!$this->pacLocalizedProductAttributessScheduledForDeletion->isEmpty()) {
                    \ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributesQuery::create()
                        ->filterByPrimaryKeys($this->pacLocalizedProductAttributessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pacLocalizedProductAttributessScheduledForDeletion = null;
                }
            }

            if ($this->collPacLocalizedProductAttributess !== null) {
                foreach ($this->collPacLocalizedProductAttributess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pacTaxesScheduledForDeletion !== null) {
                if (!$this->pacTaxesScheduledForDeletion->isEmpty()) {
                    \ProjectA\Zed\Product\Persistence\Propel\PacTaxQuery::create()
                        ->filterByPrimaryKeys($this->pacTaxesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pacTaxesScheduledForDeletion = null;
                }
            }

            if ($this->collPacTaxes !== null) {
                foreach ($this->collPacTaxes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pacTypeValuesScheduledForDeletion !== null) {
                if (!$this->pacTypeValuesScheduledForDeletion->isEmpty()) {
                    foreach ($this->pacTypeValuesScheduledForDeletion as $pacTypeValue) {
                        // need to save related object because we set the relation to null
                        $pacTypeValue->save($con);
                    }
                    $this->pacTypeValuesScheduledForDeletion = null;
                }
            }

            if ($this->collPacTypeValues !== null) {
                foreach ($this->collPacTypeValues as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pacSearchableProductssScheduledForDeletion !== null) {
                if (!$this->pacSearchableProductssScheduledForDeletion->isEmpty()) {
                    foreach ($this->pacSearchableProductssScheduledForDeletion as $pacSearchableProducts) {
                        // need to save related object because we set the relation to null
                        $pacSearchableProducts->save($con);
                    }
                    $this->pacSearchableProductssScheduledForDeletion = null;
                }
            }

            if ($this->collPacSearchableProductss !== null) {
                foreach ($this->collPacSearchableProductss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sprykerCoreUrlsScheduledForDeletion !== null) {
                if (!$this->sprykerCoreUrlsScheduledForDeletion->isEmpty()) {
                    \SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrlQuery::create()
                        ->filterByPrimaryKeys($this->sprykerCoreUrlsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sprykerCoreUrlsScheduledForDeletion = null;
                }
            }

            if ($this->collSprykerCoreUrls !== null) {
                foreach ($this->collSprykerCoreUrls as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->glossaryTranslationsScheduledForDeletion !== null) {
                if (!$this->glossaryTranslationsScheduledForDeletion->isEmpty()) {
                    \SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslationQuery::create()
                        ->filterByPrimaryKeys($this->glossaryTranslationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->glossaryTranslationsScheduledForDeletion = null;
                }
            }

            if ($this->collGlossaryTranslations !== null) {
                foreach ($this->collGlossaryTranslations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PacLocaleTableMap::COL_ID_LOCALE] = true;
        if (null !== $this->id_locale) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PacLocaleTableMap::COL_ID_LOCALE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PacLocaleTableMap::COL_ID_LOCALE)) {
            $modifiedColumns[':p' . $index++]  = 'id_locale';
        }
        if ($this->isColumnModified(PacLocaleTableMap::COL_LOCALE_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'locale_name';
        }
        if ($this->isColumnModified(PacLocaleTableMap::COL_IS_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'is_active';
        }

        $sql = sprintf(
            'INSERT INTO pac_locale (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_locale':
                        $stmt->bindValue($identifier, $this->id_locale, PDO::PARAM_INT);
                        break;
                    case 'locale_name':
                        $stmt->bindValue($identifier, $this->locale_name, PDO::PARAM_STR);
                        break;
                    case 'is_active':
                        $stmt->bindValue($identifier, (int) $this->is_active, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setIdLocale($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_FIELDNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_FIELDNAME)
    {
        $pos = PacLocaleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdLocale();
                break;
            case 1:
                return $this->getLocaleName();
                break;
            case 2:
                return $this->getIsActive();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_FIELDNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_FIELDNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['PacLocale'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PacLocale'][$this->hashCode()] = true;
        $keys = PacLocaleTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdLocale(),
            $keys[1] => $this->getLocaleName(),
            $keys[2] => $this->getIsActive(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collPacCategoryAttributes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pacCategoryAttributes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pac_category_attributes';
                        break;
                    default:
                        $key = 'PacCategoryAttributes';
                }

                $result[$key] = $this->collPacCategoryAttributes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPacLocalizedAbstractProductAttributess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pacLocalizedAbstractProductAttributess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pac_abstract_product_localized_attributess';
                        break;
                    default:
                        $key = 'PacLocalizedAbstractProductAttributess';
                }

                $result[$key] = $this->collPacLocalizedAbstractProductAttributess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPacLocalizedProductAttributess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pacLocalizedProductAttributess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pac_product_localized_attributess';
                        break;
                    default:
                        $key = 'PacLocalizedProductAttributess';
                }

                $result[$key] = $this->collPacLocalizedProductAttributess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPacTaxes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pacTaxes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pac_taxes';
                        break;
                    default:
                        $key = 'PacTaxes';
                }

                $result[$key] = $this->collPacTaxes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPacTypeValues) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pacTypeValues';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pac_attribute_type_values';
                        break;
                    default:
                        $key = 'PacTypeValues';
                }

                $result[$key] = $this->collPacTypeValues->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPacSearchableProductss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pacSearchableProductss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pac_searchable_productss';
                        break;
                    default:
                        $key = 'PacSearchableProductss';
                }

                $result[$key] = $this->collPacSearchableProductss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSprykerCoreUrls) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sprykerCoreUrls';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sprykercore_urls';
                        break;
                    default:
                        $key = 'SprykerCoreUrls';
                }

                $result[$key] = $this->collSprykerCoreUrls->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGlossaryTranslations) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'glossaryTranslations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'spy_glossary_translations';
                        break;
                    default:
                        $key = 'GlossaryTranslations';
                }

                $result[$key] = $this->collGlossaryTranslations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_FIELDNAME.
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale
     */
    public function setByName($name, $value, $type = TableMap::TYPE_FIELDNAME)
    {
        $pos = PacLocaleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdLocale($value);
                break;
            case 1:
                $this->setLocaleName($value);
                break;
            case 2:
                $this->setIsActive($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_FIELDNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_FIELDNAME)
    {
        $keys = PacLocaleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdLocale($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLocaleName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIsActive($arr[$keys[2]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_FIELDNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_FIELDNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PacLocaleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PacLocaleTableMap::COL_ID_LOCALE)) {
            $criteria->add(PacLocaleTableMap::COL_ID_LOCALE, $this->id_locale);
        }
        if ($this->isColumnModified(PacLocaleTableMap::COL_LOCALE_NAME)) {
            $criteria->add(PacLocaleTableMap::COL_LOCALE_NAME, $this->locale_name);
        }
        if ($this->isColumnModified(PacLocaleTableMap::COL_IS_ACTIVE)) {
            $criteria->add(PacLocaleTableMap::COL_IS_ACTIVE, $this->is_active);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPacLocaleQuery::create();
        $criteria->add(PacLocaleTableMap::COL_ID_LOCALE, $this->id_locale);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getIdLocale();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getIdLocale();
    }

    /**
     * Generic method to set the primary key (id_locale column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdLocale($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdLocale();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \SprykerCore\Zed\Locale\Persistence\Propel\PacLocale (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLocaleName($this->getLocaleName());
        $copyObj->setIsActive($this->getIsActive());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPacCategoryAttributes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPacCategoryAttribute($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPacLocalizedAbstractProductAttributess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPacLocalizedAbstractProductAttributes($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPacLocalizedProductAttributess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPacLocalizedProductAttributes($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPacTaxes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPacTax($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPacTypeValues() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPacTypeValue($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPacSearchableProductss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPacSearchableProducts($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSprykerCoreUrls() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSprykerCoreUrl($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGlossaryTranslations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGlossaryTranslation($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdLocale(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \SprykerCore\Zed\Locale\Persistence\Propel\PacLocale Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('PacCategoryAttribute' == $relationName) {
            return $this->initPacCategoryAttributes();
        }
        if ('PacLocalizedAbstractProductAttributes' == $relationName) {
            return $this->initPacLocalizedAbstractProductAttributess();
        }
        if ('PacLocalizedProductAttributes' == $relationName) {
            return $this->initPacLocalizedProductAttributess();
        }
        if ('PacTax' == $relationName) {
            return $this->initPacTaxes();
        }
        if ('PacTypeValue' == $relationName) {
            return $this->initPacTypeValues();
        }
        if ('PacSearchableProducts' == $relationName) {
            return $this->initPacSearchableProductss();
        }
        if ('SprykerCoreUrl' == $relationName) {
            return $this->initSprykerCoreUrls();
        }
        if ('GlossaryTranslation' == $relationName) {
            return $this->initGlossaryTranslations();
        }
    }

    /**
     * Clears out the collPacCategoryAttributes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPacCategoryAttributes()
     */
    public function clearPacCategoryAttributes()
    {
        $this->collPacCategoryAttributes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPacCategoryAttributes collection loaded partially.
     */
    public function resetPartialPacCategoryAttributes($v = true)
    {
        $this->collPacCategoryAttributesPartial = $v;
    }

    /**
     * Initializes the collPacCategoryAttributes collection.
     *
     * By default this just sets the collPacCategoryAttributes collection to an empty array (like clearcollPacCategoryAttributes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPacCategoryAttributes($overrideExisting = true)
    {
        if (null !== $this->collPacCategoryAttributes && !$overrideExisting) {
            return;
        }
        $this->collPacCategoryAttributes = new ObjectCollection();
        $this->collPacCategoryAttributes->setModel('\ProjectA\Zed\Category\Persistence\Propel\PacCategoryAttribute');
    }

    /**
     * Gets an array of PacCategoryAttribute objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPacLocale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|PacCategoryAttribute[] List of PacCategoryAttribute objects
     * @throws PropelException
     */
    public function getPacCategoryAttributes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPacCategoryAttributesPartial && !$this->isNew();
        if (null === $this->collPacCategoryAttributes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPacCategoryAttributes) {
                // return empty collection
                $this->initPacCategoryAttributes();
            } else {
                $collPacCategoryAttributes = PacCategoryAttributeQuery::create(null, $criteria)
                    ->filterByLocale($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPacCategoryAttributesPartial && count($collPacCategoryAttributes)) {
                        $this->initPacCategoryAttributes(false);

                        foreach ($collPacCategoryAttributes as $obj) {
                            if (false == $this->collPacCategoryAttributes->contains($obj)) {
                                $this->collPacCategoryAttributes->append($obj);
                            }
                        }

                        $this->collPacCategoryAttributesPartial = true;
                    }

                    return $collPacCategoryAttributes;
                }

                if ($partial && $this->collPacCategoryAttributes) {
                    foreach ($this->collPacCategoryAttributes as $obj) {
                        if ($obj->isNew()) {
                            $collPacCategoryAttributes[] = $obj;
                        }
                    }
                }

                $this->collPacCategoryAttributes = $collPacCategoryAttributes;
                $this->collPacCategoryAttributesPartial = false;
            }
        }

        return $this->collPacCategoryAttributes;
    }

    /**
     * Sets a collection of PacCategoryAttribute objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pacCategoryAttributes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function setPacCategoryAttributes(Collection $pacCategoryAttributes, ConnectionInterface $con = null)
    {
        /** @var PacCategoryAttribute[] $pacCategoryAttributesToDelete */
        $pacCategoryAttributesToDelete = $this->getPacCategoryAttributes(new Criteria(), $con)->diff($pacCategoryAttributes);


        $this->pacCategoryAttributesScheduledForDeletion = $pacCategoryAttributesToDelete;

        foreach ($pacCategoryAttributesToDelete as $pacCategoryAttributeRemoved) {
            $pacCategoryAttributeRemoved->setLocale(null);
        }

        $this->collPacCategoryAttributes = null;
        foreach ($pacCategoryAttributes as $pacCategoryAttribute) {
            $this->addPacCategoryAttribute($pacCategoryAttribute);
        }

        $this->collPacCategoryAttributes = $pacCategoryAttributes;
        $this->collPacCategoryAttributesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BasePacCategoryAttribute objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BasePacCategoryAttribute objects.
     * @throws PropelException
     */
    public function countPacCategoryAttributes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPacCategoryAttributesPartial && !$this->isNew();
        if (null === $this->collPacCategoryAttributes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPacCategoryAttributes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPacCategoryAttributes());
            }

            $query = PacCategoryAttributeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocale($this)
                ->count($con);
        }

        return count($this->collPacCategoryAttributes);
    }

    /**
     * Method called to associate a PacCategoryAttribute object to this object
     * through the PacCategoryAttribute foreign key attribute.
     *
     * @param  PacCategoryAttribute $l PacCategoryAttribute
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function addPacCategoryAttribute(PacCategoryAttribute $l)
    {
        if ($this->collPacCategoryAttributes === null) {
            $this->initPacCategoryAttributes();
            $this->collPacCategoryAttributesPartial = true;
        }

        if (!$this->collPacCategoryAttributes->contains($l)) {
            $this->doAddPacCategoryAttribute($l);
        }

        return $this;
    }

    /**
     * @param PacCategoryAttribute $pacCategoryAttribute The PacCategoryAttribute object to add.
     */
    protected function doAddPacCategoryAttribute(PacCategoryAttribute $pacCategoryAttribute)
    {
        $this->collPacCategoryAttributes[]= $pacCategoryAttribute;
        $pacCategoryAttribute->setLocale($this);
    }

    /**
     * @param  PacCategoryAttribute $pacCategoryAttribute The PacCategoryAttribute object to remove.
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function removePacCategoryAttribute(PacCategoryAttribute $pacCategoryAttribute)
    {
        if ($this->getPacCategoryAttributes()->contains($pacCategoryAttribute)) {
            $pos = $this->collPacCategoryAttributes->search($pacCategoryAttribute);
            $this->collPacCategoryAttributes->remove($pos);
            if (null === $this->pacCategoryAttributesScheduledForDeletion) {
                $this->pacCategoryAttributesScheduledForDeletion = clone $this->collPacCategoryAttributes;
                $this->pacCategoryAttributesScheduledForDeletion->clear();
            }
            $this->pacCategoryAttributesScheduledForDeletion[]= clone $pacCategoryAttribute;
            $pacCategoryAttribute->setLocale(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PacLocale is new, it will return
     * an empty collection; or if this PacLocale has previously
     * been saved, it will retrieve related PacCategoryAttributes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PacLocale.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|PacCategoryAttribute[] List of PacCategoryAttribute objects
     */
    public function getPacCategoryAttributesJoinCategory(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = PacCategoryAttributeQuery::create(null, $criteria);
        $query->joinWith('Category', $joinBehavior);

        return $this->getPacCategoryAttributes($query, $con);
    }

    /**
     * Clears out the collPacLocalizedAbstractProductAttributess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPacLocalizedAbstractProductAttributess()
     */
    public function clearPacLocalizedAbstractProductAttributess()
    {
        $this->collPacLocalizedAbstractProductAttributess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPacLocalizedAbstractProductAttributess collection loaded partially.
     */
    public function resetPartialPacLocalizedAbstractProductAttributess($v = true)
    {
        $this->collPacLocalizedAbstractProductAttributessPartial = $v;
    }

    /**
     * Initializes the collPacLocalizedAbstractProductAttributess collection.
     *
     * By default this just sets the collPacLocalizedAbstractProductAttributess collection to an empty array (like clearcollPacLocalizedAbstractProductAttributess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPacLocalizedAbstractProductAttributess($overrideExisting = true)
    {
        if (null !== $this->collPacLocalizedAbstractProductAttributess && !$overrideExisting) {
            return;
        }
        $this->collPacLocalizedAbstractProductAttributess = new ObjectCollection();
        $this->collPacLocalizedAbstractProductAttributess->setModel('\ProjectA\Zed\Product\Persistence\Propel\PacLocalizedAbstractProductAttributes');
    }

    /**
     * Gets an array of PacLocalizedAbstractProductAttributes objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPacLocale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|PacLocalizedAbstractProductAttributes[] List of PacLocalizedAbstractProductAttributes objects
     * @throws PropelException
     */
    public function getPacLocalizedAbstractProductAttributess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPacLocalizedAbstractProductAttributessPartial && !$this->isNew();
        if (null === $this->collPacLocalizedAbstractProductAttributess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPacLocalizedAbstractProductAttributess) {
                // return empty collection
                $this->initPacLocalizedAbstractProductAttributess();
            } else {
                $collPacLocalizedAbstractProductAttributess = PacLocalizedAbstractProductAttributesQuery::create(null, $criteria)
                    ->filterByLocale($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPacLocalizedAbstractProductAttributessPartial && count($collPacLocalizedAbstractProductAttributess)) {
                        $this->initPacLocalizedAbstractProductAttributess(false);

                        foreach ($collPacLocalizedAbstractProductAttributess as $obj) {
                            if (false == $this->collPacLocalizedAbstractProductAttributess->contains($obj)) {
                                $this->collPacLocalizedAbstractProductAttributess->append($obj);
                            }
                        }

                        $this->collPacLocalizedAbstractProductAttributessPartial = true;
                    }

                    return $collPacLocalizedAbstractProductAttributess;
                }

                if ($partial && $this->collPacLocalizedAbstractProductAttributess) {
                    foreach ($this->collPacLocalizedAbstractProductAttributess as $obj) {
                        if ($obj->isNew()) {
                            $collPacLocalizedAbstractProductAttributess[] = $obj;
                        }
                    }
                }

                $this->collPacLocalizedAbstractProductAttributess = $collPacLocalizedAbstractProductAttributess;
                $this->collPacLocalizedAbstractProductAttributessPartial = false;
            }
        }

        return $this->collPacLocalizedAbstractProductAttributess;
    }

    /**
     * Sets a collection of PacLocalizedAbstractProductAttributes objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pacLocalizedAbstractProductAttributess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function setPacLocalizedAbstractProductAttributess(Collection $pacLocalizedAbstractProductAttributess, ConnectionInterface $con = null)
    {
        /** @var PacLocalizedAbstractProductAttributes[] $pacLocalizedAbstractProductAttributessToDelete */
        $pacLocalizedAbstractProductAttributessToDelete = $this->getPacLocalizedAbstractProductAttributess(new Criteria(), $con)->diff($pacLocalizedAbstractProductAttributess);


        $this->pacLocalizedAbstractProductAttributessScheduledForDeletion = $pacLocalizedAbstractProductAttributessToDelete;

        foreach ($pacLocalizedAbstractProductAttributessToDelete as $pacLocalizedAbstractProductAttributesRemoved) {
            $pacLocalizedAbstractProductAttributesRemoved->setLocale(null);
        }

        $this->collPacLocalizedAbstractProductAttributess = null;
        foreach ($pacLocalizedAbstractProductAttributess as $pacLocalizedAbstractProductAttributes) {
            $this->addPacLocalizedAbstractProductAttributes($pacLocalizedAbstractProductAttributes);
        }

        $this->collPacLocalizedAbstractProductAttributess = $pacLocalizedAbstractProductAttributess;
        $this->collPacLocalizedAbstractProductAttributessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BasePacLocalizedAbstractProductAttributes objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BasePacLocalizedAbstractProductAttributes objects.
     * @throws PropelException
     */
    public function countPacLocalizedAbstractProductAttributess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPacLocalizedAbstractProductAttributessPartial && !$this->isNew();
        if (null === $this->collPacLocalizedAbstractProductAttributess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPacLocalizedAbstractProductAttributess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPacLocalizedAbstractProductAttributess());
            }

            $query = PacLocalizedAbstractProductAttributesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocale($this)
                ->count($con);
        }

        return count($this->collPacLocalizedAbstractProductAttributess);
    }

    /**
     * Method called to associate a PacLocalizedAbstractProductAttributes object to this object
     * through the PacLocalizedAbstractProductAttributes foreign key attribute.
     *
     * @param  PacLocalizedAbstractProductAttributes $l PacLocalizedAbstractProductAttributes
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function addPacLocalizedAbstractProductAttributes(PacLocalizedAbstractProductAttributes $l)
    {
        if ($this->collPacLocalizedAbstractProductAttributess === null) {
            $this->initPacLocalizedAbstractProductAttributess();
            $this->collPacLocalizedAbstractProductAttributessPartial = true;
        }

        if (!$this->collPacLocalizedAbstractProductAttributess->contains($l)) {
            $this->doAddPacLocalizedAbstractProductAttributes($l);
        }

        return $this;
    }

    /**
     * @param PacLocalizedAbstractProductAttributes $pacLocalizedAbstractProductAttributes The PacLocalizedAbstractProductAttributes object to add.
     */
    protected function doAddPacLocalizedAbstractProductAttributes(PacLocalizedAbstractProductAttributes $pacLocalizedAbstractProductAttributes)
    {
        $this->collPacLocalizedAbstractProductAttributess[]= $pacLocalizedAbstractProductAttributes;
        $pacLocalizedAbstractProductAttributes->setLocale($this);
    }

    /**
     * @param  PacLocalizedAbstractProductAttributes $pacLocalizedAbstractProductAttributes The PacLocalizedAbstractProductAttributes object to remove.
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function removePacLocalizedAbstractProductAttributes(PacLocalizedAbstractProductAttributes $pacLocalizedAbstractProductAttributes)
    {
        if ($this->getPacLocalizedAbstractProductAttributess()->contains($pacLocalizedAbstractProductAttributes)) {
            $pos = $this->collPacLocalizedAbstractProductAttributess->search($pacLocalizedAbstractProductAttributes);
            $this->collPacLocalizedAbstractProductAttributess->remove($pos);
            if (null === $this->pacLocalizedAbstractProductAttributessScheduledForDeletion) {
                $this->pacLocalizedAbstractProductAttributessScheduledForDeletion = clone $this->collPacLocalizedAbstractProductAttributess;
                $this->pacLocalizedAbstractProductAttributessScheduledForDeletion->clear();
            }
            $this->pacLocalizedAbstractProductAttributessScheduledForDeletion[]= clone $pacLocalizedAbstractProductAttributes;
            $pacLocalizedAbstractProductAttributes->setLocale(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PacLocale is new, it will return
     * an empty collection; or if this PacLocale has previously
     * been saved, it will retrieve related PacLocalizedAbstractProductAttributess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PacLocale.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|PacLocalizedAbstractProductAttributes[] List of PacLocalizedAbstractProductAttributes objects
     */
    public function getPacLocalizedAbstractProductAttributessJoinPacAbstractProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = PacLocalizedAbstractProductAttributesQuery::create(null, $criteria);
        $query->joinWith('PacAbstractProduct', $joinBehavior);

        return $this->getPacLocalizedAbstractProductAttributess($query, $con);
    }

    /**
     * Clears out the collPacLocalizedProductAttributess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPacLocalizedProductAttributess()
     */
    public function clearPacLocalizedProductAttributess()
    {
        $this->collPacLocalizedProductAttributess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPacLocalizedProductAttributess collection loaded partially.
     */
    public function resetPartialPacLocalizedProductAttributess($v = true)
    {
        $this->collPacLocalizedProductAttributessPartial = $v;
    }

    /**
     * Initializes the collPacLocalizedProductAttributess collection.
     *
     * By default this just sets the collPacLocalizedProductAttributess collection to an empty array (like clearcollPacLocalizedProductAttributess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPacLocalizedProductAttributess($overrideExisting = true)
    {
        if (null !== $this->collPacLocalizedProductAttributess && !$overrideExisting) {
            return;
        }
        $this->collPacLocalizedProductAttributess = new ObjectCollection();
        $this->collPacLocalizedProductAttributess->setModel('\ProjectA\Zed\Product\Persistence\Propel\PacLocalizedProductAttributes');
    }

    /**
     * Gets an array of PacLocalizedProductAttributes objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPacLocale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|PacLocalizedProductAttributes[] List of PacLocalizedProductAttributes objects
     * @throws PropelException
     */
    public function getPacLocalizedProductAttributess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPacLocalizedProductAttributessPartial && !$this->isNew();
        if (null === $this->collPacLocalizedProductAttributess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPacLocalizedProductAttributess) {
                // return empty collection
                $this->initPacLocalizedProductAttributess();
            } else {
                $collPacLocalizedProductAttributess = PacLocalizedProductAttributesQuery::create(null, $criteria)
                    ->filterByLocale($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPacLocalizedProductAttributessPartial && count($collPacLocalizedProductAttributess)) {
                        $this->initPacLocalizedProductAttributess(false);

                        foreach ($collPacLocalizedProductAttributess as $obj) {
                            if (false == $this->collPacLocalizedProductAttributess->contains($obj)) {
                                $this->collPacLocalizedProductAttributess->append($obj);
                            }
                        }

                        $this->collPacLocalizedProductAttributessPartial = true;
                    }

                    return $collPacLocalizedProductAttributess;
                }

                if ($partial && $this->collPacLocalizedProductAttributess) {
                    foreach ($this->collPacLocalizedProductAttributess as $obj) {
                        if ($obj->isNew()) {
                            $collPacLocalizedProductAttributess[] = $obj;
                        }
                    }
                }

                $this->collPacLocalizedProductAttributess = $collPacLocalizedProductAttributess;
                $this->collPacLocalizedProductAttributessPartial = false;
            }
        }

        return $this->collPacLocalizedProductAttributess;
    }

    /**
     * Sets a collection of PacLocalizedProductAttributes objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pacLocalizedProductAttributess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function setPacLocalizedProductAttributess(Collection $pacLocalizedProductAttributess, ConnectionInterface $con = null)
    {
        /** @var PacLocalizedProductAttributes[] $pacLocalizedProductAttributessToDelete */
        $pacLocalizedProductAttributessToDelete = $this->getPacLocalizedProductAttributess(new Criteria(), $con)->diff($pacLocalizedProductAttributess);


        $this->pacLocalizedProductAttributessScheduledForDeletion = $pacLocalizedProductAttributessToDelete;

        foreach ($pacLocalizedProductAttributessToDelete as $pacLocalizedProductAttributesRemoved) {
            $pacLocalizedProductAttributesRemoved->setLocale(null);
        }

        $this->collPacLocalizedProductAttributess = null;
        foreach ($pacLocalizedProductAttributess as $pacLocalizedProductAttributes) {
            $this->addPacLocalizedProductAttributes($pacLocalizedProductAttributes);
        }

        $this->collPacLocalizedProductAttributess = $pacLocalizedProductAttributess;
        $this->collPacLocalizedProductAttributessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BasePacLocalizedProductAttributes objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BasePacLocalizedProductAttributes objects.
     * @throws PropelException
     */
    public function countPacLocalizedProductAttributess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPacLocalizedProductAttributessPartial && !$this->isNew();
        if (null === $this->collPacLocalizedProductAttributess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPacLocalizedProductAttributess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPacLocalizedProductAttributess());
            }

            $query = PacLocalizedProductAttributesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocale($this)
                ->count($con);
        }

        return count($this->collPacLocalizedProductAttributess);
    }

    /**
     * Method called to associate a PacLocalizedProductAttributes object to this object
     * through the PacLocalizedProductAttributes foreign key attribute.
     *
     * @param  PacLocalizedProductAttributes $l PacLocalizedProductAttributes
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function addPacLocalizedProductAttributes(PacLocalizedProductAttributes $l)
    {
        if ($this->collPacLocalizedProductAttributess === null) {
            $this->initPacLocalizedProductAttributess();
            $this->collPacLocalizedProductAttributessPartial = true;
        }

        if (!$this->collPacLocalizedProductAttributess->contains($l)) {
            $this->doAddPacLocalizedProductAttributes($l);
        }

        return $this;
    }

    /**
     * @param PacLocalizedProductAttributes $pacLocalizedProductAttributes The PacLocalizedProductAttributes object to add.
     */
    protected function doAddPacLocalizedProductAttributes(PacLocalizedProductAttributes $pacLocalizedProductAttributes)
    {
        $this->collPacLocalizedProductAttributess[]= $pacLocalizedProductAttributes;
        $pacLocalizedProductAttributes->setLocale($this);
    }

    /**
     * @param  PacLocalizedProductAttributes $pacLocalizedProductAttributes The PacLocalizedProductAttributes object to remove.
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function removePacLocalizedProductAttributes(PacLocalizedProductAttributes $pacLocalizedProductAttributes)
    {
        if ($this->getPacLocalizedProductAttributess()->contains($pacLocalizedProductAttributes)) {
            $pos = $this->collPacLocalizedProductAttributess->search($pacLocalizedProductAttributes);
            $this->collPacLocalizedProductAttributess->remove($pos);
            if (null === $this->pacLocalizedProductAttributessScheduledForDeletion) {
                $this->pacLocalizedProductAttributessScheduledForDeletion = clone $this->collPacLocalizedProductAttributess;
                $this->pacLocalizedProductAttributessScheduledForDeletion->clear();
            }
            $this->pacLocalizedProductAttributessScheduledForDeletion[]= clone $pacLocalizedProductAttributes;
            $pacLocalizedProductAttributes->setLocale(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PacLocale is new, it will return
     * an empty collection; or if this PacLocale has previously
     * been saved, it will retrieve related PacLocalizedProductAttributess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PacLocale.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|PacLocalizedProductAttributes[] List of PacLocalizedProductAttributes objects
     */
    public function getPacLocalizedProductAttributessJoinPacProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = PacLocalizedProductAttributesQuery::create(null, $criteria);
        $query->joinWith('PacProduct', $joinBehavior);

        return $this->getPacLocalizedProductAttributess($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PacLocale is new, it will return
     * an empty collection; or if this PacLocale has previously
     * been saved, it will retrieve related PacLocalizedProductAttributess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PacLocale.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|PacLocalizedProductAttributes[] List of PacLocalizedProductAttributes objects
     */
    public function getPacLocalizedProductAttributessJoinPacTax(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = PacLocalizedProductAttributesQuery::create(null, $criteria);
        $query->joinWith('PacTax', $joinBehavior);

        return $this->getPacLocalizedProductAttributess($query, $con);
    }

    /**
     * Clears out the collPacTaxes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPacTaxes()
     */
    public function clearPacTaxes()
    {
        $this->collPacTaxes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPacTaxes collection loaded partially.
     */
    public function resetPartialPacTaxes($v = true)
    {
        $this->collPacTaxesPartial = $v;
    }

    /**
     * Initializes the collPacTaxes collection.
     *
     * By default this just sets the collPacTaxes collection to an empty array (like clearcollPacTaxes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPacTaxes($overrideExisting = true)
    {
        if (null !== $this->collPacTaxes && !$overrideExisting) {
            return;
        }
        $this->collPacTaxes = new ObjectCollection();
        $this->collPacTaxes->setModel('\ProjectA\Zed\Product\Persistence\Propel\PacTax');
    }

    /**
     * Gets an array of PacTax objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPacLocale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|PacTax[] List of PacTax objects
     * @throws PropelException
     */
    public function getPacTaxes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPacTaxesPartial && !$this->isNew();
        if (null === $this->collPacTaxes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPacTaxes) {
                // return empty collection
                $this->initPacTaxes();
            } else {
                $collPacTaxes = PacTaxQuery::create(null, $criteria)
                    ->filterByLocale($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPacTaxesPartial && count($collPacTaxes)) {
                        $this->initPacTaxes(false);

                        foreach ($collPacTaxes as $obj) {
                            if (false == $this->collPacTaxes->contains($obj)) {
                                $this->collPacTaxes->append($obj);
                            }
                        }

                        $this->collPacTaxesPartial = true;
                    }

                    return $collPacTaxes;
                }

                if ($partial && $this->collPacTaxes) {
                    foreach ($this->collPacTaxes as $obj) {
                        if ($obj->isNew()) {
                            $collPacTaxes[] = $obj;
                        }
                    }
                }

                $this->collPacTaxes = $collPacTaxes;
                $this->collPacTaxesPartial = false;
            }
        }

        return $this->collPacTaxes;
    }

    /**
     * Sets a collection of PacTax objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pacTaxes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function setPacTaxes(Collection $pacTaxes, ConnectionInterface $con = null)
    {
        /** @var PacTax[] $pacTaxesToDelete */
        $pacTaxesToDelete = $this->getPacTaxes(new Criteria(), $con)->diff($pacTaxes);


        $this->pacTaxesScheduledForDeletion = $pacTaxesToDelete;

        foreach ($pacTaxesToDelete as $pacTaxRemoved) {
            $pacTaxRemoved->setLocale(null);
        }

        $this->collPacTaxes = null;
        foreach ($pacTaxes as $pacTax) {
            $this->addPacTax($pacTax);
        }

        $this->collPacTaxes = $pacTaxes;
        $this->collPacTaxesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BasePacTax objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BasePacTax objects.
     * @throws PropelException
     */
    public function countPacTaxes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPacTaxesPartial && !$this->isNew();
        if (null === $this->collPacTaxes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPacTaxes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPacTaxes());
            }

            $query = PacTaxQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocale($this)
                ->count($con);
        }

        return count($this->collPacTaxes);
    }

    /**
     * Method called to associate a PacTax object to this object
     * through the PacTax foreign key attribute.
     *
     * @param  PacTax $l PacTax
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function addPacTax(PacTax $l)
    {
        if ($this->collPacTaxes === null) {
            $this->initPacTaxes();
            $this->collPacTaxesPartial = true;
        }

        if (!$this->collPacTaxes->contains($l)) {
            $this->doAddPacTax($l);
        }

        return $this;
    }

    /**
     * @param PacTax $pacTax The PacTax object to add.
     */
    protected function doAddPacTax(PacTax $pacTax)
    {
        $this->collPacTaxes[]= $pacTax;
        $pacTax->setLocale($this);
    }

    /**
     * @param  PacTax $pacTax The PacTax object to remove.
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function removePacTax(PacTax $pacTax)
    {
        if ($this->getPacTaxes()->contains($pacTax)) {
            $pos = $this->collPacTaxes->search($pacTax);
            $this->collPacTaxes->remove($pos);
            if (null === $this->pacTaxesScheduledForDeletion) {
                $this->pacTaxesScheduledForDeletion = clone $this->collPacTaxes;
                $this->pacTaxesScheduledForDeletion->clear();
            }
            $this->pacTaxesScheduledForDeletion[]= clone $pacTax;
            $pacTax->setLocale(null);
        }

        return $this;
    }

    /**
     * Clears out the collPacTypeValues collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPacTypeValues()
     */
    public function clearPacTypeValues()
    {
        $this->collPacTypeValues = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPacTypeValues collection loaded partially.
     */
    public function resetPartialPacTypeValues($v = true)
    {
        $this->collPacTypeValuesPartial = $v;
    }

    /**
     * Initializes the collPacTypeValues collection.
     *
     * By default this just sets the collPacTypeValues collection to an empty array (like clearcollPacTypeValues());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPacTypeValues($overrideExisting = true)
    {
        if (null !== $this->collPacTypeValues && !$overrideExisting) {
            return;
        }
        $this->collPacTypeValues = new ObjectCollection();
        $this->collPacTypeValues->setModel('\ProjectA\Zed\Product\Persistence\Propel\PacTypeValue');
    }

    /**
     * Gets an array of PacTypeValue objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPacLocale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|PacTypeValue[] List of PacTypeValue objects
     * @throws PropelException
     */
    public function getPacTypeValues(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPacTypeValuesPartial && !$this->isNew();
        if (null === $this->collPacTypeValues || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPacTypeValues) {
                // return empty collection
                $this->initPacTypeValues();
            } else {
                $collPacTypeValues = PacTypeValueQuery::create(null, $criteria)
                    ->filterByLocale($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPacTypeValuesPartial && count($collPacTypeValues)) {
                        $this->initPacTypeValues(false);

                        foreach ($collPacTypeValues as $obj) {
                            if (false == $this->collPacTypeValues->contains($obj)) {
                                $this->collPacTypeValues->append($obj);
                            }
                        }

                        $this->collPacTypeValuesPartial = true;
                    }

                    return $collPacTypeValues;
                }

                if ($partial && $this->collPacTypeValues) {
                    foreach ($this->collPacTypeValues as $obj) {
                        if ($obj->isNew()) {
                            $collPacTypeValues[] = $obj;
                        }
                    }
                }

                $this->collPacTypeValues = $collPacTypeValues;
                $this->collPacTypeValuesPartial = false;
            }
        }

        return $this->collPacTypeValues;
    }

    /**
     * Sets a collection of PacTypeValue objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pacTypeValues A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function setPacTypeValues(Collection $pacTypeValues, ConnectionInterface $con = null)
    {
        /** @var PacTypeValue[] $pacTypeValuesToDelete */
        $pacTypeValuesToDelete = $this->getPacTypeValues(new Criteria(), $con)->diff($pacTypeValues);


        $this->pacTypeValuesScheduledForDeletion = $pacTypeValuesToDelete;

        foreach ($pacTypeValuesToDelete as $pacTypeValueRemoved) {
            $pacTypeValueRemoved->setLocale(null);
        }

        $this->collPacTypeValues = null;
        foreach ($pacTypeValues as $pacTypeValue) {
            $this->addPacTypeValue($pacTypeValue);
        }

        $this->collPacTypeValues = $pacTypeValues;
        $this->collPacTypeValuesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BasePacTypeValue objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BasePacTypeValue objects.
     * @throws PropelException
     */
    public function countPacTypeValues(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPacTypeValuesPartial && !$this->isNew();
        if (null === $this->collPacTypeValues || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPacTypeValues) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPacTypeValues());
            }

            $query = PacTypeValueQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocale($this)
                ->count($con);
        }

        return count($this->collPacTypeValues);
    }

    /**
     * Method called to associate a PacTypeValue object to this object
     * through the PacTypeValue foreign key attribute.
     *
     * @param  PacTypeValue $l PacTypeValue
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function addPacTypeValue(PacTypeValue $l)
    {
        if ($this->collPacTypeValues === null) {
            $this->initPacTypeValues();
            $this->collPacTypeValuesPartial = true;
        }

        if (!$this->collPacTypeValues->contains($l)) {
            $this->doAddPacTypeValue($l);
        }

        return $this;
    }

    /**
     * @param PacTypeValue $pacTypeValue The PacTypeValue object to add.
     */
    protected function doAddPacTypeValue(PacTypeValue $pacTypeValue)
    {
        $this->collPacTypeValues[]= $pacTypeValue;
        $pacTypeValue->setLocale($this);
    }

    /**
     * @param  PacTypeValue $pacTypeValue The PacTypeValue object to remove.
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function removePacTypeValue(PacTypeValue $pacTypeValue)
    {
        if ($this->getPacTypeValues()->contains($pacTypeValue)) {
            $pos = $this->collPacTypeValues->search($pacTypeValue);
            $this->collPacTypeValues->remove($pos);
            if (null === $this->pacTypeValuesScheduledForDeletion) {
                $this->pacTypeValuesScheduledForDeletion = clone $this->collPacTypeValues;
                $this->pacTypeValuesScheduledForDeletion->clear();
            }
            $this->pacTypeValuesScheduledForDeletion[]= $pacTypeValue;
            $pacTypeValue->setLocale(null);
        }

        return $this;
    }

    /**
     * Clears out the collPacSearchableProductss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPacSearchableProductss()
     */
    public function clearPacSearchableProductss()
    {
        $this->collPacSearchableProductss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPacSearchableProductss collection loaded partially.
     */
    public function resetPartialPacSearchableProductss($v = true)
    {
        $this->collPacSearchableProductssPartial = $v;
    }

    /**
     * Initializes the collPacSearchableProductss collection.
     *
     * By default this just sets the collPacSearchableProductss collection to an empty array (like clearcollPacSearchableProductss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPacSearchableProductss($overrideExisting = true)
    {
        if (null !== $this->collPacSearchableProductss && !$overrideExisting) {
            return;
        }
        $this->collPacSearchableProductss = new ObjectCollection();
        $this->collPacSearchableProductss->setModel('\ProjectA\Zed\ProductSearch\Persistence\Propel\PacSearchableProducts');
    }

    /**
     * Gets an array of PacSearchableProducts objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPacLocale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|PacSearchableProducts[] List of PacSearchableProducts objects
     * @throws PropelException
     */
    public function getPacSearchableProductss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPacSearchableProductssPartial && !$this->isNew();
        if (null === $this->collPacSearchableProductss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPacSearchableProductss) {
                // return empty collection
                $this->initPacSearchableProductss();
            } else {
                $collPacSearchableProductss = PacSearchableProductsQuery::create(null, $criteria)
                    ->filterByPacLocale($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPacSearchableProductssPartial && count($collPacSearchableProductss)) {
                        $this->initPacSearchableProductss(false);

                        foreach ($collPacSearchableProductss as $obj) {
                            if (false == $this->collPacSearchableProductss->contains($obj)) {
                                $this->collPacSearchableProductss->append($obj);
                            }
                        }

                        $this->collPacSearchableProductssPartial = true;
                    }

                    return $collPacSearchableProductss;
                }

                if ($partial && $this->collPacSearchableProductss) {
                    foreach ($this->collPacSearchableProductss as $obj) {
                        if ($obj->isNew()) {
                            $collPacSearchableProductss[] = $obj;
                        }
                    }
                }

                $this->collPacSearchableProductss = $collPacSearchableProductss;
                $this->collPacSearchableProductssPartial = false;
            }
        }

        return $this->collPacSearchableProductss;
    }

    /**
     * Sets a collection of PacSearchableProducts objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pacSearchableProductss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function setPacSearchableProductss(Collection $pacSearchableProductss, ConnectionInterface $con = null)
    {
        /** @var PacSearchableProducts[] $pacSearchableProductssToDelete */
        $pacSearchableProductssToDelete = $this->getPacSearchableProductss(new Criteria(), $con)->diff($pacSearchableProductss);


        $this->pacSearchableProductssScheduledForDeletion = $pacSearchableProductssToDelete;

        foreach ($pacSearchableProductssToDelete as $pacSearchableProductsRemoved) {
            $pacSearchableProductsRemoved->setPacLocale(null);
        }

        $this->collPacSearchableProductss = null;
        foreach ($pacSearchableProductss as $pacSearchableProducts) {
            $this->addPacSearchableProducts($pacSearchableProducts);
        }

        $this->collPacSearchableProductss = $pacSearchableProductss;
        $this->collPacSearchableProductssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BasePacSearchableProducts objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BasePacSearchableProducts objects.
     * @throws PropelException
     */
    public function countPacSearchableProductss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPacSearchableProductssPartial && !$this->isNew();
        if (null === $this->collPacSearchableProductss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPacSearchableProductss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPacSearchableProductss());
            }

            $query = PacSearchableProductsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPacLocale($this)
                ->count($con);
        }

        return count($this->collPacSearchableProductss);
    }

    /**
     * Method called to associate a PacSearchableProducts object to this object
     * through the PacSearchableProducts foreign key attribute.
     *
     * @param  PacSearchableProducts $l PacSearchableProducts
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function addPacSearchableProducts(PacSearchableProducts $l)
    {
        if ($this->collPacSearchableProductss === null) {
            $this->initPacSearchableProductss();
            $this->collPacSearchableProductssPartial = true;
        }

        if (!$this->collPacSearchableProductss->contains($l)) {
            $this->doAddPacSearchableProducts($l);
        }

        return $this;
    }

    /**
     * @param PacSearchableProducts $pacSearchableProducts The PacSearchableProducts object to add.
     */
    protected function doAddPacSearchableProducts(PacSearchableProducts $pacSearchableProducts)
    {
        $this->collPacSearchableProductss[]= $pacSearchableProducts;
        $pacSearchableProducts->setPacLocale($this);
    }

    /**
     * @param  PacSearchableProducts $pacSearchableProducts The PacSearchableProducts object to remove.
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function removePacSearchableProducts(PacSearchableProducts $pacSearchableProducts)
    {
        if ($this->getPacSearchableProductss()->contains($pacSearchableProducts)) {
            $pos = $this->collPacSearchableProductss->search($pacSearchableProducts);
            $this->collPacSearchableProductss->remove($pos);
            if (null === $this->pacSearchableProductssScheduledForDeletion) {
                $this->pacSearchableProductssScheduledForDeletion = clone $this->collPacSearchableProductss;
                $this->pacSearchableProductssScheduledForDeletion->clear();
            }
            $this->pacSearchableProductssScheduledForDeletion[]= $pacSearchableProducts;
            $pacSearchableProducts->setPacLocale(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PacLocale is new, it will return
     * an empty collection; or if this PacLocale has previously
     * been saved, it will retrieve related PacSearchableProductss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PacLocale.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|PacSearchableProducts[] List of PacSearchableProducts objects
     */
    public function getPacSearchableProductssJoinPacProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = PacSearchableProductsQuery::create(null, $criteria);
        $query->joinWith('PacProduct', $joinBehavior);

        return $this->getPacSearchableProductss($query, $con);
    }

    /**
     * Clears out the collSprykerCoreUrls collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSprykerCoreUrls()
     */
    public function clearSprykerCoreUrls()
    {
        $this->collSprykerCoreUrls = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSprykerCoreUrls collection loaded partially.
     */
    public function resetPartialSprykerCoreUrls($v = true)
    {
        $this->collSprykerCoreUrlsPartial = $v;
    }

    /**
     * Initializes the collSprykerCoreUrls collection.
     *
     * By default this just sets the collSprykerCoreUrls collection to an empty array (like clearcollSprykerCoreUrls());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSprykerCoreUrls($overrideExisting = true)
    {
        if (null !== $this->collSprykerCoreUrls && !$overrideExisting) {
            return;
        }
        $this->collSprykerCoreUrls = new ObjectCollection();
        $this->collSprykerCoreUrls->setModel('\SprykerCore\Zed\Url\Persistence\Propel\SprykerCoreUrl');
    }

    /**
     * Gets an array of SprykerCoreUrl objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPacLocale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|SprykerCoreUrl[] List of SprykerCoreUrl objects
     * @throws PropelException
     */
    public function getSprykerCoreUrls(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSprykerCoreUrlsPartial && !$this->isNew();
        if (null === $this->collSprykerCoreUrls || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSprykerCoreUrls) {
                // return empty collection
                $this->initSprykerCoreUrls();
            } else {
                $collSprykerCoreUrls = SprykerCoreUrlQuery::create(null, $criteria)
                    ->filterByLocale($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSprykerCoreUrlsPartial && count($collSprykerCoreUrls)) {
                        $this->initSprykerCoreUrls(false);

                        foreach ($collSprykerCoreUrls as $obj) {
                            if (false == $this->collSprykerCoreUrls->contains($obj)) {
                                $this->collSprykerCoreUrls->append($obj);
                            }
                        }

                        $this->collSprykerCoreUrlsPartial = true;
                    }

                    return $collSprykerCoreUrls;
                }

                if ($partial && $this->collSprykerCoreUrls) {
                    foreach ($this->collSprykerCoreUrls as $obj) {
                        if ($obj->isNew()) {
                            $collSprykerCoreUrls[] = $obj;
                        }
                    }
                }

                $this->collSprykerCoreUrls = $collSprykerCoreUrls;
                $this->collSprykerCoreUrlsPartial = false;
            }
        }

        return $this->collSprykerCoreUrls;
    }

    /**
     * Sets a collection of SprykerCoreUrl objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sprykerCoreUrls A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function setSprykerCoreUrls(Collection $sprykerCoreUrls, ConnectionInterface $con = null)
    {
        /** @var SprykerCoreUrl[] $sprykerCoreUrlsToDelete */
        $sprykerCoreUrlsToDelete = $this->getSprykerCoreUrls(new Criteria(), $con)->diff($sprykerCoreUrls);


        $this->sprykerCoreUrlsScheduledForDeletion = $sprykerCoreUrlsToDelete;

        foreach ($sprykerCoreUrlsToDelete as $sprykerCoreUrlRemoved) {
            $sprykerCoreUrlRemoved->setLocale(null);
        }

        $this->collSprykerCoreUrls = null;
        foreach ($sprykerCoreUrls as $sprykerCoreUrl) {
            $this->addSprykerCoreUrl($sprykerCoreUrl);
        }

        $this->collSprykerCoreUrls = $sprykerCoreUrls;
        $this->collSprykerCoreUrlsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseSprykerCoreUrl objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseSprykerCoreUrl objects.
     * @throws PropelException
     */
    public function countSprykerCoreUrls(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSprykerCoreUrlsPartial && !$this->isNew();
        if (null === $this->collSprykerCoreUrls || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSprykerCoreUrls) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSprykerCoreUrls());
            }

            $query = SprykerCoreUrlQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocale($this)
                ->count($con);
        }

        return count($this->collSprykerCoreUrls);
    }

    /**
     * Method called to associate a SprykerCoreUrl object to this object
     * through the SprykerCoreUrl foreign key attribute.
     *
     * @param  SprykerCoreUrl $l SprykerCoreUrl
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function addSprykerCoreUrl(SprykerCoreUrl $l)
    {
        if ($this->collSprykerCoreUrls === null) {
            $this->initSprykerCoreUrls();
            $this->collSprykerCoreUrlsPartial = true;
        }

        if (!$this->collSprykerCoreUrls->contains($l)) {
            $this->doAddSprykerCoreUrl($l);
        }

        return $this;
    }

    /**
     * @param SprykerCoreUrl $sprykerCoreUrl The SprykerCoreUrl object to add.
     */
    protected function doAddSprykerCoreUrl(SprykerCoreUrl $sprykerCoreUrl)
    {
        $this->collSprykerCoreUrls[]= $sprykerCoreUrl;
        $sprykerCoreUrl->setLocale($this);
    }

    /**
     * @param  SprykerCoreUrl $sprykerCoreUrl The SprykerCoreUrl object to remove.
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function removeSprykerCoreUrl(SprykerCoreUrl $sprykerCoreUrl)
    {
        if ($this->getSprykerCoreUrls()->contains($sprykerCoreUrl)) {
            $pos = $this->collSprykerCoreUrls->search($sprykerCoreUrl);
            $this->collSprykerCoreUrls->remove($pos);
            if (null === $this->sprykerCoreUrlsScheduledForDeletion) {
                $this->sprykerCoreUrlsScheduledForDeletion = clone $this->collSprykerCoreUrls;
                $this->sprykerCoreUrlsScheduledForDeletion->clear();
            }
            $this->sprykerCoreUrlsScheduledForDeletion[]= clone $sprykerCoreUrl;
            $sprykerCoreUrl->setLocale(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PacLocale is new, it will return
     * an empty collection; or if this PacLocale has previously
     * been saved, it will retrieve related SprykerCoreUrls from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PacLocale.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|SprykerCoreUrl[] List of SprykerCoreUrl objects
     */
    public function getSprykerCoreUrlsJoinContent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = SprykerCoreUrlQuery::create(null, $criteria);
        $query->joinWith('Content', $joinBehavior);

        return $this->getSprykerCoreUrls($query, $con);
    }

    /**
     * Clears out the collGlossaryTranslations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGlossaryTranslations()
     */
    public function clearGlossaryTranslations()
    {
        $this->collGlossaryTranslations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGlossaryTranslations collection loaded partially.
     */
    public function resetPartialGlossaryTranslations($v = true)
    {
        $this->collGlossaryTranslationsPartial = $v;
    }

    /**
     * Initializes the collGlossaryTranslations collection.
     *
     * By default this just sets the collGlossaryTranslations collection to an empty array (like clearcollGlossaryTranslations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGlossaryTranslations($overrideExisting = true)
    {
        if (null !== $this->collGlossaryTranslations && !$overrideExisting) {
            return;
        }
        $this->collGlossaryTranslations = new ObjectCollection();
        $this->collGlossaryTranslations->setModel('\SprykerFeature\Zed\Glossary\Persistence\Propel\GlossaryTranslation');
    }

    /**
     * Gets an array of GlossaryTranslation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPacLocale is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|GlossaryTranslation[] List of GlossaryTranslation objects
     * @throws PropelException
     */
    public function getGlossaryTranslations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGlossaryTranslationsPartial && !$this->isNew();
        if (null === $this->collGlossaryTranslations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGlossaryTranslations) {
                // return empty collection
                $this->initGlossaryTranslations();
            } else {
                $collGlossaryTranslations = GlossaryTranslationQuery::create(null, $criteria)
                    ->filterByGlossaryLocale($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGlossaryTranslationsPartial && count($collGlossaryTranslations)) {
                        $this->initGlossaryTranslations(false);

                        foreach ($collGlossaryTranslations as $obj) {
                            if (false == $this->collGlossaryTranslations->contains($obj)) {
                                $this->collGlossaryTranslations->append($obj);
                            }
                        }

                        $this->collGlossaryTranslationsPartial = true;
                    }

                    return $collGlossaryTranslations;
                }

                if ($partial && $this->collGlossaryTranslations) {
                    foreach ($this->collGlossaryTranslations as $obj) {
                        if ($obj->isNew()) {
                            $collGlossaryTranslations[] = $obj;
                        }
                    }
                }

                $this->collGlossaryTranslations = $collGlossaryTranslations;
                $this->collGlossaryTranslationsPartial = false;
            }
        }

        return $this->collGlossaryTranslations;
    }

    /**
     * Sets a collection of GlossaryTranslation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $glossaryTranslations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function setGlossaryTranslations(Collection $glossaryTranslations, ConnectionInterface $con = null)
    {
        /** @var GlossaryTranslation[] $glossaryTranslationsToDelete */
        $glossaryTranslationsToDelete = $this->getGlossaryTranslations(new Criteria(), $con)->diff($glossaryTranslations);


        $this->glossaryTranslationsScheduledForDeletion = $glossaryTranslationsToDelete;

        foreach ($glossaryTranslationsToDelete as $glossaryTranslationRemoved) {
            $glossaryTranslationRemoved->setGlossaryLocale(null);
        }

        $this->collGlossaryTranslations = null;
        foreach ($glossaryTranslations as $glossaryTranslation) {
            $this->addGlossaryTranslation($glossaryTranslation);
        }

        $this->collGlossaryTranslations = $glossaryTranslations;
        $this->collGlossaryTranslationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseGlossaryTranslation objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseGlossaryTranslation objects.
     * @throws PropelException
     */
    public function countGlossaryTranslations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGlossaryTranslationsPartial && !$this->isNew();
        if (null === $this->collGlossaryTranslations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGlossaryTranslations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGlossaryTranslations());
            }

            $query = GlossaryTranslationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGlossaryLocale($this)
                ->count($con);
        }

        return count($this->collGlossaryTranslations);
    }

    /**
     * Method called to associate a GlossaryTranslation object to this object
     * through the GlossaryTranslation foreign key attribute.
     *
     * @param  GlossaryTranslation $l GlossaryTranslation
     * @return $this|\SprykerCore\Zed\Locale\Persistence\Propel\PacLocale The current object (for fluent API support)
     */
    public function addGlossaryTranslation(GlossaryTranslation $l)
    {
        if ($this->collGlossaryTranslations === null) {
            $this->initGlossaryTranslations();
            $this->collGlossaryTranslationsPartial = true;
        }

        if (!$this->collGlossaryTranslations->contains($l)) {
            $this->doAddGlossaryTranslation($l);
        }

        return $this;
    }

    /**
     * @param GlossaryTranslation $glossaryTranslation The GlossaryTranslation object to add.
     */
    protected function doAddGlossaryTranslation(GlossaryTranslation $glossaryTranslation)
    {
        $this->collGlossaryTranslations[]= $glossaryTranslation;
        $glossaryTranslation->setGlossaryLocale($this);
    }

    /**
     * @param  GlossaryTranslation $glossaryTranslation The GlossaryTranslation object to remove.
     * @return $this|ChildPacLocale The current object (for fluent API support)
     */
    public function removeGlossaryTranslation(GlossaryTranslation $glossaryTranslation)
    {
        if ($this->getGlossaryTranslations()->contains($glossaryTranslation)) {
            $pos = $this->collGlossaryTranslations->search($glossaryTranslation);
            $this->collGlossaryTranslations->remove($pos);
            if (null === $this->glossaryTranslationsScheduledForDeletion) {
                $this->glossaryTranslationsScheduledForDeletion = clone $this->collGlossaryTranslations;
                $this->glossaryTranslationsScheduledForDeletion->clear();
            }
            $this->glossaryTranslationsScheduledForDeletion[]= clone $glossaryTranslation;
            $glossaryTranslation->setGlossaryLocale(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PacLocale is new, it will return
     * an empty collection; or if this PacLocale has previously
     * been saved, it will retrieve related GlossaryTranslations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PacLocale.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|GlossaryTranslation[] List of GlossaryTranslation objects
     */
    public function getGlossaryTranslationsJoinGlossaryKey(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = GlossaryTranslationQuery::create(null, $criteria);
        $query->joinWith('GlossaryKey', $joinBehavior);

        return $this->getGlossaryTranslations($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id_locale = null;
        $this->locale_name = null;
        $this->is_active = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPacCategoryAttributes) {
                foreach ($this->collPacCategoryAttributes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPacLocalizedAbstractProductAttributess) {
                foreach ($this->collPacLocalizedAbstractProductAttributess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPacLocalizedProductAttributess) {
                foreach ($this->collPacLocalizedProductAttributess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPacTaxes) {
                foreach ($this->collPacTaxes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPacTypeValues) {
                foreach ($this->collPacTypeValues as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPacSearchableProductss) {
                foreach ($this->collPacSearchableProductss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSprykerCoreUrls) {
                foreach ($this->collSprykerCoreUrls as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGlossaryTranslations) {
                foreach ($this->collGlossaryTranslations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPacCategoryAttributes = null;
        $this->collPacLocalizedAbstractProductAttributess = null;
        $this->collPacLocalizedProductAttributess = null;
        $this->collPacTaxes = null;
        $this->collPacTypeValues = null;
        $this->collPacSearchableProductss = null;
        $this->collSprykerCoreUrls = null;
        $this->collGlossaryTranslations = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PacLocaleTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
