<?php

namespace Base;

use \TDoc as ChildTDoc;
use \TDocQuery as ChildTDocQuery;
use \Exception;
use \PDO;
use Map\TDocTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'typedoc' table.
 *
 *
 *
 * @method     ChildTDocQuery orderByTDoc($order = Criteria::ASC) Order by the type column
 * @method     ChildTDocQuery orderByCommentaire($order = Criteria::ASC) Order by the comment column
 *
 * @method     ChildTDocQuery groupByTDoc() Group by the type column
 * @method     ChildTDocQuery groupByCommentaire() Group by the comment column
 *
 * @method     ChildTDocQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTDocQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTDocQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTDocQuery leftJoinCMDTDoc($relationAlias = null) Adds a LEFT JOIN clause to the query using the CMDTDoc relation
 * @method     ChildTDocQuery rightJoinCMDTDoc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CMDTDoc relation
 * @method     ChildTDocQuery innerJoinCMDTDoc($relationAlias = null) Adds a INNER JOIN clause to the query using the CMDTDoc relation
 *
 * @method     \CMDTDocQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTDoc findOne(ConnectionInterface $con = null) Return the first ChildTDoc matching the query
 * @method     ChildTDoc findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTDoc matching the query, or a new ChildTDoc object populated from the query conditions when no match is found
 *
 * @method     ChildTDoc findOneByTDoc(string $type) Return the first ChildTDoc filtered by the type column
 * @method     ChildTDoc findOneByCommentaire(string $comment) Return the first ChildTDoc filtered by the comment column *

 * @method     ChildTDoc requirePk($key, ConnectionInterface $con = null) Return the ChildTDoc by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTDoc requireOne(ConnectionInterface $con = null) Return the first ChildTDoc matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTDoc requireOneByTDoc(string $type) Return the first ChildTDoc filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTDoc requireOneByCommentaire(string $comment) Return the first ChildTDoc filtered by the comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTDoc[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTDoc objects based on current ModelCriteria
 * @method     ChildTDoc[]|ObjectCollection findByTDoc(string $type) Return ChildTDoc objects filtered by the type column
 * @method     ChildTDoc[]|ObjectCollection findByCommentaire(string $comment) Return ChildTDoc objects filtered by the comment column
 * @method     ChildTDoc[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TDocQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TDocQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\TDoc', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTDocQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTDocQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTDocQuery) {
            return $criteria;
        }
        $query = new ChildTDocQuery();
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
     * @return ChildTDoc|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TDocTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TDocTableMap::DATABASE_NAME);
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
     * @return ChildTDoc A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT type, comment FROM typedoc WHERE type = :p0';
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
            /** @var ChildTDoc $obj */
            $obj = new ChildTDoc();
            $obj->hydrate($row);
            TDocTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTDoc|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTDocQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TDocTableMap::COL_TYPE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTDocQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TDocTableMap::COL_TYPE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByTDoc('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByTDoc('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tDoc The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTDocQuery The current query, for fluid interface
     */
    public function filterByTDoc($tDoc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tDoc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tDoc)) {
                $tDoc = str_replace('*', '%', $tDoc);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TDocTableMap::COL_TYPE, $tDoc, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByCommentaire('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByCommentaire('%fooValue%'); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $commentaire The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTDocQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TDocTableMap::COL_COMMENT, $commentaire, $comparison);
    }

    /**
     * Filter the query by a related \CMDTDoc object
     *
     * @param \CMDTDoc|ObjectCollection $cMDTDoc the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTDocQuery The current query, for fluid interface
     */
    public function filterByCMDTDoc($cMDTDoc, $comparison = null)
    {
        if ($cMDTDoc instanceof \CMDTDoc) {
            return $this
                ->addUsingAlias(TDocTableMap::COL_TYPE, $cMDTDoc->getTDoc_FK(), $comparison);
        } elseif ($cMDTDoc instanceof ObjectCollection) {
            return $this
                ->useCMDTDocQuery()
                ->filterByPrimaryKeys($cMDTDoc->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCMDTDoc() only accepts arguments of type \CMDTDoc or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CMDTDoc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTDocQuery The current query, for fluid interface
     */
    public function joinCMDTDoc($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CMDTDoc');

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
            $this->addJoinObject($join, 'CMDTDoc');
        }

        return $this;
    }

    /**
     * Use the CMDTDoc relation CMDTDoc object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CMDTDocQuery A secondary query class using the current class as primary query
     */
    public function useCMDTDocQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCMDTDoc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CMDTDoc', '\CMDTDocQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTDoc $tDoc Object to remove from the list of results
     *
     * @return $this|ChildTDocQuery The current query, for fluid interface
     */
    public function prune($tDoc = null)
    {
        if ($tDoc) {
            $this->addUsingAlias(TDocTableMap::COL_TYPE, $tDoc->getTDoc(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the typedoc table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TDocTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TDocTableMap::clearInstancePool();
            TDocTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TDocTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TDocTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TDocTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TDocTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TDocQuery
