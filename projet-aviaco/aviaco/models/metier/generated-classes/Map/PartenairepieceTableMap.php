<?php

namespace Map;

use \Partenairepiece;
use \PartenairepieceQuery;
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
 * This class defines the structure of the 'partenaire_piece' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PartenairepieceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PartenairepieceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'partenaire_piece';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Partenairepiece';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Partenairepiece';

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
     * the column name for the id field
     */
    const COL_ID = 'partenaire_piece.id';

    /**
     * the column name for the quantite field
     */
    const COL_QUANTITE = 'partenaire_piece.quantite';

    /**
     * the column name for the prix_achat field
     */
    const COL_PRIX_ACHAT = 'partenaire_piece.prix_achat';

    /**
     * the column name for the prix_vente field
     */
    const COL_PRIX_VENTE = 'partenaire_piece.prix_vente';

    /**
     * the column name for the date_enreg field
     */
    const COL_DATE_ENREG = 'partenaire_piece.date_enreg';

    /**
     * the column name for the reference_PK field
     */
    const COL_REFERENCE_PK = 'partenaire_piece.reference_PK';

    /**
     * the column name for the part_id_PK field
     */
    const COL_PART_ID_PK = 'partenaire_piece.part_id_PK';

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
        self::TYPE_PHPNAME       => array('ID', 'Quantite', 'Prixachat', 'Prixvente', 'Dateenregistrement', 'Reference_PK', 'Partenaire_PK', ),
        self::TYPE_CAMELNAME     => array('iD', 'quantite', 'prixachat', 'prixvente', 'dateenregistrement', 'reference_PK', 'partenaire_PK', ),
        self::TYPE_COLNAME       => array(PartenairepieceTableMap::COL_ID, PartenairepieceTableMap::COL_QUANTITE, PartenairepieceTableMap::COL_PRIX_ACHAT, PartenairepieceTableMap::COL_PRIX_VENTE, PartenairepieceTableMap::COL_DATE_ENREG, PartenairepieceTableMap::COL_REFERENCE_PK, PartenairepieceTableMap::COL_PART_ID_PK, ),
        self::TYPE_FIELDNAME     => array('id', 'quantite', 'prix_achat', 'prix_vente', 'date_enreg', 'reference_PK', 'part_id_PK', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ID' => 0, 'Quantite' => 1, 'Prixachat' => 2, 'Prixvente' => 3, 'Dateenregistrement' => 4, 'Reference_PK' => 5, 'Partenaire_PK' => 6, ),
        self::TYPE_CAMELNAME     => array('iD' => 0, 'quantite' => 1, 'prixachat' => 2, 'prixvente' => 3, 'dateenregistrement' => 4, 'reference_PK' => 5, 'partenaire_PK' => 6, ),
        self::TYPE_COLNAME       => array(PartenairepieceTableMap::COL_ID => 0, PartenairepieceTableMap::COL_QUANTITE => 1, PartenairepieceTableMap::COL_PRIX_ACHAT => 2, PartenairepieceTableMap::COL_PRIX_VENTE => 3, PartenairepieceTableMap::COL_DATE_ENREG => 4, PartenairepieceTableMap::COL_REFERENCE_PK => 5, PartenairepieceTableMap::COL_PART_ID_PK => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'quantite' => 1, 'prix_achat' => 2, 'prix_vente' => 3, 'date_enreg' => 4, 'reference_PK' => 5, 'part_id_PK' => 6, ),
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
        $this->setName('partenaire_piece');
        $this->setPhpName('Partenairepiece');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Partenairepiece');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'ID', 'INTEGER', true, null, null);
        $this->addColumn('quantite', 'Quantite', 'INTEGER', false, null, null);
        $this->addColumn('prix_achat', 'Prixachat', 'DOUBLE', false, null, null);
        $this->addColumn('prix_vente', 'Prixvente', 'DOUBLE', false, null, null);
        $this->addColumn('date_enreg', 'Dateenregistrement', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('reference_PK', 'Reference_PK', 'VARCHAR', 'piece', 'reference', false, 100, null);
        $this->addForeignKey('part_id_PK', 'Partenaire_PK', 'INTEGER', 'partenaire', 'part_id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Piece', '\\Piece', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':reference_PK',
    1 => ':reference',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Partenaire', '\\Partenaire', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':part_id_PK',
    1 => ':part_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Doc', '\\Document', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':date_enreg_FK',
    1 => ':date_enreg',
  ),
), 'CASCADE', 'CASCADE', 'Docs', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to partenaire_piece     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        DocumentTableMap::clearInstancePool();
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
        return $withPrefix ? PartenairepieceTableMap::CLASS_DEFAULT : PartenairepieceTableMap::OM_CLASS;
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
     * @return array           (Partenairepiece object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PartenairepieceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PartenairepieceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PartenairepieceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PartenairepieceTableMap::OM_CLASS;
            /** @var Partenairepiece $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PartenairepieceTableMap::addInstanceToPool($obj, $key);
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
            $key = PartenairepieceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PartenairepieceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Partenairepiece $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PartenairepieceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PartenairepieceTableMap::COL_ID);
            $criteria->addSelectColumn(PartenairepieceTableMap::COL_QUANTITE);
            $criteria->addSelectColumn(PartenairepieceTableMap::COL_PRIX_ACHAT);
            $criteria->addSelectColumn(PartenairepieceTableMap::COL_PRIX_VENTE);
            $criteria->addSelectColumn(PartenairepieceTableMap::COL_DATE_ENREG);
            $criteria->addSelectColumn(PartenairepieceTableMap::COL_REFERENCE_PK);
            $criteria->addSelectColumn(PartenairepieceTableMap::COL_PART_ID_PK);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.quantite');
            $criteria->addSelectColumn($alias . '.prix_achat');
            $criteria->addSelectColumn($alias . '.prix_vente');
            $criteria->addSelectColumn($alias . '.date_enreg');
            $criteria->addSelectColumn($alias . '.reference_PK');
            $criteria->addSelectColumn($alias . '.part_id_PK');
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
        return Propel::getServiceContainer()->getDatabaseMap(PartenairepieceTableMap::DATABASE_NAME)->getTable(PartenairepieceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PartenairepieceTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PartenairepieceTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PartenairepieceTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Partenairepiece or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Partenairepiece object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PartenairepieceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Partenairepiece) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PartenairepieceTableMap::DATABASE_NAME);
            $criteria->add(PartenairepieceTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PartenairepieceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PartenairepieceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PartenairepieceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the partenaire_piece table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PartenairepieceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Partenairepiece or Criteria object.
     *
     * @param mixed               $criteria Criteria or Partenairepiece object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PartenairepieceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Partenairepiece object
        }

        if ($criteria->containsKey(PartenairepieceTableMap::COL_ID) && $criteria->keyContainsValue(PartenairepieceTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PartenairepieceTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PartenairepieceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PartenairepieceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PartenairepieceTableMap::buildTableMap();
