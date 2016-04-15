<?php

namespace Base;

use \Partenairepiece as ChildPartenairepiece;
use \PartenairepieceQuery as ChildPartenairepieceQuery;
use \Exception;
use \PDO;
use Map\PartenairepieceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'partenaire_piece' table.
 *
 *
 *
 * @method     ChildPartenairepieceQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildPartenairepieceQuery orderByQuantite($order = Criteria::ASC) Order by the quantite column
 * @method     ChildPartenairepieceQuery orderByPrixachat($order = Criteria::ASC) Order by the prix_achat column
 * @method     ChildPartenairepieceQuery orderByPrixvente($order = Criteria::ASC) Order by the prix_vente column
 * @method     ChildPartenairepieceQuery orderByDateenregistrement($order = Criteria::ASC) Order by the date_enreg column
 * @method     ChildPartenairepieceQuery orderByReference_PK($order = Criteria::ASC) Order by the reference_PK column
 * @method     ChildPartenairepieceQuery orderByPartenaire_PK($order = Criteria::ASC) Order by the part_id_PK column
 *
 * @method     ChildPartenairepieceQuery groupByID() Group by the id column
 * @method     ChildPartenairepieceQuery groupByQuantite() Group by the quantite column
 * @method     ChildPartenairepieceQuery groupByPrixachat() Group by the prix_achat column
 * @method     ChildPartenairepieceQuery groupByPrixvente() Group by the prix_vente column
 * @method     ChildPartenairepieceQuery groupByDateenregistrement() Group by the date_enreg column
 * @method     ChildPartenairepieceQuery groupByReference_PK() Group by the reference_PK column
 * @method     ChildPartenairepieceQuery groupByPartenaire_PK() Group by the part_id_PK column
 *
 * @method     ChildPartenairepieceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPartenairepieceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPartenairepieceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPartenairepieceQuery leftJoinPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Piece relation
 * @method     ChildPartenairepieceQuery rightJoinPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Piece relation
 * @method     ChildPartenairepieceQuery innerJoinPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Piece relation
 *
 * @method     ChildPartenairepieceQuery leftJoinPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenaire relation
 * @method     ChildPartenairepieceQuery rightJoinPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenaire relation
 * @method     ChildPartenairepieceQuery innerJoinPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenaire relation
 *
 * @method     ChildPartenairepieceQuery leftJoinDoc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Doc relation
 * @method     ChildPartenairepieceQuery rightJoinDoc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Doc relation
 * @method     ChildPartenairepieceQuery innerJoinDoc($relationAlias = null) Adds a INNER JOIN clause to the query using the Doc relation
 *
 * @method     \PieceQuery|\PartenaireQuery|\DocumentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPartenairepiece findOne(ConnectionInterface $con = null) Return the first ChildPartenairepiece matching the query
 * @method     ChildPartenairepiece findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPartenairepiece matching the query, or a new ChildPartenairepiece object populated from the query conditions when no match is found
 *
 * @method     ChildPartenairepiece findOneByID(int $id) Return the first ChildPartenairepiece filtered by the id column
 * @method     ChildPartenairepiece findOneByQuantite(int $quantite) Return the first ChildPartenairepiece filtered by the quantite column
 * @method     ChildPartenairepiece findOneByPrixachat(double $prix_achat) Return the first ChildPartenairepiece filtered by the prix_achat column
 * @method     ChildPartenairepiece findOneByPrixvente(double $prix_vente) Return the first ChildPartenairepiece filtered by the prix_vente column
 * @method     ChildPartenairepiece findOneByDateenregistrement(string $date_enreg) Return the first ChildPartenairepiece filtered by the date_enreg column
 * @method     ChildPartenairepiece findOneByReference_PK(string $reference_PK) Return the first ChildPartenairepiece filtered by the reference_PK column
 * @method     ChildPartenairepiece findOneByPartenaire_PK(int $part_id_PK) Return the first ChildPartenairepiece filtered by the part_id_PK column *

 * @method     ChildPartenairepiece requirePk($key, ConnectionInterface $con = null) Return the ChildPartenairepiece by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenairepiece requireOne(ConnectionInterface $con = null) Return the first ChildPartenairepiece matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPartenairepiece requireOneByID(int $id) Return the first ChildPartenairepiece filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenairepiece requireOneByQuantite(int $quantite) Return the first ChildPartenairepiece filtered by the quantite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenairepiece requireOneByPrixachat(double $prix_achat) Return the first ChildPartenairepiece filtered by the prix_achat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenairepiece requireOneByPrixvente(double $prix_vente) Return the first ChildPartenairepiece filtered by the prix_vente column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenairepiece requireOneByDateenregistrement(string $date_enreg) Return the first ChildPartenairepiece filtered by the date_enreg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenairepiece requireOneByReference_PK(string $reference_PK) Return the first ChildPartenairepiece filtered by the reference_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenairepiece requireOneByPartenaire_PK(int $part_id_PK) Return the first ChildPartenairepiece filtered by the part_id_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPartenairepiece[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPartenairepiece objects based on current ModelCriteria
 * @method     ChildPartenairepiece[]|ObjectCollection findByID(int $id) Return ChildPartenairepiece objects filtered by the id column
 * @method     ChildPartenairepiece[]|ObjectCollection findByQuantite(int $quantite) Return ChildPartenairepiece objects filtered by the quantite column
 * @method     ChildPartenairepiece[]|ObjectCollection findByPrixachat(double $prix_achat) Return ChildPartenairepiece objects filtered by the prix_achat column
 * @method     ChildPartenairepiece[]|ObjectCollection findByPrixvente(double $prix_vente) Return ChildPartenairepiece objects filtered by the prix_vente column
 * @method     ChildPartenairepiece[]|ObjectCollection findByDateenregistrement(string $date_enreg) Return ChildPartenairepiece objects filtered by the date_enreg column
 * @method     ChildPartenairepiece[]|ObjectCollection findByReference_PK(string $reference_PK) Return ChildPartenairepiece objects filtered by the reference_PK column
 * @method     ChildPartenairepiece[]|ObjectCollection findByPartenaire_PK(int $part_id_PK) Return ChildPartenairepiece objects filtered by the part_id_PK column
 * @method     ChildPartenairepiece[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PartenairepieceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PartenairepieceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Partenairepiece', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPartenairepieceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPartenairepieceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPartenairepieceQuery) {
            return $criteria;
        }
        $query = new ChildPartenairepieceQuery();
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
     * @return ChildPartenairepiece|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PartenairepieceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PartenairepieceTableMap::DATABASE_NAME);
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
     * @return ChildPartenairepiece A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, quantite, prix_achat, prix_vente, date_enreg, reference_PK, part_id_PK FROM partenaire_piece WHERE id = :p0';
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
            /** @var ChildPartenairepiece $obj */
            $obj = new ChildPartenairepiece();
            $obj->hydrate($row);
            PartenairepieceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPartenairepiece|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PartenairepieceTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PartenairepieceTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartenairepieceTableMap::COL_ID, $iD, $comparison);
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
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByQuantite($quantite = null, $comparison = null)
    {
        if (is_array($quantite)) {
            $useMinMax = false;
            if (isset($quantite['min'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_QUANTITE, $quantite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantite['max'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_QUANTITE, $quantite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartenairepieceTableMap::COL_QUANTITE, $quantite, $comparison);
    }

    /**
     * Filter the query on the prix_achat column
     *
     * Example usage:
     * <code>
     * $query->filterByPrixachat(1234); // WHERE prix_achat = 1234
     * $query->filterByPrixachat(array(12, 34)); // WHERE prix_achat IN (12, 34)
     * $query->filterByPrixachat(array('min' => 12)); // WHERE prix_achat > 12
     * </code>
     *
     * @param     mixed $prixachat The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByPrixachat($prixachat = null, $comparison = null)
    {
        if (is_array($prixachat)) {
            $useMinMax = false;
            if (isset($prixachat['min'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_PRIX_ACHAT, $prixachat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prixachat['max'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_PRIX_ACHAT, $prixachat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartenairepieceTableMap::COL_PRIX_ACHAT, $prixachat, $comparison);
    }

    /**
     * Filter the query on the prix_vente column
     *
     * Example usage:
     * <code>
     * $query->filterByPrixvente(1234); // WHERE prix_vente = 1234
     * $query->filterByPrixvente(array(12, 34)); // WHERE prix_vente IN (12, 34)
     * $query->filterByPrixvente(array('min' => 12)); // WHERE prix_vente > 12
     * </code>
     *
     * @param     mixed $prixvente The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByPrixvente($prixvente = null, $comparison = null)
    {
        if (is_array($prixvente)) {
            $useMinMax = false;
            if (isset($prixvente['min'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_PRIX_VENTE, $prixvente['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prixvente['max'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_PRIX_VENTE, $prixvente['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartenairepieceTableMap::COL_PRIX_VENTE, $prixvente, $comparison);
    }

    /**
     * Filter the query on the date_enreg column
     *
     * Example usage:
     * <code>
     * $query->filterByDateenregistrement('2011-03-14'); // WHERE date_enreg = '2011-03-14'
     * $query->filterByDateenregistrement('now'); // WHERE date_enreg = '2011-03-14'
     * $query->filterByDateenregistrement(array('max' => 'yesterday')); // WHERE date_enreg > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateenregistrement The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByDateenregistrement($dateenregistrement = null, $comparison = null)
    {
        if (is_array($dateenregistrement)) {
            $useMinMax = false;
            if (isset($dateenregistrement['min'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_DATE_ENREG, $dateenregistrement['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateenregistrement['max'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_DATE_ENREG, $dateenregistrement['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartenairepieceTableMap::COL_DATE_ENREG, $dateenregistrement, $comparison);
    }

    /**
     * Filter the query on the reference_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByReference_PK('fooValue');   // WHERE reference_PK = 'fooValue'
     * $query->filterByReference_PK('%fooValue%'); // WHERE reference_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $reference_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByReference_PK($reference_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($reference_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $reference_PK)) {
                $reference_PK = str_replace('*', '%', $reference_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartenairepieceTableMap::COL_REFERENCE_PK, $reference_PK, $comparison);
    }

    /**
     * Filter the query on the part_id_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByPartenaire_PK(1234); // WHERE part_id_PK = 1234
     * $query->filterByPartenaire_PK(array(12, 34)); // WHERE part_id_PK IN (12, 34)
     * $query->filterByPartenaire_PK(array('min' => 12)); // WHERE part_id_PK > 12
     * </code>
     *
     * @see       filterByPartenaire()
     *
     * @param     mixed $partenaire_PK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByPartenaire_PK($partenaire_PK = null, $comparison = null)
    {
        if (is_array($partenaire_PK)) {
            $useMinMax = false;
            if (isset($partenaire_PK['min'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_PART_ID_PK, $partenaire_PK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($partenaire_PK['max'])) {
                $this->addUsingAlias(PartenairepieceTableMap::COL_PART_ID_PK, $partenaire_PK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartenairepieceTableMap::COL_PART_ID_PK, $partenaire_PK, $comparison);
    }

    /**
     * Filter the query by a related \Piece object
     *
     * @param \Piece|ObjectCollection $piece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByPiece($piece, $comparison = null)
    {
        if ($piece instanceof \Piece) {
            return $this
                ->addUsingAlias(PartenairepieceTableMap::COL_REFERENCE_PK, $piece->getReference(), $comparison);
        } elseif ($piece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PartenairepieceTableMap::COL_REFERENCE_PK, $piece->toKeyValue('Reference', 'Reference'), $comparison);
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
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
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
     * Filter the query by a related \Partenaire object
     *
     * @param \Partenaire|ObjectCollection $partenaire The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByPartenaire($partenaire, $comparison = null)
    {
        if ($partenaire instanceof \Partenaire) {
            return $this
                ->addUsingAlias(PartenairepieceTableMap::COL_PART_ID_PK, $partenaire->getPartenaire(), $comparison);
        } elseif ($partenaire instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PartenairepieceTableMap::COL_PART_ID_PK, $partenaire->toKeyValue('PrimaryKey', 'Partenaire'), $comparison);
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
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
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
     * Filter the query by a related \Document object
     *
     * @param \Document|ObjectCollection $document the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function filterByDoc($document, $comparison = null)
    {
        if ($document instanceof \Document) {
            return $this
                ->addUsingAlias(PartenairepieceTableMap::COL_DATE_ENREG, $document->getDateenreg_FK(), $comparison);
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
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildPartenairepiece $partenairepiece Object to remove from the list of results
     *
     * @return $this|ChildPartenairepieceQuery The current query, for fluid interface
     */
    public function prune($partenairepiece = null)
    {
        if ($partenairepiece) {
            $this->addUsingAlias(PartenairepieceTableMap::COL_ID, $partenairepiece->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the partenaire_piece table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PartenairepieceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PartenairepieceTableMap::clearInstancePool();
            PartenairepieceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PartenairepieceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PartenairepieceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PartenairepieceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PartenairepieceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PartenairepieceQuery
