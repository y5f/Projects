<?php

namespace Map;

use \CMDPiece;
use \CMDPieceQuery;
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
 * This class defines the structure of the 'piece_cmd' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CMDPieceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CMDPieceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'appliaviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'piece_cmd';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CMDPiece';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CMDPiece';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id_commande_FK field
     */
    const COL_ID_COMMANDE_FK = 'piece_cmd.id_commande_FK';

    /**
     * the column name for the pc_id field
     */
    const COL_PC_ID = 'piece_cmd.pc_id';

    /**
     * the column name for the pn_clt field
     */
    const COL_PN_CLT = 'piece_cmd.pn_clt';

    /**
     * the column name for the quantite field
     */
    const COL_QUANTITE = 'piece_cmd.quantite';

    /**
     * the column name for the prix_clt field
     */
    const COL_PRIX_CLT = 'piece_cmd.prix_clt';

    /**
     * the column name for the note_pce field
     */
    const COL_NOTE_PCE = 'piece_cmd.note_pce';

    /**
     * the column name for the delai field
     */
    const COL_DELAI = 'piece_cmd.delai';

    /**
     * the column name for the dte_propos field
     */
    const COL_DTE_PROPOS = 'piece_cmd.dte_propos';

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
        self::TYPE_PHPNAME       => array('IDCommande_FK', 'IDPiece', 'PNClient', 'Quantite', 'CPrix', 'PCENote', 'ADelai', 'DTEProposition', ),
        self::TYPE_CAMELNAME     => array('iDCommande_FK', 'iDPiece', 'pNClient', 'quantite', 'cPrix', 'pCENote', 'aDelai', 'dTEProposition', ),
        self::TYPE_COLNAME       => array(CMDPieceTableMap::COL_ID_COMMANDE_FK, CMDPieceTableMap::COL_PC_ID, CMDPieceTableMap::COL_PN_CLT, CMDPieceTableMap::COL_QUANTITE, CMDPieceTableMap::COL_PRIX_CLT, CMDPieceTableMap::COL_NOTE_PCE, CMDPieceTableMap::COL_DELAI, CMDPieceTableMap::COL_DTE_PROPOS, ),
        self::TYPE_FIELDNAME     => array('id_commande_FK', 'pc_id', 'pn_clt', 'quantite', 'prix_clt', 'note_pce', 'delai', 'dte_propos', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IDCommande_FK' => 0, 'IDPiece' => 1, 'PNClient' => 2, 'Quantite' => 3, 'CPrix' => 4, 'PCENote' => 5, 'ADelai' => 6, 'DTEProposition' => 7, ),
        self::TYPE_CAMELNAME     => array('iDCommande_FK' => 0, 'iDPiece' => 1, 'pNClient' => 2, 'quantite' => 3, 'cPrix' => 4, 'pCENote' => 5, 'aDelai' => 6, 'dTEProposition' => 7, ),
        self::TYPE_COLNAME       => array(CMDPieceTableMap::COL_ID_COMMANDE_FK => 0, CMDPieceTableMap::COL_PC_ID => 1, CMDPieceTableMap::COL_PN_CLT => 2, CMDPieceTableMap::COL_QUANTITE => 3, CMDPieceTableMap::COL_PRIX_CLT => 4, CMDPieceTableMap::COL_NOTE_PCE => 5, CMDPieceTableMap::COL_DELAI => 6, CMDPieceTableMap::COL_DTE_PROPOS => 7, ),
        self::TYPE_FIELDNAME     => array('id_commande_FK' => 0, 'pc_id' => 1, 'pn_clt' => 2, 'quantite' => 3, 'prix_clt' => 4, 'note_pce' => 5, 'delai' => 6, 'dte_propos' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('piece_cmd');
        $this->setPhpName('CMDPiece');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\CMDPiece');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id_commande_FK', 'IDCommande_FK', 'INTEGER' , 'commande', 'id_commande', true, null, null);
        $this->addForeignPrimaryKey('pc_id', 'IDPiece', 'INTEGER' , 'piece', 'id', true, null, null);
        $this->addColumn('pn_clt', 'PNClient', 'VARCHAR', false, 80, null);
        $this->addColumn('quantite', 'Quantite', 'INTEGER', false, null, null);
        $this->addColumn('prix_clt', 'CPrix', 'VARCHAR', false, 25, null);
        $this->addColumn('note_pce', 'PCENote', 'LONGVARCHAR', false, null, null);
        $this->addColumn('delai', 'ADelai', 'NUMERIC', false, null, null);
        $this->addColumn('dte_propos', 'DTEProposition', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Commande', '\\Commande', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_commande_FK',
    1 => ':id_commande',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Piece', '\\Piece', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':pc_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \CMDPiece $obj A \CMDPiece object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getIDCommande_FK(), (string) $obj->getIDPiece()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \CMDPiece object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \CMDPiece) {
                $key = serialize(array((string) $value->getIDCommande_FK(), (string) $value->getIDPiece()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \CMDPiece object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IDCommande_FK', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IDPiece', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IDCommande_FK', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IDPiece', TableMap::TYPE_PHPNAME, $indexType)]));
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IDCommande_FK', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('IDPiece', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? CMDPieceTableMap::CLASS_DEFAULT : CMDPieceTableMap::OM_CLASS;
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
     * @return array           (CMDPiece object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CMDPieceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CMDPieceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CMDPieceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CMDPieceTableMap::OM_CLASS;
            /** @var CMDPiece $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CMDPieceTableMap::addInstanceToPool($obj, $key);
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
            $key = CMDPieceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CMDPieceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CMDPiece $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CMDPieceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CMDPieceTableMap::COL_ID_COMMANDE_FK);
            $criteria->addSelectColumn(CMDPieceTableMap::COL_PC_ID);
            $criteria->addSelectColumn(CMDPieceTableMap::COL_PN_CLT);
            $criteria->addSelectColumn(CMDPieceTableMap::COL_QUANTITE);
            $criteria->addSelectColumn(CMDPieceTableMap::COL_PRIX_CLT);
            $criteria->addSelectColumn(CMDPieceTableMap::COL_NOTE_PCE);
            $criteria->addSelectColumn(CMDPieceTableMap::COL_DELAI);
            $criteria->addSelectColumn(CMDPieceTableMap::COL_DTE_PROPOS);
        } else {
            $criteria->addSelectColumn($alias . '.id_commande_FK');
            $criteria->addSelectColumn($alias . '.pc_id');
            $criteria->addSelectColumn($alias . '.pn_clt');
            $criteria->addSelectColumn($alias . '.quantite');
            $criteria->addSelectColumn($alias . '.prix_clt');
            $criteria->addSelectColumn($alias . '.note_pce');
            $criteria->addSelectColumn($alias . '.delai');
            $criteria->addSelectColumn($alias . '.dte_propos');
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
        return Propel::getServiceContainer()->getDatabaseMap(CMDPieceTableMap::DATABASE_NAME)->getTable(CMDPieceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CMDPieceTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CMDPieceTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CMDPieceTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CMDPiece or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CMDPiece object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CMDPieceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CMDPiece) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CMDPieceTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(CMDPieceTableMap::COL_ID_COMMANDE_FK, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(CMDPieceTableMap::COL_PC_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = CMDPieceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CMDPieceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CMDPieceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the piece_cmd table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CMDPieceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CMDPiece or Criteria object.
     *
     * @param mixed               $criteria Criteria or CMDPiece object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CMDPieceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CMDPiece object
        }


        // Set the correct dbName
        $query = CMDPieceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CMDPieceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CMDPieceTableMap::buildTableMap();
