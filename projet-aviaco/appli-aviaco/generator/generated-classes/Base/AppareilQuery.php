<?php

namespace Base;

use \Appareil as ChildAppareil;
use \AppareilQuery as ChildAppareilQuery;
use \Exception;
use \PDO;
use Map\AppareilTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'appareil' table.
 *
 *
 *
 * @method     ChildAppareilQuery orderByIdAp($order = Criteria::ASC) Order by the idAp column
 * @method     ChildAppareilQuery orderByImmatriculation($order = Criteria::ASC) Order by the Immatriculation column
 * @method     ChildAppareilQuery orderByNomApp($order = Criteria::ASC) Order by the nom_app column
 * @method     ChildAppareilQuery orderByModele_PK($order = Criteria::ASC) Order by the modele_PK column
 * @method     ChildAppareilQuery orderByMarque_PK($order = Criteria::ASC) Order by the marque_PK column
 *
 * @method     ChildAppareilQuery groupByIdAp() Group by the idAp column
 * @method     ChildAppareilQuery groupByImmatriculation() Group by the Immatriculation column
 * @method     ChildAppareilQuery groupByNomApp() Group by the nom_app column
 * @method     ChildAppareilQuery groupByModele_PK() Group by the modele_PK column
 * @method     ChildAppareilQuery groupByMarque_PK() Group by the marque_PK column
 *
 * @method     ChildAppareilQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAppareilQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAppareilQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAppareilQuery leftJoinMarque($relationAlias = null) Adds a LEFT JOIN clause to the query using the Marque relation
 * @method     ChildAppareilQuery rightJoinMarque($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Marque relation
 * @method     ChildAppareilQuery innerJoinMarque($relationAlias = null) Adds a INNER JOIN clause to the query using the Marque relation
 *
 * @method     ChildAppareilQuery leftJoinModele($relationAlias = null) Adds a LEFT JOIN clause to the query using the Modele relation
 * @method     ChildAppareilQuery rightJoinModele($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Modele relation
 * @method     ChildAppareilQuery innerJoinModele($relationAlias = null) Adds a INNER JOIN clause to the query using the Modele relation
 *
 * @method     ChildAppareilQuery leftJoinPieceApp($relationAlias = null) Adds a LEFT JOIN clause to the query using the PieceApp relation
 * @method     ChildAppareilQuery rightJoinPieceApp($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PieceApp relation
 * @method     ChildAppareilQuery innerJoinPieceApp($relationAlias = null) Adds a INNER JOIN clause to the query using the PieceApp relation
 *
 * @method     ChildAppareilQuery leftJoinPhotoappareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Photoappareil relation
 * @method     ChildAppareilQuery rightJoinPhotoappareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Photoappareil relation
 * @method     ChildAppareilQuery innerJoinPhotoappareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Photoappareil relation
 *
 * @method     ChildAppareilQuery leftJoinCMDTAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the CMDTAppareil relation
 * @method     ChildAppareilQuery rightJoinCMDTAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CMDTAppareil relation
 * @method     ChildAppareilQuery innerJoinCMDTAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the CMDTAppareil relation
 *
 * @method     ChildAppareilQuery leftJoinSocieteappareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societeappareil relation
 * @method     ChildAppareilQuery rightJoinSocieteappareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societeappareil relation
 * @method     ChildAppareilQuery innerJoinSocieteappareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Societeappareil relation
 *
 * @method     ChildAppareilQuery leftJoinAppareilcertificat($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appareilcertificat relation
 * @method     ChildAppareilQuery rightJoinAppareilcertificat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appareilcertificat relation
 * @method     ChildAppareilQuery innerJoinAppareilcertificat($relationAlias = null) Adds a INNER JOIN clause to the query using the Appareilcertificat relation
 *
 * @method     ChildAppareilQuery leftJoinSocietecertificat($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societecertificat relation
 * @method     ChildAppareilQuery rightJoinSocietecertificat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societecertificat relation
 * @method     ChildAppareilQuery innerJoinSocietecertificat($relationAlias = null) Adds a INNER JOIN clause to the query using the Societecertificat relation
 *
 * @method     \MarqueQuery|\ModelQuery|\PieceAppQuery|\PhotoappareilQuery|\CMDTAppareilQuery|\SocieteappareilQuery|\AppareilcertificatQuery|\SocietecertificatQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAppareil findOne(ConnectionInterface $con = null) Return the first ChildAppareil matching the query
 * @method     ChildAppareil findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAppareil matching the query, or a new ChildAppareil object populated from the query conditions when no match is found
 *
 * @method     ChildAppareil findOneByIdAp(int $idAp) Return the first ChildAppareil filtered by the idAp column
 * @method     ChildAppareil findOneByImmatriculation(string $Immatriculation) Return the first ChildAppareil filtered by the Immatriculation column
 * @method     ChildAppareil findOneByNomApp(string $nom_app) Return the first ChildAppareil filtered by the nom_app column
 * @method     ChildAppareil findOneByModele_PK(string $modele_PK) Return the first ChildAppareil filtered by the modele_PK column
 * @method     ChildAppareil findOneByMarque_PK(string $marque_PK) Return the first ChildAppareil filtered by the marque_PK column *

 * @method     ChildAppareil requirePk($key, ConnectionInterface $con = null) Return the ChildAppareil by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppareil requireOne(ConnectionInterface $con = null) Return the first ChildAppareil matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAppareil requireOneByIdAp(int $idAp) Return the first ChildAppareil filtered by the idAp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppareil requireOneByImmatriculation(string $Immatriculation) Return the first ChildAppareil filtered by the Immatriculation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppareil requireOneByNomApp(string $nom_app) Return the first ChildAppareil filtered by the nom_app column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppareil requireOneByModele_PK(string $modele_PK) Return the first ChildAppareil filtered by the modele_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAppareil requireOneByMarque_PK(string $marque_PK) Return the first ChildAppareil filtered by the marque_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAppareil[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAppareil objects based on current ModelCriteria
 * @method     ChildAppareil[]|ObjectCollection findByIdAp(int $idAp) Return ChildAppareil objects filtered by the idAp column
 * @method     ChildAppareil[]|ObjectCollection findByImmatriculation(string $Immatriculation) Return ChildAppareil objects filtered by the Immatriculation column
 * @method     ChildAppareil[]|ObjectCollection findByNomApp(string $nom_app) Return ChildAppareil objects filtered by the nom_app column
 * @method     ChildAppareil[]|ObjectCollection findByModele_PK(string $modele_PK) Return ChildAppareil objects filtered by the modele_PK column
 * @method     ChildAppareil[]|ObjectCollection findByMarque_PK(string $marque_PK) Return ChildAppareil objects filtered by the marque_PK column
 * @method     ChildAppareil[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AppareilQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AppareilQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Appareil', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAppareilQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAppareilQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAppareilQuery) {
            return $criteria;
        }
        $query = new ChildAppareilQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$idAp, $modele_PK, $marque_PK] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAppareil|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AppareilTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AppareilTableMap::DATABASE_NAME);
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
     * @return ChildAppareil A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idAp, Immatriculation, nom_app, modele_PK, marque_PK FROM appareil WHERE idAp = :p0 AND modele_PK = :p1 AND marque_PK = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAppareil $obj */
            $obj = new ChildAppareil();
            $obj->hydrate($row);
            AppareilTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2])));
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
     * @return ChildAppareil|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AppareilTableMap::COL_IDAP, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AppareilTableMap::COL_MODELE_PK, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(AppareilTableMap::COL_MARQUE_PK, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AppareilTableMap::COL_IDAP, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AppareilTableMap::COL_MODELE_PK, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(AppareilTableMap::COL_MARQUE_PK, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the idAp column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAp(1234); // WHERE idAp = 1234
     * $query->filterByIdAp(array(12, 34)); // WHERE idAp IN (12, 34)
     * $query->filterByIdAp(array('min' => 12)); // WHERE idAp > 12
     * </code>
     *
     * @param     mixed $idAp The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByIdAp($idAp = null, $comparison = null)
    {
        if (is_array($idAp)) {
            $useMinMax = false;
            if (isset($idAp['min'])) {
                $this->addUsingAlias(AppareilTableMap::COL_IDAP, $idAp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAp['max'])) {
                $this->addUsingAlias(AppareilTableMap::COL_IDAP, $idAp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AppareilTableMap::COL_IDAP, $idAp, $comparison);
    }

    /**
     * Filter the query on the Immatriculation column
     *
     * Example usage:
     * <code>
     * $query->filterByImmatriculation('fooValue');   // WHERE Immatriculation = 'fooValue'
     * $query->filterByImmatriculation('%fooValue%'); // WHERE Immatriculation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $immatriculation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByImmatriculation($immatriculation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($immatriculation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $immatriculation)) {
                $immatriculation = str_replace('*', '%', $immatriculation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AppareilTableMap::COL_IMMATRICULATION, $immatriculation, $comparison);
    }

    /**
     * Filter the query on the nom_app column
     *
     * Example usage:
     * <code>
     * $query->filterByNomApp('fooValue');   // WHERE nom_app = 'fooValue'
     * $query->filterByNomApp('%fooValue%'); // WHERE nom_app LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nomApp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByNomApp($nomApp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nomApp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nomApp)) {
                $nomApp = str_replace('*', '%', $nomApp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AppareilTableMap::COL_NOM_APP, $nomApp, $comparison);
    }

    /**
     * Filter the query on the modele_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByModele_PK('fooValue');   // WHERE modele_PK = 'fooValue'
     * $query->filterByModele_PK('%fooValue%'); // WHERE modele_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $modele_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByModele_PK($modele_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($modele_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $modele_PK)) {
                $modele_PK = str_replace('*', '%', $modele_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AppareilTableMap::COL_MODELE_PK, $modele_PK, $comparison);
    }

    /**
     * Filter the query on the marque_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByMarque_PK('fooValue');   // WHERE marque_PK = 'fooValue'
     * $query->filterByMarque_PK('%fooValue%'); // WHERE marque_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $marque_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByMarque_PK($marque_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($marque_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $marque_PK)) {
                $marque_PK = str_replace('*', '%', $marque_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AppareilTableMap::COL_MARQUE_PK, $marque_PK, $comparison);
    }

    /**
     * Filter the query by a related \Marque object
     *
     * @param \Marque|ObjectCollection $marque The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByMarque($marque, $comparison = null)
    {
        if ($marque instanceof \Marque) {
            return $this
                ->addUsingAlias(AppareilTableMap::COL_MARQUE_PK, $marque->getMarque(), $comparison);
        } elseif ($marque instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AppareilTableMap::COL_MARQUE_PK, $marque->toKeyValue('PrimaryKey', 'Marque'), $comparison);
        } else {
            throw new PropelException('filterByMarque() only accepts arguments of type \Marque or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Marque relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function joinMarque($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Marque');

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
            $this->addJoinObject($join, 'Marque');
        }

        return $this;
    }

    /**
     * Use the Marque relation Marque object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MarqueQuery A secondary query class using the current class as primary query
     */
    public function useMarqueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMarque($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Marque', '\MarqueQuery');
    }

    /**
     * Filter the query by a related \Model object
     *
     * @param \Model|ObjectCollection $model The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByModele($model, $comparison = null)
    {
        if ($model instanceof \Model) {
            return $this
                ->addUsingAlias(AppareilTableMap::COL_MODELE_PK, $model->getModele(), $comparison);
        } elseif ($model instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AppareilTableMap::COL_MODELE_PK, $model->toKeyValue('PrimaryKey', 'Modele'), $comparison);
        } else {
            throw new PropelException('filterByModele() only accepts arguments of type \Model or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Modele relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function joinModele($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Modele');

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
            $this->addJoinObject($join, 'Modele');
        }

        return $this;
    }

    /**
     * Use the Modele relation Model object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ModelQuery A secondary query class using the current class as primary query
     */
    public function useModeleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinModele($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Modele', '\ModelQuery');
    }

    /**
     * Filter the query by a related \PieceApp object
     *
     * @param \PieceApp|ObjectCollection $pieceApp the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByPieceApp($pieceApp, $comparison = null)
    {
        if ($pieceApp instanceof \PieceApp) {
            return $this
                ->addUsingAlias(AppareilTableMap::COL_IDAP, $pieceApp->getIdAp_PK(), $comparison);
        } elseif ($pieceApp instanceof ObjectCollection) {
            return $this
                ->usePieceAppQuery()
                ->filterByPrimaryKeys($pieceApp->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPieceApp() only accepts arguments of type \PieceApp or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PieceApp relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function joinPieceApp($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PieceApp');

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
            $this->addJoinObject($join, 'PieceApp');
        }

        return $this;
    }

    /**
     * Use the PieceApp relation PieceApp object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PieceAppQuery A secondary query class using the current class as primary query
     */
    public function usePieceAppQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPieceApp($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PieceApp', '\PieceAppQuery');
    }

    /**
     * Filter the query by a related \Photoappareil object
     *
     * @param \Photoappareil|ObjectCollection $photoappareil the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByPhotoappareil($photoappareil, $comparison = null)
    {
        if ($photoappareil instanceof \Photoappareil) {
            return $this
                ->addUsingAlias(AppareilTableMap::COL_IDAP, $photoappareil->getIdAp_PK(), $comparison);
        } elseif ($photoappareil instanceof ObjectCollection) {
            return $this
                ->usePhotoappareilQuery()
                ->filterByPrimaryKeys($photoappareil->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPhotoappareil() only accepts arguments of type \Photoappareil or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Photoappareil relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function joinPhotoappareil($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Photoappareil');

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
            $this->addJoinObject($join, 'Photoappareil');
        }

        return $this;
    }

    /**
     * Use the Photoappareil relation Photoappareil object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PhotoappareilQuery A secondary query class using the current class as primary query
     */
    public function usePhotoappareilQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPhotoappareil($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Photoappareil', '\PhotoappareilQuery');
    }

    /**
     * Filter the query by a related \CMDTAppareil object
     *
     * @param \CMDTAppareil|ObjectCollection $cMDTAppareil the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByCMDTAppareil($cMDTAppareil, $comparison = null)
    {
        if ($cMDTAppareil instanceof \CMDTAppareil) {
            return $this
                ->addUsingAlias(AppareilTableMap::COL_IDAP, $cMDTAppareil->getIdAp_FK(), $comparison);
        } elseif ($cMDTAppareil instanceof ObjectCollection) {
            return $this
                ->useCMDTAppareilQuery()
                ->filterByPrimaryKeys($cMDTAppareil->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCMDTAppareil() only accepts arguments of type \CMDTAppareil or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CMDTAppareil relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function joinCMDTAppareil($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CMDTAppareil');

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
            $this->addJoinObject($join, 'CMDTAppareil');
        }

        return $this;
    }

    /**
     * Use the CMDTAppareil relation CMDTAppareil object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CMDTAppareilQuery A secondary query class using the current class as primary query
     */
    public function useCMDTAppareilQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCMDTAppareil($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CMDTAppareil', '\CMDTAppareilQuery');
    }

    /**
     * Filter the query by a related \Societeappareil object
     *
     * @param \Societeappareil|ObjectCollection $societeappareil the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAppareilQuery The current query, for fluid interface
     */
    public function filterBySocieteappareil($societeappareil, $comparison = null)
    {
        if ($societeappareil instanceof \Societeappareil) {
            return $this
                ->addUsingAlias(AppareilTableMap::COL_IDAP, $societeappareil->getIdAppareil_FK(), $comparison);
        } elseif ($societeappareil instanceof ObjectCollection) {
            return $this
                ->useSocieteappareilQuery()
                ->filterByPrimaryKeys($societeappareil->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySocieteappareil() only accepts arguments of type \Societeappareil or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societeappareil relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function joinSocieteappareil($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societeappareil');

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
            $this->addJoinObject($join, 'Societeappareil');
        }

        return $this;
    }

    /**
     * Use the Societeappareil relation Societeappareil object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocieteappareilQuery A secondary query class using the current class as primary query
     */
    public function useSocieteappareilQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocieteappareil($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societeappareil', '\SocieteappareilQuery');
    }

    /**
     * Filter the query by a related \Appareilcertificat object
     *
     * @param \Appareilcertificat|ObjectCollection $appareilcertificat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAppareilQuery The current query, for fluid interface
     */
    public function filterByAppareilcertificat($appareilcertificat, $comparison = null)
    {
        if ($appareilcertificat instanceof \Appareilcertificat) {
            return $this
                ->addUsingAlias(AppareilTableMap::COL_IDAP, $appareilcertificat->getIdAppareil(), $comparison);
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
     * @return $this|ChildAppareilQuery The current query, for fluid interface
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
     * @return ChildAppareilQuery The current query, for fluid interface
     */
    public function filterBySocietecertificat($societecertificat, $comparison = null)
    {
        if ($societecertificat instanceof \Societecertificat) {
            return $this
                ->addUsingAlias(AppareilTableMap::COL_IDAP, $societecertificat->getIdAppareil(), $comparison);
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
     * @return $this|ChildAppareilQuery The current query, for fluid interface
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
     * @param   ChildAppareil $appareil Object to remove from the list of results
     *
     * @return $this|ChildAppareilQuery The current query, for fluid interface
     */
    public function prune($appareil = null)
    {
        if ($appareil) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AppareilTableMap::COL_IDAP), $appareil->getIdAp(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AppareilTableMap::COL_MODELE_PK), $appareil->getModele_PK(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(AppareilTableMap::COL_MARQUE_PK), $appareil->getMarque_PK(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the appareil table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AppareilTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AppareilTableMap::clearInstancePool();
            AppareilTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AppareilTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AppareilTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AppareilTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AppareilTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AppareilQuery
