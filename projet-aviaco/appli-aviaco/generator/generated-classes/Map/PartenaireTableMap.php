<?php

namespace Map;

use \Partenaire;
use \PartenaireQuery;
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
 * This class defines the structure of the 'partenaire' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PartenaireTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PartenaireTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'appliaviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'partenaire';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Partenaire';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Partenaire';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the indx field
     */
    const COL_INDX = 'partenaire.indx';

    /**
     * the column name for the partenaire field
     */
    const COL_PARTENAIRE = 'partenaire.partenaire';

    /**
     * the column name for the id_part field
     */
    const COL_ID_PART = 'partenaire.id_part';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'partenaire.code';

    /**
     * the column name for the lien field
     */
    const COL_LIEN = 'partenaire.lien';

    /**
     * the column name for the mail field
     */
    const COL_MAIL = 'partenaire.mail';

    /**
     * the column name for the type_part field
     */
    const COL_TYPE_PART = 'partenaire.type_part';

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
        self::TYPE_PHPNAME       => array('ID', 'Partenaire', 'IDPartenaire', 'Code', 'Lienweb', 'mail', 'TypePart', ),
        self::TYPE_CAMELNAME     => array('iD', 'partenaire', 'iDPartenaire', 'code', 'lienweb', 'mail', 'typePart', ),
        self::TYPE_COLNAME       => array(PartenaireTableMap::COL_INDX, PartenaireTableMap::COL_PARTENAIRE, PartenaireTableMap::COL_ID_PART, PartenaireTableMap::COL_CODE, PartenaireTableMap::COL_LIEN, PartenaireTableMap::COL_MAIL, PartenaireTableMap::COL_TYPE_PART, ),
        self::TYPE_FIELDNAME     => array('indx', 'partenaire', 'id_part', 'code', 'lien', 'mail', 'type_part', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'Partenaire' => 1, 'IDPartenaire' => 2, 'Code' => 3, 'Lienweb' => 4, 'mail' => 5, 'TypePart' => 6, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'partenaire' => 1, 'iDPartenaire' => 2, 'code' => 3, 'lienweb' => 4, 'mail' => 5, 'typePart' => 6, ),
        self::TYPE_COLNAME       => array(PartenaireTableMap::COL_INDX => 0, PartenaireTableMap::COL_PARTENAIRE => 1, PartenaireTableMap::COL_ID_PART => 2, PartenaireTableMap::COL_CODE => 3, PartenaireTableMap::COL_LIEN => 4, PartenaireTableMap::COL_MAIL => 5, PartenaireTableMap::COL_TYPE_PART => 6, ),
        self::TYPE_FIELDNAME     => array('indx' => 0, 'partenaire' => 1, 'id_part' => 2, 'code' => 3, 'lien' => 4, 'mail' => 5, 'type_part' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('partenaire');
        $this->setPhpName('Partenaire');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Partenaire');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('indx', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('partenaire', 'Partenaire', 'VARCHAR', false, 80, null);
        $this->addColumn('id_part', 'IDPartenaire', 'VARCHAR', false, 80, null);
        $this->addColumn('code', 'Code', 'VARCHAR', false, 80, null);
        $this->addColumn('lien', 'Lienweb', 'VARCHAR', false, 200, null);
        $this->addColumn('mail', 'mail', 'VARCHAR', false, 100, null);
        $this->addColumn('type_part', 'TypePart', 'VARCHAR', false, 80, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Annonceur', '\\Annonceur', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':indx_part',
    1 => ':indx',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('FPartenaire', '\\FPartenaire', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':indx_part',
    1 => ':indx',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('SPartenaire', '\\SPartenaire', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':plaig_part',
    1 => ':indx',
  ),
), 'CASCADE', 'CASCADE', 'SPartenaires', false);
        $this->addRelation('BPartenaire', '\\BPartenaire', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':indx_part',
    1 => ':indx',
  ),
), 'CASCADE', 'CASCADE', 'BPartenaires', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to partenaire     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AnnonceurTableMap::clearInstancePool();
        FPartenaireTableMap::clearInstancePool();
        SPartenaireTableMap::clearInstancePool();
        BPartenaireTableMap::clearInstancePool();
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
        return $withPrefix ? PartenaireTableMap::CLASS_DEFAULT : PartenaireTableMap::OM_CLASS;
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
     * @return array           (Partenaire object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PartenaireTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PartenaireTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PartenaireTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PartenaireTableMap::OM_CLASS;
            /** @var Partenaire $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PartenaireTableMap::addInstanceToPool($obj, $key);
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
            $key = PartenaireTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PartenaireTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Partenaire $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PartenaireTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PartenaireTableMap::COL_INDX);
            $criteria->addSelectColumn(PartenaireTableMap::COL_PARTENAIRE);
            $criteria->addSelectColumn(PartenaireTableMap::COL_ID_PART);
            $criteria->addSelectColumn(PartenaireTableMap::COL_CODE);
            $criteria->addSelectColumn(PartenaireTableMap::COL_LIEN);
            $criteria->addSelectColumn(PartenaireTableMap::COL_MAIL);
            $criteria->addSelectColumn(PartenaireTableMap::COL_TYPE_PART);
        } else {
            $criteria->addSelectColumn($alias . '.indx');
            $criteria->addSelectColumn($alias . '.partenaire');
            $criteria->addSelectColumn($alias . '.id_part');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.lien');
            $criteria->addSelectColumn($alias . '.mail');
            $criteria->addSelectColumn($alias . '.type_part');
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
        return Propel::getServiceContainer()->getDatabaseMap(PartenaireTableMap::DATABASE_NAME)->getTable(PartenaireTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PartenaireTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PartenaireTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PartenaireTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Partenaire or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Partenaire object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PartenaireTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Partenaire) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PartenaireTableMap::DATABASE_NAME);
            $criteria->add(PartenaireTableMap::COL_INDX, (array) $values, Criteria::IN);
        }

        $query = PartenaireQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PartenaireTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PartenaireTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the partenaire table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PartenaireQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Partenaire or Criteria object.
     *
     * @param mixed               $criteria Criteria or Partenaire object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PartenaireTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Partenaire object
        }

        if ($criteria->containsKey(PartenaireTableMap::COL_INDX) && $criteria->keyContainsValue(PartenaireTableMap::COL_INDX) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PartenaireTableMap::COL_INDX.')');
        }


        // Set the correct dbName
        $query = PartenaireQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PartenaireTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PartenaireTableMap::buildTableMap();