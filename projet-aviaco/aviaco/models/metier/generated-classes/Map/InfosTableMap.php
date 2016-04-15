<?php

namespace Map;

use \Infos;
use \InfosQuery;
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
 * This class defines the structure of the 'infos_box' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class InfosTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.InfosTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'infos_box';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Infos';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Infos';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the ibox_id field
     */
    const COL_IBOX_ID = 'infos_box.ibox_id';

    /**
     * the column name for the titre field
     */
    const COL_TITRE = 'infos_box.titre';

    /**
     * the column name for the logo field
     */
    const COL_LOGO = 'infos_box.logo';

    /**
     * the column name for the slogan field
     */
    const COL_SLOGAN = 'infos_box.slogan';

    /**
     * the column name for the telephone field
     */
    const COL_TELEPHONE = 'infos_box.telephone';

    /**
     * the column name for the mail field
     */
    const COL_MAIL = 'infos_box.mail';

    /**
     * the column name for the num_rue field
     */
    const COL_NUM_RUE = 'infos_box.num_rue';

    /**
     * the column name for the nom_rue field
     */
    const COL_NOM_RUE = 'infos_box.nom_rue';

    /**
     * the column name for the cp field
     */
    const COL_CP = 'infos_box.cp';

    /**
     * the column name for the ville field
     */
    const COL_VILLE = 'infos_box.ville';

    /**
     * the column name for the txt_slider field
     */
    const COL_TXT_SLIDER = 'infos_box.txt_slider';

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
        self::TYPE_PHPNAME       => array('IDInfos', 'Titre', 'Logo', 'Slogan', 'Telephone', 'Email', 'Numrue', 'Nomrue', 'Codepostal', 'Ville', 'Textslider', ),
        self::TYPE_CAMELNAME     => array('iDInfos', 'titre', 'logo', 'slogan', 'telephone', 'email', 'numrue', 'nomrue', 'codepostal', 'ville', 'textslider', ),
        self::TYPE_COLNAME       => array(InfosTableMap::COL_IBOX_ID, InfosTableMap::COL_TITRE, InfosTableMap::COL_LOGO, InfosTableMap::COL_SLOGAN, InfosTableMap::COL_TELEPHONE, InfosTableMap::COL_MAIL, InfosTableMap::COL_NUM_RUE, InfosTableMap::COL_NOM_RUE, InfosTableMap::COL_CP, InfosTableMap::COL_VILLE, InfosTableMap::COL_TXT_SLIDER, ),
        self::TYPE_FIELDNAME     => array('ibox_id', 'titre', 'logo', 'slogan', 'telephone', 'mail', 'num_rue', 'nom_rue', 'cp', 'ville', 'txt_slider', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IDInfos' => 0, 'Titre' => 1, 'Logo' => 2, 'Slogan' => 3, 'Telephone' => 4, 'Email' => 5, 'Numrue' => 6, 'Nomrue' => 7, 'Codepostal' => 8, 'Ville' => 9, 'Textslider' => 10, ),
        self::TYPE_CAMELNAME     => array('iDInfos' => 0, 'titre' => 1, 'logo' => 2, 'slogan' => 3, 'telephone' => 4, 'email' => 5, 'numrue' => 6, 'nomrue' => 7, 'codepostal' => 8, 'ville' => 9, 'textslider' => 10, ),
        self::TYPE_COLNAME       => array(InfosTableMap::COL_IBOX_ID => 0, InfosTableMap::COL_TITRE => 1, InfosTableMap::COL_LOGO => 2, InfosTableMap::COL_SLOGAN => 3, InfosTableMap::COL_TELEPHONE => 4, InfosTableMap::COL_MAIL => 5, InfosTableMap::COL_NUM_RUE => 6, InfosTableMap::COL_NOM_RUE => 7, InfosTableMap::COL_CP => 8, InfosTableMap::COL_VILLE => 9, InfosTableMap::COL_TXT_SLIDER => 10, ),
        self::TYPE_FIELDNAME     => array('ibox_id' => 0, 'titre' => 1, 'logo' => 2, 'slogan' => 3, 'telephone' => 4, 'mail' => 5, 'num_rue' => 6, 'nom_rue' => 7, 'cp' => 8, 'ville' => 9, 'txt_slider' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('infos_box');
        $this->setPhpName('Infos');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Infos');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ibox_id', 'IDInfos', 'INTEGER', true, null, null);
        $this->addColumn('titre', 'Titre', 'VARCHAR', false, 200, null);
        $this->addColumn('logo', 'Logo', 'VARCHAR', false, 200, null);
        $this->addColumn('slogan', 'Slogan', 'VARCHAR', false, 200, null);
        $this->addColumn('telephone', 'Telephone', 'VARCHAR', false, 15, null);
        $this->addColumn('mail', 'Email', 'VARCHAR', false, 100, null);
        $this->addColumn('num_rue', 'Numrue', 'VARCHAR', false, 5, null);
        $this->addColumn('nom_rue', 'Nomrue', 'VARCHAR', false, 100, null);
        $this->addColumn('cp', 'Codepostal', 'VARCHAR', false, 5, null);
        $this->addColumn('ville', 'Ville', 'VARCHAR', false, 40, null);
        $this->addColumn('txt_slider', 'Textslider', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IDInfos', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IDInfos', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('IDInfos', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? InfosTableMap::CLASS_DEFAULT : InfosTableMap::OM_CLASS;
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
     * @return array           (Infos object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = InfosTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InfosTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InfosTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InfosTableMap::OM_CLASS;
            /** @var Infos $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InfosTableMap::addInstanceToPool($obj, $key);
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
            $key = InfosTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InfosTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Infos $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InfosTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(InfosTableMap::COL_IBOX_ID);
            $criteria->addSelectColumn(InfosTableMap::COL_TITRE);
            $criteria->addSelectColumn(InfosTableMap::COL_LOGO);
            $criteria->addSelectColumn(InfosTableMap::COL_SLOGAN);
            $criteria->addSelectColumn(InfosTableMap::COL_TELEPHONE);
            $criteria->addSelectColumn(InfosTableMap::COL_MAIL);
            $criteria->addSelectColumn(InfosTableMap::COL_NUM_RUE);
            $criteria->addSelectColumn(InfosTableMap::COL_NOM_RUE);
            $criteria->addSelectColumn(InfosTableMap::COL_CP);
            $criteria->addSelectColumn(InfosTableMap::COL_VILLE);
            $criteria->addSelectColumn(InfosTableMap::COL_TXT_SLIDER);
        } else {
            $criteria->addSelectColumn($alias . '.ibox_id');
            $criteria->addSelectColumn($alias . '.titre');
            $criteria->addSelectColumn($alias . '.logo');
            $criteria->addSelectColumn($alias . '.slogan');
            $criteria->addSelectColumn($alias . '.telephone');
            $criteria->addSelectColumn($alias . '.mail');
            $criteria->addSelectColumn($alias . '.num_rue');
            $criteria->addSelectColumn($alias . '.nom_rue');
            $criteria->addSelectColumn($alias . '.cp');
            $criteria->addSelectColumn($alias . '.ville');
            $criteria->addSelectColumn($alias . '.txt_slider');
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
        return Propel::getServiceContainer()->getDatabaseMap(InfosTableMap::DATABASE_NAME)->getTable(InfosTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(InfosTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(InfosTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new InfosTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Infos or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Infos object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(InfosTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Infos) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InfosTableMap::DATABASE_NAME);
            $criteria->add(InfosTableMap::COL_IBOX_ID, (array) $values, Criteria::IN);
        }

        $query = InfosQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InfosTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InfosTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the infos_box table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return InfosQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Infos or Criteria object.
     *
     * @param mixed               $criteria Criteria or Infos object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InfosTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Infos object
        }

        if ($criteria->containsKey(InfosTableMap::COL_IBOX_ID) && $criteria->keyContainsValue(InfosTableMap::COL_IBOX_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InfosTableMap::COL_IBOX_ID.')');
        }


        // Set the correct dbName
        $query = InfosQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // InfosTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
InfosTableMap::buildTableMap();
