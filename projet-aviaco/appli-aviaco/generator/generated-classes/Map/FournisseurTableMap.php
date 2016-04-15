<?php

namespace Map;

use \Fournisseur;
use \FournisseurQuery;
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
 * This class defines the structure of the 'fournisseur' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FournisseurTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.FournisseurTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'appliaviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fournisseur';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Fournisseur';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Fournisseur';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 19;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 19;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fournisseur.id';

    /**
     * the column name for the quantite field
     */
    const COL_QUANTITE = 'fournisseur.quantite';

    /**
     * the column name for the prix_achat field
     */
    const COL_PRIX_ACHAT = 'fournisseur.prix_achat';

    /**
     * the column name for the prix_vente field
     */
    const COL_PRIX_VENTE = 'fournisseur.prix_vente';

    /**
     * the column name for the date_enreg field
     */
    const COL_DATE_ENREG = 'fournisseur.date_enreg';

    /**
     * the column name for the production field
     */
    const COL_PRODUCTION = 'fournisseur.production';

    /**
     * the column name for the delai field
     */
    const COL_DELAI = 'fournisseur.delai';

    /**
     * the column name for the id_piece_FK field
     */
    const COL_ID_PIECE_FK = 'fournisseur.id_piece_FK';

    /**
     * the column name for the condition_FK field
     */
    const COL_CONDITION_FK = 'fournisseur.condition_FK';

    /**
     * the column name for the transport_FK field
     */
    const COL_TRANSPORT_FK = 'fournisseur.transport_FK';

    /**
     * the column name for the soc_id_FK field
     */
    const COL_SOC_ID_FK = 'fournisseur.soc_id_FK';

    /**
     * the column name for the annee_fab field
     */
    const COL_ANNEE_FAB = 'fournisseur.annee_fab';

    /**
     * the column name for the tmp_rest field
     */
    const COL_TMP_REST = 'fournisseur.tmp_rest';

    /**
     * the column name for the tmp_total field
     */
    const COL_TMP_TOTAL = 'fournisseur.tmp_total';

    /**
     * the column name for the duree_vie field
     */
    const COL_DUREE_VIE = 'fournisseur.duree_vie';

    /**
     * the column name for the old_app field
     */
    const COL_OLD_APP = 'fournisseur.old_app';

    /**
     * the column name for the new_app field
     */
    const COL_NEW_APP = 'fournisseur.new_app';

    /**
     * the column name for the nbr_oh field
     */
    const COL_NBR_OH = 'fournisseur.nbr_oh';

    /**
     * the column name for the note field
     */
    const COL_NOTE = 'fournisseur.note';

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
        self::TYPE_PHPNAME       => array('ID', 'Quantite', 'Prixachat', 'Prixvente', 'DTESave', 'isProd', 'Delai', 'IDPiece_PK', 'VCondition', 'TMode', 'IDSoc_FK', 'FABAnnee', 'TRestant', 'TTotal', 'DVie', 'OLDApp', 'NApp', 'NBROh', 'Note', ),
        self::TYPE_CAMELNAME     => array('iD', 'quantite', 'prixachat', 'prixvente', 'dTESave', 'isProd', 'delai', 'iDPiece_PK', 'vCondition', 'tMode', 'iDSoc_FK', 'fABAnnee', 'tRestant', 'tTotal', 'dVie', 'oLDApp', 'nApp', 'nBROh', 'note', ),
        self::TYPE_COLNAME       => array(FournisseurTableMap::COL_ID, FournisseurTableMap::COL_QUANTITE, FournisseurTableMap::COL_PRIX_ACHAT, FournisseurTableMap::COL_PRIX_VENTE, FournisseurTableMap::COL_DATE_ENREG, FournisseurTableMap::COL_PRODUCTION, FournisseurTableMap::COL_DELAI, FournisseurTableMap::COL_ID_PIECE_FK, FournisseurTableMap::COL_CONDITION_FK, FournisseurTableMap::COL_TRANSPORT_FK, FournisseurTableMap::COL_SOC_ID_FK, FournisseurTableMap::COL_ANNEE_FAB, FournisseurTableMap::COL_TMP_REST, FournisseurTableMap::COL_TMP_TOTAL, FournisseurTableMap::COL_DUREE_VIE, FournisseurTableMap::COL_OLD_APP, FournisseurTableMap::COL_NEW_APP, FournisseurTableMap::COL_NBR_OH, FournisseurTableMap::COL_NOTE, ),
        self::TYPE_FIELDNAME     => array('id', 'quantite', 'prix_achat', 'prix_vente', 'date_enreg', 'production', 'delai', 'id_piece_FK', 'condition_FK', 'transport_FK', 'soc_id_FK', 'annee_fab', 'tmp_rest', 'tmp_total', 'duree_vie', 'old_app', 'new_app', 'nbr_oh', 'note', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'Quantite' => 1, 'Prixachat' => 2, 'Prixvente' => 3, 'DTESave' => 4, 'isProd' => 5, 'Delai' => 6, 'IDPiece_PK' => 7, 'VCondition' => 8, 'TMode' => 9, 'IDSoc_FK' => 10, 'FABAnnee' => 11, 'TRestant' => 12, 'TTotal' => 13, 'DVie' => 14, 'OLDApp' => 15, 'NApp' => 16, 'NBROh' => 17, 'Note' => 18, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'quantite' => 1, 'prixachat' => 2, 'prixvente' => 3, 'dTESave' => 4, 'isProd' => 5, 'delai' => 6, 'iDPiece_PK' => 7, 'vCondition' => 8, 'tMode' => 9, 'iDSoc_FK' => 10, 'fABAnnee' => 11, 'tRestant' => 12, 'tTotal' => 13, 'dVie' => 14, 'oLDApp' => 15, 'nApp' => 16, 'nBROh' => 17, 'note' => 18, ),
        self::TYPE_COLNAME       => array(FournisseurTableMap::COL_ID => 0, FournisseurTableMap::COL_QUANTITE => 1, FournisseurTableMap::COL_PRIX_ACHAT => 2, FournisseurTableMap::COL_PRIX_VENTE => 3, FournisseurTableMap::COL_DATE_ENREG => 4, FournisseurTableMap::COL_PRODUCTION => 5, FournisseurTableMap::COL_DELAI => 6, FournisseurTableMap::COL_ID_PIECE_FK => 7, FournisseurTableMap::COL_CONDITION_FK => 8, FournisseurTableMap::COL_TRANSPORT_FK => 9, FournisseurTableMap::COL_SOC_ID_FK => 10, FournisseurTableMap::COL_ANNEE_FAB => 11, FournisseurTableMap::COL_TMP_REST => 12, FournisseurTableMap::COL_TMP_TOTAL => 13, FournisseurTableMap::COL_DUREE_VIE => 14, FournisseurTableMap::COL_OLD_APP => 15, FournisseurTableMap::COL_NEW_APP => 16, FournisseurTableMap::COL_NBR_OH => 17, FournisseurTableMap::COL_NOTE => 18, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'quantite' => 1, 'prix_achat' => 2, 'prix_vente' => 3, 'date_enreg' => 4, 'production' => 5, 'delai' => 6, 'id_piece_FK' => 7, 'condition_FK' => 8, 'transport_FK' => 9, 'soc_id_FK' => 10, 'annee_fab' => 11, 'tmp_rest' => 12, 'tmp_total' => 13, 'duree_vie' => 14, 'old_app' => 15, 'new_app' => 16, 'nbr_oh' => 17, 'note' => 18, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
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
        $this->setName('fournisseur');
        $this->setPhpName('Fournisseur');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Fournisseur');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('quantite', 'Quantite', 'INTEGER', false, null, null);
        $this->addColumn('prix_achat', 'Prixachat', 'VARCHAR', false, 25, null);
        $this->addColumn('prix_vente', 'Prixvente', 'VARCHAR', false, 25, null);
        $this->addColumn('date_enreg', 'DTESave', 'TIMESTAMP', false, null, null);
        $this->addColumn('production', 'isProd', 'BOOLEAN', false, 1, null);
        $this->addColumn('delai', 'Delai', 'VARCHAR', false, 15, null);
        $this->addForeignKey('id_piece_FK', 'IDPiece_PK', 'INTEGER', 'piece', 'id', false, null, null);
        $this->addForeignKey('condition_FK', 'VCondition', 'VARCHAR', 'cond', 'cond', false, 10, null);
        $this->addForeignKey('transport_FK', 'TMode', 'VARCHAR', 'transport', 'transport', false, 25, null);
        $this->addForeignKey('soc_id_FK', 'IDSoc_FK', 'INTEGER', 'societe', 'soc_id', false, null, null);
        $this->addColumn('annee_fab', 'FABAnnee', 'VARCHAR', false, 10, null);
        $this->addColumn('tmp_rest', 'TRestant', 'VARCHAR', false, 10, null);
        $this->addColumn('tmp_total', 'TTotal', 'VARCHAR', false, 10, null);
        $this->addColumn('duree_vie', 'DVie', 'VARCHAR', false, 10, null);
        $this->addColumn('old_app', 'OLDApp', 'VARCHAR', false, 80, null);
        $this->addColumn('new_app', 'NApp', 'VARCHAR', false, 80, null);
        $this->addColumn('nbr_oh', 'NBROh', 'VARCHAR', false, 10, null);
        $this->addColumn('note', 'Note', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Piece', '\\Piece', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_piece_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Societe', '\\Societe', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':soc_id_FK',
    1 => ':soc_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Condition', '\\Condition', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':condition_FK',
    1 => ':cond',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('MTransport', '\\MTransport', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':transport_FK',
    1 => ':transport',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('COMVendeur', '\\COMVendeur', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':frs_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'COMVendeurs', false);
        $this->addRelation('Doc', '\\Document', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_fournisseur_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Docs', false);
        $this->addRelation('Photopiece', '\\Photopiece', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_fournisseur_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Photopieces', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to fournisseur     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        COMVendeurTableMap::clearInstancePool();
        DocumentTableMap::clearInstancePool();
        PhotopieceTableMap::clearInstancePool();
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
        return $withPrefix ? FournisseurTableMap::CLASS_DEFAULT : FournisseurTableMap::OM_CLASS;
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
     * @return array           (Fournisseur object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FournisseurTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FournisseurTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FournisseurTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FournisseurTableMap::OM_CLASS;
            /** @var Fournisseur $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FournisseurTableMap::addInstanceToPool($obj, $key);
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
            $key = FournisseurTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FournisseurTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Fournisseur $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FournisseurTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FournisseurTableMap::COL_ID);
            $criteria->addSelectColumn(FournisseurTableMap::COL_QUANTITE);
            $criteria->addSelectColumn(FournisseurTableMap::COL_PRIX_ACHAT);
            $criteria->addSelectColumn(FournisseurTableMap::COL_PRIX_VENTE);
            $criteria->addSelectColumn(FournisseurTableMap::COL_DATE_ENREG);
            $criteria->addSelectColumn(FournisseurTableMap::COL_PRODUCTION);
            $criteria->addSelectColumn(FournisseurTableMap::COL_DELAI);
            $criteria->addSelectColumn(FournisseurTableMap::COL_ID_PIECE_FK);
            $criteria->addSelectColumn(FournisseurTableMap::COL_CONDITION_FK);
            $criteria->addSelectColumn(FournisseurTableMap::COL_TRANSPORT_FK);
            $criteria->addSelectColumn(FournisseurTableMap::COL_SOC_ID_FK);
            $criteria->addSelectColumn(FournisseurTableMap::COL_ANNEE_FAB);
            $criteria->addSelectColumn(FournisseurTableMap::COL_TMP_REST);
            $criteria->addSelectColumn(FournisseurTableMap::COL_TMP_TOTAL);
            $criteria->addSelectColumn(FournisseurTableMap::COL_DUREE_VIE);
            $criteria->addSelectColumn(FournisseurTableMap::COL_OLD_APP);
            $criteria->addSelectColumn(FournisseurTableMap::COL_NEW_APP);
            $criteria->addSelectColumn(FournisseurTableMap::COL_NBR_OH);
            $criteria->addSelectColumn(FournisseurTableMap::COL_NOTE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.quantite');
            $criteria->addSelectColumn($alias . '.prix_achat');
            $criteria->addSelectColumn($alias . '.prix_vente');
            $criteria->addSelectColumn($alias . '.date_enreg');
            $criteria->addSelectColumn($alias . '.production');
            $criteria->addSelectColumn($alias . '.delai');
            $criteria->addSelectColumn($alias . '.id_piece_FK');
            $criteria->addSelectColumn($alias . '.condition_FK');
            $criteria->addSelectColumn($alias . '.transport_FK');
            $criteria->addSelectColumn($alias . '.soc_id_FK');
            $criteria->addSelectColumn($alias . '.annee_fab');
            $criteria->addSelectColumn($alias . '.tmp_rest');
            $criteria->addSelectColumn($alias . '.tmp_total');
            $criteria->addSelectColumn($alias . '.duree_vie');
            $criteria->addSelectColumn($alias . '.old_app');
            $criteria->addSelectColumn($alias . '.new_app');
            $criteria->addSelectColumn($alias . '.nbr_oh');
            $criteria->addSelectColumn($alias . '.note');
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
        return Propel::getServiceContainer()->getDatabaseMap(FournisseurTableMap::DATABASE_NAME)->getTable(FournisseurTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FournisseurTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FournisseurTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FournisseurTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Fournisseur or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Fournisseur object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FournisseurTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Fournisseur) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FournisseurTableMap::DATABASE_NAME);
            $criteria->add(FournisseurTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FournisseurQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FournisseurTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FournisseurTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fournisseur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FournisseurQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Fournisseur or Criteria object.
     *
     * @param mixed               $criteria Criteria or Fournisseur object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FournisseurTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Fournisseur object
        }

        if ($criteria->containsKey(FournisseurTableMap::COL_ID) && $criteria->keyContainsValue(FournisseurTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FournisseurTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FournisseurQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FournisseurTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FournisseurTableMap::buildTableMap();
