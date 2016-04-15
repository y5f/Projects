<?php

namespace Base;

use \COMCondition as ChildCOMCondition;
use \COMConditionQuery as ChildCOMConditionQuery;
use \Condition as ChildCondition;
use \ConditionQuery as ChildConditionQuery;
use \Fournisseur as ChildFournisseur;
use \FournisseurQuery as ChildFournisseurQuery;
use \Exception;
use \PDO;
use Map\ConditionTableMap;
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
 * Base class that represents a row from the 'cond' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Condition implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ConditionTableMap';


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
     * The value for the cond field.
     * @var        string
     */
    protected $cond;

    /**
     * The value for the commentaire field.
     * @var        string
     */
    protected $commentaire;

    /**
     * @var        ObjectCollection|ChildFournisseur[] Collection to store aggregation of ChildFournisseur objects.
     */
    protected $collFournisseurs;
    protected $collFournisseursPartial;

    /**
     * @var        ObjectCollection|ChildCOMCondition[] Collection to store aggregation of ChildCOMCondition objects.
     */
    protected $collCOMConditions;
    protected $collCOMConditionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFournisseur[]
     */
    protected $fournisseursScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCOMCondition[]
     */
    protected $cOMConditionsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Condition object.
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
     * Compares this with another <code>Condition</code> instance.  If
     * <code>obj</code> is an instance of <code>Condition</code>, delegates to
     * <code>equals(Condition)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Condition The current object, for fluid interface
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
     * Get the [cond] column value.
     *
     * @return string
     */
    public function getCondition()
    {
        return $this->cond;
    }

    /**
     * Get the [commentaire] column value.
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set the value of [cond] column.
     *
     * @param string $v new value
     * @return $this|\Condition The current object (for fluent API support)
     */
    public function setCondition($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cond !== $v) {
            $this->cond = $v;
            $this->modifiedColumns[ConditionTableMap::COL_COND] = true;
        }

        return $this;
    } // setCondition()

    /**
     * Set the value of [commentaire] column.
     *
     * @param string $v new value
     * @return $this|\Condition The current object (for fluent API support)
     */
    public function setCommentaire($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->commentaire !== $v) {
            $this->commentaire = $v;
            $this->modifiedColumns[ConditionTableMap::COL_COMMENTAIRE] = true;
        }

        return $this;
    } // setCommentaire()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ConditionTableMap::translateFieldName('Condition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cond = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ConditionTableMap::translateFieldName('Commentaire', TableMap::TYPE_PHPNAME, $indexType)];
            $this->commentaire = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = ConditionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Condition'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ConditionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildConditionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collFournisseurs = null;

            $this->collCOMConditions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Condition::setDeleted()
     * @see Condition::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConditionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildConditionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConditionTableMap::DATABASE_NAME);
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
                ConditionTableMap::addInstanceToPool($this);
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

            if ($this->fournisseursScheduledForDeletion !== null) {
                if (!$this->fournisseursScheduledForDeletion->isEmpty()) {
                    \FournisseurQuery::create()
                        ->filterByPrimaryKeys($this->fournisseursScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->fournisseursScheduledForDeletion = null;
                }
            }

            if ($this->collFournisseurs !== null) {
                foreach ($this->collFournisseurs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cOMConditionsScheduledForDeletion !== null) {
                if (!$this->cOMConditionsScheduledForDeletion->isEmpty()) {
                    \COMConditionQuery::create()
                        ->filterByPrimaryKeys($this->cOMConditionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cOMConditionsScheduledForDeletion = null;
                }
            }

            if ($this->collCOMConditions !== null) {
                foreach ($this->collCOMConditions as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ConditionTableMap::COL_COND)) {
            $modifiedColumns[':p' . $index++]  = 'cond';
        }
        if ($this->isColumnModified(ConditionTableMap::COL_COMMENTAIRE)) {
            $modifiedColumns[':p' . $index++]  = 'commentaire';
        }

        $sql = sprintf(
            'INSERT INTO cond (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'cond':
                        $stmt->bindValue($identifier, $this->cond, PDO::PARAM_STR);
                        break;
                    case 'commentaire':
                        $stmt->bindValue($identifier, $this->commentaire, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = ConditionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCondition();
                break;
            case 1:
                return $this->getCommentaire();
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

        if (isset($alreadyDumpedObjects['Condition'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Condition'][$this->hashCode()] = true;
        $keys = ConditionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCondition(),
            $keys[1] => $this->getCommentaire(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collFournisseurs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fournisseurs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fournisseurs';
                        break;
                    default:
                        $key = 'Fournisseurs';
                }

                $result[$key] = $this->collFournisseurs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCOMConditions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cOMConditions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'commande_conditions';
                        break;
                    default:
                        $key = 'COMConditions';
                }

                $result[$key] = $this->collCOMConditions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Condition
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ConditionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Condition
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCondition($value);
                break;
            case 1:
                $this->setCommentaire($value);
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
        $keys = ConditionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setCondition($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCommentaire($arr[$keys[1]]);
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
     * @return $this|\Condition The current object, for fluid interface
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
        $criteria = new Criteria(ConditionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ConditionTableMap::COL_COND)) {
            $criteria->add(ConditionTableMap::COL_COND, $this->cond);
        }
        if ($this->isColumnModified(ConditionTableMap::COL_COMMENTAIRE)) {
            $criteria->add(ConditionTableMap::COL_COMMENTAIRE, $this->commentaire);
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
        $criteria = ChildConditionQuery::create();
        $criteria->add(ConditionTableMap::COL_COND, $this->cond);

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
        $validPk = null !== $this->getCondition();

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
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getCondition();
    }

    /**
     * Generic method to set the primary key (cond column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCondition($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getCondition();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Condition (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCondition($this->getCondition());
        $copyObj->setCommentaire($this->getCommentaire());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getFournisseurs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFournisseur($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCOMConditions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCOMCondition($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \Condition Clone of current object.
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
        if ('Fournisseur' == $relationName) {
            return $this->initFournisseurs();
        }
        if ('COMCondition' == $relationName) {
            return $this->initCOMConditions();
        }
    }

    /**
     * Clears out the collFournisseurs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFournisseurs()
     */
    public function clearFournisseurs()
    {
        $this->collFournisseurs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFournisseurs collection loaded partially.
     */
    public function resetPartialFournisseurs($v = true)
    {
        $this->collFournisseursPartial = $v;
    }

    /**
     * Initializes the collFournisseurs collection.
     *
     * By default this just sets the collFournisseurs collection to an empty array (like clearcollFournisseurs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFournisseurs($overrideExisting = true)
    {
        if (null !== $this->collFournisseurs && !$overrideExisting) {
            return;
        }
        $this->collFournisseurs = new ObjectCollection();
        $this->collFournisseurs->setModel('\Fournisseur');
    }

    /**
     * Gets an array of ChildFournisseur objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCondition is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFournisseur[] List of ChildFournisseur objects
     * @throws PropelException
     */
    public function getFournisseurs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFournisseursPartial && !$this->isNew();
        if (null === $this->collFournisseurs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFournisseurs) {
                // return empty collection
                $this->initFournisseurs();
            } else {
                $collFournisseurs = ChildFournisseurQuery::create(null, $criteria)
                    ->filterByCondition($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFournisseursPartial && count($collFournisseurs)) {
                        $this->initFournisseurs(false);

                        foreach ($collFournisseurs as $obj) {
                            if (false == $this->collFournisseurs->contains($obj)) {
                                $this->collFournisseurs->append($obj);
                            }
                        }

                        $this->collFournisseursPartial = true;
                    }

                    return $collFournisseurs;
                }

                if ($partial && $this->collFournisseurs) {
                    foreach ($this->collFournisseurs as $obj) {
                        if ($obj->isNew()) {
                            $collFournisseurs[] = $obj;
                        }
                    }
                }

                $this->collFournisseurs = $collFournisseurs;
                $this->collFournisseursPartial = false;
            }
        }

        return $this->collFournisseurs;
    }

    /**
     * Sets a collection of ChildFournisseur objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fournisseurs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCondition The current object (for fluent API support)
     */
    public function setFournisseurs(Collection $fournisseurs, ConnectionInterface $con = null)
    {
        /** @var ChildFournisseur[] $fournisseursToDelete */
        $fournisseursToDelete = $this->getFournisseurs(new Criteria(), $con)->diff($fournisseurs);


        $this->fournisseursScheduledForDeletion = $fournisseursToDelete;

        foreach ($fournisseursToDelete as $fournisseurRemoved) {
            $fournisseurRemoved->setCondition(null);
        }

        $this->collFournisseurs = null;
        foreach ($fournisseurs as $fournisseur) {
            $this->addFournisseur($fournisseur);
        }

        $this->collFournisseurs = $fournisseurs;
        $this->collFournisseursPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Fournisseur objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Fournisseur objects.
     * @throws PropelException
     */
    public function countFournisseurs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFournisseursPartial && !$this->isNew();
        if (null === $this->collFournisseurs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFournisseurs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFournisseurs());
            }

            $query = ChildFournisseurQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCondition($this)
                ->count($con);
        }

        return count($this->collFournisseurs);
    }

    /**
     * Method called to associate a ChildFournisseur object to this object
     * through the ChildFournisseur foreign key attribute.
     *
     * @param  ChildFournisseur $l ChildFournisseur
     * @return $this|\Condition The current object (for fluent API support)
     */
    public function addFournisseur(ChildFournisseur $l)
    {
        if ($this->collFournisseurs === null) {
            $this->initFournisseurs();
            $this->collFournisseursPartial = true;
        }

        if (!$this->collFournisseurs->contains($l)) {
            $this->doAddFournisseur($l);
        }

        return $this;
    }

    /**
     * @param ChildFournisseur $fournisseur The ChildFournisseur object to add.
     */
    protected function doAddFournisseur(ChildFournisseur $fournisseur)
    {
        $this->collFournisseurs[]= $fournisseur;
        $fournisseur->setCondition($this);
    }

    /**
     * @param  ChildFournisseur $fournisseur The ChildFournisseur object to remove.
     * @return $this|ChildCondition The current object (for fluent API support)
     */
    public function removeFournisseur(ChildFournisseur $fournisseur)
    {
        if ($this->getFournisseurs()->contains($fournisseur)) {
            $pos = $this->collFournisseurs->search($fournisseur);
            $this->collFournisseurs->remove($pos);
            if (null === $this->fournisseursScheduledForDeletion) {
                $this->fournisseursScheduledForDeletion = clone $this->collFournisseurs;
                $this->fournisseursScheduledForDeletion->clear();
            }
            $this->fournisseursScheduledForDeletion[]= $fournisseur;
            $fournisseur->setCondition(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Condition is new, it will return
     * an empty collection; or if this Condition has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Condition.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFournisseur[] List of ChildFournisseur objects
     */
    public function getFournisseursJoinPiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFournisseurQuery::create(null, $criteria);
        $query->joinWith('Piece', $joinBehavior);

        return $this->getFournisseurs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Condition is new, it will return
     * an empty collection; or if this Condition has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Condition.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFournisseur[] List of ChildFournisseur objects
     */
    public function getFournisseursJoinSociete(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFournisseurQuery::create(null, $criteria);
        $query->joinWith('Societe', $joinBehavior);

        return $this->getFournisseurs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Condition is new, it will return
     * an empty collection; or if this Condition has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Condition.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFournisseur[] List of ChildFournisseur objects
     */
    public function getFournisseursJoinMTransport(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFournisseurQuery::create(null, $criteria);
        $query->joinWith('MTransport', $joinBehavior);

        return $this->getFournisseurs($query, $con);
    }

    /**
     * Clears out the collCOMConditions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCOMConditions()
     */
    public function clearCOMConditions()
    {
        $this->collCOMConditions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCOMConditions collection loaded partially.
     */
    public function resetPartialCOMConditions($v = true)
    {
        $this->collCOMConditionsPartial = $v;
    }

    /**
     * Initializes the collCOMConditions collection.
     *
     * By default this just sets the collCOMConditions collection to an empty array (like clearcollCOMConditions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCOMConditions($overrideExisting = true)
    {
        if (null !== $this->collCOMConditions && !$overrideExisting) {
            return;
        }
        $this->collCOMConditions = new ObjectCollection();
        $this->collCOMConditions->setModel('\COMCondition');
    }

    /**
     * Gets an array of ChildCOMCondition objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCondition is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCOMCondition[] List of ChildCOMCondition objects
     * @throws PropelException
     */
    public function getCOMConditions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCOMConditionsPartial && !$this->isNew();
        if (null === $this->collCOMConditions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCOMConditions) {
                // return empty collection
                $this->initCOMConditions();
            } else {
                $collCOMConditions = ChildCOMConditionQuery::create(null, $criteria)
                    ->filterByCondition($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCOMConditionsPartial && count($collCOMConditions)) {
                        $this->initCOMConditions(false);

                        foreach ($collCOMConditions as $obj) {
                            if (false == $this->collCOMConditions->contains($obj)) {
                                $this->collCOMConditions->append($obj);
                            }
                        }

                        $this->collCOMConditionsPartial = true;
                    }

                    return $collCOMConditions;
                }

                if ($partial && $this->collCOMConditions) {
                    foreach ($this->collCOMConditions as $obj) {
                        if ($obj->isNew()) {
                            $collCOMConditions[] = $obj;
                        }
                    }
                }

                $this->collCOMConditions = $collCOMConditions;
                $this->collCOMConditionsPartial = false;
            }
        }

        return $this->collCOMConditions;
    }

    /**
     * Sets a collection of ChildCOMCondition objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cOMConditions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCondition The current object (for fluent API support)
     */
    public function setCOMConditions(Collection $cOMConditions, ConnectionInterface $con = null)
    {
        /** @var ChildCOMCondition[] $cOMConditionsToDelete */
        $cOMConditionsToDelete = $this->getCOMConditions(new Criteria(), $con)->diff($cOMConditions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->cOMConditionsScheduledForDeletion = clone $cOMConditionsToDelete;

        foreach ($cOMConditionsToDelete as $cOMConditionRemoved) {
            $cOMConditionRemoved->setCondition(null);
        }

        $this->collCOMConditions = null;
        foreach ($cOMConditions as $cOMCondition) {
            $this->addCOMCondition($cOMCondition);
        }

        $this->collCOMConditions = $cOMConditions;
        $this->collCOMConditionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related COMCondition objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related COMCondition objects.
     * @throws PropelException
     */
    public function countCOMConditions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCOMConditionsPartial && !$this->isNew();
        if (null === $this->collCOMConditions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCOMConditions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCOMConditions());
            }

            $query = ChildCOMConditionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCondition($this)
                ->count($con);
        }

        return count($this->collCOMConditions);
    }

    /**
     * Method called to associate a ChildCOMCondition object to this object
     * through the ChildCOMCondition foreign key attribute.
     *
     * @param  ChildCOMCondition $l ChildCOMCondition
     * @return $this|\Condition The current object (for fluent API support)
     */
    public function addCOMCondition(ChildCOMCondition $l)
    {
        if ($this->collCOMConditions === null) {
            $this->initCOMConditions();
            $this->collCOMConditionsPartial = true;
        }

        if (!$this->collCOMConditions->contains($l)) {
            $this->doAddCOMCondition($l);
        }

        return $this;
    }

    /**
     * @param ChildCOMCondition $cOMCondition The ChildCOMCondition object to add.
     */
    protected function doAddCOMCondition(ChildCOMCondition $cOMCondition)
    {
        $this->collCOMConditions[]= $cOMCondition;
        $cOMCondition->setCondition($this);
    }

    /**
     * @param  ChildCOMCondition $cOMCondition The ChildCOMCondition object to remove.
     * @return $this|ChildCondition The current object (for fluent API support)
     */
    public function removeCOMCondition(ChildCOMCondition $cOMCondition)
    {
        if ($this->getCOMConditions()->contains($cOMCondition)) {
            $pos = $this->collCOMConditions->search($cOMCondition);
            $this->collCOMConditions->remove($pos);
            if (null === $this->cOMConditionsScheduledForDeletion) {
                $this->cOMConditionsScheduledForDeletion = clone $this->collCOMConditions;
                $this->cOMConditionsScheduledForDeletion->clear();
            }
            $this->cOMConditionsScheduledForDeletion[]= clone $cOMCondition;
            $cOMCondition->setCondition(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Condition is new, it will return
     * an empty collection; or if this Condition has previously
     * been saved, it will retrieve related COMConditions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Condition.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCOMCondition[] List of ChildCOMCondition objects
     */
    public function getCOMConditionsJoinCommande(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCOMConditionQuery::create(null, $criteria);
        $query->joinWith('Commande', $joinBehavior);

        return $this->getCOMConditions($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Condition is new, it will return
     * an empty collection; or if this Condition has previously
     * been saved, it will retrieve related COMConditions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Condition.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCOMCondition[] List of ChildCOMCondition objects
     */
    public function getCOMConditionsJoinPiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCOMConditionQuery::create(null, $criteria);
        $query->joinWith('Piece', $joinBehavior);

        return $this->getCOMConditions($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->cond = null;
        $this->commentaire = null;
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
            if ($this->collFournisseurs) {
                foreach ($this->collFournisseurs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCOMConditions) {
                foreach ($this->collCOMConditions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collFournisseurs = null;
        $this->collCOMConditions = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ConditionTableMap::DEFAULT_STRING_FORMAT);
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
