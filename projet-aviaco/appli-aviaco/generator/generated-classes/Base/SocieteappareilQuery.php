<?php

namespace Base;

use \Societeappareil as ChildSocieteappareil;
use \SocieteappareilQuery as ChildSocieteappareilQuery;
use \Exception;
use \PDO;
use Map\SocieteappareilTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'societe_app' table.
 *
 *
 *
 * @method     ChildSocieteappareilQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildSocieteappareilQuery orderBySociete_FK($order = Criteria::ASC) Order by the societe_FK column
 * @method     ChildSocieteappareilQuery orderByIdAppareil_FK($order = Criteria::ASC) Order by the idAp_FK column
 * @method     ChildSocieteappareilQuery orderByisFlotte($order = Criteria::ASC) Order by the flotte column
 *
 * @method     ChildSocieteappareilQuery groupByID() Group by the id column
 * @method     ChildSocieteappareilQuery groupBySociete_FK() Group by the societe_FK column
 * @method     ChildSocieteappareilQuery groupByIdAppareil_FK() Group by the idAp_FK column
 * @method     ChildSocieteappareilQuery groupByisFlotte() Group by the flotte column
 *
 * @method     ChildSocieteappareilQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSocieteappareilQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSocieteappareilQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSocieteappareilQuery leftJoinSociete($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societe relation
 * @method     ChildSocieteappareilQuery rightJoinSociete($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societe relation
 * @method     ChildSocieteappareilQuery innerJoinSociete($relationAlias = null) Adds a INNER JOIN clause to the query using the Societe relation
 *
 * @method     ChildSocieteappareilQuery leftJoinAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appareil relation
 * @method     ChildSocieteappareilQuery rightJoinAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appareil relation
 * @method     ChildSocieteappareilQuery innerJoinAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Appareil relation
 *
 * @method     \SocieteQuery|\AppareilQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSocieteappareil findOne(ConnectionInterface $con = null) Return the first ChildSocieteappareil matching the query
 * @method     ChildSocieteappareil findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSocieteappareil matching the query, or a new ChildSocieteappareil object populated from the query conditions when no match is found
 *
 * @method     ChildSocieteappareil findOneByID(int $id) Return the first ChildSocieteappareil filtered by the id column
 * @method     ChildSocieteappareil findOneBySociete_FK(string $societe_FK) Return the first ChildSocieteappareil filtered by the societe_FK column
 * @method     ChildSocieteappareil findOneByIdAppareil_FK(int $idAp_FK) Return the first ChildSocieteappareil filtered by the idAp_FK column
 * @method     ChildSocieteappareil findOneByisFlotte(boolean $flotte) Return the first ChildSocieteappareil filtered by the flotte column *

 * @method     ChildSocieteappareil requirePk($key, ConnectionInterface $con = null) Return the ChildSocieteappareil by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocieteappareil requireOne(ConnectionInterface $con = null) Return the first ChildSocieteappareil matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSocieteappareil requireOneByID(int $id) Return the first ChildSocieteappareil filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocieteappareil requireOneBySociete_FK(string $societe_FK) Return the first ChildSocieteappareil filtered by the societe_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocieteappareil requireOneByIdAppareil_FK(int $idAp_FK) Return the first ChildSocieteappareil filtered by the idAp_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocieteappareil requireOneByisFlotte(boolean $flotte) Return the first ChildSocieteappareil filtered by the flotte column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSocieteappareil[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSocieteappareil objects based on current ModelCriteria
 * @method     ChildSocieteappareil[]|ObjectCollection findByID(int $id) Return ChildSocieteappareil objects filtered by the id column
 * @method     ChildSocieteappareil[]|ObjectCollection findBySociete_FK(string $societe_FK) Return ChildSocieteappareil objects filtered by the societe_FK column
 * @method     ChildSocieteappareil[]|ObjectCollection findByIdAppareil_FK(int $idAp_FK) Return ChildSocieteappareil objects filtered by the idAp_FK column
 * @method     ChildSocieteappareil[]|ObjectCollection findByisFlotte(boolean $flotte) Return ChildSocieteappareil objects filtered by the flotte column
 * @method     ChildSocieteappareil[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SocieteappareilQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SocieteappareilQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Societeappareil', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSocieteappareilQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSocieteappareilQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSocieteappareilQuery) {
            return $criteria;
        }
        $query = new ChildSocieteappareilQuery();
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
     * @return ChildSocieteappareil|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SocieteappareilTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SocieteappareilTableMap::DATABASE_NAME);
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
     * @return ChildSocieteappareil A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, societe_FK, idAp_FK, flotte FROM societe_app WHERE id = :p0';
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
            /** @var ChildSocieteappareil $obj */
            $obj = new ChildSocieteappareil();
            $obj->hydrate($row);
            SocieteappareilTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSocieteappareil|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SocieteappareilTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SocieteappareilTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(SocieteappareilTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(SocieteappareilTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocieteappareilTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the societe_FK column
     *
     * Example usage:
     * <code>
     * $query->filterBySociete_FK('fooValue');   // WHERE societe_FK = 'fooValue'
     * $query->filterBySociete_FK('%fooValue%'); // WHERE societe_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $societe_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function filterBySociete_FK($societe_FK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($societe_FK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $societe_FK)) {
                $societe_FK = str_replace('*', '%', $societe_FK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteappareilTableMap::COL_SOCIETE_FK, $societe_FK, $comparison);
    }

    /**
     * Filter the query on the idAp_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAppareil_FK(1234); // WHERE idAp_FK = 1234
     * $query->filterByIdAppareil_FK(array(12, 34)); // WHERE idAp_FK IN (12, 34)
     * $query->filterByIdAppareil_FK(array('min' => 12)); // WHERE idAp_FK > 12
     * </code>
     *
     * @see       filterByAppareil()
     *
     * @param     mixed $idAppareil_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function filterByIdAppareil_FK($idAppareil_FK = null, $comparison = null)
    {
        if (is_array($idAppareil_FK)) {
            $useMinMax = false;
            if (isset($idAppareil_FK['min'])) {
                $this->addUsingAlias(SocieteappareilTableMap::COL_IDAP_FK, $idAppareil_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAppareil_FK['max'])) {
                $this->addUsingAlias(SocieteappareilTableMap::COL_IDAP_FK, $idAppareil_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocieteappareilTableMap::COL_IDAP_FK, $idAppareil_FK, $comparison);
    }

    /**
     * Filter the query on the flotte column
     *
     * Example usage:
     * <code>
     * $query->filterByisFlotte(true); // WHERE flotte = true
     * $query->filterByisFlotte('yes'); // WHERE flotte = true
     * </code>
     *
     * @param     boolean|string $isFlotte The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function filterByisFlotte($isFlotte = null, $comparison = null)
    {
        if (is_string($isFlotte)) {
            $isFlotte = in_array(strtolower($isFlotte), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SocieteappareilTableMap::COL_FLOTTE, $isFlotte, $comparison);
    }

    /**
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function filterBySociete($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(SocieteappareilTableMap::COL_SOCIETE_FK, $societe->getSociete(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocieteappareilTableMap::COL_SOCIETE_FK, $societe->toKeyValue('PrimaryKey', 'Societe'), $comparison);
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
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
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
     * Filter the query by a related \Appareil object
     *
     * @param \Appareil|ObjectCollection $appareil The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function filterByAppareil($appareil, $comparison = null)
    {
        if ($appareil instanceof \Appareil) {
            return $this
                ->addUsingAlias(SocieteappareilTableMap::COL_IDAP_FK, $appareil->getIdAp(), $comparison);
        } elseif ($appareil instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocieteappareilTableMap::COL_IDAP_FK, $appareil->toKeyValue('IdAp', 'IdAp'), $comparison);
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
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildSocieteappareil $societeappareil Object to remove from the list of results
     *
     * @return $this|ChildSocieteappareilQuery The current query, for fluid interface
     */
    public function prune($societeappareil = null)
    {
        if ($societeappareil) {
            $this->addUsingAlias(SocieteappareilTableMap::COL_ID, $societeappareil->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the societe_app table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SocieteappareilTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SocieteappareilTableMap::clearInstancePool();
            SocieteappareilTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SocieteappareilTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SocieteappareilTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SocieteappareilTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SocieteappareilTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SocieteappareilQuery
