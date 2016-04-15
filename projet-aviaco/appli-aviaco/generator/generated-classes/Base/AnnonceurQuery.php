<?php

namespace Base;

use \Annonceur as ChildAnnonceur;
use \AnnonceurQuery as ChildAnnonceurQuery;
use \Exception;
use \PDO;
use Map\AnnonceurTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'annonceur' table.
 *
 *
 *
 * @method     ChildAnnonceurQuery orderByIDPart($order = Criteria::ASC) Order by the indx_part column
 * @method     ChildAnnonceurQuery orderByisStock($order = Criteria::ASC) Order by the stock_en_ligne column
 *
 * @method     ChildAnnonceurQuery groupByIDPart() Group by the indx_part column
 * @method     ChildAnnonceurQuery groupByisStock() Group by the stock_en_ligne column
 *
 * @method     ChildAnnonceurQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAnnonceurQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAnnonceurQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAnnonceurQuery leftJoinPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenaire relation
 * @method     ChildAnnonceurQuery rightJoinPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenaire relation
 * @method     ChildAnnonceurQuery innerJoinPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenaire relation
 *
 * @method     \PartenaireQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAnnonceur findOne(ConnectionInterface $con = null) Return the first ChildAnnonceur matching the query
 * @method     ChildAnnonceur findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAnnonceur matching the query, or a new ChildAnnonceur object populated from the query conditions when no match is found
 *
 * @method     ChildAnnonceur findOneByIDPart(int $indx_part) Return the first ChildAnnonceur filtered by the indx_part column
 * @method     ChildAnnonceur findOneByisStock(boolean $stock_en_ligne) Return the first ChildAnnonceur filtered by the stock_en_ligne column *

 * @method     ChildAnnonceur requirePk($key, ConnectionInterface $con = null) Return the ChildAnnonceur by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnonceur requireOne(ConnectionInterface $con = null) Return the first ChildAnnonceur matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAnnonceur requireOneByIDPart(int $indx_part) Return the first ChildAnnonceur filtered by the indx_part column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAnnonceur requireOneByisStock(boolean $stock_en_ligne) Return the first ChildAnnonceur filtered by the stock_en_ligne column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAnnonceur[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAnnonceur objects based on current ModelCriteria
 * @method     ChildAnnonceur[]|ObjectCollection findByIDPart(int $indx_part) Return ChildAnnonceur objects filtered by the indx_part column
 * @method     ChildAnnonceur[]|ObjectCollection findByisStock(boolean $stock_en_ligne) Return ChildAnnonceur objects filtered by the stock_en_ligne column
 * @method     ChildAnnonceur[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AnnonceurQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AnnonceurQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Annonceur', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAnnonceurQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAnnonceurQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAnnonceurQuery) {
            return $criteria;
        }
        $query = new ChildAnnonceurQuery();
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
     * @return ChildAnnonceur|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AnnonceurTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AnnonceurTableMap::DATABASE_NAME);
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
     * @return ChildAnnonceur A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT indx_part, stock_en_ligne FROM annonceur WHERE indx_part = :p0';
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
            /** @var ChildAnnonceur $obj */
            $obj = new ChildAnnonceur();
            $obj->hydrate($row);
            AnnonceurTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAnnonceur|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAnnonceurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnnonceurTableMap::COL_INDX_PART, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAnnonceurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnnonceurTableMap::COL_INDX_PART, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the indx_part column
     *
     * Example usage:
     * <code>
     * $query->filterByIDPart(1234); // WHERE indx_part = 1234
     * $query->filterByIDPart(array(12, 34)); // WHERE indx_part IN (12, 34)
     * $query->filterByIDPart(array('min' => 12)); // WHERE indx_part > 12
     * </code>
     *
     * @see       filterByPartenaire()
     *
     * @param     mixed $iDPart The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnnonceurQuery The current query, for fluid interface
     */
    public function filterByIDPart($iDPart = null, $comparison = null)
    {
        if (is_array($iDPart)) {
            $useMinMax = false;
            if (isset($iDPart['min'])) {
                $this->addUsingAlias(AnnonceurTableMap::COL_INDX_PART, $iDPart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDPart['max'])) {
                $this->addUsingAlias(AnnonceurTableMap::COL_INDX_PART, $iDPart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnnonceurTableMap::COL_INDX_PART, $iDPart, $comparison);
    }

    /**
     * Filter the query on the stock_en_ligne column
     *
     * Example usage:
     * <code>
     * $query->filterByisStock(true); // WHERE stock_en_ligne = true
     * $query->filterByisStock('yes'); // WHERE stock_en_ligne = true
     * </code>
     *
     * @param     boolean|string $isStock The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAnnonceurQuery The current query, for fluid interface
     */
    public function filterByisStock($isStock = null, $comparison = null)
    {
        if (is_string($isStock)) {
            $isStock = in_array(strtolower($isStock), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AnnonceurTableMap::COL_STOCK_EN_LIGNE, $isStock, $comparison);
    }

    /**
     * Filter the query by a related \Partenaire object
     *
     * @param \Partenaire|ObjectCollection $partenaire The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAnnonceurQuery The current query, for fluid interface
     */
    public function filterByPartenaire($partenaire, $comparison = null)
    {
        if ($partenaire instanceof \Partenaire) {
            return $this
                ->addUsingAlias(AnnonceurTableMap::COL_INDX_PART, $partenaire->getID(), $comparison);
        } elseif ($partenaire instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnnonceurTableMap::COL_INDX_PART, $partenaire->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildAnnonceurQuery The current query, for fluid interface
     */
    public function joinPartenaire($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function usePartenaireQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Partenaire', '\PartenaireQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAnnonceur $annonceur Object to remove from the list of results
     *
     * @return $this|ChildAnnonceurQuery The current query, for fluid interface
     */
    public function prune($annonceur = null)
    {
        if ($annonceur) {
            $this->addUsingAlias(AnnonceurTableMap::COL_INDX_PART, $annonceur->getIDPart(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the annonceur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AnnonceurTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AnnonceurTableMap::clearInstancePool();
            AnnonceurTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AnnonceurTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AnnonceurTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AnnonceurTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AnnonceurTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AnnonceurQuery
