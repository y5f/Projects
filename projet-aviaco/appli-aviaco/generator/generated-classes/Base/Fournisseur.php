<?php

namespace Base;

use \COMVendeur as ChildCOMVendeur;
use \COMVendeurQuery as ChildCOMVendeurQuery;
use \Condition as ChildCondition;
use \ConditionQuery as ChildConditionQuery;
use \Document as ChildDocument;
use \DocumentQuery as ChildDocumentQuery;
use \Fournisseur as ChildFournisseur;
use \FournisseurQuery as ChildFournisseurQuery;
use \MTransport as ChildMTransport;
use \MTransportQuery as ChildMTransportQuery;
use \Photopiece as ChildPhotopiece;
use \PhotopieceQuery as ChildPhotopieceQuery;
use \Piece as ChildPiece;
use \PieceQuery as ChildPieceQuery;
use \Societe as ChildSociete;
use \SocieteQuery as ChildSocieteQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\FournisseurTableMap;
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
 * Base class that represents a row from the 'fournisseur' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Fournisseur implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\FournisseurTableMap';


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
     * @var        string
     */
    protected $prix_achat;

    /**
     * The value for the prix_vente field.
     * @var        string
     */
    protected $prix_vente;

    /**
     * The value for the date_enreg field.
     * @var        \DateTime
     */
    protected $date_enreg;

    /**
     * The value for the production field.
     * @var        boolean
     */
    protected $production;

    /**
     * The value for the delai field.
     * @var        string
     */
    protected $delai;

    /**
     * The value for the id_piece_fk field.
     * @var        int
     */
    protected $id_piece_fk;

    /**
     * The value for the condition_fk field.
     * @var        string
     */
    protected $condition_fk;

    /**
     * The value for the transport_fk field.
     * @var        string
     */
    protected $transport_fk;

    /**
     * The value for the soc_id_fk field.
     * @var        int
     */
    protected $soc_id_fk;

    /**
     * The value for the annee_fab field.
     * @var        string
     */
    protected $annee_fab;

    /**
     * The value for the tmp_rest field.
     * @var        string
     */
    protected $tmp_rest;

    /**
     * The value for the tmp_total field.
     * @var        string
     */
    protected $tmp_total;

    /**
     * The value for the duree_vie field.
     * @var        string
     */
    protected $duree_vie;

    /**
     * The value for the old_app field.
     * @var        string
     */
    protected $old_app;

    /**
     * The value for the new_app field.
     * @var        string
     */
    protected $new_app;

    /**
     * The value for the nbr_oh field.
     * @var        string
     */
    protected $nbr_oh;

    /**
     * The value for the note field.
     * @var        string
     */
    protected $note;

    /**
     * @var        ChildPiece
     */
    protected $aPiece;

    /**
     * @var        ChildSociete
     */
    protected $aSociete;

    /**
     * @var        ChildCondition
     */
    protected $aCondition;

    /**
     * @var        ChildMTransport
     */
    protected $aMTransport;

    /**
     * @var        ObjectCollection|ChildCOMVendeur[] Collection to store aggregation of ChildCOMVendeur objects.
     */
    protected $collCOMVendeurs;
    protected $collCOMVendeursPartial;

    /**
     * @var        ObjectCollection|ChildDocument[] Collection to store aggregation of ChildDocument objects.
     */
    protected $collDocs;
    protected $collDocsPartial;

    /**
     * @var        ObjectCollection|ChildPhotopiece[] Collection to store aggregation of ChildPhotopiece objects.
     */
    protected $collPhotopieces;
    protected $collPhotopiecesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCOMVendeur[]
     */
    protected $cOMVendeursScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDocument[]
     */
    protected $docsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPhotopiece[]
     */
    protected $photopiecesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Fournisseur object.
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
     * Compares this with another <code>Fournisseur</code> instance.  If
     * <code>obj</code> is an instance of <code>Fournisseur</code>, delegates to
     * <code>equals(Fournisseur)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Fournisseur The current object, for fluid interface
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
     * @return string
     */
    public function getPrixachat()
    {
        return $this->prix_achat;
    }

    /**
     * Get the [prix_vente] column value.
     *
     * @return string
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
    public function getDTESave($format = NULL)
    {
        if ($format === null) {
            return $this->date_enreg;
        } else {
            return $this->date_enreg instanceof \DateTime ? $this->date_enreg->format($format) : null;
        }
    }

    /**
     * Get the [production] column value.
     *
     * @return boolean
     */
    public function getisProd()
    {
        return $this->production;
    }

    /**
     * Get the [production] column value.
     *
     * @return boolean
     */
    public function isProd()
    {
        return $this->getisProd();
    }

    /**
     * Get the [delai] column value.
     *
     * @return string
     */
    public function getDelai()
    {
        return $this->delai;
    }

    /**
     * Get the [id_piece_fk] column value.
     *
     * @return int
     */
    public function getIDPiece_PK()
    {
        return $this->id_piece_fk;
    }

    /**
     * Get the [condition_fk] column value.
     *
     * @return string
     */
    public function getVCondition()
    {
        return $this->condition_fk;
    }

    /**
     * Get the [transport_fk] column value.
     *
     * @return string
     */
    public function getTMode()
    {
        return $this->transport_fk;
    }

    /**
     * Get the [soc_id_fk] column value.
     *
     * @return int
     */
    public function getIDSoc_FK()
    {
        return $this->soc_id_fk;
    }

    /**
     * Get the [annee_fab] column value.
     *
     * @return string
     */
    public function getFABAnnee()
    {
        return $this->annee_fab;
    }

    /**
     * Get the [tmp_rest] column value.
     *
     * @return string
     */
    public function getTRestant()
    {
        return $this->tmp_rest;
    }

    /**
     * Get the [tmp_total] column value.
     *
     * @return string
     */
    public function getTTotal()
    {
        return $this->tmp_total;
    }

    /**
     * Get the [duree_vie] column value.
     *
     * @return string
     */
    public function getDVie()
    {
        return $this->duree_vie;
    }

    /**
     * Get the [old_app] column value.
     *
     * @return string
     */
    public function getOLDApp()
    {
        return $this->old_app;
    }

    /**
     * Get the [new_app] column value.
     *
     * @return string
     */
    public function getNApp()
    {
        return $this->new_app;
    }

    /**
     * Get the [nbr_oh] column value.
     *
     * @return string
     */
    public function getNBROh()
    {
        return $this->nbr_oh;
    }

    /**
     * Get the [note] column value.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_ID] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [quantite] column.
     *
     * @param int $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setQuantite($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->quantite !== $v) {
            $this->quantite = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_QUANTITE] = true;
        }

        return $this;
    } // setQuantite()

    /**
     * Set the value of [prix_achat] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setPrixachat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->prix_achat !== $v) {
            $this->prix_achat = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_PRIX_ACHAT] = true;
        }

        return $this;
    } // setPrixachat()

    /**
     * Set the value of [prix_vente] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setPrixvente($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->prix_vente !== $v) {
            $this->prix_vente = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_PRIX_VENTE] = true;
        }

        return $this;
    } // setPrixvente()

    /**
     * Sets the value of [date_enreg] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setDTESave($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_enreg !== null || $dt !== null) {
            if ($this->date_enreg === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->date_enreg->format("Y-m-d H:i:s")) {
                $this->date_enreg = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FournisseurTableMap::COL_DATE_ENREG] = true;
            }
        } // if either are not null

        return $this;
    } // setDTESave()

    /**
     * Sets the value of the [production] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setisProd($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->production !== $v) {
            $this->production = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_PRODUCTION] = true;
        }

        return $this;
    } // setisProd()

    /**
     * Set the value of [delai] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setDelai($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->delai !== $v) {
            $this->delai = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_DELAI] = true;
        }

        return $this;
    } // setDelai()

    /**
     * Set the value of [id_piece_fk] column.
     *
     * @param int $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setIDPiece_PK($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_piece_fk !== $v) {
            $this->id_piece_fk = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_ID_PIECE_FK] = true;
        }

        if ($this->aPiece !== null && $this->aPiece->getID() !== $v) {
            $this->aPiece = null;
        }

        return $this;
    } // setIDPiece_PK()

    /**
     * Set the value of [condition_fk] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setVCondition($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->condition_fk !== $v) {
            $this->condition_fk = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_CONDITION_FK] = true;
        }

        if ($this->aCondition !== null && $this->aCondition->getCondition() !== $v) {
            $this->aCondition = null;
        }

        return $this;
    } // setVCondition()

    /**
     * Set the value of [transport_fk] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setTMode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->transport_fk !== $v) {
            $this->transport_fk = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_TRANSPORT_FK] = true;
        }

        if ($this->aMTransport !== null && $this->aMTransport->getMTransport() !== $v) {
            $this->aMTransport = null;
        }

        return $this;
    } // setTMode()

    /**
     * Set the value of [soc_id_fk] column.
     *
     * @param int $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setIDSoc_FK($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->soc_id_fk !== $v) {
            $this->soc_id_fk = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_SOC_ID_FK] = true;
        }

        if ($this->aSociete !== null && $this->aSociete->getID() !== $v) {
            $this->aSociete = null;
        }

        return $this;
    } // setIDSoc_FK()

    /**
     * Set the value of [annee_fab] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setFABAnnee($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->annee_fab !== $v) {
            $this->annee_fab = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_ANNEE_FAB] = true;
        }

        return $this;
    } // setFABAnnee()

    /**
     * Set the value of [tmp_rest] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setTRestant($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tmp_rest !== $v) {
            $this->tmp_rest = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_TMP_REST] = true;
        }

        return $this;
    } // setTRestant()

    /**
     * Set the value of [tmp_total] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setTTotal($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tmp_total !== $v) {
            $this->tmp_total = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_TMP_TOTAL] = true;
        }

        return $this;
    } // setTTotal()

    /**
     * Set the value of [duree_vie] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setDVie($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->duree_vie !== $v) {
            $this->duree_vie = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_DUREE_VIE] = true;
        }

        return $this;
    } // setDVie()

    /**
     * Set the value of [old_app] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setOLDApp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->old_app !== $v) {
            $this->old_app = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_OLD_APP] = true;
        }

        return $this;
    } // setOLDApp()

    /**
     * Set the value of [new_app] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setNApp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->new_app !== $v) {
            $this->new_app = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_NEW_APP] = true;
        }

        return $this;
    } // setNApp()

    /**
     * Set the value of [nbr_oh] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setNBROh($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nbr_oh !== $v) {
            $this->nbr_oh = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_NBR_OH] = true;
        }

        return $this;
    } // setNBROh()

    /**
     * Set the value of [note] column.
     *
     * @param string $v new value
     * @return $this|\Fournisseur The current object (for fluent API support)
     */
    public function setNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->note !== $v) {
            $this->note = $v;
            $this->modifiedColumns[FournisseurTableMap::COL_NOTE] = true;
        }

        return $this;
    } // setNote()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : FournisseurTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : FournisseurTableMap::translateFieldName('Quantite', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quantite = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : FournisseurTableMap::translateFieldName('Prixachat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prix_achat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : FournisseurTableMap::translateFieldName('Prixvente', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prix_vente = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : FournisseurTableMap::translateFieldName('DTESave', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->date_enreg = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : FournisseurTableMap::translateFieldName('isProd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->production = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : FournisseurTableMap::translateFieldName('Delai', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delai = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : FournisseurTableMap::translateFieldName('IDPiece_PK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_piece_fk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : FournisseurTableMap::translateFieldName('VCondition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->condition_fk = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : FournisseurTableMap::translateFieldName('TMode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->transport_fk = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : FournisseurTableMap::translateFieldName('IDSoc_FK', TableMap::TYPE_PHPNAME, $indexType)];
            $this->soc_id_fk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : FournisseurTableMap::translateFieldName('FABAnnee', TableMap::TYPE_PHPNAME, $indexType)];
            $this->annee_fab = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : FournisseurTableMap::translateFieldName('TRestant', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tmp_rest = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : FournisseurTableMap::translateFieldName('TTotal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tmp_total = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : FournisseurTableMap::translateFieldName('DVie', TableMap::TYPE_PHPNAME, $indexType)];
            $this->duree_vie = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : FournisseurTableMap::translateFieldName('OLDApp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->old_app = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : FournisseurTableMap::translateFieldName('NApp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->new_app = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : FournisseurTableMap::translateFieldName('NBROh', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nbr_oh = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : FournisseurTableMap::translateFieldName('Note', TableMap::TYPE_PHPNAME, $indexType)];
            $this->note = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 19; // 19 = FournisseurTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Fournisseur'), 0, $e);
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
        if ($this->aPiece !== null && $this->id_piece_fk !== $this->aPiece->getID()) {
            $this->aPiece = null;
        }
        if ($this->aCondition !== null && $this->condition_fk !== $this->aCondition->getCondition()) {
            $this->aCondition = null;
        }
        if ($this->aMTransport !== null && $this->transport_fk !== $this->aMTransport->getMTransport()) {
            $this->aMTransport = null;
        }
        if ($this->aSociete !== null && $this->soc_id_fk !== $this->aSociete->getID()) {
            $this->aSociete = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(FournisseurTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFournisseurQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPiece = null;
            $this->aSociete = null;
            $this->aCondition = null;
            $this->aMTransport = null;
            $this->collCOMVendeurs = null;

            $this->collDocs = null;

            $this->collPhotopieces = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Fournisseur::setDeleted()
     * @see Fournisseur::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FournisseurTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildFournisseurQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(FournisseurTableMap::DATABASE_NAME);
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
                FournisseurTableMap::addInstanceToPool($this);
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

            if ($this->aSociete !== null) {
                if ($this->aSociete->isModified() || $this->aSociete->isNew()) {
                    $affectedRows += $this->aSociete->save($con);
                }
                $this->setSociete($this->aSociete);
            }

            if ($this->aCondition !== null) {
                if ($this->aCondition->isModified() || $this->aCondition->isNew()) {
                    $affectedRows += $this->aCondition->save($con);
                }
                $this->setCondition($this->aCondition);
            }

            if ($this->aMTransport !== null) {
                if ($this->aMTransport->isModified() || $this->aMTransport->isNew()) {
                    $affectedRows += $this->aMTransport->save($con);
                }
                $this->setMTransport($this->aMTransport);
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

        $this->modifiedColumns[FournisseurTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FournisseurTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FournisseurTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_QUANTITE)) {
            $modifiedColumns[':p' . $index++]  = 'quantite';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_PRIX_ACHAT)) {
            $modifiedColumns[':p' . $index++]  = 'prix_achat';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_PRIX_VENTE)) {
            $modifiedColumns[':p' . $index++]  = 'prix_vente';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_DATE_ENREG)) {
            $modifiedColumns[':p' . $index++]  = 'date_enreg';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_PRODUCTION)) {
            $modifiedColumns[':p' . $index++]  = 'production';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_DELAI)) {
            $modifiedColumns[':p' . $index++]  = 'delai';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_ID_PIECE_FK)) {
            $modifiedColumns[':p' . $index++]  = 'id_piece_FK';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_CONDITION_FK)) {
            $modifiedColumns[':p' . $index++]  = 'condition_FK';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_TRANSPORT_FK)) {
            $modifiedColumns[':p' . $index++]  = 'transport_FK';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_SOC_ID_FK)) {
            $modifiedColumns[':p' . $index++]  = 'soc_id_FK';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_ANNEE_FAB)) {
            $modifiedColumns[':p' . $index++]  = 'annee_fab';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_TMP_REST)) {
            $modifiedColumns[':p' . $index++]  = 'tmp_rest';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_TMP_TOTAL)) {
            $modifiedColumns[':p' . $index++]  = 'tmp_total';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_DUREE_VIE)) {
            $modifiedColumns[':p' . $index++]  = 'duree_vie';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_OLD_APP)) {
            $modifiedColumns[':p' . $index++]  = 'old_app';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_NEW_APP)) {
            $modifiedColumns[':p' . $index++]  = 'new_app';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_NBR_OH)) {
            $modifiedColumns[':p' . $index++]  = 'nbr_oh';
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_NOTE)) {
            $modifiedColumns[':p' . $index++]  = 'note';
        }

        $sql = sprintf(
            'INSERT INTO fournisseur (%s) VALUES (%s)',
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
                    case 'production':
                        $stmt->bindValue($identifier, (int) $this->production, PDO::PARAM_INT);
                        break;
                    case 'delai':
                        $stmt->bindValue($identifier, $this->delai, PDO::PARAM_STR);
                        break;
                    case 'id_piece_FK':
                        $stmt->bindValue($identifier, $this->id_piece_fk, PDO::PARAM_INT);
                        break;
                    case 'condition_FK':
                        $stmt->bindValue($identifier, $this->condition_fk, PDO::PARAM_STR);
                        break;
                    case 'transport_FK':
                        $stmt->bindValue($identifier, $this->transport_fk, PDO::PARAM_STR);
                        break;
                    case 'soc_id_FK':
                        $stmt->bindValue($identifier, $this->soc_id_fk, PDO::PARAM_INT);
                        break;
                    case 'annee_fab':
                        $stmt->bindValue($identifier, $this->annee_fab, PDO::PARAM_STR);
                        break;
                    case 'tmp_rest':
                        $stmt->bindValue($identifier, $this->tmp_rest, PDO::PARAM_STR);
                        break;
                    case 'tmp_total':
                        $stmt->bindValue($identifier, $this->tmp_total, PDO::PARAM_STR);
                        break;
                    case 'duree_vie':
                        $stmt->bindValue($identifier, $this->duree_vie, PDO::PARAM_STR);
                        break;
                    case 'old_app':
                        $stmt->bindValue($identifier, $this->old_app, PDO::PARAM_STR);
                        break;
                    case 'new_app':
                        $stmt->bindValue($identifier, $this->new_app, PDO::PARAM_STR);
                        break;
                    case 'nbr_oh':
                        $stmt->bindValue($identifier, $this->nbr_oh, PDO::PARAM_STR);
                        break;
                    case 'note':
                        $stmt->bindValue($identifier, $this->note, PDO::PARAM_STR);
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
        $pos = FournisseurTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDTESave();
                break;
            case 5:
                return $this->getisProd();
                break;
            case 6:
                return $this->getDelai();
                break;
            case 7:
                return $this->getIDPiece_PK();
                break;
            case 8:
                return $this->getVCondition();
                break;
            case 9:
                return $this->getTMode();
                break;
            case 10:
                return $this->getIDSoc_FK();
                break;
            case 11:
                return $this->getFABAnnee();
                break;
            case 12:
                return $this->getTRestant();
                break;
            case 13:
                return $this->getTTotal();
                break;
            case 14:
                return $this->getDVie();
                break;
            case 15:
                return $this->getOLDApp();
                break;
            case 16:
                return $this->getNApp();
                break;
            case 17:
                return $this->getNBROh();
                break;
            case 18:
                return $this->getNote();
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

        if (isset($alreadyDumpedObjects['Fournisseur'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Fournisseur'][$this->hashCode()] = true;
        $keys = FournisseurTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getQuantite(),
            $keys[2] => $this->getPrixachat(),
            $keys[3] => $this->getPrixvente(),
            $keys[4] => $this->getDTESave(),
            $keys[5] => $this->getisProd(),
            $keys[6] => $this->getDelai(),
            $keys[7] => $this->getIDPiece_PK(),
            $keys[8] => $this->getVCondition(),
            $keys[9] => $this->getTMode(),
            $keys[10] => $this->getIDSoc_FK(),
            $keys[11] => $this->getFABAnnee(),
            $keys[12] => $this->getTRestant(),
            $keys[13] => $this->getTTotal(),
            $keys[14] => $this->getDVie(),
            $keys[15] => $this->getOLDApp(),
            $keys[16] => $this->getNApp(),
            $keys[17] => $this->getNBROh(),
            $keys[18] => $this->getNote(),
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
            if (null !== $this->aSociete) {

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

                $result[$key] = $this->aSociete->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCondition) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'condition';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'cond';
                        break;
                    default:
                        $key = 'Condition';
                }

                $result[$key] = $this->aCondition->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aMTransport) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mTransport';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'transport';
                        break;
                    default:
                        $key = 'MTransport';
                }

                $result[$key] = $this->aMTransport->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Fournisseur
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = FournisseurTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Fournisseur
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
                $this->setDTESave($value);
                break;
            case 5:
                $this->setisProd($value);
                break;
            case 6:
                $this->setDelai($value);
                break;
            case 7:
                $this->setIDPiece_PK($value);
                break;
            case 8:
                $this->setVCondition($value);
                break;
            case 9:
                $this->setTMode($value);
                break;
            case 10:
                $this->setIDSoc_FK($value);
                break;
            case 11:
                $this->setFABAnnee($value);
                break;
            case 12:
                $this->setTRestant($value);
                break;
            case 13:
                $this->setTTotal($value);
                break;
            case 14:
                $this->setDVie($value);
                break;
            case 15:
                $this->setOLDApp($value);
                break;
            case 16:
                $this->setNApp($value);
                break;
            case 17:
                $this->setNBROh($value);
                break;
            case 18:
                $this->setNote($value);
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
        $keys = FournisseurTableMap::getFieldNames($keyType);

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
            $this->setDTESave($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setisProd($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDelai($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setIDPiece_PK($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setVCondition($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setTMode($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setIDSoc_FK($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setFABAnnee($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setTRestant($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setTTotal($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setDVie($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setOLDApp($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setNApp($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setNBROh($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setNote($arr[$keys[18]]);
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
     * @return $this|\Fournisseur The current object, for fluid interface
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
        $criteria = new Criteria(FournisseurTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FournisseurTableMap::COL_ID)) {
            $criteria->add(FournisseurTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_QUANTITE)) {
            $criteria->add(FournisseurTableMap::COL_QUANTITE, $this->quantite);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_PRIX_ACHAT)) {
            $criteria->add(FournisseurTableMap::COL_PRIX_ACHAT, $this->prix_achat);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_PRIX_VENTE)) {
            $criteria->add(FournisseurTableMap::COL_PRIX_VENTE, $this->prix_vente);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_DATE_ENREG)) {
            $criteria->add(FournisseurTableMap::COL_DATE_ENREG, $this->date_enreg);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_PRODUCTION)) {
            $criteria->add(FournisseurTableMap::COL_PRODUCTION, $this->production);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_DELAI)) {
            $criteria->add(FournisseurTableMap::COL_DELAI, $this->delai);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_ID_PIECE_FK)) {
            $criteria->add(FournisseurTableMap::COL_ID_PIECE_FK, $this->id_piece_fk);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_CONDITION_FK)) {
            $criteria->add(FournisseurTableMap::COL_CONDITION_FK, $this->condition_fk);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_TRANSPORT_FK)) {
            $criteria->add(FournisseurTableMap::COL_TRANSPORT_FK, $this->transport_fk);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_SOC_ID_FK)) {
            $criteria->add(FournisseurTableMap::COL_SOC_ID_FK, $this->soc_id_fk);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_ANNEE_FAB)) {
            $criteria->add(FournisseurTableMap::COL_ANNEE_FAB, $this->annee_fab);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_TMP_REST)) {
            $criteria->add(FournisseurTableMap::COL_TMP_REST, $this->tmp_rest);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_TMP_TOTAL)) {
            $criteria->add(FournisseurTableMap::COL_TMP_TOTAL, $this->tmp_total);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_DUREE_VIE)) {
            $criteria->add(FournisseurTableMap::COL_DUREE_VIE, $this->duree_vie);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_OLD_APP)) {
            $criteria->add(FournisseurTableMap::COL_OLD_APP, $this->old_app);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_NEW_APP)) {
            $criteria->add(FournisseurTableMap::COL_NEW_APP, $this->new_app);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_NBR_OH)) {
            $criteria->add(FournisseurTableMap::COL_NBR_OH, $this->nbr_oh);
        }
        if ($this->isColumnModified(FournisseurTableMap::COL_NOTE)) {
            $criteria->add(FournisseurTableMap::COL_NOTE, $this->note);
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
        $criteria = ChildFournisseurQuery::create();
        $criteria->add(FournisseurTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Fournisseur (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setQuantite($this->getQuantite());
        $copyObj->setPrixachat($this->getPrixachat());
        $copyObj->setPrixvente($this->getPrixvente());
        $copyObj->setDTESave($this->getDTESave());
        $copyObj->setisProd($this->getisProd());
        $copyObj->setDelai($this->getDelai());
        $copyObj->setIDPiece_PK($this->getIDPiece_PK());
        $copyObj->setVCondition($this->getVCondition());
        $copyObj->setTMode($this->getTMode());
        $copyObj->setIDSoc_FK($this->getIDSoc_FK());
        $copyObj->setFABAnnee($this->getFABAnnee());
        $copyObj->setTRestant($this->getTRestant());
        $copyObj->setTTotal($this->getTTotal());
        $copyObj->setDVie($this->getDVie());
        $copyObj->setOLDApp($this->getOLDApp());
        $copyObj->setNApp($this->getNApp());
        $copyObj->setNBROh($this->getNBROh());
        $copyObj->setNote($this->getNote());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCOMVendeurs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCOMVendeur($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDocs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDoc($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPhotopieces() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPhotopiece($relObj->copy($deepCopy));
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
     * @return \Fournisseur Clone of current object.
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
     * @return $this|\Fournisseur The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPiece(ChildPiece $v = null)
    {
        if ($v === null) {
            $this->setIDPiece_PK(NULL);
        } else {
            $this->setIDPiece_PK($v->getID());
        }

        $this->aPiece = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPiece object, it will not be re-added.
        if ($v !== null) {
            $v->addFournisseur($this);
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
                $this->aPiece->addFournisseurs($this);
             */
        }

        return $this->aPiece;
    }

    /**
     * Declares an association between this object and a ChildSociete object.
     *
     * @param  ChildSociete $v
     * @return $this|\Fournisseur The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSociete(ChildSociete $v = null)
    {
        if ($v === null) {
            $this->setIDSoc_FK(NULL);
        } else {
            $this->setIDSoc_FK($v->getID());
        }

        $this->aSociete = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSociete object, it will not be re-added.
        if ($v !== null) {
            $v->addFournisseur($this);
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
    public function getSociete(ConnectionInterface $con = null)
    {
        if ($this->aSociete === null && ($this->soc_id_fk !== null)) {
            $this->aSociete = ChildSocieteQuery::create()->findPk($this->soc_id_fk, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSociete->addFournisseurs($this);
             */
        }

        return $this->aSociete;
    }

    /**
     * Declares an association between this object and a ChildCondition object.
     *
     * @param  ChildCondition $v
     * @return $this|\Fournisseur The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCondition(ChildCondition $v = null)
    {
        if ($v === null) {
            $this->setVCondition(NULL);
        } else {
            $this->setVCondition($v->getCondition());
        }

        $this->aCondition = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCondition object, it will not be re-added.
        if ($v !== null) {
            $v->addFournisseur($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCondition object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCondition The associated ChildCondition object.
     * @throws PropelException
     */
    public function getCondition(ConnectionInterface $con = null)
    {
        if ($this->aCondition === null && (($this->condition_fk !== "" && $this->condition_fk !== null))) {
            $this->aCondition = ChildConditionQuery::create()->findPk($this->condition_fk, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCondition->addFournisseurs($this);
             */
        }

        return $this->aCondition;
    }

    /**
     * Declares an association between this object and a ChildMTransport object.
     *
     * @param  ChildMTransport $v
     * @return $this|\Fournisseur The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMTransport(ChildMTransport $v = null)
    {
        if ($v === null) {
            $this->setTMode(NULL);
        } else {
            $this->setTMode($v->getMTransport());
        }

        $this->aMTransport = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMTransport object, it will not be re-added.
        if ($v !== null) {
            $v->addFournisseur($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMTransport object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildMTransport The associated ChildMTransport object.
     * @throws PropelException
     */
    public function getMTransport(ConnectionInterface $con = null)
    {
        if ($this->aMTransport === null && (($this->transport_fk !== "" && $this->transport_fk !== null))) {
            $this->aMTransport = ChildMTransportQuery::create()->findPk($this->transport_fk, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMTransport->addFournisseurs($this);
             */
        }

        return $this->aMTransport;
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
        if ('COMVendeur' == $relationName) {
            return $this->initCOMVendeurs();
        }
        if ('Doc' == $relationName) {
            return $this->initDocs();
        }
        if ('Photopiece' == $relationName) {
            return $this->initPhotopieces();
        }
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
     * If this ChildFournisseur is new, it will return
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
                    ->filterByFournisseur($this)
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
     * @return $this|ChildFournisseur The current object (for fluent API support)
     */
    public function setCOMVendeurs(Collection $cOMVendeurs, ConnectionInterface $con = null)
    {
        /** @var ChildCOMVendeur[] $cOMVendeursToDelete */
        $cOMVendeursToDelete = $this->getCOMVendeurs(new Criteria(), $con)->diff($cOMVendeurs);


        $this->cOMVendeursScheduledForDeletion = $cOMVendeursToDelete;

        foreach ($cOMVendeursToDelete as $cOMVendeurRemoved) {
            $cOMVendeurRemoved->setFournisseur(null);
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
                ->filterByFournisseur($this)
                ->count($con);
        }

        return count($this->collCOMVendeurs);
    }

    /**
     * Method called to associate a ChildCOMVendeur object to this object
     * through the ChildCOMVendeur foreign key attribute.
     *
     * @param  ChildCOMVendeur $l ChildCOMVendeur
     * @return $this|\Fournisseur The current object (for fluent API support)
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
        $cOMVendeur->setFournisseur($this);
    }

    /**
     * @param  ChildCOMVendeur $cOMVendeur The ChildCOMVendeur object to remove.
     * @return $this|ChildFournisseur The current object (for fluent API support)
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
            $cOMVendeur->setFournisseur(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Fournisseur is new, it will return
     * an empty collection; or if this Fournisseur has previously
     * been saved, it will retrieve related COMVendeurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Fournisseur.
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
     * Otherwise if this Fournisseur is new, it will return
     * an empty collection; or if this Fournisseur has previously
     * been saved, it will retrieve related COMVendeurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Fournisseur.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCOMVendeur[] List of ChildCOMVendeur objects
     */
    public function getCOMVendeursJoinPiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCOMVendeurQuery::create(null, $criteria);
        $query->joinWith('Piece', $joinBehavior);

        return $this->getCOMVendeurs($query, $con);
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
     * If this ChildFournisseur is new, it will return
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
                    ->filterByFournisseur($this)
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
     * @return $this|ChildFournisseur The current object (for fluent API support)
     */
    public function setDocs(Collection $docs, ConnectionInterface $con = null)
    {
        /** @var ChildDocument[] $docsToDelete */
        $docsToDelete = $this->getDocs(new Criteria(), $con)->diff($docs);


        $this->docsScheduledForDeletion = $docsToDelete;

        foreach ($docsToDelete as $docRemoved) {
            $docRemoved->setFournisseur(null);
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
                ->filterByFournisseur($this)
                ->count($con);
        }

        return count($this->collDocs);
    }

    /**
     * Method called to associate a ChildDocument object to this object
     * through the ChildDocument foreign key attribute.
     *
     * @param  ChildDocument $l ChildDocument
     * @return $this|\Fournisseur The current object (for fluent API support)
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
        $doc->setFournisseur($this);
    }

    /**
     * @param  ChildDocument $doc The ChildDocument object to remove.
     * @return $this|ChildFournisseur The current object (for fluent API support)
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
            $doc->setFournisseur(null);
        }

        return $this;
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
     * If this ChildFournisseur is new, it will return
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
                    ->filterByFournisseur($this)
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
     * @return $this|ChildFournisseur The current object (for fluent API support)
     */
    public function setPhotopieces(Collection $photopieces, ConnectionInterface $con = null)
    {
        /** @var ChildPhotopiece[] $photopiecesToDelete */
        $photopiecesToDelete = $this->getPhotopieces(new Criteria(), $con)->diff($photopieces);


        $this->photopiecesScheduledForDeletion = $photopiecesToDelete;

        foreach ($photopiecesToDelete as $photopieceRemoved) {
            $photopieceRemoved->setFournisseur(null);
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
                ->filterByFournisseur($this)
                ->count($con);
        }

        return count($this->collPhotopieces);
    }

    /**
     * Method called to associate a ChildPhotopiece object to this object
     * through the ChildPhotopiece foreign key attribute.
     *
     * @param  ChildPhotopiece $l ChildPhotopiece
     * @return $this|\Fournisseur The current object (for fluent API support)
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
        $photopiece->setFournisseur($this);
    }

    /**
     * @param  ChildPhotopiece $photopiece The ChildPhotopiece object to remove.
     * @return $this|ChildFournisseur The current object (for fluent API support)
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
            $photopiece->setFournisseur(null);
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
        if (null !== $this->aPiece) {
            $this->aPiece->removeFournisseur($this);
        }
        if (null !== $this->aSociete) {
            $this->aSociete->removeFournisseur($this);
        }
        if (null !== $this->aCondition) {
            $this->aCondition->removeFournisseur($this);
        }
        if (null !== $this->aMTransport) {
            $this->aMTransport->removeFournisseur($this);
        }
        $this->id = null;
        $this->quantite = null;
        $this->prix_achat = null;
        $this->prix_vente = null;
        $this->date_enreg = null;
        $this->production = null;
        $this->delai = null;
        $this->id_piece_fk = null;
        $this->condition_fk = null;
        $this->transport_fk = null;
        $this->soc_id_fk = null;
        $this->annee_fab = null;
        $this->tmp_rest = null;
        $this->tmp_total = null;
        $this->duree_vie = null;
        $this->old_app = null;
        $this->new_app = null;
        $this->nbr_oh = null;
        $this->note = null;
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
            if ($this->collCOMVendeurs) {
                foreach ($this->collCOMVendeurs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDocs) {
                foreach ($this->collDocs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPhotopieces) {
                foreach ($this->collPhotopieces as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCOMVendeurs = null;
        $this->collDocs = null;
        $this->collPhotopieces = null;
        $this->aPiece = null;
        $this->aSociete = null;
        $this->aCondition = null;
        $this->aMTransport = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FournisseurTableMap::DEFAULT_STRING_FORMAT);
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
