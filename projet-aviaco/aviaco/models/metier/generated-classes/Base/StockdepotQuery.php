<?php

namespace Base;

use \Stockdepot as ChildStockdepot;
use \StockdepotQuery as ChildStockdepotQuery;
use \Exception;
use \PDO;
use Map\StockdepotTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'stock_depot' table.
 *
 *
 *
 * @method     ChildStockdepotQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildStockdepotQuery orderByStock_id_PK($order = Criteria::ASC) Order by the stock_id_PK column
 * @method     ChildStockdepotQuery orderByReference_PK($order = Criteria::ASC) Order by the reference_PK column
 * @method     ChildStockdepotQuery orderById_depot_PK($order = Criteria::ASC) Order by the id_depot_PK column
 *
 * @method     ChildStockdepotQuery groupByID() Group by the id column
 * @method     ChildStockdepotQuery groupByStock_id_PK() Group by the stock_id_PK column
 * @method     ChildStockdepotQuery groupByReference_PK() Group by the reference_PK column
 * @method     ChildStockdepotQuery groupById_depot_PK() Group by the id_depot_PK column
 *
 * @method     ChildStockdepotQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockdepotQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockdepotQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockdepotQuery leftJoinStock($relationAlias = null) Adds a LEFT JOIN clause to the query using the Stock relation
 * @method     ChildStockdepotQuery rightJoinStock($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Stock relation
 * @method     ChildStockdepotQuery innerJoinStock($relationAlias = null) Adds a INNER JOIN clause to the query using the Stock relation
 *
 * @method     ChildStockdepotQuery leftJoinPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Piece relation
 * @method     ChildStockdepotQuery rightJoinPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Piece relation
 * @method     ChildStockdepotQuery innerJoinPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Piece relation
 *
 * @method     ChildStockdepotQuery leftJoinDepot($relationAlias = null) Adds a LEFT JOIN clause to the query using the Depot relation
 * @method     ChildStockdepotQuery rightJoinDepot($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Depot relation
 * @method     ChildStockdepotQuery innerJoinDepot($relationAlias = null) Adds a INNER JOIN clause to the query using the Depot relation
 *
 * @method     \StockQuery|\PieceQuery|\DepotQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStockdepot findOne(ConnectionInterface $con = null) Return the first ChildStockdepot matching the query
 * @method     ChildStockdepot findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStockdepot matching the query, or a new ChildStockdepot object populated from the query conditions when no match is found
 *
 * @method     ChildStockdepot findOneByID(int $id) Return the first ChildStockdepot filtered by the id column
 * @method     ChildStockdepot findOneByStock_id_PK(int $stock_id_PK) Return the first ChildStockdepot filtered by the stock_id_PK column
 * @method     ChildStockdepot findOneByReference_PK(string $reference_PK) Return the first ChildStockdepot filtered by the reference_PK column
 * @method     ChildStockdepot findOneById_depot_PK(int $id_depot_PK) Return the first ChildStockdepot filtered by the id_depot_PK column *

 * @method     ChildStockdepot requirePk($key, ConnectionInterface $con = null) Return the ChildStockdepot by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockdepot requireOne(ConnectionInterface $con = null) Return the first ChildStockdepot matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStockdepot requireOneByID(int $id) Return the first ChildStockdepot filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockdepot requireOneByStock_id_PK(int $stock_id_PK) Return the first ChildStockdepot filtered by the stock_id_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockdepot requireOneByReference_PK(string $reference_PK) Return the first ChildStockdepot filtered by the reference_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStockdepot requireOneById_depot_PK(int $id_depot_PK) Return the first ChildStockdepot filtered by the id_depot_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStockdepot[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStockdepot objects based on current ModelCriteria
 * @method     ChildStockdepot[]|ObjectCollection findByID(int $id) Return ChildStockdepot objects filtered by the id column
 * @method     ChildStockdepot[]|ObjectCollection findByStock_id_PK(int $stock_id_PK) Return ChildStockdepot objects filtered by the stock_id_PK column
 * @method     ChildStockdepot[]|ObjectCollection findByReference_PK(string $reference_PK) Return ChildStockdepot objects filtered by the reference_PK column
 * @method     ChildStockdepot[]|ObjectCollection findById_depot_PK(int $id_depot_PK) Return ChildStockdepot objects filtered by the id_depot_PK column
 * @method     ChildStockdepot[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StockdepotQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\StockdepotQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Stockdepot', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockdepotQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockdepotQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStockdepotQuery) {
            return $criteria;
        }
        $query = new ChildStockdepotQuery();
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
     * @return ChildStockdepot|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StockdepotTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockdepotTableMap::DATABASE_NAME);
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
     * @return ChildStockdepot A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, stock_id_PK, reference_PK, id_depot_PK FROM stock_depot WHERE id = :p0';
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
            /** @var ChildStockdepot $obj */
            $obj = new ChildStockdepot();
            $obj->hydrate($row);
            StockdepotTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStockdepot|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StockdepotTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StockdepotTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(StockdepotTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(StockdepotTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockdepotTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the stock_id_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByStock_id_PK(1234); // WHERE stock_id_PK = 1234
     * $query->filterByStock_id_PK(array(12, 34)); // WHERE stock_id_PK IN (12, 34)
     * $query->filterByStock_id_PK(array('min' => 12)); // WHERE stock_id_PK > 12
     * </code>
     *
     * @see       filterByStock()
     *
     * @param     mixed $stock_id_PK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
     */
    public function filterByStock_id_PK($stock_id_PK = null, $comparison = null)
    {
        if (is_array($stock_id_PK)) {
            $useMinMax = false;
            if (isset($stock_id_PK['min'])) {
                $this->addUsingAlias(StockdepotTableMap::COL_STOCK_ID_PK, $stock_id_PK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stock_id_PK['max'])) {
                $this->addUsingAlias(StockdepotTableMap::COL_STOCK_ID_PK, $stock_id_PK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockdepotTableMap::COL_STOCK_ID_PK, $stock_id_PK, $comparison);
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
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StockdepotTableMap::COL_REFERENCE_PK, $reference_PK, $comparison);
    }

    /**
     * Filter the query on the id_depot_PK column
     *
     * Example usage:
     * <code>
     * $query->filterById_depot_PK(1234); // WHERE id_depot_PK = 1234
     * $query->filterById_depot_PK(array(12, 34)); // WHERE id_depot_PK IN (12, 34)
     * $query->filterById_depot_PK(array('min' => 12)); // WHERE id_depot_PK > 12
     * </code>
     *
     * @see       filterByDepot()
     *
     * @param     mixed $id_depot_PK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
     */
    public function filterById_depot_PK($id_depot_PK = null, $comparison = null)
    {
        if (is_array($id_depot_PK)) {
            $useMinMax = false;
            if (isset($id_depot_PK['min'])) {
                $this->addUsingAlias(StockdepotTableMap::COL_ID_DEPOT_PK, $id_depot_PK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id_depot_PK['max'])) {
                $this->addUsingAlias(StockdepotTableMap::COL_ID_DEPOT_PK, $id_depot_PK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockdepotTableMap::COL_ID_DEPOT_PK, $id_depot_PK, $comparison);
    }

    /**
     * Filter the query by a related \Stock object
     *
     * @param \Stock|ObjectCollection $stock The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStockdepotQuery The current query, for fluid interface
     */
    public function filterByStock($stock, $comparison = null)
    {
        if ($stock instanceof \Stock) {
            return $this
                ->addUsingAlias(StockdepotTableMap::COL_STOCK_ID_PK, $stock->getId_stock(), $comparison);
        } elseif ($stock instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockdepotTableMap::COL_STOCK_ID_PK, $stock->toKeyValue('PrimaryKey', 'Id_stock'), $comparison);
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
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
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
     * Filter the query by a related \Piece object
     *
     * @param \Piece|ObjectCollection $piece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStockdepotQuery The current query, for fluid interface
     */
    public function filterByPiece($piece, $comparison = null)
    {
        if ($piece instanceof \Piece) {
            return $this
                ->addUsingAlias(StockdepotTableMap::COL_REFERENCE_PK, $piece->getReference(), $comparison);
        } elseif ($piece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockdepotTableMap::COL_REFERENCE_PK, $piece->toKeyValue('Reference', 'Reference'), $comparison);
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
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
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
     * Filter the query by a related \Depot object
     *
     * @param \Depot|ObjectCollection $depot The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStockdepotQuery The current query, for fluid interface
     */
    public function filterByDepot($depot, $comparison = null)
    {
        if ($depot instanceof \Depot) {
            return $this
                ->addUsingAlias(StockdepotTableMap::COL_ID_DEPOT_PK, $depot->getIddepot(), $comparison);
        } elseif ($depot instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockdepotTableMap::COL_ID_DEPOT_PK, $depot->toKeyValue('PrimaryKey', 'Iddepot'), $comparison);
        } else {
            throw new PropelException('filterByDepot() only accepts arguments of type \Depot or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Depot relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
     */
    public function joinDepot($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Depot');

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
            $this->addJoinObject($join, 'Depot');
        }

        return $this;
    }

    /**
     * Use the Depot relation Depot object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DepotQuery A secondary query class using the current class as primary query
     */
    public function useDepotQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDepot($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Depot', '\DepotQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStockdepot $stockdepot Object to remove from the list of results
     *
     * @return $this|ChildStockdepotQuery The current query, for fluid interface
     */
    public function prune($stockdepot = null)
    {
        if ($stockdepot) {
            $this->addUsingAlias(StockdepotTableMap::COL_ID, $stockdepot->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stock_depot table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockdepotTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StockdepotTableMap::clearInstancePool();
            StockdepotTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StockdepotTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockdepotTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StockdepotTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockdepotTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // StockdepotQuery
