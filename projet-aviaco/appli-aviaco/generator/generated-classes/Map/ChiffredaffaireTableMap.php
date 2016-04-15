<?php

namespace Map;

use \Chiffredaffaire;
use \ChiffredaffaireQuery;
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
 * This class defines the structure of the 'chiffreaffaire' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ChiffredaffaireTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ChiffredaffaireTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'appliaviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'chiffreaffaire';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Chiffredaffaire';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Chiffredaffaire';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'chiffreaffaire.id';

    /**
     * the column name for the annee field
     */
    const COL_ANNEE = 'chiffreaffaire.annee';

    /**
     * the column name for the ca field
     */
    const COL_CA = 'chiffreaffaire.ca';

    /**
     * the column name for the nbremp field
     */
    const COL_NBREMP = 'chiffreaffaire.nbremp';

    /**
     * the column name for the filiale field
     */
    const COL_FILIALE = 'chiffreaffaire.filiale';

    /**
     * the column name for the societe_FK field
     */
    const COL_SOCIETE_FK = 'chiffreaffaire.societe_FK';

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
        self::TYPE_PHPNAME       => array('ID', 'Annee', 'Chiffre', 'Nbremployes', 'isFiliale', 'societe_FK', ),
        self::TYPE_CAMELNAME     => array('iD', 'annee', 'chiffre', 'nbremployes', 'isFiliale', 'societe_FK', ),
        self::TYPE_COLNAME       => array(ChiffredaffaireTableMap::COL_ID, ChiffredaffaireTableMap::COL_ANNEE, ChiffredaffaireTableMap::COL_CA, ChiffredaffaireTableMap::COL_NBREMP, ChiffredaffaireTableMap::COL_FILIALE, ChiffredaffaireTableMap::COL_SOCIETE_FK, ),
        self::TYPE_FIELDNAME     => array('id', 'annee', 'ca', 'nbremp', 'filiale', 'societe_FK', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'Annee' => 1, 'Chiffre' => 2, 'Nbremployes' => 3, 'isFiliale' => 4, 'societe_FK' => 5, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'annee' => 1, 'chiffre' => 2, 'nbremployes' => 3, 'isFiliale' => 4, 'societe_FK' => 5, ),
        self::TYPE_COLNAME       => array(ChiffredaffaireTableMap::COL_ID => 0, ChiffredaffaireTableMap::COL_ANNEE => 1, ChiffredaffaireTableMap::COL_CA => 2, ChiffredaffaireTableMap::COL_NBREMP => 3, ChiffredaffaireTableMap::COL_FILIALE => 4, ChiffredaffaireTableMap::COL_SOCIETE_FK => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'annee' => 1, 'ca' => 2, 'nbremp' => 3, 'filiale' => 4, 'societe_FK' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('chiffreaffaire');
        $this->setPhpName('Chiffredaffaire');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Chiffredaffaire');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('annee', 'Annee', 'INTEGER', false, 4, null);
        $this->addColumn('ca', 'Chiffre', 'DOUBLE', false, null, null);
        $this->addColumn('nbremp', 'Nbremployes', 'INTEGER', false, null, null);
        $this->addColumn('filiale', 'isFiliale', 'BOOLEAN', false, 1, null);
        $this->addForeignKey('societe_FK', 'societe_FK', 'VARCHAR', 'societe', 'societe', false, 80, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Societe', '\\Societe', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':societe_FK',
    1 => ':societe',
  ),
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

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
        return $withPrefix ? ChiffredaffaireTableMap::CLASS_DEFAULT : ChiffredaffaireTableMap::OM_CLASS;
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
     * @return array           (Chiffredaffaire object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ChiffredaffaireTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ChiffredaffaireTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ChiffredaffaireTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ChiffredaffaireTableMap::OM_CLASS;
            /** @var Chiffredaffaire $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ChiffredaffaireTableMap::addInstanceToPool($obj, $key);
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
            $key = ChiffredaffaireTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ChiffredaffaireTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Chiffredaffaire $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ChiffredaffaireTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ChiffredaffaireTableMap::COL_ID);
            $criteria->addSelectColumn(ChiffredaffaireTableMap::COL_ANNEE);
            $criteria->addSelectColumn(ChiffredaffaireTableMap::COL_CA);
            $criteria->addSelectColumn(ChiffredaffaireTableMap::COL_NBREMP);
            $criteria->addSelectColumn(ChiffredaffaireTableMap::COL_FILIALE);
            $criteria->addSelectColumn(ChiffredaffaireTableMap::COL_SOCIETE_FK);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.annee');
            $criteria->addSelectColumn($alias . '.ca');
            $criteria->addSelectColumn($alias . '.nbremp');
            $criteria->addSelectColumn($alias . '.filiale');
            $criteria->addSelectColumn($alias . '.societe_FK');
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
        return Propel::getServiceContainer()->getDatabaseMap(ChiffredaffaireTableMap::DATABASE_NAME)->getTable(ChiffredaffaireTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ChiffredaffaireTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ChiffredaffaireTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ChiffredaffaireTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Chiffredaffaire or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Chiffredaffaire object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ChiffredaffaireTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Chiffredaffaire) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ChiffredaffaireTableMap::DATABASE_NAME);
            $criteria->add(ChiffredaffaireTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ChiffredaffaireQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ChiffredaffaireTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ChiffredaffaireTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the chiffreaffaire table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ChiffredaffaireQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Chiffredaffaire or Criteria object.
     *
     * @param mixed               $criteria Criteria or Chiffredaffaire object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChiffredaffaireTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Chiffredaffaire object
        }

        if ($criteria->containsKey(ChiffredaffaireTableMap::COL_ID) && $criteria->keyContainsValue(ChiffredaffaireTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ChiffredaffaireTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ChiffredaffaireQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ChiffredaffaireTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ChiffredaffaireTableMap::buildTableMap();
