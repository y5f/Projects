<?php

namespace Base;

use \Societetypepiece as ChildSocietetypepiece;
use \SocietetypepieceQuery as ChildSocietetypepieceQuery;
use \Exception;
use \PDO;
use Map\SocietetypepieceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'soctypepiece' table.
 *
 *
 *
 * @method     ChildSocietetypepieceQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildSocietetypepieceQuery orderBySociete_PK($order = Criteria::ASC) Order by the societe_PK column
 * @method     ChildSocietetypepieceQuery orderByType_PK($order = Criteria::ASC) Order by the type_PK column
 *
 * @method     ChildSocietetypepieceQuery groupByID() Group by the id column
 * @method     ChildSocietetypepieceQuery groupBySociete_PK() Group by the societe_PK column
 * @method     ChildSocietetypepieceQuery groupByType_PK() Group by the type_PK column
 *
 * @method     ChildSocietetypepieceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSocietetypepieceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSocietetypepieceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSocietetypepieceQuery leftJoinSociete($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societe relation
 * @method     ChildSocietetypepieceQuery rightJoinSociete($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societe relation
 * @method     ChildSocietetypepieceQuery innerJoinSociete($relationAlias = null) Adds a INNER JOIN clause to the query using the Societe relation
 *
 * @method     ChildSocietetypepieceQuery leftJoinTypepiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Typepiece relation
 * @method     ChildSocietetypepieceQuery rightJoinTypepiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Typepiece relation
 * @method     ChildSocietetypepieceQuery innerJoinTypepiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Typepiece relation
 *
 * @method     \SocieteQuery|\TypepieceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSocietetypepiece findOne(ConnectionInterface $con = null) Return the first ChildSocietetypepiece matching the query
 * @method     ChildSocietetypepiece findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSocietetypepiece matching the query, or a new ChildSocietetypepiece object populated from the query conditions when no match is found
 *
 * @method     ChildSocietetypepiece findOneByID(int $id) Return the first ChildSocietetypepiece filtered by the id column
 * @method     ChildSocietetypepiece findOneBySociete_PK(string $societe_PK) Return the first ChildSocietetypepiece filtered by the societe_PK column
 * @method     ChildSocietetypepiece findOneByType_PK(string $type_PK) Return the first ChildSocietetypepiece filtered by the type_PK column *

 * @method     ChildSocietetypepiece requirePk($key, ConnectionInterface $con = null) Return the ChildSocietetypepiece by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocietetypepiece requireOne(ConnectionInterface $con = null) Return the first ChildSocietetypepiece matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSocietetypepiece requireOneByID(int $id) Return the first ChildSocietetypepiece filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocietetypepiece requireOneBySociete_PK(string $societe_PK) Return the first ChildSocietetypepiece filtered by the societe_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocietetypepiece requireOneByType_PK(string $type_PK) Return the first ChildSocietetypepiece filtered by the type_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSocietetypepiece[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSocietetypepiece objects based on current ModelCriteria
 * @method     ChildSocietetypepiece[]|ObjectCollection findByID(int $id) Return ChildSocietetypepiece objects filtered by the id column
 * @method     ChildSocietetypepiece[]|ObjectCollection findBySociete_PK(string $societe_PK) Return ChildSocietetypepiece objects filtered by the societe_PK column
 * @method     ChildSocietetypepiece[]|ObjectCollection findByType_PK(string $type_PK) Return ChildSocietetypepiece objects filtered by the type_PK column
 * @method     ChildSocietetypepiece[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SocietetypepieceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SocietetypepieceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Societetypepiece', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSocietetypepieceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSocietetypepieceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSocietetypepieceQuery) {
            return $criteria;
        }
        $query = new ChildSocietetypepieceQuery();
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
     * @return ChildSocietetypepiece|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SocietetypepieceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SocietetypepieceTableMap::DATABASE_NAME);
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
     * @return ChildSocietetypepiece A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, societe_PK, type_PK FROM soctypepiece WHERE id = :p0';
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
            /** @var ChildSocietetypepiece $obj */
            $obj = new ChildSocietetypepiece();
            $obj->hydrate($row);
            SocietetypepieceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSocietetypepiece|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SocietetypepieceTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SocietetypepieceTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(SocietetypepieceTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(SocietetypepieceTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocietetypepieceTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the societe_PK column
     *
     * Example usage:
     * <code>
     * $query->filterBySociete_PK('fooValue');   // WHERE societe_PK = 'fooValue'
     * $query->filterBySociete_PK('%fooValue%'); // WHERE societe_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $societe_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function filterBySociete_PK($societe_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($societe_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $societe_PK)) {
                $societe_PK = str_replace('*', '%', $societe_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocietetypepieceTableMap::COL_SOCIETE_PK, $societe_PK, $comparison);
    }

    /**
     * Filter the query on the type_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByType_PK('fooValue');   // WHERE type_PK = 'fooValue'
     * $query->filterByType_PK('%fooValue%'); // WHERE type_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function filterByType_PK($type_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type_PK)) {
                $type_PK = str_replace('*', '%', $type_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocietetypepieceTableMap::COL_TYPE_PK, $type_PK, $comparison);
    }

    /**
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function filterBySociete($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(SocietetypepieceTableMap::COL_SOCIETE_PK, $societe->getSociete(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocietetypepieceTableMap::COL_SOCIETE_PK, $societe->toKeyValue('PrimaryKey', 'Societe'), $comparison);
        } else {
            throw new PropelException('filterBySociete() only accepts arguments of type \Societe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societe relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function joinSociete($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societe');

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
            $this->addJoinObject($join, 'Societe');
        }

        return $this;
    }

    /**
     * Use the Societe relation Societe object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocieteQuery A secondary query class using the current class as primary query
     */
    public function useSocieteQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSociete($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societe', '\SocieteQuery');
    }

    /**
     * Filter the query by a related \Typepiece object
     *
     * @param \Typepiece|ObjectCollection $typepiece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function filterByTypepiece($typepiece, $comparison = null)
    {
        if ($typepiece instanceof \Typepiece) {
            return $this
                ->addUsingAlias(SocietetypepieceTableMap::COL_TYPE_PK, $typepiece->getType(), $comparison);
        } elseif ($typepiece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocietetypepieceTableMap::COL_TYPE_PK, $typepiece->toKeyValue('PrimaryKey', 'Type'), $comparison);
        } else {
            throw new PropelException('filterByTypepiece() only accepts arguments of type \Typepiece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Typepiece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function joinTypepiece($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Typepiece');

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
            $this->addJoinObject($join, 'Typepiece');
        }

        return $this;
    }

    /**
     * Use the Typepiece relation Typepiece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TypepieceQuery A secondary query class using the current class as primary query
     */
    public function useTypepieceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTypepiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Typepiece', '\TypepieceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSocietetypepiece $societetypepiece Object to remove from the list of results
     *
     * @return $this|ChildSocietetypepieceQuery The current query, for fluid interface
     */
    public function prune($societetypepiece = null)
    {
        if ($societetypepiece) {
            $this->addUsingAlias(SocietetypepieceTableMap::COL_ID, $societetypepiece->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the soctypepiece table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SocietetypepieceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SocietetypepieceTableMap::clearInstancePool();
            SocietetypepieceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SocietetypepieceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SocietetypepieceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SocietetypepieceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SocietetypepieceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SocietetypepieceQuery
