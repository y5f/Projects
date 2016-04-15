<?php

namespace Map;

use \Appareil;
use \AppareilQuery;
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
 * This class defines the structure of the 'appareil' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AppareilTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AppareilTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'appareil';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Appareil';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Appareil';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'appareil.id';

    /**
     * the column name for the idAp field
     */
    const COL_IDAP = 'appareil.idAp';

    /**
     * the column name for the nom_app field
     */
    const COL_NOM_APP = 'appareil.nom_app';

    /**
     * the column name for the modele_PK field
     */
    const COL_MODELE_PK = 'appareil.modele_PK';

    /**
     * the column name for the marque_PK field
     */
    const COL_MARQUE_PK = 'appareil.marque_PK';

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
        self::TYPE_PHPNAME       => array('ID', 'IdAppareil', 'NomApp', 'Modele_PK', 'Marque_PK', ),
        self::TYPE_CAMELNAME     => array('iD', 'idAppareil', 'nomApp', 'modele_PK', 'marque_PK', ),
        self::TYPE_COLNAME       => array(AppareilTableMap::COL_ID, AppareilTableMap::COL_IDAP, AppareilTableMap::COL_NOM_APP, AppareilTableMap::COL_MODELE_PK, AppareilTableMap::COL_MARQUE_PK, ),
        self::TYPE_FIELDNAME     => array('id', 'idAp', 'nom_app', 'modele_PK', 'marque_PK', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'IdAppareil' => 1, 'NomApp' => 2, 'Modele_PK' => 3, 'Marque_PK' => 4, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'idAppareil' => 1, 'nomApp' => 2, 'modele_PK' => 3, 'marque_PK' => 4, ),
        self::TYPE_COLNAME       => array(AppareilTableMap::COL_ID => 0, AppareilTableMap::COL_IDAP => 1, AppareilTableMap::COL_NOM_APP => 2, AppareilTableMap::COL_MODELE_PK => 3, AppareilTableMap::COL_MARQUE_PK => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'idAp' => 1, 'nom_app' => 2, 'modele_PK' => 3, 'marque_PK' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('appareil');
        $this->setPhpName('Appareil');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Appareil');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('idAp', 'IdAppareil', 'VARCHAR', false, 100, null);
        $this->addColumn('nom_app', 'NomApp', 'VARCHAR', false, 100, null);
        $this->addForeignPrimaryKey('modele_PK', 'Modele_PK', 'VARCHAR' , 'modele', 'modele', true, 100, null);
        $this->addForeignPrimaryKey('marque_PK', 'Marque_PK', 'VARCHAR' , 'marque', 'marque', true, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Marque', '\\Marque', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':marque_PK',
    1 => ':marque',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Modele', '\\Model', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':modele_PK',
    1 => ':modele',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('PieceApp', '\\PieceApp', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':idAp_PK',
    1 => ':idAp',
  ),
), 'CASCADE', 'CASCADE', 'PieceApps', false);
        $this->addRelation('Photoappareil', '\\Photoappareil', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':idAp_PK',
    1 => ':idAp',
  ),
), 'CASCADE', 'CASCADE', 'Photoappareils', false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Appareil $obj A \Appareil object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getID(), (string) $obj->getModele_PK(), (string) $obj->getMarque_PK()));
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
     * @param mixed $value A \Appareil object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Appareil) {
                $key = serialize(array((string) $value->getID(), (string) $value->getModele_PK(), (string) $value->getMarque_PK()));

            } elseif (is_array($value) && count($value) === 3) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1], (string) $value[2]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Appareil object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }
    /**
     * Method to invalidate the instance pool of all tables related to appareil     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PieceAppTableMap::clearInstancePool();
        PhotoappareilTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('Modele_PK', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('Marque_PK', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 3 + $offset : static::translateFieldName('Modele_PK', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 4 + $offset : static::translateFieldName('Marque_PK', TableMap::TYPE_PHPNAME, $indexType)]));
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
                : self::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 3 + $offset
                : self::translateFieldName('Modele_PK', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 4 + $offset
                : self::translateFieldName('Marque_PK', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AppareilTableMap::CLASS_DEFAULT : AppareilTableMap::OM_CLASS;
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
     * @return array           (Appareil object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AppareilTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AppareilTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AppareilTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AppareilTableMap::OM_CLASS;
            /** @var Appareil $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AppareilTableMap::addInstanceToPool($obj, $key);
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
            $key = AppareilTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AppareilTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Appareil $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AppareilTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AppareilTableMap::COL_ID);
            $criteria->addSelectColumn(AppareilTableMap::COL_IDAP);
            $criteria->addSelectColumn(AppareilTableMap::COL_NOM_APP);
            $criteria->addSelectColumn(AppareilTableMap::COL_MODELE_PK);
            $criteria->addSelectColumn(AppareilTableMap::COL_MARQUE_PK);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.idAp');
            $criteria->addSelectColumn($alias . '.nom_app');
            $criteria->addSelectColumn($alias . '.modele_PK');
            $criteria->addSelectColumn($alias . '.marque_PK');
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
        return Propel::getServiceContainer()->getDatabaseMap(AppareilTableMap::DATABASE_NAME)->getTable(AppareilTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AppareilTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AppareilTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AppareilTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Appareil or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Appareil object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AppareilTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Appareil) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AppareilTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(AppareilTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(AppareilTableMap::COL_MODELE_PK, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(AppareilTableMap::COL_MARQUE_PK, $value[2]));
                $criteria->addOr($criterion);
            }
        }

        $query = AppareilQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AppareilTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AppareilTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the appareil table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AppareilQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Appareil or Criteria object.
     *
     * @param mixed               $criteria Criteria or Appareil object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AppareilTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Appareil object
        }

        if ($criteria->containsKey(AppareilTableMap::COL_ID) && $criteria->keyContainsValue(AppareilTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AppareilTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AppareilQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AppareilTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AppareilTableMap::buildTableMap();
