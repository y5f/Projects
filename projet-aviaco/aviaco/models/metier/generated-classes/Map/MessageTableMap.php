<?php

namespace Map;

use \Message;
use \MessageQuery;
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
 * This class defines the structure of the 'message' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MessageTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.MessageTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'message';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Message';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Message';

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
     * the column name for the id_msg field
     */
    const COL_ID_MSG = 'message.id_msg';

    /**
     * the column name for the objet field
     */
    const COL_OBJET = 'message.objet';

    /**
     * the column name for the nom_visiteur field
     */
    const COL_NOM_VISITEUR = 'message.nom_visiteur';

    /**
     * the column name for the mail_visiteur field
     */
    const COL_MAIL_VISITEUR = 'message.mail_visiteur';

    /**
     * the column name for the telephone field
     */
    const COL_TELEPHONE = 'message.telephone';

    /**
     * the column name for the msg field
     */
    const COL_MSG = 'message.msg';

    /**
     * the column name for the etat field
     */
    const COL_ETAT = 'message.etat';

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
        self::TYPE_PHPNAME       => array('Idmsg', 'Objet', 'Visiteur', 'Email', 'Telephone', 'Msg', 'Etat', ),
        self::TYPE_CAMELNAME     => array('idmsg', 'objet', 'visiteur', 'email', 'telephone', 'msg', 'etat', ),
        self::TYPE_COLNAME       => array(MessageTableMap::COL_ID_MSG, MessageTableMap::COL_OBJET, MessageTableMap::COL_NOM_VISITEUR, MessageTableMap::COL_MAIL_VISITEUR, MessageTableMap::COL_TELEPHONE, MessageTableMap::COL_MSG, MessageTableMap::COL_ETAT, ),
        self::TYPE_FIELDNAME     => array('id_msg', 'objet', 'nom_visiteur', 'mail_visiteur', 'telephone', 'msg', 'etat', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Idmsg' => 0, 'Objet' => 1, 'Visiteur' => 2, 'Email' => 3, 'Telephone' => 4, 'Msg' => 5, 'Etat' => 6, ),
        self::TYPE_CAMELNAME     => array('idmsg' => 0, 'objet' => 1, 'visiteur' => 2, 'email' => 3, 'telephone' => 4, 'msg' => 5, 'etat' => 6, ),
        self::TYPE_COLNAME       => array(MessageTableMap::COL_ID_MSG => 0, MessageTableMap::COL_OBJET => 1, MessageTableMap::COL_NOM_VISITEUR => 2, MessageTableMap::COL_MAIL_VISITEUR => 3, MessageTableMap::COL_TELEPHONE => 4, MessageTableMap::COL_MSG => 5, MessageTableMap::COL_ETAT => 6, ),
        self::TYPE_FIELDNAME     => array('id_msg' => 0, 'objet' => 1, 'nom_visiteur' => 2, 'mail_visiteur' => 3, 'telephone' => 4, 'msg' => 5, 'etat' => 6, ),
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
        $this->setName('message');
        $this->setPhpName('Message');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Message');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id_msg', 'Idmsg', 'INTEGER', true, null, null);
        $this->addColumn('objet', 'Objet', 'VARCHAR', false, 255, null);
        $this->addColumn('nom_visiteur', 'Visiteur', 'VARCHAR', false, 100, null);
        $this->addColumn('mail_visiteur', 'Email', 'VARCHAR', false, 100, null);
        $this->addColumn('telephone', 'Telephone', 'VARCHAR', false, 15, null);
        $this->addColumn('msg', 'Msg', 'LONGVARCHAR', false, null, null);
        $this->addColumn('etat', 'Etat', 'BOOLEAN', false, 1, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Idmsg', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Idmsg', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Idmsg', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? MessageTableMap::CLASS_DEFAULT : MessageTableMap::OM_CLASS;
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
     * @return array           (Message object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MessageTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MessageTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MessageTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MessageTableMap::OM_CLASS;
            /** @var Message $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MessageTableMap::addInstanceToPool($obj, $key);
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
            $key = MessageTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MessageTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Message $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MessageTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MessageTableMap::COL_ID_MSG);
            $criteria->addSelectColumn(MessageTableMap::COL_OBJET);
            $criteria->addSelectColumn(MessageTableMap::COL_NOM_VISITEUR);
            $criteria->addSelectColumn(MessageTableMap::COL_MAIL_VISITEUR);
            $criteria->addSelectColumn(MessageTableMap::COL_TELEPHONE);
            $criteria->addSelectColumn(MessageTableMap::COL_MSG);
            $criteria->addSelectColumn(MessageTableMap::COL_ETAT);
        } else {
            $criteria->addSelectColumn($alias . '.id_msg');
            $criteria->addSelectColumn($alias . '.objet');
            $criteria->addSelectColumn($alias . '.nom_visiteur');
            $criteria->addSelectColumn($alias . '.mail_visiteur');
            $criteria->addSelectColumn($alias . '.telephone');
            $criteria->addSelectColumn($alias . '.msg');
            $criteria->addSelectColumn($alias . '.etat');
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
        return Propel::getServiceContainer()->getDatabaseMap(MessageTableMap::DATABASE_NAME)->getTable(MessageTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(MessageTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(MessageTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new MessageTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Message or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Message object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MessageTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Message) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MessageTableMap::DATABASE_NAME);
            $criteria->add(MessageTableMap::COL_ID_MSG, (array) $values, Criteria::IN);
        }

        $query = MessageQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MessageTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MessageTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the message table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MessageQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Message or Criteria object.
     *
     * @param mixed               $criteria Criteria or Message object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessageTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Message object
        }

        if ($criteria->containsKey(MessageTableMap::COL_ID_MSG) && $criteria->keyContainsValue(MessageTableMap::COL_ID_MSG) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MessageTableMap::COL_ID_MSG.')');
        }


        // Set the correct dbName
        $query = MessageQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // MessageTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MessageTableMap::buildTableMap();
