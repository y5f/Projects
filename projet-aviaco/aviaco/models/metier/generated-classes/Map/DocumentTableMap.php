<?php

namespace Map;

use \Document;
use \DocumentQuery;
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
 * This class defines the structure of the 'document' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DocumentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DocumentTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'document';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Document';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Document';

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
     * the column name for the doc_num field
     */
    const COL_DOC_NUM = 'document.doc_num';

    /**
     * the column name for the doc_lien field
     */
    const COL_DOC_LIEN = 'document.doc_lien';

    /**
     * the column name for the reference_FK field
     */
    const COL_REFERENCE_FK = 'document.reference_FK';

    /**
     * the column name for the part_id_FK field
     */
    const COL_PART_ID_FK = 'document.part_id_FK';

    /**
     * the column name for the date_enreg_FK field
     */
    const COL_DATE_ENREG_FK = 'document.date_enreg_FK';

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
        self::TYPE_PHPNAME       => array('Docnumber', 'Doc', 'Reference_FK', 'Part_id_FK', 'Dateenreg_FK', ),
        self::TYPE_CAMELNAME     => array('docnumber', 'doc', 'reference_FK', 'part_id_FK', 'dateenreg_FK', ),
        self::TYPE_COLNAME       => array(DocumentTableMap::COL_DOC_NUM, DocumentTableMap::COL_DOC_LIEN, DocumentTableMap::COL_REFERENCE_FK, DocumentTableMap::COL_PART_ID_FK, DocumentTableMap::COL_DATE_ENREG_FK, ),
        self::TYPE_FIELDNAME     => array('doc_num', 'doc_lien', 'reference_FK', 'part_id_FK', 'date_enreg_FK', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Docnumber' => 0, 'Doc' => 1, 'Reference_FK' => 2, 'Part_id_FK' => 3, 'Dateenreg_FK' => 4, ),
        self::TYPE_CAMELNAME     => array('docnumber' => 0, 'doc' => 1, 'reference_FK' => 2, 'part_id_FK' => 3, 'dateenreg_FK' => 4, ),
        self::TYPE_COLNAME       => array(DocumentTableMap::COL_DOC_NUM => 0, DocumentTableMap::COL_DOC_LIEN => 1, DocumentTableMap::COL_REFERENCE_FK => 2, DocumentTableMap::COL_PART_ID_FK => 3, DocumentTableMap::COL_DATE_ENREG_FK => 4, ),
        self::TYPE_FIELDNAME     => array('doc_num' => 0, 'doc_lien' => 1, 'reference_FK' => 2, 'part_id_FK' => 3, 'date_enreg_FK' => 4, ),
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
        $this->setName('document');
        $this->setPhpName('Document');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Document');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('doc_num', 'Docnumber', 'INTEGER', true, null, null);
        $this->addColumn('doc_lien', 'Doc', 'VARCHAR', false, 100, null);
        $this->addForeignKey('reference_FK', 'Reference_FK', 'VARCHAR', 'piece', 'reference', false, 100, null);
        $this->addForeignKey('part_id_FK', 'Part_id_FK', 'INTEGER', 'partenaire', 'part_id', false, 100, null);
        $this->addForeignKey('date_enreg_FK', 'Dateenreg_FK', 'TIMESTAMP', 'partenaire_piece', 'date_enreg', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Partenairepiece', '\\Partenairepiece', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':date_enreg_FK',
    1 => ':date_enreg',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Piece', '\\Piece', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':reference_FK',
    1 => ':reference',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Partenaire', '\\Partenaire', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':part_id_FK',
    1 => ':part_id',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Docnumber', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Docnumber', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Docnumber', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? DocumentTableMap::CLASS_DEFAULT : DocumentTableMap::OM_CLASS;
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
     * @return array           (Document object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DocumentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DocumentTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DocumentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DocumentTableMap::OM_CLASS;
            /** @var Document $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DocumentTableMap::addInstanceToPool($obj, $key);
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
            $key = DocumentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DocumentTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Document $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DocumentTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DocumentTableMap::COL_DOC_NUM);
            $criteria->addSelectColumn(DocumentTableMap::COL_DOC_LIEN);
            $criteria->addSelectColumn(DocumentTableMap::COL_REFERENCE_FK);
            $criteria->addSelectColumn(DocumentTableMap::COL_PART_ID_FK);
            $criteria->addSelectColumn(DocumentTableMap::COL_DATE_ENREG_FK);
        } else {
            $criteria->addSelectColumn($alias . '.doc_num');
            $criteria->addSelectColumn($alias . '.doc_lien');
            $criteria->addSelectColumn($alias . '.reference_FK');
            $criteria->addSelectColumn($alias . '.part_id_FK');
            $criteria->addSelectColumn($alias . '.date_enreg_FK');
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
        return Propel::getServiceContainer()->getDatabaseMap(DocumentTableMap::DATABASE_NAME)->getTable(DocumentTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DocumentTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DocumentTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DocumentTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Document or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Document object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Document) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DocumentTableMap::DATABASE_NAME);
            $criteria->add(DocumentTableMap::COL_DOC_NUM, (array) $values, Criteria::IN);
        }

        $query = DocumentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DocumentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DocumentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the document table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DocumentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Document or Criteria object.
     *
     * @param mixed               $criteria Criteria or Document object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Document object
        }

        if ($criteria->containsKey(DocumentTableMap::COL_DOC_NUM) && $criteria->keyContainsValue(DocumentTableMap::COL_DOC_NUM) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DocumentTableMap::COL_DOC_NUM.')');
        }


        // Set the correct dbName
        $query = DocumentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DocumentTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DocumentTableMap::buildTableMap();
