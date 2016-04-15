<?php

namespace Base;

use \Sousmenu as ChildSousmenu;
use \SousmenuQuery as ChildSousmenuQuery;
use \Exception;
use \PDO;
use Map\SousmenuTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sous_menu' table.
 *
 *
 *
 * @method     ChildSousmenuQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildSousmenuQuery orderBySousmenu($order = Criteria::ASC) Order by the sous_menu column
 * @method     ChildSousmenuQuery orderByIDMenu_FK($order = Criteria::ASC) Order by the id_menu_FK column
 * @method     ChildSousmenuQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 * @method     ChildSousmenuQuery orderByOrdre($order = Criteria::ASC) Order by the ordre column
 * @method     ChildSousmenuQuery orderByURL($order = Criteria::ASC) Order by the url column
 *
 * @method     ChildSousmenuQuery groupByID() Group by the id column
 * @method     ChildSousmenuQuery groupBySousmenu() Group by the sous_menu column
 * @method     ChildSousmenuQuery groupByIDMenu_FK() Group by the id_menu_FK column
 * @method     ChildSousmenuQuery groupByCommentaire() Group by the commentaire column
 * @method     ChildSousmenuQuery groupByOrdre() Group by the ordre column
 * @method     ChildSousmenuQuery groupByURL() Group by the url column
 *
 * @method     ChildSousmenuQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSousmenuQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSousmenuQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSousmenuQuery leftJoinMenus($relationAlias = null) Adds a LEFT JOIN clause to the query using the Menus relation
 * @method     ChildSousmenuQuery rightJoinMenus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Menus relation
 * @method     ChildSousmenuQuery innerJoinMenus($relationAlias = null) Adds a INNER JOIN clause to the query using the Menus relation
 *
 * @method     \MenusQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSousmenu findOne(ConnectionInterface $con = null) Return the first ChildSousmenu matching the query
 * @method     ChildSousmenu findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSousmenu matching the query, or a new ChildSousmenu object populated from the query conditions when no match is found
 *
 * @method     ChildSousmenu findOneByID(int $id) Return the first ChildSousmenu filtered by the id column
 * @method     ChildSousmenu findOneBySousmenu(string $sous_menu) Return the first ChildSousmenu filtered by the sous_menu column
 * @method     ChildSousmenu findOneByIDMenu_FK(int $id_menu_FK) Return the first ChildSousmenu filtered by the id_menu_FK column
 * @method     ChildSousmenu findOneByCommentaire(string $commentaire) Return the first ChildSousmenu filtered by the commentaire column
 * @method     ChildSousmenu findOneByOrdre(int $ordre) Return the first ChildSousmenu filtered by the ordre column
 * @method     ChildSousmenu findOneByURL(string $url) Return the first ChildSousmenu filtered by the url column *

 * @method     ChildSousmenu requirePk($key, ConnectionInterface $con = null) Return the ChildSousmenu by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSousmenu requireOne(ConnectionInterface $con = null) Return the first ChildSousmenu matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSousmenu requireOneByID(int $id) Return the first ChildSousmenu filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSousmenu requireOneBySousmenu(string $sous_menu) Return the first ChildSousmenu filtered by the sous_menu column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSousmenu requireOneByIDMenu_FK(int $id_menu_FK) Return the first ChildSousmenu filtered by the id_menu_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSousmenu requireOneByCommentaire(string $commentaire) Return the first ChildSousmenu filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSousmenu requireOneByOrdre(int $ordre) Return the first ChildSousmenu filtered by the ordre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSousmenu requireOneByURL(string $url) Return the first ChildSousmenu filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSousmenu[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSousmenu objects based on current ModelCriteria
 * @method     ChildSousmenu[]|ObjectCollection findByID(int $id) Return ChildSousmenu objects filtered by the id column
 * @method     ChildSousmenu[]|ObjectCollection findBySousmenu(string $sous_menu) Return ChildSousmenu objects filtered by the sous_menu column
 * @method     ChildSousmenu[]|ObjectCollection findByIDMenu_FK(int $id_menu_FK) Return ChildSousmenu objects filtered by the id_menu_FK column
 * @method     ChildSousmenu[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildSousmenu objects filtered by the commentaire column
 * @method     ChildSousmenu[]|ObjectCollection findByOrdre(int $ordre) Return ChildSousmenu objects filtered by the ordre column
 * @method     ChildSousmenu[]|ObjectCollection findByURL(string $url) Return ChildSousmenu objects filtered by the url column
 * @method     ChildSousmenu[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SousmenuQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SousmenuQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Sousmenu', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSousmenuQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSousmenuQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSousmenuQuery) {
            return $criteria;
        }
        $query = new ChildSousmenuQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSousmenu|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SousmenuTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SousmenuTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSousmenu A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, sous_menu, id_menu_FK, commentaire, ordre, url FROM sous_menu WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSousmenu $obj */
            $obj = new ChildSousmenu();
            $obj->hydrate($row);
            SousmenuTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSousmenu|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SousmenuTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SousmenuTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterByID(1234); // WHERE id = 1234
     * $query->filterByID(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterByID(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $iD The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(SousmenuTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(SousmenuTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SousmenuTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the sous_menu column
     *
     * Example usage:
     * <code>
     * $query->filterBySousmenu('fooValue');   // WHERE sous_menu = 'fooValue'
     * $query->filterBySousmenu('%fooValue%'); // WHERE sous_menu LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sousmenu The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterBySousmenu($sousmenu = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sousmenu)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sousmenu)) {
                $sousmenu = str_replace('*', '%', $sousmenu);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SousmenuTableMap::COL_SOUS_MENU, $sousmenu, $comparison);
    }

    /**
     * Filter the query on the id_menu_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIDMenu_FK(1234); // WHERE id_menu_FK = 1234
     * $query->filterByIDMenu_FK(array(12, 34)); // WHERE id_menu_FK IN (12, 34)
     * $query->filterByIDMenu_FK(array('min' => 12)); // WHERE id_menu_FK > 12
     * </code>
     *
     * @see       filterByMenus()
     *
     * @param     mixed $iDMenu_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterByIDMenu_FK($iDMenu_FK = null, $comparison = null)
    {
        if (is_array($iDMenu_FK)) {
            $useMinMax = false;
            if (isset($iDMenu_FK['min'])) {
                $this->addUsingAlias(SousmenuTableMap::COL_ID_MENU_FK, $iDMenu_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDMenu_FK['max'])) {
                $this->addUsingAlias(SousmenuTableMap::COL_ID_MENU_FK, $iDMenu_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SousmenuTableMap::COL_ID_MENU_FK, $iDMenu_FK, $comparison);
    }

    /**
     * Filter the query on the commentaire column
     *
     * Example usage:
     * <code>
     * $query->filterByCommentaire('fooValue');   // WHERE commentaire = 'fooValue'
     * $query->filterByCommentaire('%fooValue%'); // WHERE commentaire LIKE '%fooValue%'
     * </code>
     *
     * @param     string $commentaire The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterByCommentaire($commentaire = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($commentaire)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $commentaire)) {
                $commentaire = str_replace('*', '%', $commentaire);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SousmenuTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
    }

    /**
     * Filter the query on the ordre column
     *
     * Example usage:
     * <code>
     * $query->filterByOrdre(1234); // WHERE ordre = 1234
     * $query->filterByOrdre(array(12, 34)); // WHERE ordre IN (12, 34)
     * $query->filterByOrdre(array('min' => 12)); // WHERE ordre > 12
     * </code>
     *
     * @param     mixed $ordre The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterByOrdre($ordre = null, $comparison = null)
    {
        if (is_array($ordre)) {
            $useMinMax = false;
            if (isset($ordre['min'])) {
                $this->addUsingAlias(SousmenuTableMap::COL_ORDRE, $ordre['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ordre['max'])) {
                $this->addUsingAlias(SousmenuTableMap::COL_ORDRE, $ordre['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SousmenuTableMap::COL_ORDRE, $ordre, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByURL('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByURL('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uRL The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterByURL($uRL = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uRL)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $uRL)) {
                $uRL = str_replace('*', '%', $uRL);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SousmenuTableMap::COL_URL, $uRL, $comparison);
    }

    /**
     * Filter the query by a related \Menus object
     *
     * @param \Menus|ObjectCollection $menus The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSousmenuQuery The current query, for fluid interface
     */
    public function filterByMenus($menus, $comparison = null)
    {
        if ($menus instanceof \Menus) {
            return $this
                ->addUsingAlias(SousmenuTableMap::COL_ID_MENU_FK, $menus->getID(), $comparison);
        } elseif ($menus instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SousmenuTableMap::COL_ID_MENU_FK, $menus->toKeyValue('PrimaryKey', 'ID'), $comparison);
        } else {
            throw new PropelException('filterByMenus() only accepts arguments of type \Menus or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Menus relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function joinMenus($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Menus');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Menus');
        }

        return $this;
    }

    /**
     * Use the Menus relation Menus object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MenusQuery A secondary query class using the current class as primary query
     */
    public function useMenusQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMenus($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Menus', '\MenusQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSousmenu $sousmenu Object to remove from the list of results
     *
     * @return $this|ChildSousmenuQuery The current query, for fluid interface
     */
    public function prune($sousmenu = null)
    {
        if ($sousmenu) {
            $this->addUsingAlias(SousmenuTableMap::COL_ID, $sousmenu->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sous_menu table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SousmenuTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SousmenuTableMap::clearInstancePool();
            SousmenuTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SousmenuTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SousmenuTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SousmenuTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SousmenuTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SousmenuQuery
