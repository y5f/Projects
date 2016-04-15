<?php

namespace Base;

use \COMVendeur as ChildCOMVendeur;
use \COMVendeurQuery as ChildCOMVendeurQuery;
use \Exception;
use \PDO;
use Map\COMVendeurTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'vendeur' table.
 *
 *
 *
 * @method     ChildCOMVendeurQuery orderByIDVendeur($order = Criteria::ASC) Order by the id_vte column
 * @method     ChildCOMVendeurQuery orderByIDCommande_FK($order = Criteria::ASC) Order by the id_commande_FK column
 * @method     ChildCOMVendeurQuery orderByIDPiece_FK($order = Criteria::ASC) Order by the id_piece_FK column
 * @method     ChildCOMVendeurQuery orderByIDFournisseur($order = Criteria::ASC) Order by the frs_id column
 * @method     ChildCOMVendeurQuery orderByPMinimum($order = Criteria::ASC) Order by the mo column
 * @method     ChildCOMVendeurQuery orderByVNDNote($order = Criteria::ASC) Order by the note column
 * @method     ChildCOMVendeurQuery orderByDTEProposition($order = Criteria::ASC) Order by the dte_propos column
 *
 * @method     ChildCOMVendeurQuery groupByIDVendeur() Group by the id_vte column
 * @method     ChildCOMVendeurQuery groupByIDCommande_FK() Group by the id_commande_FK column
 * @method     ChildCOMVendeurQuery groupByIDPiece_FK() Group by the id_piece_FK column
 * @method     ChildCOMVendeurQuery groupByIDFournisseur() Group by the frs_id column
 * @method     ChildCOMVendeurQuery groupByPMinimum() Group by the mo column
 * @method     ChildCOMVendeurQuery groupByVNDNote() Group by the note column
 * @method     ChildCOMVendeurQuery groupByDTEProposition() Group by the dte_propos column
 *
 * @method     ChildCOMVendeurQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCOMVendeurQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCOMVendeurQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCOMVendeurQuery leftJoinCommande($relationAlias = null) Adds a LEFT JOIN clause to the query using the Commande relation
 * @method     ChildCOMVendeurQuery rightJoinCommande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Commande relation
 * @method     ChildCOMVendeurQuery innerJoinCommande($relationAlias = null) Adds a INNER JOIN clause to the query using the Commande relation
 *
 * @method     ChildCOMVendeurQuery leftJoinFournisseur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fournisseur relation
 * @method     ChildCOMVendeurQuery rightJoinFournisseur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fournisseur relation
 * @method     ChildCOMVendeurQuery innerJoinFournisseur($relationAlias = null) Adds a INNER JOIN clause to the query using the Fournisseur relation
 *
 * @method     ChildCOMVendeurQuery leftJoinPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Piece relation
 * @method     ChildCOMVendeurQuery rightJoinPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Piece relation
 * @method     ChildCOMVendeurQuery innerJoinPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Piece relation
 *
 * @method     \CommandeQuery|\FournisseurQuery|\PieceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCOMVendeur findOne(ConnectionInterface $con = null) Return the first ChildCOMVendeur matching the query
 * @method     ChildCOMVendeur findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCOMVendeur matching the query, or a new ChildCOMVendeur object populated from the query conditions when no match is found
 *
 * @method     ChildCOMVendeur findOneByIDVendeur(int $id_vte) Return the first ChildCOMVendeur filtered by the id_vte column
 * @method     ChildCOMVendeur findOneByIDCommande_FK(int $id_commande_FK) Return the first ChildCOMVendeur filtered by the id_commande_FK column
 * @method     ChildCOMVendeur findOneByIDPiece_FK(int $id_piece_FK) Return the first ChildCOMVendeur filtered by the id_piece_FK column
 * @method     ChildCOMVendeur findOneByIDFournisseur(int $frs_id) Return the first ChildCOMVendeur filtered by the frs_id column
 * @method     ChildCOMVendeur findOneByPMinimum(string $mo) Return the first ChildCOMVendeur filtered by the mo column
 * @method     ChildCOMVendeur findOneByVNDNote(string $note) Return the first ChildCOMVendeur filtered by the note column
 * @method     ChildCOMVendeur findOneByDTEProposition(string $dte_propos) Return the first ChildCOMVendeur filtered by the dte_propos column *

 * @method     ChildCOMVendeur requirePk($key, ConnectionInterface $con = null) Return the ChildCOMVendeur by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCOMVendeur requireOne(ConnectionInterface $con = null) Return the first ChildCOMVendeur matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCOMVendeur requireOneByIDVendeur(int $id_vte) Return the first ChildCOMVendeur filtered by the id_vte column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCOMVendeur requireOneByIDCommande_FK(int $id_commande_FK) Return the first ChildCOMVendeur filtered by the id_commande_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCOMVendeur requireOneByIDPiece_FK(int $id_piece_FK) Return the first ChildCOMVendeur filtered by the id_piece_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCOMVendeur requireOneByIDFournisseur(int $frs_id) Return the first ChildCOMVendeur filtered by the frs_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCOMVendeur requireOneByPMinimum(string $mo) Return the first ChildCOMVendeur filtered by the mo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCOMVendeur requireOneByVNDNote(string $note) Return the first ChildCOMVendeur filtered by the note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCOMVendeur requireOneByDTEProposition(string $dte_propos) Return the first ChildCOMVendeur filtered by the dte_propos column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCOMVendeur[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCOMVendeur objects based on current ModelCriteria
 * @method     ChildCOMVendeur[]|ObjectCollection findByIDVendeur(int $id_vte) Return ChildCOMVendeur objects filtered by the id_vte column
 * @method     ChildCOMVendeur[]|ObjectCollection findByIDCommande_FK(int $id_commande_FK) Return ChildCOMVendeur objects filtered by the id_commande_FK column
 * @method     ChildCOMVendeur[]|ObjectCollection findByIDPiece_FK(int $id_piece_FK) Return ChildCOMVendeur objects filtered by the id_piece_FK column
 * @method     ChildCOMVendeur[]|ObjectCollection findByIDFournisseur(int $frs_id) Return ChildCOMVendeur objects filtered by the frs_id column
 * @method     ChildCOMVendeur[]|ObjectCollection findByPMinimum(string $mo) Return ChildCOMVendeur objects filtered by the mo column
 * @method     ChildCOMVendeur[]|ObjectCollection findByVNDNote(string $note) Return ChildCOMVendeur objects filtered by the note column
 * @method     ChildCOMVendeur[]|ObjectCollection findByDTEProposition(string $dte_propos) Return ChildCOMVendeur objects filtered by the dte_propos column
 * @method     ChildCOMVendeur[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class COMVendeurQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\COMVendeurQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\COMVendeur', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCOMVendeurQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCOMVendeurQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCOMVendeurQuery) {
            return $criteria;
        }
        $query = new ChildCOMVendeurQuery();
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
     * @return ChildCOMVendeur|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = COMVendeurTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(COMVendeurTableMap::DATABASE_NAME);
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
     * @return ChildCOMVendeur A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_vte, id_commande_FK, id_piece_FK, frs_id, mo, note, dte_propos FROM vendeur WHERE id_vte = :p0';
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
            /** @var ChildCOMVendeur $obj */
            $obj = new ChildCOMVendeur();
            $obj->hydrate($row);
            COMVendeurTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCOMVendeur|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(COMVendeurTableMap::COL_ID_VTE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(COMVendeurTableMap::COL_ID_VTE, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_vte column
     *
     * Example usage:
     * <code>
     * $query->filterByIDVendeur(1234); // WHERE id_vte = 1234
     * $query->filterByIDVendeur(array(12, 34)); // WHERE id_vte IN (12, 34)
     * $query->filterByIDVendeur(array('min' => 12)); // WHERE id_vte > 12
     * </code>
     *
     * @param     mixed $iDVendeur The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByIDVendeur($iDVendeur = null, $comparison = null)
    {
        if (is_array($iDVendeur)) {
            $useMinMax = false;
            if (isset($iDVendeur['min'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_ID_VTE, $iDVendeur['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDVendeur['max'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_ID_VTE, $iDVendeur['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(COMVendeurTableMap::COL_ID_VTE, $iDVendeur, $comparison);
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
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByIDCommande_FK($iDCommande_FK = null, $comparison = null)
    {
        if (is_array($iDCommande_FK)) {
            $useMinMax = false;
            if (isset($iDCommande_FK['min'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDCommande_FK['max'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(COMVendeurTableMap::COL_ID_COMMANDE_FK, $iDCommande_FK, $comparison);
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
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByIDPiece_FK($iDPiece_FK = null, $comparison = null)
    {
        if (is_array($iDPiece_FK)) {
            $useMinMax = false;
            if (isset($iDPiece_FK['min'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_ID_PIECE_FK, $iDPiece_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDPiece_FK['max'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_ID_PIECE_FK, $iDPiece_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(COMVendeurTableMap::COL_ID_PIECE_FK, $iDPiece_FK, $comparison);
    }

    /**
     * Filter the query on the frs_id column
     *
     * Example usage:
     * <code>
     * $query->filterByIDFournisseur(1234); // WHERE frs_id = 1234
     * $query->filterByIDFournisseur(array(12, 34)); // WHERE frs_id IN (12, 34)
     * $query->filterByIDFournisseur(array('min' => 12)); // WHERE frs_id > 12
     * </code>
     *
     * @see       filterByFournisseur()
     *
     * @param     mixed $iDFournisseur The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByIDFournisseur($iDFournisseur = null, $comparison = null)
    {
        if (is_array($iDFournisseur)) {
            $useMinMax = false;
            if (isset($iDFournisseur['min'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_FRS_ID, $iDFournisseur['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDFournisseur['max'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_FRS_ID, $iDFournisseur['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(COMVendeurTableMap::COL_FRS_ID, $iDFournisseur, $comparison);
    }

    /**
     * Filter the query on the mo column
     *
     * Example usage:
     * <code>
     * $query->filterByPMinimum('fooValue');   // WHERE mo = 'fooValue'
     * $query->filterByPMinimum('%fooValue%'); // WHERE mo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pMinimum The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByPMinimum($pMinimum = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pMinimum)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pMinimum)) {
                $pMinimum = str_replace('*', '%', $pMinimum);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(COMVendeurTableMap::COL_MO, $pMinimum, $comparison);
    }

    /**
     * Filter the query on the note column
     *
     * Example usage:
     * <code>
     * $query->filterByVNDNote('fooValue');   // WHERE note = 'fooValue'
     * $query->filterByVNDNote('%fooValue%'); // WHERE note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $vNDNote The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByVNDNote($vNDNote = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vNDNote)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $vNDNote)) {
                $vNDNote = str_replace('*', '%', $vNDNote);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(COMVendeurTableMap::COL_NOTE, $vNDNote, $comparison);
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
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByDTEProposition($dTEProposition = null, $comparison = null)
    {
        if (is_array($dTEProposition)) {
            $useMinMax = false;
            if (isset($dTEProposition['min'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_DTE_PROPOS, $dTEProposition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dTEProposition['max'])) {
                $this->addUsingAlias(COMVendeurTableMap::COL_DTE_PROPOS, $dTEProposition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(COMVendeurTableMap::COL_DTE_PROPOS, $dTEProposition, $comparison);
    }

    /**
     * Filter the query by a related \Commande object
     *
     * @param \Commande|ObjectCollection $commande The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByCommande($commande, $comparison = null)
    {
        if ($commande instanceof \Commande) {
            return $this
                ->addUsingAlias(COMVendeurTableMap::COL_ID_COMMANDE_FK, $commande->getIDCommande(), $comparison);
        } elseif ($commande instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(COMVendeurTableMap::COL_ID_COMMANDE_FK, $commande->toKeyValue('PrimaryKey', 'IDCommande'), $comparison);
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
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function joinCommande($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useCommandeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCommande($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Commande', '\CommandeQuery');
    }

    /**
     * Filter the query by a related \Fournisseur object
     *
     * @param \Fournisseur|ObjectCollection $fournisseur The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByFournisseur($fournisseur, $comparison = null)
    {
        if ($fournisseur instanceof \Fournisseur) {
            return $this
                ->addUsingAlias(COMVendeurTableMap::COL_FRS_ID, $fournisseur->getID(), $comparison);
        } elseif ($fournisseur instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(COMVendeurTableMap::COL_FRS_ID, $fournisseur->toKeyValue('PrimaryKey', 'ID'), $comparison);
        } else {
            throw new PropelException('filterByFournisseur() only accepts arguments of type \Fournisseur or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Fournisseur relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function joinFournisseur($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Fournisseur');

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
            $this->addJoinObject($join, 'Fournisseur');
        }

        return $this;
    }

    /**
     * Use the Fournisseur relation Fournisseur object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FournisseurQuery A secondary query class using the current class as primary query
     */
    public function useFournisseurQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFournisseur($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Fournisseur', '\FournisseurQuery');
    }

    /**
     * Filter the query by a related \Piece object
     *
     * @param \Piece|ObjectCollection $piece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function filterByPiece($piece, $comparison = null)
    {
        if ($piece instanceof \Piece) {
            return $this
                ->addUsingAlias(COMVendeurTableMap::COL_ID_PIECE_FK, $piece->getID(), $comparison);
        } elseif ($piece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(COMVendeurTableMap::COL_ID_PIECE_FK, $piece->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildCOMVendeur $cOMVendeur Object to remove from the list of results
     *
     * @return $this|ChildCOMVendeurQuery The current query, for fluid interface
     */
    public function prune($cOMVendeur = null)
    {
        if ($cOMVendeur) {
            $this->addUsingAlias(COMVendeurTableMap::COL_ID_VTE, $cOMVendeur->getIDVendeur(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the vendeur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(COMVendeurTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            COMVendeurTableMap::clearInstancePool();
            COMVendeurTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(COMVendeurTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(COMVendeurTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            COMVendeurTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            COMVendeurTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // COMVendeurQuery
