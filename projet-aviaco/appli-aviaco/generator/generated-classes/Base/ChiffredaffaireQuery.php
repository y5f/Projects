<?php

namespace Base;

use \Chiffredaffaire as ChildChiffredaffaire;
use \ChiffredaffaireQuery as ChildChiffredaffaireQuery;
use \Exception;
use \PDO;
use Map\ChiffredaffaireTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'chiffreaffaire' table.
 *
 *
 *
 * @method     ChildChiffredaffaireQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildChiffredaffaireQuery orderByAnnee($order = Criteria::ASC) Order by the annee column
 * @method     ChildChiffredaffaireQuery orderByChiffre($order = Criteria::ASC) Order by the ca column
 * @method     ChildChiffredaffaireQuery orderByNbremployes($order = Criteria::ASC) Order by the nbremp column
 * @method     ChildChiffredaffaireQuery orderByisFiliale($order = Criteria::ASC) Order by the filiale column
 * @method     ChildChiffredaffaireQuery orderBysociete_FK($order = Criteria::ASC) Order by the societe_FK column
 *
 * @method     ChildChiffredaffaireQuery groupByID() Group by the id column
 * @method     ChildChiffredaffaireQuery groupByAnnee() Group by the annee column
 * @method     ChildChiffredaffaireQuery groupByChiffre() Group by the ca column
 * @method     ChildChiffredaffaireQuery groupByNbremployes() Group by the nbremp column
 * @method     ChildChiffredaffaireQuery groupByisFiliale() Group by the filiale column
 * @method     ChildChiffredaffaireQuery groupBysociete_FK() Group by the societe_FK column
 *
 * @method     ChildChiffredaffaireQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildChiffredaffaireQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildChiffredaffaireQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildChiffredaffaireQuery leftJoinSociete($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societe relation
 * @method     ChildChiffredaffaireQuery rightJoinSociete($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societe relation
 * @method     ChildChiffredaffaireQuery innerJoinSociete($relationAlias = null) Adds a INNER JOIN clause to the query using the Societe relation
 *
 * @method     \SocieteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildChiffredaffaire findOne(ConnectionInterface $con = null) Return the first ChildChiffredaffaire matching the query
 * @method     ChildChiffredaffaire findOneOrCreate(ConnectionInterface $con = null) Return the first ChildChiffredaffaire matching the query, or a new ChildChiffredaffaire object populated from the query conditions when no match is found
 *
 * @method     ChildChiffredaffaire findOneByID(int $id) Return the first ChildChiffredaffaire filtered by the id column
 * @method     ChildChiffredaffaire findOneByAnnee(int $annee) Return the first ChildChiffredaffaire filtered by the annee column
 * @method     ChildChiffredaffaire findOneByChiffre(double $ca) Return the first ChildChiffredaffaire filtered by the ca column
 * @method     ChildChiffredaffaire findOneByNbremployes(int $nbremp) Return the first ChildChiffredaffaire filtered by the nbremp column
 * @method     ChildChiffredaffaire findOneByisFiliale(boolean $filiale) Return the first ChildChiffredaffaire filtered by the filiale column
 * @method     ChildChiffredaffaire findOneBysociete_FK(string $societe_FK) Return the first ChildChiffredaffaire filtered by the societe_FK column *

 * @method     ChildChiffredaffaire requirePk($key, ConnectionInterface $con = null) Return the ChildChiffredaffaire by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChiffredaffaire requireOne(ConnectionInterface $con = null) Return the first ChildChiffredaffaire matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildChiffredaffaire requireOneByID(int $id) Return the first ChildChiffredaffaire filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChiffredaffaire requireOneByAnnee(int $annee) Return the first ChildChiffredaffaire filtered by the annee column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChiffredaffaire requireOneByChiffre(double $ca) Return the first ChildChiffredaffaire filtered by the ca column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChiffredaffaire requireOneByNbremployes(int $nbremp) Return the first ChildChiffredaffaire filtered by the nbremp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChiffredaffaire requireOneByisFiliale(boolean $filiale) Return the first ChildChiffredaffaire filtered by the filiale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChiffredaffaire requireOneBysociete_FK(string $societe_FK) Return the first ChildChiffredaffaire filtered by the societe_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildChiffredaffaire[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildChiffredaffaire objects based on current ModelCriteria
 * @method     ChildChiffredaffaire[]|ObjectCollection findByID(int $id) Return ChildChiffredaffaire objects filtered by the id column
 * @method     ChildChiffredaffaire[]|ObjectCollection findByAnnee(int $annee) Return ChildChiffredaffaire objects filtered by the annee column
 * @method     ChildChiffredaffaire[]|ObjectCollection findByChiffre(double $ca) Return ChildChiffredaffaire objects filtered by the ca column
 * @method     ChildChiffredaffaire[]|ObjectCollection findByNbremployes(int $nbremp) Return ChildChiffredaffaire objects filtered by the nbremp column
 * @method     ChildChiffredaffaire[]|ObjectCollection findByisFiliale(boolean $filiale) Return ChildChiffredaffaire objects filtered by the filiale column
 * @method     ChildChiffredaffaire[]|ObjectCollection findBysociete_FK(string $societe_FK) Return ChildChiffredaffaire objects filtered by the societe_FK column
 * @method     ChildChiffredaffaire[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ChiffredaffaireQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ChiffredaffaireQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Chiffredaffaire', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildChiffredaffaireQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildChiffredaffaireQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildChiffredaffaireQuery) {
            return $criteria;
        }
        $query = new ChildChiffredaffaireQuery();
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
     * @return ChildChiffredaffaire|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ChiffredaffaireTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ChiffredaffaireTableMap::DATABASE_NAME);
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
     * @return ChildChiffredaffaire A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, annee, ca, nbremp, filiale, societe_FK FROM chiffreaffaire WHERE id = :p0';
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
            /** @var ChildChiffredaffaire $obj */
            $obj = new ChildChiffredaffaire();
            $obj->hydrate($row);
            ChiffredaffaireTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildChiffredaffaire|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ChiffredaffaireTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ChiffredaffaireTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(ChiffredaffaireTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(ChiffredaffaireTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChiffredaffaireTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the annee column
     *
     * Example usage:
     * <code>
     * $query->filterByAnnee(1234); // WHERE annee = 1234
     * $query->filterByAnnee(array(12, 34)); // WHERE annee IN (12, 34)
     * $query->filterByAnnee(array('min' => 12)); // WHERE annee > 12
     * </code>
     *
     * @param     mixed $annee The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterByAnnee($annee = null, $comparison = null)
    {
        if (is_array($annee)) {
            $useMinMax = false;
            if (isset($annee['min'])) {
                $this->addUsingAlias(ChiffredaffaireTableMap::COL_ANNEE, $annee['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($annee['max'])) {
                $this->addUsingAlias(ChiffredaffaireTableMap::COL_ANNEE, $annee['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChiffredaffaireTableMap::COL_ANNEE, $annee, $comparison);
    }

    /**
     * Filter the query on the ca column
     *
     * Example usage:
     * <code>
     * $query->filterByChiffre(1234); // WHERE ca = 1234
     * $query->filterByChiffre(array(12, 34)); // WHERE ca IN (12, 34)
     * $query->filterByChiffre(array('min' => 12)); // WHERE ca > 12
     * </code>
     *
     * @param     mixed $chiffre The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterByChiffre($chiffre = null, $comparison = null)
    {
        if (is_array($chiffre)) {
            $useMinMax = false;
            if (isset($chiffre['min'])) {
                $this->addUsingAlias(ChiffredaffaireTableMap::COL_CA, $chiffre['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($chiffre['max'])) {
                $this->addUsingAlias(ChiffredaffaireTableMap::COL_CA, $chiffre['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChiffredaffaireTableMap::COL_CA, $chiffre, $comparison);
    }

    /**
     * Filter the query on the nbremp column
     *
     * Example usage:
     * <code>
     * $query->filterByNbremployes(1234); // WHERE nbremp = 1234
     * $query->filterByNbremployes(array(12, 34)); // WHERE nbremp IN (12, 34)
     * $query->filterByNbremployes(array('min' => 12)); // WHERE nbremp > 12
     * </code>
     *
     * @param     mixed $nbremployes The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterByNbremployes($nbremployes = null, $comparison = null)
    {
        if (is_array($nbremployes)) {
            $useMinMax = false;
            if (isset($nbremployes['min'])) {
                $this->addUsingAlias(ChiffredaffaireTableMap::COL_NBREMP, $nbremployes['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbremployes['max'])) {
                $this->addUsingAlias(ChiffredaffaireTableMap::COL_NBREMP, $nbremployes['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChiffredaffaireTableMap::COL_NBREMP, $nbremployes, $comparison);
    }

    /**
     * Filter the query on the filiale column
     *
     * Example usage:
     * <code>
     * $query->filterByisFiliale(true); // WHERE filiale = true
     * $query->filterByisFiliale('yes'); // WHERE filiale = true
     * </code>
     *
     * @param     boolean|string $isFiliale The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterByisFiliale($isFiliale = null, $comparison = null)
    {
        if (is_string($isFiliale)) {
            $isFiliale = in_array(strtolower($isFiliale), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ChiffredaffaireTableMap::COL_FILIALE, $isFiliale, $comparison);
    }

    /**
     * Filter the query on the societe_FK column
     *
     * Example usage:
     * <code>
     * $query->filterBysociete_FK('fooValue');   // WHERE societe_FK = 'fooValue'
     * $query->filterBysociete_FK('%fooValue%'); // WHERE societe_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $societe_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterBysociete_FK($societe_FK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($societe_FK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $societe_FK)) {
                $societe_FK = str_replace('*', '%', $societe_FK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ChiffredaffaireTableMap::COL_SOCIETE_FK, $societe_FK, $comparison);
    }

    /**
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function filterBySociete($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(ChiffredaffaireTableMap::COL_SOCIETE_FK, $societe->getSociete(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ChiffredaffaireTableMap::COL_SOCIETE_FK, $societe->toKeyValue('PrimaryKey', 'Societe'), $comparison);
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
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildChiffredaffaire $chiffredaffaire Object to remove from the list of results
     *
     * @return $this|ChildChiffredaffaireQuery The current query, for fluid interface
     */
    public function prune($chiffredaffaire = null)
    {
        if ($chiffredaffaire) {
            $this->addUsingAlias(ChiffredaffaireTableMap::COL_ID, $chiffredaffaire->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the chiffreaffaire table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChiffredaffaireTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ChiffredaffaireTableMap::clearInstancePool();
            ChiffredaffaireTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ChiffredaffaireTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ChiffredaffaireTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ChiffredaffaireTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ChiffredaffaireTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ChiffredaffaireQuery
