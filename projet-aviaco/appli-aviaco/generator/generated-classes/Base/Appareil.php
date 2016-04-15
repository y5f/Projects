<?php

namespace Base;

use \Appareil as ChildAppareil;
use \AppareilQuery as ChildAppareilQuery;
use \Appareilcertificat as ChildAppareilcertificat;
use \AppareilcertificatQuery as ChildAppareilcertificatQuery;
use \CMDTAppareil as ChildCMDTAppareil;
use \CMDTAppareilQuery as ChildCMDTAppareilQuery;
use \Marque as ChildMarque;
use \MarqueQuery as ChildMarqueQuery;
use \Model as ChildModel;
use \ModelQuery as ChildModelQuery;
use \Photoappareil as ChildPhotoappareil;
use \PhotoappareilQuery as ChildPhotoappareilQuery;
use \PieceApp as ChildPieceApp;
use \PieceAppQuery as ChildPieceAppQuery;
use \Societeappareil as ChildSocieteappareil;
use \SocieteappareilQuery as ChildSocieteappareilQuery;
use \Societecertificat as ChildSocietecertificat;
use \SocietecertificatQuery as ChildSocietecertificatQuery;
use \Exception;
use \PDO;
use Map\AppareilTableMap;
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
 * Base class that represents a row from the 'appareil' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Appareil implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\AppareilTableMap';


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
     * The value for the idap field.
     * @var        int
     */
    protected $idap;

    /**
     * The value for the immatriculation field.
     * @var        string
     */
    protected $immatriculation;

    /**
     * The value for the nom_app field.
     * @var        string
     */
    protected $nom_app;

    /**
     * The value for the modele_pk field.
     * @var        string
     */
    protected $modele_pk;

    /**
     * The value for the marque_pk field.
     * @var        string
     */
    protected $marque_pk;

    /**
     * @var        ChildMarque
     */
    protected $aMarque;

    /**
     * @var        ChildModel
     */
    protected $aModele;

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
     * @var        ObjectCollection|ChildCMDTAppareil[] Collection to store aggregation of ChildCMDTAppareil objects.
     */
    protected $collCMDTAppareils;
    protected $collCMDTAppareilsPartial;

    /**
     * @var        ObjectCollection|ChildSocieteappareil[] Collection to store aggregation of ChildSocieteappareil objects.
     */
    protected $collSocieteappareils;
    protected $collSocieteappareilsPartial;

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
     * @var ObjectCollection|ChildPieceApp[]
     */
    protected $pieceAppsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPhotoappareil[]
     */
    protected $photoappareilsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCMDTAppareil[]
     */
    protected $cMDTAppareilsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSocieteappareil[]
     */
    protected $societeappareilsScheduledForDeletion = null;

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
     * Initializes internal state of Base\Appareil object.
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
     * Compares this with another <code>Appareil</code> instance.  If
     * <code>obj</code> is an instance of <code>Appareil</code>, delegates to
     * <code>equals(Appareil)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Appareil The current object, for fluid interface
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
     * Get the [idap] column value.
     *
     * @return int
     */
    public function getIdAp()
    {
        return $this->idap;
    }

    /**
     * Get the [immatriculation] column value.
     *
     * @return string
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * Get the [nom_app] column value.
     *
     * @return string
     */
    public function getNomApp()
    {
        return $this->nom_app;
    }

    /**
     * Get the [modele_pk] column value.
     *
     * @return string
     */
    public function getModele_PK()
    {
        return $this->modele_pk;
    }

    /**
     * Get the [marque_pk] column value.
     *
     * @return string
     */
    public function getMarque_PK()
    {
        return $this->marque_pk;
    }

    /**
     * Set the value of [idap] column.
     *
     * @param int $v new value
     * @return $this|\Appareil The current object (for fluent API support)
     */
    public function setIdAp($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->idap !== $v) {
            $this->idap = $v;
            $this->modifiedColumns[AppareilTableMap::COL_IDAP] = true;
        }

        return $this;
    } // setIdAp()

    /**
     * Set the value of [immatriculation] column.
     *
     * @param string $v new value
     * @return $this|\Appareil The current object (for fluent API support)
     */
    public function setImmatriculation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->immatriculation !== $v) {
            $this->immatriculation = $v;
            $this->modifiedColumns[AppareilTableMap::COL_IMMATRICULATION] = true;
        }

        return $this;
    } // setImmatriculation()

    /**
     * Set the value of [nom_app] column.
     *
     * @param string $v new value
     * @return $this|\Appareil The current object (for fluent API support)
     */
    public function setNomApp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nom_app !== $v) {
            $this->nom_app = $v;
            $this->modifiedColumns[AppareilTableMap::COL_NOM_APP] = true;
        }

        return $this;
    } // setNomApp()

    /**
     * Set the value of [modele_pk] column.
     *
     * @param string $v new value
     * @return $this|\Appareil The current object (for fluent API support)
     */
    public function setModele_PK($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->modele_pk !== $v) {
            $this->modele_pk = $v;
            $this->modifiedColumns[AppareilTableMap::COL_MODELE_PK] = true;
        }

        if ($this->aModele !== null && $this->aModele->getModele() !== $v) {
            $this->aModele = null;
        }

        return $this;
    } // setModele_PK()

    /**
     * Set the value of [marque_pk] column.
     *
     * @param string $v new value
     * @return $this|\Appareil The current object (for fluent API support)
     */
    public function setMarque_PK($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->marque_pk !== $v) {
            $this->marque_pk = $v;
            $this->modifiedColumns[AppareilTableMap::COL_MARQUE_PK] = true;
        }

        if ($this->aMarque !== null && $this->aMarque->getMarque() !== $v) {
            $this->aMarque = null;
        }

        return $this;
    } // setMarque_PK()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AppareilTableMap::translateFieldName('IdAp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idap = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AppareilTableMap::translateFieldName('Immatriculation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->immatriculation = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AppareilTableMap::translateFieldName('NomApp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nom_app = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AppareilTableMap::translateFieldName('Modele_PK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->modele_pk = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AppareilTableMap::translateFieldName('Marque_PK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->marque_pk = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = AppareilTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Appareil'), 0, $e);
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
        if ($this->aModele !== null && $this->modele_pk !== $this->aModele->getModele()) {
            $this->aModele = null;
        }
        if ($this->aMarque !== null && $this->marque_pk !== $this->aMarque->getMarque()) {
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
            $con = Propel::getServiceContainer()->getReadConnection(AppareilTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAppareilQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMarque = null;
            $this->aModele = null;
            $this->collPieceApps = null;

            $this->collPhotoappareils = null;

            $this->collCMDTAppareils = null;

            $this->collSocieteappareils = null;

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
     * @see Appareil::setDeleted()
     * @see Appareil::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AppareilTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAppareilQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AppareilTableMap::DATABASE_NAME);
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
                AppareilTableMap::addInstanceToPool($this);
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

            if ($this->aModele !== null) {
                if ($this->aModele->isModified() || $this->aModele->isNew()) {
                    $affectedRows += $this->aModele->save($con);
                }
                $this->setModele($this->aModele);
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

            if ($this->societeappareilsScheduledForDeletion !== null) {
                if (!$this->societeappareilsScheduledForDeletion->isEmpty()) {
                    \SocieteappareilQuery::create()
                        ->filterByPrimaryKeys($this->societeappareilsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->societeappareilsScheduledForDeletion = null;
                }
            }

            if ($this->collSocieteappareils !== null) {
                foreach ($this->collSocieteappareils as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[AppareilTableMap::COL_IDAP] = true;
        if (null !== $this->idap) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AppareilTableMap::COL_IDAP . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AppareilTableMap::COL_IDAP)) {
            $modifiedColumns[':p' . $index++]  = 'idAp';
        }
        if ($this->isColumnModified(AppareilTableMap::COL_IMMATRICULATION)) {
            $modifiedColumns[':p' . $index++]  = 'Immatriculation';
        }
        if ($this->isColumnModified(AppareilTableMap::COL_NOM_APP)) {
            $modifiedColumns[':p' . $index++]  = 'nom_app';
        }
        if ($this->isColumnModified(AppareilTableMap::COL_MODELE_PK)) {
            $modifiedColumns[':p' . $index++]  = 'modele_PK';
        }
        if ($this->isColumnModified(AppareilTableMap::COL_MARQUE_PK)) {
            $modifiedColumns[':p' . $index++]  = 'marque_PK';
        }

        $sql = sprintf(
            'INSERT INTO appareil (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'idAp':
                        $stmt->bindValue($identifier, $this->idap, PDO::PARAM_INT);
                        break;
                    case 'Immatriculation':
                        $stmt->bindValue($identifier, $this->immatriculation, PDO::PARAM_STR);
                        break;
                    case 'nom_app':
                        $stmt->bindValue($identifier, $this->nom_app, PDO::PARAM_STR);
                        break;
                    case 'modele_PK':
                        $stmt->bindValue($identifier, $this->modele_pk, PDO::PARAM_STR);
                        break;
                    case 'marque_PK':
                        $stmt->bindValue($identifier, $this->marque_pk, PDO::PARAM_STR);
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
        $this->setIdAp($pk);

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
        $pos = AppareilTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdAp();
                break;
            case 1:
                return $this->getImmatriculation();
                break;
            case 2:
                return $this->getNomApp();
                break;
            case 3:
                return $this->getModele_PK();
                break;
            case 4:
                return $this->getMarque_PK();
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

        if (isset($alreadyDumpedObjects['Appareil'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Appareil'][$this->hashCode()] = true;
        $keys = AppareilTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdAp(),
            $keys[1] => $this->getImmatriculation(),
            $keys[2] => $this->getNomApp(),
            $keys[3] => $this->getModele_PK(),
            $keys[4] => $this->getMarque_PK(),
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
            if (null !== $this->aModele) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'model';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'modele';
                        break;
                    default:
                        $key = 'Model';
                }

                $result[$key] = $this->aModele->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collSocieteappareils) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'societeappareils';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'societe_apps';
                        break;
                    default:
                        $key = 'Societeappareils';
                }

                $result[$key] = $this->collSocieteappareils->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
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
     * @return $this|\Appareil
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AppareilTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Appareil
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdAp($value);
                break;
            case 1:
                $this->setImmatriculation($value);
                break;
            case 2:
                $this->setNomApp($value);
                break;
            case 3:
                $this->setModele_PK($value);
                break;
            case 4:
                $this->setMarque_PK($value);
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
        $keys = AppareilTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdAp($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setImmatriculation($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNomApp($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setModele_PK($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setMarque_PK($arr[$keys[4]]);
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
     * @return $this|\Appareil The current object, for fluid interface
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
        $criteria = new Criteria(AppareilTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AppareilTableMap::COL_IDAP)) {
            $criteria->add(AppareilTableMap::COL_IDAP, $this->idap);
        }
        if ($this->isColumnModified(AppareilTableMap::COL_IMMATRICULATION)) {
            $criteria->add(AppareilTableMap::COL_IMMATRICULATION, $this->immatriculation);
        }
        if ($this->isColumnModified(AppareilTableMap::COL_NOM_APP)) {
            $criteria->add(AppareilTableMap::COL_NOM_APP, $this->nom_app);
        }
        if ($this->isColumnModified(AppareilTableMap::COL_MODELE_PK)) {
            $criteria->add(AppareilTableMap::COL_MODELE_PK, $this->modele_pk);
        }
        if ($this->isColumnModified(AppareilTableMap::COL_MARQUE_PK)) {
            $criteria->add(AppareilTableMap::COL_MARQUE_PK, $this->marque_pk);
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
        $criteria = ChildAppareilQuery::create();
        $criteria->add(AppareilTableMap::COL_IDAP, $this->idap);
        $criteria->add(AppareilTableMap::COL_MODELE_PK, $this->modele_pk);
        $criteria->add(AppareilTableMap::COL_MARQUE_PK, $this->marque_pk);

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
        $validPk = null !== $this->getIdAp() &&
            null !== $this->getModele_PK() &&
            null !== $this->getMarque_PK();

        $validPrimaryKeyFKs = 2;
        $primaryKeyFKs = [];

        //relation appareil_fk_041995 to table marque
        if ($this->aMarque && $hash = spl_object_hash($this->aMarque)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        //relation appareil_fk_47db7e to table modele
        if ($this->aModele && $hash = spl_object_hash($this->aModele)) {
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
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getIdAp();
        $pks[1] = $this->getModele_PK();
        $pks[2] = $this->getMarque_PK();

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
        $this->setIdAp($keys[0]);
        $this->setModele_PK($keys[1]);
        $this->setMarque_PK($keys[2]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getIdAp()) && (null === $this->getModele_PK()) && (null === $this->getMarque_PK());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Appareil (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setImmatriculation($this->getImmatriculation());
        $copyObj->setNomApp($this->getNomApp());
        $copyObj->setModele_PK($this->getModele_PK());
        $copyObj->setMarque_PK($this->getMarque_PK());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

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

            foreach ($this->getCMDTAppareils() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCMDTAppareil($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSocieteappareils() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSocieteappareil($relObj->copy($deepCopy));
                }
            }

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
            $copyObj->setIdAp(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Appareil Clone of current object.
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
     * @return $this|\Appareil The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMarque(ChildMarque $v = null)
    {
        if ($v === null) {
            $this->setMarque_PK(NULL);
        } else {
            $this->setMarque_PK($v->getMarque());
        }

        $this->aMarque = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMarque object, it will not be re-added.
        if ($v !== null) {
            $v->addAppareil($this);
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
        if ($this->aMarque === null && (($this->marque_pk !== "" && $this->marque_pk !== null))) {
            $this->aMarque = ChildMarqueQuery::create()
                ->filterByAppareil($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMarque->addAppareils($this);
             */
        }

        return $this->aMarque;
    }

    /**
     * Declares an association between this object and a ChildModel object.
     *
     * @param  ChildModel $v
     * @return $this|\Appareil The current object (for fluent API support)
     * @throws PropelException
     */
    public function setModele(ChildModel $v = null)
    {
        if ($v === null) {
            $this->setModele_PK(NULL);
        } else {
            $this->setModele_PK($v->getModele());
        }

        $this->aModele = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildModel object, it will not be re-added.
        if ($v !== null) {
            $v->addAppareil($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildModel object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildModel The associated ChildModel object.
     * @throws PropelException
     */
    public function getModele(ConnectionInterface $con = null)
    {
        if ($this->aModele === null && (($this->modele_pk !== "" && $this->modele_pk !== null))) {
            $this->aModele = ChildModelQuery::create()
                ->filterByAppareil($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aModele->addAppareils($this);
             */
        }

        return $this->aModele;
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
        if ('Photoappareil' == $relationName) {
            return $this->initPhotoappareils();
        }
        if ('CMDTAppareil' == $relationName) {
            return $this->initCMDTAppareils();
        }
        if ('Societeappareil' == $relationName) {
            return $this->initSocieteappareils();
        }
        if ('Appareilcertificat' == $relationName) {
            return $this->initAppareilcertificats();
        }
        if ('Societecertificat' == $relationName) {
            return $this->initSocietecertificats();
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
     * If this ChildAppareil is new, it will return
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
                    ->filterByAppareil($this)
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
     * @return $this|ChildAppareil The current object (for fluent API support)
     */
    public function setPieceApps(Collection $pieceApps, ConnectionInterface $con = null)
    {
        /** @var ChildPieceApp[] $pieceAppsToDelete */
        $pieceAppsToDelete = $this->getPieceApps(new Criteria(), $con)->diff($pieceApps);


        $this->pieceAppsScheduledForDeletion = $pieceAppsToDelete;

        foreach ($pieceAppsToDelete as $pieceAppRemoved) {
            $pieceAppRemoved->setAppareil(null);
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
                ->filterByAppareil($this)
                ->count($con);
        }

        return count($this->collPieceApps);
    }

    /**
     * Method called to associate a ChildPieceApp object to this object
     * through the ChildPieceApp foreign key attribute.
     *
     * @param  ChildPieceApp $l ChildPieceApp
     * @return $this|\Appareil The current object (for fluent API support)
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
        $pieceApp->setAppareil($this);
    }

    /**
     * @param  ChildPieceApp $pieceApp The ChildPieceApp object to remove.
     * @return $this|ChildAppareil The current object (for fluent API support)
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
            $pieceApp->setAppareil(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Appareil is new, it will return
     * an empty collection; or if this Appareil has previously
     * been saved, it will retrieve related PieceApps from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Appareil.
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
     * If this ChildAppareil is new, it will return
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
                    ->filterByAppareil($this)
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
     * @return $this|ChildAppareil The current object (for fluent API support)
     */
    public function setPhotoappareils(Collection $photoappareils, ConnectionInterface $con = null)
    {
        /** @var ChildPhotoappareil[] $photoappareilsToDelete */
        $photoappareilsToDelete = $this->getPhotoappareils(new Criteria(), $con)->diff($photoappareils);


        $this->photoappareilsScheduledForDeletion = $photoappareilsToDelete;

        foreach ($photoappareilsToDelete as $photoappareilRemoved) {
            $photoappareilRemoved->setAppareil(null);
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
                ->filterByAppareil($this)
                ->count($con);
        }

        return count($this->collPhotoappareils);
    }

    /**
     * Method called to associate a ChildPhotoappareil object to this object
     * through the ChildPhotoappareil foreign key attribute.
     *
     * @param  ChildPhotoappareil $l ChildPhotoappareil
     * @return $this|\Appareil The current object (for fluent API support)
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
        $photoappareil->setAppareil($this);
    }

    /**
     * @param  ChildPhotoappareil $photoappareil The ChildPhotoappareil object to remove.
     * @return $this|ChildAppareil The current object (for fluent API support)
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
            $this->photoappareilsScheduledForDeletion[]= $photoappareil;
            $photoappareil->setAppareil(null);
        }

        return $this;
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
     * If this ChildAppareil is new, it will return
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
                    ->filterByAppareil($this)
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
     * @return $this|ChildAppareil The current object (for fluent API support)
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
            $cMDTAppareilRemoved->setAppareil(null);
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
                ->filterByAppareil($this)
                ->count($con);
        }

        return count($this->collCMDTAppareils);
    }

    /**
     * Method called to associate a ChildCMDTAppareil object to this object
     * through the ChildCMDTAppareil foreign key attribute.
     *
     * @param  ChildCMDTAppareil $l ChildCMDTAppareil
     * @return $this|\Appareil The current object (for fluent API support)
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
        $cMDTAppareil->setAppareil($this);
    }

    /**
     * @param  ChildCMDTAppareil $cMDTAppareil The ChildCMDTAppareil object to remove.
     * @return $this|ChildAppareil The current object (for fluent API support)
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
            $cMDTAppareil->setAppareil(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Appareil is new, it will return
     * an empty collection; or if this Appareil has previously
     * been saved, it will retrieve related CMDTAppareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Appareil.
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
     * Otherwise if this Appareil is new, it will return
     * an empty collection; or if this Appareil has previously
     * been saved, it will retrieve related CMDTAppareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Appareil.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCMDTAppareil[] List of ChildCMDTAppareil objects
     */
    public function getCMDTAppareilsJoinPiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCMDTAppareilQuery::create(null, $criteria);
        $query->joinWith('Piece', $joinBehavior);

        return $this->getCMDTAppareils($query, $con);
    }

    /**
     * Clears out the collSocieteappareils collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSocieteappareils()
     */
    public function clearSocieteappareils()
    {
        $this->collSocieteappareils = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSocieteappareils collection loaded partially.
     */
    public function resetPartialSocieteappareils($v = true)
    {
        $this->collSocieteappareilsPartial = $v;
    }

    /**
     * Initializes the collSocieteappareils collection.
     *
     * By default this just sets the collSocieteappareils collection to an empty array (like clearcollSocieteappareils());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSocieteappareils($overrideExisting = true)
    {
        if (null !== $this->collSocieteappareils && !$overrideExisting) {
            return;
        }
        $this->collSocieteappareils = new ObjectCollection();
        $this->collSocieteappareils->setModel('\Societeappareil');
    }

    /**
     * Gets an array of ChildSocieteappareil objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAppareil is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSocieteappareil[] List of ChildSocieteappareil objects
     * @throws PropelException
     */
    public function getSocieteappareils(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSocieteappareilsPartial && !$this->isNew();
        if (null === $this->collSocieteappareils || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSocieteappareils) {
                // return empty collection
                $this->initSocieteappareils();
            } else {
                $collSocieteappareils = ChildSocieteappareilQuery::create(null, $criteria)
                    ->filterByAppareil($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSocieteappareilsPartial && count($collSocieteappareils)) {
                        $this->initSocieteappareils(false);

                        foreach ($collSocieteappareils as $obj) {
                            if (false == $this->collSocieteappareils->contains($obj)) {
                                $this->collSocieteappareils->append($obj);
                            }
                        }

                        $this->collSocieteappareilsPartial = true;
                    }

                    return $collSocieteappareils;
                }

                if ($partial && $this->collSocieteappareils) {
                    foreach ($this->collSocieteappareils as $obj) {
                        if ($obj->isNew()) {
                            $collSocieteappareils[] = $obj;
                        }
                    }
                }

                $this->collSocieteappareils = $collSocieteappareils;
                $this->collSocieteappareilsPartial = false;
            }
        }

        return $this->collSocieteappareils;
    }

    /**
     * Sets a collection of ChildSocieteappareil objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $societeappareils A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAppareil The current object (for fluent API support)
     */
    public function setSocieteappareils(Collection $societeappareils, ConnectionInterface $con = null)
    {
        /** @var ChildSocieteappareil[] $societeappareilsToDelete */
        $societeappareilsToDelete = $this->getSocieteappareils(new Criteria(), $con)->diff($societeappareils);


        $this->societeappareilsScheduledForDeletion = $societeappareilsToDelete;

        foreach ($societeappareilsToDelete as $societeappareilRemoved) {
            $societeappareilRemoved->setAppareil(null);
        }

        $this->collSocieteappareils = null;
        foreach ($societeappareils as $societeappareil) {
            $this->addSocieteappareil($societeappareil);
        }

        $this->collSocieteappareils = $societeappareils;
        $this->collSocieteappareilsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Societeappareil objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Societeappareil objects.
     * @throws PropelException
     */
    public function countSocieteappareils(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSocieteappareilsPartial && !$this->isNew();
        if (null === $this->collSocieteappareils || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSocieteappareils) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSocieteappareils());
            }

            $query = ChildSocieteappareilQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAppareil($this)
                ->count($con);
        }

        return count($this->collSocieteappareils);
    }

    /**
     * Method called to associate a ChildSocieteappareil object to this object
     * through the ChildSocieteappareil foreign key attribute.
     *
     * @param  ChildSocieteappareil $l ChildSocieteappareil
     * @return $this|\Appareil The current object (for fluent API support)
     */
    public function addSocieteappareil(ChildSocieteappareil $l)
    {
        if ($this->collSocieteappareils === null) {
            $this->initSocieteappareils();
            $this->collSocieteappareilsPartial = true;
        }

        if (!$this->collSocieteappareils->contains($l)) {
            $this->doAddSocieteappareil($l);
        }

        return $this;
    }

    /**
     * @param ChildSocieteappareil $societeappareil The ChildSocieteappareil object to add.
     */
    protected function doAddSocieteappareil(ChildSocieteappareil $societeappareil)
    {
        $this->collSocieteappareils[]= $societeappareil;
        $societeappareil->setAppareil($this);
    }

    /**
     * @param  ChildSocieteappareil $societeappareil The ChildSocieteappareil object to remove.
     * @return $this|ChildAppareil The current object (for fluent API support)
     */
    public function removeSocieteappareil(ChildSocieteappareil $societeappareil)
    {
        if ($this->getSocieteappareils()->contains($societeappareil)) {
            $pos = $this->collSocieteappareils->search($societeappareil);
            $this->collSocieteappareils->remove($pos);
            if (null === $this->societeappareilsScheduledForDeletion) {
                $this->societeappareilsScheduledForDeletion = clone $this->collSocieteappareils;
                $this->societeappareilsScheduledForDeletion->clear();
            }
            $this->societeappareilsScheduledForDeletion[]= $societeappareil;
            $societeappareil->setAppareil(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Appareil is new, it will return
     * an empty collection; or if this Appareil has previously
     * been saved, it will retrieve related Societeappareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Appareil.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocieteappareil[] List of ChildSocieteappareil objects
     */
    public function getSocieteappareilsJoinSociete(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocieteappareilQuery::create(null, $criteria);
        $query->joinWith('Societe', $joinBehavior);

        return $this->getSocieteappareils($query, $con);
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
     * If this ChildAppareil is new, it will return
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
                    ->filterByAppareil($this)
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
     * @return $this|ChildAppareil The current object (for fluent API support)
     */
    public function setAppareilcertificats(Collection $appareilcertificats, ConnectionInterface $con = null)
    {
        /** @var ChildAppareilcertificat[] $appareilcertificatsToDelete */
        $appareilcertificatsToDelete = $this->getAppareilcertificats(new Criteria(), $con)->diff($appareilcertificats);


        $this->appareilcertificatsScheduledForDeletion = $appareilcertificatsToDelete;

        foreach ($appareilcertificatsToDelete as $appareilcertificatRemoved) {
            $appareilcertificatRemoved->setAppareil(null);
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
                ->filterByAppareil($this)
                ->count($con);
        }

        return count($this->collAppareilcertificats);
    }

    /**
     * Method called to associate a ChildAppareilcertificat object to this object
     * through the ChildAppareilcertificat foreign key attribute.
     *
     * @param  ChildAppareilcertificat $l ChildAppareilcertificat
     * @return $this|\Appareil The current object (for fluent API support)
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
        $appareilcertificat->setAppareil($this);
    }

    /**
     * @param  ChildAppareilcertificat $appareilcertificat The ChildAppareilcertificat object to remove.
     * @return $this|ChildAppareil The current object (for fluent API support)
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
            $appareilcertificat->setAppareil(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Appareil is new, it will return
     * an empty collection; or if this Appareil has previously
     * been saved, it will retrieve related Appareilcertificats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Appareil.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAppareilcertificat[] List of ChildAppareilcertificat objects
     */
    public function getAppareilcertificatsJoinCertificat(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAppareilcertificatQuery::create(null, $criteria);
        $query->joinWith('Certificat', $joinBehavior);

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
     * If this ChildAppareil is new, it will return
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
                    ->filterByAppareil($this)
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
     * @return $this|ChildAppareil The current object (for fluent API support)
     */
    public function setSocietecertificats(Collection $societecertificats, ConnectionInterface $con = null)
    {
        /** @var ChildSocietecertificat[] $societecertificatsToDelete */
        $societecertificatsToDelete = $this->getSocietecertificats(new Criteria(), $con)->diff($societecertificats);


        $this->societecertificatsScheduledForDeletion = $societecertificatsToDelete;

        foreach ($societecertificatsToDelete as $societecertificatRemoved) {
            $societecertificatRemoved->setAppareil(null);
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
                ->filterByAppareil($this)
                ->count($con);
        }

        return count($this->collSocietecertificats);
    }

    /**
     * Method called to associate a ChildSocietecertificat object to this object
     * through the ChildSocietecertificat foreign key attribute.
     *
     * @param  ChildSocietecertificat $l ChildSocietecertificat
     * @return $this|\Appareil The current object (for fluent API support)
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
        $societecertificat->setAppareil($this);
    }

    /**
     * @param  ChildSocietecertificat $societecertificat The ChildSocietecertificat object to remove.
     * @return $this|ChildAppareil The current object (for fluent API support)
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
            $societecertificat->setAppareil(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Appareil is new, it will return
     * an empty collection; or if this Appareil has previously
     * been saved, it will retrieve related Societecertificats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Appareil.
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
     * Otherwise if this Appareil is new, it will return
     * an empty collection; or if this Appareil has previously
     * been saved, it will retrieve related Societecertificats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Appareil.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocietecertificat[] List of ChildSocietecertificat objects
     */
    public function getSocietecertificatsJoinCertificat(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocietecertificatQuery::create(null, $criteria);
        $query->joinWith('Certificat', $joinBehavior);

        return $this->getSocietecertificats($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aMarque) {
            $this->aMarque->removeAppareil($this);
        }
        if (null !== $this->aModele) {
            $this->aModele->removeAppareil($this);
        }
        $this->idap = null;
        $this->immatriculation = null;
        $this->nom_app = null;
        $this->modele_pk = null;
        $this->marque_pk = null;
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
            if ($this->collPhotoappareils) {
                foreach ($this->collPhotoappareils as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCMDTAppareils) {
                foreach ($this->collCMDTAppareils as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSocieteappareils) {
                foreach ($this->collSocieteappareils as $o) {
                    $o->clearAllReferences($deep);
                }
            }
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

        $this->collPieceApps = null;
        $this->collPhotoappareils = null;
        $this->collCMDTAppareils = null;
        $this->collSocieteappareils = null;
        $this->collAppareilcertificats = null;
        $this->collSocietecertificats = null;
        $this->aMarque = null;
        $this->aModele = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AppareilTableMap::DEFAULT_STRING_FORMAT);
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
