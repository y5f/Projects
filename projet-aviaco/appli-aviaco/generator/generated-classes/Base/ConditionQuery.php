<?php

namespace Base;

use \Condition as ChildCondition;
use \ConditionQuery as ChildConditionQuery;
use \Exception;
use \PDO;
use Map\ConditionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cond' table.
 *
 *
 *
 * @method     ChildConditionQuery orderByCondition($order = Criteria::ASC) Order by the cond column
 * @method     ChildConditionQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 *
 * @method     ChildConditionQuery groupByCondition() Group by the cond column
 * @method     ChildConditionQuery groupByCommentaire() Group by the commentaire column
 *
 * @method     ChildConditionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildConditionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildConditionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildConditionQuery leftJoinFournisseur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fournisseur relation
 * @method     ChildConditionQuery rightJoinFournisseur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fournisseur relation
 * @method     ChildConditionQuery innerJoinFournisseur($relationAlias = null) Adds a INNER JOIN clause to the query using the Fournisseur relation
 *
 * @method     ChildConditionQuery leftJoinCOMCondition($relationAlias = null) Adds a LEFT JOIN clause to the query using the COMCondition relation
 * @method     ChildConditionQuery rightJoinCOMCondition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the COMCondition relation
 * @method     ChildConditionQuery innerJoinCOMCondition($relationAlias = null) Adds a INNER JOIN clause to the query using the COMCondition relation
 *
 * @method     \FournisseurQuery|\COMConditionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCondition findOne(ConnectionInterface $con = null) Return the first ChildCondition matching the query
 * @method     ChildCondition findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCondition matching the query, or a new ChildCondition object populated from the query conditions when no match is found
 *
 * @method     ChildCondition findOneByCondition(string $cond) Return the first ChildCondition filtered by the cond column
 * @method     ChildCondition findOneByCommentaire(string $commentaire) Return the first ChildCondition filtered by the commentaire column *

 * @method     ChildCondition requirePk($key, ConnectionInterface $con = null) Return the ChildCondition by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCondition requireOne(ConnectionInterface $con = null) Return the first ChildCondition matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCondition requireOneByCondition(string $cond) Return the first ChildCondition filtered by the cond column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCondition requireOneByCommentaire(string $commentaire) Return the first ChildCondition filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCondition[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCondition objects based on current ModelCriteria
 * @method     ChildCondition[]|ObjectCollection findByCondition(string $cond) Return ChildCondition objects filtered by the cond column
 * @method     ChildCondition[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildCondition objects filtered by the commentaire column
 * @method     ChildCondition[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ConditionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ConditionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Condition', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildConditionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildConditionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildConditionQuery) {
            return $criteria;
        }
        $query = new ChildConditionQuery();
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
     * @return ChildCondition|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ConditionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ConditionTableMap::DATABASE_NAME);
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
     * @return ChildCondition A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT cond, commentaire FROM cond WHERE cond = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCondition $obj */
            $obj = new ChildCondition();
            $obj->hydrate($row);
            ConditionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCondition|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildConditionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ConditionTableMap::COL_COND, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildConditionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ConditionTableMap::COL_COND, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the cond column
     *
     * Example usage:
     * <code>
     * $query->filterByCondition('fooValue');   // WHERE cond = 'fooValue'
     * $query->filterByCondition('%fooValue%'); // WHERE cond LIKE '%fooValue%'
     * </code>
     *
     * @param     string $condition The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildConditionQuery The current query, for fluid interface
     */
    public function filterByCondition($condition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($condition)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $condition)) {
                $condition = str_replace('*', '%', $condition);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ConditionTableMap::COL_COND, $condition, $comparison);
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
     * @return $this|ChildConditionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ConditionTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
    }

    /**
     * Filter the query by a related \Fournisseur object
     *
     * @param \Fournisseur|ObjectCollection $fournisseur the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConditionQuery The current query, for fluid interface
     */
    public function filterByFournisseur($fournisseur, $comparison = null)
    {
        if ($fournisseur instanceof \Fournisseur) {
            return $this
                ->addUsingAlias(ConditionTableMap::COL_COND, $fournisseur->getVCondition(), $comparison);
        } elseif ($fournisseur instanceof ObjectCollection) {
            return $this
                ->useFournisseurQuery()
                ->filterByPrimaryKeys($fournisseur->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFournisseur() only accepts arguments of type \Fournisseur or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Fournisseur relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildConditionQuery The current query, for fluid interface
     */
    public function joinFournisseur($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Fournisseur');

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
            $this->addJoinObject($join, 'Fournisseur');
        }

        return $this;
    }

    /**
     * Use the Fournisseur relation Fournisseur object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FournisseurQuery A secondary query class using the current class as primary query
     */
    public function useFournisseurQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFournisseur($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Fournisseur', '\FournisseurQuery');
    }

    /**
     * Filter the query by a related \COMCondition object
     *
     * @param \COMCondition|ObjectCollection $cOMCondition the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildConditionQuery The current query, for fluid interface
     */
    public function filterByCOMCondition($cOMCondition, $comparison = null)
    {
        if ($cOMCondition instanceof \COMCondition) {
            return $this
                ->addUsingAlias(ConditionTableMap::COL_COND, $cOMCondition->getCondition_FK(), $comparison);
        } elseif ($cOMCondition instanceof ObjectCollection) {
            return $this
                ->useCOMConditionQuery()
                ->filterByPrimaryKeys($cOMCondition->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCOMCondition() only accepts arguments of type \COMCondition or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the COMCondition relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildConditionQuery The current query, for fluid interface
     */
    public function joinCOMCondition($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('COMCondition');

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
            $this->addJoinObject($join, 'COMCondition');
        }

        return $this;
    }

    /**
     * Use the COMCondition relation COMCondition object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \COMConditionQuery A secondary query class using the current class as primary query
     */
    public function useCOMConditionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCOMCondition($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'COMCondition', '\COMConditionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCondition $condition Object to remove from the list of results
     *
     * @return $this|ChildConditionQuery The current query, for fluid interface
     */
    public function prune($condition = null)
    {
        if ($condition) {
            $this->addUsingAlias(ConditionTableMap::COL_COND, $condition->getCondition(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cond table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConditionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ConditionTableMap::clearInstancePool();
            ConditionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ConditionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ConditionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ConditionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ConditionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ConditionQuery
