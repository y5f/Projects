<?php

namespace Map;

use \Societe;
use \SocieteQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'societe' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SocieteTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SocieteTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'appliaviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'societe';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Societe';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Societe';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 21;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 21;

    /**
     * the column name for the soc_id field
     */
    const COL_SOC_ID = 'societe.soc_id';

    /**
     * the column name for the societe field
     */
    const COL_SOCIETE = 'societe.societe';

    /**
     * the column name for the dirigeant field
     */
    const COL_DIRIGEANT = 'societe.dirigeant';

    /**
     * the column name for the mail field
     */
    const COL_MAIL = 'societe.mail';

    /**
     * the column name for the website field
     */
    const COL_WEBSITE = 'societe.website';

    /**
     * the column name for the tel field
     */
    const COL_TEL = 'societe.tel';

    /**
     * the column name for the fax field
     */
    const COL_FAX = 'societe.fax';

    /**
     * the column name for the adresse field
     */
    const COL_ADRESSE = 'societe.adresse';

    /**
     * the column name for the cp field
     */
    const COL_CP = 'societe.cp';

    /**
     * the column name for the ville field
     */
    const COL_VILLE = 'societe.ville';

    /**
     * the column name for the pays field
     */
    const COL_PAYS = 'societe.pays';

    /**
     * the column name for the notes field
     */
    const COL_NOTES = 'societe.notes';

    /**
     * the column name for the notes_activite field
     */
    const COL_NOTES_ACTIVITE = 'societe.notes_activite';

    /**
     * the column name for the scrRIB field
     */
    const COL_SCRRIB = 'societe.scrRIB';

    /**
     * the column name for the fabricant field
     */
    const COL_FABRICANT = 'societe.fabricant';

    /**
     * the column name for the logo field
     */
    const COL_LOGO = 'societe.logo';

    /**
     * the column name for the fraude field
     */
    const COL_FRAUDE = 'societe.fraude';

    /**
     * the column name for the dte_maj_soc field
     */
    const COL_DTE_MAJ_SOC = 'societe.dte_maj_soc';

    /**
     * the column name for the dte_maj_act field
     */
    const COL_DTE_MAJ_ACT = 'societe.dte_maj_act';

    /**
     * the column name for the dte_maj_gen field
     */
    const COL_DTE_MAJ_GEN = 'societe.dte_maj_gen';

    /**
     * the column name for the actif field
     */
    const COL_ACTIF = 'societe.actif';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('ID', 'Societe', 'Dirigeant', 'Email', 'Website', 'Telephone', 'Fax', 'Adresses', 'CP', 'Ville', 'Pays', 'Notes', 'Notesactivite', 'SourceRIB', 'Fabricant', 'Logo', 'isFraude', 'DateMAJSOC', 'Dte_MAJACT', 'Dte_MAJGEN', 'isACTIF', ),
        self::TYPE_CAMELNAME     => array('iD', 'societe', 'dirigeant', 'email', 'website', 'telephone', 'fax', 'adresses', 'cP', 'ville', 'pays', 'notes', 'notesactivite', 'sourceRIB', 'fabricant', 'logo', 'isFraude', 'dateMAJSOC', 'dte_MAJACT', 'dte_MAJGEN', 'isACTIF', ),
        self::TYPE_COLNAME       => array(SocieteTableMap::COL_SOC_ID, SocieteTableMap::COL_SOCIETE, SocieteTableMap::COL_DIRIGEANT, SocieteTableMap::COL_MAIL, SocieteTableMap::COL_WEBSITE, SocieteTableMap::COL_TEL, SocieteTableMap::COL_FAX, SocieteTableMap::COL_ADRESSE, SocieteTableMap::COL_CP, SocieteTableMap::COL_VILLE, SocieteTableMap::COL_PAYS, SocieteTableMap::COL_NOTES, SocieteTableMap::COL_NOTES_ACTIVITE, SocieteTableMap::COL_SCRRIB, SocieteTableMap::COL_FABRICANT, SocieteTableMap::COL_LOGO, SocieteTableMap::COL_FRAUDE, SocieteTableMap::COL_DTE_MAJ_SOC, SocieteTableMap::COL_DTE_MAJ_ACT, SocieteTableMap::COL_DTE_MAJ_GEN, SocieteTableMap::COL_ACTIF, ),
        self::TYPE_FIELDNAME     => array('soc_id', 'societe', 'dirigeant', 'mail', 'website', 'tel', 'fax', 'adresse', 'cp', 'ville', 'pays', 'notes', 'notes_activite', 'scrRIB', 'fabricant', 'logo', 'fraude', 'dte_maj_soc', 'dte_maj_act', 'dte_maj_gen', 'actif', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'Societe' => 1, 'Dirigeant' => 2, 'Email' => 3, 'Website' => 4, 'Telephone' => 5, 'Fax' => 6, 'Adresses' => 7, 'CP' => 8, 'Ville' => 9, 'Pays' => 10, 'Notes' => 11, 'Notesactivite' => 12, 'SourceRIB' => 13, 'Fabricant' => 14, 'Logo' => 15, 'isFraude' => 16, 'DateMAJSOC' => 17, 'Dte_MAJACT' => 18, 'Dte_MAJGEN' => 19, 'isACTIF' => 20, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'societe' => 1, 'dirigeant' => 2, 'email' => 3, 'website' => 4, 'telephone' => 5, 'fax' => 6, 'adresses' => 7, 'cP' => 8, 'ville' => 9, 'pays' => 10, 'notes' => 11, 'notesactivite' => 12, 'sourceRIB' => 13, 'fabricant' => 14, 'logo' => 15, 'isFraude' => 16, 'dateMAJSOC' => 17, 'dte_MAJACT' => 18, 'dte_MAJGEN' => 19, 'isACTIF' => 20, ),
        self::TYPE_COLNAME       => array(SocieteTableMap::COL_SOC_ID => 0, SocieteTableMap::COL_SOCIETE => 1, SocieteTableMap::COL_DIRIGEANT => 2, SocieteTableMap::COL_MAIL => 3, SocieteTableMap::COL_WEBSITE => 4, SocieteTableMap::COL_TEL => 5, SocieteTableMap::COL_FAX => 6, SocieteTableMap::COL_ADRESSE => 7, SocieteTableMap::COL_CP => 8, SocieteTableMap::COL_VILLE => 9, SocieteTableMap::COL_PAYS => 10, SocieteTableMap::COL_NOTES => 11, SocieteTableMap::COL_NOTES_ACTIVITE => 12, SocieteTableMap::COL_SCRRIB => 13, SocieteTableMap::COL_FABRICANT => 14, SocieteTableMap::COL_LOGO => 15, SocieteTableMap::COL_FRAUDE => 16, SocieteTableMap::COL_DTE_MAJ_SOC => 17, SocieteTableMap::COL_DTE_MAJ_ACT => 18, SocieteTableMap::COL_DTE_MAJ_GEN => 19, SocieteTableMap::COL_ACTIF => 20, ),
        self::TYPE_FIELDNAME     => array('soc_id' => 0, 'societe' => 1, 'dirigeant' => 2, 'mail' => 3, 'website' => 4, 'tel' => 5, 'fax' => 6, 'adresse' => 7, 'cp' => 8, 'ville' => 9, 'pays' => 10, 'notes' => 11, 'notes_activite' => 12, 'scrRIB' => 13, 'fabricant' => 14, 'logo' => 15, 'fraude' => 16, 'dte_maj_soc' => 17, 'dte_maj_act' => 18, 'dte_maj_gen' => 19, 'actif' => 20, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('societe');
        $this->setPhpName('Societe');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Societe');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('soc_id', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('societe', 'Societe', 'VARCHAR', false, 80, null);
        $this->addColumn('dirigeant', 'Dirigeant', 'VARCHAR', false, 80, null);
        $this->addColumn('mail', 'Email', 'VARCHAR', false, 100, null);
        $this->addColumn('website', 'Website', 'VARCHAR', false, 100, null);
        $this->addColumn('tel', 'Telephone', 'VARCHAR', false, 25, null);
        $this->addColumn('fax', 'Fax', 'VARCHAR', false, 25, null);
        $this->addColumn('adresse', 'Adresses', 'VARCHAR', false, 200, null);
        $this->addColumn('cp', 'CP', 'VARCHAR', false, 20, null);
        $this->addColumn('ville', 'Ville', 'VARCHAR', false, 25, null);
        $this->addForeignKey('pays', 'Pays', 'VARCHAR', 'pays', 'pays', false, 25, null);
        $this->addColumn('notes', 'Notes', 'LONGVARCHAR', false, null, null);
        $this->addColumn('notes_activite', 'Notesactivite', 'LONGVARCHAR', false, null, null);
        $this->addColumn('scrRIB', 'SourceRIB', 'VARCHAR', false, 200, null);
        $this->addForeignKey('fabricant', 'Fabricant', 'VARCHAR', 'marque', 'marque', false, 100, null);
        $this->addColumn('logo', 'Logo', 'VARCHAR', false, 200, null);
        $this->addColumn('fraude', 'isFraude', 'BOOLEAN', false, 1, null);
        $this->addColumn('dte_maj_soc', 'DateMAJSOC', 'TIMESTAMP', false, null, null);
        $this->addColumn('dte_maj_act', 'Dte_MAJACT', 'TIMESTAMP', false, null, null);
        $this->addColumn('dte_maj_gen', 'Dte_MAJGEN', 'TIMESTAMP', false, null, null);
        $this->addColumn('actif', 'isACTIF', 'BOOLEAN', false, 1, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('MPays', '\\MPays', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':pays',
    1 => ':pays',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Marque', '\\Marque', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':fabricant',
    1 => ':marque',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('BFPartenaire', '\\SPartenaire', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':soc_fraude',
    1 => ':soc_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('BPPartenaire', '\\SPartenaire', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':plaig_soc',
    1 => ':soc_id',
  ),
), 'CASCADE', 'CASCADE', 'BPPartenaires', false);
        $this->addRelation('MROCentre', '\\MROCentre', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_FK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'MROCentres', false);
        $this->addRelation('MROSociete', '\\MROCentre', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':mro',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'MROSocietes', false);
        $this->addRelation('Fournisseur', '\\Fournisseur', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':soc_id_FK',
    1 => ':soc_id',
  ),
), 'CASCADE', 'CASCADE', 'Fournisseurs', false);
        $this->addRelation('Commande', '\\Commande', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':soc_id_FK',
    1 => ':soc_id',
  ),
), 'CASCADE', 'CASCADE', 'Commandes', false);
        $this->addRelation('Societeappareil', '\\Societeappareil', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_FK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Societeappareils', false);
        $this->addRelation('Contact', '\\Contact', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_FK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Contacts', false);
        $this->addRelation('Societecertificat', '\\Societecertificat', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_PK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Societecertificats', false);
        $this->addRelation('Societemetier', '\\Societemetier', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_PK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Societemetiers', false);
        $this->addRelation('Societetypepiece', '\\Societetypepiece', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_PK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Societetypepieces', false);
        $this->addRelation('Societehistorique', '\\Societehistorique', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_PK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Societehistoriques', false);
        $this->addRelation('Financiere', '\\Financiere', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_FK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Financieres', false);
        $this->addRelation('Chiffredaffaire', '\\Chiffredaffaire', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_FK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Chiffredaffaires', false);
        $this->addRelation('Websource', '\\Websource', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':societe_FK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', 'Websources', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to societe     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SPartenaireTableMap::clearInstancePool();
        MROCentreTableMap::clearInstancePool();
        FournisseurTableMap::clearInstancePool();
        CommandeTableMap::clearInstancePool();
        SocieteappareilTableMap::clearInstancePool();
        ContactTableMap::clearInstancePool();
        SocietecertificatTableMap::clearInstancePool();
        SocietemetierTableMap::clearInstancePool();
        SocietetypepieceTableMap::clearInstancePool();
        SocietehistoriqueTableMap::clearInstancePool();
        FinanciereTableMap::clearInstancePool();
        ChiffredaffaireTableMap::clearInstancePool();
        WebsourceTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SocieteTableMap::CLASS_DEFAULT : SocieteTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Societe object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SocieteTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SocieteTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SocieteTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SocieteTableMap::OM_CLASS;
            /** @var Societe $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SocieteTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SocieteTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SocieteTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Societe $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SocieteTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SocieteTableMap::COL_SOC_ID);
            $criteria->addSelectColumn(SocieteTableMap::COL_SOCIETE);
            $criteria->addSelectColumn(SocieteTableMap::COL_DIRIGEANT);
            $criteria->addSelectColumn(SocieteTableMap::COL_MAIL);
            $criteria->addSelectColumn(SocieteTableMap::COL_WEBSITE);
            $criteria->addSelectColumn(SocieteTableMap::COL_TEL);
            $criteria->addSelectColumn(SocieteTableMap::COL_FAX);
            $criteria->addSelectColumn(SocieteTableMap::COL_ADRESSE);
            $criteria->addSelectColumn(SocieteTableMap::COL_CP);
            $criteria->addSelectColumn(SocieteTableMap::COL_VILLE);
            $criteria->addSelectColumn(SocieteTableMap::COL_PAYS);
            $criteria->addSelectColumn(SocieteTableMap::COL_NOTES);
            $criteria->addSelectColumn(SocieteTableMap::COL_NOTES_ACTIVITE);
            $criteria->addSelectColumn(SocieteTableMap::COL_SCRRIB);
            $criteria->addSelectColumn(SocieteTableMap::COL_FABRICANT);
            $criteria->addSelectColumn(SocieteTableMap::COL_LOGO);
            $criteria->addSelectColumn(SocieteTableMap::COL_FRAUDE);
            $criteria->addSelectColumn(SocieteTableMap::COL_DTE_MAJ_SOC);
            $criteria->addSelectColumn(SocieteTableMap::COL_DTE_MAJ_ACT);
            $criteria->addSelectColumn(SocieteTableMap::COL_DTE_MAJ_GEN);
            $criteria->addSelectColumn(SocieteTableMap::COL_ACTIF);
        } else {
            $criteria->addSelectColumn($alias . '.soc_id');
            $criteria->addSelectColumn($alias . '.societe');
            $criteria->addSelectColumn($alias . '.dirigeant');
            $criteria->addSelectColumn($alias . '.mail');
            $criteria->addSelectColumn($alias . '.website');
            $criteria->addSelectColumn($alias . '.tel');
            $criteria->addSelectColumn($alias . '.fax');
            $criteria->addSelectColumn($alias . '.adresse');
            $criteria->addSelectColumn($alias . '.cp');
            $criteria->addSelectColumn($alias . '.ville');
            $criteria->addSelectColumn($alias . '.pays');
            $criteria->addSelectColumn($alias . '.notes');
            $criteria->addSelectColumn($alias . '.notes_activite');
            $criteria->addSelectColumn($alias . '.scrRIB');
            $criteria->addSelectColumn($alias . '.fabricant');
            $criteria->addSelectColumn($alias . '.logo');
            $criteria->addSelectColumn($alias . '.fraude');
            $criteria->addSelectColumn($alias . '.dte_maj_soc');
            $criteria->addSelectColumn($alias . '.dte_maj_act');
            $criteria->addSelectColumn($alias . '.dte_maj_gen');
            $criteria->addSelectColumn($alias . '.actif');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SocieteTableMap::DATABASE_NAME)->getTable(SocieteTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SocieteTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SocieteTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SocieteTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Societe or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Societe object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SocieteTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Societe) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SocieteTableMap::DATABASE_NAME);
            $criteria->add(SocieteTableMap::COL_SOC_ID, (array) $values, Criteria::IN);
        }

        $query = SocieteQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SocieteTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SocieteTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the societe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SocieteQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Societe or Criteria object.
     *
     * @param mixed               $criteria Criteria or Societe object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SocieteTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Societe object
        }

        if ($criteria->containsKey(SocieteTableMap::COL_SOC_ID) && $criteria->keyContainsValue(SocieteTableMap::COL_SOC_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SocieteTableMap::COL_SOC_ID.')');
        }


        // Set the correct dbName
        $query = SocieteQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SocieteTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SocieteTableMap::buildTableMap();
