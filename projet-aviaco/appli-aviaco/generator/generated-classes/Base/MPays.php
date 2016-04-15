<?php

namespace Base;

use \IConcernePays as ChildIConcernePays;
use \IConcernePaysQuery as ChildIConcernePaysQuery;
use \MPays as ChildMPays;
use \MPaysQuery as ChildMPaysQuery;
use \Societe as ChildSociete;
use \SocieteQuery as ChildSocieteQuery;
use \Exception;
use \PDO;
use Map\MPaysTableMap;
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

/**
 * Base class that represents a row from the 'pays' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class MPays implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\MPaysTableMap';


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
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the pays field.
     * @var        string
     */
    protected $pays;

    /**
     * @var        ObjectCollection|ChildSociete[] Collection to store aggregation of ChildSociete objects.
     */
    protected $collSocietes;
    protected $collSocietesPartial;

    /**
     * @var        ObjectCollection|ChildIConcernePays[] Collection to store aggregation of ChildIConcernePays objects.
     */
    protected $collIConcernePayss;
    protected $collIConcernePayssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSociete[]
     */
    protected $societesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIConcernePays[]
     */
    protected $iConcernePayssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\MPays object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>MPays</code> instance.  If
     * <code>obj</code> is an instance of <code>MPays</code>, delegates to
     * <code>equals(MPays)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|MPays The current object, for fluid interface
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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Get the [pays] column value.
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\MPays The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[MPaysTableMap::COL_ID] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [pays] column.
     *
     * @param string $v new value
     * @return $this|\MPays The current object (for fluent API support)
     */
    public function setPays($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pays !== $v) {
            $this->pays = $v;
            $this->modifiedColumns[MPaysTableMap::COL_PAYS] = true;
        }

        return $this;
    } // setPays()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MPaysTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MPaysTableMap::translateFieldName('Pays', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pays = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = MPaysTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MPays'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(MPaysTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMPaysQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSocietes = null;

            $this->collIConcernePayss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see MPays::setDeleted()
     * @see MPays::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MPaysTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMPaysQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(MPaysTableMap::DATABASE_NAME);
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
                MPaysTableMap::addInstanceToPool($this);
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
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->societesScheduledForDeletion !== null) {
                if (!$this->societesScheduledForDeletion->isEmpty()) {
                    \SocieteQuery::create()
                        ->filterByPrimaryKeys($this->societesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->societesScheduledForDeletion = null;
                }
            }

            if ($this->collSocietes !== null) {
                foreach ($this->collSocietes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->iConcernePayssScheduledForDeletion !== null) {
                if (!$this->iConcernePayssScheduledForDeletion->isEmpty()) {
                    \IConcernePaysQuery::create()
                        ->filterByPrimaryKeys($this->iConcernePayssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->iConcernePayssScheduledForDeletion = null;
                }
            }

            if ($this->collIConcernePayss !== null) {
                foreach ($this->collIConcernePayss as $referrerFK) {
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

        $this->modifiedColumns[MPaysTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MPaysTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MPaysTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(MPaysTableMap::COL_PAYS)) {
            $modifiedColumns[':p' . $index++]  = 'pays';
        }

        $sql = sprintf(
            'INSERT INTO pays (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'pays':
                        $stmt->bindValue($identifier, $this->pays, PDO::PARAM_STR);
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
        $this->setID($pk);

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
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MPaysTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getID();
                break;
            case 1:
                return $this->getPays();
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
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['MPays'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['MPays'][$this->hashCode()] = true;
        $keys = MPaysTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getPays(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSocietes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'societes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'societes';
                        break;
                    default:
                        $key = 'Societes';
                }

                $result[$key] = $this->collSocietes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collIConcernePayss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'iConcernePayss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'infos_concerne_payss';
                        break;
                    default:
                        $key = 'IConcernePayss';
                }

                $result[$key] = $this->collIConcernePayss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\MPays
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MPaysTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MPays
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setID($value);
                break;
            case 1:
                $this->setPays($value);
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
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = MPaysTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPays($arr[$keys[1]]);
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
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\MPays The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
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
        $criteria = new Criteria(MPaysTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MPaysTableMap::COL_ID)) {
            $criteria->add(MPaysTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(MPaysTableMap::COL_PAYS)) {
            $criteria->add(MPaysTableMap::COL_PAYS, $this->pays);
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
        $criteria = ChildMPaysQuery::create();
        $criteria->add(MPaysTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getID();

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
        return $this->getID();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setID($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getID();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MPays (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPays($this->getPays());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSocietes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSociete($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getIConcernePayss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIConcernePays($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setID(NULL); // this is a auto-increment column, so set to default value
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
     * @return \MPays Clone of current object.
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
        if ('Societe' == $relationName) {
            return $this->initSocietes();
        }
        if ('IConcernePays' == $relationName) {
            return $this->initIConcernePayss();
        }
    }

    /**
     * Clears out the collSocietes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSocietes()
     */
    public function clearSocietes()
    {
        $this->collSocietes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSocietes collection loaded partially.
     */
    public function resetPartialSocietes($v = true)
    {
        $this->collSocietesPartial = $v;
    }

    /**
     * Initializes the collSocietes collection.
     *
     * By default this just sets the collSocietes collection to an empty array (like clearcollSocietes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSocietes($overrideExisting = true)
    {
        if (null !== $this->collSocietes && !$overrideExisting) {
            return;
        }
        $this->collSocietes = new ObjectCollection();
        $this->collSocietes->setModel('\Societe');
    }

    /**
     * Gets an array of ChildSociete objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMPays is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSociete[] List of ChildSociete objects
     * @throws PropelException
     */
    public function getSocietes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietesPartial && !$this->isNew();
        if (null === $this->collSocietes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSocietes) {
                // return empty collection
                $this->initSocietes();
            } else {
                $collSocietes = ChildSocieteQuery::create(null, $criteria)
                    ->filterByMPays($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSocietesPartial && count($collSocietes)) {
                        $this->initSocietes(false);

                        foreach ($collSocietes as $obj) {
                            if (false == $this->collSocietes->contains($obj)) {
                                $this->collSocietes->append($obj);
                            }
                        }

                        $this->collSocietesPartial = true;
                    }

                    return $collSocietes;
                }

                if ($partial && $this->collSocietes) {
                    foreach ($this->collSocietes as $obj) {
                        if ($obj->isNew()) {
                            $collSocietes[] = $obj;
                        }
                    }
                }

                $this->collSocietes = $collSocietes;
                $this->collSocietesPartial = false;
            }
        }

        return $this->collSocietes;
    }

    /**
     * Sets a collection of ChildSociete objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $societes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMPays The current object (for fluent API support)
     */
    public function setSocietes(Collection $societes, ConnectionInterface $con = null)
    {
        /** @var ChildSociete[] $societesToDelete */
        $societesToDelete = $this->getSocietes(new Criteria(), $con)->diff($societes);


        $this->societesScheduledForDeletion = $societesToDelete;

        foreach ($societesToDelete as $societeRemoved) {
            $societeRemoved->setMPays(null);
        }

        $this->collSocietes = null;
        foreach ($societes as $societe) {
            $this->addSociete($societe);
        }

        $this->collSocietes = $societes;
        $this->collSocietesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Societe objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Societe objects.
     * @throws PropelException
     */
    public function countSocietes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietesPartial && !$this->isNew();
        if (null === $this->collSocietes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSocietes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSocietes());
            }

            $query = ChildSocieteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMPays($this)
                ->count($con);
        }

        return count($this->collSocietes);
    }

    /**
     * Method called to associate a ChildSociete object to this object
     * through the ChildSociete foreign key attribute.
     *
     * @param  ChildSociete $l ChildSociete
     * @return $this|\MPays The current object (for fluent API support)
     */
    public function addSociete(ChildSociete $l)
    {
        if ($this->collSocietes === null) {
            $this->initSocietes();
            $this->collSocietesPartial = true;
        }

        if (!$this->collSocietes->contains($l)) {
            $this->doAddSociete($l);
        }

        return $this;
    }

    /**
     * @param ChildSociete $societe The ChildSociete object to add.
     */
    protected function doAddSociete(ChildSociete $societe)
    {
        $this->collSocietes[]= $societe;
        $societe->setMPays($this);
    }

    /**
     * @param  ChildSociete $societe The ChildSociete object to remove.
     * @return $this|ChildMPays The current object (for fluent API support)
     */
    public function removeSociete(ChildSociete $societe)
    {
        if ($this->getSocietes()->contains($societe)) {
            $pos = $this->collSocietes->search($societe);
            $this->collSocietes->remove($pos);
            if (null === $this->societesScheduledForDeletion) {
                $this->societesScheduledForDeletion = clone $this->collSocietes;
                $this->societesScheduledForDeletion->clear();
            }
            $this->societesScheduledForDeletion[]= $societe;
            $societe->setMPays(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this MPays is new, it will return
     * an empty collection; or if this MPays has previously
     * been saved, it will retrieve related Societes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in MPays.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSociete[] List of ChildSociete objects
     */
    public function getSocietesJoinMarque(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocieteQuery::create(null, $criteria);
        $query->joinWith('Marque', $joinBehavior);

        return $this->getSocietes($query, $con);
    }

    /**
     * Clears out the collIConcernePayss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIConcernePayss()
     */
    public function clearIConcernePayss()
    {
        $this->collIConcernePayss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collIConcernePayss collection loaded partially.
     */
    public function resetPartialIConcernePayss($v = true)
    {
        $this->collIConcernePayssPartial = $v;
    }

    /**
     * Initializes the collIConcernePayss collection.
     *
     * By default this just sets the collIConcernePayss collection to an empty array (like clearcollIConcernePayss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIConcernePayss($overrideExisting = true)
    {
        if (null !== $this->collIConcernePayss && !$overrideExisting) {
            return;
        }
        $this->collIConcernePayss = new ObjectCollection();
        $this->collIConcernePayss->setModel('\IConcernePays');
    }

    /**
     * Gets an array of ChildIConcernePays objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMPays is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildIConcernePays[] List of ChildIConcernePays objects
     * @throws PropelException
     */
    public function getIConcernePayss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIConcernePayssPartial && !$this->isNew();
        if (null === $this->collIConcernePayss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIConcernePayss) {
                // return empty collection
                $this->initIConcernePayss();
            } else {
                $collIConcernePayss = ChildIConcernePaysQuery::create(null, $criteria)
                    ->filterByPays($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collIConcernePayssPartial && count($collIConcernePayss)) {
                        $this->initIConcernePayss(false);

                        foreach ($collIConcernePayss as $obj) {
                            if (false == $this->collIConcernePayss->contains($obj)) {
                                $this->collIConcernePayss->append($obj);
                            }
                        }

                        $this->collIConcernePayssPartial = true;
                    }

                    return $collIConcernePayss;
                }

                if ($partial && $this->collIConcernePayss) {
                    foreach ($this->collIConcernePayss as $obj) {
                        if ($obj->isNew()) {
                            $collIConcernePayss[] = $obj;
                        }
                    }
                }

                $this->collIConcernePayss = $collIConcernePayss;
                $this->collIConcernePayssPartial = false;
            }
        }

        return $this->collIConcernePayss;
    }

    /**
     * Sets a collection of ChildIConcernePays objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $iConcernePayss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMPays The current object (for fluent API support)
     */
    public function setIConcernePayss(Collection $iConcernePayss, ConnectionInterface $con = null)
    {
        /** @var ChildIConcernePays[] $iConcernePayssToDelete */
        $iConcernePayssToDelete = $this->getIConcernePayss(new Criteria(), $con)->diff($iConcernePayss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->iConcernePayssScheduledForDeletion = clone $iConcernePayssToDelete;

        foreach ($iConcernePayssToDelete as $iConcernePaysRemoved) {
            $iConcernePaysRemoved->setPays(null);
        }

        $this->collIConcernePayss = null;
        foreach ($iConcernePayss as $iConcernePays) {
            $this->addIConcernePays($iConcernePays);
        }

        $this->collIConcernePayss = $iConcernePayss;
        $this->collIConcernePayssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related IConcernePays objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related IConcernePays objects.
     * @throws PropelException
     */
    public function countIConcernePayss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIConcernePayssPartial && !$this->isNew();
        if (null === $this->collIConcernePayss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIConcernePayss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getIConcernePayss());
            }

            $query = ChildIConcernePaysQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPays($this)
                ->count($con);
        }

        return count($this->collIConcernePayss);
    }

    /**
     * Method called to associate a ChildIConcernePays object to this object
     * through the ChildIConcernePays foreign key attribute.
     *
     * @param  ChildIConcernePays $l ChildIConcernePays
     * @return $this|\MPays The current object (for fluent API support)
     */
    public function addIConcernePays(ChildIConcernePays $l)
    {
        if ($this->collIConcernePayss === null) {
            $this->initIConcernePayss();
            $this->collIConcernePayssPartial = true;
        }

        if (!$this->collIConcernePayss->contains($l)) {
            $this->doAddIConcernePays($l);
        }

        return $this;
    }

    /**
     * @param ChildIConcernePays $iConcernePays The ChildIConcernePays object to add.
     */
    protected function doAddIConcernePays(ChildIConcernePays $iConcernePays)
    {
        $this->collIConcernePayss[]= $iConcernePays;
        $iConcernePays->setPays($this);
    }

    /**
     * @param  ChildIConcernePays $iConcernePays The ChildIConcernePays object to remove.
     * @return $this|ChildMPays The current object (for fluent API support)
     */
    public function removeIConcernePays(ChildIConcernePays $iConcernePays)
    {
        if ($this->getIConcernePayss()->contains($iConcernePays)) {
            $pos = $this->collIConcernePayss->search($iConcernePays);
            $this->collIConcernePayss->remove($pos);
            if (null === $this->iConcernePayssScheduledForDeletion) {
                $this->iConcernePayssScheduledForDeletion = clone $this->collIConcernePayss;
                $this->iConcernePayssScheduledForDeletion->clear();
            }
            $this->iConcernePayssScheduledForDeletion[]= clone $iConcernePays;
            $iConcernePays->setPays(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this MPays is new, it will return
     * an empty collection; or if this MPays has previously
     * been saved, it will retrieve related IConcernePayss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in MPays.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIConcernePays[] List of ChildIConcernePays objects
     */
    public function getIConcernePayssJoinFPartenaire(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIConcernePaysQuery::create(null, $criteria);
        $query->joinWith('FPartenaire', $joinBehavior);

        return $this->getIConcernePayss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->pays = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collSocietes) {
                foreach ($this->collSocietes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIConcernePayss) {
                foreach ($this->collIConcernePayss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSocietes = null;
        $this->collIConcernePayss = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MPaysTableMap::DEFAULT_STRING_FORMAT);
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
