<?php

namespace Base;

use \CMDTAppareil as ChildCMDTAppareil;
use \CMDTAppareilQuery as ChildCMDTAppareilQuery;
use \Exception;
use \PDO;
use Map\CMDTAppareilTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cmd_app' table.
 *
 *
 *
 * @method     ChildCMDTAppareilQuery orderByIdAp_FK($order = Criteria::ASC) Order by the idAp_FK column
 * @method     ChildCMDTAppareilQuery orderByIDCommande_FK($order = Criteria::ASC) Order by the id_commande_FK column
 * @method     ChildCMDTAppareilQuery orderByIDPiece_FK($order = Criteria::ASC) Order by the id_piece_FK column
 *
 * @method     ChildCMDTAppareilQuery groupByIdAp_FK() Group by the idAp_FK column
 * @method     ChildCMDTAppareilQuery groupByIDCommande_FK() Group by the id_commande_FK column
 * @method     ChildCMDTAppareilQuery groupByIDPiece_FK() Group by the id_piece_FK column
 *
 * @method     ChildCMDTAppareilQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCMDTAppareilQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCMDTAppareilQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCMDTAppareilQuery leftJoinCommande($relationAlias = null) Adds a LEFT JOIN clause to the query using the Commande relation
 * @method     ChildCMDTAppareilQuery rightJoinCommande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Commande relation
 * @method     ChildCMDTAppareilQuery innerJoinCommande($relationAlias = null) Adds a INNER JOIN clause to the query using the Commande relation
 *
 * @method     ChildCMDTAppareilQuery leftJoinPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Piece relation
 * @method     ChildCMDTAppareilQuery rightJoinPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Piece relation
 * @method     ChildCMDTAppareilQuery innerJoinPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Piece relation
 *
 * @method     ChildCMDTAppareilQuery leftJoinAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appareil relation
 * @method     ChildCMDTAppareilQuery rightJoinAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appareil relation
 * @method     ChildCMDTAppareilQuery innerJoinAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Appareil relation
 *
 * @method     \CommandeQuery|\PieceQuery|\AppareilQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCMDTAppareil findOne(ConnectionInterface $con = null) Return the first ChildCMDTAppareil matching the query
 * @method     ChildCMDTAppareil findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCMDTAppareil matching the query, or a new ChildCMDTAppareil object populated from the query conditions when no match is found
 *
 * @method     ChildCMDTAppareil findOneByIdAp_FK(int $idAp_FK) Return the first ChildCMDTAppareil filtered by the idAp_FK column
 * @method     ChildCMDTAppareil findOneByIDCommande_FK(int $id_commande_FK) Return the first ChildCMDTAppareil filtered by the id_commande_FK column
 * @method     ChildCMDTAppareil findOneByIDPiece_FK(int $id_piece_FK) Return the first ChildCMDTAppareil filtered by the id_piece_FK column *

 * @method     ChildCMDTAppareil requirePk($key, ConnectionInterface $con = null) Return the ChildCMDTAppareil by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDTAppareil requireOne(ConnectionInterface $con = null) Return the first ChildCMDTAppareil matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCMDTAppareil requireOneByIdAp_FK(int $idAp_FK) Return the first ChildCMDTAppareil filtered by the idAp_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDTAppareil requireOneByIDCommande_FK(int $id_commande_FK) Return the first ChildCMDTAppareil filtered by the id_commande_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDTAppareil requireOneByIDPiece_FK(int $id_piece_FK) Return the first ChildCMDTAppareil filtered by the id_piece_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCMDTAppareil[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCMDTAppareil objects based on current ModelCriteria
 * @method     ChildCMDTAppareil[]|ObjectCollection findByIdAp_FK(int $idAp_FK) Return ChildCMDTAppareil objects filtered by the idAp_FK column
 * @method     ChildCMDTAppareil[]|ObjectCollection findByIDCommande_FK(int $id_commande_FK) Return ChildCMDTAppareil objects filtered by the id_commande_FK column
 * @method     ChildCMDTAppareil[]|ObjectCollection findByIDPiece_FK(int $id_piece_FK) Return ChildCMDTAppareil objects filtered by the id_piece_FK column
 * @method     ChildCMDTAppareil[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CMDTAppareilQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CMDTAppareilQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\CMDTAppareil', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCMDTAppareilQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCMDTAppareilQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCMDTAppareilQuery) {
            return $criteria;
        }
        $query = new ChildCMDTAppareilQuery();
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
     * @param array[$idAp_FK, $id_commande_FK, $id_piece_FK] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCMDTAppareil|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CMDTAppareilTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CMDTAppareilTableMap::DATABASE_NAME);
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
     * @return ChildCMDTAppareil A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idAp_FK, id_commande_FK, id_piece_FK FROM cmd_app WHERE idAp_FK = :p0 AND id_commande_FK = :p1 AND id_piece_FK = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCMDTAppareil $obj */
            $obj = new ChildCMDTAppareil();
            $obj->hydrate($row);
            CMDTAppareilTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2])));
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
     * @return ChildCMDTAppareil|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CMDTAppareilTableMap::COL_IDAP_FK, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CMDTAppareilTableMap::COL_ID_COMMANDE_FK, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(CMDTAppareilTableMap::COL_ID_PIECE_FK, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CMDTAppareilTableMap::COL_IDAP_FK, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CMDTAppareilTableMap::COL_ID_COMMANDE_FK, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(CMDTAppareilTableMap::COL_ID_PIECE_FK, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the idAp_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAp_FK(1234); // WHERE idAp_FK = 1234
     * $query->filterByIdAp_FK(array(12, 34)); // WHERE idAp_FK IN (12, 34)
     * $query->filterByIdAp_FK(array('min' => 12)); // WHERE idAp_FK > 12
     * </code>
     *
     * @see       filterByAppareil()
     *
     * @param     mixed $idAp_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function filterByIdAp_FK($idAp_FK = null, $comparison = null)
    {
        if (is_array($idAp_FK)) {
            $useMinMax = false;
            if (isset($idAp_FK['min'])) {
                $this->addUsingAlias(CMDTAppareilTableMap::COL_IDAP_FK, $idAp_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idAp_FK['max'])) {
                $this->addUsingAlias(CMDTAppareilTableMap::COL_IDAP_FK, $idAp_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDTAppareilTableMap::COL_IDAP_FK, $idAp_FK, $comparison);
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
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function filterByIDCommande_FK($iDCommande_FK = null, $comparison = null)
    {
        if (is_array($iDCommande_FK)) {
            $useMinMax = false;
            if (isset($iDCommande_FK['min'])) {
                $this->addUsingAlias(CMDTAppareilTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDCommande_FK['max'])) {
                $this->addUsingAlias(CMDTAppareilTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDTAppareilTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK, $comparison);
    }

    /**
     * Filter the query on the id_piece_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIDPiece_FK(1234); // WHERE id_piece_FK = 1234
     * $query->filterByIDPiece_FK(array(12, 34)); // WHERE id_piece_FK IN (12, 34)
     * $query->filterByIDPiece_FK(array('min' => 12)); // WHERE id_piece_FK > 12
     * </code>
     *
     * @see       filterByPiece()
     *
     * @param     mixed $iDPiece_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function filterByIDPiece_FK($iDPiece_FK = null, $comparison = null)
    {
        if (is_array($iDPiece_FK)) {
            $useMinMax = false;
            if (isset($iDPiece_FK['min'])) {
                $this->addUsingAlias(CMDTAppareilTableMap::COL_ID_PIECE_FK, $iDPiece_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDPiece_FK['max'])) {
                $this->addUsingAlias(CMDTAppareilTableMap::COL_ID_PIECE_FK, $iDPiece_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDTAppareilTableMap::COL_ID_PIECE_FK, $iDPiece_FK, $comparison);
    }

    /**
     * Filter the query by a related \Commande object
     *
     * @param \Commande|ObjectCollection $commande The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function filterByCommande($commande, $comparison = null)
    {
        if ($commande instanceof \Commande) {
            return $this
                ->addUsingAlias(CMDTAppareilTableMap::COL_ID_COMMANDE_FK, $commande->getIDCommande(), $comparison);
        } elseif ($commande instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CMDTAppareilTableMap::COL_ID_COMMANDE_FK, $commande->toKeyValue('PrimaryKey', 'IDCommande'), $comparison);
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
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
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
     * Filter the query by a related \Piece object
     *
     * @param \Piece|ObjectCollection $piece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function filterByPiece($piece, $comparison = null)
    {
        if ($piece instanceof \Piece) {
            return $this
                ->addUsingAlias(CMDTAppareilTableMap::COL_ID_PIECE_FK, $piece->getID(), $comparison);
        } elseif ($piece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CMDTAppareilTableMap::COL_ID_PIECE_FK, $piece->toKeyValue('PrimaryKey', 'ID'), $comparison);
        } else {
            throw new PropelException('filterByPiece() only accepts arguments of type \Piece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Piece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function joinPiece($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Piece');

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
            $this->addJoinObject($join, 'Piece');
        }

        return $this;
    }

    /**
     * Use the Piece relation Piece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PieceQuery A secondary query class using the current class as primary query
     */
    public function usePieceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Piece', '\PieceQuery');
    }

    /**
     * Filter the query by a related \Appareil object
     *
     * @param \Appareil|ObjectCollection $appareil The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function filterByAppareil($appareil, $comparison = null)
    {
        if ($appareil instanceof \Appareil) {
            return $this
                ->addUsingAlias(CMDTAppareilTableMap::COL_IDAP_FK, $appareil->getIdAp(), $comparison);
        } elseif ($appareil instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CMDTAppareilTableMap::COL_IDAP_FK, $appareil->toKeyValue('IdAp', 'IdAp'), $comparison);
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
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function joinAppareil($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useAppareilQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAppareil($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Appareil', '\AppareilQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCMDTAppareil $cMDTAppareil Object to remove from the list of results
     *
     * @return $this|ChildCMDTAppareilQuery The current query, for fluid interface
     */
    public function prune($cMDTAppareil = null)
    {
        if ($cMDTAppareil) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CMDTAppareilTableMap::COL_IDAP_FK), $cMDTAppareil->getIdAp_FK(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CMDTAppareilTableMap::COL_ID_COMMANDE_FK), $cMDTAppareil->getIDCommande_FK(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(CMDTAppareilTableMap::COL_ID_PIECE_FK), $cMDTAppareil->getIDPiece_FK(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cmd_app table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CMDTAppareilTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CMDTAppareilTableMap::clearInstancePool();
            CMDTAppareilTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CMDTAppareilTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CMDTAppareilTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CMDTAppareilTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CMDTAppareilTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CMDTAppareilQuery
