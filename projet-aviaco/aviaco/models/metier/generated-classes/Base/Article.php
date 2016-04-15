<?php

namespace Base;

use \Article as ChildArticle;
use \ArticleQuery as ChildArticleQuery;
use \Categorie as ChildCategorie;
use \CategorieQuery as ChildCategorieQuery;
use \Employe as ChildEmploye;
use \EmployeQuery as ChildEmployeQuery;
use \Publication as ChildPublication;
use \PublicationQuery as ChildPublicationQuery;
use \Souscategorie as ChildSouscategorie;
use \SouscategorieQuery as ChildSouscategorieQuery;
use \Widget as ChildWidget;
use \WidgetQuery as ChildWidgetQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\ArticleTableMap;
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
 * Base class that represents a row from the 'article' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Article implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ArticleTableMap';


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
     * The value for the art_num field.
     * @var        int
     */
    protected $art_num;

    /**
     * The value for the titre field.
     * @var        string
     */
    protected $titre;

    /**
     * The value for the id_emp_fk field.
     * @var        string
     */
    protected $id_emp_fk;

    /**
     * The value for the date_edit field.
     * @var        \DateTime
     */
    protected $date_edit;

    /**
     * The value for the contenu field.
     * @var        string
     */
    protected $contenu;

    /**
     * The value for the resume field.
     * @var        string
     */
    protected $resume;

    /**
     * The value for the img_laune field.
     * @var        string
     */
    protected $img_laune;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * The value for the categorie_fk field.
     * @var        string
     */
    protected $categorie_fk;

    /**
     * The value for the sous_categorie_fk field.
     * @var        string
     */
    protected $sous_categorie_fk;

    /**
     * @var        ChildEmploye
     */
    protected $aEmploye;

    /**
     * @var        ChildCategorie
     */
    protected $aCategorie;

    /**
     * @var        ChildSouscategorie
     */
    protected $aSouscategorie;

    /**
     * @var        ObjectCollection|ChildPublication[] Collection to store aggregation of ChildPublication objects.
     */
    protected $collPublications;
    protected $collPublicationsPartial;

    /**
     * @var        ObjectCollection|ChildWidget[] Collection to store aggregation of ChildWidget objects.
     */
    protected $collWidgets;
    protected $collWidgetsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublication[]
     */
    protected $publicationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildWidget[]
     */
    protected $widgetsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Article object.
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
     * Compares this with another <code>Article</code> instance.  If
     * <code>obj</code> is an instance of <code>Article</code>, delegates to
     * <code>equals(Article)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Article The current object, for fluid interface
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
     * Get the [art_num] column value.
     *
     * @return int
     */
    public function getNumart()
    {
        return $this->art_num;
    }

    /**
     * Get the [titre] column value.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Get the [id_emp_fk] column value.
     *
     * @return string
     */
    public function getIdEmpFk()
    {
        return $this->id_emp_fk;
    }

    /**
     * Get the [optionally formatted] temporal [date_edit] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateEdit($format = NULL)
    {
        if ($format === null) {
            return $this->date_edit;
        } else {
            return $this->date_edit instanceof \DateTime ? $this->date_edit->format($format) : null;
        }
    }

    /**
     * Get the [contenu] column value.
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Get the [resume] column value.
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Get the [img_laune] column value.
     *
     * @return string
     */
    public function getImgLaune()
    {
        return $this->img_laune;
    }

    /**
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the [categorie_fk] column value.
     *
     * @return string
     */
    public function getCategorie_FK()
    {
        return $this->categorie_fk;
    }

    /**
     * Get the [sous_categorie_fk] column value.
     *
     * @return string
     */
    public function getSouscategorie_FK()
    {
        return $this->sous_categorie_fk;
    }

    /**
     * Set the value of [art_num] column.
     *
     * @param int $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setNumart($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->art_num !== $v) {
            $this->art_num = $v;
            $this->modifiedColumns[ArticleTableMap::COL_ART_NUM] = true;
        }

        return $this;
    } // setNumart()

    /**
     * Set the value of [titre] column.
     *
     * @param string $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setTitre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->titre !== $v) {
            $this->titre = $v;
            $this->modifiedColumns[ArticleTableMap::COL_TITRE] = true;
        }

        return $this;
    } // setTitre()

    /**
     * Set the value of [id_emp_fk] column.
     *
     * @param string $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setIdEmpFk($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id_emp_fk !== $v) {
            $this->id_emp_fk = $v;
            $this->modifiedColumns[ArticleTableMap::COL_ID_EMP_FK] = true;
        }

        if ($this->aEmploye !== null && $this->aEmploye->getIdEmploye() !== $v) {
            $this->aEmploye = null;
        }

        return $this;
    } // setIdEmpFk()

    /**
     * Sets the value of [date_edit] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setDateEdit($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_edit !== null || $dt !== null) {
            if ($this->date_edit === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->date_edit->format("Y-m-d H:i:s")) {
                $this->date_edit = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ArticleTableMap::COL_DATE_EDIT] = true;
            }
        } // if either are not null

        return $this;
    } // setDateEdit()

    /**
     * Set the value of [contenu] column.
     *
     * @param string $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setContenu($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->contenu !== $v) {
            $this->contenu = $v;
            $this->modifiedColumns[ArticleTableMap::COL_CONTENU] = true;
        }

        return $this;
    } // setContenu()

    /**
     * Set the value of [resume] column.
     *
     * @param string $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setResume($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->resume !== $v) {
            $this->resume = $v;
            $this->modifiedColumns[ArticleTableMap::COL_RESUME] = true;
        }

        return $this;
    } // setResume()

    /**
     * Set the value of [img_laune] column.
     *
     * @param string $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setImgLaune($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->img_laune !== $v) {
            $this->img_laune = $v;
            $this->modifiedColumns[ArticleTableMap::COL_IMG_LAUNE] = true;
        }

        return $this;
    } // setImgLaune()

    /**
     * Set the value of [url] column.
     *
     * @param string $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[ArticleTableMap::COL_URL] = true;
        }

        return $this;
    } // setUrl()

    /**
     * Set the value of [categorie_fk] column.
     *
     * @param string $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setCategorie_FK($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->categorie_fk !== $v) {
            $this->categorie_fk = $v;
            $this->modifiedColumns[ArticleTableMap::COL_CATEGORIE_FK] = true;
        }

        if ($this->aCategorie !== null && $this->aCategorie->getCategorie() !== $v) {
            $this->aCategorie = null;
        }

        return $this;
    } // setCategorie_FK()

    /**
     * Set the value of [sous_categorie_fk] column.
     *
     * @param string $v new value
     * @return $this|\Article The current object (for fluent API support)
     */
    public function setSouscategorie_FK($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sous_categorie_fk !== $v) {
            $this->sous_categorie_fk = $v;
            $this->modifiedColumns[ArticleTableMap::COL_SOUS_CATEGORIE_FK] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ArticleTableMap::translateFieldName('Numart', TableMap::TYPE_PHPNAME, $indexType)];
            $this->art_num = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ArticleTableMap::translateFieldName('Titre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->titre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ArticleTableMap::translateFieldName('IdEmpFk', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_emp_fk = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ArticleTableMap::translateFieldName('DateEdit', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->date_edit = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ArticleTableMap::translateFieldName('Contenu', TableMap::TYPE_PHPNAME, $indexType)];
            $this->contenu = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ArticleTableMap::translateFieldName('Resume', TableMap::TYPE_PHPNAME, $indexType)];
            $this->resume = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ArticleTableMap::translateFieldName('ImgLaune', TableMap::TYPE_PHPNAME, $indexType)];
            $this->img_laune = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ArticleTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ArticleTableMap::translateFieldName('Categorie_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->categorie_fk = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ArticleTableMap::translateFieldName('Souscategorie_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sous_categorie_fk = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ArticleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Article'), 0, $e);
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
        if ($this->aEmploye !== null && $this->id_emp_fk !== $this->aEmploye->getIdEmploye()) {
            $this->aEmploye = null;
        }
        if ($this->aCategorie !== null && $this->categorie_fk !== $this->aCategorie->getCategorie()) {
            $this->aCategorie = null;
        }
        if ($this->aSouscategorie !== null && $this->sous_categorie_fk !== $this->aSouscategorie->getSouscategorie()) {
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
            $con = Propel::getServiceContainer()->getReadConnection(ArticleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildArticleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEmploye = null;
            $this->aCategorie = null;
            $this->aSouscategorie = null;
            $this->collPublications = null;

            $this->collWidgets = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Article::setDeleted()
     * @see Article::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildArticleQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
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
                ArticleTableMap::addInstanceToPool($this);
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

            if ($this->aEmploye !== null) {
                if ($this->aEmploye->isModified() || $this->aEmploye->isNew()) {
                    $affectedRows += $this->aEmploye->save($con);
                }
                $this->setEmploye($this->aEmploye);
            }

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

            if ($this->publicationsScheduledForDeletion !== null) {
                if (!$this->publicationsScheduledForDeletion->isEmpty()) {
                    \PublicationQuery::create()
                        ->filterByPrimaryKeys($this->publicationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->publicationsScheduledForDeletion = null;
                }
            }

            if ($this->collPublications !== null) {
                foreach ($this->collPublications as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->widgetsScheduledForDeletion !== null) {
                if (!$this->widgetsScheduledForDeletion->isEmpty()) {
                    \WidgetQuery::create()
                        ->filterByPrimaryKeys($this->widgetsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->widgetsScheduledForDeletion = null;
                }
            }

            if ($this->collWidgets !== null) {
                foreach ($this->collWidgets as $referrerFK) {
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

        $this->modifiedColumns[ArticleTableMap::COL_ART_NUM] = true;
        if (null !== $this->art_num) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ArticleTableMap::COL_ART_NUM . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ArticleTableMap::COL_ART_NUM)) {
            $modifiedColumns[':p' . $index++]  = 'art_num';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_TITRE)) {
            $modifiedColumns[':p' . $index++]  = 'titre';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_ID_EMP_FK)) {
            $modifiedColumns[':p' . $index++]  = 'id_emp_FK';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_DATE_EDIT)) {
            $modifiedColumns[':p' . $index++]  = 'date_edit';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_CONTENU)) {
            $modifiedColumns[':p' . $index++]  = 'contenu';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_RESUME)) {
            $modifiedColumns[':p' . $index++]  = 'resume';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_IMG_LAUNE)) {
            $modifiedColumns[':p' . $index++]  = 'img_laune';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_CATEGORIE_FK)) {
            $modifiedColumns[':p' . $index++]  = 'categorie_FK';
        }
        if ($this->isColumnModified(ArticleTableMap::COL_SOUS_CATEGORIE_FK)) {
            $modifiedColumns[':p' . $index++]  = 'sous_categorie_FK';
        }

        $sql = sprintf(
            'INSERT INTO article (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'art_num':
                        $stmt->bindValue($identifier, $this->art_num, PDO::PARAM_INT);
                        break;
                    case 'titre':
                        $stmt->bindValue($identifier, $this->titre, PDO::PARAM_STR);
                        break;
                    case 'id_emp_FK':
                        $stmt->bindValue($identifier, $this->id_emp_fk, PDO::PARAM_STR);
                        break;
                    case 'date_edit':
                        $stmt->bindValue($identifier, $this->date_edit ? $this->date_edit->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'contenu':
                        $stmt->bindValue($identifier, $this->contenu, PDO::PARAM_STR);
                        break;
                    case 'resume':
                        $stmt->bindValue($identifier, $this->resume, PDO::PARAM_STR);
                        break;
                    case 'img_laune':
                        $stmt->bindValue($identifier, $this->img_laune, PDO::PARAM_STR);
                        break;
                    case 'url':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case 'categorie_FK':
                        $stmt->bindValue($identifier, $this->categorie_fk, PDO::PARAM_STR);
                        break;
                    case 'sous_categorie_FK':
                        $stmt->bindValue($identifier, $this->sous_categorie_fk, PDO::PARAM_STR);
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
        $this->setNumart($pk);

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
        $pos = ArticleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getNumart();
                break;
            case 1:
                return $this->getTitre();
                break;
            case 2:
                return $this->getIdEmpFk();
                break;
            case 3:
                return $this->getDateEdit();
                break;
            case 4:
                return $this->getContenu();
                break;
            case 5:
                return $this->getResume();
                break;
            case 6:
                return $this->getImgLaune();
                break;
            case 7:
                return $this->getUrl();
                break;
            case 8:
                return $this->getCategorie_FK();
                break;
            case 9:
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

        if (isset($alreadyDumpedObjects['Article'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Article'][$this->hashCode()] = true;
        $keys = ArticleTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getNumart(),
            $keys[1] => $this->getTitre(),
            $keys[2] => $this->getIdEmpFk(),
            $keys[3] => $this->getDateEdit(),
            $keys[4] => $this->getContenu(),
            $keys[5] => $this->getResume(),
            $keys[6] => $this->getImgLaune(),
            $keys[7] => $this->getUrl(),
            $keys[8] => $this->getCategorie_FK(),
            $keys[9] => $this->getSouscategorie_FK(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[3]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[3]];
            $result[$keys[3]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aEmploye) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'employe';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'employe';
                        break;
                    default:
                        $key = 'Employe';
                }

                $result[$key] = $this->aEmploye->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->collPublications) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'publications';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'publications';
                        break;
                    default:
                        $key = 'Publications';
                }

                $result[$key] = $this->collPublications->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collWidgets) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'widgets';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'widgets';
                        break;
                    default:
                        $key = 'Widgets';
                }

                $result[$key] = $this->collWidgets->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Article
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ArticleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Article
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setNumart($value);
                break;
            case 1:
                $this->setTitre($value);
                break;
            case 2:
                $this->setIdEmpFk($value);
                break;
            case 3:
                $this->setDateEdit($value);
                break;
            case 4:
                $this->setContenu($value);
                break;
            case 5:
                $this->setResume($value);
                break;
            case 6:
                $this->setImgLaune($value);
                break;
            case 7:
                $this->setUrl($value);
                break;
            case 8:
                $this->setCategorie_FK($value);
                break;
            case 9:
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
        $keys = ArticleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setNumart($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitre($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIdEmpFk($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDateEdit($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setContenu($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setResume($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setImgLaune($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setUrl($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCategorie_FK($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setSouscategorie_FK($arr[$keys[9]]);
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
     * @return $this|\Article The current object, for fluid interface
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
        $criteria = new Criteria(ArticleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ArticleTableMap::COL_ART_NUM)) {
            $criteria->add(ArticleTableMap::COL_ART_NUM, $this->art_num);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_TITRE)) {
            $criteria->add(ArticleTableMap::COL_TITRE, $this->titre);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_ID_EMP_FK)) {
            $criteria->add(ArticleTableMap::COL_ID_EMP_FK, $this->id_emp_fk);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_DATE_EDIT)) {
            $criteria->add(ArticleTableMap::COL_DATE_EDIT, $this->date_edit);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_CONTENU)) {
            $criteria->add(ArticleTableMap::COL_CONTENU, $this->contenu);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_RESUME)) {
            $criteria->add(ArticleTableMap::COL_RESUME, $this->resume);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_IMG_LAUNE)) {
            $criteria->add(ArticleTableMap::COL_IMG_LAUNE, $this->img_laune);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_URL)) {
            $criteria->add(ArticleTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_CATEGORIE_FK)) {
            $criteria->add(ArticleTableMap::COL_CATEGORIE_FK, $this->categorie_fk);
        }
        if ($this->isColumnModified(ArticleTableMap::COL_SOUS_CATEGORIE_FK)) {
            $criteria->add(ArticleTableMap::COL_SOUS_CATEGORIE_FK, $this->sous_categorie_fk);
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
        $criteria = ChildArticleQuery::create();
        $criteria->add(ArticleTableMap::COL_ART_NUM, $this->art_num);

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
        $validPk = null !== $this->getNumart();

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
        return $this->getNumart();
    }

    /**
     * Generic method to set the primary key (art_num column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setNumart($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getNumart();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Article (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitre($this->getTitre());
        $copyObj->setIdEmpFk($this->getIdEmpFk());
        $copyObj->setDateEdit($this->getDateEdit());
        $copyObj->setContenu($this->getContenu());
        $copyObj->setResume($this->getResume());
        $copyObj->setImgLaune($this->getImgLaune());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setCategorie_FK($this->getCategorie_FK());
        $copyObj->setSouscategorie_FK($this->getSouscategorie_FK());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPublications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublication($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getWidgets() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWidget($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setNumart(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Article Clone of current object.
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
     * Declares an association between this object and a ChildEmploye object.
     *
     * @param  ChildEmploye $v
     * @return $this|\Article The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEmploye(ChildEmploye $v = null)
    {
        if ($v === null) {
            $this->setIdEmpFk(NULL);
        } else {
            $this->setIdEmpFk($v->getIdEmploye());
        }

        $this->aEmploye = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEmploye object, it will not be re-added.
        if ($v !== null) {
            $v->addArticle($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEmploye object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEmploye The associated ChildEmploye object.
     * @throws PropelException
     */
    public function getEmploye(ConnectionInterface $con = null)
    {
        if ($this->aEmploye === null && (($this->id_emp_fk !== "" && $this->id_emp_fk !== null))) {
            $this->aEmploye = ChildEmployeQuery::create()->findPk($this->id_emp_fk, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEmploye->addArticles($this);
             */
        }

        return $this->aEmploye;
    }

    /**
     * Declares an association between this object and a ChildCategorie object.
     *
     * @param  ChildCategorie $v
     * @return $this|\Article The current object (for fluent API support)
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
            $v->addArticle($this);
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
        if ($this->aCategorie === null && (($this->categorie_fk !== "" && $this->categorie_fk !== null))) {
            $this->aCategorie = ChildCategorieQuery::create()
                ->filterByArticle($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCategorie->addArticles($this);
             */
        }

        return $this->aCategorie;
    }

    /**
     * Declares an association between this object and a ChildSouscategorie object.
     *
     * @param  ChildSouscategorie $v
     * @return $this|\Article The current object (for fluent API support)
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
            $v->addArticle($this);
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
        if ($this->aSouscategorie === null && (($this->sous_categorie_fk !== "" && $this->sous_categorie_fk !== null))) {
            $this->aSouscategorie = ChildSouscategorieQuery::create()
                ->filterByArticle($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSouscategorie->addArticles($this);
             */
        }

        return $this->aSouscategorie;
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
        if ('Publication' == $relationName) {
            return $this->initPublications();
        }
        if ('Widget' == $relationName) {
            return $this->initWidgets();
        }
    }

    /**
     * Clears out the collPublications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublications()
     */
    public function clearPublications()
    {
        $this->collPublications = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublications collection loaded partially.
     */
    public function resetPartialPublications($v = true)
    {
        $this->collPublicationsPartial = $v;
    }

    /**
     * Initializes the collPublications collection.
     *
     * By default this just sets the collPublications collection to an empty array (like clearcollPublications());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublications($overrideExisting = true)
    {
        if (null !== $this->collPublications && !$overrideExisting) {
            return;
        }
        $this->collPublications = new ObjectCollection();
        $this->collPublications->setModel('\Publication');
    }

    /**
     * Gets an array of ChildPublication objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildArticle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublication[] List of ChildPublication objects
     * @throws PropelException
     */
    public function getPublications(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationsPartial && !$this->isNew();
        if (null === $this->collPublications || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublications) {
                // return empty collection
                $this->initPublications();
            } else {
                $collPublications = ChildPublicationQuery::create(null, $criteria)
                    ->filterByArticle($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationsPartial && count($collPublications)) {
                        $this->initPublications(false);

                        foreach ($collPublications as $obj) {
                            if (false == $this->collPublications->contains($obj)) {
                                $this->collPublications->append($obj);
                            }
                        }

                        $this->collPublicationsPartial = true;
                    }

                    return $collPublications;
                }

                if ($partial && $this->collPublications) {
                    foreach ($this->collPublications as $obj) {
                        if ($obj->isNew()) {
                            $collPublications[] = $obj;
                        }
                    }
                }

                $this->collPublications = $collPublications;
                $this->collPublicationsPartial = false;
            }
        }

        return $this->collPublications;
    }

    /**
     * Sets a collection of ChildPublication objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publications A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildArticle The current object (for fluent API support)
     */
    public function setPublications(Collection $publications, ConnectionInterface $con = null)
    {
        /** @var ChildPublication[] $publicationsToDelete */
        $publicationsToDelete = $this->getPublications(new Criteria(), $con)->diff($publications);


        $this->publicationsScheduledForDeletion = $publicationsToDelete;

        foreach ($publicationsToDelete as $publicationRemoved) {
            $publicationRemoved->setArticle(null);
        }

        $this->collPublications = null;
        foreach ($publications as $publication) {
            $this->addPublication($publication);
        }

        $this->collPublications = $publications;
        $this->collPublicationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Publication objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Publication objects.
     * @throws PropelException
     */
    public function countPublications(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationsPartial && !$this->isNew();
        if (null === $this->collPublications || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublications) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublications());
            }

            $query = ChildPublicationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByArticle($this)
                ->count($con);
        }

        return count($this->collPublications);
    }

    /**
     * Method called to associate a ChildPublication object to this object
     * through the ChildPublication foreign key attribute.
     *
     * @param  ChildPublication $l ChildPublication
     * @return $this|\Article The current object (for fluent API support)
     */
    public function addPublication(ChildPublication $l)
    {
        if ($this->collPublications === null) {
            $this->initPublications();
            $this->collPublicationsPartial = true;
        }

        if (!$this->collPublications->contains($l)) {
            $this->doAddPublication($l);
        }

        return $this;
    }

    /**
     * @param ChildPublication $publication The ChildPublication object to add.
     */
    protected function doAddPublication(ChildPublication $publication)
    {
        $this->collPublications[]= $publication;
        $publication->setArticle($this);
    }

    /**
     * @param  ChildPublication $publication The ChildPublication object to remove.
     * @return $this|ChildArticle The current object (for fluent API support)
     */
    public function removePublication(ChildPublication $publication)
    {
        if ($this->getPublications()->contains($publication)) {
            $pos = $this->collPublications->search($publication);
            $this->collPublications->remove($pos);
            if (null === $this->publicationsScheduledForDeletion) {
                $this->publicationsScheduledForDeletion = clone $this->collPublications;
                $this->publicationsScheduledForDeletion->clear();
            }
            $this->publicationsScheduledForDeletion[]= $publication;
            $publication->setArticle(null);
        }

        return $this;
    }

    /**
     * Clears out the collWidgets collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addWidgets()
     */
    public function clearWidgets()
    {
        $this->collWidgets = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collWidgets collection loaded partially.
     */
    public function resetPartialWidgets($v = true)
    {
        $this->collWidgetsPartial = $v;
    }

    /**
     * Initializes the collWidgets collection.
     *
     * By default this just sets the collWidgets collection to an empty array (like clearcollWidgets());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWidgets($overrideExisting = true)
    {
        if (null !== $this->collWidgets && !$overrideExisting) {
            return;
        }
        $this->collWidgets = new ObjectCollection();
        $this->collWidgets->setModel('\Widget');
    }

    /**
     * Gets an array of ChildWidget objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildArticle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildWidget[] List of ChildWidget objects
     * @throws PropelException
     */
    public function getWidgets(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collWidgetsPartial && !$this->isNew();
        if (null === $this->collWidgets || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collWidgets) {
                // return empty collection
                $this->initWidgets();
            } else {
                $collWidgets = ChildWidgetQuery::create(null, $criteria)
                    ->filterByArticle($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collWidgetsPartial && count($collWidgets)) {
                        $this->initWidgets(false);

                        foreach ($collWidgets as $obj) {
                            if (false == $this->collWidgets->contains($obj)) {
                                $this->collWidgets->append($obj);
                            }
                        }

                        $this->collWidgetsPartial = true;
                    }

                    return $collWidgets;
                }

                if ($partial && $this->collWidgets) {
                    foreach ($this->collWidgets as $obj) {
                        if ($obj->isNew()) {
                            $collWidgets[] = $obj;
                        }
                    }
                }

                $this->collWidgets = $collWidgets;
                $this->collWidgetsPartial = false;
            }
        }

        return $this->collWidgets;
    }

    /**
     * Sets a collection of ChildWidget objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $widgets A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildArticle The current object (for fluent API support)
     */
    public function setWidgets(Collection $widgets, ConnectionInterface $con = null)
    {
        /** @var ChildWidget[] $widgetsToDelete */
        $widgetsToDelete = $this->getWidgets(new Criteria(), $con)->diff($widgets);


        $this->widgetsScheduledForDeletion = $widgetsToDelete;

        foreach ($widgetsToDelete as $widgetRemoved) {
            $widgetRemoved->setArticle(null);
        }

        $this->collWidgets = null;
        foreach ($widgets as $widget) {
            $this->addWidget($widget);
        }

        $this->collWidgets = $widgets;
        $this->collWidgetsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Widget objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Widget objects.
     * @throws PropelException
     */
    public function countWidgets(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collWidgetsPartial && !$this->isNew();
        if (null === $this->collWidgets || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWidgets) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWidgets());
            }

            $query = ChildWidgetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByArticle($this)
                ->count($con);
        }

        return count($this->collWidgets);
    }

    /**
     * Method called to associate a ChildWidget object to this object
     * through the ChildWidget foreign key attribute.
     *
     * @param  ChildWidget $l ChildWidget
     * @return $this|\Article The current object (for fluent API support)
     */
    public function addWidget(ChildWidget $l)
    {
        if ($this->collWidgets === null) {
            $this->initWidgets();
            $this->collWidgetsPartial = true;
        }

        if (!$this->collWidgets->contains($l)) {
            $this->doAddWidget($l);
        }

        return $this;
    }

    /**
     * @param ChildWidget $widget The ChildWidget object to add.
     */
    protected function doAddWidget(ChildWidget $widget)
    {
        $this->collWidgets[]= $widget;
        $widget->setArticle($this);
    }

    /**
     * @param  ChildWidget $widget The ChildWidget object to remove.
     * @return $this|ChildArticle The current object (for fluent API support)
     */
    public function removeWidget(ChildWidget $widget)
    {
        if ($this->getWidgets()->contains($widget)) {
            $pos = $this->collWidgets->search($widget);
            $this->collWidgets->remove($pos);
            if (null === $this->widgetsScheduledForDeletion) {
                $this->widgetsScheduledForDeletion = clone $this->collWidgets;
                $this->widgetsScheduledForDeletion->clear();
            }
            $this->widgetsScheduledForDeletion[]= $widget;
            $widget->setArticle(null);
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
        if (null !== $this->aEmploye) {
            $this->aEmploye->removeArticle($this);
        }
        if (null !== $this->aCategorie) {
            $this->aCategorie->removeArticle($this);
        }
        if (null !== $this->aSouscategorie) {
            $this->aSouscategorie->removeArticle($this);
        }
        $this->art_num = null;
        $this->titre = null;
        $this->id_emp_fk = null;
        $this->date_edit = null;
        $this->contenu = null;
        $this->resume = null;
        $this->img_laune = null;
        $this->url = null;
        $this->categorie_fk = null;
        $this->sous_categorie_fk = null;
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
            if ($this->collPublications) {
                foreach ($this->collPublications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collWidgets) {
                foreach ($this->collWidgets as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPublications = null;
        $this->collWidgets = null;
        $this->aEmploye = null;
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
        return (string) $this->exportTo(ArticleTableMap::DEFAULT_STRING_FORMAT);
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
