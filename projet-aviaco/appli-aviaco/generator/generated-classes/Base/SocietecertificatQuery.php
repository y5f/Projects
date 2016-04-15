<?php

namespace Base;

use \Societecertificat as ChildSocietecertificat;
use \SocietecertificatQuery as ChildSocietecertificatQuery;
use \Exception;
use \PDO;
use Map\SocietecertificatTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'soccertificat' table.
 *
 *
 *
 * @method     ChildSocietecertificatQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildSocietecertificatQuery orderBysociete_PK($order = Criteria::ASC) Order by the societe_PK column
 * @method     ChildSocietecertificatQuery orderByAgrement_PK($order = Criteria::ASC) Order by the agrement_PK column
 * @method     ChildSocietecertificatQuery orderByIdAppareil($order = Criteria::ASC) Order by the idAp_PK column
 * @method     ChildSocietecertificatQuery orderByisMRO($order = Criteria::ASC) Order by the isMRO column
 *
 * @method     ChildSocietecertificatQuery groupByID() Group by the id column
 * @method     ChildSocietecertificatQuery groupBysociete_PK() Group by the societe_PK column
 * @method     ChildSocietecertificatQuery groupByAgrement_PK() Group by the agrement_PK column
 * @method     ChildSocietecertificatQuery groupByIdAppareil() Group by the idAp_PK column
 * @method     ChildSocietecertificatQuery groupByisMRO() Group by the isMRO column
 *
 * @method     ChildSocietecertificatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSocietecertificatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSocietecertificatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSocietecertificatQuery leftJoinSociete($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societe relation
 * @method     ChildSocietecertificatQuery rightJoinSociete($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societe relation
 * @method     ChildSocietecertificatQuery innerJoinSociete($relationAlias = null) Adds a INNER JOIN clause to the query using the Societe relation
 *
 * @method     ChildSocietecertificatQuery leftJoinCertificat($relationAlias = null) Adds a LEFT JOIN clause to the query using the Certificat relation
 * @method     ChildSocietecertificatQuery rightJoinCertificat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Certificat relation
 * @method     ChildSocietecertificatQuery innerJoinCertificat($relationAlias = null) Adds a INNER JOIN clause to the query using the Certificat relation
 *
 * @method     ChildSocietecertificatQuery leftJoinAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appareil relation
 * @method     ChildSocietecertificatQuery rightJoinAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appareil relation
 * @method     ChildSocietecertificatQuery innerJoinAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Appareil relation
 *
 * @method     \SocieteQuery|\CertificatQuery|\AppareilQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSocietecertificat findOne(ConnectionInterface $con = null) Return the first ChildSocietecertificat matching the query
 * @method     ChildSocietecertificat findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSocietecertificat matching the query, or a new ChildSocietecertificat object populated from the query conditions when no match is found
 *
 * @method     ChildSocietecertificat findOneByID(int $id) Return the first ChildSocietecertificat filtered by the id column
 * @method     ChildSocietecertificat findOneBysociete_PK(string $societe_PK) Return the first ChildSocietecertificat filtered by the societe_PK column
 * @method     ChildSocietecertificat findOneByAgrement_PK(string $agrement_PK) Return the first ChildSocietecertificat filtered by the agrement_PK column
 * @method     ChildSocietecertificat findOneByIdAppareil(int $idAp_PK) Return the first ChildSocietecertificat filtered by the idAp_PK column
 * @method     ChildSocietecertificat findOneByisMRO(boolean $isMRO) Return the first ChildSocietecertificat filtered by the isMRO column *

 * @method     ChildSocietecertificat requirePk($key, ConnectionInterface $con = null) Return the ChildSocietecertificat by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocietecertificat requireOne(ConnectionInterface $con = null) Return the first ChildSocietecertificat matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSocietecertificat requireOneByID(int $id) Return the first ChildSocietecertificat filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocietecertificat requireOneBysociete_PK(string $societe_PK) Return the first ChildSocietecertificat filtered by the societe_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocietecertificat requireOneByAgrement_PK(string $agrement_PK) Return the first ChildSocietecertificat filtered by the agrement_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocietecertificat requireOneByIdAppareil(int $idAp_PK) Return the first ChildSocietecertificat filtered by the idAp_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSocietecertificat requireOneByisMRO(boolean $isMRO) Return the first ChildSocietecertificat filtered by the isMRO column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSocietecertificat[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSocietecertificat objects based on current ModelCriteria
 * @method     ChildSocietecertificat[]|ObjectCollection findByID(int $id) Return ChildSocietecertificat objects filtered by the id column
 * @method     ChildSocietecertificat[]|ObjectCollection findBysociete_PK(string $societe_PK) Return ChildSocietecertificat objects filtered by the societe_PK column
 * @method     ChildSocietecertificat[]|ObjectCollection findByAgrement_PK(string $agrement_PK) Return ChildSocietecertificat objects filtered by the agrement_PK column
 * @method     ChildSocietecertificat[]|ObjectCollection findByIdAppareil(int $idAp_PK) Return ChildSocietecertificat objects filtered by the idAp_PK column
 * @method     ChildSocietecertificat[]|ObjectCollection findByisMRO(boolean $isMRO) Return ChildSocietecertificat objects filtered by the isMRO column
 * @method     ChildSocietecertificat[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SocietecertificatQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SocietecertificatQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Societecertificat', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSocietecertificatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSocietecertificatQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSocietecertificatQuery) {
            return $criteria;
        }
        $query = new ChildSocietecertificatQuery();
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
     * @return ChildSocietecertificat|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SocietecertificatTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SocietecertificatTableMap::DATABASE_NAME);
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
     * @return ChildSocietecertificat A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, societe_PK, agrement_PK, idAp_PK, isMRO FROM soccertificat WHERE id = :p0';
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
            /** @var ChildSocietecertificat $obj */
            $obj = new ChildSocietecertificat();
            $obj->hydrate($row);
            SocietecertificatTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSocietecertificat|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SocietecertificatTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SocietecertificatTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(SocietecertificatTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(SocietecertificatTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocietecertificatTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the societe_PK column
     *
     * Example usage:
     * <code>
     * $query->filterBysociete_PK('fooValue');   // WHERE societe_PK = 'fooValue'
     * $query->filterBysociete_PK('%fooValue%'); // WHERE societe_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $societe_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterBysociete_PK($societe_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($societe_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $societe_PK)) {
                $societe_PK = str_replace('*', '%', $societe_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocietecertificatTableMap::COL_SOCIETE_PK, $societe_PK, $comparison);
    }

    /**
     * Filter the query on the agrement_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByAgrement_PK('fooValue');   // WHERE agrement_PK = 'fooValue'
     * $query->filterByAgrement_PK('%fooValue%'); // WHERE agrement_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $agrement_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterByAgrement_PK($agrement_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($agrement_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $agrement_PK)) {
                $agrement_PK = str_replace('*', '%', $agrement_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocietecertificatTableMap::COL_AGREMENT_PK, $agrement_PK, $comparison);
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
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterByIdAppareil($idAppareil = null, $comparison = null)
    {
        if (is_array($idAppareil)) {
            $useMinMax = false;
            if (isset($idAppareil['min'])) {
                $this->addUsingAlias(SocietecertificatTableMap::COL_IDAP_PK, $idAppareil['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAppareil['max'])) {
                $this->addUsingAlias(SocietecertificatTableMap::COL_IDAP_PK, $idAppareil['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocietecertificatTableMap::COL_IDAP_PK, $idAppareil, $comparison);
    }

    /**
     * Filter the query on the isMRO column
     *
     * Example usage:
     * <code>
     * $query->filterByisMRO(true); // WHERE isMRO = true
     * $query->filterByisMRO('yes'); // WHERE isMRO = true
     * </code>
     *
     * @param     boolean|string $isMRO The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterByisMRO($isMRO = null, $comparison = null)
    {
        if (is_string($isMRO)) {
            $isMRO = in_array(strtolower($isMRO), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SocietecertificatTableMap::COL_ISMRO, $isMRO, $comparison);
    }

    /**
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterBySociete($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(SocietecertificatTableMap::COL_SOCIETE_PK, $societe->getSociete(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocietecertificatTableMap::COL_SOCIETE_PK, $societe->toKeyValue('PrimaryKey', 'Societe'), $comparison);
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
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
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
     * Filter the query by a related \Certificat object
     *
     * @param \Certificat|ObjectCollection $certificat The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterByCertificat($certificat, $comparison = null)
    {
        if ($certificat instanceof \Certificat) {
            return $this
                ->addUsingAlias(SocietecertificatTableMap::COL_AGREMENT_PK, $certificat->getAgrement(), $comparison);
        } elseif ($certificat instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocietecertificatTableMap::COL_AGREMENT_PK, $certificat->toKeyValue('PrimaryKey', 'Agrement'), $comparison);
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
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
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
     * Filter the query by a related \Appareil object
     *
     * @param \Appareil|ObjectCollection $appareil The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function filterByAppareil($appareil, $comparison = null)
    {
        if ($appareil instanceof \Appareil) {
            return $this
                ->addUsingAlias(SocietecertificatTableMap::COL_IDAP_PK, $appareil->getIdAp(), $comparison);
        } elseif ($appareil instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocietecertificatTableMap::COL_IDAP_PK, $appareil->toKeyValue('IdAp', 'IdAp'), $comparison);
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
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
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
     * @param   ChildSocietecertificat $societecertificat Object to remove from the list of results
     *
     * @return $this|ChildSocietecertificatQuery The current query, for fluid interface
     */
    public function prune($societecertificat = null)
    {
        if ($societecertificat) {
            $this->addUsingAlias(SocietecertificatTableMap::COL_ID, $societecertificat->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the soccertificat table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SocietecertificatTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SocietecertificatTableMap::clearInstancePool();
            SocietecertificatTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SocietecertificatTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SocietecertificatTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SocietecertificatTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SocietecertificatTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SocietecertificatQuery
