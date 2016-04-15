<?php

namespace Base;

use \Stock as ChildStock;
use \StockQuery as ChildStockQuery;
use \Exception;
use \PDO;
use Map\StockTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'stock' table.
 *
 *
 *
 * @method     ChildStockQuery orderById_stock($order = Criteria::ASC) Order by the stock_id column
 * @method     ChildStockQuery orderByDatedepart($order = Criteria::ASC) Order by the date_depart column
 * @method     ChildStockQuery orderByIDPiece_FK($order = Criteria::ASC) Order by the id_piece_FK column
 *
 * @method     ChildStockQuery groupById_stock() Group by the stock_id column
 * @method     ChildStockQuery groupByDatedepart() Group by the date_depart column
 * @method     ChildStockQuery groupByIDPiece_FK() Group by the id_piece_FK column
 *
 * @method     ChildStockQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockQuery leftJoinPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Piece relation
 * @method     ChildStockQuery rightJoinPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Piece relation
 * @method     ChildStockQuery innerJoinPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Piece relation
 *
 * @method     \PieceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStock findOne(ConnectionInterface $con = null) Return the first ChildStock matching the query
 * @method     ChildStock findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStock matching the query, or a new ChildStock object populated from the query conditions when no match is found
 *
 * @method     ChildStock findOneById_stock(int $stock_id) Return the first ChildStock filtered by the stock_id column
 * @method     ChildStock findOneByDatedepart(string $date_depart) Return the first ChildStock filtered by the date_depart column
 * @method     ChildStock findOneByIDPiece_FK(int $id_piece_FK) Return the first ChildStock filtered by the id_piece_FK column *

 * @method     ChildStock requirePk($key, ConnectionInterface $con = null) Return the ChildStock by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStock requireOne(ConnectionInterface $con = null) Return the first ChildStock matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStock requireOneById_stock(int $stock_id) Return the first ChildStock filtered by the stock_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStock requireOneByDatedepart(string $date_depart) Return the first ChildStock filtered by the date_depart column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStock requireOneByIDPiece_FK(int $id_piece_FK) Return the first ChildStock filtered by the id_piece_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStock[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStock objects based on current ModelCriteria
 * @method     ChildStock[]|ObjectCollection findById_stock(int $stock_id) Return ChildStock objects filtered by the stock_id column
 * @method     ChildStock[]|ObjectCollection findByDatedepart(string $date_depart) Return ChildStock objects filtered by the date_depart column
 * @method     ChildStock[]|ObjectCollection findByIDPiece_FK(int $id_piece_FK) Return ChildStock objects filtered by the id_piece_FK column
 * @method     ChildStock[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StockQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\StockQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Stock', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStockQuery) {
            return $criteria;
        }
        $query = new ChildStockQuery();
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
     * @return ChildStock|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StockTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockTableMap::DATABASE_NAME);
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
     * @return ChildStock A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT stock_id, date_depart, id_piece_FK FROM stock WHERE stock_id = :p0';
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
            /** @var ChildStock $obj */
            $obj = new ChildStock();
            $obj->hydrate($row);
            StockTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStock|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StockTableMap::COL_STOCK_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StockTableMap::COL_STOCK_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the stock_id column
     *
     * Example usage:
     * <code>
     * $query->filterById_stock(1234); // WHERE stock_id = 1234
     * $query->filterById_stock(array(12, 34)); // WHERE stock_id IN (12, 34)
     * $query->filterById_stock(array('min' => 12)); // WHERE stock_id > 12
     * </code>
     *
     * @param     mixed $id_stock The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterById_stock($id_stock = null, $comparison = null)
    {
        if (is_array($id_stock)) {
            $useMinMax = false;
            if (isset($id_stock['min'])) {
                $this->addUsingAlias(StockTableMap::COL_STOCK_ID, $id_stock['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id_stock['max'])) {
                $this->addUsingAlias(StockTableMap::COL_STOCK_ID, $id_stock['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_STOCK_ID, $id_stock, $comparison);
    }

    /**
     * Filter the query on the date_depart column
     *
     * Example usage:
     * <code>
     * $query->filterByDatedepart('2011-03-14'); // WHERE date_depart = '2011-03-14'
     * $query->filterByDatedepart('now'); // WHERE date_depart = '2011-03-14'
     * $query->filterByDatedepart(array('max' => 'yesterday')); // WHERE date_depart > '2011-03-13'
     * </code>
     *
     * @param     mixed $datedepart The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByDatedepart($datedepart = null, $comparison = null)
    {
        if (is_array($datedepart)) {
            $useMinMax = false;
            if (isset($datedepart['min'])) {
                $this->addUsingAlias(StockTableMap::COL_DATE_DEPART, $datedepart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datedepart['max'])) {
                $this->addUsingAlias(StockTableMap::COL_DATE_DEPART, $datedepart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_DATE_DEPART, $datedepart, $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function filterByIDPiece_FK($iDPiece_FK = null, $comparison = null)
    {
        if (is_array($iDPiece_FK)) {
            $useMinMax = false;
            if (isset($iDPiece_FK['min'])) {
                $this->addUsingAlias(StockTableMap::COL_ID_PIECE_FK, $iDPiece_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDPiece_FK['max'])) {
                $this->addUsingAlias(StockTableMap::COL_ID_PIECE_FK, $iDPiece_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockTableMap::COL_ID_PIECE_FK, $iDPiece_FK, $comparison);
    }

    /**
     * Filter the query by a related \Piece object
     *
     * @param \Piece|ObjectCollection $piece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStockQuery The current query, for fluid interface
     */
    public function filterByPiece($piece, $comparison = null)
    {
        if ($piece instanceof \Piece) {
            return $this
                ->addUsingAlias(StockTableMap::COL_ID_PIECE_FK, $piece->getID(), $comparison);
        } elseif ($piece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockTableMap::COL_ID_PIECE_FK, $piece->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildStockQuery The current query, for fluid interface
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
     * @param   ChildStock $stock Object to remove from the list of results
     *
     * @return $this|ChildStockQuery The current query, for fluid interface
     */
    public function prune($stock = null)
    {
        if ($stock) {
            $this->addUsingAlias(StockTableMap::COL_STOCK_ID, $stock->getId_stock(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stock table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StockTableMap::clearInstancePool();
            StockTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StockTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StockTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // StockQuery
