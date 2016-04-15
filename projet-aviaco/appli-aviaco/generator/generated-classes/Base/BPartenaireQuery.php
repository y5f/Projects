<?php

namespace Base;

use \BPartenaire as ChildBPartenaire;
use \BPartenaireQuery as ChildBPartenaireQuery;
use \Exception;
use \PDO;
use Map\BPartenaireTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'base_part' table.
 *
 *
 *
 * @method     ChildBPartenaireQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildBPartenaireQuery orderByisDisponible($order = Criteria::ASC) Order by the disponible column
 * @method     ChildBPartenaireQuery orderByIDBase($order = Criteria::ASC) Order by the indx_base column
 * @method     ChildBPartenaireQuery orderByIDPart($order = Criteria::ASC) Order by the indx_part column
 *
 * @method     ChildBPartenaireQuery groupByID() Group by the id column
 * @method     ChildBPartenaireQuery groupByisDisponible() Group by the disponible column
 * @method     ChildBPartenaireQuery groupByIDBase() Group by the indx_base column
 * @method     ChildBPartenaireQuery groupByIDPart() Group by the indx_part column
 *
 * @method     ChildBPartenaireQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBPartenaireQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBPartenaireQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBPartenaireQuery leftJoinPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenaire relation
 * @method     ChildBPartenaireQuery rightJoinPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenaire relation
 * @method     ChildBPartenaireQuery innerJoinPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenaire relation
 *
 * @method     ChildBPartenaireQuery leftJoinBaseInfos($relationAlias = null) Adds a LEFT JOIN clause to the query using the BaseInfos relation
 * @method     ChildBPartenaireQuery rightJoinBaseInfos($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BaseInfos relation
 * @method     ChildBPartenaireQuery innerJoinBaseInfos($relationAlias = null) Adds a INNER JOIN clause to the query using the BaseInfos relation
 *
 * @method     \PartenaireQuery|\BaseInfosQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBPartenaire findOne(ConnectionInterface $con = null) Return the first ChildBPartenaire matching the query
 * @method     ChildBPartenaire findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBPartenaire matching the query, or a new ChildBPartenaire object populated from the query conditions when no match is found
 *
 * @method     ChildBPartenaire findOneByID(int $id) Return the first ChildBPartenaire filtered by the id column
 * @method     ChildBPartenaire findOneByisDisponible(boolean $disponible) Return the first ChildBPartenaire filtered by the disponible column
 * @method     ChildBPartenaire findOneByIDBase(int $indx_base) Return the first ChildBPartenaire filtered by the indx_base column
 * @method     ChildBPartenaire findOneByIDPart(int $indx_part) Return the first ChildBPartenaire filtered by the indx_part column *

 * @method     ChildBPartenaire requirePk($key, ConnectionInterface $con = null) Return the ChildBPartenaire by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBPartenaire requireOne(ConnectionInterface $con = null) Return the first ChildBPartenaire matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBPartenaire requireOneByID(int $id) Return the first ChildBPartenaire filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBPartenaire requireOneByisDisponible(boolean $disponible) Return the first ChildBPartenaire filtered by the disponible column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBPartenaire requireOneByIDBase(int $indx_base) Return the first ChildBPartenaire filtered by the indx_base column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBPartenaire requireOneByIDPart(int $indx_part) Return the first ChildBPartenaire filtered by the indx_part column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBPartenaire[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBPartenaire objects based on current ModelCriteria
 * @method     ChildBPartenaire[]|ObjectCollection findByID(int $id) Return ChildBPartenaire objects filtered by the id column
 * @method     ChildBPartenaire[]|ObjectCollection findByisDisponible(boolean $disponible) Return ChildBPartenaire objects filtered by the disponible column
 * @method     ChildBPartenaire[]|ObjectCollection findByIDBase(int $indx_base) Return ChildBPartenaire objects filtered by the indx_base column
 * @method     ChildBPartenaire[]|ObjectCollection findByIDPart(int $indx_part) Return ChildBPartenaire objects filtered by the indx_part column
 * @method     ChildBPartenaire[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BPartenaireQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BPartenaireQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\BPartenaire', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBPartenaireQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBPartenaireQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBPartenaireQuery) {
            return $criteria;
        }
        $query = new ChildBPartenaireQuery();
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
     * @return ChildBPartenaire|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BPartenaireTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BPartenaireTableMap::DATABASE_NAME);
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
     * @return ChildBPartenaire A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, disponible, indx_base, indx_part FROM base_part WHERE id = :p0';
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
            /** @var ChildBPartenaire $obj */
            $obj = new ChildBPartenaire();
            $obj->hydrate($row);
            BPartenaireTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildBPartenaire|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BPartenaireTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BPartenaireTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(BPartenaireTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(BPartenaireTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BPartenaireTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the disponible column
     *
     * Example usage:
     * <code>
     * $query->filterByisDisponible(true); // WHERE disponible = true
     * $query->filterByisDisponible('yes'); // WHERE disponible = true
     * </code>
     *
     * @param     boolean|string $isDisponible The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
     */
    public function filterByisDisponible($isDisponible = null, $comparison = null)
    {
        if (is_string($isDisponible)) {
            $isDisponible = in_array(strtolower($isDisponible), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(BPartenaireTableMap::COL_DISPONIBLE, $isDisponible, $comparison);
    }

    /**
     * Filter the query on the indx_base column
     *
     * Example usage:
     * <code>
     * $query->filterByIDBase(1234); // WHERE indx_base = 1234
     * $query->filterByIDBase(array(12, 34)); // WHERE indx_base IN (12, 34)
     * $query->filterByIDBase(array('min' => 12)); // WHERE indx_base > 12
     * </code>
     *
     * @see       filterByBaseInfos()
     *
     * @param     mixed $iDBase The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
     */
    public function filterByIDBase($iDBase = null, $comparison = null)
    {
        if (is_array($iDBase)) {
            $useMinMax = false;
            if (isset($iDBase['min'])) {
                $this->addUsingAlias(BPartenaireTableMap::COL_INDX_BASE, $iDBase['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDBase['max'])) {
                $this->addUsingAlias(BPartenaireTableMap::COL_INDX_BASE, $iDBase['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BPartenaireTableMap::COL_INDX_BASE, $iDBase, $comparison);
    }

    /**
     * Filter the query on the indx_part column
     *
     * Example usage:
     * <code>
     * $query->filterByIDPart(1234); // WHERE indx_part = 1234
     * $query->filterByIDPart(array(12, 34)); // WHERE indx_part IN (12, 34)
     * $query->filterByIDPart(array('min' => 12)); // WHERE indx_part > 12
     * </code>
     *
     * @see       filterByPartenaire()
     *
     * @param     mixed $iDPart The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
     */
    public function filterByIDPart($iDPart = null, $comparison = null)
    {
        if (is_array($iDPart)) {
            $useMinMax = false;
            if (isset($iDPart['min'])) {
                $this->addUsingAlias(BPartenaireTableMap::COL_INDX_PART, $iDPart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDPart['max'])) {
                $this->addUsingAlias(BPartenaireTableMap::COL_INDX_PART, $iDPart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BPartenaireTableMap::COL_INDX_PART, $iDPart, $comparison);
    }

    /**
     * Filter the query by a related \Partenaire object
     *
     * @param \Partenaire|ObjectCollection $partenaire The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBPartenaireQuery The current query, for fluid interface
     */
    public function filterByPartenaire($partenaire, $comparison = null)
    {
        if ($partenaire instanceof \Partenaire) {
            return $this
                ->addUsingAlias(BPartenaireTableMap::COL_INDX_PART, $partenaire->getID(), $comparison);
        } elseif ($partenaire instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BPartenaireTableMap::COL_INDX_PART, $partenaire->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
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
     * Filter the query by a related \BaseInfos object
     *
     * @param \BaseInfos|ObjectCollection $baseInfos The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBPartenaireQuery The current query, for fluid interface
     */
    public function filterByBaseInfos($baseInfos, $comparison = null)
    {
        if ($baseInfos instanceof \BaseInfos) {
            return $this
                ->addUsingAlias(BPartenaireTableMap::COL_INDX_BASE, $baseInfos->getID(), $comparison);
        } elseif ($baseInfos instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BPartenaireTableMap::COL_INDX_BASE, $baseInfos->toKeyValue('PrimaryKey', 'ID'), $comparison);
        } else {
            throw new PropelException('filterByBaseInfos() only accepts arguments of type \BaseInfos or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BaseInfos relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
     */
    public function joinBaseInfos($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BaseInfos');

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
            $this->addJoinObject($join, 'BaseInfos');
        }

        return $this;
    }

    /**
     * Use the BaseInfos relation BaseInfos object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BaseInfosQuery A secondary query class using the current class as primary query
     */
    public function useBaseInfosQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBaseInfos($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BaseInfos', '\BaseInfosQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBPartenaire $bPartenaire Object to remove from the list of results
     *
     * @return $this|ChildBPartenaireQuery The current query, for fluid interface
     */
    public function prune($bPartenaire = null)
    {
        if ($bPartenaire) {
            $this->addUsingAlias(BPartenaireTableMap::COL_ID, $bPartenaire->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the base_part table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BPartenaireTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BPartenaireTableMap::clearInstancePool();
            BPartenaireTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BPartenaireTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BPartenaireTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BPartenaireTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BPartenaireTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BPartenaireQuery
