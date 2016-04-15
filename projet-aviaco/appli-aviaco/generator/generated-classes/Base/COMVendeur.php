<?php

namespace Base;

use \COMVendeurQuery as ChildCOMVendeurQuery;
use \Commande as ChildCommande;
use \CommandeQuery as ChildCommandeQuery;
use \Fournisseur as ChildFournisseur;
use \FournisseurQuery as ChildFournisseurQuery;
use \Piece as ChildPiece;
use \PieceQuery as ChildPieceQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\COMVendeurTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'vendeur' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class COMVendeur implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\COMVendeurTableMap';


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
     * The value for the id_vte field.
     * @var        int
     */
    protected $id_vte;

    /**
     * The value for the id_commande_fk field.
     * @var        int
     */
    protected $id_commande_fk;

    /**
     * The value for the id_piece_fk field.
     * @var        int
     */
    protected $id_piece_fk;

    /**
     * The value for the frs_id field.
     * @var        int
     */
    protected $frs_id;

    /**
     * The value for the mo field.
     * @var        string
     */
    protected $mo;

    /**
     * The value for the note field.
     * @var        string
     */
    protected $note;

    /**
     * The value for the dte_propos field.
     * @var        \DateTime
     */
    protected $dte_propos;

    /**
     * @var        ChildCommande
     */
    protected $aCommande;

    /**
     * @var        ChildFournisseur
     */
    protected $aFournisseur;

    /**
     * @var        ChildPiece
     */
    protected $aPiece;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\COMVendeur object.
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
     * Compares this with another <code>COMVendeur</code> instance.  If
     * <code>obj</code> is an instance of <code>COMVendeur</code>, delegates to
     * <code>equals(COMVendeur)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|COMVendeur The current object, for fluid interface
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
     * Get the [id_vte] column value.
     *
     * @return int
     */
    public function getIDVendeur()
    {
        return $this->id_vte;
    }

    /**
     * Get the [id_commande_fk] column value.
     *
     * @return int
     */
    public function getIDCommande_FK()
    {
        return $this->id_commande_fk;
    }

    /**
     * Get the [id_piece_fk] column value.
     *
     * @return int
     */
    public function getIDPiece_FK()
    {
        return $this->id_piece_fk;
    }

    /**
     * Get the [frs_id] column value.
     *
     * @return int
     */
    public function getIDFournisseur()
    {
        return $this->frs_id;
    }

    /**
     * Get the [mo] column value.
     *
     * @return string
     */
    public function getPMinimum()
    {
        return $this->mo;
    }

    /**
     * Get the [note] column value.
     *
     * @return string
     */
    public function getVNDNote()
    {
        return $this->note;
    }

    /**
     * Get the [optionally formatted] temporal [dte_propos] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDTEProposition($format = NULL)
    {
        if ($format === null) {
            return $this->dte_propos;
        } else {
            return $this->dte_propos instanceof \DateTime ? $this->dte_propos->format($format) : null;
        }
    }

    /**
     * Set the value of [id_vte] column.
     *
     * @param int $v new value
     * @return $this|\COMVendeur The current object (for fluent API support)
     */
    public function setIDVendeur($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_vte !== $v) {
            $this->id_vte = $v;
            $this->modifiedColumns[COMVendeurTableMap::COL_ID_VTE] = true;
        }

        return $this;
    } // setIDVendeur()

    /**
     * Set the value of [id_commande_fk] column.
     *
     * @param int $v new value
     * @return $this|\COMVendeur The current object (for fluent API support)
     */
    public function setIDCommande_FK($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_commande_fk !== $v) {
            $this->id_commande_fk = $v;
            $this->modifiedColumns[COMVendeurTableMap::COL_ID_COMMANDE_FK] = true;
        }

        if ($this->aCommande !== null && $this->aCommande->getIDCommande() !== $v) {
            $this->aCommande = null;
        }

        return $this;
    } // setIDCommande_FK()

    /**
     * Set the value of [id_piece_fk] column.
     *
     * @param int $v new value
     * @return $this|\COMVendeur The current object (for fluent API support)
     */
    public function setIDPiece_FK($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_piece_fk !== $v) {
            $this->id_piece_fk = $v;
            $this->modifiedColumns[COMVendeurTableMap::COL_ID_PIECE_FK] = true;
        }

        if ($this->aPiece !== null && $this->aPiece->getID() !== $v) {
            $this->aPiece = null;
        }

        return $this;
    } // setIDPiece_FK()

    /**
     * Set the value of [frs_id] column.
     *
     * @param int $v new value
     * @return $this|\COMVendeur The current object (for fluent API support)
     */
    public function setIDFournisseur($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->frs_id !== $v) {
            $this->frs_id = $v;
            $this->modifiedColumns[COMVendeurTableMap::COL_FRS_ID] = true;
        }

        if ($this->aFournisseur !== null && $this->aFournisseur->getID() !== $v) {
            $this->aFournisseur = null;
        }

        return $this;
    } // setIDFournisseur()

    /**
     * Set the value of [mo] column.
     *
     * @param string $v new value
     * @return $this|\COMVendeur The current object (for fluent API support)
     */
    public function setPMinimum($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mo !== $v) {
            $this->mo = $v;
            $this->modifiedColumns[COMVendeurTableMap::COL_MO] = true;
        }

        return $this;
    } // setPMinimum()

    /**
     * Set the value of [note] column.
     *
     * @param string $v new value
     * @return $this|\COMVendeur The current object (for fluent API support)
     */
    public function setVNDNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->note !== $v) {
            $this->note = $v;
            $this->modifiedColumns[COMVendeurTableMap::COL_NOTE] = true;
        }

        return $this;
    } // setVNDNote()

    /**
     * Sets the value of [dte_propos] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\COMVendeur The current object (for fluent API support)
     */
    public function setDTEProposition($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dte_propos !== null || $dt !== null) {
            if ($this->dte_propos === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->dte_propos->format("Y-m-d H:i:s")) {
                $this->dte_propos = $dt === null ? null : clone $dt;
                $this->modifiedColumns[COMVendeurTableMap::COL_DTE_PROPOS] = true;
            }
        } // if either are not null

        return $this;
    } // setDTEProposition()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : COMVendeurTableMap::translateFieldName('IDVendeur', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_vte = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : COMVendeurTableMap::translateFieldName('IDCommande_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_commande_fk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : COMVendeurTableMap::translateFieldName('IDPiece_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_piece_fk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : COMVendeurTableMap::translateFieldName('IDFournisseur', TableMap::TYPE_PHPNAME, $indexType)];
            $this->frs_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : COMVendeurTableMap::translateFieldName('PMinimum', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : COMVendeurTableMap::translateFieldName('VNDNote', TableMap::TYPE_PHPNAME, $indexType)];
            $this->note = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : COMVendeurTableMap::translateFieldName('DTEProposition', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->dte_propos = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = COMVendeurTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\COMVendeur'), 0, $e);
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
        if ($this->aCommande !== null && $this->id_commande_fk !== $this->aCommande->getIDCommande()) {
            $this->aCommande = null;
        }
        if ($this->aPiece !== null && $this->id_piece_fk !== $this->aPiece->getID()) {
            $this->aPiece = null;
        }
        if ($this->aFournisseur !== null && $this->frs_id !== $this->aFournisseur->getID()) {
            $this->aFournisseur = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(COMVendeurTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCOMVendeurQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCommande = null;
            $this->aFournisseur = null;
            $this->aPiece = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see COMVendeur::setDeleted()
     * @see COMVendeur::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(COMVendeurTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCOMVendeurQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(COMVendeurTableMap::DATABASE_NAME);
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
                COMVendeurTableMap::addInstanceToPool($this);
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

            if ($this->aCommande !== null) {
                if ($this->aCommande->isModified() || $this->aCommande->isNew()) {
                    $affectedRows += $this->aCommande->save($con);
                }
                $this->setCommande($this->aCommande);
            }

            if ($this->aFournisseur !== null) {
                if ($this->aFournisseur->isModified() || $this->aFournisseur->isNew()) {
                    $affectedRows += $this->aFournisseur->save($con);
                }
                $this->setFournisseur($this->aFournisseur);
            }

            if ($this->aPiece !== null) {
                if ($this->aPiece->isModified() || $this->aPiece->isNew()) {
                    $affectedRows += $this->aPiece->save($con);
                }
                $this->setPiece($this->aPiece);
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

        $this->modifiedColumns[COMVendeurTableMap::COL_ID_VTE] = true;
        if (null !== $this->id_vte) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . COMVendeurTableMap::COL_ID_VTE . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(COMVendeurTableMap::COL_ID_VTE)) {
            $modifiedColumns[':p' . $index++]  = 'id_vte';
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_ID_COMMANDE_FK)) {
            $modifiedColumns[':p' . $index++]  = 'id_commande_FK';
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_ID_PIECE_FK)) {
            $modifiedColumns[':p' . $index++]  = 'id_piece_FK';
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_FRS_ID)) {
            $modifiedColumns[':p' . $index++]  = 'frs_id';
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_MO)) {
            $modifiedColumns[':p' . $index++]  = 'mo';
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_NOTE)) {
            $modifiedColumns[':p' . $index++]  = 'note';
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_DTE_PROPOS)) {
            $modifiedColumns[':p' . $index++]  = 'dte_propos';
        }

        $sql = sprintf(
            'INSERT INTO vendeur (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_vte':
                        $stmt->bindValue($identifier, $this->id_vte, PDO::PARAM_INT);
                        break;
                    case 'id_commande_FK':
                        $stmt->bindValue($identifier, $this->id_commande_fk, PDO::PARAM_INT);
                        break;
                    case 'id_piece_FK':
                        $stmt->bindValue($identifier, $this->id_piece_fk, PDO::PARAM_INT);
                        break;
                    case 'frs_id':
                        $stmt->bindValue($identifier, $this->frs_id, PDO::PARAM_INT);
                        break;
                    case 'mo':
                        $stmt->bindValue($identifier, $this->mo, PDO::PARAM_STR);
                        break;
                    case 'note':
                        $stmt->bindValue($identifier, $this->note, PDO::PARAM_STR);
                        break;
                    case 'dte_propos':
                        $stmt->bindValue($identifier, $this->dte_propos ? $this->dte_propos->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $this->setIDVendeur($pk);

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
        $pos = COMVendeurTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIDVendeur();
                break;
            case 1:
                return $this->getIDCommande_FK();
                break;
            case 2:
                return $this->getIDPiece_FK();
                break;
            case 3:
                return $this->getIDFournisseur();
                break;
            case 4:
                return $this->getPMinimum();
                break;
            case 5:
                return $this->getVNDNote();
                break;
            case 6:
                return $this->getDTEProposition();
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

        if (isset($alreadyDumpedObjects['COMVendeur'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['COMVendeur'][$this->hashCode()] = true;
        $keys = COMVendeurTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIDVendeur(),
            $keys[1] => $this->getIDCommande_FK(),
            $keys[2] => $this->getIDPiece_FK(),
            $keys[3] => $this->getIDFournisseur(),
            $keys[4] => $this->getPMinimum(),
            $keys[5] => $this->getVNDNote(),
            $keys[6] => $this->getDTEProposition(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[6]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[6]];
            $result[$keys[6]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCommande) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'commande';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'commande';
                        break;
                    default:
                        $key = 'Commande';
                }

                $result[$key] = $this->aCommande->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aFournisseur) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fournisseur';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fournisseur';
                        break;
                    default:
                        $key = 'Fournisseur';
                }

                $result[$key] = $this->aFournisseur->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPiece) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'piece';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'piece';
                        break;
                    default:
                        $key = 'Piece';
                }

                $result[$key] = $this->aPiece->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\COMVendeur
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = COMVendeurTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\COMVendeur
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIDVendeur($value);
                break;
            case 1:
                $this->setIDCommande_FK($value);
                break;
            case 2:
                $this->setIDPiece_FK($value);
                break;
            case 3:
                $this->setIDFournisseur($value);
                break;
            case 4:
                $this->setPMinimum($value);
                break;
            case 5:
                $this->setVNDNote($value);
                break;
            case 6:
                $this->setDTEProposition($value);
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
        $keys = COMVendeurTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIDVendeur($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIDCommande_FK($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIDPiece_FK($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIDFournisseur($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPMinimum($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setVNDNote($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDTEProposition($arr[$keys[6]]);
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
     * @return $this|\COMVendeur The current object, for fluid interface
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
        $criteria = new Criteria(COMVendeurTableMap::DATABASE_NAME);

        if ($this->isColumnModified(COMVendeurTableMap::COL_ID_VTE)) {
            $criteria->add(COMVendeurTableMap::COL_ID_VTE, $this->id_vte);
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_ID_COMMANDE_FK)) {
            $criteria->add(COMVendeurTableMap::COL_ID_COMMANDE_FK, $this->id_commande_fk);
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_ID_PIECE_FK)) {
            $criteria->add(COMVendeurTableMap::COL_ID_PIECE_FK, $this->id_piece_fk);
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_FRS_ID)) {
            $criteria->add(COMVendeurTableMap::COL_FRS_ID, $this->frs_id);
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_MO)) {
            $criteria->add(COMVendeurTableMap::COL_MO, $this->mo);
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_NOTE)) {
            $criteria->add(COMVendeurTableMap::COL_NOTE, $this->note);
        }
        if ($this->isColumnModified(COMVendeurTableMap::COL_DTE_PROPOS)) {
            $criteria->add(COMVendeurTableMap::COL_DTE_PROPOS, $this->dte_propos);
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
        $criteria = ChildCOMVendeurQuery::create();
        $criteria->add(COMVendeurTableMap::COL_ID_VTE, $this->id_vte);

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
        $validPk = null !== $this->getIDVendeur();

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
        return $this->getIDVendeur();
    }

    /**
     * Generic method to set the primary key (id_vte column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIDVendeur($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIDVendeur();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \COMVendeur (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIDCommande_FK($this->getIDCommande_FK());
        $copyObj->setIDPiece_FK($this->getIDPiece_FK());
        $copyObj->setIDFournisseur($this->getIDFournisseur());
        $copyObj->setPMinimum($this->getPMinimum());
        $copyObj->setVNDNote($this->getVNDNote());
        $copyObj->setDTEProposition($this->getDTEProposition());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIDVendeur(NULL); // this is a auto-increment column, so set to default value
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
     * @return \COMVendeur Clone of current object.
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
     * Declares an association between this object and a ChildCommande object.
     *
     * @param  ChildCommande $v
     * @return $this|\COMVendeur The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCommande(ChildCommande $v = null)
    {
        if ($v === null) {
            $this->setIDCommande_FK(NULL);
        } else {
            $this->setIDCommande_FK($v->getIDCommande());
        }

        $this->aCommande = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCommande object, it will not be re-added.
        if ($v !== null) {
            $v->addCOMVendeur($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCommande object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCommande The associated ChildCommande object.
     * @throws PropelException
     */
    public function getCommande(ConnectionInterface $con = null)
    {
        if ($this->aCommande === null && ($this->id_commande_fk !== null)) {
            $this->aCommande = ChildCommandeQuery::create()->findPk($this->id_commande_fk, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCommande->addCOMVendeurs($this);
             */
        }

        return $this->aCommande;
    }

    /**
     * Declares an association between this object and a ChildFournisseur object.
     *
     * @param  ChildFournisseur $v
     * @return $this|\COMVendeur The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFournisseur(ChildFournisseur $v = null)
    {
        if ($v === null) {
            $this->setIDFournisseur(NULL);
        } else {
            $this->setIDFournisseur($v->getID());
        }

        $this->aFournisseur = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildFournisseur object, it will not be re-added.
        if ($v !== null) {
            $v->addCOMVendeur($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildFournisseur object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildFournisseur The associated ChildFournisseur object.
     * @throws PropelException
     */
    public function getFournisseur(ConnectionInterface $con = null)
    {
        if ($this->aFournisseur === null && ($this->frs_id !== null)) {
            $this->aFournisseur = ChildFournisseurQuery::create()->findPk($this->frs_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFournisseur->addCOMVendeurs($this);
             */
        }

        return $this->aFournisseur;
    }

    /**
     * Declares an association between this object and a ChildPiece object.
     *
     * @param  ChildPiece $v
     * @return $this|\COMVendeur The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPiece(ChildPiece $v = null)
    {
        if ($v === null) {
            $this->setIDPiece_FK(NULL);
        } else {
            $this->setIDPiece_FK($v->getID());
        }

        $this->aPiece = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPiece object, it will not be re-added.
        if ($v !== null) {
            $v->addCOMVendeur($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPiece object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPiece The associated ChildPiece object.
     * @throws PropelException
     */
    public function getPiece(ConnectionInterface $con = null)
    {
        if ($this->aPiece === null && ($this->id_piece_fk !== null)) {
            $this->aPiece = ChildPieceQuery::create()->findPk($this->id_piece_fk, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPiece->addCOMVendeurs($this);
             */
        }

        return $this->aPiece;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCommande) {
            $this->aCommande->removeCOMVendeur($this);
        }
        if (null !== $this->aFournisseur) {
            $this->aFournisseur->removeCOMVendeur($this);
        }
        if (null !== $this->aPiece) {
            $this->aPiece->removeCOMVendeur($this);
        }
        $this->id_vte = null;
        $this->id_commande_fk = null;
        $this->id_piece_fk = null;
        $this->frs_id = null;
        $this->mo = null;
        $this->note = null;
        $this->dte_propos = null;
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
        } // if ($deep)

        $this->aCommande = null;
        $this->aFournisseur = null;
        $this->aPiece = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(COMVendeurTableMap::DEFAULT_STRING_FORMAT);
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
