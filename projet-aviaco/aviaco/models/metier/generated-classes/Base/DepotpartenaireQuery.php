<?php

namespace Base;

use \Depotpartenaire as ChildDepotpartenaire;
use \DepotpartenaireQuery as ChildDepotpartenaireQuery;
use \Exception;
use \PDO;
use Map\DepotpartenaireTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'partenaire_depot' table.
 *
 *
 *
 * @method     ChildDepotpartenaireQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildDepotpartenaireQuery orderByPart_id_PK($order = Criteria::ASC) Order by the part_id_PK column
 * @method     ChildDepotpartenaireQuery orderById_depot_PK($order = Criteria::ASC) Order by the id_depot_PK column
 *
 * @method     ChildDepotpartenaireQuery groupByID() Group by the id column
 * @method     ChildDepotpartenaireQuery groupByPart_id_PK() Group by the part_id_PK column
 * @method     ChildDepotpartenaireQuery groupById_depot_PK() Group by the id_depot_PK column
 *
 * @method     ChildDepotpartenaireQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDepotpartenaireQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDepotpartenaireQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDepotpartenaireQuery leftJoinPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenaire relation
 * @method     ChildDepotpartenaireQuery rightJoinPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenaire relation
 * @method     ChildDepotpartenaireQuery innerJoinPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenaire relation
 *
 * @method     ChildDepotpartenaireQuery leftJoinDepot($relationAlias = null) Adds a LEFT JOIN clause to the query using the Depot relation
 * @method     ChildDepotpartenaireQuery rightJoinDepot($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Depot relation
 * @method     ChildDepotpartenaireQuery innerJoinDepot($relationAlias = null) Adds a INNER JOIN clause to the query using the Depot relation
 *
 * @method     \PartenaireQuery|\DepotQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDepotpartenaire findOne(ConnectionInterface $con = null) Return the first ChildDepotpartenaire matching the query
 * @method     ChildDepotpartenaire findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDepotpartenaire matching the query, or a new ChildDepotpartenaire object populated from the query conditions when no match is found
 *
 * @method     ChildDepotpartenaire findOneByID(int $id) Return the first ChildDepotpartenaire filtered by the id column
 * @method     ChildDepotpartenaire findOneByPart_id_PK(int $part_id_PK) Return the first ChildDepotpartenaire filtered by the part_id_PK column
 * @method     ChildDepotpartenaire findOneById_depot_PK(int $id_depot_PK) Return the first ChildDepotpartenaire filtered by the id_depot_PK column *

 * @method     ChildDepotpartenaire requirePk($key, ConnectionInterface $con = null) Return the ChildDepotpartenaire by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepotpartenaire requireOne(ConnectionInterface $con = null) Return the first ChildDepotpartenaire matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDepotpartenaire requireOneByID(int $id) Return the first ChildDepotpartenaire filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepotpartenaire requireOneByPart_id_PK(int $part_id_PK) Return the first ChildDepotpartenaire filtered by the part_id_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepotpartenaire requireOneById_depot_PK(int $id_depot_PK) Return the first ChildDepotpartenaire filtered by the id_depot_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDepotpartenaire[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDepotpartenaire objects based on current ModelCriteria
 * @method     ChildDepotpartenaire[]|ObjectCollection findByID(int $id) Return ChildDepotpartenaire objects filtered by the id column
 * @method     ChildDepotpartenaire[]|ObjectCollection findByPart_id_PK(int $part_id_PK) Return ChildDepotpartenaire objects filtered by the part_id_PK column
 * @method     ChildDepotpartenaire[]|ObjectCollection findById_depot_PK(int $id_depot_PK) Return ChildDepotpartenaire objects filtered by the id_depot_PK column
 * @method     ChildDepotpartenaire[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DepotpartenaireQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DepotpartenaireQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Depotpartenaire', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDepotpartenaireQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDepotpartenaireQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDepotpartenaireQuery) {
            return $criteria;
        }
        $query = new ChildDepotpartenaireQuery();
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
     * @return ChildDepotpartenaire|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DepotpartenaireTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DepotpartenaireTableMap::DATABASE_NAME);
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
     * @return ChildDepotpartenaire A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, part_id_PK, id_depot_PK FROM partenaire_depot WHERE id = :p0';
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
            /** @var ChildDepotpartenaire $obj */
            $obj = new ChildDepotpartenaire();
            $obj->hydrate($row);
            DepotpartenaireTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildDepotpartenaire|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DepotpartenaireTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DepotpartenaireTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(DepotpartenaireTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(DepotpartenaireTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DepotpartenaireTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the part_id_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByPart_id_PK(1234); // WHERE part_id_PK = 1234
     * $query->filterByPart_id_PK(array(12, 34)); // WHERE part_id_PK IN (12, 34)
     * $query->filterByPart_id_PK(array('min' => 12)); // WHERE part_id_PK > 12
     * </code>
     *
     * @see       filterByPartenaire()
     *
     * @param     mixed $part_id_PK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function filterByPart_id_PK($part_id_PK = null, $comparison = null)
    {
        if (is_array($part_id_PK)) {
            $useMinMax = false;
            if (isset($part_id_PK['min'])) {
                $this->addUsingAlias(DepotpartenaireTableMap::COL_PART_ID_PK, $part_id_PK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($part_id_PK['max'])) {
                $this->addUsingAlias(DepotpartenaireTableMap::COL_PART_ID_PK, $part_id_PK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DepotpartenaireTableMap::COL_PART_ID_PK, $part_id_PK, $comparison);
    }

    /**
     * Filter the query on the id_depot_PK column
     *
     * Example usage:
     * <code>
     * $query->filterById_depot_PK(1234); // WHERE id_depot_PK = 1234
     * $query->filterById_depot_PK(array(12, 34)); // WHERE id_depot_PK IN (12, 34)
     * $query->filterById_depot_PK(array('min' => 12)); // WHERE id_depot_PK > 12
     * </code>
     *
     * @see       filterByDepot()
     *
     * @param     mixed $id_depot_PK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function filterById_depot_PK($id_depot_PK = null, $comparison = null)
    {
        if (is_array($id_depot_PK)) {
            $useMinMax = false;
            if (isset($id_depot_PK['min'])) {
                $this->addUsingAlias(DepotpartenaireTableMap::COL_ID_DEPOT_PK, $id_depot_PK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id_depot_PK['max'])) {
                $this->addUsingAlias(DepotpartenaireTableMap::COL_ID_DEPOT_PK, $id_depot_PK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DepotpartenaireTableMap::COL_ID_DEPOT_PK, $id_depot_PK, $comparison);
    }

    /**
     * Filter the query by a related \Partenaire object
     *
     * @param \Partenaire|ObjectCollection $partenaire The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function filterByPartenaire($partenaire, $comparison = null)
    {
        if ($partenaire instanceof \Partenaire) {
            return $this
                ->addUsingAlias(DepotpartenaireTableMap::COL_PART_ID_PK, $partenaire->getPartenaire(), $comparison);
        } elseif ($partenaire instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DepotpartenaireTableMap::COL_PART_ID_PK, $partenaire->toKeyValue('PrimaryKey', 'Partenaire'), $comparison);
        } else {
            throw new PropelException('filterByPartenaire() only accepts arguments of type \Partenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Partenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function joinPartenaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Partenaire');

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
            $this->addJoinObject($join, 'Partenaire');
        }

        return $this;
    }

    /**
     * Use the Partenaire relation Partenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PartenaireQuery A secondary query class using the current class as primary query
     */
    public function usePartenaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Partenaire', '\PartenaireQuery');
    }

    /**
     * Filter the query by a related \Depot object
     *
     * @param \Depot|ObjectCollection $depot The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function filterByDepot($depot, $comparison = null)
    {
        if ($depot instanceof \Depot) {
            return $this
                ->addUsingAlias(DepotpartenaireTableMap::COL_ID_DEPOT_PK, $depot->getIddepot(), $comparison);
        } elseif ($depot instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DepotpartenaireTableMap::COL_ID_DEPOT_PK, $depot->toKeyValue('PrimaryKey', 'Iddepot'), $comparison);
        } else {
            throw new PropelException('filterByDepot() only accepts arguments of type \Depot or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Depot relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function joinDepot($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Depot');

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
            $this->addJoinObject($join, 'Depot');
        }

        return $this;
    }

    /**
     * Use the Depot relation Depot object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DepotQuery A secondary query class using the current class as primary query
     */
    public function useDepotQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDepot($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Depot', '\DepotQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDepotpartenaire $depotpartenaire Object to remove from the list of results
     *
     * @return $this|ChildDepotpartenaireQuery The current query, for fluid interface
     */
    public function prune($depotpartenaire = null)
    {
        if ($depotpartenaire) {
            $this->addUsingAlias(DepotpartenaireTableMap::COL_ID, $depotpartenaire->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the partenaire_depot table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DepotpartenaireTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DepotpartenaireTableMap::clearInstancePool();
            DepotpartenaireTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DepotpartenaireTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DepotpartenaireTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DepotpartenaireTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DepotpartenaireTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DepotpartenaireQuery
