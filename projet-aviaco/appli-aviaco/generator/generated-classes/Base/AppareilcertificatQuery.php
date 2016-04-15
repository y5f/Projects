<?php

namespace Base;

use \Appareilcertificat as ChildAppareilcertificat;
use \AppareilcertificatQuery as ChildAppareilcertificatQuery;
use \Exception;
use \PDO;
use Map\AppareilcertificatTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'appcertificat' table.
 *
 *
 *
 * @method     ChildAppareilcertificatQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildAppareilcertificatQuery orderByIdAppareil($order = Criteria::ASC) Order by the idAp_PK column
 * @method     ChildAppareilcertificatQuery orderByAgrement($order = Criteria::ASC) Order by the agrement_PK column
 *
 * @method     ChildAppareilcertificatQuery groupByID() Group by the id column
 * @method     ChildAppareilcertificatQuery groupByIdAppareil() Group by the idAp_PK column
 * @method     ChildAppareilcertificatQuery groupByAgrement() Group by the agrement_PK column
 *
 * @method     ChildAppareilcertificatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAppareilcertificatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAppareilcertificatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAppareilcertificatQuery leftJoinAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appareil relation
 * @method     ChildAppareilcertificatQuery rightJoinAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appareil relation
 * @method     ChildAppareilcertificatQuery innerJoinAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Appareil relation
 *
 * @method     ChildAppareilcertificatQuery leftJoinCertificat($relationAlias = null) Adds a LEFT JOIN clause to the query using the Certificat relation
 * @method     ChildAppareilcertificatQuery rightJoinCertificat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Certificat relation
 * @method     ChildAppareilcertificatQuery innerJoinCertificat($relationAlias = null) Adds a INNER JOIN clause to the query using the Certificat relation
 *
 * @method     \AppareilQuery|\CertificatQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAppareilcertificat findOne(ConnectionInterface $con = null) Return the first ChildAppareilcertificat matching the query
 * @method     ChildAppareilcertificat findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAppareilcertificat matching the query, or a new ChildAppareilcertificat object populated from the query conditions when no match is found
 *
 * @method     ChildAppareilcertificat findOneByID(int $id) Return the first ChildAppareilcertificat filtered by the id column
 * @method     ChildAppareilcertificat findOneByIdAppareil(int $idAp_PK) Return the first ChildAppareilcertificat filtered by the idAp_PK column
 * @method     ChildAppareilcertificat findOneByAgrement(string $agrement_PK) Return the first ChildAppareilcertificat filtered by the agrement_PK column *

 * @method     ChildAppareilcertificat requirePk($key, ConnectionInterface $con = null) Return the ChildAppareilcertificat by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppareilcertificat requireOne(ConnectionInterface $con = null) Return the first ChildAppareilcertificat matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAppareilcertificat requireOneByID(int $id) Return the first ChildAppareilcertificat filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppareilcertificat requireOneByIdAppareil(int $idAp_PK) Return the first ChildAppareilcertificat filtered by the idAp_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppareilcertificat requireOneByAgrement(string $agrement_PK) Return the first ChildAppareilcertificat filtered by the agrement_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAppareilcertificat[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAppareilcertificat objects based on current ModelCriteria
 * @method     ChildAppareilcertificat[]|ObjectCollection findByID(int $id) Return ChildAppareilcertificat objects filtered by the id column
 * @method     ChildAppareilcertificat[]|ObjectCollection findByIdAppareil(int $idAp_PK) Return ChildAppareilcertificat objects filtered by the idAp_PK column
 * @method     ChildAppareilcertificat[]|ObjectCollection findByAgrement(string $agrement_PK) Return ChildAppareilcertificat objects filtered by the agrement_PK column
 * @method     ChildAppareilcertificat[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AppareilcertificatQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AppareilcertificatQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Appareilcertificat', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAppareilcertificatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAppareilcertificatQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAppareilcertificatQuery) {
            return $criteria;
        }
        $query = new ChildAppareilcertificatQuery();
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
     * @return ChildAppareilcertificat|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AppareilcertificatTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AppareilcertificatTableMap::DATABASE_NAME);
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
     * @return ChildAppareilcertificat A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, idAp_PK, agrement_PK FROM appcertificat WHERE id = :p0';
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
            /** @var ChildAppareilcertificat $obj */
            $obj = new ChildAppareilcertificat();
            $obj->hydrate($row);
            AppareilcertificatTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAppareilcertificat|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AppareilcertificatTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AppareilcertificatTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(AppareilcertificatTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(AppareilcertificatTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppareilcertificatTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the idAp_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAppareil(1234); // WHERE idAp_PK = 1234
     * $query->filterByIdAppareil(array(12, 34)); // WHERE idAp_PK IN (12, 34)
     * $query->filterByIdAppareil(array('min' => 12)); // WHERE idAp_PK > 12
     * </code>
     *
     * @see       filterByAppareil()
     *
     * @param     mixed $idAppareil The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function filterByIdAppareil($idAppareil = null, $comparison = null)
    {
        if (is_array($idAppareil)) {
            $useMinMax = false;
            if (isset($idAppareil['min'])) {
                $this->addUsingAlias(AppareilcertificatTableMap::COL_IDAP_PK, $idAppareil['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAppareil['max'])) {
                $this->addUsingAlias(AppareilcertificatTableMap::COL_IDAP_PK, $idAppareil['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppareilcertificatTableMap::COL_IDAP_PK, $idAppareil, $comparison);
    }

    /**
     * Filter the query on the agrement_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByAgrement('fooValue');   // WHERE agrement_PK = 'fooValue'
     * $query->filterByAgrement('%fooValue%'); // WHERE agrement_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $agrement The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppareilcertificatQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AppareilcertificatTableMap::COL_AGREMENT_PK, $agrement, $comparison);
    }

    /**
     * Filter the query by a related \Appareil object
     *
     * @param \Appareil|ObjectCollection $appareil The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function filterByAppareil($appareil, $comparison = null)
    {
        if ($appareil instanceof \Appareil) {
            return $this
                ->addUsingAlias(AppareilcertificatTableMap::COL_IDAP_PK, $appareil->getIdAp(), $comparison);
        } elseif ($appareil instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AppareilcertificatTableMap::COL_IDAP_PK, $appareil->toKeyValue('IdAp', 'IdAp'), $comparison);
        } else {
            throw new PropelException('filterByAppareil() only accepts arguments of type \Appareil or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Appareil relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function joinAppareil($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Appareil');

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
            $this->addJoinObject($join, 'Appareil');
        }

        return $this;
    }

    /**
     * Use the Appareil relation Appareil object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppareilQuery A secondary query class using the current class as primary query
     */
    public function useAppareilQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAppareil($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Appareil', '\AppareilQuery');
    }

    /**
     * Filter the query by a related \Certificat object
     *
     * @param \Certificat|ObjectCollection $certificat The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function filterByCertificat($certificat, $comparison = null)
    {
        if ($certificat instanceof \Certificat) {
            return $this
                ->addUsingAlias(AppareilcertificatTableMap::COL_AGREMENT_PK, $certificat->getAgrement(), $comparison);
        } elseif ($certificat instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AppareilcertificatTableMap::COL_AGREMENT_PK, $certificat->toKeyValue('PrimaryKey', 'Agrement'), $comparison);
        } else {
            throw new PropelException('filterByCertificat() only accepts arguments of type \Certificat or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Certificat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function joinCertificat($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Certificat');

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
            $this->addJoinObject($join, 'Certificat');
        }

        return $this;
    }

    /**
     * Use the Certificat relation Certificat object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CertificatQuery A secondary query class using the current class as primary query
     */
    public function useCertificatQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCertificat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Certificat', '\CertificatQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAppareilcertificat $appareilcertificat Object to remove from the list of results
     *
     * @return $this|ChildAppareilcertificatQuery The current query, for fluid interface
     */
    public function prune($appareilcertificat = null)
    {
        if ($appareilcertificat) {
            $this->addUsingAlias(AppareilcertificatTableMap::COL_ID, $appareilcertificat->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the appcertificat table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AppareilcertificatTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AppareilcertificatTableMap::clearInstancePool();
            AppareilcertificatTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AppareilcertificatTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AppareilcertificatTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AppareilcertificatTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AppareilcertificatTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AppareilcertificatQuery
