<?php

namespace Map;

use \Photoappareil;
use \PhotoappareilQuery;
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
 * This class defines the structure of the 'photo_appareil' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PhotoappareilTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PhotoappareilTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'photo_appareil';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Photoappareil';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Photoappareil';

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
    const COL_ID = 'photo_appareil.id';

    /**
     * the column name for the url_photo field
     */
    const COL_URL_PHOTO = 'photo_appareil.url_photo';

    /**
     * the column name for the date_photo field
     */
    const COL_DATE_PHOTO = 'photo_appareil.date_photo';

    /**
     * the column name for the titre_photo field
     */
    const COL_TITRE_PHOTO = 'photo_appareil.titre_photo';

    /**
     * the column name for the commentaire field
     */
    const COL_COMMENTAIRE = 'photo_appareil.commentaire';

    /**
     * the column name for the etat field
     */
    const COL_ETAT = 'photo_appareil.etat';

    /**
     * the column name for the idAp_PK field
     */
    const COL_IDAP_PK = 'photo_appareil.idAp_PK';

    /**
     * the column name for the modele_PK field
     */
    const COL_MODELE_PK = 'photo_appareil.modele_PK';

    /**
     * the column name for the marque_PK field
     */
    const COL_MARQUE_PK = 'photo_appareil.marque_PK';

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
        self::TYPE_PHPNAME       => array('ID', 'Photo', 'Datephoto', 'Titre', 'Commentaire', 'Etat', 'IdAp_PK', 'modele_PK', 'marque_PK', ),
        self::TYPE_CAMELNAME     => array('iD', 'photo', 'datephoto', 'titre', 'commentaire', 'etat', 'idAp_PK', 'modele_PK', 'marque_PK', ),
        self::TYPE_COLNAME       => array(PhotoappareilTableMap::COL_ID, PhotoappareilTableMap::COL_URL_PHOTO, PhotoappareilTableMap::COL_DATE_PHOTO, PhotoappareilTableMap::COL_TITRE_PHOTO, PhotoappareilTableMap::COL_COMMENTAIRE, PhotoappareilTableMap::COL_ETAT, PhotoappareilTableMap::COL_IDAP_PK, PhotoappareilTableMap::COL_MODELE_PK, PhotoappareilTableMap::COL_MARQUE_PK, ),
        self::TYPE_FIELDNAME     => array('id', 'url_photo', 'date_photo', 'titre_photo', 'commentaire', 'etat', 'idAp_PK', 'modele_PK', 'marque_PK', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'Photo' => 1, 'Datephoto' => 2, 'Titre' => 3, 'Commentaire' => 4, 'Etat' => 5, 'IdAp_PK' => 6, 'modele_PK' => 7, 'marque_PK' => 8, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'photo' => 1, 'datephoto' => 2, 'titre' => 3, 'commentaire' => 4, 'etat' => 5, 'idAp_PK' => 6, 'modele_PK' => 7, 'marque_PK' => 8, ),
        self::TYPE_COLNAME       => array(PhotoappareilTableMap::COL_ID => 0, PhotoappareilTableMap::COL_URL_PHOTO => 1, PhotoappareilTableMap::COL_DATE_PHOTO => 2, PhotoappareilTableMap::COL_TITRE_PHOTO => 3, PhotoappareilTableMap::COL_COMMENTAIRE => 4, PhotoappareilTableMap::COL_ETAT => 5, PhotoappareilTableMap::COL_IDAP_PK => 6, PhotoappareilTableMap::COL_MODELE_PK => 7, PhotoappareilTableMap::COL_MARQUE_PK => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'url_photo' => 1, 'date_photo' => 2, 'titre_photo' => 3, 'commentaire' => 4, 'etat' => 5, 'idAp_PK' => 6, 'modele_PK' => 7, 'marque_PK' => 8, ),
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
        $this->setName('photo_appareil');
        $this->setPhpName('Photoappareil');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Photoappareil');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('url_photo', 'Photo', 'VARCHAR', false, 200, null);
        $this->addColumn('date_photo', 'Datephoto', 'TIMESTAMP', false, null, null);
        $this->addColumn('titre_photo', 'Titre', 'VARCHAR', false, 100, null);
        $this->addColumn('commentaire', 'Commentaire', 'LONGVARCHAR', false, null, null);
        $this->addColumn('etat', 'Etat', 'BOOLEAN', false, 1, null);
        $this->addForeignPrimaryKey('idAp_PK', 'IdAp_PK', 'VARCHAR' , 'appareil', 'idAp', true, 100, null);
        $this->addForeignPrimaryKey('modele_PK', 'modele_PK', 'VARCHAR' , 'modele', 'modele', true, 100, null);
        $this->addForeignPrimaryKey('marque_PK', 'marque_PK', 'VARCHAR' , 'marque', 'marque', true, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Appareil', '\\Appareil', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':idAp_PK',
    1 => ':idAp',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Modele', '\\Model', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':modele_PK',
    1 => ':modele',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Marque', '\\Marque', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':marque_PK',
    1 => ':marque',
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
     * @param \Photoappareil $obj A \Photoappareil object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getID(), (string) $obj->getIdAp_PK(), (string) $obj->getmodele_PK(), (string) $obj->getmarque_PK()));
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
     * @param mixed $value A \Photoappareil object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Photoappareil) {
                $key = serialize(array((string) $value->getID(), (string) $value->getIdAp_PK(), (string) $value->getmodele_PK(), (string) $value->getmarque_PK()));

            } elseif (is_array($value) && count($value) === 4) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1], (string) $value[2], (string) $value[3]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Photoappareil object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('IdAp_PK', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('modele_PK', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 8 + $offset : static::translateFieldName('marque_PK', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ID', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 6 + $offset : static::translateFieldName('IdAp_PK', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 7 + $offset : static::translateFieldName('modele_PK', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 8 + $offset : static::translateFieldName('marque_PK', TableMap::TYPE_PHPNAME, $indexType)]));
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
                ? 6 + $offset
                : self::translateFieldName('IdAp_PK', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 7 + $offset
                : self::translateFieldName('modele_PK', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 8 + $offset
                : self::translateFieldName('marque_PK', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PhotoappareilTableMap::CLASS_DEFAULT : PhotoappareilTableMap::OM_CLASS;
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
     * @return array           (Photoappareil object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PhotoappareilTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PhotoappareilTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PhotoappareilTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PhotoappareilTableMap::OM_CLASS;
            /** @var Photoappareil $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PhotoappareilTableMap::addInstanceToPool($obj, $key);
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
            $key = PhotoappareilTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PhotoappareilTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Photoappareil $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PhotoappareilTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_ID);
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_URL_PHOTO);
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_DATE_PHOTO);
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_TITRE_PHOTO);
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_COMMENTAIRE);
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_ETAT);
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_IDAP_PK);
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_MODELE_PK);
            $criteria->addSelectColumn(PhotoappareilTableMap::COL_MARQUE_PK);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.url_photo');
            $criteria->addSelectColumn($alias . '.date_photo');
            $criteria->addSelectColumn($alias . '.titre_photo');
            $criteria->addSelectColumn($alias . '.commentaire');
            $criteria->addSelectColumn($alias . '.etat');
            $criteria->addSelectColumn($alias . '.idAp_PK');
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
        return Propel::getServiceContainer()->getDatabaseMap(PhotoappareilTableMap::DATABASE_NAME)->getTable(PhotoappareilTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PhotoappareilTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PhotoappareilTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PhotoappareilTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Photoappareil or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Photoappareil object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PhotoappareilTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Photoappareil) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PhotoappareilTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(PhotoappareilTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(PhotoappareilTableMap::COL_IDAP_PK, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(PhotoappareilTableMap::COL_MODELE_PK, $value[2]));
                $criterion->addAnd($criteria->getNewCriterion(PhotoappareilTableMap::COL_MARQUE_PK, $value[3]));
                $criteria->addOr($criterion);
            }
        }

        $query = PhotoappareilQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PhotoappareilTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PhotoappareilTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the photo_appareil table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PhotoappareilQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Photoappareil or Criteria object.
     *
     * @param mixed               $criteria Criteria or Photoappareil object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PhotoappareilTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Photoappareil object
        }

        if ($criteria->containsKey(PhotoappareilTableMap::COL_ID) && $criteria->keyContainsValue(PhotoappareilTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PhotoappareilTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PhotoappareilQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PhotoappareilTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PhotoappareilTableMap::buildTableMap();
