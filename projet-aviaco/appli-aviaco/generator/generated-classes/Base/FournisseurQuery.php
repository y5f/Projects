<?php

namespace Base;

use \Fournisseur as ChildFournisseur;
use \FournisseurQuery as ChildFournisseurQuery;
use \Exception;
use \PDO;
use Map\FournisseurTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fournisseur' table.
 *
 *
 *
 * @method     ChildFournisseurQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildFournisseurQuery orderByQuantite($order = Criteria::ASC) Order by the quantite column
 * @method     ChildFournisseurQuery orderByPrixachat($order = Criteria::ASC) Order by the prix_achat column
 * @method     ChildFournisseurQuery orderByPrixvente($order = Criteria::ASC) Order by the prix_vente column
 * @method     ChildFournisseurQuery orderByDTESave($order = Criteria::ASC) Order by the date_enreg column
 * @method     ChildFournisseurQuery orderByisProd($order = Criteria::ASC) Order by the production column
 * @method     ChildFournisseurQuery orderByDelai($order = Criteria::ASC) Order by the delai column
 * @method     ChildFournisseurQuery orderByIDPiece_PK($order = Criteria::ASC) Order by the id_piece_FK column
 * @method     ChildFournisseurQuery orderByVCondition($order = Criteria::ASC) Order by the condition_FK column
 * @method     ChildFournisseurQuery orderByTMode($order = Criteria::ASC) Order by the transport_FK column
 * @method     ChildFournisseurQuery orderByIDSoc_FK($order = Criteria::ASC) Order by the soc_id_FK column
 * @method     ChildFournisseurQuery orderByFABAnnee($order = Criteria::ASC) Order by the annee_fab column
 * @method     ChildFournisseurQuery orderByTRestant($order = Criteria::ASC) Order by the tmp_rest column
 * @method     ChildFournisseurQuery orderByTTotal($order = Criteria::ASC) Order by the tmp_total column
 * @method     ChildFournisseurQuery orderByDVie($order = Criteria::ASC) Order by the duree_vie column
 * @method     ChildFournisseurQuery orderByOLDApp($order = Criteria::ASC) Order by the old_app column
 * @method     ChildFournisseurQuery orderByNApp($order = Criteria::ASC) Order by the new_app column
 * @method     ChildFournisseurQuery orderByNBROh($order = Criteria::ASC) Order by the nbr_oh column
 * @method     ChildFournisseurQuery orderByNote($order = Criteria::ASC) Order by the note column
 *
 * @method     ChildFournisseurQuery groupByID() Group by the id column
 * @method     ChildFournisseurQuery groupByQuantite() Group by the quantite column
 * @method     ChildFournisseurQuery groupByPrixachat() Group by the prix_achat column
 * @method     ChildFournisseurQuery groupByPrixvente() Group by the prix_vente column
 * @method     ChildFournisseurQuery groupByDTESave() Group by the date_enreg column
 * @method     ChildFournisseurQuery groupByisProd() Group by the production column
 * @method     ChildFournisseurQuery groupByDelai() Group by the delai column
 * @method     ChildFournisseurQuery groupByIDPiece_PK() Group by the id_piece_FK column
 * @method     ChildFournisseurQuery groupByVCondition() Group by the condition_FK column
 * @method     ChildFournisseurQuery groupByTMode() Group by the transport_FK column
 * @method     ChildFournisseurQuery groupByIDSoc_FK() Group by the soc_id_FK column
 * @method     ChildFournisseurQuery groupByFABAnnee() Group by the annee_fab column
 * @method     ChildFournisseurQuery groupByTRestant() Group by the tmp_rest column
 * @method     ChildFournisseurQuery groupByTTotal() Group by the tmp_total column
 * @method     ChildFournisseurQuery groupByDVie() Group by the duree_vie column
 * @method     ChildFournisseurQuery groupByOLDApp() Group by the old_app column
 * @method     ChildFournisseurQuery groupByNApp() Group by the new_app column
 * @method     ChildFournisseurQuery groupByNBROh() Group by the nbr_oh column
 * @method     ChildFournisseurQuery groupByNote() Group by the note column
 *
 * @method     ChildFournisseurQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFournisseurQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFournisseurQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFournisseurQuery leftJoinPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Piece relation
 * @method     ChildFournisseurQuery rightJoinPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Piece relation
 * @method     ChildFournisseurQuery innerJoinPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Piece relation
 *
 * @method     ChildFournisseurQuery leftJoinSociete($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societe relation
 * @method     ChildFournisseurQuery rightJoinSociete($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societe relation
 * @method     ChildFournisseurQuery innerJoinSociete($relationAlias = null) Adds a INNER JOIN clause to the query using the Societe relation
 *
 * @method     ChildFournisseurQuery leftJoinCondition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Condition relation
 * @method     ChildFournisseurQuery rightJoinCondition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Condition relation
 * @method     ChildFournisseurQuery innerJoinCondition($relationAlias = null) Adds a INNER JOIN clause to the query using the Condition relation
 *
 * @method     ChildFournisseurQuery leftJoinMTransport($relationAlias = null) Adds a LEFT JOIN clause to the query using the MTransport relation
 * @method     ChildFournisseurQuery rightJoinMTransport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MTransport relation
 * @method     ChildFournisseurQuery innerJoinMTransport($relationAlias = null) Adds a INNER JOIN clause to the query using the MTransport relation
 *
 * @method     ChildFournisseurQuery leftJoinCOMVendeur($relationAlias = null) Adds a LEFT JOIN clause to the query using the COMVendeur relation
 * @method     ChildFournisseurQuery rightJoinCOMVendeur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the COMVendeur relation
 * @method     ChildFournisseurQuery innerJoinCOMVendeur($relationAlias = null) Adds a INNER JOIN clause to the query using the COMVendeur relation
 *
 * @method     ChildFournisseurQuery leftJoinDoc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Doc relation
 * @method     ChildFournisseurQuery rightJoinDoc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Doc relation
 * @method     ChildFournisseurQuery innerJoinDoc($relationAlias = null) Adds a INNER JOIN clause to the query using the Doc relation
 *
 * @method     ChildFournisseurQuery leftJoinPhotopiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Photopiece relation
 * @method     ChildFournisseurQuery rightJoinPhotopiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Photopiece relation
 * @method     ChildFournisseurQuery innerJoinPhotopiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Photopiece relation
 *
 * @method     \PieceQuery|\SocieteQuery|\ConditionQuery|\MTransportQuery|\COMVendeurQuery|\DocumentQuery|\PhotopieceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFournisseur findOne(ConnectionInterface $con = null) Return the first ChildFournisseur matching the query
 * @method     ChildFournisseur findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFournisseur matching the query, or a new ChildFournisseur object populated from the query conditions when no match is found
 *
 * @method     ChildFournisseur findOneByID(int $id) Return the first ChildFournisseur filtered by the id column
 * @method     ChildFournisseur findOneByQuantite(int $quantite) Return the first ChildFournisseur filtered by the quantite column
 * @method     ChildFournisseur findOneByPrixachat(string $prix_achat) Return the first ChildFournisseur filtered by the prix_achat column
 * @method     ChildFournisseur findOneByPrixvente(string $prix_vente) Return the first ChildFournisseur filtered by the prix_vente column
 * @method     ChildFournisseur findOneByDTESave(string $date_enreg) Return the first ChildFournisseur filtered by the date_enreg column
 * @method     ChildFournisseur findOneByisProd(boolean $production) Return the first ChildFournisseur filtered by the production column
 * @method     ChildFournisseur findOneByDelai(string $delai) Return the first ChildFournisseur filtered by the delai column
 * @method     ChildFournisseur findOneByIDPiece_PK(int $id_piece_FK) Return the first ChildFournisseur filtered by the id_piece_FK column
 * @method     ChildFournisseur findOneByVCondition(string $condition_FK) Return the first ChildFournisseur filtered by the condition_FK column
 * @method     ChildFournisseur findOneByTMode(string $transport_FK) Return the first ChildFournisseur filtered by the transport_FK column
 * @method     ChildFournisseur findOneByIDSoc_FK(int $soc_id_FK) Return the first ChildFournisseur filtered by the soc_id_FK column
 * @method     ChildFournisseur findOneByFABAnnee(string $annee_fab) Return the first ChildFournisseur filtered by the annee_fab column
 * @method     ChildFournisseur findOneByTRestant(string $tmp_rest) Return the first ChildFournisseur filtered by the tmp_rest column
 * @method     ChildFournisseur findOneByTTotal(string $tmp_total) Return the first ChildFournisseur filtered by the tmp_total column
 * @method     ChildFournisseur findOneByDVie(string $duree_vie) Return the first ChildFournisseur filtered by the duree_vie column
 * @method     ChildFournisseur findOneByOLDApp(string $old_app) Return the first ChildFournisseur filtered by the old_app column
 * @method     ChildFournisseur findOneByNApp(string $new_app) Return the first ChildFournisseur filtered by the new_app column
 * @method     ChildFournisseur findOneByNBROh(string $nbr_oh) Return the first ChildFournisseur filtered by the nbr_oh column
 * @method     ChildFournisseur findOneByNote(string $note) Return the first ChildFournisseur filtered by the note column *

 * @method     ChildFournisseur requirePk($key, ConnectionInterface $con = null) Return the ChildFournisseur by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOne(ConnectionInterface $con = null) Return the first ChildFournisseur matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFournisseur requireOneByID(int $id) Return the first ChildFournisseur filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByQuantite(int $quantite) Return the first ChildFournisseur filtered by the quantite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByPrixachat(string $prix_achat) Return the first ChildFournisseur filtered by the prix_achat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByPrixvente(string $prix_vente) Return the first ChildFournisseur filtered by the prix_vente column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByDTESave(string $date_enreg) Return the first ChildFournisseur filtered by the date_enreg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByisProd(boolean $production) Return the first ChildFournisseur filtered by the production column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByDelai(string $delai) Return the first ChildFournisseur filtered by the delai column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByIDPiece_PK(int $id_piece_FK) Return the first ChildFournisseur filtered by the id_piece_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByVCondition(string $condition_FK) Return the first ChildFournisseur filtered by the condition_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByTMode(string $transport_FK) Return the first ChildFournisseur filtered by the transport_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByIDSoc_FK(int $soc_id_FK) Return the first ChildFournisseur filtered by the soc_id_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByFABAnnee(string $annee_fab) Return the first ChildFournisseur filtered by the annee_fab column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByTRestant(string $tmp_rest) Return the first ChildFournisseur filtered by the tmp_rest column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByTTotal(string $tmp_total) Return the first ChildFournisseur filtered by the tmp_total column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByDVie(string $duree_vie) Return the first ChildFournisseur filtered by the duree_vie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByOLDApp(string $old_app) Return the first ChildFournisseur filtered by the old_app column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByNApp(string $new_app) Return the first ChildFournisseur filtered by the new_app column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByNBROh(string $nbr_oh) Return the first ChildFournisseur filtered by the nbr_oh column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFournisseur requireOneByNote(string $note) Return the first ChildFournisseur filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFournisseur[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFournisseur objects based on current ModelCriteria
 * @method     ChildFournisseur[]|ObjectCollection findByID(int $id) Return ChildFournisseur objects filtered by the id column
 * @method     ChildFournisseur[]|ObjectCollection findByQuantite(int $quantite) Return ChildFournisseur objects filtered by the quantite column
 * @method     ChildFournisseur[]|ObjectCollection findByPrixachat(string $prix_achat) Return ChildFournisseur objects filtered by the prix_achat column
 * @method     ChildFournisseur[]|ObjectCollection findByPrixvente(string $prix_vente) Return ChildFournisseur objects filtered by the prix_vente column
 * @method     ChildFournisseur[]|ObjectCollection findByDTESave(string $date_enreg) Return ChildFournisseur objects filtered by the date_enreg column
 * @method     ChildFournisseur[]|ObjectCollection findByisProd(boolean $production) Return ChildFournisseur objects filtered by the production column
 * @method     ChildFournisseur[]|ObjectCollection findByDelai(string $delai) Return ChildFournisseur objects filtered by the delai column
 * @method     ChildFournisseur[]|ObjectCollection findByIDPiece_PK(int $id_piece_FK) Return ChildFournisseur objects filtered by the id_piece_FK column
 * @method     ChildFournisseur[]|ObjectCollection findByVCondition(string $condition_FK) Return ChildFournisseur objects filtered by the condition_FK column
 * @method     ChildFournisseur[]|ObjectCollection findByTMode(string $transport_FK) Return ChildFournisseur objects filtered by the transport_FK column
 * @method     ChildFournisseur[]|ObjectCollection findByIDSoc_FK(int $soc_id_FK) Return ChildFournisseur objects filtered by the soc_id_FK column
 * @method     ChildFournisseur[]|ObjectCollection findByFABAnnee(string $annee_fab) Return ChildFournisseur objects filtered by the annee_fab column
 * @method     ChildFournisseur[]|ObjectCollection findByTRestant(string $tmp_rest) Return ChildFournisseur objects filtered by the tmp_rest column
 * @method     ChildFournisseur[]|ObjectCollection findByTTotal(string $tmp_total) Return ChildFournisseur objects filtered by the tmp_total column
 * @method     ChildFournisseur[]|ObjectCollection findByDVie(string $duree_vie) Return ChildFournisseur objects filtered by the duree_vie column
 * @method     ChildFournisseur[]|ObjectCollection findByOLDApp(string $old_app) Return ChildFournisseur objects filtered by the old_app column
 * @method     ChildFournisseur[]|ObjectCollection findByNApp(string $new_app) Return ChildFournisseur objects filtered by the new_app column
 * @method     ChildFournisseur[]|ObjectCollection findByNBROh(string $nbr_oh) Return ChildFournisseur objects filtered by the nbr_oh column
 * @method     ChildFournisseur[]|ObjectCollection findByNote(string $note) Return ChildFournisseur objects filtered by the note column
 * @method     ChildFournisseur[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FournisseurQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FournisseurQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Fournisseur', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFournisseurQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFournisseurQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFournisseurQuery) {
            return $criteria;
        }
        $query = new ChildFournisseurQuery();
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
     * @return ChildFournisseur|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FournisseurTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FournisseurTableMap::DATABASE_NAME);
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
     * @return ChildFournisseur A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, quantite, prix_achat, prix_vente, date_enreg, production, delai, id_piece_FK, condition_FK, transport_FK, soc_id_FK, annee_fab, tmp_rest, tmp_total, duree_vie, old_app, new_app, nbr_oh, note FROM fournisseur WHERE id = :p0';
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
            /** @var ChildFournisseur $obj */
            $obj = new ChildFournisseur();
            $obj->hydrate($row);
            FournisseurTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildFournisseur|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FournisseurTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FournisseurTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_ID, $iD, $comparison);
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
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByQuantite($quantite = null, $comparison = null)
    {
        if (is_array($quantite)) {
            $useMinMax = false;
            if (isset($quantite['min'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_QUANTITE, $quantite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantite['max'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_QUANTITE, $quantite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_QUANTITE, $quantite, $comparison);
    }

    /**
     * Filter the query on the prix_achat column
     *
     * Example usage:
     * <code>
     * $query->filterByPrixachat('fooValue');   // WHERE prix_achat = 'fooValue'
     * $query->filterByPrixachat('%fooValue%'); // WHERE prix_achat LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prixachat The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByPrixachat($prixachat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prixachat)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prixachat)) {
                $prixachat = str_replace('*', '%', $prixachat);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_PRIX_ACHAT, $prixachat, $comparison);
    }

    /**
     * Filter the query on the prix_vente column
     *
     * Example usage:
     * <code>
     * $query->filterByPrixvente('fooValue');   // WHERE prix_vente = 'fooValue'
     * $query->filterByPrixvente('%fooValue%'); // WHERE prix_vente LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prixvente The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByPrixvente($prixvente = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prixvente)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prixvente)) {
                $prixvente = str_replace('*', '%', $prixvente);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_PRIX_VENTE, $prixvente, $comparison);
    }

    /**
     * Filter the query on the date_enreg column
     *
     * Example usage:
     * <code>
     * $query->filterByDTESave('2011-03-14'); // WHERE date_enreg = '2011-03-14'
     * $query->filterByDTESave('now'); // WHERE date_enreg = '2011-03-14'
     * $query->filterByDTESave(array('max' => 'yesterday')); // WHERE date_enreg > '2011-03-13'
     * </code>
     *
     * @param     mixed $dTESave The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByDTESave($dTESave = null, $comparison = null)
    {
        if (is_array($dTESave)) {
            $useMinMax = false;
            if (isset($dTESave['min'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_DATE_ENREG, $dTESave['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dTESave['max'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_DATE_ENREG, $dTESave['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_DATE_ENREG, $dTESave, $comparison);
    }

    /**
     * Filter the query on the production column
     *
     * Example usage:
     * <code>
     * $query->filterByisProd(true); // WHERE production = true
     * $query->filterByisProd('yes'); // WHERE production = true
     * </code>
     *
     * @param     boolean|string $isProd The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByisProd($isProd = null, $comparison = null)
    {
        if (is_string($isProd)) {
            $isProd = in_array(strtolower($isProd), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_PRODUCTION, $isProd, $comparison);
    }

    /**
     * Filter the query on the delai column
     *
     * Example usage:
     * <code>
     * $query->filterByDelai('fooValue');   // WHERE delai = 'fooValue'
     * $query->filterByDelai('%fooValue%'); // WHERE delai LIKE '%fooValue%'
     * </code>
     *
     * @param     string $delai The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByDelai($delai = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($delai)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $delai)) {
                $delai = str_replace('*', '%', $delai);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_DELAI, $delai, $comparison);
    }

    /**
     * Filter the query on the id_piece_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIDPiece_PK(1234); // WHERE id_piece_FK = 1234
     * $query->filterByIDPiece_PK(array(12, 34)); // WHERE id_piece_FK IN (12, 34)
     * $query->filterByIDPiece_PK(array('min' => 12)); // WHERE id_piece_FK > 12
     * </code>
     *
     * @see       filterByPiece()
     *
     * @param     mixed $iDPiece_PK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByIDPiece_PK($iDPiece_PK = null, $comparison = null)
    {
        if (is_array($iDPiece_PK)) {
            $useMinMax = false;
            if (isset($iDPiece_PK['min'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_ID_PIECE_FK, $iDPiece_PK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDPiece_PK['max'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_ID_PIECE_FK, $iDPiece_PK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_ID_PIECE_FK, $iDPiece_PK, $comparison);
    }

    /**
     * Filter the query on the condition_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByVCondition('fooValue');   // WHERE condition_FK = 'fooValue'
     * $query->filterByVCondition('%fooValue%'); // WHERE condition_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $vCondition The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByVCondition($vCondition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vCondition)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $vCondition)) {
                $vCondition = str_replace('*', '%', $vCondition);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_CONDITION_FK, $vCondition, $comparison);
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
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FournisseurTableMap::COL_TRANSPORT_FK, $tMode, $comparison);
    }

    /**
     * Filter the query on the soc_id_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIDSoc_FK(1234); // WHERE soc_id_FK = 1234
     * $query->filterByIDSoc_FK(array(12, 34)); // WHERE soc_id_FK IN (12, 34)
     * $query->filterByIDSoc_FK(array('min' => 12)); // WHERE soc_id_FK > 12
     * </code>
     *
     * @see       filterBySociete()
     *
     * @param     mixed $iDSoc_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByIDSoc_FK($iDSoc_FK = null, $comparison = null)
    {
        if (is_array($iDSoc_FK)) {
            $useMinMax = false;
            if (isset($iDSoc_FK['min'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_SOC_ID_FK, $iDSoc_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDSoc_FK['max'])) {
                $this->addUsingAlias(FournisseurTableMap::COL_SOC_ID_FK, $iDSoc_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_SOC_ID_FK, $iDSoc_FK, $comparison);
    }

    /**
     * Filter the query on the annee_fab column
     *
     * Example usage:
     * <code>
     * $query->filterByFABAnnee('fooValue');   // WHERE annee_fab = 'fooValue'
     * $query->filterByFABAnnee('%fooValue%'); // WHERE annee_fab LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fABAnnee The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByFABAnnee($fABAnnee = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fABAnnee)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fABAnnee)) {
                $fABAnnee = str_replace('*', '%', $fABAnnee);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_ANNEE_FAB, $fABAnnee, $comparison);
    }

    /**
     * Filter the query on the tmp_rest column
     *
     * Example usage:
     * <code>
     * $query->filterByTRestant('fooValue');   // WHERE tmp_rest = 'fooValue'
     * $query->filterByTRestant('%fooValue%'); // WHERE tmp_rest LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tRestant The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByTRestant($tRestant = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tRestant)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tRestant)) {
                $tRestant = str_replace('*', '%', $tRestant);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_TMP_REST, $tRestant, $comparison);
    }

    /**
     * Filter the query on the tmp_total column
     *
     * Example usage:
     * <code>
     * $query->filterByTTotal('fooValue');   // WHERE tmp_total = 'fooValue'
     * $query->filterByTTotal('%fooValue%'); // WHERE tmp_total LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tTotal The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByTTotal($tTotal = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tTotal)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tTotal)) {
                $tTotal = str_replace('*', '%', $tTotal);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_TMP_TOTAL, $tTotal, $comparison);
    }

    /**
     * Filter the query on the duree_vie column
     *
     * Example usage:
     * <code>
     * $query->filterByDVie('fooValue');   // WHERE duree_vie = 'fooValue'
     * $query->filterByDVie('%fooValue%'); // WHERE duree_vie LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dVie The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByDVie($dVie = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dVie)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dVie)) {
                $dVie = str_replace('*', '%', $dVie);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_DUREE_VIE, $dVie, $comparison);
    }

    /**
     * Filter the query on the old_app column
     *
     * Example usage:
     * <code>
     * $query->filterByOLDApp('fooValue');   // WHERE old_app = 'fooValue'
     * $query->filterByOLDApp('%fooValue%'); // WHERE old_app LIKE '%fooValue%'
     * </code>
     *
     * @param     string $oLDApp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByOLDApp($oLDApp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($oLDApp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $oLDApp)) {
                $oLDApp = str_replace('*', '%', $oLDApp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_OLD_APP, $oLDApp, $comparison);
    }

    /**
     * Filter the query on the new_app column
     *
     * Example usage:
     * <code>
     * $query->filterByNApp('fooValue');   // WHERE new_app = 'fooValue'
     * $query->filterByNApp('%fooValue%'); // WHERE new_app LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nApp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByNApp($nApp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nApp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nApp)) {
                $nApp = str_replace('*', '%', $nApp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_NEW_APP, $nApp, $comparison);
    }

    /**
     * Filter the query on the nbr_oh column
     *
     * Example usage:
     * <code>
     * $query->filterByNBROh('fooValue');   // WHERE nbr_oh = 'fooValue'
     * $query->filterByNBROh('%fooValue%'); // WHERE nbr_oh LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nBROh The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByNBROh($nBROh = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nBROh)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nBROh)) {
                $nBROh = str_replace('*', '%', $nBROh);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_NBR_OH, $nBROh, $comparison);
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByNote('%fooValue%'); // WHERE note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $note The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByNote($note = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($note)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $note)) {
                $note = str_replace('*', '%', $note);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FournisseurTableMap::COL_NOTE, $note, $comparison);
    }

    /**
     * Filter the query by a related \Piece object
     *
     * @param \Piece|ObjectCollection $piece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByPiece($piece, $comparison = null)
    {
        if ($piece instanceof \Piece) {
            return $this
                ->addUsingAlias(FournisseurTableMap::COL_ID_PIECE_FK, $piece->getID(), $comparison);
        } elseif ($piece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FournisseurTableMap::COL_ID_PIECE_FK, $piece->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function joinPiece($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function usePieceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Piece', '\PieceQuery');
    }

    /**
     * Filter the query by a related \Societe object
     *
     * @param \Societe|ObjectCollection $societe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterBySociete($societe, $comparison = null)
    {
        if ($societe instanceof \Societe) {
            return $this
                ->addUsingAlias(FournisseurTableMap::COL_SOC_ID_FK, $societe->getID(), $comparison);
        } elseif ($societe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FournisseurTableMap::COL_SOC_ID_FK, $societe->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
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
     * Filter the query by a related \Condition object
     *
     * @param \Condition|ObjectCollection $condition The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByCondition($condition, $comparison = null)
    {
        if ($condition instanceof \Condition) {
            return $this
                ->addUsingAlias(FournisseurTableMap::COL_CONDITION_FK, $condition->getCondition(), $comparison);
        } elseif ($condition instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FournisseurTableMap::COL_CONDITION_FK, $condition->toKeyValue('PrimaryKey', 'Condition'), $comparison);
        } else {
            throw new PropelException('filterByCondition() only accepts arguments of type \Condition or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Condition relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function joinCondition($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Condition');

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
            $this->addJoinObject($join, 'Condition');
        }

        return $this;
    }

    /**
     * Use the Condition relation Condition object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ConditionQuery A secondary query class using the current class as primary query
     */
    public function useConditionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCondition($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Condition', '\ConditionQuery');
    }

    /**
     * Filter the query by a related \MTransport object
     *
     * @param \MTransport|ObjectCollection $mTransport The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByMTransport($mTransport, $comparison = null)
    {
        if ($mTransport instanceof \MTransport) {
            return $this
                ->addUsingAlias(FournisseurTableMap::COL_TRANSPORT_FK, $mTransport->getMTransport(), $comparison);
        } elseif ($mTransport instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FournisseurTableMap::COL_TRANSPORT_FK, $mTransport->toKeyValue('PrimaryKey', 'MTransport'), $comparison);
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
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
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
     * Filter the query by a related \COMVendeur object
     *
     * @param \COMVendeur|ObjectCollection $cOMVendeur the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByCOMVendeur($cOMVendeur, $comparison = null)
    {
        if ($cOMVendeur instanceof \COMVendeur) {
            return $this
                ->addUsingAlias(FournisseurTableMap::COL_ID, $cOMVendeur->getIDFournisseur(), $comparison);
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
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
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
     * Filter the query by a related \Document object
     *
     * @param \Document|ObjectCollection $document the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByDoc($document, $comparison = null)
    {
        if ($document instanceof \Document) {
            return $this
                ->addUsingAlias(FournisseurTableMap::COL_ID, $document->getIDFRS_FK(), $comparison);
        } elseif ($document instanceof ObjectCollection) {
            return $this
                ->useDocQuery()
                ->filterByPrimaryKeys($document->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDoc() only accepts arguments of type \Document or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Doc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function joinDoc($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Doc');

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
            $this->addJoinObject($join, 'Doc');
        }

        return $this;
    }

    /**
     * Use the Doc relation Document object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DocumentQuery A secondary query class using the current class as primary query
     */
    public function useDocQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDoc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Doc', '\DocumentQuery');
    }

    /**
     * Filter the query by a related \Photopiece object
     *
     * @param \Photopiece|ObjectCollection $photopiece the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFournisseurQuery The current query, for fluid interface
     */
    public function filterByPhotopiece($photopiece, $comparison = null)
    {
        if ($photopiece instanceof \Photopiece) {
            return $this
                ->addUsingAlias(FournisseurTableMap::COL_ID, $photopiece->getIDFRS_FK(), $comparison);
        } elseif ($photopiece instanceof ObjectCollection) {
            return $this
                ->usePhotopieceQuery()
                ->filterByPrimaryKeys($photopiece->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPhotopiece() only accepts arguments of type \Photopiece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Photopiece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function joinPhotopiece($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Photopiece');

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
            $this->addJoinObject($join, 'Photopiece');
        }

        return $this;
    }

    /**
     * Use the Photopiece relation Photopiece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PhotopieceQuery A secondary query class using the current class as primary query
     */
    public function usePhotopieceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPhotopiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Photopiece', '\PhotopieceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFournisseur $fournisseur Object to remove from the list of results
     *
     * @return $this|ChildFournisseurQuery The current query, for fluid interface
     */
    public function prune($fournisseur = null)
    {
        if ($fournisseur) {
            $this->addUsingAlias(FournisseurTableMap::COL_ID, $fournisseur->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fournisseur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FournisseurTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FournisseurTableMap::clearInstancePool();
            FournisseurTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FournisseurTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FournisseurTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FournisseurTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FournisseurTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FournisseurQuery
