<?php

namespace Base;

use \Depot as ChildDepot;
use \DepotQuery as ChildDepotQuery;
use \Exception;
use \PDO;
use Map\DepotTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'depot' table.
 *
 *
 *
 * @method     ChildDepotQuery orderByIddepot($order = Criteria::ASC) Order by the id_depot column
 * @method     ChildDepotQuery orderByDepotAdresse($order = Criteria::ASC) Order by the depot_adresse column
 *
 * @method     ChildDepotQuery groupByIddepot() Group by the id_depot column
 * @method     ChildDepotQuery groupByDepotAdresse() Group by the depot_adresse column
 *
 * @method     ChildDepotQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDepotQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDepotQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDepotQuery leftJoinDepotpartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Depotpartenaire relation
 * @method     ChildDepotQuery rightJoinDepotpartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Depotpartenaire relation
 * @method     ChildDepotQuery innerJoinDepotpartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Depotpartenaire relation
 *
 * @method     ChildDepotQuery leftJoinStockdepot($relationAlias = null) Adds a LEFT JOIN clause to the query using the Stockdepot relation
 * @method     ChildDepotQuery rightJoinStockdepot($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Stockdepot relation
 * @method     ChildDepotQuery innerJoinStockdepot($relationAlias = null) Adds a INNER JOIN clause to the query using the Stockdepot relation
 *
 * @method     \DepotpartenaireQuery|\StockdepotQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDepot findOne(ConnectionInterface $con = null) Return the first ChildDepot matching the query
 * @method     ChildDepot findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDepot matching the query, or a new ChildDepot object populated from the query conditions when no match is found
 *
 * @method     ChildDepot findOneByIddepot(int $id_depot) Return the first ChildDepot filtered by the id_depot column
 * @method     ChildDepot findOneByDepotAdresse(string $depot_adresse) Return the first ChildDepot filtered by the depot_adresse column *

 * @method     ChildDepot requirePk($key, ConnectionInterface $con = null) Return the ChildDepot by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepot requireOne(ConnectionInterface $con = null) Return the first ChildDepot matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDepot requireOneByIddepot(int $id_depot) Return the first ChildDepot filtered by the id_depot column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepot requireOneByDepotAdresse(string $depot_adresse) Return the first ChildDepot filtered by the depot_adresse column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDepot[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDepot objects based on current ModelCriteria
 * @method     ChildDepot[]|ObjectCollection findByIddepot(int $id_depot) Return ChildDepot objects filtered by the id_depot column
 * @method     ChildDepot[]|ObjectCollection findByDepotAdresse(string $depot_adresse) Return ChildDepot objects filtered by the depot_adresse column
 * @method     ChildDepot[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DepotQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DepotQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Depot', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDepotQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDepotQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDepotQuery) {
            return $criteria;
        }
        $query = new ChildDepotQuery();
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
     * @return ChildDepot|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DepotTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DepotTableMap::DATABASE_NAME);
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
     * @return ChildDepot A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_depot, depot_adresse FROM depot WHERE id_depot = :p0';
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
            /** @var ChildDepot $obj */
            $obj = new ChildDepot();
            $obj->hydrate($row);
            DepotTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildDepot|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDepotQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DepotTableMap::COL_ID_DEPOT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDepotQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DepotTableMap::COL_ID_DEPOT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_depot column
     *
     * Example usage:
     * <code>
     * $query->filterByIddepot(1234); // WHERE id_depot = 1234
     * $query->filterByIddepot(array(12, 34)); // WHERE id_depot IN (12, 34)
     * $query->filterByIddepot(array('min' => 12)); // WHERE id_depot > 12
     * </code>
     *
     * @param     mixed $iddepot The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDepotQuery The current query, for fluid interface
     */
    public function filterByIddepot($iddepot = null, $comparison = null)
    {
        if (is_array($iddepot)) {
            $useMinMax = false;
            if (isset($iddepot['min'])) {
                $this->addUsingAlias(DepotTableMap::COL_ID_DEPOT, $iddepot['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iddepot['max'])) {
                $this->addUsingAlias(DepotTableMap::COL_ID_DEPOT, $iddepot['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DepotTableMap::COL_ID_DEPOT, $iddepot, $comparison);
    }

    /**
     * Filter the query on the depot_adresse column
     *
     * Example usage:
     * <code>
     * $query->filterByDepotAdresse('fooValue');   // WHERE depot_adresse = 'fooValue'
     * $query->filterByDepotAdresse('%fooValue%'); // WHERE depot_adresse LIKE '%fooValue%'
     * </code>
     *
     * @param     string $depotAdresse The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDepotQuery The current query, for fluid interface
     */
    public function filterByDepotAdresse($depotAdresse = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($depotAdresse)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $depotAdresse)) {
                $depotAdresse = str_replace('*', '%', $depotAdresse);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DepotTableMap::COL_DEPOT_ADRESSE, $depotAdresse, $comparison);
    }

    /**
     * Filter the query by a related \Depotpartenaire object
     *
     * @param \Depotpartenaire|ObjectCollection $depotpartenaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDepotQuery The current query, for fluid interface
     */
    public function filterByDepotpartenaire($depotpartenaire, $comparison = null)
    {
        if ($depotpartenaire instanceof \Depotpartenaire) {
            return $this
                ->addUsingAlias(DepotTableMap::COL_ID_DEPOT, $depotpartenaire->getId_depot_PK(), $comparison);
        } elseif ($depotpartenaire instanceof ObjectCollection) {
            return $this
                ->useDepotpartenaireQuery()
                ->filterByPrimaryKeys($depotpartenaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDepotpartenaire() only accepts arguments of type \Depotpartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Depotpartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDepotQuery The current query, for fluid interface
     */
    public function joinDepotpartenaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Depotpartenaire');

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
            $this->addJoinObject($join, 'Depotpartenaire');
        }

        return $this;
    }

    /**
     * Use the Depotpartenaire relation Depotpartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DepotpartenaireQuery A secondary query class using the current class as primary query
     */
    public function useDepotpartenaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDepotpartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Depotpartenaire', '\DepotpartenaireQuery');
    }

    /**
     * Filter the query by a related \Stockdepot object
     *
     * @param \Stockdepot|ObjectCollection $stockdepot the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDepotQuery The current query, for fluid interface
     */
    public function filterByStockdepot($stockdepot, $comparison = null)
    {
        if ($stockdepot instanceof \Stockdepot) {
            return $this
                ->addUsingAlias(DepotTableMap::COL_ID_DEPOT, $stockdepot->getId_depot_PK(), $comparison);
        } elseif ($stockdepot instanceof ObjectCollection) {
            return $this
                ->useStockdepotQuery()
                ->filterByPrimaryKeys($stockdepot->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStockdepot() only accepts arguments of type \Stockdepot or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Stockdepot relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDepotQuery The current query, for fluid interface
     */
    public function joinStockdepot($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Stockdepot');

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
            $this->addJoinObject($join, 'Stockdepot');
        }

        return $this;
    }

    /**
     * Use the Stockdepot relation Stockdepot object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StockdepotQuery A secondary query class using the current class as primary query
     */
    public function useStockdepotQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStockdepot($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Stockdepot', '\StockdepotQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDepot $depot Object to remove from the list of results
     *
     * @return $this|ChildDepotQuery The current query, for fluid interface
     */
    public function prune($depot = null)
    {
        if ($depot) {
            $this->addUsingAlias(DepotTableMap::COL_ID_DEPOT, $depot->getIddepot(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the depot table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DepotTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DepotTableMap::clearInstancePool();
            DepotTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DepotTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DepotTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DepotTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DepotTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DepotQuery
