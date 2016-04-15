<?php

namespace Base;

use \Document as ChildDocument;
use \DocumentQuery as ChildDocumentQuery;
use \Partenairepiece as ChildPartenairepiece;
use \PartenairepieceQuery as ChildPartenairepieceQuery;
use \Photopiece as ChildPhotopiece;
use \PhotopieceQuery as ChildPhotopieceQuery;
use \Piece as ChildPiece;
use \PieceApp as ChildPieceApp;
use \PieceAppQuery as ChildPieceAppQuery;
use \PieceQuery as ChildPieceQuery;
use \Stock as ChildStock;
use \StockQuery as ChildStockQuery;
use \Stockdepot as ChildStockdepot;
use \StockdepotQuery as ChildStockdepotQuery;
use \Exception;
use \PDO;
use Map\PieceTableMap;
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
 * Base class that represents a row from the 'piece' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Piece implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PieceTableMap';


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
     * The value for the reference field.
     * @var        string
     */
    protected $reference;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * @var        ObjectCollection|ChildPieceApp[] Collection to store aggregation of ChildPieceApp objects.
     */
    protected $collPieceApps;
    protected $collPieceAppsPartial;

    /**
     * @var        ObjectCollection|ChildPhotopiece[] Collection to store aggregation of ChildPhotopiece objects.
     */
    protected $collPhotopieces;
    protected $collPhotopiecesPartial;

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
     * @var        ObjectCollection|ChildStock[] Collection to store aggregation of ChildStock objects.
     */
    protected $collStocks;
    protected $collStocksPartial;

    /**
     * @var        ObjectCollection|ChildStockdepot[] Collection to store aggregation of ChildStockdepot objects.
     */
    protected $collStockdepots;
    protected $collStockdepotsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPieceApp[]
     */
    protected $pieceAppsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPhotopiece[]
     */
    protected $photopiecesScheduledForDeletion = null;

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
     * @var ObjectCollection|ChildStock[]
     */
    protected $stocksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStockdepot[]
     */
    protected $stockdepotsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Piece object.
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
     * Compares this with another <code>Piece</code> instance.  If
     * <code>obj</code> is an instance of <code>Piece</code>, delegates to
     * <code>equals(Piece)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Piece The current object, for fluid interface
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
     * Get the [reference] column value.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PieceTableMap::COL_ID] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [reference] column.
     *
     * @param string $v new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setReference($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->reference !== $v) {
            $this->reference = $v;
            $this->modifiedColumns[PieceTableMap::COL_REFERENCE] = true;
        }

        return $this;
    } // setReference()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[PieceTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PieceTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PieceTableMap::translateFieldName('Reference', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reference = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PieceTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = PieceTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Piece'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PieceTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPieceQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collPieceApps = null;

            $this->collPhotopieces = null;

            $this->collPartenairepieces = null;

            $this->collDocs = null;

            $this->collStocks = null;

            $this->collStockdepots = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Piece::setDeleted()
     * @see Piece::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PieceTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPieceQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PieceTableMap::DATABASE_NAME);
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
                PieceTableMap::addInstanceToPool($this);
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

            if ($this->photopiecesScheduledForDeletion !== null) {
                if (!$this->photopiecesScheduledForDeletion->isEmpty()) {
                    \PhotopieceQuery::create()
                        ->filterByPrimaryKeys($this->photopiecesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->photopiecesScheduledForDeletion = null;
                }
            }

            if ($this->collPhotopieces !== null) {
                foreach ($this->collPhotopieces as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

            if ($this->stocksScheduledForDeletion !== null) {
                if (!$this->stocksScheduledForDeletion->isEmpty()) {
                    \StockQuery::create()
                        ->filterByPrimaryKeys($this->stocksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stocksScheduledForDeletion = null;
                }
            }

            if ($this->collStocks !== null) {
                foreach ($this->collStocks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stockdepotsScheduledForDeletion !== null) {
                if (!$this->stockdepotsScheduledForDeletion->isEmpty()) {
                    \StockdepotQuery::create()
                        ->filterByPrimaryKeys($this->stockdepotsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stockdepotsScheduledForDeletion = null;
                }
            }

            if ($this->collStockdepots !== null) {
                foreach ($this->collStockdepots as $referrerFK) {
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

        $this->modifiedColumns[PieceTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PieceTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PieceTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PieceTableMap::COL_REFERENCE)) {
            $modifiedColumns[':p' . $index++]  = 'reference';
        }
        if ($this->isColumnModified(PieceTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }

        $sql = sprintf(
            'INSERT INTO piece (%s) VALUES (%s)',
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
                    case 'reference':
                        $stmt->bindValue($identifier, $this->reference, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
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
        $pos = PieceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getReference();
                break;
            case 2:
                return $this->getDescription();
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

        if (isset($alreadyDumpedObjects['Piece'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Piece'][$this->hashCode()] = true;
        $keys = PieceTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getReference(),
            $keys[2] => $this->getDescription(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collPhotopieces) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'photopieces';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'photo_pieces';
                        break;
                    default:
                        $key = 'Photopieces';
                }

                $result[$key] = $this->collPhotopieces->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
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
            if (null !== $this->collStocks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'stocks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'stocks';
                        break;
                    default:
                        $key = 'Stocks';
                }

                $result[$key] = $this->collStocks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStockdepots) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'stockdepots';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'stock_depots';
                        break;
                    default:
                        $key = 'Stockdepots';
                }

                $result[$key] = $this->collStockdepots->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Piece
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PieceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Piece
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setID($value);
                break;
            case 1:
                $this->setReference($value);
                break;
            case 2:
                $this->setDescription($value);
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
        $keys = PieceTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setReference($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescription($arr[$keys[2]]);
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
     * @return $this|\Piece The current object, for fluid interface
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
        $criteria = new Criteria(PieceTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PieceTableMap::COL_ID)) {
            $criteria->add(PieceTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PieceTableMap::COL_REFERENCE)) {
            $criteria->add(PieceTableMap::COL_REFERENCE, $this->reference);
        }
        if ($this->isColumnModified(PieceTableMap::COL_DESCRIPTION)) {
            $criteria->add(PieceTableMap::COL_DESCRIPTION, $this->description);
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
        $criteria = ChildPieceQuery::create();
        $criteria->add(PieceTableMap::COL_ID, $this->id);
        $criteria->add(PieceTableMap::COL_REFERENCE, $this->reference);

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
        $validPk = null !== $this->getID() &&
            null !== $this->getReference();

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
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getID();
        $pks[1] = $this->getReference();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setID($keys[0]);
        $this->setReference($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getID()) && (null === $this->getReference());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Piece (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setReference($this->getReference());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPieceApps() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPieceApp($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPhotopieces() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPhotopiece($relObj->copy($deepCopy));
                }
            }

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

            foreach ($this->getStocks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStock($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStockdepots() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStockdepot($relObj->copy($deepCopy));
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
     * @return \Piece Clone of current object.
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
        if ('PieceApp' == $relationName) {
            return $this->initPieceApps();
        }
        if ('Photopiece' == $relationName) {
            return $this->initPhotopieces();
        }
        if ('Partenairepiece' == $relationName) {
            return $this->initPartenairepieces();
        }
        if ('Doc' == $relationName) {
            return $this->initDocs();
        }
        if ('Stock' == $relationName) {
            return $this->initStocks();
        }
        if ('Stockdepot' == $relationName) {
            return $this->initStockdepots();
        }
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
     * If this ChildPiece is new, it will return
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
                    ->filterByPiece($this)
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
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setPieceApps(Collection $pieceApps, ConnectionInterface $con = null)
    {
        /** @var ChildPieceApp[] $pieceAppsToDelete */
        $pieceAppsToDelete = $this->getPieceApps(new Criteria(), $con)->diff($pieceApps);


        $this->pieceAppsScheduledForDeletion = $pieceAppsToDelete;

        foreach ($pieceAppsToDelete as $pieceAppRemoved) {
            $pieceAppRemoved->setPiece(null);
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
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collPieceApps);
    }

    /**
     * Method called to associate a ChildPieceApp object to this object
     * through the ChildPieceApp foreign key attribute.
     *
     * @param  ChildPieceApp $l ChildPieceApp
     * @return $this|\Piece The current object (for fluent API support)
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
        $pieceApp->setPiece($this);
    }

    /**
     * @param  ChildPieceApp $pieceApp The ChildPieceApp object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
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
            $pieceApp->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related PieceApps from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
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
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related PieceApps from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPieceApp[] List of ChildPieceApp objects
     */
    public function getPieceAppsJoinModele(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPieceAppQuery::create(null, $criteria);
        $query->joinWith('Modele', $joinBehavior);

        return $this->getPieceApps($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related PieceApps from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
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
     * Clears out the collPhotopieces collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPhotopieces()
     */
    public function clearPhotopieces()
    {
        $this->collPhotopieces = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPhotopieces collection loaded partially.
     */
    public function resetPartialPhotopieces($v = true)
    {
        $this->collPhotopiecesPartial = $v;
    }

    /**
     * Initializes the collPhotopieces collection.
     *
     * By default this just sets the collPhotopieces collection to an empty array (like clearcollPhotopieces());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPhotopieces($overrideExisting = true)
    {
        if (null !== $this->collPhotopieces && !$overrideExisting) {
            return;
        }
        $this->collPhotopieces = new ObjectCollection();
        $this->collPhotopieces->setModel('\Photopiece');
    }

    /**
     * Gets an array of ChildPhotopiece objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPiece is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPhotopiece[] List of ChildPhotopiece objects
     * @throws PropelException
     */
    public function getPhotopieces(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPhotopiecesPartial && !$this->isNew();
        if (null === $this->collPhotopieces || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPhotopieces) {
                // return empty collection
                $this->initPhotopieces();
            } else {
                $collPhotopieces = ChildPhotopieceQuery::create(null, $criteria)
                    ->filterByPiece($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPhotopiecesPartial && count($collPhotopieces)) {
                        $this->initPhotopieces(false);

                        foreach ($collPhotopieces as $obj) {
                            if (false == $this->collPhotopieces->contains($obj)) {
                                $this->collPhotopieces->append($obj);
                            }
                        }

                        $this->collPhotopiecesPartial = true;
                    }

                    return $collPhotopieces;
                }

                if ($partial && $this->collPhotopieces) {
                    foreach ($this->collPhotopieces as $obj) {
                        if ($obj->isNew()) {
                            $collPhotopieces[] = $obj;
                        }
                    }
                }

                $this->collPhotopieces = $collPhotopieces;
                $this->collPhotopiecesPartial = false;
            }
        }

        return $this->collPhotopieces;
    }

    /**
     * Sets a collection of ChildPhotopiece objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $photopieces A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setPhotopieces(Collection $photopieces, ConnectionInterface $con = null)
    {
        /** @var ChildPhotopiece[] $photopiecesToDelete */
        $photopiecesToDelete = $this->getPhotopieces(new Criteria(), $con)->diff($photopieces);


        $this->photopiecesScheduledForDeletion = $photopiecesToDelete;

        foreach ($photopiecesToDelete as $photopieceRemoved) {
            $photopieceRemoved->setPiece(null);
        }

        $this->collPhotopieces = null;
        foreach ($photopieces as $photopiece) {
            $this->addPhotopiece($photopiece);
        }

        $this->collPhotopieces = $photopieces;
        $this->collPhotopiecesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Photopiece objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Photopiece objects.
     * @throws PropelException
     */
    public function countPhotopieces(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPhotopiecesPartial && !$this->isNew();
        if (null === $this->collPhotopieces || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPhotopieces) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPhotopieces());
            }

            $query = ChildPhotopieceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collPhotopieces);
    }

    /**
     * Method called to associate a ChildPhotopiece object to this object
     * through the ChildPhotopiece foreign key attribute.
     *
     * @param  ChildPhotopiece $l ChildPhotopiece
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function addPhotopiece(ChildPhotopiece $l)
    {
        if ($this->collPhotopieces === null) {
            $this->initPhotopieces();
            $this->collPhotopiecesPartial = true;
        }

        if (!$this->collPhotopieces->contains($l)) {
            $this->doAddPhotopiece($l);
        }

        return $this;
    }

    /**
     * @param ChildPhotopiece $photopiece The ChildPhotopiece object to add.
     */
    protected function doAddPhotopiece(ChildPhotopiece $photopiece)
    {
        $this->collPhotopieces[]= $photopiece;
        $photopiece->setPiece($this);
    }

    /**
     * @param  ChildPhotopiece $photopiece The ChildPhotopiece object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function removePhotopiece(ChildPhotopiece $photopiece)
    {
        if ($this->getPhotopieces()->contains($photopiece)) {
            $pos = $this->collPhotopieces->search($photopiece);
            $this->collPhotopieces->remove($pos);
            if (null === $this->photopiecesScheduledForDeletion) {
                $this->photopiecesScheduledForDeletion = clone $this->collPhotopieces;
                $this->photopiecesScheduledForDeletion->clear();
            }
            $this->photopiecesScheduledForDeletion[]= $photopiece;
            $photopiece->setPiece(null);
        }

        return $this;
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
     * If this ChildPiece is new, it will return
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
                    ->filterByPiece($this)
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
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setPartenairepieces(Collection $partenairepieces, ConnectionInterface $con = null)
    {
        /** @var ChildPartenairepiece[] $partenairepiecesToDelete */
        $partenairepiecesToDelete = $this->getPartenairepieces(new Criteria(), $con)->diff($partenairepieces);


        $this->partenairepiecesScheduledForDeletion = $partenairepiecesToDelete;

        foreach ($partenairepiecesToDelete as $partenairepieceRemoved) {
            $partenairepieceRemoved->setPiece(null);
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
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collPartenairepieces);
    }

    /**
     * Method called to associate a ChildPartenairepiece object to this object
     * through the ChildPartenairepiece foreign key attribute.
     *
     * @param  ChildPartenairepiece $l ChildPartenairepiece
     * @return $this|\Piece The current object (for fluent API support)
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
        $partenairepiece->setPiece($this);
    }

    /**
     * @param  ChildPartenairepiece $partenairepiece The ChildPartenairepiece object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
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
            $partenairepiece->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related Partenairepieces from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPartenairepiece[] List of ChildPartenairepiece objects
     */
    public function getPartenairepiecesJoinPartenaire(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPartenairepieceQuery::create(null, $criteria);
        $query->joinWith('Partenaire', $joinBehavior);

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
     * If this ChildPiece is new, it will return
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
                    ->filterByPiece($this)
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
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setDocs(Collection $docs, ConnectionInterface $con = null)
    {
        /** @var ChildDocument[] $docsToDelete */
        $docsToDelete = $this->getDocs(new Criteria(), $con)->diff($docs);


        $this->docsScheduledForDeletion = $docsToDelete;

        foreach ($docsToDelete as $docRemoved) {
            $docRemoved->setPiece(null);
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
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collDocs);
    }

    /**
     * Method called to associate a ChildDocument object to this object
     * through the ChildDocument foreign key attribute.
     *
     * @param  ChildDocument $l ChildDocument
     * @return $this|\Piece The current object (for fluent API support)
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
        $doc->setPiece($this);
    }

    /**
     * @param  ChildDocument $doc The ChildDocument object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
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
            $doc->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related Docs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
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
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related Docs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDocument[] List of ChildDocument objects
     */
    public function getDocsJoinPartenaire(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDocumentQuery::create(null, $criteria);
        $query->joinWith('Partenaire', $joinBehavior);

        return $this->getDocs($query, $con);
    }

    /**
     * Clears out the collStocks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStocks()
     */
    public function clearStocks()
    {
        $this->collStocks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStocks collection loaded partially.
     */
    public function resetPartialStocks($v = true)
    {
        $this->collStocksPartial = $v;
    }

    /**
     * Initializes the collStocks collection.
     *
     * By default this just sets the collStocks collection to an empty array (like clearcollStocks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStocks($overrideExisting = true)
    {
        if (null !== $this->collStocks && !$overrideExisting) {
            return;
        }
        $this->collStocks = new ObjectCollection();
        $this->collStocks->setModel('\Stock');
    }

    /**
     * Gets an array of ChildStock objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPiece is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStock[] List of ChildStock objects
     * @throws PropelException
     */
    public function getStocks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStocksPartial && !$this->isNew();
        if (null === $this->collStocks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStocks) {
                // return empty collection
                $this->initStocks();
            } else {
                $collStocks = ChildStockQuery::create(null, $criteria)
                    ->filterByPiece($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStocksPartial && count($collStocks)) {
                        $this->initStocks(false);

                        foreach ($collStocks as $obj) {
                            if (false == $this->collStocks->contains($obj)) {
                                $this->collStocks->append($obj);
                            }
                        }

                        $this->collStocksPartial = true;
                    }

                    return $collStocks;
                }

                if ($partial && $this->collStocks) {
                    foreach ($this->collStocks as $obj) {
                        if ($obj->isNew()) {
                            $collStocks[] = $obj;
                        }
                    }
                }

                $this->collStocks = $collStocks;
                $this->collStocksPartial = false;
            }
        }

        return $this->collStocks;
    }

    /**
     * Sets a collection of ChildStock objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $stocks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setStocks(Collection $stocks, ConnectionInterface $con = null)
    {
        /** @var ChildStock[] $stocksToDelete */
        $stocksToDelete = $this->getStocks(new Criteria(), $con)->diff($stocks);


        $this->stocksScheduledForDeletion = $stocksToDelete;

        foreach ($stocksToDelete as $stockRemoved) {
            $stockRemoved->setPiece(null);
        }

        $this->collStocks = null;
        foreach ($stocks as $stock) {
            $this->addStock($stock);
        }

        $this->collStocks = $stocks;
        $this->collStocksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Stock objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Stock objects.
     * @throws PropelException
     */
    public function countStocks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStocksPartial && !$this->isNew();
        if (null === $this->collStocks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStocks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStocks());
            }

            $query = ChildStockQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collStocks);
    }

    /**
     * Method called to associate a ChildStock object to this object
     * through the ChildStock foreign key attribute.
     *
     * @param  ChildStock $l ChildStock
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function addStock(ChildStock $l)
    {
        if ($this->collStocks === null) {
            $this->initStocks();
            $this->collStocksPartial = true;
        }

        if (!$this->collStocks->contains($l)) {
            $this->doAddStock($l);
        }

        return $this;
    }

    /**
     * @param ChildStock $stock The ChildStock object to add.
     */
    protected function doAddStock(ChildStock $stock)
    {
        $this->collStocks[]= $stock;
        $stock->setPiece($this);
    }

    /**
     * @param  ChildStock $stock The ChildStock object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function removeStock(ChildStock $stock)
    {
        if ($this->getStocks()->contains($stock)) {
            $pos = $this->collStocks->search($stock);
            $this->collStocks->remove($pos);
            if (null === $this->stocksScheduledForDeletion) {
                $this->stocksScheduledForDeletion = clone $this->collStocks;
                $this->stocksScheduledForDeletion->clear();
            }
            $this->stocksScheduledForDeletion[]= $stock;
            $stock->setPiece(null);
        }

        return $this;
    }

    /**
     * Clears out the collStockdepots collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStockdepots()
     */
    public function clearStockdepots()
    {
        $this->collStockdepots = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStockdepots collection loaded partially.
     */
    public function resetPartialStockdepots($v = true)
    {
        $this->collStockdepotsPartial = $v;
    }

    /**
     * Initializes the collStockdepots collection.
     *
     * By default this just sets the collStockdepots collection to an empty array (like clearcollStockdepots());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStockdepots($overrideExisting = true)
    {
        if (null !== $this->collStockdepots && !$overrideExisting) {
            return;
        }
        $this->collStockdepots = new ObjectCollection();
        $this->collStockdepots->setModel('\Stockdepot');
    }

    /**
     * Gets an array of ChildStockdepot objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPiece is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStockdepot[] List of ChildStockdepot objects
     * @throws PropelException
     */
    public function getStockdepots(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStockdepotsPartial && !$this->isNew();
        if (null === $this->collStockdepots || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStockdepots) {
                // return empty collection
                $this->initStockdepots();
            } else {
                $collStockdepots = ChildStockdepotQuery::create(null, $criteria)
                    ->filterByPiece($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStockdepotsPartial && count($collStockdepots)) {
                        $this->initStockdepots(false);

                        foreach ($collStockdepots as $obj) {
                            if (false == $this->collStockdepots->contains($obj)) {
                                $this->collStockdepots->append($obj);
                            }
                        }

                        $this->collStockdepotsPartial = true;
                    }

                    return $collStockdepots;
                }

                if ($partial && $this->collStockdepots) {
                    foreach ($this->collStockdepots as $obj) {
                        if ($obj->isNew()) {
                            $collStockdepots[] = $obj;
                        }
                    }
                }

                $this->collStockdepots = $collStockdepots;
                $this->collStockdepotsPartial = false;
            }
        }

        return $this->collStockdepots;
    }

    /**
     * Sets a collection of ChildStockdepot objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $stockdepots A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setStockdepots(Collection $stockdepots, ConnectionInterface $con = null)
    {
        /** @var ChildStockdepot[] $stockdepotsToDelete */
        $stockdepotsToDelete = $this->getStockdepots(new Criteria(), $con)->diff($stockdepots);


        $this->stockdepotsScheduledForDeletion = $stockdepotsToDelete;

        foreach ($stockdepotsToDelete as $stockdepotRemoved) {
            $stockdepotRemoved->setPiece(null);
        }

        $this->collStockdepots = null;
        foreach ($stockdepots as $stockdepot) {
            $this->addStockdepot($stockdepot);
        }

        $this->collStockdepots = $stockdepots;
        $this->collStockdepotsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Stockdepot objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Stockdepot objects.
     * @throws PropelException
     */
    public function countStockdepots(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStockdepotsPartial && !$this->isNew();
        if (null === $this->collStockdepots || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStockdepots) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStockdepots());
            }

            $query = ChildStockdepotQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collStockdepots);
    }

    /**
     * Method called to associate a ChildStockdepot object to this object
     * through the ChildStockdepot foreign key attribute.
     *
     * @param  ChildStockdepot $l ChildStockdepot
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function addStockdepot(ChildStockdepot $l)
    {
        if ($this->collStockdepots === null) {
            $this->initStockdepots();
            $this->collStockdepotsPartial = true;
        }

        if (!$this->collStockdepots->contains($l)) {
            $this->doAddStockdepot($l);
        }

        return $this;
    }

    /**
     * @param ChildStockdepot $stockdepot The ChildStockdepot object to add.
     */
    protected function doAddStockdepot(ChildStockdepot $stockdepot)
    {
        $this->collStockdepots[]= $stockdepot;
        $stockdepot->setPiece($this);
    }

    /**
     * @param  ChildStockdepot $stockdepot The ChildStockdepot object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function removeStockdepot(ChildStockdepot $stockdepot)
    {
        if ($this->getStockdepots()->contains($stockdepot)) {
            $pos = $this->collStockdepots->search($stockdepot);
            $this->collStockdepots->remove($pos);
            if (null === $this->stockdepotsScheduledForDeletion) {
                $this->stockdepotsScheduledForDeletion = clone $this->collStockdepots;
                $this->stockdepotsScheduledForDeletion->clear();
            }
            $this->stockdepotsScheduledForDeletion[]= $stockdepot;
            $stockdepot->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related Stockdepots from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockdepot[] List of ChildStockdepot objects
     */
    public function getStockdepotsJoinStock(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockdepotQuery::create(null, $criteria);
        $query->joinWith('Stock', $joinBehavior);

        return $this->getStockdepots($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related Stockdepots from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStockdepot[] List of ChildStockdepot objects
     */
    public function getStockdepotsJoinDepot(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStockdepotQuery::create(null, $criteria);
        $query->joinWith('Depot', $joinBehavior);

        return $this->getStockdepots($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->reference = null;
        $this->description = null;
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
            if ($this->collPieceApps) {
                foreach ($this->collPieceApps as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPhotopieces) {
                foreach ($this->collPhotopieces as $o) {
                    $o->clearAllReferences($deep);
                }
            }
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
            if ($this->collStocks) {
                foreach ($this->collStocks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStockdepots) {
                foreach ($this->collStockdepots as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPieceApps = null;
        $this->collPhotopieces = null;
        $this->collPartenairepieces = null;
        $this->collDocs = null;
        $this->collStocks = null;
        $this->collStockdepots = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PieceTableMap::DEFAULT_STRING_FORMAT);
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
