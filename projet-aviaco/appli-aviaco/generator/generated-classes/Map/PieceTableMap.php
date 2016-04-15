<?php

namespace Map;

use \Piece;
use \PieceQuery;
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
 * This class defines the structure of the 'piece' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PieceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PieceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'appliaviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'piece';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Piece';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Piece';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'piece.id';

    /**
     * the column name for the reference field
     */
    const COL_REFERENCE = 'piece.reference';

    /**
     * the column name for the type_FK field
     */
    const COL_TYPE_FK = 'piece.type_FK';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'piece.description';

    /**
     * the column name for the pn field
     */
    const COL_PN = 'piece.pn';

    /**
     * the column name for the alt_pn field
     */
    const COL_ALT_PN = 'piece.alt_pn';

    /**
     * the column name for the otan field
     */
    const COL_OTAN = 'piece.otan';

    /**
     * the column name for the ispaperboard field
     */
    const COL_ISPAPERBOARD = 'piece.ispaperboard';

    /**
     * the column name for the comment field
     */
    const COL_COMMENT = 'piece.comment';

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
        self::TYPE_PHPNAME       => array('ID', 'Reference', 'Type', 'Description', 'PN', 'AltPN', 'Otan', 'ISPaperboard', 'Commentaire', ),
        self::TYPE_CAMELNAME     => array('iD', 'reference', 'type', 'description', 'pN', 'altPN', 'otan', 'iSPaperboard', 'commentaire', ),
        self::TYPE_COLNAME       => array(PieceTableMap::COL_ID, PieceTableMap::COL_REFERENCE, PieceTableMap::COL_TYPE_FK, PieceTableMap::COL_DESCRIPTION, PieceTableMap::COL_PN, PieceTableMap::COL_ALT_PN, PieceTableMap::COL_OTAN, PieceTableMap::COL_ISPAPERBOARD, PieceTableMap::COL_COMMENT, ),
        self::TYPE_FIELDNAME     => array('id', 'reference', 'type_FK', 'description', 'pn', 'alt_pn', 'otan', 'ispaperboard', 'comment', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'Reference' => 1, 'Type' => 2, 'Description' => 3, 'PN' => 4, 'AltPN' => 5, 'Otan' => 6, 'ISPaperboard' => 7, 'Commentaire' => 8, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'reference' => 1, 'type' => 2, 'description' => 3, 'pN' => 4, 'altPN' => 5, 'otan' => 6, 'iSPaperboard' => 7, 'commentaire' => 8, ),
        self::TYPE_COLNAME       => array(PieceTableMap::COL_ID => 0, PieceTableMap::COL_REFERENCE => 1, PieceTableMap::COL_TYPE_FK => 2, PieceTableMap::COL_DESCRIPTION => 3, PieceTableMap::COL_PN => 4, PieceTableMap::COL_ALT_PN => 5, PieceTableMap::COL_OTAN => 6, PieceTableMap::COL_ISPAPERBOARD => 7, PieceTableMap::COL_COMMENT => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'reference' => 1, 'type_FK' => 2, 'description' => 3, 'pn' => 4, 'alt_pn' => 5, 'otan' => 6, 'ispaperboard' => 7, 'comment' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('piece');
        $this->setPhpName('Piece');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Piece');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('reference', 'Reference', 'VARCHAR', false, 100, null);
        $this->addForeignKey('type_FK', 'Type', 'VARCHAR', 'typepiece', 'type', false, 100, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 100, null);
        $this->addColumn('pn', 'PN', 'VARCHAR', false, 80, null);
        $this->addColumn('alt_pn', 'AltPN', 'VARCHAR', false, 80, null);
        $this->addColumn('otan', 'Otan', 'VARCHAR', false, 80, null);
        $this->addColumn('ispaperboard', 'ISPaperboard', 'BOOLEAN', false, 1, null);
        $this->addColumn('comment', 'Commentaire', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Typepiece', '\\Typepiece', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':type_FK',
    1 => ':type',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('PieceApp', '\\PieceApp', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_piece_PK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'PieceApps', false);
        $this->addRelation('Fournisseur', '\\Fournisseur', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_piece_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Fournisseurs', false);
        $this->addRelation('COMCondition', '\\COMCondition', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_piece_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'COMConditions', false);
        $this->addRelation('COMVendeur', '\\COMVendeur', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_piece_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'COMVendeurs', false);
        $this->addRelation('CMDPiece', '\\CMDPiece', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':pc_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'CMDPieces', false);
        $this->addRelation('COMEnduser', '\\COMEnduser', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_piece_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'COMEndusers', false);
        $this->addRelation('CMDTAppareil', '\\CMDTAppareil', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_piece_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'CMDTAppareils', false);
        $this->addRelation('Stock', '\\Stock', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_piece_FK',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Stocks', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to piece     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PieceAppTableMap::clearInstancePool();
        FournisseurTableMap::clearInstancePool();
        COMConditionTableMap::clearInstancePool();
        COMVendeurTableMap::clearInstancePool();
        CMDPieceTableMap::clearInstancePool();
        COMEnduserTableMap::clearInstancePool();
        CMDTAppareilTableMap::clearInstancePool();
        StockTableMap::clearInstancePool();
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
        return $withPrefix ? PieceTableMap::CLASS_DEFAULT : PieceTableMap::OM_CLASS;
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
     * @return array           (Piece object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PieceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PieceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PieceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PieceTableMap::OM_CLASS;
            /** @var Piece $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PieceTableMap::addInstanceToPool($obj, $key);
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
            $key = PieceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PieceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Piece $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PieceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PieceTableMap::COL_ID);
            $criteria->addSelectColumn(PieceTableMap::COL_REFERENCE);
            $criteria->addSelectColumn(PieceTableMap::COL_TYPE_FK);
            $criteria->addSelectColumn(PieceTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(PieceTableMap::COL_PN);
            $criteria->addSelectColumn(PieceTableMap::COL_ALT_PN);
            $criteria->addSelectColumn(PieceTableMap::COL_OTAN);
            $criteria->addSelectColumn(PieceTableMap::COL_ISPAPERBOARD);
            $criteria->addSelectColumn(PieceTableMap::COL_COMMENT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.reference');
            $criteria->addSelectColumn($alias . '.type_FK');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.pn');
            $criteria->addSelectColumn($alias . '.alt_pn');
            $criteria->addSelectColumn($alias . '.otan');
            $criteria->addSelectColumn($alias . '.ispaperboard');
            $criteria->addSelectColumn($alias . '.comment');
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
        return Propel::getServiceContainer()->getDatabaseMap(PieceTableMap::DATABASE_NAME)->getTable(PieceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PieceTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PieceTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PieceTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Piece or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Piece object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PieceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Piece) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PieceTableMap::DATABASE_NAME);
            $criteria->add(PieceTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PieceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PieceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PieceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the piece table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PieceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Piece or Criteria object.
     *
     * @param mixed               $criteria Criteria or Piece object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PieceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Piece object
        }

        if ($criteria->containsKey(PieceTableMap::COL_ID) && $criteria->keyContainsValue(PieceTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PieceTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PieceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PieceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PieceTableMap::buildTableMap();
