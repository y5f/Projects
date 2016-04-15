<?php

namespace Base;

use \BaseInfos as ChildBaseInfos;
use \BaseInfosQuery as ChildBaseInfosQuery;
use \Exception;
use \PDO;
use Map\BaseInfosTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'base_infos' table.
 *
 *
 *
 * @method     ChildBaseInfosQuery orderByID($order = Criteria::ASC) Order by the indx column
 * @method     ChildBaseInfosQuery orderByTypeInfos($order = Criteria::ASC) Order by the type_infos column
 * @method     ChildBaseInfosQuery orderByUsage($order = Criteria::ASC) Order by the usage column
 *
 * @method     ChildBaseInfosQuery groupByID() Group by the indx column
 * @method     ChildBaseInfosQuery groupByTypeInfos() Group by the type_infos column
 * @method     ChildBaseInfosQuery groupByUsage() Group by the usage column
 *
 * @method     ChildBaseInfosQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBaseInfosQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBaseInfosQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBaseInfosQuery leftJoinBPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the BPartenaire relation
 * @method     ChildBaseInfosQuery rightJoinBPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BPartenaire relation
 * @method     ChildBaseInfosQuery innerJoinBPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the BPartenaire relation
 *
 * @method     \BPartenaireQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBaseInfos findOne(ConnectionInterface $con = null) Return the first ChildBaseInfos matching the query
 * @method     ChildBaseInfos findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBaseInfos matching the query, or a new ChildBaseInfos object populated from the query conditions when no match is found
 *
 * @method     ChildBaseInfos findOneByID(int $indx) Return the first ChildBaseInfos filtered by the indx column
 * @method     ChildBaseInfos findOneByTypeInfos(string $type_infos) Return the first ChildBaseInfos filtered by the type_infos column
 * @method     ChildBaseInfos findOneByUsage(string $usage) Return the first ChildBaseInfos filtered by the usage column *

 * @method     ChildBaseInfos requirePk($key, ConnectionInterface $con = null) Return the ChildBaseInfos by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBaseInfos requireOne(ConnectionInterface $con = null) Return the first ChildBaseInfos matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBaseInfos requireOneByID(int $indx) Return the first ChildBaseInfos filtered by the indx column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBaseInfos requireOneByTypeInfos(string $type_infos) Return the first ChildBaseInfos filtered by the type_infos column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBaseInfos requireOneByUsage(string $usage) Return the first ChildBaseInfos filtered by the usage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBaseInfos[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBaseInfos objects based on current ModelCriteria
 * @method     ChildBaseInfos[]|ObjectCollection findByID(int $indx) Return ChildBaseInfos objects filtered by the indx column
 * @method     ChildBaseInfos[]|ObjectCollection findByTypeInfos(string $type_infos) Return ChildBaseInfos objects filtered by the type_infos column
 * @method     ChildBaseInfos[]|ObjectCollection findByUsage(string $usage) Return ChildBaseInfos objects filtered by the usage column
 * @method     ChildBaseInfos[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BaseInfosQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BaseInfosQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\BaseInfos', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBaseInfosQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBaseInfosQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBaseInfosQuery) {
            return $criteria;
        }
        $query = new ChildBaseInfosQuery();
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
     * @return ChildBaseInfos|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BaseInfosTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BaseInfosTableMap::DATABASE_NAME);
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
     * @return ChildBaseInfos A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT indx, type_infos, usage FROM base_infos WHERE indx = :p0';
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
            /** @var ChildBaseInfos $obj */
            $obj = new ChildBaseInfos();
            $obj->hydrate($row);
            BaseInfosTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildBaseInfos|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBaseInfosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BaseInfosTableMap::COL_INDX, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBaseInfosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BaseInfosTableMap::COL_INDX, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the indx column
     *
     * Example usage:
     * <code>
     * $query->filterByID(1234); // WHERE indx = 1234
     * $query->filterByID(array(12, 34)); // WHERE indx IN (12, 34)
     * $query->filterByID(array('min' => 12)); // WHERE indx > 12
     * </code>
     *
     * @param     mixed $iD The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBaseInfosQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(BaseInfosTableMap::COL_INDX, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(BaseInfosTableMap::COL_INDX, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BaseInfosTableMap::COL_INDX, $iD, $comparison);
    }

    /**
     * Filter the query on the type_infos column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeInfos('fooValue');   // WHERE type_infos = 'fooValue'
     * $query->filterByTypeInfos('%fooValue%'); // WHERE type_infos LIKE '%fooValue%'
     * </code>
     *
     * @param     string $typeInfos The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBaseInfosQuery The current query, for fluid interface
     */
    public function filterByTypeInfos($typeInfos = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($typeInfos)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $typeInfos)) {
                $typeInfos = str_replace('*', '%', $typeInfos);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BaseInfosTableMap::COL_TYPE_INFOS, $typeInfos, $comparison);
    }

    /**
     * Filter the query on the usage column
     *
     * Example usage:
     * <code>
     * $query->filterByUsage('fooValue');   // WHERE usage = 'fooValue'
     * $query->filterByUsage('%fooValue%'); // WHERE usage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $usage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBaseInfosQuery The current query, for fluid interface
     */
    public function filterByUsage($usage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($usage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $usage)) {
                $usage = str_replace('*', '%', $usage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BaseInfosTableMap::COL_USAGE, $usage, $comparison);
    }

    /**
     * Filter the query by a related \BPartenaire object
     *
     * @param \BPartenaire|ObjectCollection $bPartenaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBaseInfosQuery The current query, for fluid interface
     */
    public function filterByBPartenaire($bPartenaire, $comparison = null)
    {
        if ($bPartenaire instanceof \BPartenaire) {
            return $this
                ->addUsingAlias(BaseInfosTableMap::COL_INDX, $bPartenaire->getIDBase(), $comparison);
        } elseif ($bPartenaire instanceof ObjectCollection) {
            return $this
                ->useBPartenaireQuery()
                ->filterByPrimaryKeys($bPartenaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBPartenaire() only accepts arguments of type \BPartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BPartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBaseInfosQuery The current query, for fluid interface
     */
    public function joinBPartenaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BPartenaire');

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
            $this->addJoinObject($join, 'BPartenaire');
        }

        return $this;
    }

    /**
     * Use the BPartenaire relation BPartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BPartenaireQuery A secondary query class using the current class as primary query
     */
    public function useBPartenaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BPartenaire', '\BPartenaireQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBaseInfos $baseInfos Object to remove from the list of results
     *
     * @return $this|ChildBaseInfosQuery The current query, for fluid interface
     */
    public function prune($baseInfos = null)
    {
        if ($baseInfos) {
            $this->addUsingAlias(BaseInfosTableMap::COL_INDX, $baseInfos->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the base_infos table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BaseInfosTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BaseInfosTableMap::clearInstancePool();
            BaseInfosTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BaseInfosTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BaseInfosTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BaseInfosTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BaseInfosTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BaseInfosQuery
