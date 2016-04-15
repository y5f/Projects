<?php

namespace Base;

use \Contact as ChildContact;
use \ContactQuery as ChildContactQuery;
use \FPartenaire as ChildFPartenaire;
use \FPartenaireQuery as ChildFPartenaireQuery;
use \IConcernePays as ChildIConcernePays;
use \IConcernePaysQuery as ChildIConcernePaysQuery;
use \Partenaire as ChildPartenaire;
use \PartenaireQuery as ChildPartenaireQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\FPartenaireTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'finance_part' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class FPartenaire implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\FPartenaireTableMap';


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
     * The value for the indx_part field.
     * @var        int
     */
    protected $indx_part;

    /**
     * The value for the abonnement field.
     * @var        boolean
     */
    protected $abonnement;

    /**
     * The value for the notes field.
     * @var        string
     */
    protected $notes;

    /**
     * The value for the dte_maj field.
     * @var        \DateTime
     */
    protected $dte_maj;

    /**
     * The value for the id_contact field.
     * @var        int
     */
    protected $id_contact;

    /**
     * @var        ChildPartenaire
     */
    protected $aPartenaire;

    /**
     * @var        ChildContact
     */
    protected $aContact;

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
     * @var ObjectCollection|ChildIConcernePays[]
     */
    protected $iConcernePayssScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\FPartenaire object.
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
     * Compares this with another <code>FPartenaire</code> instance.  If
     * <code>obj</code> is an instance of <code>FPartenaire</code>, delegates to
     * <code>equals(FPartenaire)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|FPartenaire The current object, for fluid interface
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
     * Get the [indx_part] column value.
     *
     * @return int
     */
    public function getIDPart()
    {
        return $this->indx_part;
    }

    /**
     * Get the [abonnement] column value.
     *
     * @return boolean
     */
    public function getisAbonnement()
    {
        return $this->abonnement;
    }

    /**
     * Get the [abonnement] column value.
     *
     * @return boolean
     */
    public function isAbonnement()
    {
        return $this->getisAbonnement();
    }

    /**
     * Get the [notes] column value.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Get the [optionally formatted] temporal [dte_maj] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateMAJ($format = NULL)
    {
        if ($format === null) {
            return $this->dte_maj;
        } else {
            return $this->dte_maj instanceof \DateTime ? $this->dte_maj->format($format) : null;
        }
    }

    /**
     * Get the [id_contact] column value.
     *
     * @return int
     */
    public function getIDContact()
    {
        return $this->id_contact;
    }

    /**
     * Set the value of [indx_part] column.
     *
     * @param int $v new value
     * @return $this|\FPartenaire The current object (for fluent API support)
     */
    public function setIDPart($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->indx_part !== $v) {
            $this->indx_part = $v;
            $this->modifiedColumns[FPartenaireTableMap::COL_INDX_PART] = true;
        }

        if ($this->aPartenaire !== null && $this->aPartenaire->getID() !== $v) {
            $this->aPartenaire = null;
        }

        return $this;
    } // setIDPart()

    /**
     * Sets the value of the [abonnement] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\FPartenaire The current object (for fluent API support)
     */
    public function setisAbonnement($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->abonnement !== $v) {
            $this->abonnement = $v;
            $this->modifiedColumns[FPartenaireTableMap::COL_ABONNEMENT] = true;
        }

        return $this;
    } // setisAbonnement()

    /**
     * Set the value of [notes] column.
     *
     * @param string $v new value
     * @return $this|\FPartenaire The current object (for fluent API support)
     */
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes !== $v) {
            $this->notes = $v;
            $this->modifiedColumns[FPartenaireTableMap::COL_NOTES] = true;
        }

        return $this;
    } // setNotes()

    /**
     * Sets the value of [dte_maj] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\FPartenaire The current object (for fluent API support)
     */
    public function setDateMAJ($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dte_maj !== null || $dt !== null) {
            if ($this->dte_maj === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->dte_maj->format("Y-m-d H:i:s")) {
                $this->dte_maj = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FPartenaireTableMap::COL_DTE_MAJ] = true;
            }
        } // if either are not null

        return $this;
    } // setDateMAJ()

    /**
     * Set the value of [id_contact] column.
     *
     * @param int $v new value
     * @return $this|\FPartenaire The current object (for fluent API support)
     */
    public function setIDContact($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_contact !== $v) {
            $this->id_contact = $v;
            $this->modifiedColumns[FPartenaireTableMap::COL_ID_CONTACT] = true;
        }

        if ($this->aContact !== null && $this->aContact->getID() !== $v) {
            $this->aContact = null;
        }

        return $this;
    } // setIDContact()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : FPartenaireTableMap::translateFieldName('IDPart', TableMap::TYPE_PHPNAME, $indexType)];
            $this->indx_part = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : FPartenaireTableMap::translateFieldName('isAbonnement', TableMap::TYPE_PHPNAME, $indexType)];
            $this->abonnement = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : FPartenaireTableMap::translateFieldName('Notes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : FPartenaireTableMap::translateFieldName('DateMAJ', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->dte_maj = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : FPartenaireTableMap::translateFieldName('IDContact', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_contact = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = FPartenaireTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\FPartenaire'), 0, $e);
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
        if ($this->aPartenaire !== null && $this->indx_part !== $this->aPartenaire->getID()) {
            $this->aPartenaire = null;
        }
        if ($this->aContact !== null && $this->id_contact !== $this->aContact->getID()) {
            $this->aContact = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(FPartenaireTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFPartenaireQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPartenaire = null;
            $this->aContact = null;
            $this->collIConcernePayss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see FPartenaire::setDeleted()
     * @see FPartenaire::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FPartenaireTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildFPartenaireQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(FPartenaireTableMap::DATABASE_NAME);
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
                FPartenaireTableMap::addInstanceToPool($this);
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

            if ($this->aPartenaire !== null) {
                if ($this->aPartenaire->isModified() || $this->aPartenaire->isNew()) {
                    $affectedRows += $this->aPartenaire->save($con);
                }
                $this->setPartenaire($this->aPartenaire);
            }

            if ($this->aContact !== null) {
                if ($this->aContact->isModified() || $this->aContact->isNew()) {
                    $affectedRows += $this->aContact->save($con);
                }
                $this->setContact($this->aContact);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FPartenaireTableMap::COL_INDX_PART)) {
            $modifiedColumns[':p' . $index++]  = 'indx_part';
        }
        if ($this->isColumnModified(FPartenaireTableMap::COL_ABONNEMENT)) {
            $modifiedColumns[':p' . $index++]  = 'abonnement';
        }
        if ($this->isColumnModified(FPartenaireTableMap::COL_NOTES)) {
            $modifiedColumns[':p' . $index++]  = 'notes';
        }
        if ($this->isColumnModified(FPartenaireTableMap::COL_DTE_MAJ)) {
            $modifiedColumns[':p' . $index++]  = 'dte_maj';
        }
        if ($this->isColumnModified(FPartenaireTableMap::COL_ID_CONTACT)) {
            $modifiedColumns[':p' . $index++]  = 'id_contact';
        }

        $sql = sprintf(
            'INSERT INTO finance_part (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'indx_part':
                        $stmt->bindValue($identifier, $this->indx_part, PDO::PARAM_INT);
                        break;
                    case 'abonnement':
                        $stmt->bindValue($identifier, (int) $this->abonnement, PDO::PARAM_INT);
                        break;
                    case 'notes':
                        $stmt->bindValue($identifier, $this->notes, PDO::PARAM_STR);
                        break;
                    case 'dte_maj':
                        $stmt->bindValue($identifier, $this->dte_maj ? $this->dte_maj->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'id_contact':
                        $stmt->bindValue($identifier, $this->id_contact, PDO::PARAM_INT);
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
        $pos = FPartenaireTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIDPart();
                break;
            case 1:
                return $this->getisAbonnement();
                break;
            case 2:
                return $this->getNotes();
                break;
            case 3:
                return $this->getDateMAJ();
                break;
            case 4:
                return $this->getIDContact();
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

        if (isset($alreadyDumpedObjects['FPartenaire'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['FPartenaire'][$this->hashCode()] = true;
        $keys = FPartenaireTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIDPart(),
            $keys[1] => $this->getisAbonnement(),
            $keys[2] => $this->getNotes(),
            $keys[3] => $this->getDateMAJ(),
            $keys[4] => $this->getIDContact(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[3]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[3]];
            $result[$keys[3]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPartenaire) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'partenaire';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'partenaire';
                        break;
                    default:
                        $key = 'Partenaire';
                }

                $result[$key] = $this->aPartenaire->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aContact) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contact';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'contact';
                        break;
                    default:
                        $key = 'Contact';
                }

                $result[$key] = $this->aContact->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\FPartenaire
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = FPartenaireTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\FPartenaire
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIDPart($value);
                break;
            case 1:
                $this->setisAbonnement($value);
                break;
            case 2:
                $this->setNotes($value);
                break;
            case 3:
                $this->setDateMAJ($value);
                break;
            case 4:
                $this->setIDContact($value);
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
        $keys = FPartenaireTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIDPart($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setisAbonnement($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNotes($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDateMAJ($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setIDContact($arr[$keys[4]]);
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
     * @return $this|\FPartenaire The current object, for fluid interface
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
        $criteria = new Criteria(FPartenaireTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FPartenaireTableMap::COL_INDX_PART)) {
            $criteria->add(FPartenaireTableMap::COL_INDX_PART, $this->indx_part);
        }
        if ($this->isColumnModified(FPartenaireTableMap::COL_ABONNEMENT)) {
            $criteria->add(FPartenaireTableMap::COL_ABONNEMENT, $this->abonnement);
        }
        if ($this->isColumnModified(FPartenaireTableMap::COL_NOTES)) {
            $criteria->add(FPartenaireTableMap::COL_NOTES, $this->notes);
        }
        if ($this->isColumnModified(FPartenaireTableMap::COL_DTE_MAJ)) {
            $criteria->add(FPartenaireTableMap::COL_DTE_MAJ, $this->dte_maj);
        }
        if ($this->isColumnModified(FPartenaireTableMap::COL_ID_CONTACT)) {
            $criteria->add(FPartenaireTableMap::COL_ID_CONTACT, $this->id_contact);
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
        $criteria = ChildFPartenaireQuery::create();
        $criteria->add(FPartenaireTableMap::COL_INDX_PART, $this->indx_part);

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
        $validPk = null !== $this->getIDPart();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation finance_part_fk_16911e to table partenaire
        if ($this->aPartenaire && $hash = spl_object_hash($this->aPartenaire)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

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
        return $this->getIDPart();
    }

    /**
     * Generic method to set the primary key (indx_part column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIDPart($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIDPart();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \FPartenaire (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIDPart($this->getIDPart());
        $copyObj->setisAbonnement($this->getisAbonnement());
        $copyObj->setNotes($this->getNotes());
        $copyObj->setDateMAJ($this->getDateMAJ());
        $copyObj->setIDContact($this->getIDContact());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getIConcernePayss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIConcernePays($relObj->copy($deepCopy));
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
     * @return \FPartenaire Clone of current object.
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
     * Declares an association between this object and a ChildPartenaire object.
     *
     * @param  ChildPartenaire $v
     * @return $this|\FPartenaire The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPartenaire(ChildPartenaire $v = null)
    {
        if ($v === null) {
            $this->setIDPart(NULL);
        } else {
            $this->setIDPart($v->getID());
        }

        $this->aPartenaire = $v;

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setFPartenaire($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPartenaire object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPartenaire The associated ChildPartenaire object.
     * @throws PropelException
     */
    public function getPartenaire(ConnectionInterface $con = null)
    {
        if ($this->aPartenaire === null && ($this->indx_part !== null)) {
            $this->aPartenaire = ChildPartenaireQuery::create()->findPk($this->indx_part, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aPartenaire->setFPartenaire($this);
        }

        return $this->aPartenaire;
    }

    /**
     * Declares an association between this object and a ChildContact object.
     *
     * @param  ChildContact $v
     * @return $this|\FPartenaire The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContact(ChildContact $v = null)
    {
        if ($v === null) {
            $this->setIDContact(NULL);
        } else {
            $this->setIDContact($v->getID());
        }

        $this->aContact = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildContact object, it will not be re-added.
        if ($v !== null) {
            $v->addFPartenaire($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildContact object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildContact The associated ChildContact object.
     * @throws PropelException
     */
    public function getContact(ConnectionInterface $con = null)
    {
        if ($this->aContact === null && ($this->id_contact !== null)) {
            $this->aContact = ChildContactQuery::create()->findPk($this->id_contact, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContact->addFPartenaires($this);
             */
        }

        return $this->aContact;
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
        if ('IConcernePays' == $relationName) {
            return $this->initIConcernePayss();
        }
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
     * If this ChildFPartenaire is new, it will return
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
                    ->filterByFPartenaire($this)
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
     * @return $this|ChildFPartenaire The current object (for fluent API support)
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
            $iConcernePaysRemoved->setFPartenaire(null);
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
                ->filterByFPartenaire($this)
                ->count($con);
        }

        return count($this->collIConcernePayss);
    }

    /**
     * Method called to associate a ChildIConcernePays object to this object
     * through the ChildIConcernePays foreign key attribute.
     *
     * @param  ChildIConcernePays $l ChildIConcernePays
     * @return $this|\FPartenaire The current object (for fluent API support)
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
        $iConcernePays->setFPartenaire($this);
    }

    /**
     * @param  ChildIConcernePays $iConcernePays The ChildIConcernePays object to remove.
     * @return $this|ChildFPartenaire The current object (for fluent API support)
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
            $iConcernePays->setFPartenaire(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FPartenaire is new, it will return
     * an empty collection; or if this FPartenaire has previously
     * been saved, it will retrieve related IConcernePayss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FPartenaire.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIConcernePays[] List of ChildIConcernePays objects
     */
    public function getIConcernePayssJoinPays(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIConcernePaysQuery::create(null, $criteria);
        $query->joinWith('Pays', $joinBehavior);

        return $this->getIConcernePayss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPartenaire) {
            $this->aPartenaire->removeFPartenaire($this);
        }
        if (null !== $this->aContact) {
            $this->aContact->removeFPartenaire($this);
        }
        $this->indx_part = null;
        $this->abonnement = null;
        $this->notes = null;
        $this->dte_maj = null;
        $this->id_contact = null;
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
            if ($this->collIConcernePayss) {
                foreach ($this->collIConcernePayss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collIConcernePayss = null;
        $this->aPartenaire = null;
        $this->aContact = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FPartenaireTableMap::DEFAULT_STRING_FORMAT);
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
