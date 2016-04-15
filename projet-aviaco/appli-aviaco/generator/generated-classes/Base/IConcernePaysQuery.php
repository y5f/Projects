<?php

namespace Base;

use \IConcernePays as ChildIConcernePays;
use \IConcernePaysQuery as ChildIConcernePaysQuery;
use \Exception;
use \PDO;
use Map\IConcernePaysTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'infos_concerne_pays' table.
 *
 *
 *
 * @method     ChildIConcernePaysQuery orderByIDInfos($order = Criteria::ASC) Order by the indx_infos column
 * @method     ChildIConcernePaysQuery orderByIDPays($order = Criteria::ASC) Order by the indx_pays column
 *
 * @method     ChildIConcernePaysQuery groupByIDInfos() Group by the indx_infos column
 * @method     ChildIConcernePaysQuery groupByIDPays() Group by the indx_pays column
 *
 * @method     ChildIConcernePaysQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIConcernePaysQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIConcernePaysQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIConcernePaysQuery leftJoinFPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the FPartenaire relation
 * @method     ChildIConcernePaysQuery rightJoinFPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FPartenaire relation
 * @method     ChildIConcernePaysQuery innerJoinFPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the FPartenaire relation
 *
 * @method     ChildIConcernePaysQuery leftJoinPays($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pays relation
 * @method     ChildIConcernePaysQuery rightJoinPays($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pays relation
 * @method     ChildIConcernePaysQuery innerJoinPays($relationAlias = null) Adds a INNER JOIN clause to the query using the Pays relation
 *
 * @method     \FPartenaireQuery|\MPaysQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildIConcernePays findOne(ConnectionInterface $con = null) Return the first ChildIConcernePays matching the query
 * @method     ChildIConcernePays findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIConcernePays matching the query, or a new ChildIConcernePays object populated from the query conditions when no match is found
 *
 * @method     ChildIConcernePays findOneByIDInfos(int $indx_infos) Return the first ChildIConcernePays filtered by the indx_infos column
 * @method     ChildIConcernePays findOneByIDPays(int $indx_pays) Return the first ChildIConcernePays filtered by the indx_pays column *

 * @method     ChildIConcernePays requirePk($key, ConnectionInterface $con = null) Return the ChildIConcernePays by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIConcernePays requireOne(ConnectionInterface $con = null) Return the first ChildIConcernePays matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIConcernePays requireOneByIDInfos(int $indx_infos) Return the first ChildIConcernePays filtered by the indx_infos column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIConcernePays requireOneByIDPays(int $indx_pays) Return the first ChildIConcernePays filtered by the indx_pays column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIConcernePays[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIConcernePays objects based on current ModelCriteria
 * @method     ChildIConcernePays[]|ObjectCollection findByIDInfos(int $indx_infos) Return ChildIConcernePays objects filtered by the indx_infos column
 * @method     ChildIConcernePays[]|ObjectCollection findByIDPays(int $indx_pays) Return ChildIConcernePays objects filtered by the indx_pays column
 * @method     ChildIConcernePays[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IConcernePaysQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\IConcernePaysQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\IConcernePays', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIConcernePaysQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIConcernePaysQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIConcernePaysQuery) {
            return $criteria;
        }
        $query = new ChildIConcernePaysQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$indx_infos, $indx_pays] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildIConcernePays|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = IConcernePaysTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IConcernePaysTableMap::DATABASE_NAME);
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
     * @return ChildIConcernePays A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT indx_infos, indx_pays FROM infos_concerne_pays WHERE indx_infos = :p0 AND indx_pays = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildIConcernePays $obj */
            $obj = new ChildIConcernePays();
            $obj->hydrate($row);
            IConcernePaysTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildIConcernePays|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(IConcernePaysTableMap::COL_INDX_INFOS, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(IConcernePaysTableMap::COL_INDX_PAYS, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(IConcernePaysTableMap::COL_INDX_INFOS, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(IConcernePaysTableMap::COL_INDX_PAYS, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the indx_infos column
     *
     * Example usage:
     * <code>
     * $query->filterByIDInfos(1234); // WHERE indx_infos = 1234
     * $query->filterByIDInfos(array(12, 34)); // WHERE indx_infos IN (12, 34)
     * $query->filterByIDInfos(array('min' => 12)); // WHERE indx_infos > 12
     * </code>
     *
     * @see       filterByFPartenaire()
     *
     * @param     mixed $iDInfos The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function filterByIDInfos($iDInfos = null, $comparison = null)
    {
        if (is_array($iDInfos)) {
            $useMinMax = false;
            if (isset($iDInfos['min'])) {
                $this->addUsingAlias(IConcernePaysTableMap::COL_INDX_INFOS, $iDInfos['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDInfos['max'])) {
                $this->addUsingAlias(IConcernePaysTableMap::COL_INDX_INFOS, $iDInfos['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IConcernePaysTableMap::COL_INDX_INFOS, $iDInfos, $comparison);
    }

    /**
     * Filter the query on the indx_pays column
     *
     * Example usage:
     * <code>
     * $query->filterByIDPays(1234); // WHERE indx_pays = 1234
     * $query->filterByIDPays(array(12, 34)); // WHERE indx_pays IN (12, 34)
     * $query->filterByIDPays(array('min' => 12)); // WHERE indx_pays > 12
     * </code>
     *
     * @see       filterByPays()
     *
     * @param     mixed $iDPays The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function filterByIDPays($iDPays = null, $comparison = null)
    {
        if (is_array($iDPays)) {
            $useMinMax = false;
            if (isset($iDPays['min'])) {
                $this->addUsingAlias(IConcernePaysTableMap::COL_INDX_PAYS, $iDPays['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDPays['max'])) {
                $this->addUsingAlias(IConcernePaysTableMap::COL_INDX_PAYS, $iDPays['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IConcernePaysTableMap::COL_INDX_PAYS, $iDPays, $comparison);
    }

    /**
     * Filter the query by a related \FPartenaire object
     *
     * @param \FPartenaire|ObjectCollection $fPartenaire The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function filterByFPartenaire($fPartenaire, $comparison = null)
    {
        if ($fPartenaire instanceof \FPartenaire) {
            return $this
                ->addUsingAlias(IConcernePaysTableMap::COL_INDX_INFOS, $fPartenaire->getIDPart(), $comparison);
        } elseif ($fPartenaire instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IConcernePaysTableMap::COL_INDX_INFOS, $fPartenaire->toKeyValue('PrimaryKey', 'IDPart'), $comparison);
        } else {
            throw new PropelException('filterByFPartenaire() only accepts arguments of type \FPartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FPartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function joinFPartenaire($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FPartenaire');

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
            $this->addJoinObject($join, 'FPartenaire');
        }

        return $this;
    }

    /**
     * Use the FPartenaire relation FPartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FPartenaireQuery A secondary query class using the current class as primary query
     */
    public function useFPartenaireQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FPartenaire', '\FPartenaireQuery');
    }

    /**
     * Filter the query by a related \MPays object
     *
     * @param \MPays|ObjectCollection $mPays The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function filterByPays($mPays, $comparison = null)
    {
        if ($mPays instanceof \MPays) {
            return $this
                ->addUsingAlias(IConcernePaysTableMap::COL_INDX_PAYS, $mPays->getID(), $comparison);
        } elseif ($mPays instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IConcernePaysTableMap::COL_INDX_PAYS, $mPays->toKeyValue('PrimaryKey', 'ID'), $comparison);
        } else {
            throw new PropelException('filterByPays() only accepts arguments of type \MPays or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pays relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function joinPays($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pays');

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
            $this->addJoinObject($join, 'Pays');
        }

        return $this;
    }

    /**
     * Use the Pays relation MPays object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MPaysQuery A secondary query class using the current class as primary query
     */
    public function usePaysQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPays($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pays', '\MPaysQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildIConcernePays $iConcernePays Object to remove from the list of results
     *
     * @return $this|ChildIConcernePaysQuery The current query, for fluid interface
     */
    public function prune($iConcernePays = null)
    {
        if ($iConcernePays) {
            $this->addCond('pruneCond0', $this->getAliasedColName(IConcernePaysTableMap::COL_INDX_INFOS), $iConcernePays->getIDInfos(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(IConcernePaysTableMap::COL_INDX_PAYS), $iConcernePays->getIDPays(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the infos_concerne_pays table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IConcernePaysTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IConcernePaysTableMap::clearInstancePool();
            IConcernePaysTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(IConcernePaysTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IConcernePaysTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            IConcernePaysTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            IConcernePaysTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // IConcernePaysQuery
