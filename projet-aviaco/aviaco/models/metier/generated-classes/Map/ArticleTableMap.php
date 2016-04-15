<?php

namespace Map;

use \Article;
use \ArticleQuery;
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
 * This class defines the structure of the 'article' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ArticleTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ArticleTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aviaco';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'article';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Article';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Article';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the art_num field
     */
    const COL_ART_NUM = 'article.art_num';

    /**
     * the column name for the titre field
     */
    const COL_TITRE = 'article.titre';

    /**
     * the column name for the id_emp_FK field
     */
    const COL_ID_EMP_FK = 'article.id_emp_FK';

    /**
     * the column name for the date_edit field
     */
    const COL_DATE_EDIT = 'article.date_edit';

    /**
     * the column name for the contenu field
     */
    const COL_CONTENU = 'article.contenu';

    /**
     * the column name for the resume field
     */
    const COL_RESUME = 'article.resume';

    /**
     * the column name for the img_laune field
     */
    const COL_IMG_LAUNE = 'article.img_laune';

    /**
     * the column name for the url field
     */
    const COL_URL = 'article.url';

    /**
     * the column name for the categorie_FK field
     */
    const COL_CATEGORIE_FK = 'article.categorie_FK';

    /**
     * the column name for the sous_categorie_FK field
     */
    const COL_SOUS_CATEGORIE_FK = 'article.sous_categorie_FK';

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
        self::TYPE_PHPNAME       => array('Numart', 'Titre', 'IdEmpFk', 'DateEdit', 'Contenu', 'Resume', 'ImgLaune', 'Url', 'Categorie_FK', 'Souscategorie_FK', ),
        self::TYPE_CAMELNAME     => array('numart', 'titre', 'idEmpFk', 'dateEdit', 'contenu', 'resume', 'imgLaune', 'url', 'categorie_FK', 'souscategorie_FK', ),
        self::TYPE_COLNAME       => array(ArticleTableMap::COL_ART_NUM, ArticleTableMap::COL_TITRE, ArticleTableMap::COL_ID_EMP_FK, ArticleTableMap::COL_DATE_EDIT, ArticleTableMap::COL_CONTENU, ArticleTableMap::COL_RESUME, ArticleTableMap::COL_IMG_LAUNE, ArticleTableMap::COL_URL, ArticleTableMap::COL_CATEGORIE_FK, ArticleTableMap::COL_SOUS_CATEGORIE_FK, ),
        self::TYPE_FIELDNAME     => array('art_num', 'titre', 'id_emp_FK', 'date_edit', 'contenu', 'resume', 'img_laune', 'url', 'categorie_FK', 'sous_categorie_FK', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Numart' => 0, 'Titre' => 1, 'IdEmpFk' => 2, 'DateEdit' => 3, 'Contenu' => 4, 'Resume' => 5, 'ImgLaune' => 6, 'Url' => 7, 'Categorie_FK' => 8, 'Souscategorie_FK' => 9, ),
        self::TYPE_CAMELNAME     => array('numart' => 0, 'titre' => 1, 'idEmpFk' => 2, 'dateEdit' => 3, 'contenu' => 4, 'resume' => 5, 'imgLaune' => 6, 'url' => 7, 'categorie_FK' => 8, 'souscategorie_FK' => 9, ),
        self::TYPE_COLNAME       => array(ArticleTableMap::COL_ART_NUM => 0, ArticleTableMap::COL_TITRE => 1, ArticleTableMap::COL_ID_EMP_FK => 2, ArticleTableMap::COL_DATE_EDIT => 3, ArticleTableMap::COL_CONTENU => 4, ArticleTableMap::COL_RESUME => 5, ArticleTableMap::COL_IMG_LAUNE => 6, ArticleTableMap::COL_URL => 7, ArticleTableMap::COL_CATEGORIE_FK => 8, ArticleTableMap::COL_SOUS_CATEGORIE_FK => 9, ),
        self::TYPE_FIELDNAME     => array('art_num' => 0, 'titre' => 1, 'id_emp_FK' => 2, 'date_edit' => 3, 'contenu' => 4, 'resume' => 5, 'img_laune' => 6, 'url' => 7, 'categorie_FK' => 8, 'sous_categorie_FK' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('article');
        $this->setPhpName('Article');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Article');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('art_num', 'Numart', 'INTEGER', true, null, null);
        $this->addColumn('titre', 'Titre', 'VARCHAR', false, 255, null);
        $this->addForeignKey('id_emp_FK', 'IdEmpFk', 'VARCHAR', 'employe', 'id_emp', false, 25, null);
        $this->addColumn('date_edit', 'DateEdit', 'TIMESTAMP', false, null, null);
        $this->addColumn('contenu', 'Contenu', 'LONGVARCHAR', false, null, null);
        $this->addColumn('resume', 'Resume', 'LONGVARCHAR', false, null, null);
        $this->addColumn('img_laune', 'ImgLaune', 'LONGVARCHAR', false, null, null);
        $this->addColumn('url', 'Url', 'VARCHAR', false, 200, null);
        $this->addForeignKey('categorie_FK', 'Categorie_FK', 'VARCHAR', 'categorie', 'categorie', true, 100, null);
        $this->addForeignKey('sous_categorie_FK', 'Souscategorie_FK', 'VARCHAR', 'sous_categorie', 'sous_categorie', true, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Employe', '\\Employe', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_emp_FK',
    1 => ':id_emp',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Categorie', '\\Categorie', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':categorie_FK',
    1 => ':categorie',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Souscategorie', '\\Souscategorie', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':sous_categorie_FK',
    1 => ':sous_categorie',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Publication', '\\Publication', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':art_num_PK',
    1 => ':art_num',
  ),
), 'CASCADE', 'CASCADE', 'Publications', false);
        $this->addRelation('Widget', '\\Widget', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':num_art',
    1 => ':art_num',
  ),
), 'CASCADE', 'CASCADE', 'Widgets', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to article     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PublicationTableMap::clearInstancePool();
        WidgetTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Numart', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Numart', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Numart', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ArticleTableMap::CLASS_DEFAULT : ArticleTableMap::OM_CLASS;
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
     * @return array           (Article object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ArticleTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ArticleTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ArticleTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ArticleTableMap::OM_CLASS;
            /** @var Article $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ArticleTableMap::addInstanceToPool($obj, $key);
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
            $key = ArticleTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ArticleTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Article $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ArticleTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ArticleTableMap::COL_ART_NUM);
            $criteria->addSelectColumn(ArticleTableMap::COL_TITRE);
            $criteria->addSelectColumn(ArticleTableMap::COL_ID_EMP_FK);
            $criteria->addSelectColumn(ArticleTableMap::COL_DATE_EDIT);
            $criteria->addSelectColumn(ArticleTableMap::COL_CONTENU);
            $criteria->addSelectColumn(ArticleTableMap::COL_RESUME);
            $criteria->addSelectColumn(ArticleTableMap::COL_IMG_LAUNE);
            $criteria->addSelectColumn(ArticleTableMap::COL_URL);
            $criteria->addSelectColumn(ArticleTableMap::COL_CATEGORIE_FK);
            $criteria->addSelectColumn(ArticleTableMap::COL_SOUS_CATEGORIE_FK);
        } else {
            $criteria->addSelectColumn($alias . '.art_num');
            $criteria->addSelectColumn($alias . '.titre');
            $criteria->addSelectColumn($alias . '.id_emp_FK');
            $criteria->addSelectColumn($alias . '.date_edit');
            $criteria->addSelectColumn($alias . '.contenu');
            $criteria->addSelectColumn($alias . '.resume');
            $criteria->addSelectColumn($alias . '.img_laune');
            $criteria->addSelectColumn($alias . '.url');
            $criteria->addSelectColumn($alias . '.categorie_FK');
            $criteria->addSelectColumn($alias . '.sous_categorie_FK');
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
        return Propel::getServiceContainer()->getDatabaseMap(ArticleTableMap::DATABASE_NAME)->getTable(ArticleTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ArticleTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ArticleTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ArticleTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Article or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Article object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Article) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ArticleTableMap::DATABASE_NAME);
            $criteria->add(ArticleTableMap::COL_ART_NUM, (array) $values, Criteria::IN);
        }

        $query = ArticleQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ArticleTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ArticleTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the article table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ArticleQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Article or Criteria object.
     *
     * @param mixed               $criteria Criteria or Article object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Article object
        }

        if ($criteria->containsKey(ArticleTableMap::COL_ART_NUM) && $criteria->keyContainsValue(ArticleTableMap::COL_ART_NUM) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ArticleTableMap::COL_ART_NUM.')');
        }


        // Set the correct dbName
        $query = ArticleQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ArticleTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ArticleTableMap::buildTableMap();
