<?php

namespace Base;

use \Certificat as ChildCertificat;
use \CertificatQuery as ChildCertificatQuery;
use \Exception;
use \PDO;
use Map\CertificatTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'certificat' table.
 *
 *
 *
 * @method     ChildCertificatQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildCertificatQuery orderByAgrement($order = Criteria::ASC) Order by the agrement column
 * @method     ChildCertificatQuery orderByWeb($order = Criteria::ASC) Order by the srcweb column
 *
 * @method     ChildCertificatQuery groupByID() Group by the id column
 * @method     ChildCertificatQuery groupByAgrement() Group by the agrement column
 * @method     ChildCertificatQuery groupByWeb() Group by the srcweb column
 *
 * @method     ChildCertificatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCertificatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCertificatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCertificatQuery leftJoinAppareilcertificat($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appareilcertificat relation
 * @method     ChildCertificatQuery rightJoinAppareilcertificat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appareilcertificat relation
 * @method     ChildCertificatQuery innerJoinAppareilcertificat($relationAlias = null) Adds a INNER JOIN clause to the query using the Appareilcertificat relation
 *
 * @method     ChildCertificatQuery leftJoinSocietecertificat($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societecertificat relation
 * @method     ChildCertificatQuery rightJoinSocietecertificat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societecertificat relation
 * @method     ChildCertificatQuery innerJoinSocietecertificat($relationAlias = null) Adds a INNER JOIN clause to the query using the Societecertificat relation
 *
 * @method     \AppareilcertificatQuery|\SocietecertificatQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCertificat findOne(ConnectionInterface $con = null) Return the first ChildCertificat matching the query
 * @method     ChildCertificat findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCertificat matching the query, or a new ChildCertificat object populated from the query conditions when no match is found
 *
 * @method     ChildCertificat findOneByID(int $id) Return the first ChildCertificat filtered by the id column
 * @method     ChildCertificat findOneByAgrement(string $agrement) Return the first ChildCertificat filtered by the agrement column
 * @method     ChildCertificat findOneByWeb(string $srcweb) Return the first ChildCertificat filtered by the srcweb column *

 * @method     ChildCertificat requirePk($key, ConnectionInterface $con = null) Return the ChildCertificat by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCertificat requireOne(ConnectionInterface $con = null) Return the first ChildCertificat matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCertificat requireOneByID(int $id) Return the first ChildCertificat filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCertificat requireOneByAgrement(string $agrement) Return the first ChildCertificat filtered by the agrement column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCertificat requireOneByWeb(string $srcweb) Return the first ChildCertificat filtered by the srcweb column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCertificat[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCertificat objects based on current ModelCriteria
 * @method     ChildCertificat[]|ObjectCollection findByID(int $id) Return ChildCertificat objects filtered by the id column
 * @method     ChildCertificat[]|ObjectCollection findByAgrement(string $agrement) Return ChildCertificat objects filtered by the agrement column
 * @method     ChildCertificat[]|ObjectCollection findByWeb(string $srcweb) Return ChildCertificat objects filtered by the srcweb column
 * @method     ChildCertificat[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CertificatQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CertificatQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Certificat', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCertificatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCertificatQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCertificatQuery) {
            return $criteria;
        }
        $query = new ChildCertificatQuery();
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
     * @return ChildCertificat|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CertificatTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CertificatTableMap::DATABASE_NAME);
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
     * @return ChildCertificat A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, agrement, srcweb FROM certificat WHERE id = :p0';
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
            /** @var ChildCertificat $obj */
            $obj = new ChildCertificat();
            $obj->hydrate($row);
            CertificatTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCertificat|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCertificatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CertificatTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCertificatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CertificatTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCertificatQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(CertificatTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(CertificatTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CertificatTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the agrement column
     *
     * Example usage:
     * <code>
     * $query->filterByAgrement('fooValue');   // WHERE agrement = 'fooValue'
     * $query->filterByAgrement('%fooValue%'); // WHERE agrement LIKE '%fooValue%'
     * </code>
     *
     * @param     string $agrement The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCertificatQuery The current query, for fluid interface
     */
    public function filterByAgrement($agrement = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($agrement)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $agrement)) {
                $agrement = str_replace('*', '%', $agrement);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CertificatTableMap::COL_AGREMENT, $agrement, $comparison);
    }

    /**
     * Filter the query on the srcweb column
     *
     * Example usage:
     * <code>
     * $query->filterByWeb('fooValue');   // WHERE srcweb = 'fooValue'
     * $query->filterByWeb('%fooValue%'); // WHERE srcweb LIKE '%fooValue%'
     * </code>
     *
     * @param     string $web The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCertificatQuery The current query, for fluid interface
     */
    public function filterByWeb($web = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($web)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $web)) {
                $web = str_replace('*', '%', $web);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CertificatTableMap::COL_SRCWEB, $web, $comparison);
    }

    /**
     * Filter the query by a related \Appareilcertificat object
     *
     * @param \Appareilcertificat|ObjectCollection $appareilcertificat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCertificatQuery The current query, for fluid interface
     */
    public function filterByAppareilcertificat($appareilcertificat, $comparison = null)
    {
        if ($appareilcertificat instanceof \Appareilcertificat) {
            return $this
                ->addUsingAlias(CertificatTableMap::COL_AGREMENT, $appareilcertificat->getAgrement(), $comparison);
        } elseif ($appareilcertificat instanceof ObjectCollection) {
            return $this
                ->useAppareilcertificatQuery()
                ->filterByPrimaryKeys($appareilcertificat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAppareilcertificat() only accepts arguments of type \Appareilcertificat or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Appareilcertificat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCertificatQuery The current query, for fluid interface
     */
    public function joinAppareilcertificat($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Appareilcertificat');

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
            $this->addJoinObject($join, 'Appareilcertificat');
        }

        return $this;
    }

    /**
     * Use the Appareilcertificat relation Appareilcertificat object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppareilcertificatQuery A secondary query class using the current class as primary query
     */
    public function useAppareilcertificatQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAppareilcertificat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Appareilcertificat', '\AppareilcertificatQuery');
    }

    /**
     * Filter the query by a related \Societecertificat object
     *
     * @param \Societecertificat|ObjectCollection $societecertificat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCertificatQuery The current query, for fluid interface
     */
    public function filterBySocietecertificat($societecertificat, $comparison = null)
    {
        if ($societecertificat instanceof \Societecertificat) {
            return $this
                ->addUsingAlias(CertificatTableMap::COL_AGREMENT, $societecertificat->getAgrement_PK(), $comparison);
        } elseif ($societecertificat instanceof ObjectCollection) {
            return $this
                ->useSocietecertificatQuery()
                ->filterByPrimaryKeys($societecertificat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySocietecertificat() only accepts arguments of type \Societecertificat or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societecertificat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCertificatQuery The current query, for fluid interface
     */
    public function joinSocietecertificat($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societecertificat');

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
            $this->addJoinObject($join, 'Societecertificat');
        }

        return $this;
    }

    /**
     * Use the Societecertificat relation Societecertificat object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocietecertificatQuery A secondary query class using the current class as primary query
     */
    public function useSocietecertificatQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocietecertificat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societecertificat', '\SocietecertificatQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCertificat $certificat Object to remove from the list of results
     *
     * @return $this|ChildCertificatQuery The current query, for fluid interface
     */
    public function prune($certificat = null)
    {
        if ($certificat) {
            $this->addUsingAlias(CertificatTableMap::COL_ID, $certificat->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the certificat table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CertificatTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CertificatTableMap::clearInstancePool();
            CertificatTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CertificatTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CertificatTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CertificatTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CertificatTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CertificatQuery
