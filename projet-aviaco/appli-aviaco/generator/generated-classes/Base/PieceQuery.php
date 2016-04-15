<?php

namespace Base;

use \Piece as ChildPiece;
use \PieceQuery as ChildPieceQuery;
use \Exception;
use \PDO;
use Map\PieceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'piece' table.
 *
 *
 *
 * @method     ChildPieceQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildPieceQuery orderByReference($order = Criteria::ASC) Order by the reference column
 * @method     ChildPieceQuery orderByType($order = Criteria::ASC) Order by the type_FK column
 * @method     ChildPieceQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildPieceQuery orderByPN($order = Criteria::ASC) Order by the pn column
 * @method     ChildPieceQuery orderByAltPN($order = Criteria::ASC) Order by the alt_pn column
 * @method     ChildPieceQuery orderByOtan($order = Criteria::ASC) Order by the otan column
 * @method     ChildPieceQuery orderByISPaperboard($order = Criteria::ASC) Order by the ispaperboard column
 * @method     ChildPieceQuery orderByCommentaire($order = Criteria::ASC) Order by the comment column
 *
 * @method     ChildPieceQuery groupByID() Group by the id column
 * @method     ChildPieceQuery groupByReference() Group by the reference column
 * @method     ChildPieceQuery groupByType() Group by the type_FK column
 * @method     ChildPieceQuery groupByDescription() Group by the description column
 * @method     ChildPieceQuery groupByPN() Group by the pn column
 * @method     ChildPieceQuery groupByAltPN() Group by the alt_pn column
 * @method     ChildPieceQuery groupByOtan() Group by the otan column
 * @method     ChildPieceQuery groupByISPaperboard() Group by the ispaperboard column
 * @method     ChildPieceQuery groupByCommentaire() Group by the comment column
 *
 * @method     ChildPieceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPieceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPieceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPieceQuery leftJoinTypepiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Typepiece relation
 * @method     ChildPieceQuery rightJoinTypepiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Typepiece relation
 * @method     ChildPieceQuery innerJoinTypepiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Typepiece relation
 *
 * @method     ChildPieceQuery leftJoinPieceApp($relationAlias = null) Adds a LEFT JOIN clause to the query using the PieceApp relation
 * @method     ChildPieceQuery rightJoinPieceApp($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PieceApp relation
 * @method     ChildPieceQuery innerJoinPieceApp($relationAlias = null) Adds a INNER JOIN clause to the query using the PieceApp relation
 *
 * @method     ChildPieceQuery leftJoinFournisseur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fournisseur relation
 * @method     ChildPieceQuery rightJoinFournisseur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fournisseur relation
 * @method     ChildPieceQuery innerJoinFournisseur($relationAlias = null) Adds a INNER JOIN clause to the query using the Fournisseur relation
 *
 * @method     ChildPieceQuery leftJoinCOMCondition($relationAlias = null) Adds a LEFT JOIN clause to the query using the COMCondition relation
 * @method     ChildPieceQuery rightJoinCOMCondition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the COMCondition relation
 * @method     ChildPieceQuery innerJoinCOMCondition($relationAlias = null) Adds a INNER JOIN clause to the query using the COMCondition relation
 *
 * @method     ChildPieceQuery leftJoinCOMVendeur($relationAlias = null) Adds a LEFT JOIN clause to the query using the COMVendeur relation
 * @method     ChildPieceQuery rightJoinCOMVendeur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the COMVendeur relation
 * @method     ChildPieceQuery innerJoinCOMVendeur($relationAlias = null) Adds a INNER JOIN clause to the query using the COMVendeur relation
 *
 * @method     ChildPieceQuery leftJoinCMDPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the CMDPiece relation
 * @method     ChildPieceQuery rightJoinCMDPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CMDPiece relation
 * @method     ChildPieceQuery innerJoinCMDPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the CMDPiece relation
 *
 * @method     ChildPieceQuery leftJoinCOMEnduser($relationAlias = null) Adds a LEFT JOIN clause to the query using the COMEnduser relation
 * @method     ChildPieceQuery rightJoinCOMEnduser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the COMEnduser relation
 * @method     ChildPieceQuery innerJoinCOMEnduser($relationAlias = null) Adds a INNER JOIN clause to the query using the COMEnduser relation
 *
 * @method     ChildPieceQuery leftJoinCMDTAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the CMDTAppareil relation
 * @method     ChildPieceQuery rightJoinCMDTAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CMDTAppareil relation
 * @method     ChildPieceQuery innerJoinCMDTAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the CMDTAppareil relation
 *
 * @method     ChildPieceQuery leftJoinStock($relationAlias = null) Adds a LEFT JOIN clause to the query using the Stock relation
 * @method     ChildPieceQuery rightJoinStock($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Stock relation
 * @method     ChildPieceQuery innerJoinStock($relationAlias = null) Adds a INNER JOIN clause to the query using the Stock relation
 *
 * @method     \TypepieceQuery|\PieceAppQuery|\FournisseurQuery|\COMConditionQuery|\COMVendeurQuery|\CMDPieceQuery|\COMEnduserQuery|\CMDTAppareilQuery|\StockQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPiece findOne(ConnectionInterface $con = null) Return the first ChildPiece matching the query
 * @method     ChildPiece findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPiece matching the query, or a new ChildPiece object populated from the query conditions when no match is found
 *
 * @method     ChildPiece findOneByID(int $id) Return the first ChildPiece filtered by the id column
 * @method     ChildPiece findOneByReference(string $reference) Return the first ChildPiece filtered by the reference column
 * @method     ChildPiece findOneByType(string $type_FK) Return the first ChildPiece filtered by the type_FK column
 * @method     ChildPiece findOneByDescription(string $description) Return the first ChildPiece filtered by the description column
 * @method     ChildPiece findOneByPN(string $pn) Return the first ChildPiece filtered by the pn column
 * @method     ChildPiece findOneByAltPN(string $alt_pn) Return the first ChildPiece filtered by the alt_pn column
 * @method     ChildPiece findOneByOtan(string $otan) Return the first ChildPiece filtered by the otan column
 * @method     ChildPiece findOneByISPaperboard(boolean $ispaperboard) Return the first ChildPiece filtered by the ispaperboard column
 * @method     ChildPiece findOneByCommentaire(string $comment) Return the first ChildPiece filtered by the comment column *

 * @method     ChildPiece requirePk($key, ConnectionInterface $con = null) Return the ChildPiece by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOne(ConnectionInterface $con = null) Return the first ChildPiece matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPiece requireOneByID(int $id) Return the first ChildPiece filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByReference(string $reference) Return the first ChildPiece filtered by the reference column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByType(string $type_FK) Return the first ChildPiece filtered by the type_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByDescription(string $description) Return the first ChildPiece filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByPN(string $pn) Return the first ChildPiece filtered by the pn column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByAltPN(string $alt_pn) Return the first ChildPiece filtered by the alt_pn column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByOtan(string $otan) Return the first ChildPiece filtered by the otan column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByISPaperboard(boolean $ispaperboard) Return the first ChildPiece filtered by the ispaperboard column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByCommentaire(string $comment) Return the first ChildPiece filtered by the comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPiece[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPiece objects based on current ModelCriteria
 * @method     ChildPiece[]|ObjectCollection findByID(int $id) Return ChildPiece objects filtered by the id column
 * @method     ChildPiece[]|ObjectCollection findByReference(string $reference) Return ChildPiece objects filtered by the reference column
 * @method     ChildPiece[]|ObjectCollection findByType(string $type_FK) Return ChildPiece objects filtered by the type_FK column
 * @method     ChildPiece[]|ObjectCollection findByDescription(string $description) Return ChildPiece objects filtered by the description column
 * @method     ChildPiece[]|ObjectCollection findByPN(string $pn) Return ChildPiece objects filtered by the pn column
 * @method     ChildPiece[]|ObjectCollection findByAltPN(string $alt_pn) Return ChildPiece objects filtered by the alt_pn column
 * @method     ChildPiece[]|ObjectCollection findByOtan(string $otan) Return ChildPiece objects filtered by the otan column
 * @method     ChildPiece[]|ObjectCollection findByISPaperboard(boolean $ispaperboard) Return ChildPiece objects filtered by the ispaperboard column
 * @method     ChildPiece[]|ObjectCollection findByCommentaire(string $comment) Return ChildPiece objects filtered by the comment column
 * @method     ChildPiece[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PieceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PieceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Piece', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPieceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPieceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPieceQuery) {
            return $criteria;
        }
        $query = new ChildPieceQuery();
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
     * @return ChildPiece|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PieceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PieceTableMap::DATABASE_NAME);
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
     * @return ChildPiece A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, reference, type_FK, description, pn, alt_pn, otan, ispaperboard, comment FROM piece WHERE id = :p0';
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
            /** @var ChildPiece $obj */
            $obj = new ChildPiece();
            $obj->hydrate($row);
            PieceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPiece|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PieceTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PieceTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(PieceTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(PieceTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PieceTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the reference column
     *
     * Example usage:
     * <code>
     * $query->filterByReference('fooValue');   // WHERE reference = 'fooValue'
     * $query->filterByReference('%fooValue%'); // WHERE reference LIKE '%fooValue%'
     * </code>
     *
     * @param     string $reference The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByReference($reference = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($reference)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $reference)) {
                $reference = str_replace('*', '%', $reference);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PieceTableMap::COL_REFERENCE, $reference, $comparison);
    }

    /**
     * Filter the query on the type_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type_FK = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PieceTableMap::COL_TYPE_FK, $type, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PieceTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the pn column
     *
     * Example usage:
     * <code>
     * $query->filterByPN('fooValue');   // WHERE pn = 'fooValue'
     * $query->filterByPN('%fooValue%'); // WHERE pn LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pN The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByPN($pN = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pN)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pN)) {
                $pN = str_replace('*', '%', $pN);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PieceTableMap::COL_PN, $pN, $comparison);
    }

    /**
     * Filter the query on the alt_pn column
     *
     * Example usage:
     * <code>
     * $query->filterByAltPN('fooValue');   // WHERE alt_pn = 'fooValue'
     * $query->filterByAltPN('%fooValue%'); // WHERE alt_pn LIKE '%fooValue%'
     * </code>
     *
     * @param     string $altPN The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByAltPN($altPN = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($altPN)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $altPN)) {
                $altPN = str_replace('*', '%', $altPN);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PieceTableMap::COL_ALT_PN, $altPN, $comparison);
    }

    /**
     * Filter the query on the otan column
     *
     * Example usage:
     * <code>
     * $query->filterByOtan('fooValue');   // WHERE otan = 'fooValue'
     * $query->filterByOtan('%fooValue%'); // WHERE otan LIKE '%fooValue%'
     * </code>
     *
     * @param     string $otan The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByOtan($otan = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($otan)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $otan)) {
                $otan = str_replace('*', '%', $otan);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PieceTableMap::COL_OTAN, $otan, $comparison);
    }

    /**
     * Filter the query on the ispaperboard column
     *
     * Example usage:
     * <code>
     * $query->filterByISPaperboard(true); // WHERE ispaperboard = true
     * $query->filterByISPaperboard('yes'); // WHERE ispaperboard = true
     * </code>
     *
     * @param     boolean|string $iSPaperboard The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByISPaperboard($iSPaperboard = null, $comparison = null)
    {
        if (is_string($iSPaperboard)) {
            $iSPaperboard = in_array(strtolower($iSPaperboard), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PieceTableMap::COL_ISPAPERBOARD, $iSPaperboard, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByCommentaire('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByCommentaire('%fooValue%'); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $commentaire The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByCommentaire($commentaire = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($commentaire)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $commentaire)) {
                $commentaire = str_replace('*', '%', $commentaire);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PieceTableMap::COL_COMMENT, $commentaire, $comparison);
    }

    /**
     * Filter the query by a related \Typepiece object
     *
     * @param \Typepiece|ObjectCollection $typepiece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByTypepiece($typepiece, $comparison = null)
    {
        if ($typepiece instanceof \Typepiece) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_TYPE_FK, $typepiece->getType(), $comparison);
        } elseif ($typepiece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PieceTableMap::COL_TYPE_FK, $typepiece->toKeyValue('PrimaryKey', 'Type'), $comparison);
        } else {
            throw new PropelException('filterByTypepiece() only accepts arguments of type \Typepiece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Typepiece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function joinTypepiece($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Typepiece');

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
            $this->addJoinObject($join, 'Typepiece');
        }

        return $this;
    }

    /**
     * Use the Typepiece relation Typepiece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TypepieceQuery A secondary query class using the current class as primary query
     */
    public function useTypepieceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTypepiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Typepiece', '\TypepieceQuery');
    }

    /**
     * Filter the query by a related \PieceApp object
     *
     * @param \PieceApp|ObjectCollection $pieceApp the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByPieceApp($pieceApp, $comparison = null)
    {
        if ($pieceApp instanceof \PieceApp) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_ID, $pieceApp->getIDPiece_FK(), $comparison);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
     * Filter the query by a related \Fournisseur object
     *
     * @param \Fournisseur|ObjectCollection $fournisseur the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByFournisseur($fournisseur, $comparison = null)
    {
        if ($fournisseur instanceof \Fournisseur) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_ID, $fournisseur->getIDPiece_PK(), $comparison);
        } elseif ($fournisseur instanceof ObjectCollection) {
            return $this
                ->useFournisseurQuery()
                ->filterByPrimaryKeys($fournisseur->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
     * Filter the query by a related \COMCondition object
     *
     * @param \COMCondition|ObjectCollection $cOMCondition the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByCOMCondition($cOMCondition, $comparison = null)
    {
        if ($cOMCondition instanceof \COMCondition) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_ID, $cOMCondition->getIDPiece_FK(), $comparison);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByCOMVendeur($cOMVendeur, $comparison = null)
    {
        if ($cOMVendeur instanceof \COMVendeur) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_ID, $cOMVendeur->getIDPiece_FK(), $comparison);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByCMDPiece($cMDPiece, $comparison = null)
    {
        if ($cMDPiece instanceof \CMDPiece) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_ID, $cMDPiece->getIDPiece(), $comparison);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByCOMEnduser($cOMEnduser, $comparison = null)
    {
        if ($cOMEnduser instanceof \COMEnduser) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_ID, $cOMEnduser->getIDPiece_FK(), $comparison);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
     * Filter the query by a related \CMDTAppareil object
     *
     * @param \CMDTAppareil|ObjectCollection $cMDTAppareil the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByCMDTAppareil($cMDTAppareil, $comparison = null)
    {
        if ($cMDTAppareil instanceof \CMDTAppareil) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_ID, $cMDTAppareil->getIDPiece_FK(), $comparison);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
     * Filter the query by a related \Stock object
     *
     * @param \Stock|ObjectCollection $stock the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByStock($stock, $comparison = null)
    {
        if ($stock instanceof \Stock) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_ID, $stock->getIDPiece_FK(), $comparison);
        } elseif ($stock instanceof ObjectCollection) {
            return $this
                ->useStockQuery()
                ->filterByPrimaryKeys($stock->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStock() only accepts arguments of type \Stock or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Stock relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function joinStock($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Stock');

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
            $this->addJoinObject($join, 'Stock');
        }

        return $this;
    }

    /**
     * Use the Stock relation Stock object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StockQuery A secondary query class using the current class as primary query
     */
    public function useStockQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStock($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Stock', '\StockQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPiece $piece Object to remove from the list of results
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function prune($piece = null)
    {
        if ($piece) {
            $this->addUsingAlias(PieceTableMap::COL_ID, $piece->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the piece table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PieceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PieceTableMap::clearInstancePool();
            PieceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PieceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PieceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PieceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PieceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PieceQuery
