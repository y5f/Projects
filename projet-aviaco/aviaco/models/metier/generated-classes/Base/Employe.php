<?php

namespace Base;

use \Article as ChildArticle;
use \ArticleQuery as ChildArticleQuery;
use \CV as ChildCV;
use \CVQuery as ChildCVQuery;
use \Employe as ChildEmploye;
use \EmployeQuery as ChildEmployeQuery;
use \Session as ChildSession;
use \SessionQuery as ChildSessionQuery;
use \Exception;
use \PDO;
use Map\EmployeTableMap;
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
 * Base class that represents a row from the 'employe' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Employe implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\EmployeTableMap';


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
     * The value for the id_emp field.
     * @var        string
     */
    protected $id_emp;

    /**
     * The value for the nom field.
     * @var        string
     */
    protected $nom;

    /**
     * The value for the prenom field.
     * @var        string
     */
    protected $prenom;

    /**
     * The value for the adresses field.
     * @var        string
     */
    protected $adresses;

    /**
     * The value for the cp field.
     * @var        int
     */
    protected $cp;

    /**
     * The value for the fonction field.
     * @var        string
     */
    protected $fonction;

    /**
     * The value for the telephone field.
     * @var        string
     */
    protected $telephone;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the passe field.
     * @var        string
     */
    protected $passe;

    /**
     * The value for the acces field.
     * @var        string
     */
    protected $acces;

    /**
     * The value for the avatard field.
     * @var        string
     */
    protected $avatard;

    /**
     * The value for the etat field.
     * @var        boolean
     */
    protected $etat;

    /**
     * @var        ObjectCollection|ChildSession[] Collection to store aggregation of ChildSession objects.
     */
    protected $collSessions;
    protected $collSessionsPartial;

    /**
     * @var        ObjectCollection|ChildCV[] Collection to store aggregation of ChildCV objects.
     */
    protected $collCVs;
    protected $collCVsPartial;

    /**
     * @var        ObjectCollection|ChildArticle[] Collection to store aggregation of ChildArticle objects.
     */
    protected $collArticles;
    protected $collArticlesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSession[]
     */
    protected $sessionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCV[]
     */
    protected $cVsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildArticle[]
     */
    protected $articlesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Employe object.
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
     * Compares this with another <code>Employe</code> instance.  If
     * <code>obj</code> is an instance of <code>Employe</code>, delegates to
     * <code>equals(Employe)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Employe The current object, for fluid interface
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
     * Get the [id_emp] column value.
     *
     * @return string
     */
    public function getIdEmploye()
    {
        return $this->id_emp;
    }

    /**
     * Get the [nom] column value.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get the [prenom] column value.
     *
     * @return string
     */
    public function getPrenoom()
    {
        return $this->prenom;
    }

    /**
     * Get the [adresses] column value.
     *
     * @return string
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Get the [cp] column value.
     *
     * @return int
     */
    public function getCodepostal()
    {
        return $this->cp;
    }

    /**
     * Get the [fonction] column value.
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Get the [telephone] column value.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [passe] column value.
     *
     * @return string
     */
    public function getPasse()
    {
        return $this->passe;
    }

    /**
     * Get the [acces] column value.
     *
     * @return string
     */
    public function getNiveaAcces()
    {
        return $this->acces;
    }

    /**
     * Get the [avatard] column value.
     *
     * @return string
     */
    public function getAvatard()
    {
        return $this->avatard;
    }

    /**
     * Get the [etat] column value.
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Get the [etat] column value.
     *
     * @return boolean
     */
    public function isEtat()
    {
        return $this->getEtat();
    }

    /**
     * Set the value of [id_emp] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setIdEmploye($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id_emp !== $v) {
            $this->id_emp = $v;
            $this->modifiedColumns[EmployeTableMap::COL_ID_EMP] = true;
        }

        return $this;
    } // setIdEmploye()

    /**
     * Set the value of [nom] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setNom($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nom !== $v) {
            $this->nom = $v;
            $this->modifiedColumns[EmployeTableMap::COL_NOM] = true;
        }

        return $this;
    } // setNom()

    /**
     * Set the value of [prenom] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setPrenoom($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->prenom !== $v) {
            $this->prenom = $v;
            $this->modifiedColumns[EmployeTableMap::COL_PRENOM] = true;
        }

        return $this;
    } // setPrenoom()

    /**
     * Set the value of [adresses] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setAdresses($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->adresses !== $v) {
            $this->adresses = $v;
            $this->modifiedColumns[EmployeTableMap::COL_ADRESSES] = true;
        }

        return $this;
    } // setAdresses()

    /**
     * Set the value of [cp] column.
     *
     * @param int $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setCodepostal($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cp !== $v) {
            $this->cp = $v;
            $this->modifiedColumns[EmployeTableMap::COL_CP] = true;
        }

        return $this;
    } // setCodepostal()

    /**
     * Set the value of [fonction] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setFonction($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fonction !== $v) {
            $this->fonction = $v;
            $this->modifiedColumns[EmployeTableMap::COL_FONCTION] = true;
        }

        return $this;
    } // setFonction()

    /**
     * Set the value of [telephone] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setTelephone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telephone !== $v) {
            $this->telephone = $v;
            $this->modifiedColumns[EmployeTableMap::COL_TELEPHONE] = true;
        }

        return $this;
    } // setTelephone()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[EmployeTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [passe] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setPasse($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->passe !== $v) {
            $this->passe = $v;
            $this->modifiedColumns[EmployeTableMap::COL_PASSE] = true;
        }

        return $this;
    } // setPasse()

    /**
     * Set the value of [acces] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setNiveaAcces($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->acces !== $v) {
            $this->acces = $v;
            $this->modifiedColumns[EmployeTableMap::COL_ACCES] = true;
        }

        return $this;
    } // setNiveaAcces()

    /**
     * Set the value of [avatard] column.
     *
     * @param string $v new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setAvatard($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->avatard !== $v) {
            $this->avatard = $v;
            $this->modifiedColumns[EmployeTableMap::COL_AVATARD] = true;
        }

        return $this;
    } // setAvatard()

    /**
     * Sets the value of the [etat] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function setEtat($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->etat !== $v) {
            $this->etat = $v;
            $this->modifiedColumns[EmployeTableMap::COL_ETAT] = true;
        }

        return $this;
    } // setEtat()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EmployeTableMap::translateFieldName('IdEmploye', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_emp = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EmployeTableMap::translateFieldName('Nom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nom = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EmployeTableMap::translateFieldName('Prenoom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prenom = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EmployeTableMap::translateFieldName('Adresses', TableMap::TYPE_PHPNAME, $indexType)];
            $this->adresses = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EmployeTableMap::translateFieldName('Codepostal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cp = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EmployeTableMap::translateFieldName('Fonction', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fonction = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EmployeTableMap::translateFieldName('Telephone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->telephone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EmployeTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EmployeTableMap::translateFieldName('Passe', TableMap::TYPE_PHPNAME, $indexType)];
            $this->passe = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : EmployeTableMap::translateFieldName('NiveaAcces', TableMap::TYPE_PHPNAME, $indexType)];
            $this->acces = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : EmployeTableMap::translateFieldName('Avatard', TableMap::TYPE_PHPNAME, $indexType)];
            $this->avatard = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : EmployeTableMap::translateFieldName('Etat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->etat = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = EmployeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Employe'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(EmployeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEmployeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSessions = null;

            $this->collCVs = null;

            $this->collArticles = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Employe::setDeleted()
     * @see Employe::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEmployeQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
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
                EmployeTableMap::addInstanceToPool($this);
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

            if ($this->sessionsScheduledForDeletion !== null) {
                if (!$this->sessionsScheduledForDeletion->isEmpty()) {
                    \SessionQuery::create()
                        ->filterByPrimaryKeys($this->sessionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sessionsScheduledForDeletion = null;
                }
            }

            if ($this->collSessions !== null) {
                foreach ($this->collSessions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cVsScheduledForDeletion !== null) {
                if (!$this->cVsScheduledForDeletion->isEmpty()) {
                    \CVQuery::create()
                        ->filterByPrimaryKeys($this->cVsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cVsScheduledForDeletion = null;
                }
            }

            if ($this->collCVs !== null) {
                foreach ($this->collCVs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->articlesScheduledForDeletion !== null) {
                if (!$this->articlesScheduledForDeletion->isEmpty()) {
                    \ArticleQuery::create()
                        ->filterByPrimaryKeys($this->articlesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->articlesScheduledForDeletion = null;
                }
            }

            if ($this->collArticles !== null) {
                foreach ($this->collArticles as $referrerFK) {
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
        if ($this->isColumnModified(EmployeTableMap::COL_ID_EMP)) {
            $modifiedColumns[':p' . $index++]  = 'id_emp';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_NOM)) {
            $modifiedColumns[':p' . $index++]  = 'nom';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_PRENOM)) {
            $modifiedColumns[':p' . $index++]  = 'prenom';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_ADRESSES)) {
            $modifiedColumns[':p' . $index++]  = 'adresses';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_CP)) {
            $modifiedColumns[':p' . $index++]  = 'cp';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_FONCTION)) {
            $modifiedColumns[':p' . $index++]  = 'fonction';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_TELEPHONE)) {
            $modifiedColumns[':p' . $index++]  = 'telephone';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_PASSE)) {
            $modifiedColumns[':p' . $index++]  = 'passe';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_ACCES)) {
            $modifiedColumns[':p' . $index++]  = 'acces';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_AVATARD)) {
            $modifiedColumns[':p' . $index++]  = 'avatard';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_ETAT)) {
            $modifiedColumns[':p' . $index++]  = 'etat';
        }

        $sql = sprintf(
            'INSERT INTO employe (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id_emp':
                        $stmt->bindValue($identifier, $this->id_emp, PDO::PARAM_STR);
                        break;
                    case 'nom':
                        $stmt->bindValue($identifier, $this->nom, PDO::PARAM_STR);
                        break;
                    case 'prenom':
                        $stmt->bindValue($identifier, $this->prenom, PDO::PARAM_STR);
                        break;
                    case 'adresses':
                        $stmt->bindValue($identifier, $this->adresses, PDO::PARAM_STR);
                        break;
                    case 'cp':
                        $stmt->bindValue($identifier, $this->cp, PDO::PARAM_INT);
                        break;
                    case 'fonction':
                        $stmt->bindValue($identifier, $this->fonction, PDO::PARAM_STR);
                        break;
                    case 'telephone':
                        $stmt->bindValue($identifier, $this->telephone, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'passe':
                        $stmt->bindValue($identifier, $this->passe, PDO::PARAM_STR);
                        break;
                    case 'acces':
                        $stmt->bindValue($identifier, $this->acces, PDO::PARAM_STR);
                        break;
                    case 'avatard':
                        $stmt->bindValue($identifier, $this->avatard, PDO::PARAM_STR);
                        break;
                    case 'etat':
                        $stmt->bindValue($identifier, (int) $this->etat, PDO::PARAM_INT);
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
        $pos = EmployeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdEmploye();
                break;
            case 1:
                return $this->getNom();
                break;
            case 2:
                return $this->getPrenoom();
                break;
            case 3:
                return $this->getAdresses();
                break;
            case 4:
                return $this->getCodepostal();
                break;
            case 5:
                return $this->getFonction();
                break;
            case 6:
                return $this->getTelephone();
                break;
            case 7:
                return $this->getEmail();
                break;
            case 8:
                return $this->getPasse();
                break;
            case 9:
                return $this->getNiveaAcces();
                break;
            case 10:
                return $this->getAvatard();
                break;
            case 11:
                return $this->getEtat();
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

        if (isset($alreadyDumpedObjects['Employe'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Employe'][$this->hashCode()] = true;
        $keys = EmployeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdEmploye(),
            $keys[1] => $this->getNom(),
            $keys[2] => $this->getPrenoom(),
            $keys[3] => $this->getAdresses(),
            $keys[4] => $this->getCodepostal(),
            $keys[5] => $this->getFonction(),
            $keys[6] => $this->getTelephone(),
            $keys[7] => $this->getEmail(),
            $keys[8] => $this->getPasse(),
            $keys[9] => $this->getNiveaAcces(),
            $keys[10] => $this->getAvatard(),
            $keys[11] => $this->getEtat(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSessions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sessions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sessions';
                        break;
                    default:
                        $key = 'Sessions';
                }

                $result[$key] = $this->collSessions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCVs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cVs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'cvs';
                        break;
                    default:
                        $key = 'CVs';
                }

                $result[$key] = $this->collCVs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collArticles) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'articles';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'articles';
                        break;
                    default:
                        $key = 'Articles';
                }

                $result[$key] = $this->collArticles->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Employe
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EmployeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Employe
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdEmploye($value);
                break;
            case 1:
                $this->setNom($value);
                break;
            case 2:
                $this->setPrenoom($value);
                break;
            case 3:
                $this->setAdresses($value);
                break;
            case 4:
                $this->setCodepostal($value);
                break;
            case 5:
                $this->setFonction($value);
                break;
            case 6:
                $this->setTelephone($value);
                break;
            case 7:
                $this->setEmail($value);
                break;
            case 8:
                $this->setPasse($value);
                break;
            case 9:
                $this->setNiveaAcces($value);
                break;
            case 10:
                $this->setAvatard($value);
                break;
            case 11:
                $this->setEtat($value);
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
        $keys = EmployeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setIdEmploye($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setNom($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPrenoom($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setAdresses($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCodepostal($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setFonction($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setTelephone($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setEmail($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPasse($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setNiveaAcces($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setAvatard($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setEtat($arr[$keys[11]]);
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
     * @return $this|\Employe The current object, for fluid interface
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
        $criteria = new Criteria(EmployeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EmployeTableMap::COL_ID_EMP)) {
            $criteria->add(EmployeTableMap::COL_ID_EMP, $this->id_emp);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_NOM)) {
            $criteria->add(EmployeTableMap::COL_NOM, $this->nom);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_PRENOM)) {
            $criteria->add(EmployeTableMap::COL_PRENOM, $this->prenom);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_ADRESSES)) {
            $criteria->add(EmployeTableMap::COL_ADRESSES, $this->adresses);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_CP)) {
            $criteria->add(EmployeTableMap::COL_CP, $this->cp);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_FONCTION)) {
            $criteria->add(EmployeTableMap::COL_FONCTION, $this->fonction);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_TELEPHONE)) {
            $criteria->add(EmployeTableMap::COL_TELEPHONE, $this->telephone);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_EMAIL)) {
            $criteria->add(EmployeTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_PASSE)) {
            $criteria->add(EmployeTableMap::COL_PASSE, $this->passe);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_ACCES)) {
            $criteria->add(EmployeTableMap::COL_ACCES, $this->acces);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_AVATARD)) {
            $criteria->add(EmployeTableMap::COL_AVATARD, $this->avatard);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_ETAT)) {
            $criteria->add(EmployeTableMap::COL_ETAT, $this->etat);
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
        $criteria = ChildEmployeQuery::create();
        $criteria->add(EmployeTableMap::COL_ID_EMP, $this->id_emp);

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
        $validPk = null !== $this->getIdEmploye();

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
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getIdEmploye();
    }

    /**
     * Generic method to set the primary key (id_emp column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdEmploye($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getIdEmploye();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Employe (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdEmploye($this->getIdEmploye());
        $copyObj->setNom($this->getNom());
        $copyObj->setPrenoom($this->getPrenoom());
        $copyObj->setAdresses($this->getAdresses());
        $copyObj->setCodepostal($this->getCodepostal());
        $copyObj->setFonction($this->getFonction());
        $copyObj->setTelephone($this->getTelephone());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setPasse($this->getPasse());
        $copyObj->setNiveaAcces($this->getNiveaAcces());
        $copyObj->setAvatard($this->getAvatard());
        $copyObj->setEtat($this->getEtat());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSessions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSession($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCVs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCV($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getArticles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addArticle($relObj->copy($deepCopy));
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
     * @return \Employe Clone of current object.
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
        if ('Session' == $relationName) {
            return $this->initSessions();
        }
        if ('CV' == $relationName) {
            return $this->initCVs();
        }
        if ('Article' == $relationName) {
            return $this->initArticles();
        }
    }

    /**
     * Clears out the collSessions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSessions()
     */
    public function clearSessions()
    {
        $this->collSessions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSessions collection loaded partially.
     */
    public function resetPartialSessions($v = true)
    {
        $this->collSessionsPartial = $v;
    }

    /**
     * Initializes the collSessions collection.
     *
     * By default this just sets the collSessions collection to an empty array (like clearcollSessions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSessions($overrideExisting = true)
    {
        if (null !== $this->collSessions && !$overrideExisting) {
            return;
        }
        $this->collSessions = new ObjectCollection();
        $this->collSessions->setModel('\Session');
    }

    /**
     * Gets an array of ChildSession objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmploye is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSession[] List of ChildSession objects
     * @throws PropelException
     */
    public function getSessions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSessionsPartial && !$this->isNew();
        if (null === $this->collSessions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSessions) {
                // return empty collection
                $this->initSessions();
            } else {
                $collSessions = ChildSessionQuery::create(null, $criteria)
                    ->filterByEmploye($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSessionsPartial && count($collSessions)) {
                        $this->initSessions(false);

                        foreach ($collSessions as $obj) {
                            if (false == $this->collSessions->contains($obj)) {
                                $this->collSessions->append($obj);
                            }
                        }

                        $this->collSessionsPartial = true;
                    }

                    return $collSessions;
                }

                if ($partial && $this->collSessions) {
                    foreach ($this->collSessions as $obj) {
                        if ($obj->isNew()) {
                            $collSessions[] = $obj;
                        }
                    }
                }

                $this->collSessions = $collSessions;
                $this->collSessionsPartial = false;
            }
        }

        return $this->collSessions;
    }

    /**
     * Sets a collection of ChildSession objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sessions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function setSessions(Collection $sessions, ConnectionInterface $con = null)
    {
        /** @var ChildSession[] $sessionsToDelete */
        $sessionsToDelete = $this->getSessions(new Criteria(), $con)->diff($sessions);


        $this->sessionsScheduledForDeletion = $sessionsToDelete;

        foreach ($sessionsToDelete as $sessionRemoved) {
            $sessionRemoved->setEmploye(null);
        }

        $this->collSessions = null;
        foreach ($sessions as $session) {
            $this->addSession($session);
        }

        $this->collSessions = $sessions;
        $this->collSessionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Session objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Session objects.
     * @throws PropelException
     */
    public function countSessions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSessionsPartial && !$this->isNew();
        if (null === $this->collSessions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSessions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSessions());
            }

            $query = ChildSessionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmploye($this)
                ->count($con);
        }

        return count($this->collSessions);
    }

    /**
     * Method called to associate a ChildSession object to this object
     * through the ChildSession foreign key attribute.
     *
     * @param  ChildSession $l ChildSession
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function addSession(ChildSession $l)
    {
        if ($this->collSessions === null) {
            $this->initSessions();
            $this->collSessionsPartial = true;
        }

        if (!$this->collSessions->contains($l)) {
            $this->doAddSession($l);
        }

        return $this;
    }

    /**
     * @param ChildSession $session The ChildSession object to add.
     */
    protected function doAddSession(ChildSession $session)
    {
        $this->collSessions[]= $session;
        $session->setEmploye($this);
    }

    /**
     * @param  ChildSession $session The ChildSession object to remove.
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function removeSession(ChildSession $session)
    {
        if ($this->getSessions()->contains($session)) {
            $pos = $this->collSessions->search($session);
            $this->collSessions->remove($pos);
            if (null === $this->sessionsScheduledForDeletion) {
                $this->sessionsScheduledForDeletion = clone $this->collSessions;
                $this->sessionsScheduledForDeletion->clear();
            }
            $this->sessionsScheduledForDeletion[]= $session;
            $session->setEmploye(null);
        }

        return $this;
    }

    /**
     * Clears out the collCVs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCVs()
     */
    public function clearCVs()
    {
        $this->collCVs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCVs collection loaded partially.
     */
    public function resetPartialCVs($v = true)
    {
        $this->collCVsPartial = $v;
    }

    /**
     * Initializes the collCVs collection.
     *
     * By default this just sets the collCVs collection to an empty array (like clearcollCVs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCVs($overrideExisting = true)
    {
        if (null !== $this->collCVs && !$overrideExisting) {
            return;
        }
        $this->collCVs = new ObjectCollection();
        $this->collCVs->setModel('\CV');
    }

    /**
     * Gets an array of ChildCV objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmploye is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCV[] List of ChildCV objects
     * @throws PropelException
     */
    public function getCVs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCVsPartial && !$this->isNew();
        if (null === $this->collCVs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCVs) {
                // return empty collection
                $this->initCVs();
            } else {
                $collCVs = ChildCVQuery::create(null, $criteria)
                    ->filterByEmploye($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCVsPartial && count($collCVs)) {
                        $this->initCVs(false);

                        foreach ($collCVs as $obj) {
                            if (false == $this->collCVs->contains($obj)) {
                                $this->collCVs->append($obj);
                            }
                        }

                        $this->collCVsPartial = true;
                    }

                    return $collCVs;
                }

                if ($partial && $this->collCVs) {
                    foreach ($this->collCVs as $obj) {
                        if ($obj->isNew()) {
                            $collCVs[] = $obj;
                        }
                    }
                }

                $this->collCVs = $collCVs;
                $this->collCVsPartial = false;
            }
        }

        return $this->collCVs;
    }

    /**
     * Sets a collection of ChildCV objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cVs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function setCVs(Collection $cVs, ConnectionInterface $con = null)
    {
        /** @var ChildCV[] $cVsToDelete */
        $cVsToDelete = $this->getCVs(new Criteria(), $con)->diff($cVs);


        $this->cVsScheduledForDeletion = $cVsToDelete;

        foreach ($cVsToDelete as $cVRemoved) {
            $cVRemoved->setEmploye(null);
        }

        $this->collCVs = null;
        foreach ($cVs as $cV) {
            $this->addCV($cV);
        }

        $this->collCVs = $cVs;
        $this->collCVsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CV objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CV objects.
     * @throws PropelException
     */
    public function countCVs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCVsPartial && !$this->isNew();
        if (null === $this->collCVs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCVs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCVs());
            }

            $query = ChildCVQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmploye($this)
                ->count($con);
        }

        return count($this->collCVs);
    }

    /**
     * Method called to associate a ChildCV object to this object
     * through the ChildCV foreign key attribute.
     *
     * @param  ChildCV $l ChildCV
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function addCV(ChildCV $l)
    {
        if ($this->collCVs === null) {
            $this->initCVs();
            $this->collCVsPartial = true;
        }

        if (!$this->collCVs->contains($l)) {
            $this->doAddCV($l);
        }

        return $this;
    }

    /**
     * @param ChildCV $cV The ChildCV object to add.
     */
    protected function doAddCV(ChildCV $cV)
    {
        $this->collCVs[]= $cV;
        $cV->setEmploye($this);
    }

    /**
     * @param  ChildCV $cV The ChildCV object to remove.
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function removeCV(ChildCV $cV)
    {
        if ($this->getCVs()->contains($cV)) {
            $pos = $this->collCVs->search($cV);
            $this->collCVs->remove($pos);
            if (null === $this->cVsScheduledForDeletion) {
                $this->cVsScheduledForDeletion = clone $this->collCVs;
                $this->cVsScheduledForDeletion->clear();
            }
            $this->cVsScheduledForDeletion[]= $cV;
            $cV->setEmploye(null);
        }

        return $this;
    }

    /**
     * Clears out the collArticles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addArticles()
     */
    public function clearArticles()
    {
        $this->collArticles = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collArticles collection loaded partially.
     */
    public function resetPartialArticles($v = true)
    {
        $this->collArticlesPartial = $v;
    }

    /**
     * Initializes the collArticles collection.
     *
     * By default this just sets the collArticles collection to an empty array (like clearcollArticles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initArticles($overrideExisting = true)
    {
        if (null !== $this->collArticles && !$overrideExisting) {
            return;
        }
        $this->collArticles = new ObjectCollection();
        $this->collArticles->setModel('\Article');
    }

    /**
     * Gets an array of ChildArticle objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmploye is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildArticle[] List of ChildArticle objects
     * @throws PropelException
     */
    public function getArticles(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collArticlesPartial && !$this->isNew();
        if (null === $this->collArticles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collArticles) {
                // return empty collection
                $this->initArticles();
            } else {
                $collArticles = ChildArticleQuery::create(null, $criteria)
                    ->filterByEmploye($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collArticlesPartial && count($collArticles)) {
                        $this->initArticles(false);

                        foreach ($collArticles as $obj) {
                            if (false == $this->collArticles->contains($obj)) {
                                $this->collArticles->append($obj);
                            }
                        }

                        $this->collArticlesPartial = true;
                    }

                    return $collArticles;
                }

                if ($partial && $this->collArticles) {
                    foreach ($this->collArticles as $obj) {
                        if ($obj->isNew()) {
                            $collArticles[] = $obj;
                        }
                    }
                }

                $this->collArticles = $collArticles;
                $this->collArticlesPartial = false;
            }
        }

        return $this->collArticles;
    }

    /**
     * Sets a collection of ChildArticle objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $articles A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function setArticles(Collection $articles, ConnectionInterface $con = null)
    {
        /** @var ChildArticle[] $articlesToDelete */
        $articlesToDelete = $this->getArticles(new Criteria(), $con)->diff($articles);


        $this->articlesScheduledForDeletion = $articlesToDelete;

        foreach ($articlesToDelete as $articleRemoved) {
            $articleRemoved->setEmploye(null);
        }

        $this->collArticles = null;
        foreach ($articles as $article) {
            $this->addArticle($article);
        }

        $this->collArticles = $articles;
        $this->collArticlesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Article objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Article objects.
     * @throws PropelException
     */
    public function countArticles(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collArticlesPartial && !$this->isNew();
        if (null === $this->collArticles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collArticles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getArticles());
            }

            $query = ChildArticleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmploye($this)
                ->count($con);
        }

        return count($this->collArticles);
    }

    /**
     * Method called to associate a ChildArticle object to this object
     * through the ChildArticle foreign key attribute.
     *
     * @param  ChildArticle $l ChildArticle
     * @return $this|\Employe The current object (for fluent API support)
     */
    public function addArticle(ChildArticle $l)
    {
        if ($this->collArticles === null) {
            $this->initArticles();
            $this->collArticlesPartial = true;
        }

        if (!$this->collArticles->contains($l)) {
            $this->doAddArticle($l);
        }

        return $this;
    }

    /**
     * @param ChildArticle $article The ChildArticle object to add.
     */
    protected function doAddArticle(ChildArticle $article)
    {
        $this->collArticles[]= $article;
        $article->setEmploye($this);
    }

    /**
     * @param  ChildArticle $article The ChildArticle object to remove.
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function removeArticle(ChildArticle $article)
    {
        if ($this->getArticles()->contains($article)) {
            $pos = $this->collArticles->search($article);
            $this->collArticles->remove($pos);
            if (null === $this->articlesScheduledForDeletion) {
                $this->articlesScheduledForDeletion = clone $this->collArticles;
                $this->articlesScheduledForDeletion->clear();
            }
            $this->articlesScheduledForDeletion[]= $article;
            $article->setEmploye(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Employe is new, it will return
     * an empty collection; or if this Employe has previously
     * been saved, it will retrieve related Articles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Employe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildArticle[] List of ChildArticle objects
     */
    public function getArticlesJoinCategorie(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildArticleQuery::create(null, $criteria);
        $query->joinWith('Categorie', $joinBehavior);

        return $this->getArticles($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Employe is new, it will return
     * an empty collection; or if this Employe has previously
     * been saved, it will retrieve related Articles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Employe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildArticle[] List of ChildArticle objects
     */
    public function getArticlesJoinSouscategorie(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildArticleQuery::create(null, $criteria);
        $query->joinWith('Souscategorie', $joinBehavior);

        return $this->getArticles($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id_emp = null;
        $this->nom = null;
        $this->prenom = null;
        $this->adresses = null;
        $this->cp = null;
        $this->fonction = null;
        $this->telephone = null;
        $this->email = null;
        $this->passe = null;
        $this->acces = null;
        $this->avatard = null;
        $this->etat = null;
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
            if ($this->collSessions) {
                foreach ($this->collSessions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCVs) {
                foreach ($this->collCVs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collArticles) {
                foreach ($this->collArticles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSessions = null;
        $this->collCVs = null;
        $this->collArticles = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EmployeTableMap::DEFAULT_STRING_FORMAT);
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
