<?php

namespace Base;

use \CMDTDoc as ChildCMDTDoc;
use \CMDTDocQuery as ChildCMDTDocQuery;
use \Exception;
use \PDO;
use Map\CMDTDocTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cmd_doc' table.
 *
 *
 *
 * @method     ChildCMDTDocQuery orderByTDoc_FK($order = Criteria::ASC) Order by the type_doc_FK column
 * @method     ChildCMDTDocQuery orderByIDCommande_FK($order = Criteria::ASC) Order by the id_commande_FK column
 *
 * @method     ChildCMDTDocQuery groupByTDoc_FK() Group by the type_doc_FK column
 * @method     ChildCMDTDocQuery groupByIDCommande_FK() Group by the id_commande_FK column
 *
 * @method     ChildCMDTDocQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCMDTDocQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCMDTDocQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCMDTDocQuery leftJoinCommande($relationAlias = null) Adds a LEFT JOIN clause to the query using the Commande relation
 * @method     ChildCMDTDocQuery rightJoinCommande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Commande relation
 * @method     ChildCMDTDocQuery innerJoinCommande($relationAlias = null) Adds a INNER JOIN clause to the query using the Commande relation
 *
 * @method     ChildCMDTDocQuery leftJoinTDoc($relationAlias = null) Adds a LEFT JOIN clause to the query using the TDoc relation
 * @method     ChildCMDTDocQuery rightJoinTDoc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TDoc relation
 * @method     ChildCMDTDocQuery innerJoinTDoc($relationAlias = null) Adds a INNER JOIN clause to the query using the TDoc relation
 *
 * @method     \CommandeQuery|\TDocQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCMDTDoc findOne(ConnectionInterface $con = null) Return the first ChildCMDTDoc matching the query
 * @method     ChildCMDTDoc findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCMDTDoc matching the query, or a new ChildCMDTDoc object populated from the query conditions when no match is found
 *
 * @method     ChildCMDTDoc findOneByTDoc_FK(string $type_doc_FK) Return the first ChildCMDTDoc filtered by the type_doc_FK column
 * @method     ChildCMDTDoc findOneByIDCommande_FK(int $id_commande_FK) Return the first ChildCMDTDoc filtered by the id_commande_FK column *

 * @method     ChildCMDTDoc requirePk($key, ConnectionInterface $con = null) Return the ChildCMDTDoc by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDTDoc requireOne(ConnectionInterface $con = null) Return the first ChildCMDTDoc matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCMDTDoc requireOneByTDoc_FK(string $type_doc_FK) Return the first ChildCMDTDoc filtered by the type_doc_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDTDoc requireOneByIDCommande_FK(int $id_commande_FK) Return the first ChildCMDTDoc filtered by the id_commande_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCMDTDoc[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCMDTDoc objects based on current ModelCriteria
 * @method     ChildCMDTDoc[]|ObjectCollection findByTDoc_FK(string $type_doc_FK) Return ChildCMDTDoc objects filtered by the type_doc_FK column
 * @method     ChildCMDTDoc[]|ObjectCollection findByIDCommande_FK(int $id_commande_FK) Return ChildCMDTDoc objects filtered by the id_commande_FK column
 * @method     ChildCMDTDoc[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CMDTDocQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CMDTDocQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\CMDTDoc', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCMDTDocQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCMDTDocQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCMDTDocQuery) {
            return $criteria;
        }
        $query = new ChildCMDTDocQuery();
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
     * @param array[$type_doc_FK, $id_commande_FK] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCMDTDoc|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CMDTDocTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CMDTDocTableMap::DATABASE_NAME);
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
     * @return ChildCMDTDoc A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT type_doc_FK, id_commande_FK FROM cmd_doc WHERE type_doc_FK = :p0 AND id_commande_FK = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCMDTDoc $obj */
            $obj = new ChildCMDTDoc();
            $obj->hydrate($row);
            CMDTDocTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCMDTDoc|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCMDTDocQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CMDTDocTableMap::COL_TYPE_DOC_FK, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CMDTDocTableMap::COL_ID_COMMANDE_FK, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCMDTDocQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CMDTDocTableMap::COL_TYPE_DOC_FK, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CMDTDocTableMap::COL_ID_COMMANDE_FK, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the type_doc_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByTDoc_FK('fooValue');   // WHERE type_doc_FK = 'fooValue'
     * $query->filterByTDoc_FK('%fooValue%'); // WHERE type_doc_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tDoc_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDTDocQuery The current query, for fluid interface
     */
    public function filterByTDoc_FK($tDoc_FK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tDoc_FK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tDoc_FK)) {
                $tDoc_FK = str_replace('*', '%', $tDoc_FK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CMDTDocTableMap::COL_TYPE_DOC_FK, $tDoc_FK, $comparison);
    }

    /**
     * Filter the query on the id_commande_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIDCommande_FK(1234); // WHERE id_commande_FK = 1234
     * $query->filterByIDCommande_FK(array(12, 34)); // WHERE id_commande_FK IN (12, 34)
     * $query->filterByIDCommande_FK(array('min' => 12)); // WHERE id_commande_FK > 12
     * </code>
     *
     * @see       filterByCommande()
     *
     * @param     mixed $iDCommande_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDTDocQuery The current query, for fluid interface
     */
    public function filterByIDCommande_FK($iDCommande_FK = null, $comparison = null)
    {
        if (is_array($iDCommande_FK)) {
            $useMinMax = false;
            if (isset($iDCommande_FK['min'])) {
                $this->addUsingAlias(CMDTDocTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDCommande_FK['max'])) {
                $this->addUsingAlias(CMDTDocTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDTDocTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK, $comparison);
    }

    /**
     * Filter the query by a related \Commande object
     *
     * @param \Commande|ObjectCollection $commande The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCMDTDocQuery The current query, for fluid interface
     */
    public function filterByCommande($commande, $comparison = null)
    {
        if ($commande instanceof \Commande) {
            return $this
                ->addUsingAlias(CMDTDocTableMap::COL_ID_COMMANDE_FK, $commande->getIDCommande(), $comparison);
        } elseif ($commande instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CMDTDocTableMap::COL_ID_COMMANDE_FK, $commande->toKeyValue('PrimaryKey', 'IDCommande'), $comparison);
        } else {
            throw new PropelException('filterByCommande() only accepts arguments of type \Commande or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Commande relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCMDTDocQuery The current query, for fluid interface
     */
    public function joinCommande($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Commande');

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
            $this->addJoinObject($join, 'Commande');
        }

        return $this;
    }

    /**
     * Use the Commande relation Commande object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CommandeQuery A secondary query class using the current class as primary query
     */
    public function useCommandeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCommande($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Commande', '\CommandeQuery');
    }

    /**
     * Filter the query by a related \TDoc object
     *
     * @param \TDoc|ObjectCollection $tDoc The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCMDTDocQuery The current query, for fluid interface
     */
    public function filterByTDoc($tDoc, $comparison = null)
    {
        if ($tDoc instanceof \TDoc) {
            return $this
                ->addUsingAlias(CMDTDocTableMap::COL_TYPE_DOC_FK, $tDoc->getTDoc(), $comparison);
        } elseif ($tDoc instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CMDTDocTableMap::COL_TYPE_DOC_FK, $tDoc->toKeyValue('PrimaryKey', 'TDoc'), $comparison);
        } else {
            throw new PropelException('filterByTDoc() only accepts arguments of type \TDoc or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TDoc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCMDTDocQuery The current query, for fluid interface
     */
    public function joinTDoc($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TDoc');

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
            $this->addJoinObject($join, 'TDoc');
        }

        return $this;
    }

    /**
     * Use the TDoc relation TDoc object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TDocQuery A secondary query class using the current class as primary query
     */
    public function useTDocQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTDoc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TDoc', '\TDocQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCMDTDoc $cMDTDoc Object to remove from the list of results
     *
     * @return $this|ChildCMDTDocQuery The current query, for fluid interface
     */
    public function prune($cMDTDoc = null)
    {
        if ($cMDTDoc) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CMDTDocTableMap::COL_TYPE_DOC_FK), $cMDTDoc->getTDoc_FK(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CMDTDocTableMap::COL_ID_COMMANDE_FK), $cMDTDoc->getIDCommande_FK(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cmd_doc table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CMDTDocTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CMDTDocTableMap::clearInstancePool();
            CMDTDocTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CMDTDocTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CMDTDocTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CMDTDocTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CMDTDocTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CMDTDocQuery
