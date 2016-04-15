<?php

namespace Base;

use \Metier as ChildMetier;
use \MetierQuery as ChildMetierQuery;
use \Exception;
use \PDO;
use Map\MetierTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'metier' table.
 *
 *
 *
 * @method     ChildMetierQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildMetierQuery orderByMetier($order = Criteria::ASC) Order by the metier column
 *
 * @method     ChildMetierQuery groupByID() Group by the id column
 * @method     ChildMetierQuery groupByMetier() Group by the metier column
 *
 * @method     ChildMetierQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMetierQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMetierQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMetierQuery leftJoinSocietemetier($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societemetier relation
 * @method     ChildMetierQuery rightJoinSocietemetier($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societemetier relation
 * @method     ChildMetierQuery innerJoinSocietemetier($relationAlias = null) Adds a INNER JOIN clause to the query using the Societemetier relation
 *
 * @method     \SocietemetierQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMetier findOne(ConnectionInterface $con = null) Return the first ChildMetier matching the query
 * @method     ChildMetier findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMetier matching the query, or a new ChildMetier object populated from the query conditions when no match is found
 *
 * @method     ChildMetier findOneByID(int $id) Return the first ChildMetier filtered by the id column
 * @method     ChildMetier findOneByMetier(string $metier) Return the first ChildMetier filtered by the metier column *

 * @method     ChildMetier requirePk($key, ConnectionInterface $con = null) Return the ChildMetier by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMetier requireOne(ConnectionInterface $con = null) Return the first ChildMetier matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMetier requireOneByID(int $id) Return the first ChildMetier filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMetier requireOneByMetier(string $metier) Return the first ChildMetier filtered by the metier column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMetier[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMetier objects based on current ModelCriteria
 * @method     ChildMetier[]|ObjectCollection findByID(int $id) Return ChildMetier objects filtered by the id column
 * @method     ChildMetier[]|ObjectCollection findByMetier(string $metier) Return ChildMetier objects filtered by the metier column
 * @method     ChildMetier[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MetierQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MetierQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Metier', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMetierQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMetierQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMetierQuery) {
            return $criteria;
        }
        $query = new ChildMetierQuery();
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
     * @return ChildMetier|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MetierTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MetierTableMap::DATABASE_NAME);
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
     * @return ChildMetier A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, metier FROM metier WHERE id = :p0';
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
            /** @var ChildMetier $obj */
            $obj = new ChildMetier();
            $obj->hydrate($row);
            MetierTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMetier|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMetierQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MetierTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMetierQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MetierTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildMetierQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(MetierTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(MetierTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MetierTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the metier column
     *
     * Example usage:
     * <code>
     * $query->filterByMetier('fooValue');   // WHERE metier = 'fooValue'
     * $query->filterByMetier('%fooValue%'); // WHERE metier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metier The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMetierQuery The current query, for fluid interface
     */
    public function filterByMetier($metier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metier)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $metier)) {
                $metier = str_replace('*', '%', $metier);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MetierTableMap::COL_METIER, $metier, $comparison);
    }

    /**
     * Filter the query by a related \Societemetier object
     *
     * @param \Societemetier|ObjectCollection $societemetier the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMetierQuery The current query, for fluid interface
     */
    public function filterBySocietemetier($societemetier, $comparison = null)
    {
        if ($societemetier instanceof \Societemetier) {
            return $this
                ->addUsingAlias(MetierTableMap::COL_METIER, $societemetier->getMetier_PK(), $comparison);
        } elseif ($societemetier instanceof ObjectCollection) {
            return $this
                ->useSocietemetierQuery()
                ->filterByPrimaryKeys($societemetier->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySocietemetier() only accepts arguments of type \Societemetier or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societemetier relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMetierQuery The current query, for fluid interface
     */
    public function joinSocietemetier($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societemetier');

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
            $this->addJoinObject($join, 'Societemetier');
        }

        return $this;
    }

    /**
     * Use the Societemetier relation Societemetier object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocietemetierQuery A secondary query class using the current class as primary query
     */
    public function useSocietemetierQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocietemetier($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societemetier', '\SocietemetierQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMetier $metier Object to remove from the list of results
     *
     * @return $this|ChildMetierQuery The current query, for fluid interface
     */
    public function prune($metier = null)
    {
        if ($metier) {
            $this->addUsingAlias(MetierTableMap::COL_ID, $metier->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the metier table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MetierTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MetierTableMap::clearInstancePool();
            MetierTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MetierTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MetierTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MetierTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MetierTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MetierQuery
