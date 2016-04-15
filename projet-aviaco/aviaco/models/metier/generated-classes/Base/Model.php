<?php

namespace Base;

use \Appareil as ChildAppareil;
use \AppareilQuery as ChildAppareilQuery;
use \Marque as ChildMarque;
use \MarqueQuery as ChildMarqueQuery;
use \Model as ChildModel;
use \ModelQuery as ChildModelQuery;
use \Photoappareil as ChildPhotoappareil;
use \PhotoappareilQuery as ChildPhotoappareilQuery;
use \PieceApp as ChildPieceApp;
use \PieceAppQuery as ChildPieceAppQuery;
use \Exception;
use \PDO;
use Map\ModelTableMap;
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
 * Base class that represents a row from the 'modele' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Model implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ModelTableMap';


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
     * The value for the modele field.
     * @var        string
     */
    protected $modele;

    /**
     * The value for the marque_fk field.
     * @var        string
     */
    protected $marque_fk;

    /**
     * @var        ChildMarque
     */
    protected $aMarque;

    /**
     * @var        ObjectCollection|ChildAppareil[] Collection to store aggregation of ChildAppareil objects.
     */
    protected $collAppareils;
    protected $collAppareilsPartial;

    /**
     * @var        ObjectCollection|ChildPieceApp[] Collection to store aggregation of ChildPieceApp objects.
     */
    protected $collPieceApps;
    protected $collPieceAppsPartial;

    /**
     * @var        ObjectCollection|ChildPhotoappareil[] Collection to store aggregation of ChildPhotoappareil objects.
     */
    protected $collPhotoappareils;
    protected $collPhotoappareilsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAppareil[]
     */
    protected $appareilsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPieceApp[]
     */
    protected $pieceAppsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPhotoappareil[]
     */
    protected $photoappareilsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Model object.
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
     * Compares this with another <code>Model</code> instance.  If
     * <code>obj</code> is an instance of <code>Model</code>, delegates to
     * <code>equals(Model)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Model The current object, for fluid interface
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
     * Get the [modele] column value.
     *
     * @return string
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Get the [marque_fk] column value.
     *
     * @return string
     */
    public function getMarque_FK()
    {
        return $this->marque_fk;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Model The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ModelTableMap::COL_ID] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [modele] column.
     *
     * @param string $v new value
     * @return $this|\Model The current object (for fluent API support)
     */
    public function setModele($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->modele !== $v) {
            $this->modele = $v;
            $this->modifiedColumns[ModelTableMap::COL_MODELE] = true;
        }

        return $this;
    } // setModele()

    /**
     * Set the value of [marque_fk] column.
     *
     * @param string $v new value
     * @return $this|\Model The current object (for fluent API support)
     */
    public function setMarque_FK($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->marque_fk !== $v) {
            $this->marque_fk = $v;
            $this->modifiedColumns[ModelTableMap::COL_MARQUE_FK] = true;
        }

        if ($this->aMarque !== null && $this->aMarque->getMarque() !== $v) {
            $this->aMarque = null;
        }

        return $this;
    } // setMarque_FK()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ModelTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ModelTableMap::translateFieldName('Modele', TableMap::TYPE_PHPNAME, $indexType)];
            $this->modele = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ModelTableMap::translateFieldName('Marque_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->marque_fk = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = ModelTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model'), 0, $e);
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
        if ($this->aMarque !== null && $this->marque_fk !== $this->aMarque->getMarque()) {
            $this->aMarque = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(ModelTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildModelQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMarque = null;
            $this->collAppareils = null;

            $this->collPieceApps = null;

            $this->collPhotoappareils = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Model::setDeleted()
     * @see Model::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ModelTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildModelQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ModelTableMap::DATABASE_NAME);
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
                ModelTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aMarque !== null) {
                if ($this->aMarque->isModified() || $this->aMarque->isNew()) {
                    $affectedRows += $this->aMarque->save($con);
                }
                $this->setMarque($this->aMarque);
            }

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

            if ($this->appareilsScheduledForDeletion !== null) {
                if (!$this->appareilsScheduledForDeletion->isEmpty()) {
                    \AppareilQuery::create()
                        ->filterByPrimaryKeys($this->appareilsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->appareilsScheduledForDeletion = null;
                }
            }

            if ($this->collAppareils !== null) {
                foreach ($this->collAppareils as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pieceAppsScheduledForDeletion !== null) {
                if (!$this->pieceAppsScheduledForDeletion->isEmpty()) {
                    \PieceAppQuery::create()
                        ->filterByPrimaryKeys($this->pieceAppsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pieceAppsScheduledForDeletion = null;
                }
            }

            if ($this->collPieceApps !== null) {
                foreach ($this->collPieceApps as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->photoappareilsScheduledForDeletion !== null) {
                if (!$this->photoappareilsScheduledForDeletion->isEmpty()) {
                    \PhotoappareilQuery::create()
                        ->filterByPrimaryKeys($this->photoappareilsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->photoappareilsScheduledForDeletion = null;
                }
            }

            if ($this->collPhotoappareils !== null) {
                foreach ($this->collPhotoappareils as $referrerFK) {
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

        $this->modifiedColumns[ModelTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ModelTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ModelTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ModelTableMap::COL_MODELE)) {
            $modifiedColumns[':p' . $index++]  = 'modele';
        }
        if ($this->isColumnModified(ModelTableMap::COL_MARQUE_FK)) {
            $modifiedColumns[':p' . $index++]  = 'marque_FK';
        }

        $sql = sprintf(
            'INSERT INTO modele (%s) VALUES (%s)',
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
                    case 'modele':
                        $stmt->bindValue($identifier, $this->modele, PDO::PARAM_STR);
                        break;
                    case 'marque_FK':
                        $stmt->bindValue($identifier, $this->marque_fk, PDO::PARAM_STR);
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
        $pos = ModelTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getModele();
                break;
            case 2:
                return $this->getMarque_FK();
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

        if (isset($alreadyDumpedObjects['Model'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Model'][$this->hashCode()] = true;
        $keys = ModelTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getModele(),
            $keys[2] => $this->getMarque_FK(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aMarque) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'marque';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'marque';
                        break;
                    default:
                        $key = 'Marque';
                }

                $result[$key] = $this->aMarque->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAppareils) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'appareils';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'appareils';
                        break;
                    default:
                        $key = 'Appareils';
                }

                $result[$key] = $this->collAppareils->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPieceApps) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pieceApps';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'piece_appareils';
                        break;
                    default:
                        $key = 'PieceApps';
                }

                $result[$key] = $this->collPieceApps->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPhotoappareils) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'photoappareils';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'photo_appareils';
                        break;
                    default:
                        $key = 'Photoappareils';
                }

                $result[$key] = $this->collPhotoappareils->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Model
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ModelTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setID($value);
                break;
            case 1:
                $this->setModele($value);
                break;
            case 2:
                $this->setMarque_FK($value);
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
        $keys = ModelTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setModele($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setMarque_FK($arr[$keys[2]]);
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
     * @return $this|\Model The current object, for fluid interface
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
        $criteria = new Criteria(ModelTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ModelTableMap::COL_ID)) {
            $criteria->add(ModelTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ModelTableMap::COL_MODELE)) {
            $criteria->add(ModelTableMap::COL_MODELE, $this->modele);
        }
        if ($this->isColumnModified(ModelTableMap::COL_MARQUE_FK)) {
            $criteria->add(ModelTableMap::COL_MARQUE_FK, $this->marque_fk);
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
        $criteria = ChildModelQuery::create();
        $criteria->add(ModelTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Model (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setModele($this->getModele());
        $copyObj->setMarque_FK($this->getMarque_FK());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAppareils() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAppareil($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPieceApps() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPieceApp($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPhotoappareils() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPhotoappareil($relObj->copy($deepCopy));
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
     * @return \Model Clone of current object.
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
     * Declares an association between this object and a ChildMarque object.
     *
     * @param  ChildMarque $v
     * @return $this|\Model The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMarque(ChildMarque $v = null)
    {
        if ($v === null) {
            $this->setMarque_FK(NULL);
        } else {
            $this->setMarque_FK($v->getMarque());
        }

        $this->aMarque = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMarque object, it will not be re-added.
        if ($v !== null) {
            $v->addModele($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMarque object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildMarque The associated ChildMarque object.
     * @throws PropelException
     */
    public function getMarque(ConnectionInterface $con = null)
    {
        if ($this->aMarque === null && (($this->marque_fk !== "" && $this->marque_fk !== null))) {
            $this->aMarque = ChildMarqueQuery::create()
                ->filterByModele($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMarque->addModeles($this);
             */
        }

        return $this->aMarque;
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
        if ('Appareil' == $relationName) {
            return $this->initAppareils();
        }
        if ('PieceApp' == $relationName) {
            return $this->initPieceApps();
        }
        if ('Photoappareil' == $relationName) {
            return $this->initPhotoappareils();
        }
    }

    /**
     * Clears out the collAppareils collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAppareils()
     */
    public function clearAppareils()
    {
        $this->collAppareils = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAppareils collection loaded partially.
     */
    public function resetPartialAppareils($v = true)
    {
        $this->collAppareilsPartial = $v;
    }

    /**
     * Initializes the collAppareils collection.
     *
     * By default this just sets the collAppareils collection to an empty array (like clearcollAppareils());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAppareils($overrideExisting = true)
    {
        if (null !== $this->collAppareils && !$overrideExisting) {
            return;
        }
        $this->collAppareils = new ObjectCollection();
        $this->collAppareils->setModel('\Appareil');
    }

    /**
     * Gets an array of ChildAppareil objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildModel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAppareil[] List of ChildAppareil objects
     * @throws PropelException
     */
    public function getAppareils(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAppareilsPartial && !$this->isNew();
        if (null === $this->collAppareils || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAppareils) {
                // return empty collection
                $this->initAppareils();
            } else {
                $collAppareils = ChildAppareilQuery::create(null, $criteria)
                    ->filterByModele($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAppareilsPartial && count($collAppareils)) {
                        $this->initAppareils(false);

                        foreach ($collAppareils as $obj) {
                            if (false == $this->collAppareils->contains($obj)) {
                                $this->collAppareils->append($obj);
                            }
                        }

                        $this->collAppareilsPartial = true;
                    }

                    return $collAppareils;
                }

                if ($partial && $this->collAppareils) {
                    foreach ($this->collAppareils as $obj) {
                        if ($obj->isNew()) {
                            $collAppareils[] = $obj;
                        }
                    }
                }

                $this->collAppareils = $collAppareils;
                $this->collAppareilsPartial = false;
            }
        }

        return $this->collAppareils;
    }

    /**
     * Sets a collection of ChildAppareil objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $appareils A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildModel The current object (for fluent API support)
     */
    public function setAppareils(Collection $appareils, ConnectionInterface $con = null)
    {
        /** @var ChildAppareil[] $appareilsToDelete */
        $appareilsToDelete = $this->getAppareils(new Criteria(), $con)->diff($appareils);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->appareilsScheduledForDeletion = clone $appareilsToDelete;

        foreach ($appareilsToDelete as $appareilRemoved) {
            $appareilRemoved->setModele(null);
        }

        $this->collAppareils = null;
        foreach ($appareils as $appareil) {
            $this->addAppareil($appareil);
        }

        $this->collAppareils = $appareils;
        $this->collAppareilsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Appareil objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Appareil objects.
     * @throws PropelException
     */
    public function countAppareils(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAppareilsPartial && !$this->isNew();
        if (null === $this->collAppareils || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAppareils) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAppareils());
            }

            $query = ChildAppareilQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByModele($this)
                ->count($con);
        }

        return count($this->collAppareils);
    }

    /**
     * Method called to associate a ChildAppareil object to this object
     * through the ChildAppareil foreign key attribute.
     *
     * @param  ChildAppareil $l ChildAppareil
     * @return $this|\Model The current object (for fluent API support)
     */
    public function addAppareil(ChildAppareil $l)
    {
        if ($this->collAppareils === null) {
            $this->initAppareils();
            $this->collAppareilsPartial = true;
        }

        if (!$this->collAppareils->contains($l)) {
            $this->doAddAppareil($l);
        }

        return $this;
    }

    /**
     * @param ChildAppareil $appareil The ChildAppareil object to add.
     */
    protected function doAddAppareil(ChildAppareil $appareil)
    {
        $this->collAppareils[]= $appareil;
        $appareil->setModele($this);
    }

    /**
     * @param  ChildAppareil $appareil The ChildAppareil object to remove.
     * @return $this|ChildModel The current object (for fluent API support)
     */
    public function removeAppareil(ChildAppareil $appareil)
    {
        if ($this->getAppareils()->contains($appareil)) {
            $pos = $this->collAppareils->search($appareil);
            $this->collAppareils->remove($pos);
            if (null === $this->appareilsScheduledForDeletion) {
                $this->appareilsScheduledForDeletion = clone $this->collAppareils;
                $this->appareilsScheduledForDeletion->clear();
            }
            $this->appareilsScheduledForDeletion[]= clone $appareil;
            $appareil->setModele(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Model is new, it will return
     * an empty collection; or if this Model has previously
     * been saved, it will retrieve related Appareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Model.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAppareil[] List of ChildAppareil objects
     */
    public function getAppareilsJoinMarque(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAppareilQuery::create(null, $criteria);
        $query->joinWith('Marque', $joinBehavior);

        return $this->getAppareils($query, $con);
    }

    /**
     * Clears out the collPieceApps collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPieceApps()
     */
    public function clearPieceApps()
    {
        $this->collPieceApps = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPieceApps collection loaded partially.
     */
    public function resetPartialPieceApps($v = true)
    {
        $this->collPieceAppsPartial = $v;
    }

    /**
     * Initializes the collPieceApps collection.
     *
     * By default this just sets the collPieceApps collection to an empty array (like clearcollPieceApps());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPieceApps($overrideExisting = true)
    {
        if (null !== $this->collPieceApps && !$overrideExisting) {
            return;
        }
        $this->collPieceApps = new ObjectCollection();
        $this->collPieceApps->setModel('\PieceApp');
    }

    /**
     * Gets an array of ChildPieceApp objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildModel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPieceApp[] List of ChildPieceApp objects
     * @throws PropelException
     */
    public function getPieceApps(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPieceAppsPartial && !$this->isNew();
        if (null === $this->collPieceApps || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPieceApps) {
                // return empty collection
                $this->initPieceApps();
            } else {
                $collPieceApps = ChildPieceAppQuery::create(null, $criteria)
                    ->filterByModele($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPieceAppsPartial && count($collPieceApps)) {
                        $this->initPieceApps(false);

                        foreach ($collPieceApps as $obj) {
                            if (false == $this->collPieceApps->contains($obj)) {
                                $this->collPieceApps->append($obj);
                            }
                        }

                        $this->collPieceAppsPartial = true;
                    }

                    return $collPieceApps;
                }

                if ($partial && $this->collPieceApps) {
                    foreach ($this->collPieceApps as $obj) {
                        if ($obj->isNew()) {
                            $collPieceApps[] = $obj;
                        }
                    }
                }

                $this->collPieceApps = $collPieceApps;
                $this->collPieceAppsPartial = false;
            }
        }

        return $this->collPieceApps;
    }

    /**
     * Sets a collection of ChildPieceApp objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pieceApps A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildModel The current object (for fluent API support)
     */
    public function setPieceApps(Collection $pieceApps, ConnectionInterface $con = null)
    {
        /** @var ChildPieceApp[] $pieceAppsToDelete */
        $pieceAppsToDelete = $this->getPieceApps(new Criteria(), $con)->diff($pieceApps);


        $this->pieceAppsScheduledForDeletion = $pieceAppsToDelete;

        foreach ($pieceAppsToDelete as $pieceAppRemoved) {
            $pieceAppRemoved->setModele(null);
        }

        $this->collPieceApps = null;
        foreach ($pieceApps as $pieceApp) {
            $this->addPieceApp($pieceApp);
        }

        $this->collPieceApps = $pieceApps;
        $this->collPieceAppsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PieceApp objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PieceApp objects.
     * @throws PropelException
     */
    public function countPieceApps(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPieceAppsPartial && !$this->isNew();
        if (null === $this->collPieceApps || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPieceApps) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPieceApps());
            }

            $query = ChildPieceAppQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByModele($this)
                ->count($con);
        }

        return count($this->collPieceApps);
    }

    /**
     * Method called to associate a ChildPieceApp object to this object
     * through the ChildPieceApp foreign key attribute.
     *
     * @param  ChildPieceApp $l ChildPieceApp
     * @return $this|\Model The current object (for fluent API support)
     */
    public function addPieceApp(ChildPieceApp $l)
    {
        if ($this->collPieceApps === null) {
            $this->initPieceApps();
            $this->collPieceAppsPartial = true;
        }

        if (!$this->collPieceApps->contains($l)) {
            $this->doAddPieceApp($l);
        }

        return $this;
    }

    /**
     * @param ChildPieceApp $pieceApp The ChildPieceApp object to add.
     */
    protected function doAddPieceApp(ChildPieceApp $pieceApp)
    {
        $this->collPieceApps[]= $pieceApp;
        $pieceApp->setModele($this);
    }

    /**
     * @param  ChildPieceApp $pieceApp The ChildPieceApp object to remove.
     * @return $this|ChildModel The current object (for fluent API support)
     */
    public function removePieceApp(ChildPieceApp $pieceApp)
    {
        if ($this->getPieceApps()->contains($pieceApp)) {
            $pos = $this->collPieceApps->search($pieceApp);
            $this->collPieceApps->remove($pos);
            if (null === $this->pieceAppsScheduledForDeletion) {
                $this->pieceAppsScheduledForDeletion = clone $this->collPieceApps;
                $this->pieceAppsScheduledForDeletion->clear();
            }
            $this->pieceAppsScheduledForDeletion[]= $pieceApp;
            $pieceApp->setModele(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Model is new, it will return
     * an empty collection; or if this Model has previously
     * been saved, it will retrieve related PieceApps from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Model.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPieceApp[] List of ChildPieceApp objects
     */
    public function getPieceAppsJoinAppareil(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPieceAppQuery::create(null, $criteria);
        $query->joinWith('Appareil', $joinBehavior);

        return $this->getPieceApps($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Model is new, it will return
     * an empty collection; or if this Model has previously
     * been saved, it will retrieve related PieceApps from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Model.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPieceApp[] List of ChildPieceApp objects
     */
    public function getPieceAppsJoinMarque(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPieceAppQuery::create(null, $criteria);
        $query->joinWith('Marque', $joinBehavior);

        return $this->getPieceApps($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Model is new, it will return
     * an empty collection; or if this Model has previously
     * been saved, it will retrieve related PieceApps from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Model.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPieceApp[] List of ChildPieceApp objects
     */
    public function getPieceAppsJoinPiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPieceAppQuery::create(null, $criteria);
        $query->joinWith('Piece', $joinBehavior);

        return $this->getPieceApps($query, $con);
    }

    /**
     * Clears out the collPhotoappareils collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPhotoappareils()
     */
    public function clearPhotoappareils()
    {
        $this->collPhotoappareils = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPhotoappareils collection loaded partially.
     */
    public function resetPartialPhotoappareils($v = true)
    {
        $this->collPhotoappareilsPartial = $v;
    }

    /**
     * Initializes the collPhotoappareils collection.
     *
     * By default this just sets the collPhotoappareils collection to an empty array (like clearcollPhotoappareils());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPhotoappareils($overrideExisting = true)
    {
        if (null !== $this->collPhotoappareils && !$overrideExisting) {
            return;
        }
        $this->collPhotoappareils = new ObjectCollection();
        $this->collPhotoappareils->setModel('\Photoappareil');
    }

    /**
     * Gets an array of ChildPhotoappareil objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildModel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPhotoappareil[] List of ChildPhotoappareil objects
     * @throws PropelException
     */
    public function getPhotoappareils(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPhotoappareilsPartial && !$this->isNew();
        if (null === $this->collPhotoappareils || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPhotoappareils) {
                // return empty collection
                $this->initPhotoappareils();
            } else {
                $collPhotoappareils = ChildPhotoappareilQuery::create(null, $criteria)
                    ->filterByModele($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPhotoappareilsPartial && count($collPhotoappareils)) {
                        $this->initPhotoappareils(false);

                        foreach ($collPhotoappareils as $obj) {
                            if (false == $this->collPhotoappareils->contains($obj)) {
                                $this->collPhotoappareils->append($obj);
                            }
                        }

                        $this->collPhotoappareilsPartial = true;
                    }

                    return $collPhotoappareils;
                }

                if ($partial && $this->collPhotoappareils) {
                    foreach ($this->collPhotoappareils as $obj) {
                        if ($obj->isNew()) {
                            $collPhotoappareils[] = $obj;
                        }
                    }
                }

                $this->collPhotoappareils = $collPhotoappareils;
                $this->collPhotoappareilsPartial = false;
            }
        }

        return $this->collPhotoappareils;
    }

    /**
     * Sets a collection of ChildPhotoappareil objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $photoappareils A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildModel The current object (for fluent API support)
     */
    public function setPhotoappareils(Collection $photoappareils, ConnectionInterface $con = null)
    {
        /** @var ChildPhotoappareil[] $photoappareilsToDelete */
        $photoappareilsToDelete = $this->getPhotoappareils(new Criteria(), $con)->diff($photoappareils);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->photoappareilsScheduledForDeletion = clone $photoappareilsToDelete;

        foreach ($photoappareilsToDelete as $photoappareilRemoved) {
            $photoappareilRemoved->setModele(null);
        }

        $this->collPhotoappareils = null;
        foreach ($photoappareils as $photoappareil) {
            $this->addPhotoappareil($photoappareil);
        }

        $this->collPhotoappareils = $photoappareils;
        $this->collPhotoappareilsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Photoappareil objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Photoappareil objects.
     * @throws PropelException
     */
    public function countPhotoappareils(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPhotoappareilsPartial && !$this->isNew();
        if (null === $this->collPhotoappareils || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPhotoappareils) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPhotoappareils());
            }

            $query = ChildPhotoappareilQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByModele($this)
                ->count($con);
        }

        return count($this->collPhotoappareils);
    }

    /**
     * Method called to associate a ChildPhotoappareil object to this object
     * through the ChildPhotoappareil foreign key attribute.
     *
     * @param  ChildPhotoappareil $l ChildPhotoappareil
     * @return $this|\Model The current object (for fluent API support)
     */
    public function addPhotoappareil(ChildPhotoappareil $l)
    {
        if ($this->collPhotoappareils === null) {
            $this->initPhotoappareils();
            $this->collPhotoappareilsPartial = true;
        }

        if (!$this->collPhotoappareils->contains($l)) {
            $this->doAddPhotoappareil($l);
        }

        return $this;
    }

    /**
     * @param ChildPhotoappareil $photoappareil The ChildPhotoappareil object to add.
     */
    protected function doAddPhotoappareil(ChildPhotoappareil $photoappareil)
    {
        $this->collPhotoappareils[]= $photoappareil;
        $photoappareil->setModele($this);
    }

    /**
     * @param  ChildPhotoappareil $photoappareil The ChildPhotoappareil object to remove.
     * @return $this|ChildModel The current object (for fluent API support)
     */
    public function removePhotoappareil(ChildPhotoappareil $photoappareil)
    {
        if ($this->getPhotoappareils()->contains($photoappareil)) {
            $pos = $this->collPhotoappareils->search($photoappareil);
            $this->collPhotoappareils->remove($pos);
            if (null === $this->photoappareilsScheduledForDeletion) {
                $this->photoappareilsScheduledForDeletion = clone $this->collPhotoappareils;
                $this->photoappareilsScheduledForDeletion->clear();
            }
            $this->photoappareilsScheduledForDeletion[]= clone $photoappareil;
            $photoappareil->setModele(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Model is new, it will return
     * an empty collection; or if this Model has previously
     * been saved, it will retrieve related Photoappareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Model.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPhotoappareil[] List of ChildPhotoappareil objects
     */
    public function getPhotoappareilsJoinAppareil(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPhotoappareilQuery::create(null, $criteria);
        $query->joinWith('Appareil', $joinBehavior);

        return $this->getPhotoappareils($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Model is new, it will return
     * an empty collection; or if this Model has previously
     * been saved, it will retrieve related Photoappareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Model.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPhotoappareil[] List of ChildPhotoappareil objects
     */
    public function getPhotoappareilsJoinMarque(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPhotoappareilQuery::create(null, $criteria);
        $query->joinWith('Marque', $joinBehavior);

        return $this->getPhotoappareils($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aMarque) {
            $this->aMarque->removeModele($this);
        }
        $this->id = null;
        $this->modele = null;
        $this->marque_fk = null;
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
            if ($this->collAppareils) {
                foreach ($this->collAppareils as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPieceApps) {
                foreach ($this->collPieceApps as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPhotoappareils) {
                foreach ($this->collPhotoappareils as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAppareils = null;
        $this->collPieceApps = null;
        $this->collPhotoappareils = null;
        $this->aMarque = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ModelTableMap::DEFAULT_STRING_FORMAT);
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
