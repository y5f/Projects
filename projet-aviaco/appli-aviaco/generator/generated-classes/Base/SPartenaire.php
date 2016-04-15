<?php

namespace Base;

use \Partenaire as ChildPartenaire;
use \PartenaireQuery as ChildPartenaireQuery;
use \SPartenaireQuery as ChildSPartenaireQuery;
use \Societe as ChildSociete;
use \SocieteQuery as ChildSocieteQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\SPartenaireTableMap;
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
 * Base class that represents a row from the 'soc_part' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SPartenaire implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SPartenaireTableMap';


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
     * The value for the soc_fraude field.
     * @var        int
     */
    protected $soc_fraude;

    /**
     * The value for the plaig_part field.
     * @var        int
     */
    protected $plaig_part;

    /**
     * The value for the plaig_soc field.
     * @var        int
     */
    protected $plaig_soc;

    /**
     * The value for the plaignant field.
     * @var        string
     */
    protected $plaignant;

    /**
     * The value for the dte_plainte field.
     * @var        \DateTime
     */
    protected $dte_plainte;

    /**
     * @var        ChildPartenaire
     */
    protected $aPartenaire;

    /**
     * @var        ChildSociete
     */
    protected $aSocFraude;

    /**
     * @var        ChildSociete
     */
    protected $aSocPlaignant;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\SPartenaire object.
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
     * Compares this with another <code>SPartenaire</code> instance.  If
     * <code>obj</code> is an instance of <code>SPartenaire</code>, delegates to
     * <code>equals(SPartenaire)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|SPartenaire The current object, for fluid interface
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
     * Get the [soc_fraude] column value.
     *
     * @return int
     */
    public function getSFraude()
    {
        return $this->soc_fraude;
    }

    /**
     * Get the [plaig_part] column value.
     *
     * @return int
     */
    public function getPPlaigante()
    {
        return $this->plaig_part;
    }

    /**
     * Get the [plaig_soc] column value.
     *
     * @return int
     */
    public function getSPlaigante()
    {
        return $this->plaig_soc;
    }

    /**
     * Get the [plaignant] column value.
     *
     * @return string
     */
    public function getPlaignat()
    {
        return $this->plaignant;
    }

    /**
     * Get the [optionally formatted] temporal [dte_plainte] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatePlainte($format = NULL)
    {
        if ($format === null) {
            return $this->dte_plainte;
        } else {
            return $this->dte_plainte instanceof \DateTime ? $this->dte_plainte->format($format) : null;
        }
    }

    /**
     * Set the value of [soc_fraude] column.
     *
     * @param int $v new value
     * @return $this|\SPartenaire The current object (for fluent API support)
     */
    public function setSFraude($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->soc_fraude !== $v) {
            $this->soc_fraude = $v;
            $this->modifiedColumns[SPartenaireTableMap::COL_SOC_FRAUDE] = true;
        }

        if ($this->aSocFraude !== null && $this->aSocFraude->getID() !== $v) {
            $this->aSocFraude = null;
        }

        return $this;
    } // setSFraude()

    /**
     * Set the value of [plaig_part] column.
     *
     * @param int $v new value
     * @return $this|\SPartenaire The current object (for fluent API support)
     */
    public function setPPlaigante($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->plaig_part !== $v) {
            $this->plaig_part = $v;
            $this->modifiedColumns[SPartenaireTableMap::COL_PLAIG_PART] = true;
        }

        if ($this->aPartenaire !== null && $this->aPartenaire->getID() !== $v) {
            $this->aPartenaire = null;
        }

        return $this;
    } // setPPlaigante()

    /**
     * Set the value of [plaig_soc] column.
     *
     * @param int $v new value
     * @return $this|\SPartenaire The current object (for fluent API support)
     */
    public function setSPlaigante($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->plaig_soc !== $v) {
            $this->plaig_soc = $v;
            $this->modifiedColumns[SPartenaireTableMap::COL_PLAIG_SOC] = true;
        }

        if ($this->aSocPlaignant !== null && $this->aSocPlaignant->getID() !== $v) {
            $this->aSocPlaignant = null;
        }

        return $this;
    } // setSPlaigante()

    /**
     * Set the value of [plaignant] column.
     *
     * @param string $v new value
     * @return $this|\SPartenaire The current object (for fluent API support)
     */
    public function setPlaignat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->plaignant !== $v) {
            $this->plaignant = $v;
            $this->modifiedColumns[SPartenaireTableMap::COL_PLAIGNANT] = true;
        }

        return $this;
    } // setPlaignat()

    /**
     * Sets the value of [dte_plainte] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\SPartenaire The current object (for fluent API support)
     */
    public function setDatePlainte($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dte_plainte !== null || $dt !== null) {
            if ($this->dte_plainte === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->dte_plainte->format("Y-m-d H:i:s")) {
                $this->dte_plainte = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SPartenaireTableMap::COL_DTE_PLAINTE] = true;
            }
        } // if either are not null

        return $this;
    } // setDatePlainte()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SPartenaireTableMap::translateFieldName('SFraude', TableMap::TYPE_PHPNAME, $indexType)];
            $this->soc_fraude = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SPartenaireTableMap::translateFieldName('PPlaigante', TableMap::TYPE_PHPNAME, $indexType)];
            $this->plaig_part = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SPartenaireTableMap::translateFieldName('SPlaigante', TableMap::TYPE_PHPNAME, $indexType)];
            $this->plaig_soc = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SPartenaireTableMap::translateFieldName('Plaignat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->plaignant = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SPartenaireTableMap::translateFieldName('DatePlainte', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->dte_plainte = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = SPartenaireTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\SPartenaire'), 0, $e);
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
        if ($this->aSocFraude !== null && $this->soc_fraude !== $this->aSocFraude->getID()) {
            $this->aSocFraude = null;
        }
        if ($this->aPartenaire !== null && $this->plaig_part !== $this->aPartenaire->getID()) {
            $this->aPartenaire = null;
        }
        if ($this->aSocPlaignant !== null && $this->plaig_soc !== $this->aSocPlaignant->getID()) {
            $this->aSocPlaignant = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SPartenaireTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSPartenaireQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPartenaire = null;
            $this->aSocFraude = null;
            $this->aSocPlaignant = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SPartenaire::setDeleted()
     * @see SPartenaire::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPartenaireTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSPartenaireQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SPartenaireTableMap::DATABASE_NAME);
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
                SPartenaireTableMap::addInstanceToPool($this);
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

            if ($this->aSocFraude !== null) {
                if ($this->aSocFraude->isModified() || $this->aSocFraude->isNew()) {
                    $affectedRows += $this->aSocFraude->save($con);
                }
                $this->setSocFraude($this->aSocFraude);
            }

            if ($this->aSocPlaignant !== null) {
                if ($this->aSocPlaignant->isModified() || $this->aSocPlaignant->isNew()) {
                    $affectedRows += $this->aSocPlaignant->save($con);
                }
                $this->setSocPlaignant($this->aSocPlaignant);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SPartenaireTableMap::COL_SOC_FRAUDE)) {
            $modifiedColumns[':p' . $index++]  = 'soc_fraude';
        }
        if ($this->isColumnModified(SPartenaireTableMap::COL_PLAIG_PART)) {
            $modifiedColumns[':p' . $index++]  = 'plaig_part';
        }
        if ($this->isColumnModified(SPartenaireTableMap::COL_PLAIG_SOC)) {
            $modifiedColumns[':p' . $index++]  = 'plaig_soc';
        }
        if ($this->isColumnModified(SPartenaireTableMap::COL_PLAIGNANT)) {
            $modifiedColumns[':p' . $index++]  = 'plaignant';
        }
        if ($this->isColumnModified(SPartenaireTableMap::COL_DTE_PLAINTE)) {
            $modifiedColumns[':p' . $index++]  = 'dte_plainte';
        }

        $sql = sprintf(
            'INSERT INTO soc_part (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'soc_fraude':
                        $stmt->bindValue($identifier, $this->soc_fraude, PDO::PARAM_INT);
                        break;
                    case 'plaig_part':
                        $stmt->bindValue($identifier, $this->plaig_part, PDO::PARAM_INT);
                        break;
                    case 'plaig_soc':
                        $stmt->bindValue($identifier, $this->plaig_soc, PDO::PARAM_INT);
                        break;
                    case 'plaignant':
                        $stmt->bindValue($identifier, $this->plaignant, PDO::PARAM_STR);
                        break;
                    case 'dte_plainte':
                        $stmt->bindValue($identifier, $this->dte_plainte ? $this->dte_plainte->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = SPartenaireTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSFraude();
                break;
            case 1:
                return $this->getPPlaigante();
                break;
            case 2:
                return $this->getSPlaigante();
                break;
            case 3:
                return $this->getPlaignat();
                break;
            case 4:
                return $this->getDatePlainte();
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

        if (isset($alreadyDumpedObjects['SPartenaire'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SPartenaire'][$this->hashCode()] = true;
        $keys = SPartenaireTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getSFraude(),
            $keys[1] => $this->getPPlaigante(),
            $keys[2] => $this->getSPlaigante(),
            $keys[3] => $this->getPlaignat(),
            $keys[4] => $this->getDatePlainte(),
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
            if (null !== $this->aSocFraude) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'societe';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'societe';
                        break;
                    default:
                        $key = 'Societe';
                }

                $result[$key] = $this->aSocFraude->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSocPlaignant) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'societe';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'societe';
                        break;
                    default:
                        $key = 'Societe';
                }

                $result[$key] = $this->aSocPlaignant->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\SPartenaire
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SPartenaireTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\SPartenaire
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setSFraude($value);
                break;
            case 1:
                $this->setPPlaigante($value);
                break;
            case 2:
                $this->setSPlaigante($value);
                break;
            case 3:
                $this->setPlaignat($value);
                break;
            case 4:
                $this->setDatePlainte($value);
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
        $keys = SPartenaireTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setSFraude($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPPlaigante($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSPlaigante($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPlaignat($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDatePlainte($arr[$keys[4]]);
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
     * @return $this|\SPartenaire The current object, for fluid interface
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
        $criteria = new Criteria(SPartenaireTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SPartenaireTableMap::COL_SOC_FRAUDE)) {
            $criteria->add(SPartenaireTableMap::COL_SOC_FRAUDE, $this->soc_fraude);
        }
        if ($this->isColumnModified(SPartenaireTableMap::COL_PLAIG_PART)) {
            $criteria->add(SPartenaireTableMap::COL_PLAIG_PART, $this->plaig_part);
        }
        if ($this->isColumnModified(SPartenaireTableMap::COL_PLAIG_SOC)) {
            $criteria->add(SPartenaireTableMap::COL_PLAIG_SOC, $this->plaig_soc);
        }
        if ($this->isColumnModified(SPartenaireTableMap::COL_PLAIGNANT)) {
            $criteria->add(SPartenaireTableMap::COL_PLAIGNANT, $this->plaignant);
        }
        if ($this->isColumnModified(SPartenaireTableMap::COL_DTE_PLAINTE)) {
            $criteria->add(SPartenaireTableMap::COL_DTE_PLAINTE, $this->dte_plainte);
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
        $criteria = ChildSPartenaireQuery::create();
        $criteria->add(SPartenaireTableMap::COL_SOC_FRAUDE, $this->soc_fraude);

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
        $validPk = null !== $this->getSFraude();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation soc_part_fk_1bca9d to table societe
        if ($this->aSocFraude && $hash = spl_object_hash($this->aSocFraude)) {
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
        return $this->getSFraude();
    }

    /**
     * Generic method to set the primary key (soc_fraude column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setSFraude($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getSFraude();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \SPartenaire (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSFraude($this->getSFraude());
        $copyObj->setPPlaigante($this->getPPlaigante());
        $copyObj->setSPlaigante($this->getSPlaigante());
        $copyObj->setPlaignat($this->getPlaignat());
        $copyObj->setDatePlainte($this->getDatePlainte());
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
     * @return \SPartenaire Clone of current object.
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
     * @return $this|\SPartenaire The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPartenaire(ChildPartenaire $v = null)
    {
        if ($v === null) {
            $this->setPPlaigante(NULL);
        } else {
            $this->setPPlaigante($v->getID());
        }

        $this->aPartenaire = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPartenaire object, it will not be re-added.
        if ($v !== null) {
            $v->addSPartenaire($this);
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
        if ($this->aPartenaire === null && ($this->plaig_part !== null)) {
            $this->aPartenaire = ChildPartenaireQuery::create()->findPk($this->plaig_part, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPartenaire->addSPartenaires($this);
             */
        }

        return $this->aPartenaire;
    }

    /**
     * Declares an association between this object and a ChildSociete object.
     *
     * @param  ChildSociete $v
     * @return $this|\SPartenaire The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSocFraude(ChildSociete $v = null)
    {
        if ($v === null) {
            $this->setSFraude(NULL);
        } else {
            $this->setSFraude($v->getID());
        }

        $this->aSocFraude = $v;

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setBFPartenaire($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSociete object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSociete The associated ChildSociete object.
     * @throws PropelException
     */
    public function getSocFraude(ConnectionInterface $con = null)
    {
        if ($this->aSocFraude === null && ($this->soc_fraude !== null)) {
            $this->aSocFraude = ChildSocieteQuery::create()->findPk($this->soc_fraude, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aSocFraude->setBFPartenaire($this);
        }

        return $this->aSocFraude;
    }

    /**
     * Declares an association between this object and a ChildSociete object.
     *
     * @param  ChildSociete $v
     * @return $this|\SPartenaire The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSocPlaignant(ChildSociete $v = null)
    {
        if ($v === null) {
            $this->setSPlaigante(NULL);
        } else {
            $this->setSPlaigante($v->getID());
        }

        $this->aSocPlaignant = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSociete object, it will not be re-added.
        if ($v !== null) {
            $v->addBPPartenaire($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSociete object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSociete The associated ChildSociete object.
     * @throws PropelException
     */
    public function getSocPlaignant(ConnectionInterface $con = null)
    {
        if ($this->aSocPlaignant === null && ($this->plaig_soc !== null)) {
            $this->aSocPlaignant = ChildSocieteQuery::create()->findPk($this->plaig_soc, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSocPlaignant->addBPPartenaires($this);
             */
        }

        return $this->aSocPlaignant;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPartenaire) {
            $this->aPartenaire->removeSPartenaire($this);
        }
        if (null !== $this->aSocFraude) {
            $this->aSocFraude->removeBFPartenaire($this);
        }
        if (null !== $this->aSocPlaignant) {
            $this->aSocPlaignant->removeBPPartenaire($this);
        }
        $this->soc_fraude = null;
        $this->plaig_part = null;
        $this->plaig_soc = null;
        $this->plaignant = null;
        $this->dte_plainte = null;
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

        $this->aPartenaire = null;
        $this->aSocFraude = null;
        $this->aSocPlaignant = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SPartenaireTableMap::DEFAULT_STRING_FORMAT);
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
