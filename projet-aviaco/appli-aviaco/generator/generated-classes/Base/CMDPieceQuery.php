<?php

namespace Base;

use \CMDPiece as ChildCMDPiece;
use \CMDPieceQuery as ChildCMDPieceQuery;
use \Exception;
use \PDO;
use Map\CMDPieceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'piece_cmd' table.
 *
 *
 *
 * @method     ChildCMDPieceQuery orderByIDCommande_FK($order = Criteria::ASC) Order by the id_commande_FK column
 * @method     ChildCMDPieceQuery orderByIDPiece($order = Criteria::ASC) Order by the pc_id column
 * @method     ChildCMDPieceQuery orderByPNClient($order = Criteria::ASC) Order by the pn_clt column
 * @method     ChildCMDPieceQuery orderByQuantite($order = Criteria::ASC) Order by the quantite column
 * @method     ChildCMDPieceQuery orderByCPrix($order = Criteria::ASC) Order by the prix_clt column
 * @method     ChildCMDPieceQuery orderByPCENote($order = Criteria::ASC) Order by the note_pce column
 * @method     ChildCMDPieceQuery orderByADelai($order = Criteria::ASC) Order by the delai column
 * @method     ChildCMDPieceQuery orderByDTEProposition($order = Criteria::ASC) Order by the dte_propos column
 *
 * @method     ChildCMDPieceQuery groupByIDCommande_FK() Group by the id_commande_FK column
 * @method     ChildCMDPieceQuery groupByIDPiece() Group by the pc_id column
 * @method     ChildCMDPieceQuery groupByPNClient() Group by the pn_clt column
 * @method     ChildCMDPieceQuery groupByQuantite() Group by the quantite column
 * @method     ChildCMDPieceQuery groupByCPrix() Group by the prix_clt column
 * @method     ChildCMDPieceQuery groupByPCENote() Group by the note_pce column
 * @method     ChildCMDPieceQuery groupByADelai() Group by the delai column
 * @method     ChildCMDPieceQuery groupByDTEProposition() Group by the dte_propos column
 *
 * @method     ChildCMDPieceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCMDPieceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCMDPieceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCMDPieceQuery leftJoinCommande($relationAlias = null) Adds a LEFT JOIN clause to the query using the Commande relation
 * @method     ChildCMDPieceQuery rightJoinCommande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Commande relation
 * @method     ChildCMDPieceQuery innerJoinCommande($relationAlias = null) Adds a INNER JOIN clause to the query using the Commande relation
 *
 * @method     ChildCMDPieceQuery leftJoinPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Piece relation
 * @method     ChildCMDPieceQuery rightJoinPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Piece relation
 * @method     ChildCMDPieceQuery innerJoinPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Piece relation
 *
 * @method     \CommandeQuery|\PieceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCMDPiece findOne(ConnectionInterface $con = null) Return the first ChildCMDPiece matching the query
 * @method     ChildCMDPiece findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCMDPiece matching the query, or a new ChildCMDPiece object populated from the query conditions when no match is found
 *
 * @method     ChildCMDPiece findOneByIDCommande_FK(int $id_commande_FK) Return the first ChildCMDPiece filtered by the id_commande_FK column
 * @method     ChildCMDPiece findOneByIDPiece(int $pc_id) Return the first ChildCMDPiece filtered by the pc_id column
 * @method     ChildCMDPiece findOneByPNClient(string $pn_clt) Return the first ChildCMDPiece filtered by the pn_clt column
 * @method     ChildCMDPiece findOneByQuantite(int $quantite) Return the first ChildCMDPiece filtered by the quantite column
 * @method     ChildCMDPiece findOneByCPrix(string $prix_clt) Return the first ChildCMDPiece filtered by the prix_clt column
 * @method     ChildCMDPiece findOneByPCENote(string $note_pce) Return the first ChildCMDPiece filtered by the note_pce column
 * @method     ChildCMDPiece findOneByADelai(string $delai) Return the first ChildCMDPiece filtered by the delai column
 * @method     ChildCMDPiece findOneByDTEProposition(string $dte_propos) Return the first ChildCMDPiece filtered by the dte_propos column *

 * @method     ChildCMDPiece requirePk($key, ConnectionInterface $con = null) Return the ChildCMDPiece by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDPiece requireOne(ConnectionInterface $con = null) Return the first ChildCMDPiece matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCMDPiece requireOneByIDCommande_FK(int $id_commande_FK) Return the first ChildCMDPiece filtered by the id_commande_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDPiece requireOneByIDPiece(int $pc_id) Return the first ChildCMDPiece filtered by the pc_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDPiece requireOneByPNClient(string $pn_clt) Return the first ChildCMDPiece filtered by the pn_clt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDPiece requireOneByQuantite(int $quantite) Return the first ChildCMDPiece filtered by the quantite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDPiece requireOneByCPrix(string $prix_clt) Return the first ChildCMDPiece filtered by the prix_clt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDPiece requireOneByPCENote(string $note_pce) Return the first ChildCMDPiece filtered by the note_pce column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDPiece requireOneByADelai(string $delai) Return the first ChildCMDPiece filtered by the delai column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCMDPiece requireOneByDTEProposition(string $dte_propos) Return the first ChildCMDPiece filtered by the dte_propos column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCMDPiece[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCMDPiece objects based on current ModelCriteria
 * @method     ChildCMDPiece[]|ObjectCollection findByIDCommande_FK(int $id_commande_FK) Return ChildCMDPiece objects filtered by the id_commande_FK column
 * @method     ChildCMDPiece[]|ObjectCollection findByIDPiece(int $pc_id) Return ChildCMDPiece objects filtered by the pc_id column
 * @method     ChildCMDPiece[]|ObjectCollection findByPNClient(string $pn_clt) Return ChildCMDPiece objects filtered by the pn_clt column
 * @method     ChildCMDPiece[]|ObjectCollection findByQuantite(int $quantite) Return ChildCMDPiece objects filtered by the quantite column
 * @method     ChildCMDPiece[]|ObjectCollection findByCPrix(string $prix_clt) Return ChildCMDPiece objects filtered by the prix_clt column
 * @method     ChildCMDPiece[]|ObjectCollection findByPCENote(string $note_pce) Return ChildCMDPiece objects filtered by the note_pce column
 * @method     ChildCMDPiece[]|ObjectCollection findByADelai(string $delai) Return ChildCMDPiece objects filtered by the delai column
 * @method     ChildCMDPiece[]|ObjectCollection findByDTEProposition(string $dte_propos) Return ChildCMDPiece objects filtered by the dte_propos column
 * @method     ChildCMDPiece[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CMDPieceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CMDPieceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\CMDPiece', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCMDPieceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCMDPieceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCMDPieceQuery) {
            return $criteria;
        }
        $query = new ChildCMDPieceQuery();
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
     * @param array[$id_commande_FK, $pc_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCMDPiece|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CMDPieceTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CMDPieceTableMap::DATABASE_NAME);
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
     * @return ChildCMDPiece A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_commande_FK, pc_id, pn_clt, quantite, prix_clt, note_pce, delai, dte_propos FROM piece_cmd WHERE id_commande_FK = :p0 AND pc_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCMDPiece $obj */
            $obj = new ChildCMDPiece();
            $obj->hydrate($row);
            CMDPieceTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildCMDPiece|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CMDPieceTableMap::COL_ID_COMMANDE_FK, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CMDPieceTableMap::COL_PC_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CMDPieceTableMap::COL_ID_COMMANDE_FK, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CMDPieceTableMap::COL_PC_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByIDCommande_FK($iDCommande_FK = null, $comparison = null)
    {
        if (is_array($iDCommande_FK)) {
            $useMinMax = false;
            if (isset($iDCommande_FK['min'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDCommande_FK['max'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDPieceTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK, $comparison);
    }

    /**
     * Filter the query on the pc_id column
     *
     * Example usage:
     * <code>
     * $query->filterByIDPiece(1234); // WHERE pc_id = 1234
     * $query->filterByIDPiece(array(12, 34)); // WHERE pc_id IN (12, 34)
     * $query->filterByIDPiece(array('min' => 12)); // WHERE pc_id > 12
     * </code>
     *
     * @see       filterByPiece()
     *
     * @param     mixed $iDPiece The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByIDPiece($iDPiece = null, $comparison = null)
    {
        if (is_array($iDPiece)) {
            $useMinMax = false;
            if (isset($iDPiece['min'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_PC_ID, $iDPiece['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDPiece['max'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_PC_ID, $iDPiece['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDPieceTableMap::COL_PC_ID, $iDPiece, $comparison);
    }

    /**
     * Filter the query on the pn_clt column
     *
     * Example usage:
     * <code>
     * $query->filterByPNClient('fooValue');   // WHERE pn_clt = 'fooValue'
     * $query->filterByPNClient('%fooValue%'); // WHERE pn_clt LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pNClient The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByPNClient($pNClient = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pNClient)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pNClient)) {
                $pNClient = str_replace('*', '%', $pNClient);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CMDPieceTableMap::COL_PN_CLT, $pNClient, $comparison);
    }

    /**
     * Filter the query on the quantite column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantite(1234); // WHERE quantite = 1234
     * $query->filterByQuantite(array(12, 34)); // WHERE quantite IN (12, 34)
     * $query->filterByQuantite(array('min' => 12)); // WHERE quantite > 12
     * </code>
     *
     * @param     mixed $quantite The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByQuantite($quantite = null, $comparison = null)
    {
        if (is_array($quantite)) {
            $useMinMax = false;
            if (isset($quantite['min'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_QUANTITE, $quantite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantite['max'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_QUANTITE, $quantite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDPieceTableMap::COL_QUANTITE, $quantite, $comparison);
    }

    /**
     * Filter the query on the prix_clt column
     *
     * Example usage:
     * <code>
     * $query->filterByCPrix('fooValue');   // WHERE prix_clt = 'fooValue'
     * $query->filterByCPrix('%fooValue%'); // WHERE prix_clt LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cPrix The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByCPrix($cPrix = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cPrix)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cPrix)) {
                $cPrix = str_replace('*', '%', $cPrix);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CMDPieceTableMap::COL_PRIX_CLT, $cPrix, $comparison);
    }

    /**
     * Filter the query on the note_pce column
     *
     * Example usage:
     * <code>
     * $query->filterByPCENote('fooValue');   // WHERE note_pce = 'fooValue'
     * $query->filterByPCENote('%fooValue%'); // WHERE note_pce LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pCENote The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByPCENote($pCENote = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pCENote)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pCENote)) {
                $pCENote = str_replace('*', '%', $pCENote);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CMDPieceTableMap::COL_NOTE_PCE, $pCENote, $comparison);
    }

    /**
     * Filter the query on the delai column
     *
     * Example usage:
     * <code>
     * $query->filterByADelai(1234); // WHERE delai = 1234
     * $query->filterByADelai(array(12, 34)); // WHERE delai IN (12, 34)
     * $query->filterByADelai(array('min' => 12)); // WHERE delai > 12
     * </code>
     *
     * @param     mixed $aDelai The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByADelai($aDelai = null, $comparison = null)
    {
        if (is_array($aDelai)) {
            $useMinMax = false;
            if (isset($aDelai['min'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_DELAI, $aDelai['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aDelai['max'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_DELAI, $aDelai['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDPieceTableMap::COL_DELAI, $aDelai, $comparison);
    }

    /**
     * Filter the query on the dte_propos column
     *
     * Example usage:
     * <code>
     * $query->filterByDTEProposition('2011-03-14'); // WHERE dte_propos = '2011-03-14'
     * $query->filterByDTEProposition('now'); // WHERE dte_propos = '2011-03-14'
     * $query->filterByDTEProposition(array('max' => 'yesterday')); // WHERE dte_propos > '2011-03-13'
     * </code>
     *
     * @param     mixed $dTEProposition The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByDTEProposition($dTEProposition = null, $comparison = null)
    {
        if (is_array($dTEProposition)) {
            $useMinMax = false;
            if (isset($dTEProposition['min'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_DTE_PROPOS, $dTEProposition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dTEProposition['max'])) {
                $this->addUsingAlias(CMDPieceTableMap::COL_DTE_PROPOS, $dTEProposition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CMDPieceTableMap::COL_DTE_PROPOS, $dTEProposition, $comparison);
    }

    /**
     * Filter the query by a related \Commande object
     *
     * @param \Commande|ObjectCollection $commande The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByCommande($commande, $comparison = null)
    {
        if ($commande instanceof \Commande) {
            return $this
                ->addUsingAlias(CMDPieceTableMap::COL_ID_COMMANDE_FK, $commande->getIDCommande(), $comparison);
        } elseif ($commande instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CMDPieceTableMap::COL_ID_COMMANDE_FK, $commande->toKeyValue('PrimaryKey', 'IDCommande'), $comparison);
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
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
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
     * @return ChildCMDPieceQuery The current query, for fluid interface
     */
    public function filterByPiece($piece, $comparison = null)
    {
        if ($piece instanceof \Piece) {
            return $this
                ->addUsingAlias(CMDPieceTableMap::COL_PC_ID, $piece->getID(), $comparison);
        } elseif ($piece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CMDPieceTableMap::COL_PC_ID, $piece->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildCMDPiece $cMDPiece Object to remove from the list of results
     *
     * @return $this|ChildCMDPieceQuery The current query, for fluid interface
     */
    public function prune($cMDPiece = null)
    {
        if ($cMDPiece) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CMDPieceTableMap::COL_ID_COMMANDE_FK), $cMDPiece->getIDCommande_FK(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CMDPieceTableMap::COL_PC_ID), $cMDPiece->getIDPiece(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the piece_cmd table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CMDPieceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CMDPieceTableMap::clearInstancePool();
            CMDPieceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CMDPieceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CMDPieceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CMDPieceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CMDPieceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CMDPieceQuery
