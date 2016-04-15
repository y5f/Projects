<?php

namespace Base;

use \Article as ChildArticle;
use \ArticleQuery as ChildArticleQuery;
use \Categorie as ChildCategorie;
use \CategorieQuery as ChildCategorieQuery;
use \Media as ChildMedia;
use \MediaQuery as ChildMediaQuery;
use \Souscategorie as ChildSouscategorie;
use \SouscategorieQuery as ChildSouscategorieQuery;
use \Exception;
use \PDO;
use Map\SouscategorieTableMap;
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
 * Base class that represents a row from the 'sous_categorie' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Souscategorie implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SouscategorieTableMap';


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
     * The value for the sous_categorie field.
     * @var        string
     */
    protected $sous_categorie;

    /**
     * The value for the id_categorie_fk field.
     * @var        int
     */
    protected $id_categorie_fk;

    /**
     * The value for the commentaire field.
     * @var        string
     */
    protected $commentaire;

    /**
     * The value for the ordre field.
     * @var        int
     */
    protected $ordre;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * @var        ChildCategorie
     */
    protected $aCategorie;

    /**
     * @var        ObjectCollection|ChildMedia[] Collection to store aggregation of ChildMedia objects.
     */
    protected $collMedias;
    protected $collMediasPartial;

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
     * @var ObjectCollection|ChildMedia[]
     */
    protected $mediasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildArticle[]
     */
    protected $articlesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Souscategorie object.
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
     * Compares this with another <code>Souscategorie</code> instance.  If
     * <code>obj</code> is an instance of <code>Souscategorie</code>, delegates to
     * <code>equals(Souscategorie)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Souscategorie The current object, for fluid interface
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
     * Get the [sous_categorie] column value.
     *
     * @return string
     */
    public function getSouscategorie()
    {
        return $this->sous_categorie;
    }

    /**
     * Get the [id_categorie_fk] column value.
     *
     * @return int
     */
    public function getIDCategorie_FK()
    {
        return $this->id_categorie_fk;
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
     * Get the [ordre] column value.
     *
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Get the [url] column value.
     *
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Souscategorie The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SouscategorieTableMap::COL_ID] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [sous_categorie] column.
     *
     * @param string $v new value
     * @return $this|\Souscategorie The current object (for fluent API support)
     */
    public function setSouscategorie($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sous_categorie !== $v) {
            $this->sous_categorie = $v;
            $this->modifiedColumns[SouscategorieTableMap::COL_SOUS_CATEGORIE] = true;
        }

        return $this;
    } // setSouscategorie()

    /**
     * Set the value of [id_categorie_fk] column.
     *
     * @param int $v new value
     * @return $this|\Souscategorie The current object (for fluent API support)
     */
    public function setIDCategorie_FK($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_categorie_fk !== $v) {
            $this->id_categorie_fk = $v;
            $this->modifiedColumns[SouscategorieTableMap::COL_ID_CATEGORIE_FK] = true;
        }

        if ($this->aCategorie !== null && $this->aCategorie->getID() !== $v) {
            $this->aCategorie = null;
        }

        return $this;
    } // setIDCategorie_FK()

    /**
     * Set the value of [commentaire] column.
     *
     * @param string $v new value
     * @return $this|\Souscategorie The current object (for fluent API support)
     */
    public function setCommentaire($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->commentaire !== $v) {
            $this->commentaire = $v;
            $this->modifiedColumns[SouscategorieTableMap::COL_COMMENTAIRE] = true;
        }

        return $this;
    } // setCommentaire()

    /**
     * Set the value of [ordre] column.
     *
     * @param int $v new value
     * @return $this|\Souscategorie The current object (for fluent API support)
     */
    public function setOrdre($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ordre !== $v) {
            $this->ordre = $v;
            $this->modifiedColumns[SouscategorieTableMap::COL_ORDRE] = true;
        }

        return $this;
    } // setOrdre()

    /**
     * Set the value of [url] column.
     *
     * @param string $v new value
     * @return $this|\Souscategorie The current object (for fluent API support)
     */
    public function setURL($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[SouscategorieTableMap::COL_URL] = true;
        }

        return $this;
    } // setURL()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SouscategorieTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SouscategorieTableMap::translateFieldName('Souscategorie', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sous_categorie = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SouscategorieTableMap::translateFieldName('IDCategorie_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_categorie_fk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SouscategorieTableMap::translateFieldName('Commentaire', TableMap::TYPE_PHPNAME, $indexType)];
            $this->commentaire = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SouscategorieTableMap::translateFieldName('Ordre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ordre = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SouscategorieTableMap::translateFieldName('URL', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = SouscategorieTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Souscategorie'), 0, $e);
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
        if ($this->aCategorie !== null && $this->id_categorie_fk !== $this->aCategorie->getID()) {
            $this->aCategorie = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SouscategorieTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSouscategorieQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCategorie = null;
            $this->collMedias = null;

            $this->collArticles = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Souscategorie::setDeleted()
     * @see Souscategorie::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SouscategorieTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSouscategorieQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SouscategorieTableMap::DATABASE_NAME);
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
                SouscategorieTableMap::addInstanceToPool($this);
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

            if ($this->mediasScheduledForDeletion !== null) {
                if (!$this->mediasScheduledForDeletion->isEmpty()) {
                    \MediaQuery::create()
                        ->filterByPrimaryKeys($this->mediasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mediasScheduledForDeletion = null;
                }
            }

            if ($this->collMedias !== null) {
                foreach ($this->collMedias as $referrerFK) {
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

        $this->modifiedColumns[SouscategorieTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SouscategorieTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SouscategorieTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_SOUS_CATEGORIE)) {
            $modifiedColumns[':p' . $index++]  = 'sous_categorie';
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_ID_CATEGORIE_FK)) {
            $modifiedColumns[':p' . $index++]  = 'id_categorie_FK';
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_COMMENTAIRE)) {
            $modifiedColumns[':p' . $index++]  = 'commentaire';
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_ORDRE)) {
            $modifiedColumns[':p' . $index++]  = 'ordre';
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }

        $sql = sprintf(
            'INSERT INTO sous_categorie (%s) VALUES (%s)',
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
                    case 'sous_categorie':
                        $stmt->bindValue($identifier, $this->sous_categorie, PDO::PARAM_STR);
                        break;
                    case 'id_categorie_FK':
                        $stmt->bindValue($identifier, $this->id_categorie_fk, PDO::PARAM_INT);
                        break;
                    case 'commentaire':
                        $stmt->bindValue($identifier, $this->commentaire, PDO::PARAM_STR);
                        break;
                    case 'ordre':
                        $stmt->bindValue($identifier, $this->ordre, PDO::PARAM_INT);
                        break;
                    case 'url':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
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
        $pos = SouscategorieTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSouscategorie();
                break;
            case 2:
                return $this->getIDCategorie_FK();
                break;
            case 3:
                return $this->getCommentaire();
                break;
            case 4:
                return $this->getOrdre();
                break;
            case 5:
                return $this->getURL();
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

        if (isset($alreadyDumpedObjects['Souscategorie'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Souscategorie'][$this->hashCode()] = true;
        $keys = SouscategorieTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getSouscategorie(),
            $keys[2] => $this->getIDCategorie_FK(),
            $keys[3] => $this->getCommentaire(),
            $keys[4] => $this->getOrdre(),
            $keys[5] => $this->getURL(),
        );
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
            if (null !== $this->collMedias) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'medias';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'medias';
                        break;
                    default:
                        $key = 'Medias';
                }

                $result[$key] = $this->collMedias->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Souscategorie
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SouscategorieTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Souscategorie
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setID($value);
                break;
            case 1:
                $this->setSouscategorie($value);
                break;
            case 2:
                $this->setIDCategorie_FK($value);
                break;
            case 3:
                $this->setCommentaire($value);
                break;
            case 4:
                $this->setOrdre($value);
                break;
            case 5:
                $this->setURL($value);
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
        $keys = SouscategorieTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSouscategorie($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIDCategorie_FK($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCommentaire($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setOrdre($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setURL($arr[$keys[5]]);
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
     * @return $this|\Souscategorie The current object, for fluid interface
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
        $criteria = new Criteria(SouscategorieTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SouscategorieTableMap::COL_ID)) {
            $criteria->add(SouscategorieTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_SOUS_CATEGORIE)) {
            $criteria->add(SouscategorieTableMap::COL_SOUS_CATEGORIE, $this->sous_categorie);
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_ID_CATEGORIE_FK)) {
            $criteria->add(SouscategorieTableMap::COL_ID_CATEGORIE_FK, $this->id_categorie_fk);
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_COMMENTAIRE)) {
            $criteria->add(SouscategorieTableMap::COL_COMMENTAIRE, $this->commentaire);
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_ORDRE)) {
            $criteria->add(SouscategorieTableMap::COL_ORDRE, $this->ordre);
        }
        if ($this->isColumnModified(SouscategorieTableMap::COL_URL)) {
            $criteria->add(SouscategorieTableMap::COL_URL, $this->url);
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
        $criteria = ChildSouscategorieQuery::create();
        $criteria->add(SouscategorieTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Souscategorie (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSouscategorie($this->getSouscategorie());
        $copyObj->setIDCategorie_FK($this->getIDCategorie_FK());
        $copyObj->setCommentaire($this->getCommentaire());
        $copyObj->setOrdre($this->getOrdre());
        $copyObj->setURL($this->getURL());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getMedias() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMedia($relObj->copy($deepCopy));
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
     * @return \Souscategorie Clone of current object.
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
     * @return $this|\Souscategorie The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCategorie(ChildCategorie $v = null)
    {
        if ($v === null) {
            $this->setIDCategorie_FK(NULL);
        } else {
            $this->setIDCategorie_FK($v->getID());
        }

        $this->aCategorie = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCategorie object, it will not be re-added.
        if ($v !== null) {
            $v->addSouscategorie($this);
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
        if ($this->aCategorie === null && ($this->id_categorie_fk !== null)) {
            $this->aCategorie = ChildCategorieQuery::create()->findPk($this->id_categorie_fk, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCategorie->addSouscategories($this);
             */
        }

        return $this->aCategorie;
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
        if ('Media' == $relationName) {
            return $this->initMedias();
        }
        if ('Article' == $relationName) {
            return $this->initArticles();
        }
    }

    /**
     * Clears out the collMedias collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMedias()
     */
    public function clearMedias()
    {
        $this->collMedias = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMedias collection loaded partially.
     */
    public function resetPartialMedias($v = true)
    {
        $this->collMediasPartial = $v;
    }

    /**
     * Initializes the collMedias collection.
     *
     * By default this just sets the collMedias collection to an empty array (like clearcollMedias());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMedias($overrideExisting = true)
    {
        if (null !== $this->collMedias && !$overrideExisting) {
            return;
        }
        $this->collMedias = new ObjectCollection();
        $this->collMedias->setModel('\Media');
    }

    /**
     * Gets an array of ChildMedia objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSouscategorie is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMedia[] List of ChildMedia objects
     * @throws PropelException
     */
    public function getMedias(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMediasPartial && !$this->isNew();
        if (null === $this->collMedias || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMedias) {
                // return empty collection
                $this->initMedias();
            } else {
                $collMedias = ChildMediaQuery::create(null, $criteria)
                    ->filterBySouscategorie($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMediasPartial && count($collMedias)) {
                        $this->initMedias(false);

                        foreach ($collMedias as $obj) {
                            if (false == $this->collMedias->contains($obj)) {
                                $this->collMedias->append($obj);
                            }
                        }

                        $this->collMediasPartial = true;
                    }

                    return $collMedias;
                }

                if ($partial && $this->collMedias) {
                    foreach ($this->collMedias as $obj) {
                        if ($obj->isNew()) {
                            $collMedias[] = $obj;
                        }
                    }
                }

                $this->collMedias = $collMedias;
                $this->collMediasPartial = false;
            }
        }

        return $this->collMedias;
    }

    /**
     * Sets a collection of ChildMedia objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $medias A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSouscategorie The current object (for fluent API support)
     */
    public function setMedias(Collection $medias, ConnectionInterface $con = null)
    {
        /** @var ChildMedia[] $mediasToDelete */
        $mediasToDelete = $this->getMedias(new Criteria(), $con)->diff($medias);


        $this->mediasScheduledForDeletion = $mediasToDelete;

        foreach ($mediasToDelete as $mediaRemoved) {
            $mediaRemoved->setSouscategorie(null);
        }

        $this->collMedias = null;
        foreach ($medias as $media) {
            $this->addMedia($media);
        }

        $this->collMedias = $medias;
        $this->collMediasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Media objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Media objects.
     * @throws PropelException
     */
    public function countMedias(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMediasPartial && !$this->isNew();
        if (null === $this->collMedias || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMedias) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMedias());
            }

            $query = ChildMediaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySouscategorie($this)
                ->count($con);
        }

        return count($this->collMedias);
    }

    /**
     * Method called to associate a ChildMedia object to this object
     * through the ChildMedia foreign key attribute.
     *
     * @param  ChildMedia $l ChildMedia
     * @return $this|\Souscategorie The current object (for fluent API support)
     */
    public function addMedia(ChildMedia $l)
    {
        if ($this->collMedias === null) {
            $this->initMedias();
            $this->collMediasPartial = true;
        }

        if (!$this->collMedias->contains($l)) {
            $this->doAddMedia($l);
        }

        return $this;
    }

    /**
     * @param ChildMedia $media The ChildMedia object to add.
     */
    protected function doAddMedia(ChildMedia $media)
    {
        $this->collMedias[]= $media;
        $media->setSouscategorie($this);
    }

    /**
     * @param  ChildMedia $media The ChildMedia object to remove.
     * @return $this|ChildSouscategorie The current object (for fluent API support)
     */
    public function removeMedia(ChildMedia $media)
    {
        if ($this->getMedias()->contains($media)) {
            $pos = $this->collMedias->search($media);
            $this->collMedias->remove($pos);
            if (null === $this->mediasScheduledForDeletion) {
                $this->mediasScheduledForDeletion = clone $this->collMedias;
                $this->mediasScheduledForDeletion->clear();
            }
            $this->mediasScheduledForDeletion[]= $media;
            $media->setSouscategorie(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Souscategorie is new, it will return
     * an empty collection; or if this Souscategorie has previously
     * been saved, it will retrieve related Medias from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Souscategorie.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMedia[] List of ChildMedia objects
     */
    public function getMediasJoinCategorie(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMediaQuery::create(null, $criteria);
        $query->joinWith('Categorie', $joinBehavior);

        return $this->getMedias($query, $con);
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
     * If this ChildSouscategorie is new, it will return
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
                    ->filterBySouscategorie($this)
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
     * @return $this|ChildSouscategorie The current object (for fluent API support)
     */
    public function setArticles(Collection $articles, ConnectionInterface $con = null)
    {
        /** @var ChildArticle[] $articlesToDelete */
        $articlesToDelete = $this->getArticles(new Criteria(), $con)->diff($articles);


        $this->articlesScheduledForDeletion = $articlesToDelete;

        foreach ($articlesToDelete as $articleRemoved) {
            $articleRemoved->setSouscategorie(null);
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
                ->filterBySouscategorie($this)
                ->count($con);
        }

        return count($this->collArticles);
    }

    /**
     * Method called to associate a ChildArticle object to this object
     * through the ChildArticle foreign key attribute.
     *
     * @param  ChildArticle $l ChildArticle
     * @return $this|\Souscategorie The current object (for fluent API support)
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
        $article->setSouscategorie($this);
    }

    /**
     * @param  ChildArticle $article The ChildArticle object to remove.
     * @return $this|ChildSouscategorie The current object (for fluent API support)
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
            $this->articlesScheduledForDeletion[]= clone $article;
            $article->setSouscategorie(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Souscategorie is new, it will return
     * an empty collection; or if this Souscategorie has previously
     * been saved, it will retrieve related Articles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Souscategorie.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildArticle[] List of ChildArticle objects
     */
    public function getArticlesJoinEmploye(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildArticleQuery::create(null, $criteria);
        $query->joinWith('Employe', $joinBehavior);

        return $this->getArticles($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Souscategorie is new, it will return
     * an empty collection; or if this Souscategorie has previously
     * been saved, it will retrieve related Articles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Souscategorie.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCategorie) {
            $this->aCategorie->removeSouscategorie($this);
        }
        $this->id = null;
        $this->sous_categorie = null;
        $this->id_categorie_fk = null;
        $this->commentaire = null;
        $this->ordre = null;
        $this->url = null;
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
            if ($this->collMedias) {
                foreach ($this->collMedias as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collArticles) {
                foreach ($this->collArticles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collMedias = null;
        $this->collArticles = null;
        $this->aCategorie = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SouscategorieTableMap::DEFAULT_STRING_FORMAT);
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
