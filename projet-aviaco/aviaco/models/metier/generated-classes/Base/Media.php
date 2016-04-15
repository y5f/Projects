<?php

namespace Base;

use \Categorie as ChildCategorie;
use \CategorieQuery as ChildCategorieQuery;
use \MediaQuery as ChildMediaQuery;
use \Souscategorie as ChildSouscategorie;
use \SouscategorieQuery as ChildSouscategorieQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\MediaTableMap;
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
 * Base class that represents a row from the 'media' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Media implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\MediaTableMap';


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
     * The value for the media_num field.
     * @var        int
     */
    protected $media_num;

    /**
     * The value for the media_date field.
     * @var        \DateTime
     */
    protected $media_date;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the media_url field.
     * @var        string
     */
    protected $media_url;

    /**
     * The value for the commentaire field.
     * @var        string
     */
    protected $commentaire;

    /**
     * The value for the cat_fk field.
     * @var        string
     */
    protected $cat_fk;

    /**
     * The value for the s_cat_fk field.
     * @var        string
     */
    protected $s_cat_fk;

    /**
     * @var        ChildCategorie
     */
    protected $aCategorie;

    /**
     * @var        ChildSouscategorie
     */
    protected $aSouscategorie;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\Media object.
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
     * Compares this with another <code>Media</code> instance.  If
     * <code>obj</code> is an instance of <code>Media</code>, delegates to
     * <code>equals(Media)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Media The current object, for fluid interface
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
     * Get the [media_num] column value.
     *
     * @return int
     */
    public function getMedianum()
    {
        return $this->media_num;
    }

    /**
     * Get the [optionally formatted] temporal [media_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getMediadate($format = NULL)
    {
        if ($format === null) {
            return $this->media_date;
        } else {
            return $this->media_date instanceof \DateTime ? $this->media_date->format($format) : null;
        }
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
     * Get the [media_url] column value.
     *
     * @return string
     */
    public function getURL()
    {
        return $this->media_url;
    }

    /**
     * Get the [commentaire] column value.
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Get the [cat_fk] column value.
     *
     * @return string
     */
    public function getCategorie_FK()
    {
        return $this->cat_fk;
    }

    /**
     * Get the [s_cat_fk] column value.
     *
     * @return string
     */
    public function getSouscategorie_FK()
    {
        return $this->s_cat_fk;
    }

    /**
     * Set the value of [media_num] column.
     *
     * @param int $v new value
     * @return $this|\Media The current object (for fluent API support)
     */
    public function setMedianum($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->media_num !== $v) {
            $this->media_num = $v;
            $this->modifiedColumns[MediaTableMap::COL_MEDIA_NUM] = true;
        }

        return $this;
    } // setMedianum()

    /**
     * Sets the value of [media_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Media The current object (for fluent API support)
     */
    public function setMediadate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->media_date !== null || $dt !== null) {
            if ($this->media_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->media_date->format("Y-m-d H:i:s")) {
                $this->media_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[MediaTableMap::COL_MEDIA_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setMediadate()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\Media The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[MediaTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [media_url] column.
     *
     * @param string $v new value
     * @return $this|\Media The current object (for fluent API support)
     */
    public function setURL($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->media_url !== $v) {
            $this->media_url = $v;
            $this->modifiedColumns[MediaTableMap::COL_MEDIA_URL] = true;
        }

        return $this;
    } // setURL()

    /**
     * Set the value of [commentaire] column.
     *
     * @param string $v new value
     * @return $this|\Media The current object (for fluent API support)
     */
    public function setCommentaire($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->commentaire !== $v) {
            $this->commentaire = $v;
            $this->modifiedColumns[MediaTableMap::COL_COMMENTAIRE] = true;
        }

        return $this;
    } // setCommentaire()

    /**
     * Set the value of [cat_fk] column.
     *
     * @param string $v new value
     * @return $this|\Media The current object (for fluent API support)
     */
    public function setCategorie_FK($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cat_fk !== $v) {
            $this->cat_fk = $v;
            $this->modifiedColumns[MediaTableMap::COL_CAT_FK] = true;
        }

        if ($this->aCategorie !== null && $this->aCategorie->getCategorie() !== $v) {
            $this->aCategorie = null;
        }

        return $this;
    } // setCategorie_FK()

    /**
     * Set the value of [s_cat_fk] column.
     *
     * @param string $v new value
     * @return $this|\Media The current object (for fluent API support)
     */
    public function setSouscategorie_FK($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->s_cat_fk !== $v) {
            $this->s_cat_fk = $v;
            $this->modifiedColumns[MediaTableMap::COL_S_CAT_FK] = true;
        }

        if ($this->aSouscategorie !== null && $this->aSouscategorie->getSouscategorie() !== $v) {
            $this->aSouscategorie = null;
        }

        return $this;
    } // setSouscategorie_FK()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MediaTableMap::translateFieldName('Medianum', TableMap::TYPE_PHPNAME, $indexType)];
            $this->media_num = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MediaTableMap::translateFieldName('Mediadate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->media_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MediaTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MediaTableMap::translateFieldName('URL', TableMap::TYPE_PHPNAME, $indexType)];
            $this->media_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MediaTableMap::translateFieldName('Commentaire', TableMap::TYPE_PHPNAME, $indexType)];
            $this->commentaire = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : MediaTableMap::translateFieldName('Categorie_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cat_fk = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : MediaTableMap::translateFieldName('Souscategorie_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->s_cat_fk = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = MediaTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Media'), 0, $e);
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
        if ($this->aCategorie !== null && $this->cat_fk !== $this->aCategorie->getCategorie()) {
            $this->aCategorie = null;
        }
        if ($this->aSouscategorie !== null && $this->s_cat_fk !== $this->aSouscategorie->getSouscategorie()) {
            $this->aSouscategorie = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(MediaTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMediaQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCategorie = null;
            $this->aSouscategorie = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Media::setDeleted()
     * @see Media::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MediaTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMediaQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(MediaTableMap::DATABASE_NAME);
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
                MediaTableMap::addInstanceToPool($this);
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

            if ($this->aCategorie !== null) {
                if ($this->aCategorie->isModified() || $this->aCategorie->isNew()) {
                    $affectedRows += $this->aCategorie->save($con);
                }
                $this->setCategorie($this->aCategorie);
            }

            if ($this->aSouscategorie !== null) {
                if ($this->aSouscategorie->isModified() || $this->aSouscategorie->isNew()) {
                    $affectedRows += $this->aSouscategorie->save($con);
                }
                $this->setSouscategorie($this->aSouscategorie);
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

        $this->modifiedColumns[MediaTableMap::COL_MEDIA_NUM] = true;
        if (null !== $this->media_num) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MediaTableMap::COL_MEDIA_NUM . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MediaTableMap::COL_MEDIA_NUM)) {
            $modifiedColumns[':p' . $index++]  = 'media_num';
        }
        if ($this->isColumnModified(MediaTableMap::COL_MEDIA_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'media_date';
        }
        if ($this->isColumnModified(MediaTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(MediaTableMap::COL_MEDIA_URL)) {
            $modifiedColumns[':p' . $index++]  = 'media_url';
        }
        if ($this->isColumnModified(MediaTableMap::COL_COMMENTAIRE)) {
            $modifiedColumns[':p' . $index++]  = 'commentaire';
        }
        if ($this->isColumnModified(MediaTableMap::COL_CAT_FK)) {
            $modifiedColumns[':p' . $index++]  = 'cat_FK';
        }
        if ($this->isColumnModified(MediaTableMap::COL_S_CAT_FK)) {
            $modifiedColumns[':p' . $index++]  = 's_cat_FK';
        }

        $sql = sprintf(
            'INSERT INTO media (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'media_num':
                        $stmt->bindValue($identifier, $this->media_num, PDO::PARAM_INT);
                        break;
                    case 'media_date':
                        $stmt->bindValue($identifier, $this->media_date ? $this->media_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'media_url':
                        $stmt->bindValue($identifier, $this->media_url, PDO::PARAM_STR);
                        break;
                    case 'commentaire':
                        $stmt->bindValue($identifier, $this->commentaire, PDO::PARAM_STR);
                        break;
                    case 'cat_FK':
                        $stmt->bindValue($identifier, $this->cat_fk, PDO::PARAM_STR);
                        break;
                    case 's_cat_FK':
                        $stmt->bindValue($identifier, $this->s_cat_fk, PDO::PARAM_STR);
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
        $this->setMedianum($pk);

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
        $pos = MediaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getMedianum();
                break;
            case 1:
                return $this->getMediadate();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getURL();
                break;
            case 4:
                return $this->getCommentaire();
                break;
            case 5:
                return $this->getCategorie_FK();
                break;
            case 6:
                return $this->getSouscategorie_FK();
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

        if (isset($alreadyDumpedObjects['Media'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Media'][$this->hashCode()] = true;
        $keys = MediaTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getMedianum(),
            $keys[1] => $this->getMediadate(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getURL(),
            $keys[4] => $this->getCommentaire(),
            $keys[5] => $this->getCategorie_FK(),
            $keys[6] => $this->getSouscategorie_FK(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[1]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[1]];
            $result[$keys[1]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCategorie) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'categorie';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'categorie';
                        break;
                    default:
                        $key = 'Categorie';
                }

                $result[$key] = $this->aCategorie->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSouscategorie) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'souscategorie';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sous_categorie';
                        break;
                    default:
                        $key = 'Souscategorie';
                }

                $result[$key] = $this->aSouscategorie->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Media
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MediaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Media
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setMedianum($value);
                break;
            case 1:
                $this->setMediadate($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setURL($value);
                break;
            case 4:
                $this->setCommentaire($value);
                break;
            case 5:
                $this->setCategorie_FK($value);
                break;
            case 6:
                $this->setSouscategorie_FK($value);
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
        $keys = MediaTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setMedianum($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setMediadate($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescription($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setURL($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCommentaire($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCategorie_FK($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSouscategorie_FK($arr[$keys[6]]);
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
     * @return $this|\Media The current object, for fluid interface
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
        $criteria = new Criteria(MediaTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MediaTableMap::COL_MEDIA_NUM)) {
            $criteria->add(MediaTableMap::COL_MEDIA_NUM, $this->media_num);
        }
        if ($this->isColumnModified(MediaTableMap::COL_MEDIA_DATE)) {
            $criteria->add(MediaTableMap::COL_MEDIA_DATE, $this->media_date);
        }
        if ($this->isColumnModified(MediaTableMap::COL_DESCRIPTION)) {
            $criteria->add(MediaTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(MediaTableMap::COL_MEDIA_URL)) {
            $criteria->add(MediaTableMap::COL_MEDIA_URL, $this->media_url);
        }
        if ($this->isColumnModified(MediaTableMap::COL_COMMENTAIRE)) {
            $criteria->add(MediaTableMap::COL_COMMENTAIRE, $this->commentaire);
        }
        if ($this->isColumnModified(MediaTableMap::COL_CAT_FK)) {
            $criteria->add(MediaTableMap::COL_CAT_FK, $this->cat_fk);
        }
        if ($this->isColumnModified(MediaTableMap::COL_S_CAT_FK)) {
            $criteria->add(MediaTableMap::COL_S_CAT_FK, $this->s_cat_fk);
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
        $criteria = ChildMediaQuery::create();
        $criteria->add(MediaTableMap::COL_MEDIA_NUM, $this->media_num);

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
        $validPk = null !== $this->getMedianum();

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
        return $this->getMedianum();
    }

    /**
     * Generic method to set the primary key (media_num column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setMedianum($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getMedianum();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Media (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setMediadate($this->getMediadate());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setURL($this->getURL());
        $copyObj->setCommentaire($this->getCommentaire());
        $copyObj->setCategorie_FK($this->getCategorie_FK());
        $copyObj->setSouscategorie_FK($this->getSouscategorie_FK());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setMedianum(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Media Clone of current object.
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
     * Declares an association between this object and a ChildCategorie object.
     *
     * @param  ChildCategorie $v
     * @return $this|\Media The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCategorie(ChildCategorie $v = null)
    {
        if ($v === null) {
            $this->setCategorie_FK(NULL);
        } else {
            $this->setCategorie_FK($v->getCategorie());
        }

        $this->aCategorie = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCategorie object, it will not be re-added.
        if ($v !== null) {
            $v->addMedia($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCategorie object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCategorie The associated ChildCategorie object.
     * @throws PropelException
     */
    public function getCategorie(ConnectionInterface $con = null)
    {
        if ($this->aCategorie === null && (($this->cat_fk !== "" && $this->cat_fk !== null))) {
            $this->aCategorie = ChildCategorieQuery::create()
                ->filterByMedia($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCategorie->addMedias($this);
             */
        }

        return $this->aCategorie;
    }

    /**
     * Declares an association between this object and a ChildSouscategorie object.
     *
     * @param  ChildSouscategorie $v
     * @return $this|\Media The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSouscategorie(ChildSouscategorie $v = null)
    {
        if ($v === null) {
            $this->setSouscategorie_FK(NULL);
        } else {
            $this->setSouscategorie_FK($v->getSouscategorie());
        }

        $this->aSouscategorie = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSouscategorie object, it will not be re-added.
        if ($v !== null) {
            $v->addMedia($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSouscategorie object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSouscategorie The associated ChildSouscategorie object.
     * @throws PropelException
     */
    public function getSouscategorie(ConnectionInterface $con = null)
    {
        if ($this->aSouscategorie === null && (($this->s_cat_fk !== "" && $this->s_cat_fk !== null))) {
            $this->aSouscategorie = ChildSouscategorieQuery::create()
                ->filterByMedia($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSouscategorie->addMedias($this);
             */
        }

        return $this->aSouscategorie;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCategorie) {
            $this->aCategorie->removeMedia($this);
        }
        if (null !== $this->aSouscategorie) {
            $this->aSouscategorie->removeMedia($this);
        }
        $this->media_num = null;
        $this->media_date = null;
        $this->description = null;
        $this->media_url = null;
        $this->commentaire = null;
        $this->cat_fk = null;
        $this->s_cat_fk = null;
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

        $this->aCategorie = null;
        $this->aSouscategorie = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MediaTableMap::DEFAULT_STRING_FORMAT);
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
