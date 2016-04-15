<?php

namespace Base;

use \SPartenaire as ChildSPartenaire;
use \SPartenaireQuery as ChildSPartenaireQuery;
use \Exception;
use \PDO;
use Map\SPartenaireTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'soc_part' table.
 *
 *
 *
 * @method     ChildSPartenaireQuery orderBySFraude($order = Criteria::ASC) Order by the soc_fraude column
 * @method     ChildSPartenaireQuery orderByPPlaigante($order = Criteria::ASC) Order by the plaig_part column
 * @method     ChildSPartenaireQuery orderBySPlaigante($order = Criteria::ASC) Order by the plaig_soc column
 * @method     ChildSPartenaireQuery orderByPlaignat($order = Criteria::ASC) Order by the plaignant column
 * @method     ChildSPartenaireQuery orderByDatePlainte($order = Criteria::ASC) Order by the dte_plainte column
 *
 * @method     ChildSPartenaireQuery groupBySFraude() Group by the soc_fraude column
 * @method     ChildSPartenaireQuery groupByPPlaigante() Group by the plaig_part column
 * @method     ChildSPartenaireQuery groupBySPlaigante() Group by the plaig_soc column
 * @method     ChildSPartenaireQuery groupByPlaignat() Group by the plaignant column
 * @method     ChildSPartenaireQuery groupByDatePlainte() Group by the dte_plainte column
 *
 * @method     ChildSPartenaireQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSPartenaireQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSPartenaireQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSPartenaireQuery leftJoinPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenaire relation
 * @method     ChildSPartenaireQuery rightJoinPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenaire relation
 * @method     ChildSPartenaireQuery innerJoinPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenaire relation
 *
 * @method     ChildSPartenaireQuery leftJoinSocFraude($relationAlias = null) Adds a LEFT JOIN clause to the query using the SocFraude relation
 * @method     ChildSPartenaireQuery rightJoinSocFraude($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SocFraude relation
 * @method     ChildSPartenaireQuery innerJoinSocFraude($relationAlias = null) Adds a INNER JOIN clause to the query using the SocFraude relation
 *
 * @method     ChildSPartenaireQuery leftJoinSocPlaignant($relationAlias = null) Adds a LEFT JOIN clause to the query using the SocPlaignant relation
 * @method     ChildSPartenaireQuery rightJoinSocPlaignant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SocPlaignant relation
 * @method     ChildSPartenaireQuery innerJoinSocPlaignant($relationAlias = null) Adds a INNER JOIN clause to the query using the SocPlaignant relation
 *
 * @method     \PartenaireQuery|\SocieteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSPartenaire findOne(ConnectionInterface $con = null) Return the first ChildSPartenaire matching the query
 * @method     ChildSPartenaire findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSPartenaire matching the query, or a new ChildSPartenaire object populated from the query conditions when no match is found
 *
 * @method     ChildSPartenaire findOneBySFraude(int $soc_fraude) Return the first ChildSPartenaire filtered by the soc_fraude column
 * @method     ChildSPartenaire findOneByPPlaigante(int $plaig_part) Return the first ChildSPartenaire filtered by the plaig_part column
 * @method     ChildSPartenaire findOneBySPlaigante(int $plaig_soc) Return the first ChildSPartenaire filtered by the plaig_soc column
 * @method     ChildSPartenaire findOneByPlaignat(string $plaignant) Return the first ChildSPartenaire filtered by the plaignant column
 * @method     ChildSPartenaire findOneByDatePlainte(string $dte_plainte) Return the first ChildSPartenaire filtered by the dte_plainte column *

 * @method     ChildSPartenaire requirePk($key, ConnectionInterface $con = null) Return the ChildSPartenaire by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPartenaire requireOne(ConnectionInterface $con = null) Return the first ChildSPartenaire matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSPartenaire requireOneBySFraude(int $soc_fraude) Return the first ChildSPartenaire filtered by the soc_fraude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPartenaire requireOneByPPlaigante(int $plaig_part) Return the first ChildSPartenaire filtered by the plaig_part column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPartenaire requireOneBySPlaigante(int $plaig_soc) Return the first ChildSPartenaire filtered by the plaig_soc column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPartenaire requireOneByPlaignat(string $plaignant) Return the first ChildSPartenaire filtered by the plaignant column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSPartenaire requireOneByDatePlainte(string $dte_plainte) Return the first ChildSPartenaire filtered by the dte_plainte column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSPartenaire[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSPartenaire objects based on current ModelCriteria
 * @method     ChildSPartenaire[]|ObjectCollection findBySFraude(int $soc_fraude) Return ChildSPartenaire objects filtered by the soc_fraude column
 * @method     ChildSPartenaire[]|ObjectCollection findByPPlaigante(int $plaig_part) Return ChildSPartenaire objects filtered by the plaig_part column
 * @method     ChildSPartenaire[]|ObjectCollection findBySPlaigante(int $plaig_soc) Return ChildSPartenaire objects filtered by the plaig_soc column
 * @method     ChildSPartenaire[]|ObjectCollection findByPlaignat(string $plaignant) Return ChildSPartenaire objects filtered by the plaignant column
 * @method     ChildSPartenaire[]|ObjectCollection findByDatePlainte(string $dte_plainte) Return ChildSPartenaire objects filtered by the dte_plainte column
 * @method     ChildSPartenaire[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SPartenaireQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SPartenaireQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\SPartenaire', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSPartenaireQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSPartenaireQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSPartenaireQuery) {
            return $criteria;
        }
        $query = new ChildSPartenaireQuery();
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
     * @return ChildSPartenaire|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SPartenaireTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SPartenaireTableMap::DATABASE_NAME);
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
     * @return ChildSPartenaire A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT soc_fraude, plaig_part, plaig_soc, plaignant, dte_plainte FROM soc_part WHERE soc_fraude = :p0';
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
            /** @var ChildSPartenaire $obj */
            $obj = new ChildSPartenaire();
            $obj->hydrate($row);
            SPartenaireTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSPartenaire|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SPartenaireTableMap::COL_SOC_FRAUDE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SPartenaireTableMap::COL_SOC_FRAUDE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the soc_fraude column
     *
     * Example usage:
     * <code>
     * $query->filterBySFraude(1234); // WHERE soc_fraude = 1234
     * $query->filterBySFraude(array(12, 34)); // WHERE soc_fraude IN (12, 34)
     * $query->filterBySFraude(array('min' => 12)); // WHERE soc_fraude > 12
     * </code>
     *
     * @see       filterBySocFraude()
     *
     * @param     mixed $sFraude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterBySFraude($sFraude = null, $comparison = null)
    {
        if (is_array($sFraude)) {
            $useMinMax = false;
            if (isset($sFraude['min'])) {
                $this->addUsingAlias(SPartenaireTableMap::COL_SOC_FRAUDE, $sFraude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sFraude['max'])) {
                $this->addUsingAlias(SPartenaireTableMap::COL_SOC_FRAUDE, $sFraude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPartenaireTableMap::COL_SOC_FRAUDE, $sFraude, $comparison);
    }

    /**
     * Filter the query on the plaig_part column
     *
     * Example usage:
     * <code>
     * $query->filterByPPlaigante(1234); // WHERE plaig_part = 1234
     * $query->filterByPPlaigante(array(12, 34)); // WHERE plaig_part IN (12, 34)
     * $query->filterByPPlaigante(array('min' => 12)); // WHERE plaig_part > 12
     * </code>
     *
     * @see       filterByPartenaire()
     *
     * @param     mixed $pPlaigante The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterByPPlaigante($pPlaigante = null, $comparison = null)
    {
        if (is_array($pPlaigante)) {
            $useMinMax = false;
            if (isset($pPlaigante['min'])) {
                $this->addUsingAlias(SPartenaireTableMap::COL_PLAIG_PART, $pPlaigante['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pPlaigante['max'])) {
                $this->addUsingAlias(SPartenaireTableMap::COL_PLAIG_PART, $pPlaigante['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPartenaireTableMap::COL_PLAIG_PART, $pPlaigante, $comparison);
    }

    /**
     * Filter the query on the plaig_soc column
     *
     * Example usage:
     * <code>
     * $query->filterBySPlaigante(1234); // WHERE plaig_soc = 1234
     * $query->filterBySPlaigante(array(12, 34)); // WHERE plaig_soc IN (12, 34)
     * $query->filterBySPlaigante(array('min' => 12)); // WHERE plaig_soc > 12
     * </code>
     *
     * @see       filterBySocPlaignant()
     *
     * @param     mixed $sPlaigante The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterBySPlaigante($sPlaigante = null, $comparison = null)
    {
        if (is_array($sPlaigante)) {
            $useMinMax = false;
            if (isset($sPlaigante['min'])) {
                $this->addUsingAlias(SPartenaireTableMap::COL_PLAIG_SOC, $sPlaigante['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sPlaigante['max'])) {
                $this->addUsingAlias(SPartenaireTableMap::COL_PLAIG_SOC, $sPlaigante['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPartenaireTableMap::COL_PLAIG_SOC, $sPlaigante, $comparison);
    }

    /**
     * Filter the query on the plaignant column
     *
     * Example usage:
     * <code>
     * $query->filterByPlaignat('fooValue');   // WHERE plaignant = 'fooValue'
     * $query->filterByPlaignat('%fooValue%'); // WHERE plaignant LIKE '%fooValue%'
     * </code>
     *
     * @param     string $plaignat The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterByPlaignat($plaignat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($plaignat)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $plaignat)) {
                $plaignat = str_replace('*', '%', $plaignat);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SPartenaireTableMap::COL_PLAIGNANT, $plaignat, $comparison);
    }

    /**
     * Filter the query on the dte_plainte column
     *
     * Example usage:
     * <code>
     * $query->filterByDatePlainte('2011-03-14'); // WHERE dte_plainte = '2011-03-14'
     * $query->filterByDatePlainte('now'); // WHERE dte_plainte = '2011-03-14'
     * $query->filterByDatePlainte(array('max' => 'yesterday')); // WHERE dte_plainte > '2011-03-13'
     * </code>
     *
     * @param     mixed $datePlainte The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterByDatePlainte($datePlainte = null, $comparison = null)
    {
        if (is_array($datePlainte)) {
            $useMinMax = false;
            if (isset($datePlainte['min'])) {
                $this->addUsingAlias(SPartenaireTableMap::COL_DTE_PLAINTE, $datePlainte['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datePlainte['max'])) {
                $this->addUsingAlias(SPartenaireTableMap::COL_DTE_PLAINTE, $datePlainte['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SPartenaireTableMap::COL_DTE_PLAINTE, $datePlainte, $comparison);
    }

    /**
     * Filter the query by a related \Partenaire object
     *
     * @param \Partenaire|ObjectCollection $partenaire The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterByPartenaire($partenaire, $comparison = null)
    {
        if ($partenaire instanceof \Partenaire) {
            return $this
                ->addUsingAlias(SPartenaireTableMap::COL_PLAIG_PART, $partenaire->getID(), $comparison);
        } elseif ($partenaire instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SPartenaireTableMap::COL_PLAIG_PART, $partenaire->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
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
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterBySocFraude($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(SPartenaireTableMap::COL_SOC_FRAUDE, $societe->getID(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SPartenaireTableMap::COL_SOC_FRAUDE, $societe->toKeyValue('PrimaryKey', 'ID'), $comparison);
        } else {
            throw new PropelException('filterBySocFraude() only accepts arguments of type \Societe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SocFraude relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function joinSocFraude($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SocFraude');

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
            $this->addJoinObject($join, 'SocFraude');
        }

        return $this;
    }

    /**
     * Use the SocFraude relation Societe object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocieteQuery A secondary query class using the current class as primary query
     */
    public function useSocFraudeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSocFraude($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SocFraude', '\SocieteQuery');
    }

    /**
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSPartenaireQuery The current query, for fluid interface
     */
    public function filterBySocPlaignant($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(SPartenaireTableMap::COL_PLAIG_SOC, $societe->getID(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SPartenaireTableMap::COL_PLAIG_SOC, $societe->toKeyValue('PrimaryKey', 'ID'), $comparison);
        } else {
            throw new PropelException('filterBySocPlaignant() only accepts arguments of type \Societe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SocPlaignant relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function joinSocPlaignant($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SocPlaignant');

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
            $this->addJoinObject($join, 'SocPlaignant');
        }

        return $this;
    }

    /**
     * Use the SocPlaignant relation Societe object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocieteQuery A secondary query class using the current class as primary query
     */
    public function useSocPlaignantQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocPlaignant($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SocPlaignant', '\SocieteQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSPartenaire $sPartenaire Object to remove from the list of results
     *
     * @return $this|ChildSPartenaireQuery The current query, for fluid interface
     */
    public function prune($sPartenaire = null)
    {
        if ($sPartenaire) {
            $this->addUsingAlias(SPartenaireTableMap::COL_SOC_FRAUDE, $sPartenaire->getSFraude(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the soc_part table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SPartenaireTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SPartenaireTableMap::clearInstancePool();
            SPartenaireTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SPartenaireTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SPartenaireTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SPartenaireTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SPartenaireTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SPartenaireQuery
