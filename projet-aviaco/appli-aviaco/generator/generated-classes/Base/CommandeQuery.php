<?php

namespace Base;

use \Commande as ChildCommande;
use \CommandeQuery as ChildCommandeQuery;
use \Exception;
use \PDO;
use Map\CommandeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'commande' table.
 *
 *
 *
 * @method     ChildCommandeQuery orderByIDCommande($order = Criteria::ASC) Order by the id_commande column
 * @method     ChildCommandeQuery orderByRFCommande($order = Criteria::ASC) Order by the reference column
 * @method     ChildCommandeQuery orderByIDSociete_FK($order = Criteria::ASC) Order by the soc_id_FK column
 * @method     ChildCommandeQuery orderByTMode($order = Criteria::ASC) Order by the transport_FK column
 * @method     ChildCommandeQuery orderByQuantite($order = Criteria::ASC) Order by the quantite column
 * @method     ChildCommandeQuery orderByAPrix($order = Criteria::ASC) Order by the prix column
 * @method     ChildCommandeQuery orderByADelai($order = Criteria::ASC) Order by the delai column
 * @method     ChildCommandeQuery orderByDTECommande($order = Criteria::ASC) Order by the dte_commande column
 * @method     ChildCommandeQuery orderByPriorite($order = Criteria::ASC) Order by the priorite column
 * @method     ChildCommandeQuery orderByCMDNote($order = Criteria::ASC) Order by the note column
 *
 * @method     ChildCommandeQuery groupByIDCommande() Group by the id_commande column
 * @method     ChildCommandeQuery groupByRFCommande() Group by the reference column
 * @method     ChildCommandeQuery groupByIDSociete_FK() Group by the soc_id_FK column
 * @method     ChildCommandeQuery groupByTMode() Group by the transport_FK column
 * @method     ChildCommandeQuery groupByQuantite() Group by the quantite column
 * @method     ChildCommandeQuery groupByAPrix() Group by the prix column
 * @method     ChildCommandeQuery groupByADelai() Group by the delai column
 * @method     ChildCommandeQuery groupByDTECommande() Group by the dte_commande column
 * @method     ChildCommandeQuery groupByPriorite() Group by the priorite column
 * @method     ChildCommandeQuery groupByCMDNote() Group by the note column
 *
 * @method     ChildCommandeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCommandeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCommandeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCommandeQuery leftJoinSociete($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societe relation
 * @method     ChildCommandeQuery rightJoinSociete($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societe relation
 * @method     ChildCommandeQuery innerJoinSociete($relationAlias = null) Adds a INNER JOIN clause to the query using the Societe relation
 *
 * @method     ChildCommandeQuery leftJoinMTransport($relationAlias = null) Adds a LEFT JOIN clause to the query using the MTransport relation
 * @method     ChildCommandeQuery rightJoinMTransport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MTransport relation
 * @method     ChildCommandeQuery innerJoinMTransport($relationAlias = null) Adds a INNER JOIN clause to the query using the MTransport relation
 *
 * @method     ChildCommandeQuery leftJoinCOMCondition($relationAlias = null) Adds a LEFT JOIN clause to the query using the COMCondition relation
 * @method     ChildCommandeQuery rightJoinCOMCondition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the COMCondition relation
 * @method     ChildCommandeQuery innerJoinCOMCondition($relationAlias = null) Adds a INNER JOIN clause to the query using the COMCondition relation
 *
 * @method     ChildCommandeQuery leftJoinCOMVendeur($relationAlias = null) Adds a LEFT JOIN clause to the query using the COMVendeur relation
 * @method     ChildCommandeQuery rightJoinCOMVendeur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the COMVendeur relation
 * @method     ChildCommandeQuery innerJoinCOMVendeur($relationAlias = null) Adds a INNER JOIN clause to the query using the COMVendeur relation
 *
 * @method     ChildCommandeQuery leftJoinCMDPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the CMDPiece relation
 * @method     ChildCommandeQuery rightJoinCMDPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CMDPiece relation
 * @method     ChildCommandeQuery innerJoinCMDPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the CMDPiece relation
 *
 * @method     ChildCommandeQuery leftJoinCOMEnduser($relationAlias = null) Adds a LEFT JOIN clause to the query using the COMEnduser relation
 * @method     ChildCommandeQuery rightJoinCOMEnduser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the COMEnduser relation
 * @method     ChildCommandeQuery innerJoinCOMEnduser($relationAlias = null) Adds a INNER JOIN clause to the query using the COMEnduser relation
 *
 * @method     ChildCommandeQuery leftJoinCMDTDoc($relationAlias = null) Adds a LEFT JOIN clause to the query using the CMDTDoc relation
 * @method     ChildCommandeQuery rightJoinCMDTDoc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CMDTDoc relation
 * @method     ChildCommandeQuery innerJoinCMDTDoc($relationAlias = null) Adds a INNER JOIN clause to the query using the CMDTDoc relation
 *
 * @method     ChildCommandeQuery leftJoinCMDTAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the CMDTAppareil relation
 * @method     ChildCommandeQuery rightJoinCMDTAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CMDTAppareil relation
 * @method     ChildCommandeQuery innerJoinCMDTAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the CMDTAppareil relation
 *
 * @method     \SocieteQuery|\MTransportQuery|\COMConditionQuery|\COMVendeurQuery|\CMDPieceQuery|\COMEnduserQuery|\CMDTDocQuery|\CMDTAppareilQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCommande findOne(ConnectionInterface $con = null) Return the first ChildCommande matching the query
 * @method     ChildCommande findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCommande matching the query, or a new ChildCommande object populated from the query conditions when no match is found
 *
 * @method     ChildCommande findOneByIDCommande(int $id_commande) Return the first ChildCommande filtered by the id_commande column
 * @method     ChildCommande findOneByRFCommande(string $reference) Return the first ChildCommande filtered by the reference column
 * @method     ChildCommande findOneByIDSociete_FK(int $soc_id_FK) Return the first ChildCommande filtered by the soc_id_FK column
 * @method     ChildCommande findOneByTMode(string $transport_FK) Return the first ChildCommande filtered by the transport_FK column
 * @method     ChildCommande findOneByQuantite(int $quantite) Return the first ChildCommande filtered by the quantite column
 * @method     ChildCommande findOneByAPrix(string $prix) Return the first ChildCommande filtered by the prix column
 * @method     ChildCommande findOneByADelai(string $delai) Return the first ChildCommande filtered by the delai column
 * @method     ChildCommande findOneByDTECommande(string $dte_commande) Return the first ChildCommande filtered by the dte_commande column
 * @method     ChildCommande findOneByPriorite(string $priorite) Return the first ChildCommande filtered by the priorite column
 * @method     ChildCommande findOneByCMDNote(string $note) Return the first ChildCommande filtered by the note column *

 * @method     ChildCommande requirePk($key, ConnectionInterface $con = null) Return the ChildCommande by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOne(ConnectionInterface $con = null) Return the first ChildCommande matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCommande requireOneByIDCommande(int $id_commande) Return the first ChildCommande filtered by the id_commande column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByRFCommande(string $reference) Return the first ChildCommande filtered by the reference column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByIDSociete_FK(int $soc_id_FK) Return the first ChildCommande filtered by the soc_id_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByTMode(string $transport_FK) Return the first ChildCommande filtered by the transport_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByQuantite(int $quantite) Return the first ChildCommande filtered by the quantite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByAPrix(string $prix) Return the first ChildCommande filtered by the prix column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByADelai(string $delai) Return the first ChildCommande filtered by the delai column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByDTECommande(string $dte_commande) Return the first ChildCommande filtered by the dte_commande column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByPriorite(string $priorite) Return the first ChildCommande filtered by the priorite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommande requireOneByCMDNote(string $note) Return the first ChildCommande filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCommande[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCommande objects based on current ModelCriteria
 * @method     ChildCommande[]|ObjectCollection findByIDCommande(int $id_commande) Return ChildCommande objects filtered by the id_commande column
 * @method     ChildCommande[]|ObjectCollection findByRFCommande(string $reference) Return ChildCommande objects filtered by the reference column
 * @method     ChildCommande[]|ObjectCollection findByIDSociete_FK(int $soc_id_FK) Return ChildCommande objects filtered by the soc_id_FK column
 * @method     ChildCommande[]|ObjectCollection findByTMode(string $transport_FK) Return ChildCommande objects filtered by the transport_FK column
 * @method     ChildCommande[]|ObjectCollection findByQuantite(int $quantite) Return ChildCommande objects filtered by the quantite column
 * @method     ChildCommande[]|ObjectCollection findByAPrix(string $prix) Return ChildCommande objects filtered by the prix column
 * @method     ChildCommande[]|ObjectCollection findByADelai(string $delai) Return ChildCommande objects filtered by the delai column
 * @method     ChildCommande[]|ObjectCollection findByDTECommande(string $dte_commande) Return ChildCommande objects filtered by the dte_commande column
 * @method     ChildCommande[]|ObjectCollection findByPriorite(string $priorite) Return ChildCommande objects filtered by the priorite column
 * @method     ChildCommande[]|ObjectCollection findByCMDNote(string $note) Return ChildCommande objects filtered by the note column
 * @method     ChildCommande[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CommandeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CommandeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Commande', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCommandeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCommandeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCommandeQuery) {
            return $criteria;
        }
        $query = new ChildCommandeQuery();
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
     * @return ChildCommande|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CommandeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommandeTableMap::DATABASE_NAME);
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
     * @return ChildCommande A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_commande, reference, soc_id_FK, transport_FK, quantite, prix, delai, dte_commande, priorite, note FROM commande WHERE id_commande = :p0';
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
            /** @var ChildCommande $obj */
            $obj = new ChildCommande();
            $obj->hydrate($row);
            CommandeTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCommande|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_commande column
     *
     * Example usage:
     * <code>
     * $query->filterByIDCommande(1234); // WHERE id_commande = 1234
     * $query->filterByIDCommande(array(12, 34)); // WHERE id_commande IN (12, 34)
     * $query->filterByIDCommande(array('min' => 12)); // WHERE id_commande > 12
     * </code>
     *
     * @param     mixed $iDCommande The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByIDCommande($iDCommande = null, $comparison = null)
    {
        if (is_array($iDCommande)) {
            $useMinMax = false;
            if (isset($iDCommande['min'])) {
                $this->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $iDCommande['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDCommande['max'])) {
                $this->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $iDCommande['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $iDCommande, $comparison);
    }

    /**
     * Filter the query on the reference column
     *
     * Example usage:
     * <code>
     * $query->filterByRFCommande('fooValue');   // WHERE reference = 'fooValue'
     * $query->filterByRFCommande('%fooValue%'); // WHERE reference LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rFCommande The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByRFCommande($rFCommande = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rFCommande)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rFCommande)) {
                $rFCommande = str_replace('*', '%', $rFCommande);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_REFERENCE, $rFCommande, $comparison);
    }

    /**
     * Filter the query on the soc_id_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIDSociete_FK(1234); // WHERE soc_id_FK = 1234
     * $query->filterByIDSociete_FK(array(12, 34)); // WHERE soc_id_FK IN (12, 34)
     * $query->filterByIDSociete_FK(array('min' => 12)); // WHERE soc_id_FK > 12
     * </code>
     *
     * @see       filterBySociete()
     *
     * @param     mixed $iDSociete_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByIDSociete_FK($iDSociete_FK = null, $comparison = null)
    {
        if (is_array($iDSociete_FK)) {
            $useMinMax = false;
            if (isset($iDSociete_FK['min'])) {
                $this->addUsingAlias(CommandeTableMap::COL_SOC_ID_FK, $iDSociete_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDSociete_FK['max'])) {
                $this->addUsingAlias(CommandeTableMap::COL_SOC_ID_FK, $iDSociete_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_SOC_ID_FK, $iDSociete_FK, $comparison);
    }

    /**
     * Filter the query on the transport_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByTMode('fooValue');   // WHERE transport_FK = 'fooValue'
     * $query->filterByTMode('%fooValue%'); // WHERE transport_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tMode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByTMode($tMode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tMode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tMode)) {
                $tMode = str_replace('*', '%', $tMode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_TRANSPORT_FK, $tMode, $comparison);
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
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByQuantite($quantite = null, $comparison = null)
    {
        if (is_array($quantite)) {
            $useMinMax = false;
            if (isset($quantite['min'])) {
                $this->addUsingAlias(CommandeTableMap::COL_QUANTITE, $quantite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantite['max'])) {
                $this->addUsingAlias(CommandeTableMap::COL_QUANTITE, $quantite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_QUANTITE, $quantite, $comparison);
    }

    /**
     * Filter the query on the prix column
     *
     * Example usage:
     * <code>
     * $query->filterByAPrix('fooValue');   // WHERE prix = 'fooValue'
     * $query->filterByAPrix('%fooValue%'); // WHERE prix LIKE '%fooValue%'
     * </code>
     *
     * @param     string $aPrix The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByAPrix($aPrix = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($aPrix)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $aPrix)) {
                $aPrix = str_replace('*', '%', $aPrix);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_PRIX, $aPrix, $comparison);
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
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByADelai($aDelai = null, $comparison = null)
    {
        if (is_array($aDelai)) {
            $useMinMax = false;
            if (isset($aDelai['min'])) {
                $this->addUsingAlias(CommandeTableMap::COL_DELAI, $aDelai['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aDelai['max'])) {
                $this->addUsingAlias(CommandeTableMap::COL_DELAI, $aDelai['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_DELAI, $aDelai, $comparison);
    }

    /**
     * Filter the query on the dte_commande column
     *
     * Example usage:
     * <code>
     * $query->filterByDTECommande('2011-03-14'); // WHERE dte_commande = '2011-03-14'
     * $query->filterByDTECommande('now'); // WHERE dte_commande = '2011-03-14'
     * $query->filterByDTECommande(array('max' => 'yesterday')); // WHERE dte_commande > '2011-03-13'
     * </code>
     *
     * @param     mixed $dTECommande The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByDTECommande($dTECommande = null, $comparison = null)
    {
        if (is_array($dTECommande)) {
            $useMinMax = false;
            if (isset($dTECommande['min'])) {
                $this->addUsingAlias(CommandeTableMap::COL_DTE_COMMANDE, $dTECommande['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dTECommande['max'])) {
                $this->addUsingAlias(CommandeTableMap::COL_DTE_COMMANDE, $dTECommande['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_DTE_COMMANDE, $dTECommande, $comparison);
    }

    /**
     * Filter the query on the priorite column
     *
     * Example usage:
     * <code>
     * $query->filterByPriorite(1234); // WHERE priorite = 1234
     * $query->filterByPriorite(array(12, 34)); // WHERE priorite IN (12, 34)
     * $query->filterByPriorite(array('min' => 12)); // WHERE priorite > 12
     * </code>
     *
     * @param     mixed $priorite The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByPriorite($priorite = null, $comparison = null)
    {
        if (is_array($priorite)) {
            $useMinMax = false;
            if (isset($priorite['min'])) {
                $this->addUsingAlias(CommandeTableMap::COL_PRIORITE, $priorite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priorite['max'])) {
                $this->addUsingAlias(CommandeTableMap::COL_PRIORITE, $priorite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_PRIORITE, $priorite, $comparison);
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByCMDNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByCMDNote('%fooValue%'); // WHERE note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cMDNote The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByCMDNote($cMDNote = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cMDNote)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cMDNote)) {
                $cMDNote = str_replace('*', '%', $cMDNote);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CommandeTableMap::COL_NOTE, $cMDNote, $comparison);
    }

    /**
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommandeQuery The current query, for fluid interface
     */
    public function filterBySociete($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(CommandeTableMap::COL_SOC_ID_FK, $societe->getID(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommandeTableMap::COL_SOC_ID_FK, $societe->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildCommandeQuery The current query, for fluid interface
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
     * Filter the query by a related \MTransport object
     *
     * @param \MTransport|ObjectCollection $mTransport The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByMTransport($mTransport, $comparison = null)
    {
        if ($mTransport instanceof \MTransport) {
            return $this
                ->addUsingAlias(CommandeTableMap::COL_TRANSPORT_FK, $mTransport->getMTransport(), $comparison);
        } elseif ($mTransport instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommandeTableMap::COL_TRANSPORT_FK, $mTransport->toKeyValue('PrimaryKey', 'MTransport'), $comparison);
        } else {
            throw new PropelException('filterByMTransport() only accepts arguments of type \MTransport or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MTransport relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function joinMTransport($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MTransport');

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
            $this->addJoinObject($join, 'MTransport');
        }

        return $this;
    }

    /**
     * Use the MTransport relation MTransport object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MTransportQuery A secondary query class using the current class as primary query
     */
    public function useMTransportQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMTransport($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MTransport', '\MTransportQuery');
    }

    /**
     * Filter the query by a related \COMCondition object
     *
     * @param \COMCondition|ObjectCollection $cOMCondition the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByCOMCondition($cOMCondition, $comparison = null)
    {
        if ($cOMCondition instanceof \COMCondition) {
            return $this
                ->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $cOMCondition->getIDCommande_FK(), $comparison);
        } elseif ($cOMCondition instanceof ObjectCollection) {
            return $this
                ->useCOMConditionQuery()
                ->filterByPrimaryKeys($cOMCondition->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCOMCondition() only accepts arguments of type \COMCondition or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the COMCondition relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function joinCOMCondition($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('COMCondition');

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
            $this->addJoinObject($join, 'COMCondition');
        }

        return $this;
    }

    /**
     * Use the COMCondition relation COMCondition object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \COMConditionQuery A secondary query class using the current class as primary query
     */
    public function useCOMConditionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCOMCondition($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'COMCondition', '\COMConditionQuery');
    }

    /**
     * Filter the query by a related \COMVendeur object
     *
     * @param \COMVendeur|ObjectCollection $cOMVendeur the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByCOMVendeur($cOMVendeur, $comparison = null)
    {
        if ($cOMVendeur instanceof \COMVendeur) {
            return $this
                ->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $cOMVendeur->getIDCommande_FK(), $comparison);
        } elseif ($cOMVendeur instanceof ObjectCollection) {
            return $this
                ->useCOMVendeurQuery()
                ->filterByPrimaryKeys($cOMVendeur->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCOMVendeur() only accepts arguments of type \COMVendeur or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the COMVendeur relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function joinCOMVendeur($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('COMVendeur');

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
            $this->addJoinObject($join, 'COMVendeur');
        }

        return $this;
    }

    /**
     * Use the COMVendeur relation COMVendeur object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \COMVendeurQuery A secondary query class using the current class as primary query
     */
    public function useCOMVendeurQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCOMVendeur($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'COMVendeur', '\COMVendeurQuery');
    }

    /**
     * Filter the query by a related \CMDPiece object
     *
     * @param \CMDPiece|ObjectCollection $cMDPiece the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByCMDPiece($cMDPiece, $comparison = null)
    {
        if ($cMDPiece instanceof \CMDPiece) {
            return $this
                ->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $cMDPiece->getIDCommande_FK(), $comparison);
        } elseif ($cMDPiece instanceof ObjectCollection) {
            return $this
                ->useCMDPieceQuery()
                ->filterByPrimaryKeys($cMDPiece->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCMDPiece() only accepts arguments of type \CMDPiece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CMDPiece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function joinCMDPiece($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CMDPiece');

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
            $this->addJoinObject($join, 'CMDPiece');
        }

        return $this;
    }

    /**
     * Use the CMDPiece relation CMDPiece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CMDPieceQuery A secondary query class using the current class as primary query
     */
    public function useCMDPieceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCMDPiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CMDPiece', '\CMDPieceQuery');
    }

    /**
     * Filter the query by a related \COMEnduser object
     *
     * @param \COMEnduser|ObjectCollection $cOMEnduser the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByCOMEnduser($cOMEnduser, $comparison = null)
    {
        if ($cOMEnduser instanceof \COMEnduser) {
            return $this
                ->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $cOMEnduser->getIDCommande_FK(), $comparison);
        } elseif ($cOMEnduser instanceof ObjectCollection) {
            return $this
                ->useCOMEnduserQuery()
                ->filterByPrimaryKeys($cOMEnduser->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCOMEnduser() only accepts arguments of type \COMEnduser or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the COMEnduser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function joinCOMEnduser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('COMEnduser');

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
            $this->addJoinObject($join, 'COMEnduser');
        }

        return $this;
    }

    /**
     * Use the COMEnduser relation COMEnduser object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \COMEnduserQuery A secondary query class using the current class as primary query
     */
    public function useCOMEnduserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCOMEnduser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'COMEnduser', '\COMEnduserQuery');
    }

    /**
     * Filter the query by a related \CMDTDoc object
     *
     * @param \CMDTDoc|ObjectCollection $cMDTDoc the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByCMDTDoc($cMDTDoc, $comparison = null)
    {
        if ($cMDTDoc instanceof \CMDTDoc) {
            return $this
                ->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $cMDTDoc->getIDCommande_FK(), $comparison);
        } elseif ($cMDTDoc instanceof ObjectCollection) {
            return $this
                ->useCMDTDocQuery()
                ->filterByPrimaryKeys($cMDTDoc->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCMDTDoc() only accepts arguments of type \CMDTDoc or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CMDTDoc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function joinCMDTDoc($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CMDTDoc');

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
            $this->addJoinObject($join, 'CMDTDoc');
        }

        return $this;
    }

    /**
     * Use the CMDTDoc relation CMDTDoc object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CMDTDocQuery A secondary query class using the current class as primary query
     */
    public function useCMDTDocQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCMDTDoc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CMDTDoc', '\CMDTDocQuery');
    }

    /**
     * Filter the query by a related \CMDTAppareil object
     *
     * @param \CMDTAppareil|ObjectCollection $cMDTAppareil the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommandeQuery The current query, for fluid interface
     */
    public function filterByCMDTAppareil($cMDTAppareil, $comparison = null)
    {
        if ($cMDTAppareil instanceof \CMDTAppareil) {
            return $this
                ->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $cMDTAppareil->getIDCommande_FK(), $comparison);
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
     * @return $this|ChildCommandeQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildCommande $commande Object to remove from the list of results
     *
     * @return $this|ChildCommandeQuery The current query, for fluid interface
     */
    public function prune($commande = null)
    {
        if ($commande) {
            $this->addUsingAlias(CommandeTableMap::COL_ID_COMMANDE, $commande->getIDCommande(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the commande table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommandeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommandeTableMap::clearInstancePool();
            CommandeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CommandeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CommandeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CommandeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CommandeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CommandeQuery
