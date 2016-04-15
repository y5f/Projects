<?php

namespace Base;

use \TBINDEX as ChildTBINDEX;
use \TBINDEXQuery as ChildTBINDEXQuery;
use \Exception;
use \PDO;
use Map\TBINDEXTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'tbindex' table.
 *
 *
 *
 * @method     ChildTBINDEXQuery orderByIndx($order = Criteria::ASC) Order by the indx column
 *
 * @method     ChildTBINDEXQuery groupByIndx() Group by the indx column
 *
 * @method     ChildTBINDEXQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTBINDEXQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTBINDEXQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTBINDEX findOne(ConnectionInterface $con = null) Return the first ChildTBINDEX matching the query
 * @method     ChildTBINDEX findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTBINDEX matching the query, or a new ChildTBINDEX object populated from the query conditions when no match is found
 *
 * @method     ChildTBINDEX findOneByIndx(int $indx) Return the first ChildTBINDEX filtered by the indx column *

 * @method     ChildTBINDEX requirePk($key, ConnectionInterface $con = null) Return the ChildTBINDEX by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTBINDEX requireOne(ConnectionInterface $con = null) Return the first ChildTBINDEX matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTBINDEX requireOneByIndx(int $indx) Return the first ChildTBINDEX filtered by the indx column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTBINDEX[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTBINDEX objects based on current ModelCriteria
 * @method     ChildTBINDEX[]|ObjectCollection findByIndx(int $indx) Return ChildTBINDEX objects filtered by the indx column
 * @method     ChildTBINDEX[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TBINDEXQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TBINDEXQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\TBINDEX', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTBINDEXQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTBINDEXQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTBINDEXQuery) {
            return $criteria;
        }
        $query = new ChildTBINDEXQuery();
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
     * @return ChildTBINDEX|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TBINDEXTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TBINDEXTableMap::DATABASE_NAME);
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
     * @return ChildTBINDEX A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT indx FROM tbindex WHERE indx = :p0';
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
            /** @var ChildTBINDEX $obj */
            $obj = new ChildTBINDEX();
            $obj->hydrate($row);
            TBINDEXTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTBINDEX|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTBINDEXQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TBINDEXTableMap::COL_INDX, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTBINDEXQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TBINDEXTableMap::COL_INDX, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the indx column
     *
     * Example usage:
     * <code>
     * $query->filterByIndx(1234); // WHERE indx = 1234
     * $query->filterByIndx(array(12, 34)); // WHERE indx IN (12, 34)
     * $query->filterByIndx(array('min' => 12)); // WHERE indx > 12
     * </code>
     *
     * @param     mixed $indx The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTBINDEXQuery The current query, for fluid interface
     */
    public function filterByIndx($indx = null, $comparison = null)
    {
        if (is_array($indx)) {
            $useMinMax = false;
            if (isset($indx['min'])) {
                $this->addUsingAlias(TBINDEXTableMap::COL_INDX, $indx['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($indx['max'])) {
                $this->addUsingAlias(TBINDEXTableMap::COL_INDX, $indx['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TBINDEXTableMap::COL_INDX, $indx, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTBINDEX $tBINDEX Object to remove from the list of results
     *
     * @return $this|ChildTBINDEXQuery The current query, for fluid interface
     */
    public function prune($tBINDEX = null)
    {
        if ($tBINDEX) {
            $this->addUsingAlias(TBINDEXTableMap::COL_INDX, $tBINDEX->getIndx(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tbindex table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TBINDEXTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TBINDEXTableMap::clearInstancePool();
            TBINDEXTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TBINDEXTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TBINDEXTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TBINDEXTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TBINDEXTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TBINDEXQuery