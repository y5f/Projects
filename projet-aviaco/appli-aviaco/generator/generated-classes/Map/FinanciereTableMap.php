<?php

namespace Map;

use \Financiere;
use \FinanciereQuery;
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
 * This class defines the structure of the 'financiere' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FinanciereTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.FinanciereTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'appliaviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'financiere';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Financiere';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Financiere';

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
     * the column name for the id field
     */
    const COL_ID = 'financiere.id';

    /**
     * the column name for the immatricule field
     */
    const COL_IMMATRICULE = 'financiere.immatricule';

    /**
     * the column name for the societe_FK field
     */
    const COL_SOCIETE_FK = 'financiere.societe_FK';

    /**
     * the column name for the capital field
     */
    const COL_CAPITAL = 'financiere.capital';

    /**
     * the column name for the form field
     */
    const COL_FORM = 'financiere.form';

    /**
     * the column name for the dte_creation field
     */
    const COL_DTE_CREATION = 'financiere.dte_creation';

    /**
     * the column name for the notes field
     */
    const COL_NOTES = 'financiere.notes';

    /**
     * the column name for the dte_maj field
     */
    const COL_DTE_MAJ = 'financiere.dte_maj';

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
        self::TYPE_PHPNAME       => array('ID', 'Immatricule', 'Societe_FK', 'Capital', 'Form', 'Dtecreation', 'Notes', 'Dte_MAJ', ),
        self::TYPE_CAMELNAME     => array('iD', 'immatricule', 'societe_FK', 'capital', 'form', 'dtecreation', 'notes', 'dte_MAJ', ),
        self::TYPE_COLNAME       => array(FinanciereTableMap::COL_ID, FinanciereTableMap::COL_IMMATRICULE, FinanciereTableMap::COL_SOCIETE_FK, FinanciereTableMap::COL_CAPITAL, FinanciereTableMap::COL_FORM, FinanciereTableMap::COL_DTE_CREATION, FinanciereTableMap::COL_NOTES, FinanciereTableMap::COL_DTE_MAJ, ),
        self::TYPE_FIELDNAME     => array('id', 'immatricule', 'societe_FK', 'capital', 'form', 'dte_creation', 'notes', 'dte_maj', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'Immatricule' => 1, 'Societe_FK' => 2, 'Capital' => 3, 'Form' => 4, 'Dtecreation' => 5, 'Notes' => 6, 'Dte_MAJ' => 7, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'immatricule' => 1, 'societe_FK' => 2, 'capital' => 3, 'form' => 4, 'dtecreation' => 5, 'notes' => 6, 'dte_MAJ' => 7, ),
        self::TYPE_COLNAME       => array(FinanciereTableMap::COL_ID => 0, FinanciereTableMap::COL_IMMATRICULE => 1, FinanciereTableMap::COL_SOCIETE_FK => 2, FinanciereTableMap::COL_CAPITAL => 3, FinanciereTableMap::COL_FORM => 4, FinanciereTableMap::COL_DTE_CREATION => 5, FinanciereTableMap::COL_NOTES => 6, FinanciereTableMap::COL_DTE_MAJ => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'immatricule' => 1, 'societe_FK' => 2, 'capital' => 3, 'form' => 4, 'dte_creation' => 5, 'notes' => 6, 'dte_maj' => 7, ),
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
        $this->setName('financiere');
        $this->setPhpName('Financiere');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Financiere');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('immatricule', 'Immatricule', 'VARCHAR', false, 20, null);
        $this->addForeignKey('societe_FK', 'Societe_FK', 'VARCHAR', 'societe', 'societe', false, 80, null);
        $this->addColumn('capital', 'Capital', 'DOUBLE', false, null, null);
        $this->addColumn('form', 'Form', 'VARCHAR', false, 80, null);
        $this->addColumn('dte_creation', 'Dtecreation', 'TIMESTAMP', false, null, null);
        $this->addColumn('notes', 'Notes', 'LONGVARCHAR', false, null, null);
        $this->addColumn('dte_maj', 'Dte_MAJ', 'TIMESTAMP', false, null, null);
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
        return $withPrefix ? FinanciereTableMap::CLASS_DEFAULT : FinanciereTableMap::OM_CLASS;
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
     * @return array           (Financiere object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FinanciereTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FinanciereTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FinanciereTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FinanciereTableMap::OM_CLASS;
            /** @var Financiere $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FinanciereTableMap::addInstanceToPool($obj, $key);
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
            $key = FinanciereTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FinanciereTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Financiere $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FinanciereTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FinanciereTableMap::COL_ID);
            $criteria->addSelectColumn(FinanciereTableMap::COL_IMMATRICULE);
            $criteria->addSelectColumn(FinanciereTableMap::COL_SOCIETE_FK);
            $criteria->addSelectColumn(FinanciereTableMap::COL_CAPITAL);
            $criteria->addSelectColumn(FinanciereTableMap::COL_FORM);
            $criteria->addSelectColumn(FinanciereTableMap::COL_DTE_CREATION);
            $criteria->addSelectColumn(FinanciereTableMap::COL_NOTES);
            $criteria->addSelectColumn(FinanciereTableMap::COL_DTE_MAJ);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.immatricule');
            $criteria->addSelectColumn($alias . '.societe_FK');
            $criteria->addSelectColumn($alias . '.capital');
            $criteria->addSelectColumn($alias . '.form');
            $criteria->addSelectColumn($alias . '.dte_creation');
            $criteria->addSelectColumn($alias . '.notes');
            $criteria->addSelectColumn($alias . '.dte_maj');
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
        return Propel::getServiceContainer()->getDatabaseMap(FinanciereTableMap::DATABASE_NAME)->getTable(FinanciereTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FinanciereTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FinanciereTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FinanciereTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Financiere or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Financiere object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FinanciereTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Financiere) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FinanciereTableMap::DATABASE_NAME);
            $criteria->add(FinanciereTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FinanciereQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FinanciereTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FinanciereTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the financiere table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FinanciereQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Financiere or Criteria object.
     *
     * @param mixed               $criteria Criteria or Financiere object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FinanciereTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Financiere object
        }

        if ($criteria->containsKey(FinanciereTableMap::COL_ID) && $criteria->keyContainsValue(FinanciereTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FinanciereTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FinanciereQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FinanciereTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FinanciereTableMap::buildTableMap();
