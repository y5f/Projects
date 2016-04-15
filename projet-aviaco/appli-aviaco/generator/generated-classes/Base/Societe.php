<?php

namespace Base;

use \Chiffredaffaire as ChildChiffredaffaire;
use \ChiffredaffaireQuery as ChildChiffredaffaireQuery;
use \Commande as ChildCommande;
use \CommandeQuery as ChildCommandeQuery;
use \Contact as ChildContact;
use \ContactQuery as ChildContactQuery;
use \Financiere as ChildFinanciere;
use \FinanciereQuery as ChildFinanciereQuery;
use \Fournisseur as ChildFournisseur;
use \FournisseurQuery as ChildFournisseurQuery;
use \MPays as ChildMPays;
use \MPaysQuery as ChildMPaysQuery;
use \MROCentre as ChildMROCentre;
use \MROCentreQuery as ChildMROCentreQuery;
use \Marque as ChildMarque;
use \MarqueQuery as ChildMarqueQuery;
use \SPartenaire as ChildSPartenaire;
use \SPartenaireQuery as ChildSPartenaireQuery;
use \Societe as ChildSociete;
use \SocieteQuery as ChildSocieteQuery;
use \Societeappareil as ChildSocieteappareil;
use \SocieteappareilQuery as ChildSocieteappareilQuery;
use \Societecertificat as ChildSocietecertificat;
use \SocietecertificatQuery as ChildSocietecertificatQuery;
use \Societehistorique as ChildSocietehistorique;
use \SocietehistoriqueQuery as ChildSocietehistoriqueQuery;
use \Societemetier as ChildSocietemetier;
use \SocietemetierQuery as ChildSocietemetierQuery;
use \Societetypepiece as ChildSocietetypepiece;
use \SocietetypepieceQuery as ChildSocietetypepieceQuery;
use \Websource as ChildWebsource;
use \WebsourceQuery as ChildWebsourceQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\SocieteTableMap;
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
 * Base class that represents a row from the 'societe' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Societe implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SocieteTableMap';


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
     * The value for the soc_id field.
     * @var        int
     */
    protected $soc_id;

    /**
     * The value for the societe field.
     * @var        string
     */
    protected $societe;

    /**
     * The value for the dirigeant field.
     * @var        string
     */
    protected $dirigeant;

    /**
     * The value for the mail field.
     * @var        string
     */
    protected $mail;

    /**
     * The value for the website field.
     * @var        string
     */
    protected $website;

    /**
     * The value for the tel field.
     * @var        string
     */
    protected $tel;

    /**
     * The value for the fax field.
     * @var        string
     */
    protected $fax;

    /**
     * The value for the adresse field.
     * @var        string
     */
    protected $adresse;

    /**
     * The value for the cp field.
     * @var        string
     */
    protected $cp;

    /**
     * The value for the ville field.
     * @var        string
     */
    protected $ville;

    /**
     * The value for the pays field.
     * @var        string
     */
    protected $pays;

    /**
     * The value for the notes field.
     * @var        string
     */
    protected $notes;

    /**
     * The value for the notes_activite field.
     * @var        string
     */
    protected $notes_activite;

    /**
     * The value for the scrrib field.
     * @var        string
     */
    protected $scrrib;

    /**
     * The value for the fabricant field.
     * @var        string
     */
    protected $fabricant;

    /**
     * The value for the logo field.
     * @var        string
     */
    protected $logo;

    /**
     * The value for the fraude field.
     * @var        boolean
     */
    protected $fraude;

    /**
     * The value for the dte_maj_soc field.
     * @var        \DateTime
     */
    protected $dte_maj_soc;

    /**
     * The value for the dte_maj_act field.
     * @var        \DateTime
     */
    protected $dte_maj_act;

    /**
     * The value for the dte_maj_gen field.
     * @var        \DateTime
     */
    protected $dte_maj_gen;

    /**
     * The value for the actif field.
     * @var        boolean
     */
    protected $actif;

    /**
     * @var        ChildMPays
     */
    protected $aMPays;

    /**
     * @var        ChildMarque
     */
    protected $aMarque;

    /**
     * @var        ChildSPartenaire one-to-one related ChildSPartenaire object
     */
    protected $singleBFPartenaire;

    /**
     * @var        ObjectCollection|ChildSPartenaire[] Collection to store aggregation of ChildSPartenaire objects.
     */
    protected $collBPPartenaires;
    protected $collBPPartenairesPartial;

    /**
     * @var        ObjectCollection|ChildMROCentre[] Collection to store aggregation of ChildMROCentre objects.
     */
    protected $collMROCentres;
    protected $collMROCentresPartial;

    /**
     * @var        ObjectCollection|ChildMROCentre[] Collection to store aggregation of ChildMROCentre objects.
     */
    protected $collMROSocietes;
    protected $collMROSocietesPartial;

    /**
     * @var        ObjectCollection|ChildFournisseur[] Collection to store aggregation of ChildFournisseur objects.
     */
    protected $collFournisseurs;
    protected $collFournisseursPartial;

    /**
     * @var        ObjectCollection|ChildCommande[] Collection to store aggregation of ChildCommande objects.
     */
    protected $collCommandes;
    protected $collCommandesPartial;

    /**
     * @var        ObjectCollection|ChildSocieteappareil[] Collection to store aggregation of ChildSocieteappareil objects.
     */
    protected $collSocieteappareils;
    protected $collSocieteappareilsPartial;

    /**
     * @var        ObjectCollection|ChildContact[] Collection to store aggregation of ChildContact objects.
     */
    protected $collContacts;
    protected $collContactsPartial;

    /**
     * @var        ObjectCollection|ChildSocietecertificat[] Collection to store aggregation of ChildSocietecertificat objects.
     */
    protected $collSocietecertificats;
    protected $collSocietecertificatsPartial;

    /**
     * @var        ObjectCollection|ChildSocietemetier[] Collection to store aggregation of ChildSocietemetier objects.
     */
    protected $collSocietemetiers;
    protected $collSocietemetiersPartial;

    /**
     * @var        ObjectCollection|ChildSocietetypepiece[] Collection to store aggregation of ChildSocietetypepiece objects.
     */
    protected $collSocietetypepieces;
    protected $collSocietetypepiecesPartial;

    /**
     * @var        ObjectCollection|ChildSocietehistorique[] Collection to store aggregation of ChildSocietehistorique objects.
     */
    protected $collSocietehistoriques;
    protected $collSocietehistoriquesPartial;

    /**
     * @var        ObjectCollection|ChildFinanciere[] Collection to store aggregation of ChildFinanciere objects.
     */
    protected $collFinancieres;
    protected $collFinancieresPartial;

    /**
     * @var        ObjectCollection|ChildChiffredaffaire[] Collection to store aggregation of ChildChiffredaffaire objects.
     */
    protected $collChiffredaffaires;
    protected $collChiffredaffairesPartial;

    /**
     * @var        ObjectCollection|ChildWebsource[] Collection to store aggregation of ChildWebsource objects.
     */
    protected $collWebsources;
    protected $collWebsourcesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSPartenaire[]
     */
    protected $bPPartenairesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMROCentre[]
     */
    protected $mROCentresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMROCentre[]
     */
    protected $mROSocietesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFournisseur[]
     */
    protected $fournisseursScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCommande[]
     */
    protected $commandesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSocieteappareil[]
     */
    protected $societeappareilsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildContact[]
     */
    protected $contactsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSocietecertificat[]
     */
    protected $societecertificatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSocietemetier[]
     */
    protected $societemetiersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSocietetypepiece[]
     */
    protected $societetypepiecesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSocietehistorique[]
     */
    protected $societehistoriquesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFinanciere[]
     */
    protected $financieresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildChiffredaffaire[]
     */
    protected $chiffredaffairesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildWebsource[]
     */
    protected $websourcesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Societe object.
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
     * Compares this with another <code>Societe</code> instance.  If
     * <code>obj</code> is an instance of <code>Societe</code>, delegates to
     * <code>equals(Societe)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Societe The current object, for fluid interface
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
     * Get the [soc_id] column value.
     *
     * @return int
     */
    public function getID()
    {
        return $this->soc_id;
    }

    /**
     * Get the [societe] column value.
     *
     * @return string
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * Get the [dirigeant] column value.
     *
     * @return string
     */
    public function getDirigeant()
    {
        return $this->dirigeant;
    }

    /**
     * Get the [mail] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->mail;
    }

    /**
     * Get the [website] column value.
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Get the [tel] column value.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->tel;
    }

    /**
     * Get the [fax] column value.
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Get the [adresse] column value.
     *
     * @return string
     */
    public function getAdresses()
    {
        return $this->adresse;
    }

    /**
     * Get the [cp] column value.
     *
     * @return string
     */
    public function getCP()
    {
        return $this->cp;
    }

    /**
     * Get the [ville] column value.
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Get the [pays] column value.
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Get the [notes] column value.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Get the [notes_activite] column value.
     *
     * @return string
     */
    public function getNotesactivite()
    {
        return $this->notes_activite;
    }

    /**
     * Get the [scrrib] column value.
     *
     * @return string
     */
    public function getSourceRIB()
    {
        return $this->scrrib;
    }

    /**
     * Get the [fabricant] column value.
     *
     * @return string
     */
    public function getFabricant()
    {
        return $this->fabricant;
    }

    /**
     * Get the [logo] column value.
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Get the [fraude] column value.
     *
     * @return boolean
     */
    public function getisFraude()
    {
        return $this->fraude;
    }

    /**
     * Get the [fraude] column value.
     *
     * @return boolean
     */
    public function isFraude()
    {
        return $this->getisFraude();
    }

    /**
     * Get the [optionally formatted] temporal [dte_maj_soc] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateMAJSOC($format = NULL)
    {
        if ($format === null) {
            return $this->dte_maj_soc;
        } else {
            return $this->dte_maj_soc instanceof \DateTime ? $this->dte_maj_soc->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [dte_maj_act] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDte_MAJACT($format = NULL)
    {
        if ($format === null) {
            return $this->dte_maj_act;
        } else {
            return $this->dte_maj_act instanceof \DateTime ? $this->dte_maj_act->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [dte_maj_gen] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDte_MAJGEN($format = NULL)
    {
        if ($format === null) {
            return $this->dte_maj_gen;
        } else {
            return $this->dte_maj_gen instanceof \DateTime ? $this->dte_maj_gen->format($format) : null;
        }
    }

    /**
     * Get the [actif] column value.
     *
     * @return boolean
     */
    public function getisACTIF()
    {
        return $this->actif;
    }

    /**
     * Get the [actif] column value.
     *
     * @return boolean
     */
    public function isACTIF()
    {
        return $this->getisACTIF();
    }

    /**
     * Set the value of [soc_id] column.
     *
     * @param int $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setID($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->soc_id !== $v) {
            $this->soc_id = $v;
            $this->modifiedColumns[SocieteTableMap::COL_SOC_ID] = true;
        }

        return $this;
    } // setID()

    /**
     * Set the value of [societe] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setSociete($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->societe !== $v) {
            $this->societe = $v;
            $this->modifiedColumns[SocieteTableMap::COL_SOCIETE] = true;
        }

        return $this;
    } // setSociete()

    /**
     * Set the value of [dirigeant] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setDirigeant($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->dirigeant !== $v) {
            $this->dirigeant = $v;
            $this->modifiedColumns[SocieteTableMap::COL_DIRIGEANT] = true;
        }

        return $this;
    } // setDirigeant()

    /**
     * Set the value of [mail] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mail !== $v) {
            $this->mail = $v;
            $this->modifiedColumns[SocieteTableMap::COL_MAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [website] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setWebsite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->website !== $v) {
            $this->website = $v;
            $this->modifiedColumns[SocieteTableMap::COL_WEBSITE] = true;
        }

        return $this;
    } // setWebsite()

    /**
     * Set the value of [tel] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setTelephone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tel !== $v) {
            $this->tel = $v;
            $this->modifiedColumns[SocieteTableMap::COL_TEL] = true;
        }

        return $this;
    } // setTelephone()

    /**
     * Set the value of [fax] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setFax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fax !== $v) {
            $this->fax = $v;
            $this->modifiedColumns[SocieteTableMap::COL_FAX] = true;
        }

        return $this;
    } // setFax()

    /**
     * Set the value of [adresse] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setAdresses($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->adresse !== $v) {
            $this->adresse = $v;
            $this->modifiedColumns[SocieteTableMap::COL_ADRESSE] = true;
        }

        return $this;
    } // setAdresses()

    /**
     * Set the value of [cp] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setCP($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cp !== $v) {
            $this->cp = $v;
            $this->modifiedColumns[SocieteTableMap::COL_CP] = true;
        }

        return $this;
    } // setCP()

    /**
     * Set the value of [ville] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setVille($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ville !== $v) {
            $this->ville = $v;
            $this->modifiedColumns[SocieteTableMap::COL_VILLE] = true;
        }

        return $this;
    } // setVille()

    /**
     * Set the value of [pays] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setPays($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pays !== $v) {
            $this->pays = $v;
            $this->modifiedColumns[SocieteTableMap::COL_PAYS] = true;
        }

        if ($this->aMPays !== null && $this->aMPays->getPays() !== $v) {
            $this->aMPays = null;
        }

        return $this;
    } // setPays()

    /**
     * Set the value of [notes] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes !== $v) {
            $this->notes = $v;
            $this->modifiedColumns[SocieteTableMap::COL_NOTES] = true;
        }

        return $this;
    } // setNotes()

    /**
     * Set the value of [notes_activite] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setNotesactivite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes_activite !== $v) {
            $this->notes_activite = $v;
            $this->modifiedColumns[SocieteTableMap::COL_NOTES_ACTIVITE] = true;
        }

        return $this;
    } // setNotesactivite()

    /**
     * Set the value of [scrrib] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setSourceRIB($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->scrrib !== $v) {
            $this->scrrib = $v;
            $this->modifiedColumns[SocieteTableMap::COL_SCRRIB] = true;
        }

        return $this;
    } // setSourceRIB()

    /**
     * Set the value of [fabricant] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setFabricant($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fabricant !== $v) {
            $this->fabricant = $v;
            $this->modifiedColumns[SocieteTableMap::COL_FABRICANT] = true;
        }

        if ($this->aMarque !== null && $this->aMarque->getMarque() !== $v) {
            $this->aMarque = null;
        }

        return $this;
    } // setFabricant()

    /**
     * Set the value of [logo] column.
     *
     * @param string $v new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setLogo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->logo !== $v) {
            $this->logo = $v;
            $this->modifiedColumns[SocieteTableMap::COL_LOGO] = true;
        }

        return $this;
    } // setLogo()

    /**
     * Sets the value of the [fraude] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setisFraude($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->fraude !== $v) {
            $this->fraude = $v;
            $this->modifiedColumns[SocieteTableMap::COL_FRAUDE] = true;
        }

        return $this;
    } // setisFraude()

    /**
     * Sets the value of [dte_maj_soc] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setDateMAJSOC($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dte_maj_soc !== null || $dt !== null) {
            if ($this->dte_maj_soc === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->dte_maj_soc->format("Y-m-d H:i:s")) {
                $this->dte_maj_soc = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SocieteTableMap::COL_DTE_MAJ_SOC] = true;
            }
        } // if either are not null

        return $this;
    } // setDateMAJSOC()

    /**
     * Sets the value of [dte_maj_act] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setDte_MAJACT($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dte_maj_act !== null || $dt !== null) {
            if ($this->dte_maj_act === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->dte_maj_act->format("Y-m-d H:i:s")) {
                $this->dte_maj_act = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SocieteTableMap::COL_DTE_MAJ_ACT] = true;
            }
        } // if either are not null

        return $this;
    } // setDte_MAJACT()

    /**
     * Sets the value of [dte_maj_gen] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setDte_MAJGEN($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->dte_maj_gen !== null || $dt !== null) {
            if ($this->dte_maj_gen === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->dte_maj_gen->format("Y-m-d H:i:s")) {
                $this->dte_maj_gen = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SocieteTableMap::COL_DTE_MAJ_GEN] = true;
            }
        } // if either are not null

        return $this;
    } // setDte_MAJGEN()

    /**
     * Sets the value of the [actif] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function setisACTIF($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->actif !== $v) {
            $this->actif = $v;
            $this->modifiedColumns[SocieteTableMap::COL_ACTIF] = true;
        }

        return $this;
    } // setisACTIF()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SocieteTableMap::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
            $this->soc_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SocieteTableMap::translateFieldName('Societe', TableMap::TYPE_PHPNAME, $indexType)];
            $this->societe = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SocieteTableMap::translateFieldName('Dirigeant', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dirigeant = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SocieteTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mail = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SocieteTableMap::translateFieldName('Website', TableMap::TYPE_PHPNAME, $indexType)];
            $this->website = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SocieteTableMap::translateFieldName('Telephone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SocieteTableMap::translateFieldName('Fax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fax = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SocieteTableMap::translateFieldName('Adresses', TableMap::TYPE_PHPNAME, $indexType)];
            $this->adresse = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SocieteTableMap::translateFieldName('CP', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cp = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SocieteTableMap::translateFieldName('Ville', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ville = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SocieteTableMap::translateFieldName('Pays', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pays = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SocieteTableMap::translateFieldName('Notes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SocieteTableMap::translateFieldName('Notesactivite', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notes_activite = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SocieteTableMap::translateFieldName('SourceRIB', TableMap::TYPE_PHPNAME, $indexType)];
            $this->scrrib = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : SocieteTableMap::translateFieldName('Fabricant', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fabricant = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : SocieteTableMap::translateFieldName('Logo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->logo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : SocieteTableMap::translateFieldName('isFraude', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fraude = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : SocieteTableMap::translateFieldName('DateMAJSOC', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->dte_maj_soc = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : SocieteTableMap::translateFieldName('Dte_MAJACT', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->dte_maj_act = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : SocieteTableMap::translateFieldName('Dte_MAJGEN', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->dte_maj_gen = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : SocieteTableMap::translateFieldName('isACTIF', TableMap::TYPE_PHPNAME, $indexType)];
            $this->actif = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 21; // 21 = SocieteTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Societe'), 0, $e);
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
        if ($this->aMPays !== null && $this->pays !== $this->aMPays->getPays()) {
            $this->aMPays = null;
        }
        if ($this->aMarque !== null && $this->fabricant !== $this->aMarque->getMarque()) {
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
            $con = Propel::getServiceContainer()->getReadConnection(SocieteTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSocieteQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMPays = null;
            $this->aMarque = null;
            $this->singleBFPartenaire = null;

            $this->collBPPartenaires = null;

            $this->collMROCentres = null;

            $this->collMROSocietes = null;

            $this->collFournisseurs = null;

            $this->collCommandes = null;

            $this->collSocieteappareils = null;

            $this->collContacts = null;

            $this->collSocietecertificats = null;

            $this->collSocietemetiers = null;

            $this->collSocietetypepieces = null;

            $this->collSocietehistoriques = null;

            $this->collFinancieres = null;

            $this->collChiffredaffaires = null;

            $this->collWebsources = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Societe::setDeleted()
     * @see Societe::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SocieteTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSocieteQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SocieteTableMap::DATABASE_NAME);
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
                SocieteTableMap::addInstanceToPool($this);
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

            if ($this->aMPays !== null) {
                if ($this->aMPays->isModified() || $this->aMPays->isNew()) {
                    $affectedRows += $this->aMPays->save($con);
                }
                $this->setMPays($this->aMPays);
            }

            if ($this->aMarque !== null) {
                if ($this->aMarque->isModified() || $this->aMarque->isNew()) {
                    $affectedRows += $this->aMarque->save($con);
                }
                $this->setMarque($this->aMarque);
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

            if ($this->singleBFPartenaire !== null) {
                if (!$this->singleBFPartenaire->isDeleted() && ($this->singleBFPartenaire->isNew() || $this->singleBFPartenaire->isModified())) {
                    $affectedRows += $this->singleBFPartenaire->save($con);
                }
            }

            if ($this->bPPartenairesScheduledForDeletion !== null) {
                if (!$this->bPPartenairesScheduledForDeletion->isEmpty()) {
                    \SPartenaireQuery::create()
                        ->filterByPrimaryKeys($this->bPPartenairesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->bPPartenairesScheduledForDeletion = null;
                }
            }

            if ($this->collBPPartenaires !== null) {
                foreach ($this->collBPPartenaires as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mROCentresScheduledForDeletion !== null) {
                if (!$this->mROCentresScheduledForDeletion->isEmpty()) {
                    \MROCentreQuery::create()
                        ->filterByPrimaryKeys($this->mROCentresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mROCentresScheduledForDeletion = null;
                }
            }

            if ($this->collMROCentres !== null) {
                foreach ($this->collMROCentres as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->mROSocietesScheduledForDeletion !== null) {
                if (!$this->mROSocietesScheduledForDeletion->isEmpty()) {
                    \MROCentreQuery::create()
                        ->filterByPrimaryKeys($this->mROSocietesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->mROSocietesScheduledForDeletion = null;
                }
            }

            if ($this->collMROSocietes !== null) {
                foreach ($this->collMROSocietes as $referrerFK) {
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

            if ($this->commandesScheduledForDeletion !== null) {
                if (!$this->commandesScheduledForDeletion->isEmpty()) {
                    \CommandeQuery::create()
                        ->filterByPrimaryKeys($this->commandesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commandesScheduledForDeletion = null;
                }
            }

            if ($this->collCommandes !== null) {
                foreach ($this->collCommandes as $referrerFK) {
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

            if ($this->contactsScheduledForDeletion !== null) {
                if (!$this->contactsScheduledForDeletion->isEmpty()) {
                    \ContactQuery::create()
                        ->filterByPrimaryKeys($this->contactsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contactsScheduledForDeletion = null;
                }
            }

            if ($this->collContacts !== null) {
                foreach ($this->collContacts as $referrerFK) {
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

            if ($this->societemetiersScheduledForDeletion !== null) {
                if (!$this->societemetiersScheduledForDeletion->isEmpty()) {
                    \SocietemetierQuery::create()
                        ->filterByPrimaryKeys($this->societemetiersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->societemetiersScheduledForDeletion = null;
                }
            }

            if ($this->collSocietemetiers !== null) {
                foreach ($this->collSocietemetiers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->societetypepiecesScheduledForDeletion !== null) {
                if (!$this->societetypepiecesScheduledForDeletion->isEmpty()) {
                    \SocietetypepieceQuery::create()
                        ->filterByPrimaryKeys($this->societetypepiecesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->societetypepiecesScheduledForDeletion = null;
                }
            }

            if ($this->collSocietetypepieces !== null) {
                foreach ($this->collSocietetypepieces as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->societehistoriquesScheduledForDeletion !== null) {
                if (!$this->societehistoriquesScheduledForDeletion->isEmpty()) {
                    \SocietehistoriqueQuery::create()
                        ->filterByPrimaryKeys($this->societehistoriquesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->societehistoriquesScheduledForDeletion = null;
                }
            }

            if ($this->collSocietehistoriques !== null) {
                foreach ($this->collSocietehistoriques as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->financieresScheduledForDeletion !== null) {
                if (!$this->financieresScheduledForDeletion->isEmpty()) {
                    \FinanciereQuery::create()
                        ->filterByPrimaryKeys($this->financieresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->financieresScheduledForDeletion = null;
                }
            }

            if ($this->collFinancieres !== null) {
                foreach ($this->collFinancieres as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->chiffredaffairesScheduledForDeletion !== null) {
                if (!$this->chiffredaffairesScheduledForDeletion->isEmpty()) {
                    \ChiffredaffaireQuery::create()
                        ->filterByPrimaryKeys($this->chiffredaffairesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->chiffredaffairesScheduledForDeletion = null;
                }
            }

            if ($this->collChiffredaffaires !== null) {
                foreach ($this->collChiffredaffaires as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->websourcesScheduledForDeletion !== null) {
                if (!$this->websourcesScheduledForDeletion->isEmpty()) {
                    \WebsourceQuery::create()
                        ->filterByPrimaryKeys($this->websourcesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->websourcesScheduledForDeletion = null;
                }
            }

            if ($this->collWebsources !== null) {
                foreach ($this->collWebsources as $referrerFK) {
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

        $this->modifiedColumns[SocieteTableMap::COL_SOC_ID] = true;
        if (null !== $this->soc_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SocieteTableMap::COL_SOC_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SocieteTableMap::COL_SOC_ID)) {
            $modifiedColumns[':p' . $index++]  = 'soc_id';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_SOCIETE)) {
            $modifiedColumns[':p' . $index++]  = 'societe';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_DIRIGEANT)) {
            $modifiedColumns[':p' . $index++]  = 'dirigeant';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_MAIL)) {
            $modifiedColumns[':p' . $index++]  = 'mail';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_WEBSITE)) {
            $modifiedColumns[':p' . $index++]  = 'website';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_TEL)) {
            $modifiedColumns[':p' . $index++]  = 'tel';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_FAX)) {
            $modifiedColumns[':p' . $index++]  = 'fax';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_ADRESSE)) {
            $modifiedColumns[':p' . $index++]  = 'adresse';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_CP)) {
            $modifiedColumns[':p' . $index++]  = 'cp';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_VILLE)) {
            $modifiedColumns[':p' . $index++]  = 'ville';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_PAYS)) {
            $modifiedColumns[':p' . $index++]  = 'pays';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_NOTES)) {
            $modifiedColumns[':p' . $index++]  = 'notes';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_NOTES_ACTIVITE)) {
            $modifiedColumns[':p' . $index++]  = 'notes_activite';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_SCRRIB)) {
            $modifiedColumns[':p' . $index++]  = 'scrRIB';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_FABRICANT)) {
            $modifiedColumns[':p' . $index++]  = 'fabricant';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_LOGO)) {
            $modifiedColumns[':p' . $index++]  = 'logo';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_FRAUDE)) {
            $modifiedColumns[':p' . $index++]  = 'fraude';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_DTE_MAJ_SOC)) {
            $modifiedColumns[':p' . $index++]  = 'dte_maj_soc';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_DTE_MAJ_ACT)) {
            $modifiedColumns[':p' . $index++]  = 'dte_maj_act';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_DTE_MAJ_GEN)) {
            $modifiedColumns[':p' . $index++]  = 'dte_maj_gen';
        }
        if ($this->isColumnModified(SocieteTableMap::COL_ACTIF)) {
            $modifiedColumns[':p' . $index++]  = 'actif';
        }

        $sql = sprintf(
            'INSERT INTO societe (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'soc_id':
                        $stmt->bindValue($identifier, $this->soc_id, PDO::PARAM_INT);
                        break;
                    case 'societe':
                        $stmt->bindValue($identifier, $this->societe, PDO::PARAM_STR);
                        break;
                    case 'dirigeant':
                        $stmt->bindValue($identifier, $this->dirigeant, PDO::PARAM_STR);
                        break;
                    case 'mail':
                        $stmt->bindValue($identifier, $this->mail, PDO::PARAM_STR);
                        break;
                    case 'website':
                        $stmt->bindValue($identifier, $this->website, PDO::PARAM_STR);
                        break;
                    case 'tel':
                        $stmt->bindValue($identifier, $this->tel, PDO::PARAM_STR);
                        break;
                    case 'fax':
                        $stmt->bindValue($identifier, $this->fax, PDO::PARAM_STR);
                        break;
                    case 'adresse':
                        $stmt->bindValue($identifier, $this->adresse, PDO::PARAM_STR);
                        break;
                    case 'cp':
                        $stmt->bindValue($identifier, $this->cp, PDO::PARAM_STR);
                        break;
                    case 'ville':
                        $stmt->bindValue($identifier, $this->ville, PDO::PARAM_STR);
                        break;
                    case 'pays':
                        $stmt->bindValue($identifier, $this->pays, PDO::PARAM_STR);
                        break;
                    case 'notes':
                        $stmt->bindValue($identifier, $this->notes, PDO::PARAM_STR);
                        break;
                    case 'notes_activite':
                        $stmt->bindValue($identifier, $this->notes_activite, PDO::PARAM_STR);
                        break;
                    case 'scrRIB':
                        $stmt->bindValue($identifier, $this->scrrib, PDO::PARAM_STR);
                        break;
                    case 'fabricant':
                        $stmt->bindValue($identifier, $this->fabricant, PDO::PARAM_STR);
                        break;
                    case 'logo':
                        $stmt->bindValue($identifier, $this->logo, PDO::PARAM_STR);
                        break;
                    case 'fraude':
                        $stmt->bindValue($identifier, (int) $this->fraude, PDO::PARAM_INT);
                        break;
                    case 'dte_maj_soc':
                        $stmt->bindValue($identifier, $this->dte_maj_soc ? $this->dte_maj_soc->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'dte_maj_act':
                        $stmt->bindValue($identifier, $this->dte_maj_act ? $this->dte_maj_act->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'dte_maj_gen':
                        $stmt->bindValue($identifier, $this->dte_maj_gen ? $this->dte_maj_gen->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'actif':
                        $stmt->bindValue($identifier, (int) $this->actif, PDO::PARAM_INT);
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
        $pos = SocieteTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSociete();
                break;
            case 2:
                return $this->getDirigeant();
                break;
            case 3:
                return $this->getEmail();
                break;
            case 4:
                return $this->getWebsite();
                break;
            case 5:
                return $this->getTelephone();
                break;
            case 6:
                return $this->getFax();
                break;
            case 7:
                return $this->getAdresses();
                break;
            case 8:
                return $this->getCP();
                break;
            case 9:
                return $this->getVille();
                break;
            case 10:
                return $this->getPays();
                break;
            case 11:
                return $this->getNotes();
                break;
            case 12:
                return $this->getNotesactivite();
                break;
            case 13:
                return $this->getSourceRIB();
                break;
            case 14:
                return $this->getFabricant();
                break;
            case 15:
                return $this->getLogo();
                break;
            case 16:
                return $this->getisFraude();
                break;
            case 17:
                return $this->getDateMAJSOC();
                break;
            case 18:
                return $this->getDte_MAJACT();
                break;
            case 19:
                return $this->getDte_MAJGEN();
                break;
            case 20:
                return $this->getisACTIF();
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

        if (isset($alreadyDumpedObjects['Societe'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Societe'][$this->hashCode()] = true;
        $keys = SocieteTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getID(),
            $keys[1] => $this->getSociete(),
            $keys[2] => $this->getDirigeant(),
            $keys[3] => $this->getEmail(),
            $keys[4] => $this->getWebsite(),
            $keys[5] => $this->getTelephone(),
            $keys[6] => $this->getFax(),
            $keys[7] => $this->getAdresses(),
            $keys[8] => $this->getCP(),
            $keys[9] => $this->getVille(),
            $keys[10] => $this->getPays(),
            $keys[11] => $this->getNotes(),
            $keys[12] => $this->getNotesactivite(),
            $keys[13] => $this->getSourceRIB(),
            $keys[14] => $this->getFabricant(),
            $keys[15] => $this->getLogo(),
            $keys[16] => $this->getisFraude(),
            $keys[17] => $this->getDateMAJSOC(),
            $keys[18] => $this->getDte_MAJACT(),
            $keys[19] => $this->getDte_MAJGEN(),
            $keys[20] => $this->getisACTIF(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[17]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[17]];
            $result[$keys[17]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[18]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[18]];
            $result[$keys[18]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[19]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[19]];
            $result[$keys[19]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aMPays) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mPays';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pays';
                        break;
                    default:
                        $key = 'MPays';
                }

                $result[$key] = $this->aMPays->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->singleBFPartenaire) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sPartenaire';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'soc_part';
                        break;
                    default:
                        $key = 'SPartenaire';
                }

                $result[$key] = $this->singleBFPartenaire->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBPPartenaires) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sPartenaires';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'soc_parts';
                        break;
                    default:
                        $key = 'SPartenaires';
                }

                $result[$key] = $this->collBPPartenaires->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMROCentres) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mROCentres';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'centre_mros';
                        break;
                    default:
                        $key = 'MROCentres';
                }

                $result[$key] = $this->collMROCentres->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMROSocietes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mROCentres';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'centre_mros';
                        break;
                    default:
                        $key = 'MROCentres';
                }

                $result[$key] = $this->collMROSocietes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collCommandes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'commandes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'commandes';
                        break;
                    default:
                        $key = 'Commandes';
                }

                $result[$key] = $this->collCommandes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collContacts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contacts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'contacts';
                        break;
                    default:
                        $key = 'Contacts';
                }

                $result[$key] = $this->collContacts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collSocietemetiers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'societemetiers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'socmetiers';
                        break;
                    default:
                        $key = 'Societemetiers';
                }

                $result[$key] = $this->collSocietemetiers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSocietetypepieces) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'societetypepieces';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'soctypepieces';
                        break;
                    default:
                        $key = 'Societetypepieces';
                }

                $result[$key] = $this->collSocietetypepieces->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSocietehistoriques) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'societehistoriques';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sochistoriques';
                        break;
                    default:
                        $key = 'Societehistoriques';
                }

                $result[$key] = $this->collSocietehistoriques->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFinancieres) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'financieres';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'financieres';
                        break;
                    default:
                        $key = 'Financieres';
                }

                $result[$key] = $this->collFinancieres->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collChiffredaffaires) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'chiffredaffaires';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'chiffreaffaires';
                        break;
                    default:
                        $key = 'Chiffredaffaires';
                }

                $result[$key] = $this->collChiffredaffaires->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collWebsources) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'websources';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sourcewebs';
                        break;
                    default:
                        $key = 'Websources';
                }

                $result[$key] = $this->collWebsources->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Societe
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SocieteTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Societe
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setID($value);
                break;
            case 1:
                $this->setSociete($value);
                break;
            case 2:
                $this->setDirigeant($value);
                break;
            case 3:
                $this->setEmail($value);
                break;
            case 4:
                $this->setWebsite($value);
                break;
            case 5:
                $this->setTelephone($value);
                break;
            case 6:
                $this->setFax($value);
                break;
            case 7:
                $this->setAdresses($value);
                break;
            case 8:
                $this->setCP($value);
                break;
            case 9:
                $this->setVille($value);
                break;
            case 10:
                $this->setPays($value);
                break;
            case 11:
                $this->setNotes($value);
                break;
            case 12:
                $this->setNotesactivite($value);
                break;
            case 13:
                $this->setSourceRIB($value);
                break;
            case 14:
                $this->setFabricant($value);
                break;
            case 15:
                $this->setLogo($value);
                break;
            case 16:
                $this->setisFraude($value);
                break;
            case 17:
                $this->setDateMAJSOC($value);
                break;
            case 18:
                $this->setDte_MAJACT($value);
                break;
            case 19:
                $this->setDte_MAJGEN($value);
                break;
            case 20:
                $this->setisACTIF($value);
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
        $keys = SocieteTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setID($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSociete($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDirigeant($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmail($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setWebsite($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTelephone($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFax($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAdresses($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCP($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setVille($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setPays($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setNotes($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setNotesactivite($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setSourceRIB($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setFabricant($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setLogo($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setisFraude($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setDateMAJSOC($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setDte_MAJACT($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setDte_MAJGEN($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setisACTIF($arr[$keys[20]]);
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
     * @return $this|\Societe The current object, for fluid interface
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
        $criteria = new Criteria(SocieteTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SocieteTableMap::COL_SOC_ID)) {
            $criteria->add(SocieteTableMap::COL_SOC_ID, $this->soc_id);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_SOCIETE)) {
            $criteria->add(SocieteTableMap::COL_SOCIETE, $this->societe);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_DIRIGEANT)) {
            $criteria->add(SocieteTableMap::COL_DIRIGEANT, $this->dirigeant);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_MAIL)) {
            $criteria->add(SocieteTableMap::COL_MAIL, $this->mail);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_WEBSITE)) {
            $criteria->add(SocieteTableMap::COL_WEBSITE, $this->website);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_TEL)) {
            $criteria->add(SocieteTableMap::COL_TEL, $this->tel);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_FAX)) {
            $criteria->add(SocieteTableMap::COL_FAX, $this->fax);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_ADRESSE)) {
            $criteria->add(SocieteTableMap::COL_ADRESSE, $this->adresse);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_CP)) {
            $criteria->add(SocieteTableMap::COL_CP, $this->cp);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_VILLE)) {
            $criteria->add(SocieteTableMap::COL_VILLE, $this->ville);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_PAYS)) {
            $criteria->add(SocieteTableMap::COL_PAYS, $this->pays);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_NOTES)) {
            $criteria->add(SocieteTableMap::COL_NOTES, $this->notes);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_NOTES_ACTIVITE)) {
            $criteria->add(SocieteTableMap::COL_NOTES_ACTIVITE, $this->notes_activite);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_SCRRIB)) {
            $criteria->add(SocieteTableMap::COL_SCRRIB, $this->scrrib);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_FABRICANT)) {
            $criteria->add(SocieteTableMap::COL_FABRICANT, $this->fabricant);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_LOGO)) {
            $criteria->add(SocieteTableMap::COL_LOGO, $this->logo);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_FRAUDE)) {
            $criteria->add(SocieteTableMap::COL_FRAUDE, $this->fraude);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_DTE_MAJ_SOC)) {
            $criteria->add(SocieteTableMap::COL_DTE_MAJ_SOC, $this->dte_maj_soc);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_DTE_MAJ_ACT)) {
            $criteria->add(SocieteTableMap::COL_DTE_MAJ_ACT, $this->dte_maj_act);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_DTE_MAJ_GEN)) {
            $criteria->add(SocieteTableMap::COL_DTE_MAJ_GEN, $this->dte_maj_gen);
        }
        if ($this->isColumnModified(SocieteTableMap::COL_ACTIF)) {
            $criteria->add(SocieteTableMap::COL_ACTIF, $this->actif);
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
        $criteria = ChildSocieteQuery::create();
        $criteria->add(SocieteTableMap::COL_SOC_ID, $this->soc_id);

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
     * Generic method to set the primary key (soc_id column).
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
     * @param      object $copyObj An object of \Societe (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSociete($this->getSociete());
        $copyObj->setDirigeant($this->getDirigeant());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setWebsite($this->getWebsite());
        $copyObj->setTelephone($this->getTelephone());
        $copyObj->setFax($this->getFax());
        $copyObj->setAdresses($this->getAdresses());
        $copyObj->setCP($this->getCP());
        $copyObj->setVille($this->getVille());
        $copyObj->setPays($this->getPays());
        $copyObj->setNotes($this->getNotes());
        $copyObj->setNotesactivite($this->getNotesactivite());
        $copyObj->setSourceRIB($this->getSourceRIB());
        $copyObj->setFabricant($this->getFabricant());
        $copyObj->setLogo($this->getLogo());
        $copyObj->setisFraude($this->getisFraude());
        $copyObj->setDateMAJSOC($this->getDateMAJSOC());
        $copyObj->setDte_MAJACT($this->getDte_MAJACT());
        $copyObj->setDte_MAJGEN($this->getDte_MAJGEN());
        $copyObj->setisACTIF($this->getisACTIF());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            $relObj = $this->getBFPartenaire();
            if ($relObj) {
                $copyObj->setBFPartenaire($relObj->copy($deepCopy));
            }

            foreach ($this->getBPPartenaires() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBPPartenaire($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMROCentres() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMROCentre($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMROSocietes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMROSociete($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFournisseurs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFournisseur($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCommandes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCommande($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSocieteappareils() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSocieteappareil($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContacts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContact($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSocietecertificats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSocietecertificat($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSocietemetiers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSocietemetier($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSocietetypepieces() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSocietetypepiece($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSocietehistoriques() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSocietehistorique($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFinancieres() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFinanciere($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getChiffredaffaires() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addChiffredaffaire($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getWebsources() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWebsource($relObj->copy($deepCopy));
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
     * @return \Societe Clone of current object.
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
     * Declares an association between this object and a ChildMPays object.
     *
     * @param  ChildMPays $v
     * @return $this|\Societe The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMPays(ChildMPays $v = null)
    {
        if ($v === null) {
            $this->setPays(NULL);
        } else {
            $this->setPays($v->getPays());
        }

        $this->aMPays = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMPays object, it will not be re-added.
        if ($v !== null) {
            $v->addSociete($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMPays object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildMPays The associated ChildMPays object.
     * @throws PropelException
     */
    public function getMPays(ConnectionInterface $con = null)
    {
        if ($this->aMPays === null && (($this->pays !== "" && $this->pays !== null))) {
            $this->aMPays = ChildMPaysQuery::create()
                ->filterBySociete($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMPays->addSocietes($this);
             */
        }

        return $this->aMPays;
    }

    /**
     * Declares an association between this object and a ChildMarque object.
     *
     * @param  ChildMarque $v
     * @return $this|\Societe The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMarque(ChildMarque $v = null)
    {
        if ($v === null) {
            $this->setFabricant(NULL);
        } else {
            $this->setFabricant($v->getMarque());
        }

        $this->aMarque = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMarque object, it will not be re-added.
        if ($v !== null) {
            $v->addSociete($this);
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
        if ($this->aMarque === null && (($this->fabricant !== "" && $this->fabricant !== null))) {
            $this->aMarque = ChildMarqueQuery::create()
                ->filterBySociete($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMarque->addSocietes($this);
             */
        }

        return $this->aMarque;
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
        if ('BPPartenaire' == $relationName) {
            return $this->initBPPartenaires();
        }
        if ('MROCentre' == $relationName) {
            return $this->initMROCentres();
        }
        if ('MROSociete' == $relationName) {
            return $this->initMROSocietes();
        }
        if ('Fournisseur' == $relationName) {
            return $this->initFournisseurs();
        }
        if ('Commande' == $relationName) {
            return $this->initCommandes();
        }
        if ('Societeappareil' == $relationName) {
            return $this->initSocieteappareils();
        }
        if ('Contact' == $relationName) {
            return $this->initContacts();
        }
        if ('Societecertificat' == $relationName) {
            return $this->initSocietecertificats();
        }
        if ('Societemetier' == $relationName) {
            return $this->initSocietemetiers();
        }
        if ('Societetypepiece' == $relationName) {
            return $this->initSocietetypepieces();
        }
        if ('Societehistorique' == $relationName) {
            return $this->initSocietehistoriques();
        }
        if ('Financiere' == $relationName) {
            return $this->initFinancieres();
        }
        if ('Chiffredaffaire' == $relationName) {
            return $this->initChiffredaffaires();
        }
        if ('Websource' == $relationName) {
            return $this->initWebsources();
        }
    }

    /**
     * Gets a single ChildSPartenaire object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildSPartenaire
     * @throws PropelException
     */
    public function getBFPartenaire(ConnectionInterface $con = null)
    {

        if ($this->singleBFPartenaire === null && !$this->isNew()) {
            $this->singleBFPartenaire = ChildSPartenaireQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleBFPartenaire;
    }

    /**
     * Sets a single ChildSPartenaire object as related to this object by a one-to-one relationship.
     *
     * @param  ChildSPartenaire $v ChildSPartenaire
     * @return $this|\Societe The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBFPartenaire(ChildSPartenaire $v = null)
    {
        $this->singleBFPartenaire = $v;

        // Make sure that that the passed-in ChildSPartenaire isn't already associated with this object
        if ($v !== null && $v->getSocFraude(null, false) === null) {
            $v->setSocFraude($this);
        }

        return $this;
    }

    /**
     * Clears out the collBPPartenaires collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBPPartenaires()
     */
    public function clearBPPartenaires()
    {
        $this->collBPPartenaires = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBPPartenaires collection loaded partially.
     */
    public function resetPartialBPPartenaires($v = true)
    {
        $this->collBPPartenairesPartial = $v;
    }

    /**
     * Initializes the collBPPartenaires collection.
     *
     * By default this just sets the collBPPartenaires collection to an empty array (like clearcollBPPartenaires());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBPPartenaires($overrideExisting = true)
    {
        if (null !== $this->collBPPartenaires && !$overrideExisting) {
            return;
        }
        $this->collBPPartenaires = new ObjectCollection();
        $this->collBPPartenaires->setModel('\SPartenaire');
    }

    /**
     * Gets an array of ChildSPartenaire objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSPartenaire[] List of ChildSPartenaire objects
     * @throws PropelException
     */
    public function getBPPartenaires(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBPPartenairesPartial && !$this->isNew();
        if (null === $this->collBPPartenaires || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBPPartenaires) {
                // return empty collection
                $this->initBPPartenaires();
            } else {
                $collBPPartenaires = ChildSPartenaireQuery::create(null, $criteria)
                    ->filterBySocPlaignant($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBPPartenairesPartial && count($collBPPartenaires)) {
                        $this->initBPPartenaires(false);

                        foreach ($collBPPartenaires as $obj) {
                            if (false == $this->collBPPartenaires->contains($obj)) {
                                $this->collBPPartenaires->append($obj);
                            }
                        }

                        $this->collBPPartenairesPartial = true;
                    }

                    return $collBPPartenaires;
                }

                if ($partial && $this->collBPPartenaires) {
                    foreach ($this->collBPPartenaires as $obj) {
                        if ($obj->isNew()) {
                            $collBPPartenaires[] = $obj;
                        }
                    }
                }

                $this->collBPPartenaires = $collBPPartenaires;
                $this->collBPPartenairesPartial = false;
            }
        }

        return $this->collBPPartenaires;
    }

    /**
     * Sets a collection of ChildSPartenaire objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bPPartenaires A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setBPPartenaires(Collection $bPPartenaires, ConnectionInterface $con = null)
    {
        /** @var ChildSPartenaire[] $bPPartenairesToDelete */
        $bPPartenairesToDelete = $this->getBPPartenaires(new Criteria(), $con)->diff($bPPartenaires);


        $this->bPPartenairesScheduledForDeletion = $bPPartenairesToDelete;

        foreach ($bPPartenairesToDelete as $bPPartenaireRemoved) {
            $bPPartenaireRemoved->setSocPlaignant(null);
        }

        $this->collBPPartenaires = null;
        foreach ($bPPartenaires as $bPPartenaire) {
            $this->addBPPartenaire($bPPartenaire);
        }

        $this->collBPPartenaires = $bPPartenaires;
        $this->collBPPartenairesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SPartenaire objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SPartenaire objects.
     * @throws PropelException
     */
    public function countBPPartenaires(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBPPartenairesPartial && !$this->isNew();
        if (null === $this->collBPPartenaires || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBPPartenaires) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBPPartenaires());
            }

            $query = ChildSPartenaireQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySocPlaignant($this)
                ->count($con);
        }

        return count($this->collBPPartenaires);
    }

    /**
     * Method called to associate a ChildSPartenaire object to this object
     * through the ChildSPartenaire foreign key attribute.
     *
     * @param  ChildSPartenaire $l ChildSPartenaire
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addBPPartenaire(ChildSPartenaire $l)
    {
        if ($this->collBPPartenaires === null) {
            $this->initBPPartenaires();
            $this->collBPPartenairesPartial = true;
        }

        if (!$this->collBPPartenaires->contains($l)) {
            $this->doAddBPPartenaire($l);
        }

        return $this;
    }

    /**
     * @param ChildSPartenaire $bPPartenaire The ChildSPartenaire object to add.
     */
    protected function doAddBPPartenaire(ChildSPartenaire $bPPartenaire)
    {
        $this->collBPPartenaires[]= $bPPartenaire;
        $bPPartenaire->setSocPlaignant($this);
    }

    /**
     * @param  ChildSPartenaire $bPPartenaire The ChildSPartenaire object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeBPPartenaire(ChildSPartenaire $bPPartenaire)
    {
        if ($this->getBPPartenaires()->contains($bPPartenaire)) {
            $pos = $this->collBPPartenaires->search($bPPartenaire);
            $this->collBPPartenaires->remove($pos);
            if (null === $this->bPPartenairesScheduledForDeletion) {
                $this->bPPartenairesScheduledForDeletion = clone $this->collBPPartenaires;
                $this->bPPartenairesScheduledForDeletion->clear();
            }
            $this->bPPartenairesScheduledForDeletion[]= $bPPartenaire;
            $bPPartenaire->setSocPlaignant(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related BPPartenaires from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSPartenaire[] List of ChildSPartenaire objects
     */
    public function getBPPartenairesJoinPartenaire(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSPartenaireQuery::create(null, $criteria);
        $query->joinWith('Partenaire', $joinBehavior);

        return $this->getBPPartenaires($query, $con);
    }

    /**
     * Clears out the collMROCentres collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMROCentres()
     */
    public function clearMROCentres()
    {
        $this->collMROCentres = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMROCentres collection loaded partially.
     */
    public function resetPartialMROCentres($v = true)
    {
        $this->collMROCentresPartial = $v;
    }

    /**
     * Initializes the collMROCentres collection.
     *
     * By default this just sets the collMROCentres collection to an empty array (like clearcollMROCentres());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMROCentres($overrideExisting = true)
    {
        if (null !== $this->collMROCentres && !$overrideExisting) {
            return;
        }
        $this->collMROCentres = new ObjectCollection();
        $this->collMROCentres->setModel('\MROCentre');
    }

    /**
     * Gets an array of ChildMROCentre objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMROCentre[] List of ChildMROCentre objects
     * @throws PropelException
     */
    public function getMROCentres(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMROCentresPartial && !$this->isNew();
        if (null === $this->collMROCentres || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMROCentres) {
                // return empty collection
                $this->initMROCentres();
            } else {
                $collMROCentres = ChildMROCentreQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMROCentresPartial && count($collMROCentres)) {
                        $this->initMROCentres(false);

                        foreach ($collMROCentres as $obj) {
                            if (false == $this->collMROCentres->contains($obj)) {
                                $this->collMROCentres->append($obj);
                            }
                        }

                        $this->collMROCentresPartial = true;
                    }

                    return $collMROCentres;
                }

                if ($partial && $this->collMROCentres) {
                    foreach ($this->collMROCentres as $obj) {
                        if ($obj->isNew()) {
                            $collMROCentres[] = $obj;
                        }
                    }
                }

                $this->collMROCentres = $collMROCentres;
                $this->collMROCentresPartial = false;
            }
        }

        return $this->collMROCentres;
    }

    /**
     * Sets a collection of ChildMROCentre objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $mROCentres A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setMROCentres(Collection $mROCentres, ConnectionInterface $con = null)
    {
        /** @var ChildMROCentre[] $mROCentresToDelete */
        $mROCentresToDelete = $this->getMROCentres(new Criteria(), $con)->diff($mROCentres);


        $this->mROCentresScheduledForDeletion = $mROCentresToDelete;

        foreach ($mROCentresToDelete as $mROCentreRemoved) {
            $mROCentreRemoved->setSociete(null);
        }

        $this->collMROCentres = null;
        foreach ($mROCentres as $mROCentre) {
            $this->addMROCentre($mROCentre);
        }

        $this->collMROCentres = $mROCentres;
        $this->collMROCentresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MROCentre objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MROCentre objects.
     * @throws PropelException
     */
    public function countMROCentres(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMROCentresPartial && !$this->isNew();
        if (null === $this->collMROCentres || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMROCentres) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMROCentres());
            }

            $query = ChildMROCentreQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collMROCentres);
    }

    /**
     * Method called to associate a ChildMROCentre object to this object
     * through the ChildMROCentre foreign key attribute.
     *
     * @param  ChildMROCentre $l ChildMROCentre
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addMROCentre(ChildMROCentre $l)
    {
        if ($this->collMROCentres === null) {
            $this->initMROCentres();
            $this->collMROCentresPartial = true;
        }

        if (!$this->collMROCentres->contains($l)) {
            $this->doAddMROCentre($l);
        }

        return $this;
    }

    /**
     * @param ChildMROCentre $mROCentre The ChildMROCentre object to add.
     */
    protected function doAddMROCentre(ChildMROCentre $mROCentre)
    {
        $this->collMROCentres[]= $mROCentre;
        $mROCentre->setSociete($this);
    }

    /**
     * @param  ChildMROCentre $mROCentre The ChildMROCentre object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeMROCentre(ChildMROCentre $mROCentre)
    {
        if ($this->getMROCentres()->contains($mROCentre)) {
            $pos = $this->collMROCentres->search($mROCentre);
            $this->collMROCentres->remove($pos);
            if (null === $this->mROCentresScheduledForDeletion) {
                $this->mROCentresScheduledForDeletion = clone $this->collMROCentres;
                $this->mROCentresScheduledForDeletion->clear();
            }
            $this->mROCentresScheduledForDeletion[]= $mROCentre;
            $mROCentre->setSociete(null);
        }

        return $this;
    }

    /**
     * Clears out the collMROSocietes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMROSocietes()
     */
    public function clearMROSocietes()
    {
        $this->collMROSocietes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMROSocietes collection loaded partially.
     */
    public function resetPartialMROSocietes($v = true)
    {
        $this->collMROSocietesPartial = $v;
    }

    /**
     * Initializes the collMROSocietes collection.
     *
     * By default this just sets the collMROSocietes collection to an empty array (like clearcollMROSocietes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMROSocietes($overrideExisting = true)
    {
        if (null !== $this->collMROSocietes && !$overrideExisting) {
            return;
        }
        $this->collMROSocietes = new ObjectCollection();
        $this->collMROSocietes->setModel('\MROCentre');
    }

    /**
     * Gets an array of ChildMROCentre objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMROCentre[] List of ChildMROCentre objects
     * @throws PropelException
     */
    public function getMROSocietes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMROSocietesPartial && !$this->isNew();
        if (null === $this->collMROSocietes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMROSocietes) {
                // return empty collection
                $this->initMROSocietes();
            } else {
                $collMROSocietes = ChildMROCentreQuery::create(null, $criteria)
                    ->filterByMROSociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMROSocietesPartial && count($collMROSocietes)) {
                        $this->initMROSocietes(false);

                        foreach ($collMROSocietes as $obj) {
                            if (false == $this->collMROSocietes->contains($obj)) {
                                $this->collMROSocietes->append($obj);
                            }
                        }

                        $this->collMROSocietesPartial = true;
                    }

                    return $collMROSocietes;
                }

                if ($partial && $this->collMROSocietes) {
                    foreach ($this->collMROSocietes as $obj) {
                        if ($obj->isNew()) {
                            $collMROSocietes[] = $obj;
                        }
                    }
                }

                $this->collMROSocietes = $collMROSocietes;
                $this->collMROSocietesPartial = false;
            }
        }

        return $this->collMROSocietes;
    }

    /**
     * Sets a collection of ChildMROCentre objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $mROSocietes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setMROSocietes(Collection $mROSocietes, ConnectionInterface $con = null)
    {
        /** @var ChildMROCentre[] $mROSocietesToDelete */
        $mROSocietesToDelete = $this->getMROSocietes(new Criteria(), $con)->diff($mROSocietes);


        $this->mROSocietesScheduledForDeletion = $mROSocietesToDelete;

        foreach ($mROSocietesToDelete as $mROSocieteRemoved) {
            $mROSocieteRemoved->setMROSociete(null);
        }

        $this->collMROSocietes = null;
        foreach ($mROSocietes as $mROSociete) {
            $this->addMROSociete($mROSociete);
        }

        $this->collMROSocietes = $mROSocietes;
        $this->collMROSocietesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MROCentre objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MROCentre objects.
     * @throws PropelException
     */
    public function countMROSocietes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMROSocietesPartial && !$this->isNew();
        if (null === $this->collMROSocietes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMROSocietes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMROSocietes());
            }

            $query = ChildMROCentreQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMROSociete($this)
                ->count($con);
        }

        return count($this->collMROSocietes);
    }

    /**
     * Method called to associate a ChildMROCentre object to this object
     * through the ChildMROCentre foreign key attribute.
     *
     * @param  ChildMROCentre $l ChildMROCentre
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addMROSociete(ChildMROCentre $l)
    {
        if ($this->collMROSocietes === null) {
            $this->initMROSocietes();
            $this->collMROSocietesPartial = true;
        }

        if (!$this->collMROSocietes->contains($l)) {
            $this->doAddMROSociete($l);
        }

        return $this;
    }

    /**
     * @param ChildMROCentre $mROSociete The ChildMROCentre object to add.
     */
    protected function doAddMROSociete(ChildMROCentre $mROSociete)
    {
        $this->collMROSocietes[]= $mROSociete;
        $mROSociete->setMROSociete($this);
    }

    /**
     * @param  ChildMROCentre $mROSociete The ChildMROCentre object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeMROSociete(ChildMROCentre $mROSociete)
    {
        if ($this->getMROSocietes()->contains($mROSociete)) {
            $pos = $this->collMROSocietes->search($mROSociete);
            $this->collMROSocietes->remove($pos);
            if (null === $this->mROSocietesScheduledForDeletion) {
                $this->mROSocietesScheduledForDeletion = clone $this->collMROSocietes;
                $this->mROSocietesScheduledForDeletion->clear();
            }
            $this->mROSocietesScheduledForDeletion[]= $mROSociete;
            $mROSociete->setMROSociete(null);
        }

        return $this;
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
     * If this ChildSociete is new, it will return
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
                    ->filterBySociete($this)
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
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setFournisseurs(Collection $fournisseurs, ConnectionInterface $con = null)
    {
        /** @var ChildFournisseur[] $fournisseursToDelete */
        $fournisseursToDelete = $this->getFournisseurs(new Criteria(), $con)->diff($fournisseurs);


        $this->fournisseursScheduledForDeletion = $fournisseursToDelete;

        foreach ($fournisseursToDelete as $fournisseurRemoved) {
            $fournisseurRemoved->setSociete(null);
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
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collFournisseurs);
    }

    /**
     * Method called to associate a ChildFournisseur object to this object
     * through the ChildFournisseur foreign key attribute.
     *
     * @param  ChildFournisseur $l ChildFournisseur
     * @return $this|\Societe The current object (for fluent API support)
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
        $fournisseur->setSociete($this);
    }

    /**
     * @param  ChildFournisseur $fournisseur The ChildFournisseur object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
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
            $fournisseur->setSociete(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFournisseur[] List of ChildFournisseur objects
     */
    public function getFournisseursJoinPiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFournisseurQuery::create(null, $criteria);
        $query->joinWith('Piece', $joinBehavior);

        return $this->getFournisseurs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
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
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Fournisseurs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
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
     * Clears out the collCommandes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommandes()
     */
    public function clearCommandes()
    {
        $this->collCommandes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommandes collection loaded partially.
     */
    public function resetPartialCommandes($v = true)
    {
        $this->collCommandesPartial = $v;
    }

    /**
     * Initializes the collCommandes collection.
     *
     * By default this just sets the collCommandes collection to an empty array (like clearcollCommandes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommandes($overrideExisting = true)
    {
        if (null !== $this->collCommandes && !$overrideExisting) {
            return;
        }
        $this->collCommandes = new ObjectCollection();
        $this->collCommandes->setModel('\Commande');
    }

    /**
     * Gets an array of ChildCommande objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCommande[] List of ChildCommande objects
     * @throws PropelException
     */
    public function getCommandes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommandesPartial && !$this->isNew();
        if (null === $this->collCommandes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommandes) {
                // return empty collection
                $this->initCommandes();
            } else {
                $collCommandes = ChildCommandeQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommandesPartial && count($collCommandes)) {
                        $this->initCommandes(false);

                        foreach ($collCommandes as $obj) {
                            if (false == $this->collCommandes->contains($obj)) {
                                $this->collCommandes->append($obj);
                            }
                        }

                        $this->collCommandesPartial = true;
                    }

                    return $collCommandes;
                }

                if ($partial && $this->collCommandes) {
                    foreach ($this->collCommandes as $obj) {
                        if ($obj->isNew()) {
                            $collCommandes[] = $obj;
                        }
                    }
                }

                $this->collCommandes = $collCommandes;
                $this->collCommandesPartial = false;
            }
        }

        return $this->collCommandes;
    }

    /**
     * Sets a collection of ChildCommande objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commandes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setCommandes(Collection $commandes, ConnectionInterface $con = null)
    {
        /** @var ChildCommande[] $commandesToDelete */
        $commandesToDelete = $this->getCommandes(new Criteria(), $con)->diff($commandes);


        $this->commandesScheduledForDeletion = $commandesToDelete;

        foreach ($commandesToDelete as $commandeRemoved) {
            $commandeRemoved->setSociete(null);
        }

        $this->collCommandes = null;
        foreach ($commandes as $commande) {
            $this->addCommande($commande);
        }

        $this->collCommandes = $commandes;
        $this->collCommandesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Commande objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Commande objects.
     * @throws PropelException
     */
    public function countCommandes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommandesPartial && !$this->isNew();
        if (null === $this->collCommandes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommandes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommandes());
            }

            $query = ChildCommandeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collCommandes);
    }

    /**
     * Method called to associate a ChildCommande object to this object
     * through the ChildCommande foreign key attribute.
     *
     * @param  ChildCommande $l ChildCommande
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addCommande(ChildCommande $l)
    {
        if ($this->collCommandes === null) {
            $this->initCommandes();
            $this->collCommandesPartial = true;
        }

        if (!$this->collCommandes->contains($l)) {
            $this->doAddCommande($l);
        }

        return $this;
    }

    /**
     * @param ChildCommande $commande The ChildCommande object to add.
     */
    protected function doAddCommande(ChildCommande $commande)
    {
        $this->collCommandes[]= $commande;
        $commande->setSociete($this);
    }

    /**
     * @param  ChildCommande $commande The ChildCommande object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeCommande(ChildCommande $commande)
    {
        if ($this->getCommandes()->contains($commande)) {
            $pos = $this->collCommandes->search($commande);
            $this->collCommandes->remove($pos);
            if (null === $this->commandesScheduledForDeletion) {
                $this->commandesScheduledForDeletion = clone $this->collCommandes;
                $this->commandesScheduledForDeletion->clear();
            }
            $this->commandesScheduledForDeletion[]= $commande;
            $commande->setSociete(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Commandes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCommande[] List of ChildCommande objects
     */
    public function getCommandesJoinMTransport(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommandeQuery::create(null, $criteria);
        $query->joinWith('MTransport', $joinBehavior);

        return $this->getCommandes($query, $con);
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
     * If this ChildSociete is new, it will return
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
                    ->filterBySociete($this)
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
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setSocieteappareils(Collection $societeappareils, ConnectionInterface $con = null)
    {
        /** @var ChildSocieteappareil[] $societeappareilsToDelete */
        $societeappareilsToDelete = $this->getSocieteappareils(new Criteria(), $con)->diff($societeappareils);


        $this->societeappareilsScheduledForDeletion = $societeappareilsToDelete;

        foreach ($societeappareilsToDelete as $societeappareilRemoved) {
            $societeappareilRemoved->setSociete(null);
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
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collSocieteappareils);
    }

    /**
     * Method called to associate a ChildSocieteappareil object to this object
     * through the ChildSocieteappareil foreign key attribute.
     *
     * @param  ChildSocieteappareil $l ChildSocieteappareil
     * @return $this|\Societe The current object (for fluent API support)
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
        $societeappareil->setSociete($this);
    }

    /**
     * @param  ChildSocieteappareil $societeappareil The ChildSocieteappareil object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
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
            $societeappareil->setSociete(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Societeappareils from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocieteappareil[] List of ChildSocieteappareil objects
     */
    public function getSocieteappareilsJoinAppareil(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocieteappareilQuery::create(null, $criteria);
        $query->joinWith('Appareil', $joinBehavior);

        return $this->getSocieteappareils($query, $con);
    }

    /**
     * Clears out the collContacts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContacts()
     */
    public function clearContacts()
    {
        $this->collContacts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collContacts collection loaded partially.
     */
    public function resetPartialContacts($v = true)
    {
        $this->collContactsPartial = $v;
    }

    /**
     * Initializes the collContacts collection.
     *
     * By default this just sets the collContacts collection to an empty array (like clearcollContacts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContacts($overrideExisting = true)
    {
        if (null !== $this->collContacts && !$overrideExisting) {
            return;
        }
        $this->collContacts = new ObjectCollection();
        $this->collContacts->setModel('\Contact');
    }

    /**
     * Gets an array of ChildContact objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildContact[] List of ChildContact objects
     * @throws PropelException
     */
    public function getContacts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collContactsPartial && !$this->isNew();
        if (null === $this->collContacts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContacts) {
                // return empty collection
                $this->initContacts();
            } else {
                $collContacts = ChildContactQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContactsPartial && count($collContacts)) {
                        $this->initContacts(false);

                        foreach ($collContacts as $obj) {
                            if (false == $this->collContacts->contains($obj)) {
                                $this->collContacts->append($obj);
                            }
                        }

                        $this->collContactsPartial = true;
                    }

                    return $collContacts;
                }

                if ($partial && $this->collContacts) {
                    foreach ($this->collContacts as $obj) {
                        if ($obj->isNew()) {
                            $collContacts[] = $obj;
                        }
                    }
                }

                $this->collContacts = $collContacts;
                $this->collContactsPartial = false;
            }
        }

        return $this->collContacts;
    }

    /**
     * Sets a collection of ChildContact objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $contacts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setContacts(Collection $contacts, ConnectionInterface $con = null)
    {
        /** @var ChildContact[] $contactsToDelete */
        $contactsToDelete = $this->getContacts(new Criteria(), $con)->diff($contacts);


        $this->contactsScheduledForDeletion = $contactsToDelete;

        foreach ($contactsToDelete as $contactRemoved) {
            $contactRemoved->setSociete(null);
        }

        $this->collContacts = null;
        foreach ($contacts as $contact) {
            $this->addContact($contact);
        }

        $this->collContacts = $contacts;
        $this->collContactsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Contact objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Contact objects.
     * @throws PropelException
     */
    public function countContacts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collContactsPartial && !$this->isNew();
        if (null === $this->collContacts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContacts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContacts());
            }

            $query = ChildContactQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collContacts);
    }

    /**
     * Method called to associate a ChildContact object to this object
     * through the ChildContact foreign key attribute.
     *
     * @param  ChildContact $l ChildContact
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addContact(ChildContact $l)
    {
        if ($this->collContacts === null) {
            $this->initContacts();
            $this->collContactsPartial = true;
        }

        if (!$this->collContacts->contains($l)) {
            $this->doAddContact($l);
        }

        return $this;
    }

    /**
     * @param ChildContact $contact The ChildContact object to add.
     */
    protected function doAddContact(ChildContact $contact)
    {
        $this->collContacts[]= $contact;
        $contact->setSociete($this);
    }

    /**
     * @param  ChildContact $contact The ChildContact object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeContact(ChildContact $contact)
    {
        if ($this->getContacts()->contains($contact)) {
            $pos = $this->collContacts->search($contact);
            $this->collContacts->remove($pos);
            if (null === $this->contactsScheduledForDeletion) {
                $this->contactsScheduledForDeletion = clone $this->collContacts;
                $this->contactsScheduledForDeletion->clear();
            }
            $this->contactsScheduledForDeletion[]= $contact;
            $contact->setSociete(null);
        }

        return $this;
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
     * If this ChildSociete is new, it will return
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
                    ->filterBySociete($this)
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
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setSocietecertificats(Collection $societecertificats, ConnectionInterface $con = null)
    {
        /** @var ChildSocietecertificat[] $societecertificatsToDelete */
        $societecertificatsToDelete = $this->getSocietecertificats(new Criteria(), $con)->diff($societecertificats);


        $this->societecertificatsScheduledForDeletion = $societecertificatsToDelete;

        foreach ($societecertificatsToDelete as $societecertificatRemoved) {
            $societecertificatRemoved->setSociete(null);
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
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collSocietecertificats);
    }

    /**
     * Method called to associate a ChildSocietecertificat object to this object
     * through the ChildSocietecertificat foreign key attribute.
     *
     * @param  ChildSocietecertificat $l ChildSocietecertificat
     * @return $this|\Societe The current object (for fluent API support)
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
        $societecertificat->setSociete($this);
    }

    /**
     * @param  ChildSocietecertificat $societecertificat The ChildSocietecertificat object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
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
            $societecertificat->setSociete(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Societecertificats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Societecertificats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocietecertificat[] List of ChildSocietecertificat objects
     */
    public function getSocietecertificatsJoinAppareil(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocietecertificatQuery::create(null, $criteria);
        $query->joinWith('Appareil', $joinBehavior);

        return $this->getSocietecertificats($query, $con);
    }

    /**
     * Clears out the collSocietemetiers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSocietemetiers()
     */
    public function clearSocietemetiers()
    {
        $this->collSocietemetiers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSocietemetiers collection loaded partially.
     */
    public function resetPartialSocietemetiers($v = true)
    {
        $this->collSocietemetiersPartial = $v;
    }

    /**
     * Initializes the collSocietemetiers collection.
     *
     * By default this just sets the collSocietemetiers collection to an empty array (like clearcollSocietemetiers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSocietemetiers($overrideExisting = true)
    {
        if (null !== $this->collSocietemetiers && !$overrideExisting) {
            return;
        }
        $this->collSocietemetiers = new ObjectCollection();
        $this->collSocietemetiers->setModel('\Societemetier');
    }

    /**
     * Gets an array of ChildSocietemetier objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSocietemetier[] List of ChildSocietemetier objects
     * @throws PropelException
     */
    public function getSocietemetiers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietemetiersPartial && !$this->isNew();
        if (null === $this->collSocietemetiers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSocietemetiers) {
                // return empty collection
                $this->initSocietemetiers();
            } else {
                $collSocietemetiers = ChildSocietemetierQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSocietemetiersPartial && count($collSocietemetiers)) {
                        $this->initSocietemetiers(false);

                        foreach ($collSocietemetiers as $obj) {
                            if (false == $this->collSocietemetiers->contains($obj)) {
                                $this->collSocietemetiers->append($obj);
                            }
                        }

                        $this->collSocietemetiersPartial = true;
                    }

                    return $collSocietemetiers;
                }

                if ($partial && $this->collSocietemetiers) {
                    foreach ($this->collSocietemetiers as $obj) {
                        if ($obj->isNew()) {
                            $collSocietemetiers[] = $obj;
                        }
                    }
                }

                $this->collSocietemetiers = $collSocietemetiers;
                $this->collSocietemetiersPartial = false;
            }
        }

        return $this->collSocietemetiers;
    }

    /**
     * Sets a collection of ChildSocietemetier objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $societemetiers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setSocietemetiers(Collection $societemetiers, ConnectionInterface $con = null)
    {
        /** @var ChildSocietemetier[] $societemetiersToDelete */
        $societemetiersToDelete = $this->getSocietemetiers(new Criteria(), $con)->diff($societemetiers);


        $this->societemetiersScheduledForDeletion = $societemetiersToDelete;

        foreach ($societemetiersToDelete as $societemetierRemoved) {
            $societemetierRemoved->setSociete(null);
        }

        $this->collSocietemetiers = null;
        foreach ($societemetiers as $societemetier) {
            $this->addSocietemetier($societemetier);
        }

        $this->collSocietemetiers = $societemetiers;
        $this->collSocietemetiersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Societemetier objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Societemetier objects.
     * @throws PropelException
     */
    public function countSocietemetiers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietemetiersPartial && !$this->isNew();
        if (null === $this->collSocietemetiers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSocietemetiers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSocietemetiers());
            }

            $query = ChildSocietemetierQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collSocietemetiers);
    }

    /**
     * Method called to associate a ChildSocietemetier object to this object
     * through the ChildSocietemetier foreign key attribute.
     *
     * @param  ChildSocietemetier $l ChildSocietemetier
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addSocietemetier(ChildSocietemetier $l)
    {
        if ($this->collSocietemetiers === null) {
            $this->initSocietemetiers();
            $this->collSocietemetiersPartial = true;
        }

        if (!$this->collSocietemetiers->contains($l)) {
            $this->doAddSocietemetier($l);
        }

        return $this;
    }

    /**
     * @param ChildSocietemetier $societemetier The ChildSocietemetier object to add.
     */
    protected function doAddSocietemetier(ChildSocietemetier $societemetier)
    {
        $this->collSocietemetiers[]= $societemetier;
        $societemetier->setSociete($this);
    }

    /**
     * @param  ChildSocietemetier $societemetier The ChildSocietemetier object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeSocietemetier(ChildSocietemetier $societemetier)
    {
        if ($this->getSocietemetiers()->contains($societemetier)) {
            $pos = $this->collSocietemetiers->search($societemetier);
            $this->collSocietemetiers->remove($pos);
            if (null === $this->societemetiersScheduledForDeletion) {
                $this->societemetiersScheduledForDeletion = clone $this->collSocietemetiers;
                $this->societemetiersScheduledForDeletion->clear();
            }
            $this->societemetiersScheduledForDeletion[]= $societemetier;
            $societemetier->setSociete(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Societemetiers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocietemetier[] List of ChildSocietemetier objects
     */
    public function getSocietemetiersJoinMetier(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocietemetierQuery::create(null, $criteria);
        $query->joinWith('Metier', $joinBehavior);

        return $this->getSocietemetiers($query, $con);
    }

    /**
     * Clears out the collSocietetypepieces collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSocietetypepieces()
     */
    public function clearSocietetypepieces()
    {
        $this->collSocietetypepieces = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSocietetypepieces collection loaded partially.
     */
    public function resetPartialSocietetypepieces($v = true)
    {
        $this->collSocietetypepiecesPartial = $v;
    }

    /**
     * Initializes the collSocietetypepieces collection.
     *
     * By default this just sets the collSocietetypepieces collection to an empty array (like clearcollSocietetypepieces());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSocietetypepieces($overrideExisting = true)
    {
        if (null !== $this->collSocietetypepieces && !$overrideExisting) {
            return;
        }
        $this->collSocietetypepieces = new ObjectCollection();
        $this->collSocietetypepieces->setModel('\Societetypepiece');
    }

    /**
     * Gets an array of ChildSocietetypepiece objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSocietetypepiece[] List of ChildSocietetypepiece objects
     * @throws PropelException
     */
    public function getSocietetypepieces(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietetypepiecesPartial && !$this->isNew();
        if (null === $this->collSocietetypepieces || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSocietetypepieces) {
                // return empty collection
                $this->initSocietetypepieces();
            } else {
                $collSocietetypepieces = ChildSocietetypepieceQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSocietetypepiecesPartial && count($collSocietetypepieces)) {
                        $this->initSocietetypepieces(false);

                        foreach ($collSocietetypepieces as $obj) {
                            if (false == $this->collSocietetypepieces->contains($obj)) {
                                $this->collSocietetypepieces->append($obj);
                            }
                        }

                        $this->collSocietetypepiecesPartial = true;
                    }

                    return $collSocietetypepieces;
                }

                if ($partial && $this->collSocietetypepieces) {
                    foreach ($this->collSocietetypepieces as $obj) {
                        if ($obj->isNew()) {
                            $collSocietetypepieces[] = $obj;
                        }
                    }
                }

                $this->collSocietetypepieces = $collSocietetypepieces;
                $this->collSocietetypepiecesPartial = false;
            }
        }

        return $this->collSocietetypepieces;
    }

    /**
     * Sets a collection of ChildSocietetypepiece objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $societetypepieces A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setSocietetypepieces(Collection $societetypepieces, ConnectionInterface $con = null)
    {
        /** @var ChildSocietetypepiece[] $societetypepiecesToDelete */
        $societetypepiecesToDelete = $this->getSocietetypepieces(new Criteria(), $con)->diff($societetypepieces);


        $this->societetypepiecesScheduledForDeletion = $societetypepiecesToDelete;

        foreach ($societetypepiecesToDelete as $societetypepieceRemoved) {
            $societetypepieceRemoved->setSociete(null);
        }

        $this->collSocietetypepieces = null;
        foreach ($societetypepieces as $societetypepiece) {
            $this->addSocietetypepiece($societetypepiece);
        }

        $this->collSocietetypepieces = $societetypepieces;
        $this->collSocietetypepiecesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Societetypepiece objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Societetypepiece objects.
     * @throws PropelException
     */
    public function countSocietetypepieces(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietetypepiecesPartial && !$this->isNew();
        if (null === $this->collSocietetypepieces || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSocietetypepieces) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSocietetypepieces());
            }

            $query = ChildSocietetypepieceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collSocietetypepieces);
    }

    /**
     * Method called to associate a ChildSocietetypepiece object to this object
     * through the ChildSocietetypepiece foreign key attribute.
     *
     * @param  ChildSocietetypepiece $l ChildSocietetypepiece
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addSocietetypepiece(ChildSocietetypepiece $l)
    {
        if ($this->collSocietetypepieces === null) {
            $this->initSocietetypepieces();
            $this->collSocietetypepiecesPartial = true;
        }

        if (!$this->collSocietetypepieces->contains($l)) {
            $this->doAddSocietetypepiece($l);
        }

        return $this;
    }

    /**
     * @param ChildSocietetypepiece $societetypepiece The ChildSocietetypepiece object to add.
     */
    protected function doAddSocietetypepiece(ChildSocietetypepiece $societetypepiece)
    {
        $this->collSocietetypepieces[]= $societetypepiece;
        $societetypepiece->setSociete($this);
    }

    /**
     * @param  ChildSocietetypepiece $societetypepiece The ChildSocietetypepiece object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeSocietetypepiece(ChildSocietetypepiece $societetypepiece)
    {
        if ($this->getSocietetypepieces()->contains($societetypepiece)) {
            $pos = $this->collSocietetypepieces->search($societetypepiece);
            $this->collSocietetypepieces->remove($pos);
            if (null === $this->societetypepiecesScheduledForDeletion) {
                $this->societetypepiecesScheduledForDeletion = clone $this->collSocietetypepieces;
                $this->societetypepiecesScheduledForDeletion->clear();
            }
            $this->societetypepiecesScheduledForDeletion[]= $societetypepiece;
            $societetypepiece->setSociete(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Societetypepieces from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocietetypepiece[] List of ChildSocietetypepiece objects
     */
    public function getSocietetypepiecesJoinTypepiece(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocietetypepieceQuery::create(null, $criteria);
        $query->joinWith('Typepiece', $joinBehavior);

        return $this->getSocietetypepieces($query, $con);
    }

    /**
     * Clears out the collSocietehistoriques collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSocietehistoriques()
     */
    public function clearSocietehistoriques()
    {
        $this->collSocietehistoriques = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSocietehistoriques collection loaded partially.
     */
    public function resetPartialSocietehistoriques($v = true)
    {
        $this->collSocietehistoriquesPartial = $v;
    }

    /**
     * Initializes the collSocietehistoriques collection.
     *
     * By default this just sets the collSocietehistoriques collection to an empty array (like clearcollSocietehistoriques());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSocietehistoriques($overrideExisting = true)
    {
        if (null !== $this->collSocietehistoriques && !$overrideExisting) {
            return;
        }
        $this->collSocietehistoriques = new ObjectCollection();
        $this->collSocietehistoriques->setModel('\Societehistorique');
    }

    /**
     * Gets an array of ChildSocietehistorique objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSocietehistorique[] List of ChildSocietehistorique objects
     * @throws PropelException
     */
    public function getSocietehistoriques(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietehistoriquesPartial && !$this->isNew();
        if (null === $this->collSocietehistoriques || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSocietehistoriques) {
                // return empty collection
                $this->initSocietehistoriques();
            } else {
                $collSocietehistoriques = ChildSocietehistoriqueQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSocietehistoriquesPartial && count($collSocietehistoriques)) {
                        $this->initSocietehistoriques(false);

                        foreach ($collSocietehistoriques as $obj) {
                            if (false == $this->collSocietehistoriques->contains($obj)) {
                                $this->collSocietehistoriques->append($obj);
                            }
                        }

                        $this->collSocietehistoriquesPartial = true;
                    }

                    return $collSocietehistoriques;
                }

                if ($partial && $this->collSocietehistoriques) {
                    foreach ($this->collSocietehistoriques as $obj) {
                        if ($obj->isNew()) {
                            $collSocietehistoriques[] = $obj;
                        }
                    }
                }

                $this->collSocietehistoriques = $collSocietehistoriques;
                $this->collSocietehistoriquesPartial = false;
            }
        }

        return $this->collSocietehistoriques;
    }

    /**
     * Sets a collection of ChildSocietehistorique objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $societehistoriques A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setSocietehistoriques(Collection $societehistoriques, ConnectionInterface $con = null)
    {
        /** @var ChildSocietehistorique[] $societehistoriquesToDelete */
        $societehistoriquesToDelete = $this->getSocietehistoriques(new Criteria(), $con)->diff($societehistoriques);


        $this->societehistoriquesScheduledForDeletion = $societehistoriquesToDelete;

        foreach ($societehistoriquesToDelete as $societehistoriqueRemoved) {
            $societehistoriqueRemoved->setSociete(null);
        }

        $this->collSocietehistoriques = null;
        foreach ($societehistoriques as $societehistorique) {
            $this->addSocietehistorique($societehistorique);
        }

        $this->collSocietehistoriques = $societehistoriques;
        $this->collSocietehistoriquesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Societehistorique objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Societehistorique objects.
     * @throws PropelException
     */
    public function countSocietehistoriques(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSocietehistoriquesPartial && !$this->isNew();
        if (null === $this->collSocietehistoriques || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSocietehistoriques) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSocietehistoriques());
            }

            $query = ChildSocietehistoriqueQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collSocietehistoriques);
    }

    /**
     * Method called to associate a ChildSocietehistorique object to this object
     * through the ChildSocietehistorique foreign key attribute.
     *
     * @param  ChildSocietehistorique $l ChildSocietehistorique
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addSocietehistorique(ChildSocietehistorique $l)
    {
        if ($this->collSocietehistoriques === null) {
            $this->initSocietehistoriques();
            $this->collSocietehistoriquesPartial = true;
        }

        if (!$this->collSocietehistoriques->contains($l)) {
            $this->doAddSocietehistorique($l);
        }

        return $this;
    }

    /**
     * @param ChildSocietehistorique $societehistorique The ChildSocietehistorique object to add.
     */
    protected function doAddSocietehistorique(ChildSocietehistorique $societehistorique)
    {
        $this->collSocietehistoriques[]= $societehistorique;
        $societehistorique->setSociete($this);
    }

    /**
     * @param  ChildSocietehistorique $societehistorique The ChildSocietehistorique object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeSocietehistorique(ChildSocietehistorique $societehistorique)
    {
        if ($this->getSocietehistoriques()->contains($societehistorique)) {
            $pos = $this->collSocietehistoriques->search($societehistorique);
            $this->collSocietehistoriques->remove($pos);
            if (null === $this->societehistoriquesScheduledForDeletion) {
                $this->societehistoriquesScheduledForDeletion = clone $this->collSocietehistoriques;
                $this->societehistoriquesScheduledForDeletion->clear();
            }
            $this->societehistoriquesScheduledForDeletion[]= $societehistorique;
            $societehistorique->setSociete(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Societe is new, it will return
     * an empty collection; or if this Societe has previously
     * been saved, it will retrieve related Societehistoriques from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Societe.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSocietehistorique[] List of ChildSocietehistorique objects
     */
    public function getSocietehistoriquesJoinHistorique(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSocietehistoriqueQuery::create(null, $criteria);
        $query->joinWith('Historique', $joinBehavior);

        return $this->getSocietehistoriques($query, $con);
    }

    /**
     * Clears out the collFinancieres collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFinancieres()
     */
    public function clearFinancieres()
    {
        $this->collFinancieres = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFinancieres collection loaded partially.
     */
    public function resetPartialFinancieres($v = true)
    {
        $this->collFinancieresPartial = $v;
    }

    /**
     * Initializes the collFinancieres collection.
     *
     * By default this just sets the collFinancieres collection to an empty array (like clearcollFinancieres());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFinancieres($overrideExisting = true)
    {
        if (null !== $this->collFinancieres && !$overrideExisting) {
            return;
        }
        $this->collFinancieres = new ObjectCollection();
        $this->collFinancieres->setModel('\Financiere');
    }

    /**
     * Gets an array of ChildFinanciere objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFinanciere[] List of ChildFinanciere objects
     * @throws PropelException
     */
    public function getFinancieres(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFinancieresPartial && !$this->isNew();
        if (null === $this->collFinancieres || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFinancieres) {
                // return empty collection
                $this->initFinancieres();
            } else {
                $collFinancieres = ChildFinanciereQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFinancieresPartial && count($collFinancieres)) {
                        $this->initFinancieres(false);

                        foreach ($collFinancieres as $obj) {
                            if (false == $this->collFinancieres->contains($obj)) {
                                $this->collFinancieres->append($obj);
                            }
                        }

                        $this->collFinancieresPartial = true;
                    }

                    return $collFinancieres;
                }

                if ($partial && $this->collFinancieres) {
                    foreach ($this->collFinancieres as $obj) {
                        if ($obj->isNew()) {
                            $collFinancieres[] = $obj;
                        }
                    }
                }

                $this->collFinancieres = $collFinancieres;
                $this->collFinancieresPartial = false;
            }
        }

        return $this->collFinancieres;
    }

    /**
     * Sets a collection of ChildFinanciere objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $financieres A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setFinancieres(Collection $financieres, ConnectionInterface $con = null)
    {
        /** @var ChildFinanciere[] $financieresToDelete */
        $financieresToDelete = $this->getFinancieres(new Criteria(), $con)->diff($financieres);


        $this->financieresScheduledForDeletion = $financieresToDelete;

        foreach ($financieresToDelete as $financiereRemoved) {
            $financiereRemoved->setSociete(null);
        }

        $this->collFinancieres = null;
        foreach ($financieres as $financiere) {
            $this->addFinanciere($financiere);
        }

        $this->collFinancieres = $financieres;
        $this->collFinancieresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Financiere objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Financiere objects.
     * @throws PropelException
     */
    public function countFinancieres(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFinancieresPartial && !$this->isNew();
        if (null === $this->collFinancieres || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFinancieres) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFinancieres());
            }

            $query = ChildFinanciereQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collFinancieres);
    }

    /**
     * Method called to associate a ChildFinanciere object to this object
     * through the ChildFinanciere foreign key attribute.
     *
     * @param  ChildFinanciere $l ChildFinanciere
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addFinanciere(ChildFinanciere $l)
    {
        if ($this->collFinancieres === null) {
            $this->initFinancieres();
            $this->collFinancieresPartial = true;
        }

        if (!$this->collFinancieres->contains($l)) {
            $this->doAddFinanciere($l);
        }

        return $this;
    }

    /**
     * @param ChildFinanciere $financiere The ChildFinanciere object to add.
     */
    protected function doAddFinanciere(ChildFinanciere $financiere)
    {
        $this->collFinancieres[]= $financiere;
        $financiere->setSociete($this);
    }

    /**
     * @param  ChildFinanciere $financiere The ChildFinanciere object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeFinanciere(ChildFinanciere $financiere)
    {
        if ($this->getFinancieres()->contains($financiere)) {
            $pos = $this->collFinancieres->search($financiere);
            $this->collFinancieres->remove($pos);
            if (null === $this->financieresScheduledForDeletion) {
                $this->financieresScheduledForDeletion = clone $this->collFinancieres;
                $this->financieresScheduledForDeletion->clear();
            }
            $this->financieresScheduledForDeletion[]= $financiere;
            $financiere->setSociete(null);
        }

        return $this;
    }

    /**
     * Clears out the collChiffredaffaires collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addChiffredaffaires()
     */
    public function clearChiffredaffaires()
    {
        $this->collChiffredaffaires = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collChiffredaffaires collection loaded partially.
     */
    public function resetPartialChiffredaffaires($v = true)
    {
        $this->collChiffredaffairesPartial = $v;
    }

    /**
     * Initializes the collChiffredaffaires collection.
     *
     * By default this just sets the collChiffredaffaires collection to an empty array (like clearcollChiffredaffaires());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initChiffredaffaires($overrideExisting = true)
    {
        if (null !== $this->collChiffredaffaires && !$overrideExisting) {
            return;
        }
        $this->collChiffredaffaires = new ObjectCollection();
        $this->collChiffredaffaires->setModel('\Chiffredaffaire');
    }

    /**
     * Gets an array of ChildChiffredaffaire objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildChiffredaffaire[] List of ChildChiffredaffaire objects
     * @throws PropelException
     */
    public function getChiffredaffaires(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collChiffredaffairesPartial && !$this->isNew();
        if (null === $this->collChiffredaffaires || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collChiffredaffaires) {
                // return empty collection
                $this->initChiffredaffaires();
            } else {
                $collChiffredaffaires = ChildChiffredaffaireQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collChiffredaffairesPartial && count($collChiffredaffaires)) {
                        $this->initChiffredaffaires(false);

                        foreach ($collChiffredaffaires as $obj) {
                            if (false == $this->collChiffredaffaires->contains($obj)) {
                                $this->collChiffredaffaires->append($obj);
                            }
                        }

                        $this->collChiffredaffairesPartial = true;
                    }

                    return $collChiffredaffaires;
                }

                if ($partial && $this->collChiffredaffaires) {
                    foreach ($this->collChiffredaffaires as $obj) {
                        if ($obj->isNew()) {
                            $collChiffredaffaires[] = $obj;
                        }
                    }
                }

                $this->collChiffredaffaires = $collChiffredaffaires;
                $this->collChiffredaffairesPartial = false;
            }
        }

        return $this->collChiffredaffaires;
    }

    /**
     * Sets a collection of ChildChiffredaffaire objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $chiffredaffaires A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setChiffredaffaires(Collection $chiffredaffaires, ConnectionInterface $con = null)
    {
        /** @var ChildChiffredaffaire[] $chiffredaffairesToDelete */
        $chiffredaffairesToDelete = $this->getChiffredaffaires(new Criteria(), $con)->diff($chiffredaffaires);


        $this->chiffredaffairesScheduledForDeletion = $chiffredaffairesToDelete;

        foreach ($chiffredaffairesToDelete as $chiffredaffaireRemoved) {
            $chiffredaffaireRemoved->setSociete(null);
        }

        $this->collChiffredaffaires = null;
        foreach ($chiffredaffaires as $chiffredaffaire) {
            $this->addChiffredaffaire($chiffredaffaire);
        }

        $this->collChiffredaffaires = $chiffredaffaires;
        $this->collChiffredaffairesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Chiffredaffaire objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Chiffredaffaire objects.
     * @throws PropelException
     */
    public function countChiffredaffaires(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collChiffredaffairesPartial && !$this->isNew();
        if (null === $this->collChiffredaffaires || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collChiffredaffaires) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getChiffredaffaires());
            }

            $query = ChildChiffredaffaireQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collChiffredaffaires);
    }

    /**
     * Method called to associate a ChildChiffredaffaire object to this object
     * through the ChildChiffredaffaire foreign key attribute.
     *
     * @param  ChildChiffredaffaire $l ChildChiffredaffaire
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addChiffredaffaire(ChildChiffredaffaire $l)
    {
        if ($this->collChiffredaffaires === null) {
            $this->initChiffredaffaires();
            $this->collChiffredaffairesPartial = true;
        }

        if (!$this->collChiffredaffaires->contains($l)) {
            $this->doAddChiffredaffaire($l);
        }

        return $this;
    }

    /**
     * @param ChildChiffredaffaire $chiffredaffaire The ChildChiffredaffaire object to add.
     */
    protected function doAddChiffredaffaire(ChildChiffredaffaire $chiffredaffaire)
    {
        $this->collChiffredaffaires[]= $chiffredaffaire;
        $chiffredaffaire->setSociete($this);
    }

    /**
     * @param  ChildChiffredaffaire $chiffredaffaire The ChildChiffredaffaire object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeChiffredaffaire(ChildChiffredaffaire $chiffredaffaire)
    {
        if ($this->getChiffredaffaires()->contains($chiffredaffaire)) {
            $pos = $this->collChiffredaffaires->search($chiffredaffaire);
            $this->collChiffredaffaires->remove($pos);
            if (null === $this->chiffredaffairesScheduledForDeletion) {
                $this->chiffredaffairesScheduledForDeletion = clone $this->collChiffredaffaires;
                $this->chiffredaffairesScheduledForDeletion->clear();
            }
            $this->chiffredaffairesScheduledForDeletion[]= $chiffredaffaire;
            $chiffredaffaire->setSociete(null);
        }

        return $this;
    }

    /**
     * Clears out the collWebsources collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addWebsources()
     */
    public function clearWebsources()
    {
        $this->collWebsources = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collWebsources collection loaded partially.
     */
    public function resetPartialWebsources($v = true)
    {
        $this->collWebsourcesPartial = $v;
    }

    /**
     * Initializes the collWebsources collection.
     *
     * By default this just sets the collWebsources collection to an empty array (like clearcollWebsources());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWebsources($overrideExisting = true)
    {
        if (null !== $this->collWebsources && !$overrideExisting) {
            return;
        }
        $this->collWebsources = new ObjectCollection();
        $this->collWebsources->setModel('\Websource');
    }

    /**
     * Gets an array of ChildWebsource objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSociete is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildWebsource[] List of ChildWebsource objects
     * @throws PropelException
     */
    public function getWebsources(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collWebsourcesPartial && !$this->isNew();
        if (null === $this->collWebsources || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collWebsources) {
                // return empty collection
                $this->initWebsources();
            } else {
                $collWebsources = ChildWebsourceQuery::create(null, $criteria)
                    ->filterBySociete($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collWebsourcesPartial && count($collWebsources)) {
                        $this->initWebsources(false);

                        foreach ($collWebsources as $obj) {
                            if (false == $this->collWebsources->contains($obj)) {
                                $this->collWebsources->append($obj);
                            }
                        }

                        $this->collWebsourcesPartial = true;
                    }

                    return $collWebsources;
                }

                if ($partial && $this->collWebsources) {
                    foreach ($this->collWebsources as $obj) {
                        if ($obj->isNew()) {
                            $collWebsources[] = $obj;
                        }
                    }
                }

                $this->collWebsources = $collWebsources;
                $this->collWebsourcesPartial = false;
            }
        }

        return $this->collWebsources;
    }

    /**
     * Sets a collection of ChildWebsource objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $websources A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function setWebsources(Collection $websources, ConnectionInterface $con = null)
    {
        /** @var ChildWebsource[] $websourcesToDelete */
        $websourcesToDelete = $this->getWebsources(new Criteria(), $con)->diff($websources);


        $this->websourcesScheduledForDeletion = $websourcesToDelete;

        foreach ($websourcesToDelete as $websourceRemoved) {
            $websourceRemoved->setSociete(null);
        }

        $this->collWebsources = null;
        foreach ($websources as $websource) {
            $this->addWebsource($websource);
        }

        $this->collWebsources = $websources;
        $this->collWebsourcesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Websource objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Websource objects.
     * @throws PropelException
     */
    public function countWebsources(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collWebsourcesPartial && !$this->isNew();
        if (null === $this->collWebsources || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWebsources) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWebsources());
            }

            $query = ChildWebsourceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySociete($this)
                ->count($con);
        }

        return count($this->collWebsources);
    }

    /**
     * Method called to associate a ChildWebsource object to this object
     * through the ChildWebsource foreign key attribute.
     *
     * @param  ChildWebsource $l ChildWebsource
     * @return $this|\Societe The current object (for fluent API support)
     */
    public function addWebsource(ChildWebsource $l)
    {
        if ($this->collWebsources === null) {
            $this->initWebsources();
            $this->collWebsourcesPartial = true;
        }

        if (!$this->collWebsources->contains($l)) {
            $this->doAddWebsource($l);
        }

        return $this;
    }

    /**
     * @param ChildWebsource $websource The ChildWebsource object to add.
     */
    protected function doAddWebsource(ChildWebsource $websource)
    {
        $this->collWebsources[]= $websource;
        $websource->setSociete($this);
    }

    /**
     * @param  ChildWebsource $websource The ChildWebsource object to remove.
     * @return $this|ChildSociete The current object (for fluent API support)
     */
    public function removeWebsource(ChildWebsource $websource)
    {
        if ($this->getWebsources()->contains($websource)) {
            $pos = $this->collWebsources->search($websource);
            $this->collWebsources->remove($pos);
            if (null === $this->websourcesScheduledForDeletion) {
                $this->websourcesScheduledForDeletion = clone $this->collWebsources;
                $this->websourcesScheduledForDeletion->clear();
            }
            $this->websourcesScheduledForDeletion[]= $websource;
            $websource->setSociete(null);
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
        if (null !== $this->aMPays) {
            $this->aMPays->removeSociete($this);
        }
        if (null !== $this->aMarque) {
            $this->aMarque->removeSociete($this);
        }
        $this->soc_id = null;
        $this->societe = null;
        $this->dirigeant = null;
        $this->mail = null;
        $this->website = null;
        $this->tel = null;
        $this->fax = null;
        $this->adresse = null;
        $this->cp = null;
        $this->ville = null;
        $this->pays = null;
        $this->notes = null;
        $this->notes_activite = null;
        $this->scrrib = null;
        $this->fabricant = null;
        $this->logo = null;
        $this->fraude = null;
        $this->dte_maj_soc = null;
        $this->dte_maj_act = null;
        $this->dte_maj_gen = null;
        $this->actif = null;
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
            if ($this->singleBFPartenaire) {
                $this->singleBFPartenaire->clearAllReferences($deep);
            }
            if ($this->collBPPartenaires) {
                foreach ($this->collBPPartenaires as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMROCentres) {
                foreach ($this->collMROCentres as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMROSocietes) {
                foreach ($this->collMROSocietes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFournisseurs) {
                foreach ($this->collFournisseurs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCommandes) {
                foreach ($this->collCommandes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSocieteappareils) {
                foreach ($this->collSocieteappareils as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContacts) {
                foreach ($this->collContacts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSocietecertificats) {
                foreach ($this->collSocietecertificats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSocietemetiers) {
                foreach ($this->collSocietemetiers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSocietetypepieces) {
                foreach ($this->collSocietetypepieces as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSocietehistoriques) {
                foreach ($this->collSocietehistoriques as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFinancieres) {
                foreach ($this->collFinancieres as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collChiffredaffaires) {
                foreach ($this->collChiffredaffaires as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collWebsources) {
                foreach ($this->collWebsources as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->singleBFPartenaire = null;
        $this->collBPPartenaires = null;
        $this->collMROCentres = null;
        $this->collMROSocietes = null;
        $this->collFournisseurs = null;
        $this->collCommandes = null;
        $this->collSocieteappareils = null;
        $this->collContacts = null;
        $this->collSocietecertificats = null;
        $this->collSocietemetiers = null;
        $this->collSocietetypepieces = null;
        $this->collSocietehistoriques = null;
        $this->collFinancieres = null;
        $this->collChiffredaffaires = null;
        $this->collWebsources = null;
        $this->aMPays = null;
        $this->aMarque = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SocieteTableMap::DEFAULT_STRING_FORMAT);
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
