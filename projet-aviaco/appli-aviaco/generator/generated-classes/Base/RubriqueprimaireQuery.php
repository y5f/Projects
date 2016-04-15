<?php

namespace Base;

use \Rubriqueprimaire as ChildRubriqueprimaire;
use \RubriqueprimaireQuery as ChildRubriqueprimaireQuery;
use \Exception;
use \PDO;
use Map\RubriqueprimaireTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rubrique_primaire' table.
 *
 *
 *
 * @method     ChildRubriqueprimaireQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildRubriqueprimaireQuery orderByRubriqueCol($order = Criteria::ASC) Order by the rubrique_primaire column
 * @method     ChildRubriqueprimaireQuery orderByRubrique_FK($order = Criteria::ASC) Order by the rubrique_FK column
 * @method     ChildRubriqueprimaireQuery orderByURL($order = Criteria::ASC) Order by the url column
 *
 * @method     ChildRubriqueprimaireQuery groupByID() Group by the id column
 * @method     ChildRubriqueprimaireQuery groupByRubriqueCol() Group by the rubrique_primaire column
 * @method     ChildRubriqueprimaireQuery groupByRubrique_FK() Group by the rubrique_FK column
 * @method     ChildRubriqueprimaireQuery groupByURL() Group by the url column
 *
 * @method     ChildRubriqueprimaireQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRubriqueprimaireQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRubriqueprimaireQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRubriqueprimaireQuery leftJoinRubrique($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rubrique relation
 * @method     ChildRubriqueprimaireQuery rightJoinRubrique($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rubrique relation
 * @method     ChildRubriqueprimaireQuery innerJoinRubrique($relationAlias = null) Adds a INNER JOIN clause to the query using the Rubrique relation
 *
 * @method     \RubriqueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRubriqueprimaire findOne(ConnectionInterface $con = null) Return the first ChildRubriqueprimaire matching the query
 * @method     ChildRubriqueprimaire findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRubriqueprimaire matching the query, or a new ChildRubriqueprimaire object populated from the query conditions when no match is found
 *
 * @method     ChildRubriqueprimaire findOneByID(int $id) Return the first ChildRubriqueprimaire filtered by the id column
 * @method     ChildRubriqueprimaire findOneByRubriqueCol(string $rubrique_primaire) Return the first ChildRubriqueprimaire filtered by the rubrique_primaire column
 * @method     ChildRubriqueprimaire findOneByRubrique_FK(string $rubrique_FK) Return the first ChildRubriqueprimaire filtered by the rubrique_FK column
 * @method     ChildRubriqueprimaire findOneByURL(string $url) Return the first ChildRubriqueprimaire filtered by the url column *

 * @method     ChildRubriqueprimaire requirePk($key, ConnectionInterface $con = null) Return the ChildRubriqueprimaire by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRubriqueprimaire requireOne(ConnectionInterface $con = null) Return the first ChildRubriqueprimaire matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRubriqueprimaire requireOneByID(int $id) Return the first ChildRubriqueprimaire filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRubriqueprimaire requireOneByRubriqueCol(string $rubrique_primaire) Return the first ChildRubriqueprimaire filtered by the rubrique_primaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRubriqueprimaire requireOneByRubrique_FK(string $rubrique_FK) Return the first ChildRubriqueprimaire filtered by the rubrique_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRubriqueprimaire requireOneByURL(string $url) Return the first ChildRubriqueprimaire filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRubriqueprimaire[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRubriqueprimaire objects based on current ModelCriteria
 * @method     ChildRubriqueprimaire[]|ObjectCollection findByID(int $id) Return ChildRubriqueprimaire objects filtered by the id column
 * @method     ChildRubriqueprimaire[]|ObjectCollection findByRubriqueCol(string $rubrique_primaire) Return ChildRubriqueprimaire objects filtered by the rubrique_primaire column
 * @method     ChildRubriqueprimaire[]|ObjectCollection findByRubrique_FK(string $rubrique_FK) Return ChildRubriqueprimaire objects filtered by the rubrique_FK column
 * @method     ChildRubriqueprimaire[]|ObjectCollection findByURL(string $url) Return ChildRubriqueprimaire objects filtered by the url column
 * @method     ChildRubriqueprimaire[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RubriqueprimaireQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RubriqueprimaireQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Rubriqueprimaire', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRubriqueprimaireQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRubriqueprimaireQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRubriqueprimaireQuery) {
            return $criteria;
        }
        $query = new ChildRubriqueprimaireQuery();
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
     * @return ChildRubriqueprimaire|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RubriqueprimaireTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RubriqueprimaireTableMap::DATABASE_NAME);
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
     * @return ChildRubriqueprimaire A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, rubrique_primaire, rubrique_FK, url FROM rubrique_primaire WHERE id = :p0';
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
            /** @var ChildRubriqueprimaire $obj */
            $obj = new ChildRubriqueprimaire();
            $obj->hydrate($row);
            RubriqueprimaireTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRubriqueprimaire|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRubriqueprimaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RubriqueprimaireTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRubriqueprimaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RubriqueprimaireTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRubriqueprimaireQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(RubriqueprimaireTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(RubriqueprimaireTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RubriqueprimaireTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the rubrique_primaire column
     *
     * Example usage:
     * <code>
     * $query->filterByRubriqueCol('fooValue');   // WHERE rubrique_primaire = 'fooValue'
     * $query->filterByRubriqueCol('%fooValue%'); // WHERE rubrique_primaire LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rubriqueCol The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRubriqueprimaireQuery The current query, for fluid interface
     */
    public function filterByRubriqueCol($rubriqueCol = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rubriqueCol)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rubriqueCol)) {
                $rubriqueCol = str_replace('*', '%', $rubriqueCol);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RubriqueprimaireTableMap::COL_RUBRIQUE_PRIMAIRE, $rubriqueCol, $comparison);
    }

    /**
     * Filter the query on the rubrique_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByRubrique_FK('fooValue');   // WHERE rubrique_FK = 'fooValue'
     * $query->filterByRubrique_FK('%fooValue%'); // WHERE rubrique_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rubrique_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRubriqueprimaireQuery The current query, for fluid interface
     */
    public function filterByRubrique_FK($rubrique_FK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rubrique_FK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rubrique_FK)) {
                $rubrique_FK = str_replace('*', '%', $rubrique_FK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RubriqueprimaireTableMap::COL_RUBRIQUE_FK, $rubrique_FK, $comparison);
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
     * @return $this|ChildRubriqueprimaireQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RubriqueprimaireTableMap::COL_URL, $uRL, $comparison);
    }

    /**
     * Filter the query by a related \Rubrique object
     *
     * @param \Rubrique|ObjectCollection $rubrique The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRubriqueprimaireQuery The current query, for fluid interface
     */
    public function filterByRubrique($rubrique, $comparison = null)
    {
        if ($rubrique instanceof \Rubrique) {
            return $this
                ->addUsingAlias(RubriqueprimaireTableMap::COL_RUBRIQUE_FK, $rubrique->getRubriqueCol(), $comparison);
        } elseif ($rubrique instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RubriqueprimaireTableMap::COL_RUBRIQUE_FK, $rubrique->toKeyValue('PrimaryKey', 'RubriqueCol'), $comparison);
        } else {
            throw new PropelException('filterByRubrique() only accepts arguments of type \Rubrique or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Rubrique relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRubriqueprimaireQuery The current query, for fluid interface
     */
    public function joinRubrique($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Rubrique');

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
            $this->addJoinObject($join, 'Rubrique');
        }

        return $this;
    }

    /**
     * Use the Rubrique relation Rubrique object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RubriqueQuery A secondary query class using the current class as primary query
     */
    public function useRubriqueQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRubrique($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Rubrique', '\RubriqueQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRubriqueprimaire $rubriqueprimaire Object to remove from the list of results
     *
     * @return $this|ChildRubriqueprimaireQuery The current query, for fluid interface
     */
    public function prune($rubriqueprimaire = null)
    {
        if ($rubriqueprimaire) {
            $this->addUsingAlias(RubriqueprimaireTableMap::COL_ID, $rubriqueprimaire->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rubrique_primaire table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RubriqueprimaireTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RubriqueprimaireTableMap::clearInstancePool();
            RubriqueprimaireTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RubriqueprimaireTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RubriqueprimaireTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RubriqueprimaireTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RubriqueprimaireTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RubriqueprimaireQuery
