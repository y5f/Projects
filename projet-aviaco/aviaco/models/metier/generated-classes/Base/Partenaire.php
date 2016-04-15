<?php

namespace Base;

use \Depotpartenaire as ChildDepotpartenaire;
use \DepotpartenaireQuery as ChildDepotpartenaireQuery;
use \Document as ChildDocument;
use \DocumentQuery as ChildDocumentQuery;
use \Partenaire as ChildPartenaire;
use \PartenaireQuery as ChildPartenaireQuery;
use \Partenairepiece as ChildPartenairepiece;
use \PartenairepieceQuery as ChildPartenairepieceQuery;
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
     * The value for the part_id field.
     * @var        int
     */
    protected $part_id;

    /**
     * The value for the part_nom field.
     * @var        string
     */
    protected $part_nom;

    /**
     * The value for the part_adresse field.
     * @var        string
     */
    protected $part_adresse;

    /**
     * The value for the part_tel field.
     * @var        string
     */
    protected $part_tel;

    /**
     * The value for the part_mail field.
     * @var        string
     */
    protected $part_mail;

    /**
     * The value for the part_logo field.
     * @var        string
     */
    protected $part_logo;

    /**
     * @var        ObjectCollection|ChildPartenairepiece[] Collection to store aggregation of ChildPartenairepiece objects.
     */
    protected $collPartenairepieces;
    protected $collPartenairepiecesPartial;

    /**
     * @var        ObjectCollection|ChildDocument[] Collection to store aggregation of ChildDocument objects.
     */
    protected $collDocs;
    protected $collDocsPartial;

    /**
     * @var        ObjectCollection|ChildDepotpartenaire[] Collection to store aggregation of ChildDepotpartenaire objects.
     */
    protected $collDepotpartenaires;
    protected $collDepotpartenairesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPartenairepiece[]
     */
    protected $partenairepiecesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDocument[]
     */
    protected $docsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDepotpartenaire[]
     */
    protected $depotpartenairesScheduledForDeletion = null;

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
     * Get the [part_id] column value.
     *
     * @return int
     */
    public function getPartenaire()
    {
        return $this->part_id;
    }

    /**
     * Get the [part_nom] column value.
     *
     * @return string
     */
    public function getNompartenaire()
    {
        return $this->part_nom;
    }

    /**
     * Get the [part_adresse] column value.
     *
     * @return string
     */
    public function getAdresses()
    {
        return $this->part_adresse;
    }

    /**
     * Get the [part_tel] column value.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->part_tel;
    }

    /**
     * Get the [part_mail] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->part_mail;
    }

    /**
     * Get the [part_logo] column value.
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->part_logo;
    }

    /**
     * Set the value of [part_id] column.
     *
     * @param int $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setPartenaire($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->part_id !== $v) {
            $this->part_id = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_PART_ID] = true;
        }

        return $this;
    } // setPartenaire()

    /**
     * Set the value of [part_nom] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setNompartenaire($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->part_nom !== $v) {
            $this->part_nom = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_PART_NOM] = true;
        }

        return $this;
    } // setNompartenaire()

    /**
     * Set the value of [part_adresse] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setAdresses($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->part_adresse !== $v) {
            $this->part_adresse = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_PART_ADRESSE] = true;
        }

        return $this;
    } // setAdresses()

    /**
     * Set the value of [part_tel] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setTelephone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->part_tel !== $v) {
            $this->part_tel = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_PART_TEL] = true;
        }

        return $this;
    } // setTelephone()

    /**
     * Set the value of [part_mail] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->part_mail !== $v) {
            $this->part_mail = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_PART_MAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [part_logo] column.
     *
     * @param string $v new value
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function setLogo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->part_logo !== $v) {
            $this->part_logo = $v;
            $this->modifiedColumns[PartenaireTableMap::COL_PART_LOGO] = true;
        }

        return $this;
    } // setLogo()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PartenaireTableMap::translateFieldName('Partenaire', TableMap::TYPE_PHPNAME, $indexType)];
            $this->part_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PartenaireTableMap::translateFieldName('Nompartenaire', TableMap::TYPE_PHPNAME, $indexType)];
            $this->part_nom = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PartenaireTableMap::translateFieldName('Adresses', TableMap::TYPE_PHPNAME, $indexType)];
            $this->part_adresse = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PartenaireTableMap::translateFieldName('Telephone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->part_tel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PartenaireTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->part_mail = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PartenaireTableMap::translateFieldName('Logo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->part_logo = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = PartenaireTableMap::NUM_HYDRATE_COLUMNS.

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

            $this->collPartenairepieces = null;

            $this->collDocs = null;

            $this->collDepotpartenaires = null;

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

            if ($this->partenairepiecesScheduledForDeletion !== null) {
                if (!$this->partenairepiecesScheduledForDeletion->isEmpty()) {
                    \PartenairepieceQuery::create()
                        ->filterByPrimaryKeys($this->partenairepiecesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->partenairepiecesScheduledForDeletion = null;
                }
            }

            if ($this->collPartenairepieces !== null) {
                foreach ($this->collPartenairepieces as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->docsScheduledForDeletion !== null) {
                if (!$this->docsScheduledForDeletion->isEmpty()) {
                    \DocumentQuery::create()
                        ->filterByPrimaryKeys($this->docsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->docsScheduledForDeletion = null;
                }
            }

            if ($this->collDocs !== null) {
                foreach ($this->collDocs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->depotpartenairesScheduledForDeletion !== null) {
                if (!$this->depotpartenairesScheduledForDeletion->isEmpty()) {
                    \DepotpartenaireQuery::create()
                        ->filterByPrimaryKeys($this->depotpartenairesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->depotpartenairesScheduledForDeletion = null;
                }
            }

            if ($this->collDepotpartenaires !== null) {
                foreach ($this->collDepotpartenaires as $referrerFK) {
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

        $this->modifiedColumns[PartenaireTableMap::COL_PART_ID] = true;
        if (null !== $this->part_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PartenaireTableMap::COL_PART_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_ID)) {
            $modifiedColumns[':p' . $index++]  = 'part_id';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_NOM)) {
            $modifiedColumns[':p' . $index++]  = 'part_nom';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_ADRESSE)) {
            $modifiedColumns[':p' . $index++]  = 'part_adresse';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_TEL)) {
            $modifiedColumns[':p' . $index++]  = 'part_tel';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_MAIL)) {
            $modifiedColumns[':p' . $index++]  = 'part_mail';
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_LOGO)) {
            $modifiedColumns[':p' . $index++]  = 'part_logo';
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
                    case 'part_id':
                        $stmt->bindValue($identifier, $this->part_id, PDO::PARAM_INT);
                        break;
                    case 'part_nom':
                        $stmt->bindValue($identifier, $this->part_nom, PDO::PARAM_STR);
                        break;
                    case 'part_adresse':
                        $stmt->bindValue($identifier, $this->part_adresse, PDO::PARAM_STR);
                        break;
                    case 'part_tel':
                        $stmt->bindValue($identifier, $this->part_tel, PDO::PARAM_STR);
                        break;
                    case 'part_mail':
                        $stmt->bindValue($identifier, $this->part_mail, PDO::PARAM_STR);
                        break;
                    case 'part_logo':
                        $stmt->bindValue($identifier, $this->part_logo, PDO::PARAM_STR);
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
        $this->setPartenaire($pk);

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
                return $this->getPartenaire();
                break;
            case 1:
                return $this->getNompartenaire();
                break;
            case 2:
                return $this->getAdresses();
                break;
            case 3:
                return $this->getTelephone();
                break;
            case 4:
                return $this->getEmail();
                break;
            case 5:
                return $this->getLogo();
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
            $keys[0] => $this->getPartenaire(),
            $keys[1] => $this->getNompartenaire(),
            $keys[2] => $this->getAdresses(),
            $keys[3] => $this->getTelephone(),
            $keys[4] => $this->getEmail(),
            $keys[5] => $this->getLogo(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collPartenairepieces) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'partenairepieces';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'partenaire_pieces';
                        break;
                    default:
                        $key = 'Partenairepieces';
                }

                $result[$key] = $this->collPartenairepieces->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDocs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'documents';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'documents';
                        break;
                    default:
                        $key = 'Documents';
                }

                $result[$key] = $this->collDocs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDepotpartenaires) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'depotpartenaires';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'partenaire_depots';
                        break;
                    default:
                        $key = 'Depotpartenaires';
                }

                $result[$key] = $this->collDepotpartenaires->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
                $this->setPartenaire($value);
                break;
            case 1:
                $this->setNompartenaire($value);
                break;
            case 2:
                $this->setAdresses($value);
                break;
            case 3:
                $this->setTelephone($value);
                break;
            case 4:
                $this->setEmail($value);
                break;
            case 5:
                $this->setLogo($value);
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
            $this->setPartenaire($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setNompartenaire($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAdresses($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTelephone($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEmail($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setLogo($arr[$keys[5]]);
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

        if ($this->isColumnModified(PartenaireTableMap::COL_PART_ID)) {
            $criteria->add(PartenaireTableMap::COL_PART_ID, $this->part_id);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_NOM)) {
            $criteria->add(PartenaireTableMap::COL_PART_NOM, $this->part_nom);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_ADRESSE)) {
            $criteria->add(PartenaireTableMap::COL_PART_ADRESSE, $this->part_adresse);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_TEL)) {
            $criteria->add(PartenaireTableMap::COL_PART_TEL, $this->part_tel);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_MAIL)) {
            $criteria->add(PartenaireTableMap::COL_PART_MAIL, $this->part_mail);
        }
        if ($this->isColumnModified(PartenaireTableMap::COL_PART_LOGO)) {
            $criteria->add(PartenaireTableMap::COL_PART_LOGO, $this->part_logo);
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
        $criteria->add(PartenaireTableMap::COL_PART_ID, $this->part_id);

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
        $validPk = null !== $this->getPartenaire();

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
        return $this->getPartenaire();
    }

    /**
     * Generic method to set the primary key (part_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setPartenaire($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getPartenaire();
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
        $copyObj->setNompartenaire($this->getNompartenaire());
        $copyObj->setAdresses($this->getAdresses());
        $copyObj->setTelephone($this->getTelephone());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setLogo($this->getLogo());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPartenairepieces() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPartenairepiece($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDocs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDoc($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDepotpartenaires() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDepotpartenaire($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setPartenaire(NULL); // this is a auto-increment column, so set to default value
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
        if ('Partenairepiece' == $relationName) {
            return $this->initPartenairepieces();
        }
        if ('Doc' == $relationName) {
            return $this->initDocs();
        }
        if ('Depotpartenaire' == $relationName) {
            return $this->initDepotpartenaires();
        }
    }

    /**
     * Clears out the collPartenairepieces collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPartenairepieces()
     */
    public function clearPartenairepieces()
    {
        $this->collPartenairepieces = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPartenairepieces collection loaded partially.
     */
    public function resetPartialPartenairepieces($v = true)
    {
        $this->collPartenairepiecesPartial = $v;
    }

    /**
     * Initializes the collPartenairepieces collection.
     *
     * By default this just sets the collPartenairepieces collection to an empty array (like clearcollPartenairepieces());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPartenairepieces($overrideExisting = true)
    {
        if (null !== $this->collPartenairepieces && !$overrideExisting) {
            return;
        }
        $this->collPartenairepieces = new ObjectCollection();
        $this->collPartenairepieces->setModel('\Partenairepiece');
    }

    /**
     * Gets an array of ChildPartenairepiece objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPartenaire is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPartenairepiece[] List of ChildPartenairepiece objects
     * @throws PropelException
     */
    public function getPartenairepieces(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPartenairepiecesPartial && !$this->isNew();
        if (null === $this->collPartenairepieces || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPartenairepieces) {
                // return empty collection
                $this->initPartenairepieces();
            } else {
                $collPartenairepieces = ChildPartenairepieceQuery::create(null, $criteria)
                    ->filterByPartenaire($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPartenairepiecesPartial && count($collPartenairepieces)) {
                        $this->initPartenairepieces(false);

                        foreach ($collPartenairepieces as $obj) {
                            if (false == $this->collPartenairepieces->contains($obj)) {
                                $this->collPartenairepieces->append($obj);
                            }
                        }

                        $this->collPartenairepiecesPartial = true;
                    }

                    return $collPartenairepieces;
                }

                if ($partial && $this->collPartenairepieces) {
                    foreach ($this->collPartenairepieces as $obj) {
                        if ($obj->isNew()) {
                            $collPartenairepieces[] = $obj;
                        }
                    }
                }

                $this->collPartenairepieces = $collPartenairepieces;
                $this->collPartenairepiecesPartial = false;
            }
        }

        return $this->collPartenairepieces;
    }

    /**
     * Sets a collection of ChildPartenairepiece objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $partenairepieces A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function setPartenairepieces(Collection $partenairepieces, ConnectionInterface $con = null)
    {
        /** @var ChildPartenairepiece[] $partenairepiecesToDelete */
        $partenairepiecesToDelete = $this->getPartenairepieces(new Criteria(), $con)->diff($partenairepieces);


        $this->partenairepiecesScheduledForDeletion = $partenairepiecesToDelete;

        foreach ($partenairepiecesToDelete as $partenairepieceRemoved) {
            $partenairepieceRemoved->setPartenaire(null);
        }

        $this->collPartenairepieces = null;
        foreach ($partenairepieces as $partenairepiece) {
            $this->addPartenairepiece($partenairepiece);
        }

        $this->collPartenairepieces = $partenairepieces;
        $this->collPartenairepiecesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Partenairepiece objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Partenairepiece objects.
     * @throws PropelException
     */
    public function countPartenairepieces(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPartenairepiecesPartial && !$this->isNew();
        if (null === $this->collPartenairepieces || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPartenairepieces) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPartenairepieces());
            }

            $query = ChildPartenairepieceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPartenaire($this)
                ->count($con);
        }

        return count($this->collPartenairepieces);
    }

    /**
     * Method called to associate a ChildPartenairepiece object to this object
     * through the ChildPartenairepiece foreign key attribute.
     *
     * @param  ChildPartenairepiece $l ChildPartenairepiece
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function addPartenairepiece(ChildPartenairepiece $l)
    {
        if ($this->collPartenairepieces === null) {
            $this->initPartenairepieces();
            $this->collPartenairepiecesPartial = true;
        }

        if (!$this->collPartenairepieces->contains($l)) {
            $this->doAddPartenairepiece($l);
        }

        return $this;
    }

    /**
     * @param ChildPartenairepiece $partenairepiece The ChildPartenairepiece object to add.
     */
    protected function doAddPartenairepiece(ChildPartenairepiece $partenairepiece)
    {
        $this->collPartenairepieces[]= $partenairepiece;
        $partenairepiece->setPartenaire($this);
    }

    /**
     * @param  ChildPartenairepiece $partenairepiece The ChildPartenairepiece object to remove.
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function removePartenairepiece(ChildPartenairepiece $partenairepiece)
    {
        if ($this->getPartenairepieces()->contains($partenairepiece)) {
            $pos = $this->collPartenairepieces->search($partenairepiece);
            $this->collPartenairepieces->remove($pos);
            if (null === $this->partenairepiecesScheduledForDeletion) {
                $this->partenairepiecesScheduledForDeletion = clone $this->collPartenairepieces;
                $this->partenairepiecesScheduledForDeletion->clear();
            }
            $this->partenairepiecesScheduledForDeletion[]= $partenairepiece;
            $partenairepiece->setPartenaire(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenaire is new, it will return
     * an empty collection; or if this Partenaire has previously
     * been saved, it will retrieve related Partenairepieces from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenaire.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPartenairepiece[] List of ChildPartenairepiece objects
     */
    public function getPartenairepiecesJoinPiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPartenairepieceQuery::create(null, $criteria);
        $query->joinWith('Piece', $joinBehavior);

        return $this->getPartenairepieces($query, $con);
    }

    /**
     * Clears out the collDocs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDocs()
     */
    public function clearDocs()
    {
        $this->collDocs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDocs collection loaded partially.
     */
    public function resetPartialDocs($v = true)
    {
        $this->collDocsPartial = $v;
    }

    /**
     * Initializes the collDocs collection.
     *
     * By default this just sets the collDocs collection to an empty array (like clearcollDocs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDocs($overrideExisting = true)
    {
        if (null !== $this->collDocs && !$overrideExisting) {
            return;
        }
        $this->collDocs = new ObjectCollection();
        $this->collDocs->setModel('\Document');
    }

    /**
     * Gets an array of ChildDocument objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPartenaire is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDocument[] List of ChildDocument objects
     * @throws PropelException
     */
    public function getDocs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDocsPartial && !$this->isNew();
        if (null === $this->collDocs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDocs) {
                // return empty collection
                $this->initDocs();
            } else {
                $collDocs = ChildDocumentQuery::create(null, $criteria)
                    ->filterByPartenaire($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDocsPartial && count($collDocs)) {
                        $this->initDocs(false);

                        foreach ($collDocs as $obj) {
                            if (false == $this->collDocs->contains($obj)) {
                                $this->collDocs->append($obj);
                            }
                        }

                        $this->collDocsPartial = true;
                    }

                    return $collDocs;
                }

                if ($partial && $this->collDocs) {
                    foreach ($this->collDocs as $obj) {
                        if ($obj->isNew()) {
                            $collDocs[] = $obj;
                        }
                    }
                }

                $this->collDocs = $collDocs;
                $this->collDocsPartial = false;
            }
        }

        return $this->collDocs;
    }

    /**
     * Sets a collection of ChildDocument objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $docs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function setDocs(Collection $docs, ConnectionInterface $con = null)
    {
        /** @var ChildDocument[] $docsToDelete */
        $docsToDelete = $this->getDocs(new Criteria(), $con)->diff($docs);


        $this->docsScheduledForDeletion = $docsToDelete;

        foreach ($docsToDelete as $docRemoved) {
            $docRemoved->setPartenaire(null);
        }

        $this->collDocs = null;
        foreach ($docs as $doc) {
            $this->addDoc($doc);
        }

        $this->collDocs = $docs;
        $this->collDocsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Document objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Document objects.
     * @throws PropelException
     */
    public function countDocs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDocsPartial && !$this->isNew();
        if (null === $this->collDocs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDocs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDocs());
            }

            $query = ChildDocumentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPartenaire($this)
                ->count($con);
        }

        return count($this->collDocs);
    }

    /**
     * Method called to associate a ChildDocument object to this object
     * through the ChildDocument foreign key attribute.
     *
     * @param  ChildDocument $l ChildDocument
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function addDoc(ChildDocument $l)
    {
        if ($this->collDocs === null) {
            $this->initDocs();
            $this->collDocsPartial = true;
        }

        if (!$this->collDocs->contains($l)) {
            $this->doAddDoc($l);
        }

        return $this;
    }

    /**
     * @param ChildDocument $doc The ChildDocument object to add.
     */
    protected function doAddDoc(ChildDocument $doc)
    {
        $this->collDocs[]= $doc;
        $doc->setPartenaire($this);
    }

    /**
     * @param  ChildDocument $doc The ChildDocument object to remove.
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function removeDoc(ChildDocument $doc)
    {
        if ($this->getDocs()->contains($doc)) {
            $pos = $this->collDocs->search($doc);
            $this->collDocs->remove($pos);
            if (null === $this->docsScheduledForDeletion) {
                $this->docsScheduledForDeletion = clone $this->collDocs;
                $this->docsScheduledForDeletion->clear();
            }
            $this->docsScheduledForDeletion[]= $doc;
            $doc->setPartenaire(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenaire is new, it will return
     * an empty collection; or if this Partenaire has previously
     * been saved, it will retrieve related Docs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenaire.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDocument[] List of ChildDocument objects
     */
    public function getDocsJoinPartenairepiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDocumentQuery::create(null, $criteria);
        $query->joinWith('Partenairepiece', $joinBehavior);

        return $this->getDocs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenaire is new, it will return
     * an empty collection; or if this Partenaire has previously
     * been saved, it will retrieve related Docs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenaire.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDocument[] List of ChildDocument objects
     */
    public function getDocsJoinPiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDocumentQuery::create(null, $criteria);
        $query->joinWith('Piece', $joinBehavior);

        return $this->getDocs($query, $con);
    }

    /**
     * Clears out the collDepotpartenaires collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDepotpartenaires()
     */
    public function clearDepotpartenaires()
    {
        $this->collDepotpartenaires = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDepotpartenaires collection loaded partially.
     */
    public function resetPartialDepotpartenaires($v = true)
    {
        $this->collDepotpartenairesPartial = $v;
    }

    /**
     * Initializes the collDepotpartenaires collection.
     *
     * By default this just sets the collDepotpartenaires collection to an empty array (like clearcollDepotpartenaires());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDepotpartenaires($overrideExisting = true)
    {
        if (null !== $this->collDepotpartenaires && !$overrideExisting) {
            return;
        }
        $this->collDepotpartenaires = new ObjectCollection();
        $this->collDepotpartenaires->setModel('\Depotpartenaire');
    }

    /**
     * Gets an array of ChildDepotpartenaire objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPartenaire is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDepotpartenaire[] List of ChildDepotpartenaire objects
     * @throws PropelException
     */
    public function getDepotpartenaires(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDepotpartenairesPartial && !$this->isNew();
        if (null === $this->collDepotpartenaires || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDepotpartenaires) {
                // return empty collection
                $this->initDepotpartenaires();
            } else {
                $collDepotpartenaires = ChildDepotpartenaireQuery::create(null, $criteria)
                    ->filterByPartenaire($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDepotpartenairesPartial && count($collDepotpartenaires)) {
                        $this->initDepotpartenaires(false);

                        foreach ($collDepotpartenaires as $obj) {
                            if (false == $this->collDepotpartenaires->contains($obj)) {
                                $this->collDepotpartenaires->append($obj);
                            }
                        }

                        $this->collDepotpartenairesPartial = true;
                    }

                    return $collDepotpartenaires;
                }

                if ($partial && $this->collDepotpartenaires) {
                    foreach ($this->collDepotpartenaires as $obj) {
                        if ($obj->isNew()) {
                            $collDepotpartenaires[] = $obj;
                        }
                    }
                }

                $this->collDepotpartenaires = $collDepotpartenaires;
                $this->collDepotpartenairesPartial = false;
            }
        }

        return $this->collDepotpartenaires;
    }

    /**
     * Sets a collection of ChildDepotpartenaire objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $depotpartenaires A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function setDepotpartenaires(Collection $depotpartenaires, ConnectionInterface $con = null)
    {
        /** @var ChildDepotpartenaire[] $depotpartenairesToDelete */
        $depotpartenairesToDelete = $this->getDepotpartenaires(new Criteria(), $con)->diff($depotpartenaires);


        $this->depotpartenairesScheduledForDeletion = $depotpartenairesToDelete;

        foreach ($depotpartenairesToDelete as $depotpartenaireRemoved) {
            $depotpartenaireRemoved->setPartenaire(null);
        }

        $this->collDepotpartenaires = null;
        foreach ($depotpartenaires as $depotpartenaire) {
            $this->addDepotpartenaire($depotpartenaire);
        }

        $this->collDepotpartenaires = $depotpartenaires;
        $this->collDepotpartenairesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Depotpartenaire objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Depotpartenaire objects.
     * @throws PropelException
     */
    public function countDepotpartenaires(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDepotpartenairesPartial && !$this->isNew();
        if (null === $this->collDepotpartenaires || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDepotpartenaires) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDepotpartenaires());
            }

            $query = ChildDepotpartenaireQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPartenaire($this)
                ->count($con);
        }

        return count($this->collDepotpartenaires);
    }

    /**
     * Method called to associate a ChildDepotpartenaire object to this object
     * through the ChildDepotpartenaire foreign key attribute.
     *
     * @param  ChildDepotpartenaire $l ChildDepotpartenaire
     * @return $this|\Partenaire The current object (for fluent API support)
     */
    public function addDepotpartenaire(ChildDepotpartenaire $l)
    {
        if ($this->collDepotpartenaires === null) {
            $this->initDepotpartenaires();
            $this->collDepotpartenairesPartial = true;
        }

        if (!$this->collDepotpartenaires->contains($l)) {
            $this->doAddDepotpartenaire($l);
        }

        return $this;
    }

    /**
     * @param ChildDepotpartenaire $depotpartenaire The ChildDepotpartenaire object to add.
     */
    protected function doAddDepotpartenaire(ChildDepotpartenaire $depotpartenaire)
    {
        $this->collDepotpartenaires[]= $depotpartenaire;
        $depotpartenaire->setPartenaire($this);
    }

    /**
     * @param  ChildDepotpartenaire $depotpartenaire The ChildDepotpartenaire object to remove.
     * @return $this|ChildPartenaire The current object (for fluent API support)
     */
    public function removeDepotpartenaire(ChildDepotpartenaire $depotpartenaire)
    {
        if ($this->getDepotpartenaires()->contains($depotpartenaire)) {
            $pos = $this->collDepotpartenaires->search($depotpartenaire);
            $this->collDepotpartenaires->remove($pos);
            if (null === $this->depotpartenairesScheduledForDeletion) {
                $this->depotpartenairesScheduledForDeletion = clone $this->collDepotpartenaires;
                $this->depotpartenairesScheduledForDeletion->clear();
            }
            $this->depotpartenairesScheduledForDeletion[]= $depotpartenaire;
            $depotpartenaire->setPartenaire(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenaire is new, it will return
     * an empty collection; or if this Partenaire has previously
     * been saved, it will retrieve related Depotpartenaires from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenaire.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDepotpartenaire[] List of ChildDepotpartenaire objects
     */
    public function getDepotpartenairesJoinDepot(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDepotpartenaireQuery::create(null, $criteria);
        $query->joinWith('Depot', $joinBehavior);

        return $this->getDepotpartenaires($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->part_id = null;
        $this->part_nom = null;
        $this->part_adresse = null;
        $this->part_tel = null;
        $this->part_mail = null;
        $this->part_logo = null;
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
            if ($this->collPartenairepieces) {
                foreach ($this->collPartenairepieces as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDocs) {
                foreach ($this->collDocs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDepotpartenaires) {
                foreach ($this->collDepotpartenaires as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPartenairepieces = null;
        $this->collDocs = null;
        $this->collDepotpartenaires = null;
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
