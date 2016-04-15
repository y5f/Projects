<?php

namespace Base;

use \Financiere as ChildFinanciere;
use \FinanciereQuery as ChildFinanciereQuery;
use \Exception;
use \PDO;
use Map\FinanciereTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'financiere' table.
 *
 *
 *
 * @method     ChildFinanciereQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildFinanciereQuery orderByImmatricule($order = Criteria::ASC) Order by the immatricule column
 * @method     ChildFinanciereQuery orderBySociete_FK($order = Criteria::ASC) Order by the societe_FK column
 * @method     ChildFinanciereQuery orderByCapital($order = Criteria::ASC) Order by the capital column
 * @method     ChildFinanciereQuery orderByForm($order = Criteria::ASC) Order by the form column
 * @method     ChildFinanciereQuery orderByDtecreation($order = Criteria::ASC) Order by the dte_creation column
 * @method     ChildFinanciereQuery orderByNotes($order = Criteria::ASC) Order by the notes column
 * @method     ChildFinanciereQuery orderByDte_MAJ($order = Criteria::ASC) Order by the dte_maj column
 *
 * @method     ChildFinanciereQuery groupByID() Group by the id column
 * @method     ChildFinanciereQuery groupByImmatricule() Group by the immatricule column
 * @method     ChildFinanciereQuery groupBySociete_FK() Group by the societe_FK column
 * @method     ChildFinanciereQuery groupByCapital() Group by the capital column
 * @method     ChildFinanciereQuery groupByForm() Group by the form column
 * @method     ChildFinanciereQuery groupByDtecreation() Group by the dte_creation column
 * @method     ChildFinanciereQuery groupByNotes() Group by the notes column
 * @method     ChildFinanciereQuery groupByDte_MAJ() Group by the dte_maj column
 *
 * @method     ChildFinanciereQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFinanciereQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFinanciereQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFinanciereQuery leftJoinSociete($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societe relation
 * @method     ChildFinanciereQuery rightJoinSociete($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societe relation
 * @method     ChildFinanciereQuery innerJoinSociete($relationAlias = null) Adds a INNER JOIN clause to the query using the Societe relation
 *
 * @method     \SocieteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFinanciere findOne(ConnectionInterface $con = null) Return the first ChildFinanciere matching the query
 * @method     ChildFinanciere findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFinanciere matching the query, or a new ChildFinanciere object populated from the query conditions when no match is found
 *
 * @method     ChildFinanciere findOneByID(int $id) Return the first ChildFinanciere filtered by the id column
 * @method     ChildFinanciere findOneByImmatricule(string $immatricule) Return the first ChildFinanciere filtered by the immatricule column
 * @method     ChildFinanciere findOneBySociete_FK(string $societe_FK) Return the first ChildFinanciere filtered by the societe_FK column
 * @method     ChildFinanciere findOneByCapital(double $capital) Return the first ChildFinanciere filtered by the capital column
 * @method     ChildFinanciere findOneByForm(string $form) Return the first ChildFinanciere filtered by the form column
 * @method     ChildFinanciere findOneByDtecreation(string $dte_creation) Return the first ChildFinanciere filtered by the dte_creation column
 * @method     ChildFinanciere findOneByNotes(string $notes) Return the first ChildFinanciere filtered by the notes column
 * @method     ChildFinanciere findOneByDte_MAJ(string $dte_maj) Return the first ChildFinanciere filtered by the dte_maj column *

 * @method     ChildFinanciere requirePk($key, ConnectionInterface $con = null) Return the ChildFinanciere by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFinanciere requireOne(ConnectionInterface $con = null) Return the first ChildFinanciere matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFinanciere requireOneByID(int $id) Return the first ChildFinanciere filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFinanciere requireOneByImmatricule(string $immatricule) Return the first ChildFinanciere filtered by the immatricule column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFinanciere requireOneBySociete_FK(string $societe_FK) Return the first ChildFinanciere filtered by the societe_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFinanciere requireOneByCapital(double $capital) Return the first ChildFinanciere filtered by the capital column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFinanciere requireOneByForm(string $form) Return the first ChildFinanciere filtered by the form column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFinanciere requireOneByDtecreation(string $dte_creation) Return the first ChildFinanciere filtered by the dte_creation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFinanciere requireOneByNotes(string $notes) Return the first ChildFinanciere filtered by the notes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFinanciere requireOneByDte_MAJ(string $dte_maj) Return the first ChildFinanciere filtered by the dte_maj column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFinanciere[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFinanciere objects based on current ModelCriteria
 * @method     ChildFinanciere[]|ObjectCollection findByID(int $id) Return ChildFinanciere objects filtered by the id column
 * @method     ChildFinanciere[]|ObjectCollection findByImmatricule(string $immatricule) Return ChildFinanciere objects filtered by the immatricule column
 * @method     ChildFinanciere[]|ObjectCollection findBySociete_FK(string $societe_FK) Return ChildFinanciere objects filtered by the societe_FK column
 * @method     ChildFinanciere[]|ObjectCollection findByCapital(double $capital) Return ChildFinanciere objects filtered by the capital column
 * @method     ChildFinanciere[]|ObjectCollection findByForm(string $form) Return ChildFinanciere objects filtered by the form column
 * @method     ChildFinanciere[]|ObjectCollection findByDtecreation(string $dte_creation) Return ChildFinanciere objects filtered by the dte_creation column
 * @method     ChildFinanciere[]|ObjectCollection findByNotes(string $notes) Return ChildFinanciere objects filtered by the notes column
 * @method     ChildFinanciere[]|ObjectCollection findByDte_MAJ(string $dte_maj) Return ChildFinanciere objects filtered by the dte_maj column
 * @method     ChildFinanciere[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FinanciereQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FinanciereQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Financiere', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFinanciereQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFinanciereQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFinanciereQuery) {
            return $criteria;
        }
        $query = new ChildFinanciereQuery();
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
     * @return ChildFinanciere|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FinanciereTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FinanciereTableMap::DATABASE_NAME);
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
     * @return ChildFinanciere A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, immatricule, societe_FK, capital, form, dte_creation, notes, dte_maj FROM financiere WHERE id = :p0';
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
            /** @var ChildFinanciere $obj */
            $obj = new ChildFinanciere();
            $obj->hydrate($row);
            FinanciereTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFinanciere|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FinanciereTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FinanciereTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(FinanciereTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(FinanciereTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FinanciereTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the immatricule column
     *
     * Example usage:
     * <code>
     * $query->filterByImmatricule('fooValue');   // WHERE immatricule = 'fooValue'
     * $query->filterByImmatricule('%fooValue%'); // WHERE immatricule LIKE '%fooValue%'
     * </code>
     *
     * @param     string $immatricule The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByImmatricule($immatricule = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($immatricule)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $immatricule)) {
                $immatricule = str_replace('*', '%', $immatricule);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FinanciereTableMap::COL_IMMATRICULE, $immatricule, $comparison);
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
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FinanciereTableMap::COL_SOCIETE_FK, $societe_FK, $comparison);
    }

    /**
     * Filter the query on the capital column
     *
     * Example usage:
     * <code>
     * $query->filterByCapital(1234); // WHERE capital = 1234
     * $query->filterByCapital(array(12, 34)); // WHERE capital IN (12, 34)
     * $query->filterByCapital(array('min' => 12)); // WHERE capital > 12
     * </code>
     *
     * @param     mixed $capital The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByCapital($capital = null, $comparison = null)
    {
        if (is_array($capital)) {
            $useMinMax = false;
            if (isset($capital['min'])) {
                $this->addUsingAlias(FinanciereTableMap::COL_CAPITAL, $capital['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($capital['max'])) {
                $this->addUsingAlias(FinanciereTableMap::COL_CAPITAL, $capital['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FinanciereTableMap::COL_CAPITAL, $capital, $comparison);
    }

    /**
     * Filter the query on the form column
     *
     * Example usage:
     * <code>
     * $query->filterByForm('fooValue');   // WHERE form = 'fooValue'
     * $query->filterByForm('%fooValue%'); // WHERE form LIKE '%fooValue%'
     * </code>
     *
     * @param     string $form The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByForm($form = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($form)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $form)) {
                $form = str_replace('*', '%', $form);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FinanciereTableMap::COL_FORM, $form, $comparison);
    }

    /**
     * Filter the query on the dte_creation column
     *
     * Example usage:
     * <code>
     * $query->filterByDtecreation('2011-03-14'); // WHERE dte_creation = '2011-03-14'
     * $query->filterByDtecreation('now'); // WHERE dte_creation = '2011-03-14'
     * $query->filterByDtecreation(array('max' => 'yesterday')); // WHERE dte_creation > '2011-03-13'
     * </code>
     *
     * @param     mixed $dtecreation The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByDtecreation($dtecreation = null, $comparison = null)
    {
        if (is_array($dtecreation)) {
            $useMinMax = false;
            if (isset($dtecreation['min'])) {
                $this->addUsingAlias(FinanciereTableMap::COL_DTE_CREATION, $dtecreation['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dtecreation['max'])) {
                $this->addUsingAlias(FinanciereTableMap::COL_DTE_CREATION, $dtecreation['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FinanciereTableMap::COL_DTE_CREATION, $dtecreation, $comparison);
    }

    /**
     * Filter the query on the notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes('fooValue');   // WHERE notes = 'fooValue'
     * $query->filterByNotes('%fooValue%'); // WHERE notes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByNotes($notes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notes)) {
                $notes = str_replace('*', '%', $notes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FinanciereTableMap::COL_NOTES, $notes, $comparison);
    }

    /**
     * Filter the query on the dte_maj column
     *
     * Example usage:
     * <code>
     * $query->filterByDte_MAJ('2011-03-14'); // WHERE dte_maj = '2011-03-14'
     * $query->filterByDte_MAJ('now'); // WHERE dte_maj = '2011-03-14'
     * $query->filterByDte_MAJ(array('max' => 'yesterday')); // WHERE dte_maj > '2011-03-13'
     * </code>
     *
     * @param     mixed $dte_MAJ The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterByDte_MAJ($dte_MAJ = null, $comparison = null)
    {
        if (is_array($dte_MAJ)) {
            $useMinMax = false;
            if (isset($dte_MAJ['min'])) {
                $this->addUsingAlias(FinanciereTableMap::COL_DTE_MAJ, $dte_MAJ['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dte_MAJ['max'])) {
                $this->addUsingAlias(FinanciereTableMap::COL_DTE_MAJ, $dte_MAJ['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FinanciereTableMap::COL_DTE_MAJ, $dte_MAJ, $comparison);
    }

    /**
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFinanciereQuery The current query, for fluid interface
     */
    public function filterBySociete($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(FinanciereTableMap::COL_SOCIETE_FK, $societe->getSociete(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FinanciereTableMap::COL_SOCIETE_FK, $societe->toKeyValue('PrimaryKey', 'Societe'), $comparison);
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
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
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
     * @param   ChildFinanciere $financiere Object to remove from the list of results
     *
     * @return $this|ChildFinanciereQuery The current query, for fluid interface
     */
    public function prune($financiere = null)
    {
        if ($financiere) {
            $this->addUsingAlias(FinanciereTableMap::COL_ID, $financiere->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the financiere table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FinanciereTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FinanciereTableMap::clearInstancePool();
            FinanciereTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FinanciereTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FinanciereTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FinanciereTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FinanciereTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FinanciereQuery
