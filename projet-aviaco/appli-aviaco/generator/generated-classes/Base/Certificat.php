<?php

namespace Base;

use \Appareilcertificat as ChildAppareilcertificat;
use \AppareilcertificatQuery as ChildAppareilcertificatQuery;
use \Certificat as ChildCertificat;
use \CertificatQuery as ChildCertificatQuery;
use \Societecertificat as ChildSocietecertificat;
use \SocietecertificatQuery as ChildSocietecertificatQuery;
use \Exception;
use \PDO;
use Map\CertificatTableMap;
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
 * Base class that represents a row from the 'certificat' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Certificat implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CertificatTableMap';


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
     * The value for the agrement field.
     * @var        string
     */
    protected $agrement;

    /**
     * The value for the srcweb field.
     * @var        string
     */
    protected $srcweb;

    /**
     * @var        ObjectCollection|ChildAppareilcertificat[] Collection to store aggregation of ChildAppareilcertificat objects.
     */
    protected $collAppareilcertificats;
    protected $collAppareilcertificatsPartial;

    /**
     * @var        ObjectCollection|ChildSocietecertificat[] Collection to store aggregation of ChildSocietecertificat objects.
     */
    protected $collSocietecertificats;
    protected $collSocietecertificatsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAppareilcertificat[]
     */
    protected $appareilcertificatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSocietecertificat[]
     */
    protected $societecertificatsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Certificat object.
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
     * Compares this with another <code>Certificat</code> instance.  If
     * <code>obj</code> is an instance of <code>Certificat</code>, delegates to
     * <code>equals(Certificat)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Certificat The current object, for fluid interface
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
     * Get the [agrement] column value.
     *
     * @return string
     */
    public function getAgrement()
    {
        return $this->agrement;
    }

    /**
     * Get the [srcweb] column value.
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->srcweb;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Certificat The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CertificatTableMap::COL_ID] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [agrement] column.
     *
     * @param string $v new value
     * @return $this|\Certificat The current object (for fluent API support)
     */
    public function setAgrement($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->agrement !== $v) {
            $this->agrement = $v;
            $this->modifiedColumns[CertificatTableMap::COL_AGREMENT] = true;
        }

        return $this;
    } // setAgrement()

    /**
     * Set the value of [srcweb] column.
     *
     * @param string $v new value
     * @return $this|\Certificat The current object (for fluent API support)
     */
    public function setWeb($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->srcweb !== $v) {
            $this->srcweb = $v;
            $this->modifiedColumns[CertificatTableMap::COL_SRCWEB] = true;
        }

        return $this;
    } // setWeb()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CertificatTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CertificatTableMap::translateFieldName('Agrement', TableMap::TYPE_PHPNAME, $indexType)];
            $this->agrement = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CertificatTableMap::translateFieldName('Web', TableMap::TYPE_PHPNAME, $indexType)];
            $this->srcweb = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = CertificatTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Certificat'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(CertificatTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCertificatQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAppareilcertificats = null;

            $this->collSocietecertificats = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Certificat::setDeleted()
     * @see Certificat::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CertificatTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCertificatQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CertificatTableMap::DATABASE_NAME);
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
                CertificatTableMap::addInstanceToPool($this);
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

            if ($this->appareilcertificatsScheduledForDeletion !== null) {
                if (!$this->appareilcertificatsScheduledForDeletion->isEmpty()) {
                    \AppareilcertificatQuery::create()
                        ->filterByPrimaryKeys($this->appareilcertificatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->appareilcertificatsScheduledForDeletion = null;
                }
            }

            if ($this->collAppareilcertificats !== null) {
                foreach ($this->collAppareilcertificats as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->societecertificatsScheduledForDeletion !== null) {
                if (!$this->societecertificatsScheduledForDeletion->isEmpty()) {
                    \SocietecertificatQuery::create()
                        ->filterByPrimaryKeys($this->societecertificatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->societecertificatsScheduledForDeletion = null;
                }
            }

            if ($this->collSocietecertificats !== null) {
                foreach ($this->collSocietecertificats as $referrerFK) {
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

        $this->modifiedColumns[CertificatTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CertificatTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CertificatTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(CertificatTableMap::COL_AGREMENT)) {
            $modifiedColumns[':p' . $index++]  = 'agrement';
        }
        if ($this->isColumnModified(CertificatTableMap::COL_SRCWEB)) {
            $modifiedColumns[':p' . $index++]  = 'srcweb';
        }

        $sql = sprintf(
            'INSERT INTO certificat (%s) VALUES (%s)',
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
                    case 'agrement':
                        $stmt->bindValue($identifier, $this->agrement, PDO::PARAM_STR);
                        break;
                    case 'srcweb':
                        $stmt->bindValue($identifier, $this->srcweb, PDO::PARAM_STR);
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
        $pos = CertificatTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAgrement();
                break;
            case 2:
                return $this->getWeb();
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

        if (isset($alreadyDumpedObjects['Certificat'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Certificat'][$this->hashCode()] = true;
        $keys = CertificatTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getAgrement(),
            $keys[2] => $this->getWeb(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAppareilcertificats) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'appareilcertificats';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'appcertificats';
                        break;
                    default:
                        $key = 'Appareilcertificats';
                }

                $result[$key] = $this->collAppareilcertificats->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSocietecertificats) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'societecertificats';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'soccertificats';
                        break;
                    default:
                        $key = 'Societecertificats';
                }

                $result[$key] = $this->collSocietecertificats->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Certificat
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CertificatTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Certificat
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setID($value);
                break;
            case 1:
                $this->setAgrement($value);
                break;
            case 2:
                $this->setWeb($value);
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
        $keys = CertificatTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAgrement($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setWeb($arr[$keys[2]]);
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
     * @return $this|\Certificat The current object, for fluid interface
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
        $criteria = new Criteria(CertificatTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CertificatTableMap::COL_ID)) {
            $criteria->add(CertificatTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CertificatTableMap::COL_AGREMENT)) {
            $criteria->add(CertificatTableMap::COL_AGREMENT, $this->agrement);
        }
        if ($this->isColumnModified(CertificatTableMap::COL_SRCWEB)) {
            $criteria->add(CertificatTableMap::COL_SRCWEB, $this->srcweb);
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
        $criteria = ChildCertificatQuery::create();
        $criteria->add(CertificatTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Certificat (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAgrement($this->getAgrement());
        $copyObj->setWeb($this->getWeb());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAppareilcertificats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAppareilcertificat($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSocietecertificats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSocietecertificat($relObj->copy($deepCopy));
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
     * @return \Certificat Clone of current object.
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
        if ('Appareilcertificat' == $relationName) {
            return $this->initAppareilcertificats();
        }
        if ('Societecertificat' == $relationName) {
            return $this->initSocietecertificats();
        }
    }

    /**
     * Clears out the collAppareilcertificats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAppareilcertificats()
     */
    public function clearAppareilcertificats()
    {
        $this->collAppareilcertificats = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAppareilcertificats collection loaded partially.
     */
    public function resetPartialAppareilcertificats($v = true)
    {
        $this->collAppareilcertificatsPartial = $v;
    }

    /**
     * Initializes the collAppareilcertificats collection.
     *
     * By default this just sets the collAppareilcertificats collection to an empty array (like clearcollAppareilcertificats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAppareilcertificats($overrideExisting = true)
    {
        if (null !== $this->collAppareilcertificats && !$overrideExisting) {
            return;
        }
        $this->collAppareilcertificats = new ObjectCollection();
        $this->collAppareilcertificats->setModel('\Appareilcertificat');
    }

    /**
     * Gets an array of ChildAppareilcertificat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCertificat is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAppareilcertificat[] List of ChildAppareilcertificat objects
     * @throws PropelException
     */
    public function getAppareilcertificats(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAppareilcertificatsPartial && !$this->isNew();
        if (null === $this->collAppareilcertificats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAppareilcertificats) {
                // return empty collection
                $this->initAppareilcertificats();
            } else {
                $collAppareilcertificats = ChildAppareilcertificatQuery::create(null, $criteria)
                    ->filterByCertificat($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAppareilcertificatsPartial && count($collAppareilcertificats)) {
                        $this->initAppareilcertificats(false);

                        foreach ($collAppareilcertificats as $obj) {
                            if (false == $this->collAppareilcertificats->contains($obj)) {
                                $this->collAppareilcertificats->append($obj);
                            }
                        }

                        $this->collAppareilcertificatsPartial = true;
                    }

                    return $collAppareilcertificats;
                }

                if ($partial && $this->collAppareilcertificats) {
                    foreach ($this->collAppareilcertificats as $obj) {
                        if ($obj->isNew()) {
                            $collAppareilcertificats[] = $obj;
                        }
                    }
                }

                $this->collAppareilcertificats = $collAppareilcertificats;
                $this->collAppareilcertificatsPartial = false;
            }
        }

        return $this->collAppareilcertificats;
    }

    /**
     * Sets a collection of ChildAppareilcertificat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $appareilcertificats A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCertificat The current object (for fluent API support)
     */
    public function setAppareilcertificats(Collection $appareilcertificats, ConnectionInterface $con = null)
    {
        /** @var ChildAppareilcertificat[] $appareilcertificatsToDelete */
        $appareilcertificatsToDelete = $this->getAppareilcertificats(new Criteria(), $con)->diff($appareilcertificats);


        $this->appareilcertificatsScheduledForDeletion = $appareilcertificatsToDelete;

        foreach ($appareilcertificatsToDelete as $appareilcertificatRemoved) {
            $appareilcertificatRemoved->setCertificat(null);
        }

        $this->collAppareilcertificats = null;
        foreach ($appareilcertificats as $appareilcertificat) {
            $this->addAppareilcertificat($appareilcertificat);
        }

        $this->collAppareilcertificats = $appareilcertificats;
        $this->collAppareilcertificatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Appareilcertificat objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Appareilcertificat objects.
     * @throws PropelException
     */
    public function countAppareilcertificats(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAppareilcertificatsPartial && !$this->isNew();
        if (null === $this->collAppareilcertificats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAppareilcertificats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAppareilcertificats());
            }

            $query = ChildAppareilcertificatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCertificat($this)
                ->count($con);
        }

        return count($this->collAppareilcertificats);
    }

    /**
     * Method called to associate a ChildAppareilcertificat object to this object
     * through the ChildAppareilcertificat foreign key attribute.
     *
     * @param  ChildAppareilcertificat $l ChildAppareilcertificat
     * @return $this|\Certificat The current object (for fluent API support)
     */
    public function addAppareilcertificat(ChildAppareilcertificat $l)
    {
        if ($this->collAppareilcertificats === null) {
            $this->initAppareilcertificats();
            $this->collAppareilcertificatsPartial = true;
        }

        if (!$this->collAppareilcertificats->contains($l)) {
            $this->doAddAppareilcertificat($l);
        }

        return $this;
    }

    /**
     * @param ChildAppareilcertificat $appareilcertificat The ChildAppareilcertificat object to add.
     */
    protected function doAddAppareilcertificat(ChildAppareilcertificat $appareilcertificat)
    {
        $this->collAppareilcertificats[]= $appareilcertificat;
        $appareilcertificat->setCertificat($this);
    }

    /**
     * @param  ChildAppareilcertificat $appareilcertificat The ChildAppareilcertificat object to remove.
     * @return $this|ChildCertificat The current object (for fluent API support)
     */
    public function removeAppareilcertificat(ChildAppareilcertificat $appareilcertificat)
    {
        if ($this->getAppareilcertificats()->contains($appareilcertificat)) {
            $pos = $this->collAppareilcertificats->search($appareilcertificat);
            $this->collAppareilcertificats->remove($pos);
            if (null === $this->appareilcertificatsScheduledForDeletion) {
                $this->appareilcertificatsScheduledForDeletion = clone $this->collAppareilcertificats;
                $this->appareilcertificatsScheduledForDeletion->clear();
            }
            $this->appareilcertificatsScheduledForDeletion[]= $appareilcertificat;
            $appareilcertificat->setCertificat(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Certificat is new, it will return
     * an empty collection; or if this Certificat has previously
     * been saved, it will retrieve related Appareilcertificats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Certificat.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAppareilcertificat[] List of ChildAppareilcertificat objects
     */
    public function getAppareilcertificatsJoinAppareil(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAppareilcertificatQuery::create(null, $criteria);
        $query->joinWith('Appareil', $joinBehavior);

        return $this->getAppareilcertificats($query, $con);
    }

    /**
     * Clears out the collSocietecertificats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSocietecertificats()
     */
    public function clearSocietecertificats()
    {
        $this->collSocietecertificats = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSocietecertificats collection loaded partially.
     */
    public function resetPartialSocietecertificats($v = true)
    {
        $this->collSocietecertificatsPartial = $v;
    }

    /**
     * Initializes the collSocietecertificats collection.
     *
     * By default this just sets the collSocietecertificats collection to an empty array (like clearcollSocietecertificats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSocietecertificats($overrideExisting = true)
    {
        if (null !== $this->collSocietecertificats && !$overrideExisting) {
            return;
        }
        $this->collSocietecertificats = new ObjectCollection();
        $this->collSocietecertificats->setModel('\Societecertificat');
    }

    /**
     * Gets an array of ChildSocietecertificat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCertificat is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSocietecertificat[] List of ChildSocietecertificat objects
     * @throws PropelException
     */
    public function getSocietecertificats(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietecertificatsPartial && !$this->isNew();
        if (null === $this->collSocietecertificats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSocietecertificats) {
                // return empty collection
                $this->initSocietecertificats();
            } else {
                $collSocietecertificats = ChildSocietecertificatQuery::create(null, $criteria)
                    ->filterByCertificat($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSocietecertificatsPartial && count($collSocietecertificats)) {
                        $this->initSocietecertificats(false);

                        foreach ($collSocietecertificats as $obj) {
                            if (false == $this->collSocietecertificats->contains($obj)) {
                                $this->collSocietecertificats->append($obj);
                            }
                        }

                        $this->collSocietecertificatsPartial = true;
                    }

                    return $collSocietecertificats;
                }

                if ($partial && $this->collSocietecertificats) {
                    foreach ($this->collSocietecertificats as $obj) {
                        if ($obj->isNew()) {
                            $collSocietecertificats[] = $obj;
                        }
                    }
                }

                $this->collSocietecertificats = $collSocietecertificats;
                $this->collSocietecertificatsPartial = false;
            }
        }

        return $this->collSocietecertificats;
    }

    /**
     * Sets a collection of ChildSocietecertificat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $societecertificats A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCertificat The current object (for fluent API support)
     */
    public function setSocietecertificats(Collection $societecertificats, ConnectionInterface $con = null)
    {
        /** @var ChildSocietecertificat[] $societecertificatsToDelete */
        $societecertificatsToDelete = $this->getSocietecertificats(new Criteria(), $con)->diff($societecertificats);


        $this->societecertificatsScheduledForDeletion = $societecertificatsToDelete;

        foreach ($societecertificatsToDelete as $societecertificatRemoved) {
            $societecertificatRemoved->setCertificat(null);
        }

        $this->collSocietecertificats = null;
        foreach ($societecertificats as $societecertificat) {
            $this->addSocietecertificat($societecertificat);
        }

        $this->collSocietecertificats = $societecertificats;
        $this->collSocietecertificatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Societecertificat objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Societecertificat objects.
     * @throws PropelException
     */
    public function countSocietecertificats(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietecertificatsPartial && !$this->isNew();
        if (null === $this->collSocietecertificats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSocietecertificats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSocietecertificats());
            }

            $query = ChildSocietecertificatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCertificat($this)
                ->count($con);
        }

        return count($this->collSocietecertificats);
    }

    /**
     * Method called to associate a ChildSocietecertificat object to this object
     * through the ChildSocietecertificat foreign key attribute.
     *
     * @param  ChildSocietecertificat $l ChildSocietecertificat
     * @return $this|\Certificat The current object (for fluent API support)
     */
    public function addSocietecertificat(ChildSocietecertificat $l)
    {
        if ($this->collSocietecertificats === null) {
            $this->initSocietecertificats();
            $this->collSocietecertificatsPartial = true;
        }

        if (!$this->collSocietecertificats->contains($l)) {
            $this->doAddSocietecertificat($l);
        }

        return $this;
    }

    /**
     * @param ChildSocietecertificat $societecertificat The ChildSocietecertificat object to add.
     */
    protected function doAddSocietecertificat(ChildSocietecertificat $societecertificat)
    {
        $this->collSocietecertificats[]= $societecertificat;
        $societecertificat->setCertificat($this);
    }

    /**
     * @param  ChildSocietecertificat $societecertificat The ChildSocietecertificat object to remove.
     * @return $this|ChildCertificat The current object (for fluent API support)
     */
    public function removeSocietecertificat(ChildSocietecertificat $societecertificat)
    {
        if ($this->getSocietecertificats()->contains($societecertificat)) {
            $pos = $this->collSocietecertificats->search($societecertificat);
            $this->collSocietecertificats->remove($pos);
            if (null === $this->societecertificatsScheduledForDeletion) {
                $this->societecertificatsScheduledForDeletion = clone $this->collSocietecertificats;
                $this->societecertificatsScheduledForDeletion->clear();
            }
            $this->societecertificatsScheduledForDeletion[]= $societecertificat;
            $societecertificat->setCertificat(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Certificat is new, it will return
     * an empty collection; or if this Certificat has previously
     * been saved, it will retrieve related Societecertificats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Certificat.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocietecertificat[] List of ChildSocietecertificat objects
     */
    public function getSocietecertificatsJoinSociete(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocietecertificatQuery::create(null, $criteria);
        $query->joinWith('Societe', $joinBehavior);

        return $this->getSocietecertificats($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Certificat is new, it will return
     * an empty collection; or if this Certificat has previously
     * been saved, it will retrieve related Societecertificats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Certificat.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocietecertificat[] List of ChildSocietecertificat objects
     */
    public function getSocietecertificatsJoinAppareil(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocietecertificatQuery::create(null, $criteria);
        $query->joinWith('Appareil', $joinBehavior);

        return $this->getSocietecertificats($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->agrement = null;
        $this->srcweb = null;
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
            if ($this->collAppareilcertificats) {
                foreach ($this->collAppareilcertificats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSocietecertificats) {
                foreach ($this->collSocietecertificats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAppareilcertificats = null;
        $this->collSocietecertificats = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CertificatTableMap::DEFAULT_STRING_FORMAT);
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
