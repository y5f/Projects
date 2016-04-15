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
 * @method     ChildPieceQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildPieceQuery groupByID() Group by the id column
 * @method     ChildPieceQuery groupByReference() Group by the reference column
 * @method     ChildPieceQuery groupByDescription() Group by the description column
 *
 * @method     ChildPieceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPieceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPieceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPieceQuery leftJoinPieceApp($relationAlias = null) Adds a LEFT JOIN clause to the query using the PieceApp relation
 * @method     ChildPieceQuery rightJoinPieceApp($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PieceApp relation
 * @method     ChildPieceQuery innerJoinPieceApp($relationAlias = null) Adds a INNER JOIN clause to the query using the PieceApp relation
 *
 * @method     ChildPieceQuery leftJoinPhotopiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Photopiece relation
 * @method     ChildPieceQuery rightJoinPhotopiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Photopiece relation
 * @method     ChildPieceQuery innerJoinPhotopiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Photopiece relation
 *
 * @method     ChildPieceQuery leftJoinPartenairepiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenairepiece relation
 * @method     ChildPieceQuery rightJoinPartenairepiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenairepiece relation
 * @method     ChildPieceQuery innerJoinPartenairepiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenairepiece relation
 *
 * @method     ChildPieceQuery leftJoinDoc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Doc relation
 * @method     ChildPieceQuery rightJoinDoc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Doc relation
 * @method     ChildPieceQuery innerJoinDoc($relationAlias = null) Adds a INNER JOIN clause to the query using the Doc relation
 *
 * @method     ChildPieceQuery leftJoinStock($relationAlias = null) Adds a LEFT JOIN clause to the query using the Stock relation
 * @method     ChildPieceQuery rightJoinStock($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Stock relation
 * @method     ChildPieceQuery innerJoinStock($relationAlias = null) Adds a INNER JOIN clause to the query using the Stock relation
 *
 * @method     ChildPieceQuery leftJoinStockdepot($relationAlias = null) Adds a LEFT JOIN clause to the query using the Stockdepot relation
 * @method     ChildPieceQuery rightJoinStockdepot($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Stockdepot relation
 * @method     ChildPieceQuery innerJoinStockdepot($relationAlias = null) Adds a INNER JOIN clause to the query using the Stockdepot relation
 *
 * @method     \PieceAppQuery|\PhotopieceQuery|\PartenairepieceQuery|\DocumentQuery|\StockQuery|\StockdepotQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPiece findOne(ConnectionInterface $con = null) Return the first ChildPiece matching the query
 * @method     ChildPiece findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPiece matching the query, or a new ChildPiece object populated from the query conditions when no match is found
 *
 * @method     ChildPiece findOneByID(int $id) Return the first ChildPiece filtered by the id column
 * @method     ChildPiece findOneByReference(string $reference) Return the first ChildPiece filtered by the reference column
 * @method     ChildPiece findOneByDescription(string $description) Return the first ChildPiece filtered by the description column *

 * @method     ChildPiece requirePk($key, ConnectionInterface $con = null) Return the ChildPiece by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOne(ConnectionInterface $con = null) Return the first ChildPiece matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPiece requireOneByID(int $id) Return the first ChildPiece filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByReference(string $reference) Return the first ChildPiece filtered by the reference column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPiece requireOneByDescription(string $description) Return the first ChildPiece filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPiece[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPiece objects based on current ModelCriteria
 * @method     ChildPiece[]|ObjectCollection findByID(int $id) Return ChildPiece objects filtered by the id column
 * @method     ChildPiece[]|ObjectCollection findByReference(string $reference) Return ChildPiece objects filtered by the reference column
 * @method     ChildPiece[]|ObjectCollection findByDescription(string $description) Return ChildPiece objects filtered by the description column
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
    public function __construct($dbName = 'aviaco', $modelName = '\\Piece', $modelAlias = null)
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $reference] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPiece|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PieceTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
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
        $sql = 'SELECT id, reference, description FROM piece WHERE id = :p0 AND reference = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
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
            PieceTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PieceTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PieceTableMap::COL_REFERENCE, $key[1], Criteria::EQUAL);

        return $this;
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
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PieceTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PieceTableMap::COL_REFERENCE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
                ->addUsingAlias(PieceTableMap::COL_REFERENCE, $pieceApp->getReference_PK(), $comparison);
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
     * Filter the query by a related \Photopiece object
     *
     * @param \Photopiece|ObjectCollection $photopiece the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByPhotopiece($photopiece, $comparison = null)
    {
        if ($photopiece instanceof \Photopiece) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_REFERENCE, $photopiece->getReference_FK(), $comparison);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
     * Filter the query by a related \Partenairepiece object
     *
     * @param \Partenairepiece|ObjectCollection $partenairepiece the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByPartenairepiece($partenairepiece, $comparison = null)
    {
        if ($partenairepiece instanceof \Partenairepiece) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_REFERENCE, $partenairepiece->getReference_PK(), $comparison);
        } elseif ($partenairepiece instanceof ObjectCollection) {
            return $this
                ->usePartenairepieceQuery()
                ->filterByPrimaryKeys($partenairepiece->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPartenairepiece() only accepts arguments of type \Partenairepiece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Partenairepiece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function joinPartenairepiece($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Partenairepiece');

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
            $this->addJoinObject($join, 'Partenairepiece');
        }

        return $this;
    }

    /**
     * Use the Partenairepiece relation Partenairepiece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PartenairepieceQuery A secondary query class using the current class as primary query
     */
    public function usePartenairepieceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPartenairepiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Partenairepiece', '\PartenairepieceQuery');
    }

    /**
     * Filter the query by a related \Document object
     *
     * @param \Document|ObjectCollection $document the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByDoc($document, $comparison = null)
    {
        if ($document instanceof \Document) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_REFERENCE, $document->getReference_FK(), $comparison);
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
     * @return $this|ChildPieceQuery The current query, for fluid interface
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
                ->addUsingAlias(PieceTableMap::COL_REFERENCE, $stock->getReference_PK(), $comparison);
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
     * Filter the query by a related \Stockdepot object
     *
     * @param \Stockdepot|ObjectCollection $stockdepot the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPieceQuery The current query, for fluid interface
     */
    public function filterByStockdepot($stockdepot, $comparison = null)
    {
        if ($stockdepot instanceof \Stockdepot) {
            return $this
                ->addUsingAlias(PieceTableMap::COL_REFERENCE, $stockdepot->getReference_PK(), $comparison);
        } elseif ($stockdepot instanceof ObjectCollection) {
            return $this
                ->useStockdepotQuery()
                ->filterByPrimaryKeys($stockdepot->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStockdepot() only accepts arguments of type \Stockdepot or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Stockdepot relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPieceQuery The current query, for fluid interface
     */
    public function joinStockdepot($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Stockdepot');

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
            $this->addJoinObject($join, 'Stockdepot');
        }

        return $this;
    }

    /**
     * Use the Stockdepot relation Stockdepot object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StockdepotQuery A secondary query class using the current class as primary query
     */
    public function useStockdepotQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStockdepot($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Stockdepot', '\StockdepotQuery');
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
            $this->addCond('pruneCond0', $this->getAliasedColName(PieceTableMap::COL_ID), $piece->getID(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PieceTableMap::COL_REFERENCE), $piece->getReference(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
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
