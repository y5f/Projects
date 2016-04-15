<?php

namespace Base;

use \Document as ChildDocument;
use \DocumentQuery as ChildDocumentQuery;
use \Partenaire as ChildPartenaire;
use \PartenaireQuery as ChildPartenaireQuery;
use \Partenairepiece as ChildPartenairepiece;
use \PartenairepieceQuery as ChildPartenairepieceQuery;
use \Piece as ChildPiece;
use \PieceQuery as ChildPieceQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\PartenairepieceTableMap;
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
 * Base class that represents a row from the 'partenaire_piece' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Partenairepiece implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PartenairepieceTableMap';


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
     * The value for the quantite field.
     * @var        int
     */
    protected $quantite;

    /**
     * The value for the prix_achat field.
     * @var        double
     */
    protected $prix_achat;

    /**
     * The value for the prix_vente field.
     * @var        double
     */
    protected $prix_vente;

    /**
     * The value for the date_enreg field.
     * @var        \DateTime
     */
    protected $date_enreg;

    /**
     * The value for the reference_pk field.
     * @var        string
     */
    protected $reference_pk;

    /**
     * The value for the part_id_pk field.
     * @var        int
     */
    protected $part_id_pk;

    /**
     * @var        ChildPiece
     */
    protected $aPiece;

    /**
     * @var        ChildPartenaire
     */
    protected $aPartenaire;

    /**
     * @var        ObjectCollection|ChildDocument[] Collection to store aggregation of ChildDocument objects.
     */
    protected $collDocs;
    protected $collDocsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDocument[]
     */
    protected $docsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Partenairepiece object.
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
     * Compares this with another <code>Partenairepiece</code> instance.  If
     * <code>obj</code> is an instance of <code>Partenairepiece</code>, delegates to
     * <code>equals(Partenairepiece)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Partenairepiece The current object, for fluid interface
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
     * Get the [quantite] column value.
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Get the [prix_achat] column value.
     *
     * @return double
     */
    public function getPrixachat()
    {
        return $this->prix_achat;
    }

    /**
     * Get the [prix_vente] column value.
     *
     * @return double
     */
    public function getPrixvente()
    {
        return $this->prix_vente;
    }

    /**
     * Get the [optionally formatted] temporal [date_enreg] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateenregistrement($format = NULL)
    {
        if ($format === null) {
            return $this->date_enreg;
        } else {
            return $this->date_enreg instanceof \DateTime ? $this->date_enreg->format($format) : null;
        }
    }

    /**
     * Get the [reference_pk] column value.
     *
     * @return string
     */
    public function getReference_PK()
    {
        return $this->reference_pk;
    }

    /**
     * Get the [part_id_pk] column value.
     *
     * @return int
     */
    public function getPartenaire_PK()
    {
        return $this->part_id_pk;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Partenairepiece The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PartenairepieceTableMap::COL_ID] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [quantite] column.
     *
     * @param int $v new value
     * @return $this|\Partenairepiece The current object (for fluent API support)
     */
    public function setQuantite($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->quantite !== $v) {
            $this->quantite = $v;
            $this->modifiedColumns[PartenairepieceTableMap::COL_QUANTITE] = true;
        }

        return $this;
    } // setQuantite()

    /**
     * Set the value of [prix_achat] column.
     *
     * @param double $v new value
     * @return $this|\Partenairepiece The current object (for fluent API support)
     */
    public function setPrixachat($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->prix_achat !== $v) {
            $this->prix_achat = $v;
            $this->modifiedColumns[PartenairepieceTableMap::COL_PRIX_ACHAT] = true;
        }

        return $this;
    } // setPrixachat()

    /**
     * Set the value of [prix_vente] column.
     *
     * @param double $v new value
     * @return $this|\Partenairepiece The current object (for fluent API support)
     */
    public function setPrixvente($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->prix_vente !== $v) {
            $this->prix_vente = $v;
            $this->modifiedColumns[PartenairepieceTableMap::COL_PRIX_VENTE] = true;
        }

        return $this;
    } // setPrixvente()

    /**
     * Sets the value of [date_enreg] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Partenairepiece The current object (for fluent API support)
     */
    public function setDateenregistrement($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_enreg !== null || $dt !== null) {
            if ($this->date_enreg === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->date_enreg->format("Y-m-d H:i:s")) {
                $this->date_enreg = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PartenairepieceTableMap::COL_DATE_ENREG] = true;
            }
        } // if either are not null

        return $this;
    } // setDateenregistrement()

    /**
     * Set the value of [reference_pk] column.
     *
     * @param string $v new value
     * @return $this|\Partenairepiece The current object (for fluent API support)
     */
    public function setReference_PK($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->reference_pk !== $v) {
            $this->reference_pk = $v;
            $this->modifiedColumns[PartenairepieceTableMap::COL_REFERENCE_PK] = true;
        }

        if ($this->aPiece !== null && $this->aPiece->getReference() !== $v) {
            $this->aPiece = null;
        }

        return $this;
    } // setReference_PK()

    /**
     * Set the value of [part_id_pk] column.
     *
     * @param int $v new value
     * @return $this|\Partenairepiece The current object (for fluent API support)
     */
    public function setPartenaire_PK($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->part_id_pk !== $v) {
            $this->part_id_pk = $v;
            $this->modifiedColumns[PartenairepieceTableMap::COL_PART_ID_PK] = true;
        }

        if ($this->aPartenaire !== null && $this->aPartenaire->getPartenaire() !== $v) {
            $this->aPartenaire = null;
        }

        return $this;
    } // setPartenaire_PK()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PartenairepieceTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PartenairepieceTableMap::translateFieldName('Quantite', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quantite = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PartenairepieceTableMap::translateFieldName('Prixachat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prix_achat = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PartenairepieceTableMap::translateFieldName('Prixvente', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prix_vente = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PartenairepieceTableMap::translateFieldName('Dateenregistrement', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->date_enreg = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PartenairepieceTableMap::translateFieldName('Reference_PK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reference_pk = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PartenairepieceTableMap::translateFieldName('Partenaire_PK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->part_id_pk = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = PartenairepieceTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Partenairepiece'), 0, $e);
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
        if ($this->aPiece !== null && $this->reference_pk !== $this->aPiece->getReference()) {
            $this->aPiece = null;
        }
        if ($this->aPartenaire !== null && $this->part_id_pk !== $this->aPartenaire->getPartenaire()) {
            $this->aPartenaire = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PartenairepieceTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPartenairepieceQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPiece = null;
            $this->aPartenaire = null;
            $this->collDocs = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Partenairepiece::setDeleted()
     * @see Partenairepiece::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PartenairepieceTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPartenairepieceQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PartenairepieceTableMap::DATABASE_NAME);
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
                PartenairepieceTableMap::addInstanceToPool($this);
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

            if ($this->aPiece !== null) {
                if ($this->aPiece->isModified() || $this->aPiece->isNew()) {
                    $affectedRows += $this->aPiece->save($con);
                }
                $this->setPiece($this->aPiece);
            }

            if ($this->aPartenaire !== null) {
                if ($this->aPartenaire->isModified() || $this->aPartenaire->isNew()) {
                    $affectedRows += $this->aPartenaire->save($con);
                }
                $this->setPartenaire($this->aPartenaire);
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

        $this->modifiedColumns[PartenairepieceTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PartenairepieceTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PartenairepieceTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_QUANTITE)) {
            $modifiedColumns[':p' . $index++]  = 'quantite';
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_PRIX_ACHAT)) {
            $modifiedColumns[':p' . $index++]  = 'prix_achat';
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_PRIX_VENTE)) {
            $modifiedColumns[':p' . $index++]  = 'prix_vente';
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_DATE_ENREG)) {
            $modifiedColumns[':p' . $index++]  = 'date_enreg';
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_REFERENCE_PK)) {
            $modifiedColumns[':p' . $index++]  = 'reference_PK';
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_PART_ID_PK)) {
            $modifiedColumns[':p' . $index++]  = 'part_id_PK';
        }

        $sql = sprintf(
            'INSERT INTO partenaire_piece (%s) VALUES (%s)',
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
                    case 'quantite':
                        $stmt->bindValue($identifier, $this->quantite, PDO::PARAM_INT);
                        break;
                    case 'prix_achat':
                        $stmt->bindValue($identifier, $this->prix_achat, PDO::PARAM_STR);
                        break;
                    case 'prix_vente':
                        $stmt->bindValue($identifier, $this->prix_vente, PDO::PARAM_STR);
                        break;
                    case 'date_enreg':
                        $stmt->bindValue($identifier, $this->date_enreg ? $this->date_enreg->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'reference_PK':
                        $stmt->bindValue($identifier, $this->reference_pk, PDO::PARAM_STR);
                        break;
                    case 'part_id_PK':
                        $stmt->bindValue($identifier, $this->part_id_pk, PDO::PARAM_INT);
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
        $pos = PartenairepieceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getQuantite();
                break;
            case 2:
                return $this->getPrixachat();
                break;
            case 3:
                return $this->getPrixvente();
                break;
            case 4:
                return $this->getDateenregistrement();
                break;
            case 5:
                return $this->getReference_PK();
                break;
            case 6:
                return $this->getPartenaire_PK();
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

        if (isset($alreadyDumpedObjects['Partenairepiece'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Partenairepiece'][$this->hashCode()] = true;
        $keys = PartenairepieceTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getQuantite(),
            $keys[2] => $this->getPrixachat(),
            $keys[3] => $this->getPrixvente(),
            $keys[4] => $this->getDateenregistrement(),
            $keys[5] => $this->getReference_PK(),
            $keys[6] => $this->getPartenaire_PK(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[4]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[4]];
            $result[$keys[4]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
     * @return $this|\Partenairepiece
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PartenairepieceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Partenairepiece
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setID($value);
                break;
            case 1:
                $this->setQuantite($value);
                break;
            case 2:
                $this->setPrixachat($value);
                break;
            case 3:
                $this->setPrixvente($value);
                break;
            case 4:
                $this->setDateenregistrement($value);
                break;
            case 5:
                $this->setReference_PK($value);
                break;
            case 6:
                $this->setPartenaire_PK($value);
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
        $keys = PartenairepieceTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setQuantite($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPrixachat($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPrixvente($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDateenregistrement($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setReference_PK($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPartenaire_PK($arr[$keys[6]]);
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
     * @return $this|\Partenairepiece The current object, for fluid interface
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
        $criteria = new Criteria(PartenairepieceTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PartenairepieceTableMap::COL_ID)) {
            $criteria->add(PartenairepieceTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_QUANTITE)) {
            $criteria->add(PartenairepieceTableMap::COL_QUANTITE, $this->quantite);
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_PRIX_ACHAT)) {
            $criteria->add(PartenairepieceTableMap::COL_PRIX_ACHAT, $this->prix_achat);
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_PRIX_VENTE)) {
            $criteria->add(PartenairepieceTableMap::COL_PRIX_VENTE, $this->prix_vente);
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_DATE_ENREG)) {
            $criteria->add(PartenairepieceTableMap::COL_DATE_ENREG, $this->date_enreg);
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_REFERENCE_PK)) {
            $criteria->add(PartenairepieceTableMap::COL_REFERENCE_PK, $this->reference_pk);
        }
        if ($this->isColumnModified(PartenairepieceTableMap::COL_PART_ID_PK)) {
            $criteria->add(PartenairepieceTableMap::COL_PART_ID_PK, $this->part_id_pk);
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
        $criteria = ChildPartenairepieceQuery::create();
        $criteria->add(PartenairepieceTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Partenairepiece (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setQuantite($this->getQuantite());
        $copyObj->setPrixachat($this->getPrixachat());
        $copyObj->setPrixvente($this->getPrixvente());
        $copyObj->setDateenregistrement($this->getDateenregistrement());
        $copyObj->setReference_PK($this->getReference_PK());
        $copyObj->setPartenaire_PK($this->getPartenaire_PK());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDocs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDoc($relObj->copy($deepCopy));
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
     * @return \Partenairepiece Clone of current object.
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
     * Declares an association between this object and a ChildPiece object.
     *
     * @param  ChildPiece $v
     * @return $this|\Partenairepiece The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPiece(ChildPiece $v = null)
    {
        if ($v === null) {
            $this->setReference_PK(NULL);
        } else {
            $this->setReference_PK($v->getReference());
        }

        $this->aPiece = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPiece object, it will not be re-added.
        if ($v !== null) {
            $v->addPartenairepiece($this);
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
        if ($this->aPiece === null && (($this->reference_pk !== "" && $this->reference_pk !== null))) {
            $this->aPiece = ChildPieceQuery::create()
                ->filterByPartenairepiece($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPiece->addPartenairepieces($this);
             */
        }

        return $this->aPiece;
    }

    /**
     * Declares an association between this object and a ChildPartenaire object.
     *
     * @param  ChildPartenaire $v
     * @return $this|\Partenairepiece The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPartenaire(ChildPartenaire $v = null)
    {
        if ($v === null) {
            $this->setPartenaire_PK(NULL);
        } else {
            $this->setPartenaire_PK($v->getPartenaire());
        }

        $this->aPartenaire = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPartenaire object, it will not be re-added.
        if ($v !== null) {
            $v->addPartenairepiece($this);
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
        if ($this->aPartenaire === null && ($this->part_id_pk !== null)) {
            $this->aPartenaire = ChildPartenaireQuery::create()->findPk($this->part_id_pk, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPartenaire->addPartenairepieces($this);
             */
        }

        return $this->aPartenaire;
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
        if ('Doc' == $relationName) {
            return $this->initDocs();
        }
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
     * If this ChildPartenairepiece is new, it will return
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
                    ->filterByPartenairepiece($this)
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
     * @return $this|ChildPartenairepiece The current object (for fluent API support)
     */
    public function setDocs(Collection $docs, ConnectionInterface $con = null)
    {
        /** @var ChildDocument[] $docsToDelete */
        $docsToDelete = $this->getDocs(new Criteria(), $con)->diff($docs);


        $this->docsScheduledForDeletion = $docsToDelete;

        foreach ($docsToDelete as $docRemoved) {
            $docRemoved->setPartenairepiece(null);
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
                ->filterByPartenairepiece($this)
                ->count($con);
        }

        return count($this->collDocs);
    }

    /**
     * Method called to associate a ChildDocument object to this object
     * through the ChildDocument foreign key attribute.
     *
     * @param  ChildDocument $l ChildDocument
     * @return $this|\Partenairepiece The current object (for fluent API support)
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
        $doc->setPartenairepiece($this);
    }

    /**
     * @param  ChildDocument $doc The ChildDocument object to remove.
     * @return $this|ChildPartenairepiece The current object (for fluent API support)
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
            $doc->setPartenairepiece(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenairepiece is new, it will return
     * an empty collection; or if this Partenairepiece has previously
     * been saved, it will retrieve related Docs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenairepiece.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Partenairepiece is new, it will return
     * an empty collection; or if this Partenairepiece has previously
     * been saved, it will retrieve related Docs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Partenairepiece.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPiece) {
            $this->aPiece->removePartenairepiece($this);
        }
        if (null !== $this->aPartenaire) {
            $this->aPartenaire->removePartenairepiece($this);
        }
        $this->id = null;
        $this->quantite = null;
        $this->prix_achat = null;
        $this->prix_vente = null;
        $this->date_enreg = null;
        $this->reference_pk = null;
        $this->part_id_pk = null;
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
            if ($this->collDocs) {
                foreach ($this->collDocs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDocs = null;
        $this->aPiece = null;
        $this->aPartenaire = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PartenairepieceTableMap::DEFAULT_STRING_FORMAT);
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
