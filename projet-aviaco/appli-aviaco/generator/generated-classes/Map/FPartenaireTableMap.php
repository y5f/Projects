<?php

namespace Map;

use \FPartenaire;
use \FPartenaireQuery;
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
 * This class defines the structure of the 'finance_part' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FPartenaireTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.FPartenaireTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'appliaviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'finance_part';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\FPartenaire';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'FPartenaire';

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
     * the column name for the indx_part field
     */
    const COL_INDX_PART = 'finance_part.indx_part';

    /**
     * the column name for the abonnement field
     */
    const COL_ABONNEMENT = 'finance_part.abonnement';

    /**
     * the column name for the notes field
     */
    const COL_NOTES = 'finance_part.notes';

    /**
     * the column name for the dte_maj field
     */
    const COL_DTE_MAJ = 'finance_part.dte_maj';

    /**
     * the column name for the id_contact field
     */
    const COL_ID_CONTACT = 'finance_part.id_contact';

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
        self::TYPE_PHPNAME       => array('IDPart', 'isAbonnement', 'Notes', 'DateMAJ', 'IDContact', ),
        self::TYPE_CAMELNAME     => array('iDPart', 'isAbonnement', 'notes', 'dateMAJ', 'iDContact', ),
        self::TYPE_COLNAME       => array(FPartenaireTableMap::COL_INDX_PART, FPartenaireTableMap::COL_ABONNEMENT, FPartenaireTableMap::COL_NOTES, FPartenaireTableMap::COL_DTE_MAJ, FPartenaireTableMap::COL_ID_CONTACT, ),
        self::TYPE_FIELDNAME     => array('indx_part', 'abonnement', 'notes', 'dte_maj', 'id_contact', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IDPart' => 0, 'isAbonnement' => 1, 'Notes' => 2, 'DateMAJ' => 3, 'IDContact' => 4, ),
        self::TYPE_CAMELNAME     => array('iDPart' => 0, 'isAbonnement' => 1, 'notes' => 2, 'dateMAJ' => 3, 'iDContact' => 4, ),
        self::TYPE_COLNAME       => array(FPartenaireTableMap::COL_INDX_PART => 0, FPartenaireTableMap::COL_ABONNEMENT => 1, FPartenaireTableMap::COL_NOTES => 2, FPartenaireTableMap::COL_DTE_MAJ => 3, FPartenaireTableMap::COL_ID_CONTACT => 4, ),
        self::TYPE_FIELDNAME     => array('indx_part' => 0, 'abonnement' => 1, 'notes' => 2, 'dte_maj' => 3, 'id_contact' => 4, ),
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
        $this->setName('finance_part');
        $this->setPhpName('FPartenaire');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\FPartenaire');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('indx_part', 'IDPart', 'INTEGER' , 'partenaire', 'indx', true, null, null);
        $this->addColumn('abonnement', 'isAbonnement', 'BOOLEAN', false, 1, null);
        $this->addColumn('notes', 'Notes', 'LONGVARCHAR', false, null, null);
        $this->addColumn('dte_maj', 'DateMAJ', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('id_contact', 'IDContact', 'INTEGER', 'contact', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Partenaire', '\\Partenaire', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':indx_part',
    1 => ':indx',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Contact', '\\Contact', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_contact',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('IConcernePays', '\\IConcernePays', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':indx_infos',
    1 => ':indx_part',
  ),
), 'CASCADE', 'CASCADE', 'IConcernePayss', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to finance_part     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        IConcernePaysTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IDPart', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IDPart', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IDPart', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? FPartenaireTableMap::CLASS_DEFAULT : FPartenaireTableMap::OM_CLASS;
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
     * @return array           (FPartenaire object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FPartenaireTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FPartenaireTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FPartenaireTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FPartenaireTableMap::OM_CLASS;
            /** @var FPartenaire $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FPartenaireTableMap::addInstanceToPool($obj, $key);
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
            $key = FPartenaireTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FPartenaireTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var FPartenaire $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FPartenaireTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FPartenaireTableMap::COL_INDX_PART);
            $criteria->addSelectColumn(FPartenaireTableMap::COL_ABONNEMENT);
            $criteria->addSelectColumn(FPartenaireTableMap::COL_NOTES);
            $criteria->addSelectColumn(FPartenaireTableMap::COL_DTE_MAJ);
            $criteria->addSelectColumn(FPartenaireTableMap::COL_ID_CONTACT);
        } else {
            $criteria->addSelectColumn($alias . '.indx_part');
            $criteria->addSelectColumn($alias . '.abonnement');
            $criteria->addSelectColumn($alias . '.notes');
            $criteria->addSelectColumn($alias . '.dte_maj');
            $criteria->addSelectColumn($alias . '.id_contact');
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
        return Propel::getServiceContainer()->getDatabaseMap(FPartenaireTableMap::DATABASE_NAME)->getTable(FPartenaireTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FPartenaireTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FPartenaireTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FPartenaireTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a FPartenaire or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or FPartenaire object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FPartenaireTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \FPartenaire) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FPartenaireTableMap::DATABASE_NAME);
            $criteria->add(FPartenaireTableMap::COL_INDX_PART, (array) $values, Criteria::IN);
        }

        $query = FPartenaireQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FPartenaireTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FPartenaireTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the finance_part table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FPartenaireQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a FPartenaire or Criteria object.
     *
     * @param mixed               $criteria Criteria or FPartenaire object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FPartenaireTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from FPartenaire object
        }


        // Set the correct dbName
        $query = FPartenaireQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FPartenaireTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FPartenaireTableMap::buildTableMap();
