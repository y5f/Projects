<?php

namespace Base;

use \Menus as ChildMenus;
use \MenusQuery as ChildMenusQuery;
use \Exception;
use \PDO;
use Map\MenusTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'menus' table.
 *
 *
 *
 * @method     ChildMenusQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildMenusQuery orderByMenu($order = Criteria::ASC) Order by the menu column
 * @method     ChildMenusQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 * @method     ChildMenusQuery orderByNiveau($order = Criteria::ASC) Order by the niveau column
 * @method     ChildMenusQuery orderByOrdre($order = Criteria::ASC) Order by the ordre column
 * @method     ChildMenusQuery orderByURL($order = Criteria::ASC) Order by the url column
 *
 * @method     ChildMenusQuery groupByID() Group by the id column
 * @method     ChildMenusQuery groupByMenu() Group by the menu column
 * @method     ChildMenusQuery groupByCommentaire() Group by the commentaire column
 * @method     ChildMenusQuery groupByNiveau() Group by the niveau column
 * @method     ChildMenusQuery groupByOrdre() Group by the ordre column
 * @method     ChildMenusQuery groupByURL() Group by the url column
 *
 * @method     ChildMenusQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMenusQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMenusQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMenusQuery leftJoinSousmenu($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sousmenu relation
 * @method     ChildMenusQuery rightJoinSousmenu($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sousmenu relation
 * @method     ChildMenusQuery innerJoinSousmenu($relationAlias = null) Adds a INNER JOIN clause to the query using the Sousmenu relation
 *
 * @method     \SousmenuQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMenus findOne(ConnectionInterface $con = null) Return the first ChildMenus matching the query
 * @method     ChildMenus findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMenus matching the query, or a new ChildMenus object populated from the query conditions when no match is found
 *
 * @method     ChildMenus findOneByID(int $id) Return the first ChildMenus filtered by the id column
 * @method     ChildMenus findOneByMenu(string $menu) Return the first ChildMenus filtered by the menu column
 * @method     ChildMenus findOneByCommentaire(string $commentaire) Return the first ChildMenus filtered by the commentaire column
 * @method     ChildMenus findOneByNiveau(int $niveau) Return the first ChildMenus filtered by the niveau column
 * @method     ChildMenus findOneByOrdre(int $ordre) Return the first ChildMenus filtered by the ordre column
 * @method     ChildMenus findOneByURL(string $url) Return the first ChildMenus filtered by the url column *

 * @method     ChildMenus requirePk($key, ConnectionInterface $con = null) Return the ChildMenus by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenus requireOne(ConnectionInterface $con = null) Return the first ChildMenus matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMenus requireOneByID(int $id) Return the first ChildMenus filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenus requireOneByMenu(string $menu) Return the first ChildMenus filtered by the menu column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenus requireOneByCommentaire(string $commentaire) Return the first ChildMenus filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenus requireOneByNiveau(int $niveau) Return the first ChildMenus filtered by the niveau column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenus requireOneByOrdre(int $ordre) Return the first ChildMenus filtered by the ordre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenus requireOneByURL(string $url) Return the first ChildMenus filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMenus[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMenus objects based on current ModelCriteria
 * @method     ChildMenus[]|ObjectCollection findByID(int $id) Return ChildMenus objects filtered by the id column
 * @method     ChildMenus[]|ObjectCollection findByMenu(string $menu) Return ChildMenus objects filtered by the menu column
 * @method     ChildMenus[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildMenus objects filtered by the commentaire column
 * @method     ChildMenus[]|ObjectCollection findByNiveau(int $niveau) Return ChildMenus objects filtered by the niveau column
 * @method     ChildMenus[]|ObjectCollection findByOrdre(int $ordre) Return ChildMenus objects filtered by the ordre column
 * @method     ChildMenus[]|ObjectCollection findByURL(string $url) Return ChildMenus objects filtered by the url column
 * @method     ChildMenus[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MenusQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MenusQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Menus', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMenusQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMenusQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMenusQuery) {
            return $criteria;
        }
        $query = new ChildMenusQuery();
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
     * @return ChildMenus|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MenusTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MenusTableMap::DATABASE_NAME);
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
     * @return ChildMenus A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, menu, commentaire, niveau, ordre, url FROM menus WHERE id = :p0';
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
            /** @var ChildMenus $obj */
            $obj = new ChildMenus();
            $obj->hydrate($row);
            MenusTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMenus|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMenusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MenusTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMenusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MenusTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildMenusQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(MenusTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(MenusTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenusTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the menu column
     *
     * Example usage:
     * <code>
     * $query->filterByMenu('fooValue');   // WHERE menu = 'fooValue'
     * $query->filterByMenu('%fooValue%'); // WHERE menu LIKE '%fooValue%'
     * </code>
     *
     * @param     string $menu The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenusQuery The current query, for fluid interface
     */
    public function filterByMenu($menu = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($menu)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $menu)) {
                $menu = str_replace('*', '%', $menu);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MenusTableMap::COL_MENU, $menu, $comparison);
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
     * @return $this|ChildMenusQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MenusTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
    }

    /**
     * Filter the query on the niveau column
     *
     * Example usage:
     * <code>
     * $query->filterByNiveau(1234); // WHERE niveau = 1234
     * $query->filterByNiveau(array(12, 34)); // WHERE niveau IN (12, 34)
     * $query->filterByNiveau(array('min' => 12)); // WHERE niveau > 12
     * </code>
     *
     * @param     mixed $niveau The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenusQuery The current query, for fluid interface
     */
    public function filterByNiveau($niveau = null, $comparison = null)
    {
        if (is_array($niveau)) {
            $useMinMax = false;
            if (isset($niveau['min'])) {
                $this->addUsingAlias(MenusTableMap::COL_NIVEAU, $niveau['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($niveau['max'])) {
                $this->addUsingAlias(MenusTableMap::COL_NIVEAU, $niveau['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenusTableMap::COL_NIVEAU, $niveau, $comparison);
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
     * @return $this|ChildMenusQuery The current query, for fluid interface
     */
    public function filterByOrdre($ordre = null, $comparison = null)
    {
        if (is_array($ordre)) {
            $useMinMax = false;
            if (isset($ordre['min'])) {
                $this->addUsingAlias(MenusTableMap::COL_ORDRE, $ordre['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ordre['max'])) {
                $this->addUsingAlias(MenusTableMap::COL_ORDRE, $ordre['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenusTableMap::COL_ORDRE, $ordre, $comparison);
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
     * @return $this|ChildMenusQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MenusTableMap::COL_URL, $uRL, $comparison);
    }

    /**
     * Filter the query by a related \Sousmenu object
     *
     * @param \Sousmenu|ObjectCollection $sousmenu the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenusQuery The current query, for fluid interface
     */
    public function filterBySousmenu($sousmenu, $comparison = null)
    {
        if ($sousmenu instanceof \Sousmenu) {
            return $this
                ->addUsingAlias(MenusTableMap::COL_ID, $sousmenu->getIDMenu_FK(), $comparison);
        } elseif ($sousmenu instanceof ObjectCollection) {
            return $this
                ->useSousmenuQuery()
                ->filterByPrimaryKeys($sousmenu->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySousmenu() only accepts arguments of type \Sousmenu or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sousmenu relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMenusQuery The current query, for fluid interface
     */
    public function joinSousmenu($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sousmenu');

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
            $this->addJoinObject($join, 'Sousmenu');
        }

        return $this;
    }

    /**
     * Use the Sousmenu relation Sousmenu object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SousmenuQuery A secondary query class using the current class as primary query
     */
    public function useSousmenuQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSousmenu($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sousmenu', '\SousmenuQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMenus $menus Object to remove from the list of results
     *
     * @return $this|ChildMenusQuery The current query, for fluid interface
     */
    public function prune($menus = null)
    {
        if ($menus) {
            $this->addUsingAlias(MenusTableMap::COL_ID, $menus->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the menus table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenusTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MenusTableMap::clearInstancePool();
            MenusTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MenusTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MenusTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MenusTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MenusTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MenusQuery
