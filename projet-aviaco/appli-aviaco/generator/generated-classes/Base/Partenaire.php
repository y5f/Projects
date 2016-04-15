<?php

namespace Base;

use \Annonceur as ChildAnnonceur;
use \AnnonceurQuery as ChildAnnonceurQuery;
use \BPartenaire as ChildBPartenaire;
use \BPartenaireQuery as ChildBPartenaireQuery;
use \FPartenaire as ChildFPartenaire;
use \FPartenaireQuery as ChildFPartenaireQuery;
use \Partenaire as ChildPartenaire;
use \PartenaireQuery as ChildPartenaireQuery;
use \SPartenaire as ChildSPartenaire;
use \SPartenaireQuery as ChildSPartenaireQuery;
use \Exception;
use \PDO;
use Map\PartenaireTableMap;
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
 * Base class that represents a row from the 'partenaire' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Partenaire implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PartenaireTableMap';


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
     * The value for the indx field.
     * @var        int
     */
    protected $indx;

    /**
     * The value for the partenaire field.
     * @var        string
     */
    protected $partenaire;

    /**
     * The value for the id_part field.
     * @var        string
     */
    protected $id_part;

    /**
     * The value for the code field.
     * @var        string
     */
    protected $code;

    /**
     * The value for the lien field.
     * @var        string
     */
    protected $lien;

    /**
     * The value for the mail field.
     * @var        string
     */
    protected $mail;

    /**
     * The value for the type_part field.
     * @var        string
     */
    protected $type_part;

    /**
     * @var        ChildAnnonceur one-to-one related ChildAnnonceur object
     */
    protected $singleAnnonceur;

    /**
     * @var        ChildFPartenaire one-to-one related ChildFPartenaire object
     */
    protected $singleFPartenaire;

    /**
     * @var        ObjectCollection|ChildSPartenaire[] Collection to store aggregation of ChildSPartenaire objects.
     */
    protected $collSPartenaires;
    protected $collSPartenairesPartial;

    /**
     * @var        ObjectCollection|ChildBPartenaire[] Collection to store aggregation of ChildBPartenaire objects.
     */
    protected $collBPartenaires;
    protected $collBPartenairesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSPartenaire[]
     */
    protected $sPartenairesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBPartenaire[]
     */
    protected $bPartenairesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Partenaire object.
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
     * Compares this with another <code>Partenaire</code> instance.  If
     * <code>obj</code> is an instance of <code>Partenaire</code>, delegates to
     * <code>equals(Partenaire)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Partenaire The current object, for fluid interface
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
     * Get the [indx] column value.
     *
     * @return int
     */
    public function getID()
    {
        return $this->indx;
    }

    /**
     * Get the [partenaire] column value.
     *
     * @return string
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * Get the [id_part] column value.
     *
     * @return string
     */
    public function getIDPartenaire()
    {
        return $this->id_part;
    }

    /**
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the [lien] column value.
     *
     * @return string
     */
    public function getLienweb()
    {
        return $this->lien;
    }

    /**
     * Get the [mail] column value.
     *
     * @return string
     */
    public function getmail()
    {
        return $this->mail;
    }

    /**
     * Get the [type_part] column value.
     *
     * @return string
     */
    public function getTypePart()
    {
        return $this->type_part;
    }

    /**
     * Set the value of [indx] column.
     *
     * @param int $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->indx !== $v) {
            $this->indx = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_INDX] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [partenaire] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setPartenaire($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->partenaire !== $v) {
            $this->partenaire = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_PARTENAIRE] = true;
        }

        return $this;
    } // setPartenaire()

    /**
     * Set the value of [id_part] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setIDPartenaire($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id_part !== $v) {
            $this->id_part = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_ID_PART] = true;
        }

        return $this;
    } // setIDPartenaire()

    /**
     * Set the value of [code] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Set the value of [lien] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setLienweb($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lien !== $v) {
            $this->lien = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_LIEN] = true;
        }

        return $this;
    } // setLienweb()

    /**
     * Set the value of [mail] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mail !== $v) {
            $this->mail = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_MAIL] = true;
        }

        return $this;
    } // setmail()

    /**
     * Set the value of [type_part] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setTypePart($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type_part !== $v) {
            $this->type_part = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_TYPE_PART] = true;
        }

        return $this;
    } // setTypePart()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PartenaireTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->indx = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PartenaireTableMap::translateFieldName('Partenaire', TableMap::TYPE_PHPNAME, $indexType)];
            $this->partenaire = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PartenaireTableMap::translateFieldName('IDPartenaire', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_part = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PartenaireTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PartenaireTableMap::translateFieldName('Lienweb', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lien = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PartenaireTableMap::translateFieldName('mail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mail = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PartenaireTableMap::translateFieldName('TypePart', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type_part = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = PartenaireTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Partenaire'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PartenaireTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPartenaireQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->singleAnnonceur = null;

            $this->singleFPartenaire = null;

            $this->collSPartenaires = null;

            $this->collBPartenaires = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Partenaire::setDeleted()
     * @see Partenaire::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PartenaireTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPartenaireQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PartenaireTableMap::DATABASE_NAME);
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
                PartenaireTableMap::addInstanceToPool($this);
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

            if ($this->singleAnnonceur !== null) {
                if (!$this->singleAnnonceur->isDeleted() && ($this->singleAnnonceur->isNew() || $this->singleAnnonceur->isModified())) {
                    $affectedRows += $this->singleAnnonceur->save($con);
                }
            }

            if ($this->singleFPartenaire !== null) {
                if (!$this->singleFPartenaire->isDeleted() && ($this->singleFPartenaire->isNew() || $this->singleFPartenaire->isModified())) {
                    $affectedRows += $this->singleFPartenaire->save($con);
                }
            }

            if ($this->sPartenairesScheduledForDeletion !== null) {
                if (!$this->sPartenairesScheduledForDeletion->isEmpty()) {
                    \SPartenaireQuery::create()
                        ->filterByPrimaryKeys($this->sPartenairesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sPartenairesScheduledForDeletion = null;
                }
            }

            if ($this->collSPartenaires !== null) {
                foreach ($this->collSPartenaires as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->bPartenairesScheduledForDeletion !== null) {
                if (!$this->bPartenairesScheduledForDeletion->isEmpty()) {
                    \BPartenaireQuery::create()
                        ->filterByPrimaryKeys($this->bPartenairesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->bPartenairesScheduledForDeletion = null;
                }
            }

            if ($this->collBPartenaires !== null) {
                foreach ($this->collBPartenaires as $referrerFK) {
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

        $this->modifiedColumns[PartenaireTableMap::COL_INDX] = true;
        if (null !== $this->indx) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PartenaireTableMap::COL_INDX . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PartenaireTableMap::COL_INDX)) {
            $modifiedColumns[':p' . $index++]  = 'indx';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PARTENAIRE)) {
            $modifiedColumns[':p' . $index++]  = 'partenaire';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_ID_PART)) {
            $modifiedColumns[':p' . $index++]  = 'id_part';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_LIEN)) {
            $modifiedColumns[':p' . $index++]  = 'lien';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_MAIL)) {
            $modifiedColumns[':p' . $index++]  = 'mail';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_TYPE_PART)) {
            $modifiedColumns[':p' . $index++]  = 'type_part';
        }

        $sql = sprintf(
            'INSERT INTO partenaire (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'indx':
                        $stmt->bindValue($identifier, $this->indx, PDO::PARAM_INT);
                        break;
                    case 'partenaire':
                        $stmt->bindValue($identifier, $this->partenaire, PDO::PARAM_STR);
                        break;
                    case 'id_part':
                        $stmt->bindValue($identifier, $this->id_part, PDO::PARAM_STR);
                        break;
                    case 'code':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case 'lien':
                        $stmt->bindValue($identifier, $this->lien, PDO::PARAM_STR);
                        break;
                    case 'mail':
                        $stmt->bindValue($identifier, $this->mail, PDO::PARAM_STR);
                        break;
                    case 'type_part':
                        $stmt->bindValue($identifier, $this->type_part, PDO::PARAM_STR);
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
        $pos = PartenaireTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPartenaire();
                break;
            case 2:
                return $this->getIDPartenaire();
                break;
            case 3:
                return $this->getCode();
                break;
            case 4:
                return $this->getLienweb();
                break;
            case 5:
                return $this->getmail();
                break;
            case 6:
                return $this->getTypePart();
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

        if (isset($alreadyDumpedObjects['Partenaire'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Partenaire'][$this->hashCode()] = true;
        $keys = PartenaireTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getPartenaire(),
            $keys[2] => $this->getIDPartenaire(),
            $keys[3] => $this->getCode(),
            $keys[4] => $this->getLienweb(),
            $keys[5] => $this->getmail(),
            $keys[6] => $this->getTypePart(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->singleAnnonceur) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'annonceur';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'annonceur';
                        break;
                    default:
                        $key = 'Annonceur';
                }

                $result[$key] = $this->singleAnnonceur->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->singleFPartenaire) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fPartenaire';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'finance_part';
                        break;
                    default:
                        $key = 'FPartenaire';
                }

                $result[$key] = $this->singleFPartenaire->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSPartenaires) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sPartenaires';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'soc_parts';
                        break;
                    default:
                        $key = 'SPartenaires';
                }

                $result[$key] = $this->collSPartenaires->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBPartenaires) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bPartenaires';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'base_parts';
                        break;
                    default:
                        $key = 'BPartenaires';
                }

                $result[$key] = $this->collBPartenaires->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Partenaire
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PartenaireTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Partenaire
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setID($value);
                break;
            case 1:
                $this->setPartenaire($value);
                break;
            case 2:
                $this->setIDPartenaire($value);
                break;
            case 3:
                $this->setCode($value);
                break;
            case 4:
                $this->setLienweb($value);
                break;
            case 5:
                $this->setmail($value);
                break;
            case 6:
                $this->setTypePart($value);
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
        $keys = PartenaireTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPartenaire($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIDPartenaire($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCode($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLienweb($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setmail($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setTypePart($arr[$keys[6]]);
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
     * @return $this|\Partenaire The current object, for fluid interface
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
        $criteria = new Criteria(PartenaireTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PartenaireTableMap::COL_INDX)) {
            $criteria->add(PartenaireTableMap::COL_INDX, $this->indx);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PARTENAIRE)) {
            $criteria->add(PartenaireTableMap::COL_PARTENAIRE, $this->partenaire);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_ID_PART)) {
            $criteria->add(PartenaireTableMap::COL_ID_PART, $this->id_part);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_CODE)) {
            $criteria->add(PartenaireTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_LIEN)) {
            $criteria->add(PartenaireTableMap::COL_LIEN, $this->lien);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_MAIL)) {
            $criteria->add(PartenaireTableMap::COL_MAIL, $this->mail);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_TYPE_PART)) {
            $criteria->add(PartenaireTableMap::COL_TYPE_PART, $this->type_part);
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
        $criteria = ChildPartenaireQuery::create();
        $criteria->add(PartenaireTableMap::COL_INDX, $this->indx);

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
     * Generic method to set the primary key (indx column).
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
     * @param      object $copyObj An object of \Partenaire (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPartenaire($this->getPartenaire());
        $copyObj->setIDPartenaire($this->getIDPartenaire());
        $copyObj->setCode($this->getCode());
        $copyObj->setLienweb($this->getLienweb());
        $copyObj->setmail($this->getmail());
        $copyObj->setTypePart($this->getTypePart());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            $relObj = $this->getAnnonceur();
            if ($relObj) {
                $copyObj->setAnnonceur($relObj->copy($deepCopy));
            }

            $relObj = $this->getFPartenaire();
            if ($relObj) {
                $copyObj->setFPartenaire($relObj->copy($deepCopy));
            }

            foreach ($this->getSPartenaires() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSPartenaire($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBPartenaires() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBPartenaire($relObj->copy($deepCopy));
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
     * @return \Partenaire Clone of current object.
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
        if ('SPartenaire' == $relationName) {
            return $this->initSPartenaires();
        }
        if ('BPartenaire' == $relationName) {
            return $this->initBPartenaires();
        }
    }

    /**
     * Gets a single ChildAnnonceur object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildAnnonceur
     * @throws PropelException
     */
    public function getAnnonceur(ConnectionInterface $con = null)
    {

        if ($this->singleAnnonceur === null && !$this->isNew()) {
            $this->singleAnnonceur = ChildAnnonceurQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleAnnonceur;
    }

    /**
     * Sets a single ChildAnnonceur object as related to this object by a one-to-one relationship.
     *
     * @param  ChildAnnonceur $v ChildAnnonceur
     * @return $this|\Partenaire The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAnnonceur(ChildAnnonceur $v = null)
    {
        $this->singleAnnonceur = $v;

        // Make sure that that the passed-in ChildAnnonceur isn't already associated with this object
        if ($v !== null && $v->getPartenaire(null, false) === null) {
            $v->setPartenaire($this);
        }

        return $this;
    }

    /**
     * Gets a single ChildFPartenaire object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildFPartenaire
     * @throws PropelException
     */
    public function getFPartenaire(ConnectionInterface $con = null)
    {

        if ($this->singleFPartenaire === null && !$this->isNew()) {
            $this->singleFPartenaire = ChildFPartenaireQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleFPartenaire;
    }

    /**
     * Sets a single ChildFPartenaire object as related to this object by a one-to-one relationship.
     *
     * @param  ChildFPartenaire $v ChildFPartenaire
     * @return $this|\Partenaire The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFPartenaire(ChildFPartenaire $v = null)
    {
        $this->singleFPartenaire = $v;

        // Make sure that that the passed-in ChildFPartenaire isn't already associated with this object
        if ($v !== null && $v->getPartenaire(null, false) === null) {
            $v->setPartenaire($this);
        }

        return $this;
    }

    /**
     * Clears out the collSPartenaires collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSPartenaires()
     */
    public function clearSPartenaires()
    {
        $this->collSPartenaires = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSPartenaires collection loaded partially.
     */
    public function resetPartialSPartenaires($v = true)
    {
        $this->collSPartenairesPartial = $v;
    }

    /**
     * Initializes the collSPartenaires collection.
     *
     * By default this just sets the collSPartenaires collection to an empty array (like clearcollSPartenaires());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSPartenaires($overrideExisting = true)
    {
        if (null !== $this->collSPartenaires && !$overrideExisting) {
            return;
        }
        $this->collSPartenaires = new ObjectCollection();
        $this->collSPartenaires->setModel('\SPartenaire');
    }

    /**
     * Gets an array of ChildSPartenaire objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPartenaire is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSPartenaire[] List of ChildSPartenaire objects
     * @throws PropelException
     */
    public function getSPartenaires(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSPartenairesPartial && !$this->isNew();
        if (null === $this->collSPartenaires || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSPartenaires) {
                // return empty collection
                $this->initSPartenaires();
            } else {
                $collSPartenaires = ChildSPartenaireQuery::create(null, $criteria)
                    ->filterByPartenaire($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSPartenairesPartial && count($collSPartenaires)) {
                        $this->initSPartenaires(false);

                        foreach ($collSPartenaires as $obj) {
                            if (false == $this->collSPartenaires->contains($obj)) {
                                $this->collSPartenaires->append($obj);
                            }
                        }

                        $this->collSPartenairesPartial = true;
                    }

                    return $collSPartenaires;
                }

                if ($partial && $this->collSPartenaires) {
                    foreach ($this->collSPartenaires as $obj) {
                        if ($obj->isNew()) {
                            $collSPartenaires[] = $obj;
                        }
                    }
                }

                $this->collSPartenaires = $collSPartenaires;
                $this->collSPartenairesPartial = false;
            }
        }

        return $this->collSPartenaires;
    }

    /**
     * Sets a collection of ChildSPartenaire objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sPartenaires A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function setSPartenaires(Collection $sPartenaires, ConnectionInterface $con = null)
    {
        /** @var ChildSPartenaire[] $sPartenairesToDelete */
        $sPartenairesToDelete = $this->getSPartenaires(new Criteria(), $con)->diff($sPartenaires);


        $this->sPartenairesScheduledForDeletion = $sPartenairesToDelete;

        foreach ($sPartenairesToDelete as $sPartenaireRemoved) {
            $sPartenaireRemoved->setPartenaire(null);
        }

        $this->collSPartenaires = null;
        foreach ($sPartenaires as $sPartenaire) {
            $this->addSPartenaire($sPartenaire);
        }

        $this->collSPartenaires = $sPartenaires;
        $this->collSPartenairesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SPartenaire objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SPartenaire objects.
     * @throws PropelException
     */
    public function countSPartenaires(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSPartenairesPartial && !$this->isNew();
        if (null === $this->collSPartenaires || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSPartenaires) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSPartenaires());
            }

            $query = ChildSPartenaireQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPartenaire($this)
                ->count($con);
        }

        return count($this->collSPartenaires);
    }

    /**
     * Method called to associate a ChildSPartenaire object to this object
     * through the ChildSPartenaire foreign key attribute.
     *
     * @param  ChildSPartenaire $l ChildSPartenaire
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function addSPartenaire(ChildSPartenaire $l)
    {
        if ($this->collSPartenaires === null) {
            $this->initSPartenaires();
            $this->collSPartenairesPartial = true;
        }

        if (!$this->collSPartenaires->contains($l)) {
            $this->doAddSPartenaire($l);
        }

        return $this;
    }

    /**
     * @param ChildSPartenaire $sPartenaire The ChildSPartenaire object to add.
     */
    protected function doAddSPartenaire(ChildSPartenaire $sPartenaire)
    {
        $this->collSPartenaires[]= $sPartenaire;
        $sPartenaire->setPartenaire($this);
    }

    /**
     * @param  ChildSPartenaire $sPartenaire The ChildSPartenaire object to remove.
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function removeSPartenaire(ChildSPartenaire $sPartenaire)
    {
        if ($this->getSPartenaires()->contains($sPartenaire)) {
            $pos = $this->collSPartenaires->search($sPartenaire);
            $this->collSPartenaires->remove($pos);
            if (null === $this->sPartenairesScheduledForDeletion) {
                $this->sPartenairesScheduledForDeletion = clone $this->collSPartenaires;
                $this->sPartenairesScheduledForDeletion->clear();
            }
            $this->sPartenairesScheduledForDeletion[]= $sPartenaire;
            $sPartenaire->setPartenaire(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenaire is new, it will return
     * an empty collection; or if this Partenaire has previously
     * been saved, it will retrieve related SPartenaires from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenaire.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSPartenaire[] List of ChildSPartenaire objects
     */
    public function getSPartenairesJoinSocFraude(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSPartenaireQuery::create(null, $criteria);
        $query->joinWith('SocFraude', $joinBehavior);

        return $this->getSPartenaires($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenaire is new, it will return
     * an empty collection; or if this Partenaire has previously
     * been saved, it will retrieve related SPartenaires from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenaire.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSPartenaire[] List of ChildSPartenaire objects
     */
    public function getSPartenairesJoinSocPlaignant(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSPartenaireQuery::create(null, $criteria);
        $query->joinWith('SocPlaignant', $joinBehavior);

        return $this->getSPartenaires($query, $con);
    }

    /**
     * Clears out the collBPartenaires collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBPartenaires()
     */
    public function clearBPartenaires()
    {
        $this->collBPartenaires = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBPartenaires collection loaded partially.
     */
    public function resetPartialBPartenaires($v = true)
    {
        $this->collBPartenairesPartial = $v;
    }

    /**
     * Initializes the collBPartenaires collection.
     *
     * By default this just sets the collBPartenaires collection to an empty array (like clearcollBPartenaires());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBPartenaires($overrideExisting = true)
    {
        if (null !== $this->collBPartenaires && !$overrideExisting) {
            return;
        }
        $this->collBPartenaires = new ObjectCollection();
        $this->collBPartenaires->setModel('\BPartenaire');
    }

    /**
     * Gets an array of ChildBPartenaire objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPartenaire is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBPartenaire[] List of ChildBPartenaire objects
     * @throws PropelException
     */
    public function getBPartenaires(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBPartenairesPartial && !$this->isNew();
        if (null === $this->collBPartenaires || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBPartenaires) {
                // return empty collection
                $this->initBPartenaires();
            } else {
                $collBPartenaires = ChildBPartenaireQuery::create(null, $criteria)
                    ->filterByPartenaire($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBPartenairesPartial && count($collBPartenaires)) {
                        $this->initBPartenaires(false);

                        foreach ($collBPartenaires as $obj) {
                            if (false == $this->collBPartenaires->contains($obj)) {
                                $this->collBPartenaires->append($obj);
                            }
                        }

                        $this->collBPartenairesPartial = true;
                    }

                    return $collBPartenaires;
                }

                if ($partial && $this->collBPartenaires) {
                    foreach ($this->collBPartenaires as $obj) {
                        if ($obj->isNew()) {
                            $collBPartenaires[] = $obj;
                        }
                    }
                }

                $this->collBPartenaires = $collBPartenaires;
                $this->collBPartenairesPartial = false;
            }
        }

        return $this->collBPartenaires;
    }

    /**
     * Sets a collection of ChildBPartenaire objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bPartenaires A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function setBPartenaires(Collection $bPartenaires, ConnectionInterface $con = null)
    {
        /** @var ChildBPartenaire[] $bPartenairesToDelete */
        $bPartenairesToDelete = $this->getBPartenaires(new Criteria(), $con)->diff($bPartenaires);


        $this->bPartenairesScheduledForDeletion = $bPartenairesToDelete;

        foreach ($bPartenairesToDelete as $bPartenaireRemoved) {
            $bPartenaireRemoved->setPartenaire(null);
        }

        $this->collBPartenaires = null;
        foreach ($bPartenaires as $bPartenaire) {
            $this->addBPartenaire($bPartenaire);
        }

        $this->collBPartenaires = $bPartenaires;
        $this->collBPartenairesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BPartenaire objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BPartenaire objects.
     * @throws PropelException
     */
    public function countBPartenaires(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBPartenairesPartial && !$this->isNew();
        if (null === $this->collBPartenaires || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBPartenaires) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBPartenaires());
            }

            $query = ChildBPartenaireQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPartenaire($this)
                ->count($con);
        }

        return count($this->collBPartenaires);
    }

    /**
     * Method called to associate a ChildBPartenaire object to this object
     * through the ChildBPartenaire foreign key attribute.
     *
     * @param  ChildBPartenaire $l ChildBPartenaire
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function addBPartenaire(ChildBPartenaire $l)
    {
        if ($this->collBPartenaires === null) {
            $this->initBPartenaires();
            $this->collBPartenairesPartial = true;
        }

        if (!$this->collBPartenaires->contains($l)) {
            $this->doAddBPartenaire($l);
        }

        return $this;
    }

    /**
     * @param ChildBPartenaire $bPartenaire The ChildBPartenaire object to add.
     */
    protected function doAddBPartenaire(ChildBPartenaire $bPartenaire)
    {
        $this->collBPartenaires[]= $bPartenaire;
        $bPartenaire->setPartenaire($this);
    }

    /**
     * @param  ChildBPartenaire $bPartenaire The ChildBPartenaire object to remove.
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function removeBPartenaire(ChildBPartenaire $bPartenaire)
    {
        if ($this->getBPartenaires()->contains($bPartenaire)) {
            $pos = $this->collBPartenaires->search($bPartenaire);
            $this->collBPartenaires->remove($pos);
            if (null === $this->bPartenairesScheduledForDeletion) {
                $this->bPartenairesScheduledForDeletion = clone $this->collBPartenaires;
                $this->bPartenairesScheduledForDeletion->clear();
            }
            $this->bPartenairesScheduledForDeletion[]= $bPartenaire;
            $bPartenaire->setPartenaire(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenaire is new, it will return
     * an empty collection; or if this Partenaire has previously
     * been saved, it will retrieve related BPartenaires from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenaire.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBPartenaire[] List of ChildBPartenaire objects
     */
    public function getBPartenairesJoinBaseInfos(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBPartenaireQuery::create(null, $criteria);
        $query->joinWith('BaseInfos', $joinBehavior);

        return $this->getBPartenaires($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->indx = null;
        $this->partenaire = null;
        $this->id_part = null;
        $this->code = null;
        $this->lien = null;
        $this->mail = null;
        $this->type_part = null;
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
            if ($this->singleAnnonceur) {
                $this->singleAnnonceur->clearAllReferences($deep);
            }
            if ($this->singleFPartenaire) {
                $this->singleFPartenaire->clearAllReferences($deep);
            }
            if ($this->collSPartenaires) {
                foreach ($this->collSPartenaires as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBPartenaires) {
                foreach ($this->collBPartenaires as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->singleAnnonceur = null;
        $this->singleFPartenaire = null;
        $this->collSPartenaires = null;
        $this->collBPartenaires = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PartenaireTableMap::DEFAULT_STRING_FORMAT);
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
