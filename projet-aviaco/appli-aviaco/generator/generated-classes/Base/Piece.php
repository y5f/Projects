<?php

namespace Base;

use \CMDPiece as ChildCMDPiece;
use \CMDPieceQuery as ChildCMDPieceQuery;
use \CMDTAppareil as ChildCMDTAppareil;
use \CMDTAppareilQuery as ChildCMDTAppareilQuery;
use \COMCondition as ChildCOMCondition;
use \COMConditionQuery as ChildCOMConditionQuery;
use \COMEnduser as ChildCOMEnduser;
use \COMEnduserQuery as ChildCOMEnduserQuery;
use \COMVendeur as ChildCOMVendeur;
use \COMVendeurQuery as ChildCOMVendeurQuery;
use \Fournisseur as ChildFournisseur;
use \FournisseurQuery as ChildFournisseurQuery;
use \Piece as ChildPiece;
use \PieceApp as ChildPieceApp;
use \PieceAppQuery as ChildPieceAppQuery;
use \PieceQuery as ChildPieceQuery;
use \Stock as ChildStock;
use \StockQuery as ChildStockQuery;
use \Typepiece as ChildTypepiece;
use \TypepieceQuery as ChildTypepieceQuery;
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
     * The value for the type_fk field.
     * @var        string
     */
    protected $type_fk;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the pn field.
     * @var        string
     */
    protected $pn;

    /**
     * The value for the alt_pn field.
     * @var        string
     */
    protected $alt_pn;

    /**
     * The value for the otan field.
     * @var        string
     */
    protected $otan;

    /**
     * The value for the ispaperboard field.
     * @var        boolean
     */
    protected $ispaperboard;

    /**
     * The value for the comment field.
     * @var        string
     */
    protected $comment;

    /**
     * @var        ChildTypepiece
     */
    protected $aTypepiece;

    /**
     * @var        ObjectCollection|ChildPieceApp[] Collection to store aggregation of ChildPieceApp objects.
     */
    protected $collPieceApps;
    protected $collPieceAppsPartial;

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
     * @var        ObjectCollection|ChildCOMVendeur[] Collection to store aggregation of ChildCOMVendeur objects.
     */
    protected $collCOMVendeurs;
    protected $collCOMVendeursPartial;

    /**
     * @var        ObjectCollection|ChildCMDPiece[] Collection to store aggregation of ChildCMDPiece objects.
     */
    protected $collCMDPieces;
    protected $collCMDPiecesPartial;

    /**
     * @var        ObjectCollection|ChildCOMEnduser[] Collection to store aggregation of ChildCOMEnduser objects.
     */
    protected $collCOMEndusers;
    protected $collCOMEndusersPartial;

    /**
     * @var        ObjectCollection|ChildCMDTAppareil[] Collection to store aggregation of ChildCMDTAppareil objects.
     */
    protected $collCMDTAppareils;
    protected $collCMDTAppareilsPartial;

    /**
     * @var        ObjectCollection|ChildStock[] Collection to store aggregation of ChildStock objects.
     */
    protected $collStocks;
    protected $collStocksPartial;

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
     * @var ObjectCollection|ChildFournisseur[]
     */
    protected $fournisseursScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCOMCondition[]
     */
    protected $cOMConditionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCOMVendeur[]
     */
    protected $cOMVendeursScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCMDPiece[]
     */
    protected $cMDPiecesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCOMEnduser[]
     */
    protected $cOMEndusersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCMDTAppareil[]
     */
    protected $cMDTAppareilsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStock[]
     */
    protected $stocksScheduledForDeletion = null;

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
     * Get the [type_fk] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type_fk;
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
     * Get the [pn] column value.
     *
     * @return string
     */
    public function getPN()
    {
        return $this->pn;
    }

    /**
     * Get the [alt_pn] column value.
     *
     * @return string
     */
    public function getAltPN()
    {
        return $this->alt_pn;
    }

    /**
     * Get the [otan] column value.
     *
     * @return string
     */
    public function getOtan()
    {
        return $this->otan;
    }

    /**
     * Get the [ispaperboard] column value.
     *
     * @return boolean
     */
    public function getISPaperboard()
    {
        return $this->ispaperboard;
    }

    /**
     * Get the [ispaperboard] column value.
     *
     * @return boolean
     */
    public function isISPaperboard()
    {
        return $this->getISPaperboard();
    }

    /**
     * Get the [comment] column value.
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->comment;
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
     * Set the value of [type_fk] column.
     *
     * @param string $v new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type_fk !== $v) {
            $this->type_fk = $v;
            $this->modifiedColumns[PieceTableMap::COL_TYPE_FK] = true;
        }

        if ($this->aTypepiece !== null && $this->aTypepiece->getType() !== $v) {
            $this->aTypepiece = null;
        }

        return $this;
    } // setType()

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
     * Set the value of [pn] column.
     *
     * @param string $v new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setPN($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pn !== $v) {
            $this->pn = $v;
            $this->modifiedColumns[PieceTableMap::COL_PN] = true;
        }

        return $this;
    } // setPN()

    /**
     * Set the value of [alt_pn] column.
     *
     * @param string $v new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setAltPN($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alt_pn !== $v) {
            $this->alt_pn = $v;
            $this->modifiedColumns[PieceTableMap::COL_ALT_PN] = true;
        }

        return $this;
    } // setAltPN()

    /**
     * Set the value of [otan] column.
     *
     * @param string $v new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setOtan($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->otan !== $v) {
            $this->otan = $v;
            $this->modifiedColumns[PieceTableMap::COL_OTAN] = true;
        }

        return $this;
    } // setOtan()

    /**
     * Sets the value of the [ispaperboard] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setISPaperboard($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->ispaperboard !== $v) {
            $this->ispaperboard = $v;
            $this->modifiedColumns[PieceTableMap::COL_ISPAPERBOARD] = true;
        }

        return $this;
    } // setISPaperboard()

    /**
     * Set the value of [comment] column.
     *
     * @param string $v new value
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function setCommentaire($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->comment !== $v) {
            $this->comment = $v;
            $this->modifiedColumns[PieceTableMap::COL_COMMENT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PieceTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PieceTableMap::translateFieldName('Reference', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reference = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PieceTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type_fk = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PieceTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PieceTableMap::translateFieldName('PN', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pn = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PieceTableMap::translateFieldName('AltPN', TableMap::TYPE_PHPNAME, $indexType)];
            $this->alt_pn = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PieceTableMap::translateFieldName('Otan', TableMap::TYPE_PHPNAME, $indexType)];
            $this->otan = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PieceTableMap::translateFieldName('ISPaperboard', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ispaperboard = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PieceTableMap::translateFieldName('Commentaire', TableMap::TYPE_PHPNAME, $indexType)];
            $this->comment = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = PieceTableMap::NUM_HYDRATE_COLUMNS.

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
        if ($this->aTypepiece !== null && $this->type_fk !== $this->aTypepiece->getType()) {
            $this->aTypepiece = null;
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

            $this->aTypepiece = null;
            $this->collPieceApps = null;

            $this->collFournisseurs = null;

            $this->collCOMConditions = null;

            $this->collCOMVendeurs = null;

            $this->collCMDPieces = null;

            $this->collCOMEndusers = null;

            $this->collCMDTAppareils = null;

            $this->collStocks = null;

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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTypepiece !== null) {
                if ($this->aTypepiece->isModified() || $this->aTypepiece->isNew()) {
                    $affectedRows += $this->aTypepiece->save($con);
                }
                $this->setTypepiece($this->aTypepiece);
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

            if ($this->cOMVendeursScheduledForDeletion !== null) {
                if (!$this->cOMVendeursScheduledForDeletion->isEmpty()) {
                    \COMVendeurQuery::create()
                        ->filterByPrimaryKeys($this->cOMVendeursScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cOMVendeursScheduledForDeletion = null;
                }
            }

            if ($this->collCOMVendeurs !== null) {
                foreach ($this->collCOMVendeurs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cMDPiecesScheduledForDeletion !== null) {
                if (!$this->cMDPiecesScheduledForDeletion->isEmpty()) {
                    \CMDPieceQuery::create()
                        ->filterByPrimaryKeys($this->cMDPiecesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cMDPiecesScheduledForDeletion = null;
                }
            }

            if ($this->collCMDPieces !== null) {
                foreach ($this->collCMDPieces as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cOMEndusersScheduledForDeletion !== null) {
                if (!$this->cOMEndusersScheduledForDeletion->isEmpty()) {
                    \COMEnduserQuery::create()
                        ->filterByPrimaryKeys($this->cOMEndusersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cOMEndusersScheduledForDeletion = null;
                }
            }

            if ($this->collCOMEndusers !== null) {
                foreach ($this->collCOMEndusers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cMDTAppareilsScheduledForDeletion !== null) {
                if (!$this->cMDTAppareilsScheduledForDeletion->isEmpty()) {
                    \CMDTAppareilQuery::create()
                        ->filterByPrimaryKeys($this->cMDTAppareilsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cMDTAppareilsScheduledForDeletion = null;
                }
            }

            if ($this->collCMDTAppareils !== null) {
                foreach ($this->collCMDTAppareils as $referrerFK) {
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
        if ($this->isColumnModified(PieceTableMap::COL_TYPE_FK)) {
            $modifiedColumns[':p' . $index++]  = 'type_FK';
        }
        if ($this->isColumnModified(PieceTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(PieceTableMap::COL_PN)) {
            $modifiedColumns[':p' . $index++]  = 'pn';
        }
        if ($this->isColumnModified(PieceTableMap::COL_ALT_PN)) {
            $modifiedColumns[':p' . $index++]  = 'alt_pn';
        }
        if ($this->isColumnModified(PieceTableMap::COL_OTAN)) {
            $modifiedColumns[':p' . $index++]  = 'otan';
        }
        if ($this->isColumnModified(PieceTableMap::COL_ISPAPERBOARD)) {
            $modifiedColumns[':p' . $index++]  = 'ispaperboard';
        }
        if ($this->isColumnModified(PieceTableMap::COL_COMMENT)) {
            $modifiedColumns[':p' . $index++]  = 'comment';
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
                    case 'type_FK':
                        $stmt->bindValue($identifier, $this->type_fk, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'pn':
                        $stmt->bindValue($identifier, $this->pn, PDO::PARAM_STR);
                        break;
                    case 'alt_pn':
                        $stmt->bindValue($identifier, $this->alt_pn, PDO::PARAM_STR);
                        break;
                    case 'otan':
                        $stmt->bindValue($identifier, $this->otan, PDO::PARAM_STR);
                        break;
                    case 'ispaperboard':
                        $stmt->bindValue($identifier, (int) $this->ispaperboard, PDO::PARAM_INT);
                        break;
                    case 'comment':
                        $stmt->bindValue($identifier, $this->comment, PDO::PARAM_STR);
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
                return $this->getType();
                break;
            case 3:
                return $this->getDescription();
                break;
            case 4:
                return $this->getPN();
                break;
            case 5:
                return $this->getAltPN();
                break;
            case 6:
                return $this->getOtan();
                break;
            case 7:
                return $this->getISPaperboard();
                break;
            case 8:
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

        if (isset($alreadyDumpedObjects['Piece'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Piece'][$this->hashCode()] = true;
        $keys = PieceTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getReference(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getDescription(),
            $keys[4] => $this->getPN(),
            $keys[5] => $this->getAltPN(),
            $keys[6] => $this->getOtan(),
            $keys[7] => $this->getISPaperboard(),
            $keys[8] => $this->getCommentaire(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTypepiece) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'typepiece';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'typepiece';
                        break;
                    default:
                        $key = 'Typepiece';
                }

                $result[$key] = $this->aTypepiece->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collCOMVendeurs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cOMVendeurs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'vendeurs';
                        break;
                    default:
                        $key = 'COMVendeurs';
                }

                $result[$key] = $this->collCOMVendeurs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCMDPieces) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cMDPieces';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'piece_cmds';
                        break;
                    default:
                        $key = 'CMDPieces';
                }

                $result[$key] = $this->collCMDPieces->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCOMEndusers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cOMEndusers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'commande_endusers';
                        break;
                    default:
                        $key = 'COMEndusers';
                }

                $result[$key] = $this->collCOMEndusers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCMDTAppareils) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cMDTAppareils';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'cmd_apps';
                        break;
                    default:
                        $key = 'CMDTAppareils';
                }

                $result[$key] = $this->collCMDTAppareils->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
                $this->setType($value);
                break;
            case 3:
                $this->setDescription($value);
                break;
            case 4:
                $this->setPN($value);
                break;
            case 5:
                $this->setAltPN($value);
                break;
            case 6:
                $this->setOtan($value);
                break;
            case 7:
                $this->setISPaperboard($value);
                break;
            case 8:
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
        $keys = PieceTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setReference($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDescription($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPN($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAltPN($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setOtan($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setISPaperboard($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCommentaire($arr[$keys[8]]);
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
        if ($this->isColumnModified(PieceTableMap::COL_TYPE_FK)) {
            $criteria->add(PieceTableMap::COL_TYPE_FK, $this->type_fk);
        }
        if ($this->isColumnModified(PieceTableMap::COL_DESCRIPTION)) {
            $criteria->add(PieceTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(PieceTableMap::COL_PN)) {
            $criteria->add(PieceTableMap::COL_PN, $this->pn);
        }
        if ($this->isColumnModified(PieceTableMap::COL_ALT_PN)) {
            $criteria->add(PieceTableMap::COL_ALT_PN, $this->alt_pn);
        }
        if ($this->isColumnModified(PieceTableMap::COL_OTAN)) {
            $criteria->add(PieceTableMap::COL_OTAN, $this->otan);
        }
        if ($this->isColumnModified(PieceTableMap::COL_ISPAPERBOARD)) {
            $criteria->add(PieceTableMap::COL_ISPAPERBOARD, $this->ispaperboard);
        }
        if ($this->isColumnModified(PieceTableMap::COL_COMMENT)) {
            $criteria->add(PieceTableMap::COL_COMMENT, $this->comment);
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
     * @param      object $copyObj An object of \Piece (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setReference($this->getReference());
        $copyObj->setType($this->getType());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setPN($this->getPN());
        $copyObj->setAltPN($this->getAltPN());
        $copyObj->setOtan($this->getOtan());
        $copyObj->setISPaperboard($this->getISPaperboard());
        $copyObj->setCommentaire($this->getCommentaire());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPieceApps() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPieceApp($relObj->copy($deepCopy));
                }
            }

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

            foreach ($this->getCOMVendeurs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCOMVendeur($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCMDPieces() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCMDPiece($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCOMEndusers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCOMEnduser($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCMDTAppareils() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCMDTAppareil($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStocks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStock($relObj->copy($deepCopy));
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
     * Declares an association between this object and a ChildTypepiece object.
     *
     * @param  ChildTypepiece $v
     * @return $this|\Piece The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTypepiece(ChildTypepiece $v = null)
    {
        if ($v === null) {
            $this->setType(NULL);
        } else {
            $this->setType($v->getType());
        }

        $this->aTypepiece = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTypepiece object, it will not be re-added.
        if ($v !== null) {
            $v->addTypepiece($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTypepiece object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTypepiece The associated ChildTypepiece object.
     * @throws PropelException
     */
    public function getTypepiece(ConnectionInterface $con = null)
    {
        if ($this->aTypepiece === null && (($this->type_fk !== "" && $this->type_fk !== null))) {
            $this->aTypepiece = ChildTypepieceQuery::create()
                ->filterByTypepiece($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTypepiece->addTypepieces($this);
             */
        }

        return $this->aTypepiece;
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
        if ('Fournisseur' == $relationName) {
            return $this->initFournisseurs();
        }
        if ('COMCondition' == $relationName) {
            return $this->initCOMConditions();
        }
        if ('COMVendeur' == $relationName) {
            return $this->initCOMVendeurs();
        }
        if ('CMDPiece' == $relationName) {
            return $this->initCMDPieces();
        }
        if ('COMEnduser' == $relationName) {
            return $this->initCOMEndusers();
        }
        if ('CMDTAppareil' == $relationName) {
            return $this->initCMDTAppareils();
        }
        if ('Stock' == $relationName) {
            return $this->initStocks();
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
     * If this ChildPiece is new, it will return
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
                    ->filterByPiece($this)
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
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setFournisseurs(Collection $fournisseurs, ConnectionInterface $con = null)
    {
        /** @var ChildFournisseur[] $fournisseursToDelete */
        $fournisseursToDelete = $this->getFournisseurs(new Criteria(), $con)->diff($fournisseurs);


        $this->fournisseursScheduledForDeletion = $fournisseursToDelete;

        foreach ($fournisseursToDelete as $fournisseurRemoved) {
            $fournisseurRemoved->setPiece(null);
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
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collFournisseurs);
    }

    /**
     * Method called to associate a ChildFournisseur object to this object
     * through the ChildFournisseur foreign key attribute.
     *
     * @param  ChildFournisseur $l ChildFournisseur
     * @return $this|\Piece The current object (for fluent API support)
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
        $fournisseur->setPiece($this);
    }

    /**
     * @param  ChildFournisseur $fournisseur The ChildFournisseur object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
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
            $fournisseur->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
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
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFournisseur[] List of ChildFournisseur objects
     */
    public function getFournisseursJoinCondition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFournisseurQuery::create(null, $criteria);
        $query->joinWith('Condition', $joinBehavior);

        return $this->getFournisseurs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
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
     * If this ChildPiece is new, it will return
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
                    ->filterByPiece($this)
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
     * @return $this|ChildPiece The current object (for fluent API support)
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
            $cOMConditionRemoved->setPiece(null);
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
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collCOMConditions);
    }

    /**
     * Method called to associate a ChildCOMCondition object to this object
     * through the ChildCOMCondition foreign key attribute.
     *
     * @param  ChildCOMCondition $l ChildCOMCondition
     * @return $this|\Piece The current object (for fluent API support)
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
        $cOMCondition->setPiece($this);
    }

    /**
     * @param  ChildCOMCondition $cOMCondition The ChildCOMCondition object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
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
            $cOMCondition->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related COMConditions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
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
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related COMConditions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCOMCondition[] List of ChildCOMCondition objects
     */
    public function getCOMConditionsJoinCondition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCOMConditionQuery::create(null, $criteria);
        $query->joinWith('Condition', $joinBehavior);

        return $this->getCOMConditions($query, $con);
    }

    /**
     * Clears out the collCOMVendeurs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCOMVendeurs()
     */
    public function clearCOMVendeurs()
    {
        $this->collCOMVendeurs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCOMVendeurs collection loaded partially.
     */
    public function resetPartialCOMVendeurs($v = true)
    {
        $this->collCOMVendeursPartial = $v;
    }

    /**
     * Initializes the collCOMVendeurs collection.
     *
     * By default this just sets the collCOMVendeurs collection to an empty array (like clearcollCOMVendeurs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCOMVendeurs($overrideExisting = true)
    {
        if (null !== $this->collCOMVendeurs && !$overrideExisting) {
            return;
        }
        $this->collCOMVendeurs = new ObjectCollection();
        $this->collCOMVendeurs->setModel('\COMVendeur');
    }

    /**
     * Gets an array of ChildCOMVendeur objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPiece is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCOMVendeur[] List of ChildCOMVendeur objects
     * @throws PropelException
     */
    public function getCOMVendeurs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCOMVendeursPartial && !$this->isNew();
        if (null === $this->collCOMVendeurs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCOMVendeurs) {
                // return empty collection
                $this->initCOMVendeurs();
            } else {
                $collCOMVendeurs = ChildCOMVendeurQuery::create(null, $criteria)
                    ->filterByPiece($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCOMVendeursPartial && count($collCOMVendeurs)) {
                        $this->initCOMVendeurs(false);

                        foreach ($collCOMVendeurs as $obj) {
                            if (false == $this->collCOMVendeurs->contains($obj)) {
                                $this->collCOMVendeurs->append($obj);
                            }
                        }

                        $this->collCOMVendeursPartial = true;
                    }

                    return $collCOMVendeurs;
                }

                if ($partial && $this->collCOMVendeurs) {
                    foreach ($this->collCOMVendeurs as $obj) {
                        if ($obj->isNew()) {
                            $collCOMVendeurs[] = $obj;
                        }
                    }
                }

                $this->collCOMVendeurs = $collCOMVendeurs;
                $this->collCOMVendeursPartial = false;
            }
        }

        return $this->collCOMVendeurs;
    }

    /**
     * Sets a collection of ChildCOMVendeur objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cOMVendeurs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setCOMVendeurs(Collection $cOMVendeurs, ConnectionInterface $con = null)
    {
        /** @var ChildCOMVendeur[] $cOMVendeursToDelete */
        $cOMVendeursToDelete = $this->getCOMVendeurs(new Criteria(), $con)->diff($cOMVendeurs);


        $this->cOMVendeursScheduledForDeletion = $cOMVendeursToDelete;

        foreach ($cOMVendeursToDelete as $cOMVendeurRemoved) {
            $cOMVendeurRemoved->setPiece(null);
        }

        $this->collCOMVendeurs = null;
        foreach ($cOMVendeurs as $cOMVendeur) {
            $this->addCOMVendeur($cOMVendeur);
        }

        $this->collCOMVendeurs = $cOMVendeurs;
        $this->collCOMVendeursPartial = false;

        return $this;
    }

    /**
     * Returns the number of related COMVendeur objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related COMVendeur objects.
     * @throws PropelException
     */
    public function countCOMVendeurs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCOMVendeursPartial && !$this->isNew();
        if (null === $this->collCOMVendeurs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCOMVendeurs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCOMVendeurs());
            }

            $query = ChildCOMVendeurQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collCOMVendeurs);
    }

    /**
     * Method called to associate a ChildCOMVendeur object to this object
     * through the ChildCOMVendeur foreign key attribute.
     *
     * @param  ChildCOMVendeur $l ChildCOMVendeur
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function addCOMVendeur(ChildCOMVendeur $l)
    {
        if ($this->collCOMVendeurs === null) {
            $this->initCOMVendeurs();
            $this->collCOMVendeursPartial = true;
        }

        if (!$this->collCOMVendeurs->contains($l)) {
            $this->doAddCOMVendeur($l);
        }

        return $this;
    }

    /**
     * @param ChildCOMVendeur $cOMVendeur The ChildCOMVendeur object to add.
     */
    protected function doAddCOMVendeur(ChildCOMVendeur $cOMVendeur)
    {
        $this->collCOMVendeurs[]= $cOMVendeur;
        $cOMVendeur->setPiece($this);
    }

    /**
     * @param  ChildCOMVendeur $cOMVendeur The ChildCOMVendeur object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function removeCOMVendeur(ChildCOMVendeur $cOMVendeur)
    {
        if ($this->getCOMVendeurs()->contains($cOMVendeur)) {
            $pos = $this->collCOMVendeurs->search($cOMVendeur);
            $this->collCOMVendeurs->remove($pos);
            if (null === $this->cOMVendeursScheduledForDeletion) {
                $this->cOMVendeursScheduledForDeletion = clone $this->collCOMVendeurs;
                $this->cOMVendeursScheduledForDeletion->clear();
            }
            $this->cOMVendeursScheduledForDeletion[]= $cOMVendeur;
            $cOMVendeur->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related COMVendeurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCOMVendeur[] List of ChildCOMVendeur objects
     */
    public function getCOMVendeursJoinCommande(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCOMVendeurQuery::create(null, $criteria);
        $query->joinWith('Commande', $joinBehavior);

        return $this->getCOMVendeurs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related COMVendeurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCOMVendeur[] List of ChildCOMVendeur objects
     */
    public function getCOMVendeursJoinFournisseur(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCOMVendeurQuery::create(null, $criteria);
        $query->joinWith('Fournisseur', $joinBehavior);

        return $this->getCOMVendeurs($query, $con);
    }

    /**
     * Clears out the collCMDPieces collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCMDPieces()
     */
    public function clearCMDPieces()
    {
        $this->collCMDPieces = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCMDPieces collection loaded partially.
     */
    public function resetPartialCMDPieces($v = true)
    {
        $this->collCMDPiecesPartial = $v;
    }

    /**
     * Initializes the collCMDPieces collection.
     *
     * By default this just sets the collCMDPieces collection to an empty array (like clearcollCMDPieces());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCMDPieces($overrideExisting = true)
    {
        if (null !== $this->collCMDPieces && !$overrideExisting) {
            return;
        }
        $this->collCMDPieces = new ObjectCollection();
        $this->collCMDPieces->setModel('\CMDPiece');
    }

    /**
     * Gets an array of ChildCMDPiece objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPiece is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCMDPiece[] List of ChildCMDPiece objects
     * @throws PropelException
     */
    public function getCMDPieces(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCMDPiecesPartial && !$this->isNew();
        if (null === $this->collCMDPieces || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCMDPieces) {
                // return empty collection
                $this->initCMDPieces();
            } else {
                $collCMDPieces = ChildCMDPieceQuery::create(null, $criteria)
                    ->filterByPiece($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCMDPiecesPartial && count($collCMDPieces)) {
                        $this->initCMDPieces(false);

                        foreach ($collCMDPieces as $obj) {
                            if (false == $this->collCMDPieces->contains($obj)) {
                                $this->collCMDPieces->append($obj);
                            }
                        }

                        $this->collCMDPiecesPartial = true;
                    }

                    return $collCMDPieces;
                }

                if ($partial && $this->collCMDPieces) {
                    foreach ($this->collCMDPieces as $obj) {
                        if ($obj->isNew()) {
                            $collCMDPieces[] = $obj;
                        }
                    }
                }

                $this->collCMDPieces = $collCMDPieces;
                $this->collCMDPiecesPartial = false;
            }
        }

        return $this->collCMDPieces;
    }

    /**
     * Sets a collection of ChildCMDPiece objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cMDPieces A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setCMDPieces(Collection $cMDPieces, ConnectionInterface $con = null)
    {
        /** @var ChildCMDPiece[] $cMDPiecesToDelete */
        $cMDPiecesToDelete = $this->getCMDPieces(new Criteria(), $con)->diff($cMDPieces);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->cMDPiecesScheduledForDeletion = clone $cMDPiecesToDelete;

        foreach ($cMDPiecesToDelete as $cMDPieceRemoved) {
            $cMDPieceRemoved->setPiece(null);
        }

        $this->collCMDPieces = null;
        foreach ($cMDPieces as $cMDPiece) {
            $this->addCMDPiece($cMDPiece);
        }

        $this->collCMDPieces = $cMDPieces;
        $this->collCMDPiecesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CMDPiece objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CMDPiece objects.
     * @throws PropelException
     */
    public function countCMDPieces(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCMDPiecesPartial && !$this->isNew();
        if (null === $this->collCMDPieces || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCMDPieces) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCMDPieces());
            }

            $query = ChildCMDPieceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collCMDPieces);
    }

    /**
     * Method called to associate a ChildCMDPiece object to this object
     * through the ChildCMDPiece foreign key attribute.
     *
     * @param  ChildCMDPiece $l ChildCMDPiece
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function addCMDPiece(ChildCMDPiece $l)
    {
        if ($this->collCMDPieces === null) {
            $this->initCMDPieces();
            $this->collCMDPiecesPartial = true;
        }

        if (!$this->collCMDPieces->contains($l)) {
            $this->doAddCMDPiece($l);
        }

        return $this;
    }

    /**
     * @param ChildCMDPiece $cMDPiece The ChildCMDPiece object to add.
     */
    protected function doAddCMDPiece(ChildCMDPiece $cMDPiece)
    {
        $this->collCMDPieces[]= $cMDPiece;
        $cMDPiece->setPiece($this);
    }

    /**
     * @param  ChildCMDPiece $cMDPiece The ChildCMDPiece object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function removeCMDPiece(ChildCMDPiece $cMDPiece)
    {
        if ($this->getCMDPieces()->contains($cMDPiece)) {
            $pos = $this->collCMDPieces->search($cMDPiece);
            $this->collCMDPieces->remove($pos);
            if (null === $this->cMDPiecesScheduledForDeletion) {
                $this->cMDPiecesScheduledForDeletion = clone $this->collCMDPieces;
                $this->cMDPiecesScheduledForDeletion->clear();
            }
            $this->cMDPiecesScheduledForDeletion[]= clone $cMDPiece;
            $cMDPiece->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related CMDPieces from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCMDPiece[] List of ChildCMDPiece objects
     */
    public function getCMDPiecesJoinCommande(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCMDPieceQuery::create(null, $criteria);
        $query->joinWith('Commande', $joinBehavior);

        return $this->getCMDPieces($query, $con);
    }

    /**
     * Clears out the collCOMEndusers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCOMEndusers()
     */
    public function clearCOMEndusers()
    {
        $this->collCOMEndusers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCOMEndusers collection loaded partially.
     */
    public function resetPartialCOMEndusers($v = true)
    {
        $this->collCOMEndusersPartial = $v;
    }

    /**
     * Initializes the collCOMEndusers collection.
     *
     * By default this just sets the collCOMEndusers collection to an empty array (like clearcollCOMEndusers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCOMEndusers($overrideExisting = true)
    {
        if (null !== $this->collCOMEndusers && !$overrideExisting) {
            return;
        }
        $this->collCOMEndusers = new ObjectCollection();
        $this->collCOMEndusers->setModel('\COMEnduser');
    }

    /**
     * Gets an array of ChildCOMEnduser objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPiece is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCOMEnduser[] List of ChildCOMEnduser objects
     * @throws PropelException
     */
    public function getCOMEndusers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCOMEndusersPartial && !$this->isNew();
        if (null === $this->collCOMEndusers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCOMEndusers) {
                // return empty collection
                $this->initCOMEndusers();
            } else {
                $collCOMEndusers = ChildCOMEnduserQuery::create(null, $criteria)
                    ->filterByPiece($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCOMEndusersPartial && count($collCOMEndusers)) {
                        $this->initCOMEndusers(false);

                        foreach ($collCOMEndusers as $obj) {
                            if (false == $this->collCOMEndusers->contains($obj)) {
                                $this->collCOMEndusers->append($obj);
                            }
                        }

                        $this->collCOMEndusersPartial = true;
                    }

                    return $collCOMEndusers;
                }

                if ($partial && $this->collCOMEndusers) {
                    foreach ($this->collCOMEndusers as $obj) {
                        if ($obj->isNew()) {
                            $collCOMEndusers[] = $obj;
                        }
                    }
                }

                $this->collCOMEndusers = $collCOMEndusers;
                $this->collCOMEndusersPartial = false;
            }
        }

        return $this->collCOMEndusers;
    }

    /**
     * Sets a collection of ChildCOMEnduser objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cOMEndusers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setCOMEndusers(Collection $cOMEndusers, ConnectionInterface $con = null)
    {
        /** @var ChildCOMEnduser[] $cOMEndusersToDelete */
        $cOMEndusersToDelete = $this->getCOMEndusers(new Criteria(), $con)->diff($cOMEndusers);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->cOMEndusersScheduledForDeletion = clone $cOMEndusersToDelete;

        foreach ($cOMEndusersToDelete as $cOMEnduserRemoved) {
            $cOMEnduserRemoved->setPiece(null);
        }

        $this->collCOMEndusers = null;
        foreach ($cOMEndusers as $cOMEnduser) {
            $this->addCOMEnduser($cOMEnduser);
        }

        $this->collCOMEndusers = $cOMEndusers;
        $this->collCOMEndusersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related COMEnduser objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related COMEnduser objects.
     * @throws PropelException
     */
    public function countCOMEndusers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCOMEndusersPartial && !$this->isNew();
        if (null === $this->collCOMEndusers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCOMEndusers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCOMEndusers());
            }

            $query = ChildCOMEnduserQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collCOMEndusers);
    }

    /**
     * Method called to associate a ChildCOMEnduser object to this object
     * through the ChildCOMEnduser foreign key attribute.
     *
     * @param  ChildCOMEnduser $l ChildCOMEnduser
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function addCOMEnduser(ChildCOMEnduser $l)
    {
        if ($this->collCOMEndusers === null) {
            $this->initCOMEndusers();
            $this->collCOMEndusersPartial = true;
        }

        if (!$this->collCOMEndusers->contains($l)) {
            $this->doAddCOMEnduser($l);
        }

        return $this;
    }

    /**
     * @param ChildCOMEnduser $cOMEnduser The ChildCOMEnduser object to add.
     */
    protected function doAddCOMEnduser(ChildCOMEnduser $cOMEnduser)
    {
        $this->collCOMEndusers[]= $cOMEnduser;
        $cOMEnduser->setPiece($this);
    }

    /**
     * @param  ChildCOMEnduser $cOMEnduser The ChildCOMEnduser object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function removeCOMEnduser(ChildCOMEnduser $cOMEnduser)
    {
        if ($this->getCOMEndusers()->contains($cOMEnduser)) {
            $pos = $this->collCOMEndusers->search($cOMEnduser);
            $this->collCOMEndusers->remove($pos);
            if (null === $this->cOMEndusersScheduledForDeletion) {
                $this->cOMEndusersScheduledForDeletion = clone $this->collCOMEndusers;
                $this->cOMEndusersScheduledForDeletion->clear();
            }
            $this->cOMEndusersScheduledForDeletion[]= clone $cOMEnduser;
            $cOMEnduser->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related COMEndusers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCOMEnduser[] List of ChildCOMEnduser objects
     */
    public function getCOMEndusersJoinCommande(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCOMEnduserQuery::create(null, $criteria);
        $query->joinWith('Commande', $joinBehavior);

        return $this->getCOMEndusers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related COMEndusers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCOMEnduser[] List of ChildCOMEnduser objects
     */
    public function getCOMEndusersJoinEUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCOMEnduserQuery::create(null, $criteria);
        $query->joinWith('EUser', $joinBehavior);

        return $this->getCOMEndusers($query, $con);
    }

    /**
     * Clears out the collCMDTAppareils collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCMDTAppareils()
     */
    public function clearCMDTAppareils()
    {
        $this->collCMDTAppareils = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCMDTAppareils collection loaded partially.
     */
    public function resetPartialCMDTAppareils($v = true)
    {
        $this->collCMDTAppareilsPartial = $v;
    }

    /**
     * Initializes the collCMDTAppareils collection.
     *
     * By default this just sets the collCMDTAppareils collection to an empty array (like clearcollCMDTAppareils());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCMDTAppareils($overrideExisting = true)
    {
        if (null !== $this->collCMDTAppareils && !$overrideExisting) {
            return;
        }
        $this->collCMDTAppareils = new ObjectCollection();
        $this->collCMDTAppareils->setModel('\CMDTAppareil');
    }

    /**
     * Gets an array of ChildCMDTAppareil objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPiece is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCMDTAppareil[] List of ChildCMDTAppareil objects
     * @throws PropelException
     */
    public function getCMDTAppareils(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCMDTAppareilsPartial && !$this->isNew();
        if (null === $this->collCMDTAppareils || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCMDTAppareils) {
                // return empty collection
                $this->initCMDTAppareils();
            } else {
                $collCMDTAppareils = ChildCMDTAppareilQuery::create(null, $criteria)
                    ->filterByPiece($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCMDTAppareilsPartial && count($collCMDTAppareils)) {
                        $this->initCMDTAppareils(false);

                        foreach ($collCMDTAppareils as $obj) {
                            if (false == $this->collCMDTAppareils->contains($obj)) {
                                $this->collCMDTAppareils->append($obj);
                            }
                        }

                        $this->collCMDTAppareilsPartial = true;
                    }

                    return $collCMDTAppareils;
                }

                if ($partial && $this->collCMDTAppareils) {
                    foreach ($this->collCMDTAppareils as $obj) {
                        if ($obj->isNew()) {
                            $collCMDTAppareils[] = $obj;
                        }
                    }
                }

                $this->collCMDTAppareils = $collCMDTAppareils;
                $this->collCMDTAppareilsPartial = false;
            }
        }

        return $this->collCMDTAppareils;
    }

    /**
     * Sets a collection of ChildCMDTAppareil objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cMDTAppareils A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function setCMDTAppareils(Collection $cMDTAppareils, ConnectionInterface $con = null)
    {
        /** @var ChildCMDTAppareil[] $cMDTAppareilsToDelete */
        $cMDTAppareilsToDelete = $this->getCMDTAppareils(new Criteria(), $con)->diff($cMDTAppareils);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->cMDTAppareilsScheduledForDeletion = clone $cMDTAppareilsToDelete;

        foreach ($cMDTAppareilsToDelete as $cMDTAppareilRemoved) {
            $cMDTAppareilRemoved->setPiece(null);
        }

        $this->collCMDTAppareils = null;
        foreach ($cMDTAppareils as $cMDTAppareil) {
            $this->addCMDTAppareil($cMDTAppareil);
        }

        $this->collCMDTAppareils = $cMDTAppareils;
        $this->collCMDTAppareilsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CMDTAppareil objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CMDTAppareil objects.
     * @throws PropelException
     */
    public function countCMDTAppareils(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCMDTAppareilsPartial && !$this->isNew();
        if (null === $this->collCMDTAppareils || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCMDTAppareils) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCMDTAppareils());
            }

            $query = ChildCMDTAppareilQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPiece($this)
                ->count($con);
        }

        return count($this->collCMDTAppareils);
    }

    /**
     * Method called to associate a ChildCMDTAppareil object to this object
     * through the ChildCMDTAppareil foreign key attribute.
     *
     * @param  ChildCMDTAppareil $l ChildCMDTAppareil
     * @return $this|\Piece The current object (for fluent API support)
     */
    public function addCMDTAppareil(ChildCMDTAppareil $l)
    {
        if ($this->collCMDTAppareils === null) {
            $this->initCMDTAppareils();
            $this->collCMDTAppareilsPartial = true;
        }

        if (!$this->collCMDTAppareils->contains($l)) {
            $this->doAddCMDTAppareil($l);
        }

        return $this;
    }

    /**
     * @param ChildCMDTAppareil $cMDTAppareil The ChildCMDTAppareil object to add.
     */
    protected function doAddCMDTAppareil(ChildCMDTAppareil $cMDTAppareil)
    {
        $this->collCMDTAppareils[]= $cMDTAppareil;
        $cMDTAppareil->setPiece($this);
    }

    /**
     * @param  ChildCMDTAppareil $cMDTAppareil The ChildCMDTAppareil object to remove.
     * @return $this|ChildPiece The current object (for fluent API support)
     */
    public function removeCMDTAppareil(ChildCMDTAppareil $cMDTAppareil)
    {
        if ($this->getCMDTAppareils()->contains($cMDTAppareil)) {
            $pos = $this->collCMDTAppareils->search($cMDTAppareil);
            $this->collCMDTAppareils->remove($pos);
            if (null === $this->cMDTAppareilsScheduledForDeletion) {
                $this->cMDTAppareilsScheduledForDeletion = clone $this->collCMDTAppareils;
                $this->cMDTAppareilsScheduledForDeletion->clear();
            }
            $this->cMDTAppareilsScheduledForDeletion[]= clone $cMDTAppareil;
            $cMDTAppareil->setPiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related CMDTAppareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCMDTAppareil[] List of ChildCMDTAppareil objects
     */
    public function getCMDTAppareilsJoinCommande(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCMDTAppareilQuery::create(null, $criteria);
        $query->joinWith('Commande', $joinBehavior);

        return $this->getCMDTAppareils($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Piece is new, it will return
     * an empty collection; or if this Piece has previously
     * been saved, it will retrieve related CMDTAppareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Piece.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCMDTAppareil[] List of ChildCMDTAppareil objects
     */
    public function getCMDTAppareilsJoinAppareil(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCMDTAppareilQuery::create(null, $criteria);
        $query->joinWith('Appareil', $joinBehavior);

        return $this->getCMDTAppareils($query, $con);
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aTypepiece) {
            $this->aTypepiece->removeTypepiece($this);
        }
        $this->id = null;
        $this->reference = null;
        $this->type_fk = null;
        $this->description = null;
        $this->pn = null;
        $this->alt_pn = null;
        $this->otan = null;
        $this->ispaperboard = null;
        $this->comment = null;
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
            if ($this->collCOMVendeurs) {
                foreach ($this->collCOMVendeurs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCMDPieces) {
                foreach ($this->collCMDPieces as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCOMEndusers) {
                foreach ($this->collCOMEndusers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCMDTAppareils) {
                foreach ($this->collCMDTAppareils as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStocks) {
                foreach ($this->collStocks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPieceApps = null;
        $this->collFournisseurs = null;
        $this->collCOMConditions = null;
        $this->collCOMVendeurs = null;
        $this->collCMDPieces = null;
        $this->collCOMEndusers = null;
        $this->collCMDTAppareils = null;
        $this->collStocks = null;
        $this->aTypepiece = null;
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
