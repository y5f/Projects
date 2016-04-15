<?php

namespace Base;

use \Widget as ChildWidget;
use \WidgetQuery as ChildWidgetQuery;
use \Exception;
use \PDO;
use Map\WidgetTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'widget' table.
 *
 *
 *
 * @method     ChildWidgetQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildWidgetQuery orderByNumbloc($order = Criteria::ASC) Order by the num_bloc column
 * @method     ChildWidgetQuery orderByNumarticle($order = Criteria::ASC) Order by the num_art column
 *
 * @method     ChildWidgetQuery groupByID() Group by the id column
 * @method     ChildWidgetQuery groupByNumbloc() Group by the num_bloc column
 * @method     ChildWidgetQuery groupByNumarticle() Group by the num_art column
 *
 * @method     ChildWidgetQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWidgetQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWidgetQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWidgetQuery leftJoinArticle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Article relation
 * @method     ChildWidgetQuery rightJoinArticle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Article relation
 * @method     ChildWidgetQuery innerJoinArticle($relationAlias = null) Adds a INNER JOIN clause to the query using the Article relation
 *
 * @method     \ArticleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWidget findOne(ConnectionInterface $con = null) Return the first ChildWidget matching the query
 * @method     ChildWidget findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWidget matching the query, or a new ChildWidget object populated from the query conditions when no match is found
 *
 * @method     ChildWidget findOneByID(int $id) Return the first ChildWidget filtered by the id column
 * @method     ChildWidget findOneByNumbloc(int $num_bloc) Return the first ChildWidget filtered by the num_bloc column
 * @method     ChildWidget findOneByNumarticle(int $num_art) Return the first ChildWidget filtered by the num_art column *

 * @method     ChildWidget requirePk($key, ConnectionInterface $con = null) Return the ChildWidget by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWidget requireOne(ConnectionInterface $con = null) Return the first ChildWidget matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWidget requireOneByID(int $id) Return the first ChildWidget filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWidget requireOneByNumbloc(int $num_bloc) Return the first ChildWidget filtered by the num_bloc column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWidget requireOneByNumarticle(int $num_art) Return the first ChildWidget filtered by the num_art column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWidget[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildWidget objects based on current ModelCriteria
 * @method     ChildWidget[]|ObjectCollection findByID(int $id) Return ChildWidget objects filtered by the id column
 * @method     ChildWidget[]|ObjectCollection findByNumbloc(int $num_bloc) Return ChildWidget objects filtered by the num_bloc column
 * @method     ChildWidget[]|ObjectCollection findByNumarticle(int $num_art) Return ChildWidget objects filtered by the num_art column
 * @method     ChildWidget[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class WidgetQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\WidgetQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Widget', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWidgetQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWidgetQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildWidgetQuery) {
            return $criteria;
        }
        $query = new ChildWidgetQuery();
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
     * @return ChildWidget|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WidgetTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WidgetTableMap::DATABASE_NAME);
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
     * @return ChildWidget A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, num_bloc, num_art FROM widget WHERE id = :p0';
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
            /** @var ChildWidget $obj */
            $obj = new ChildWidget();
            $obj->hydrate($row);
            WidgetTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildWidget|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildWidgetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WidgetTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildWidgetQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WidgetTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildWidgetQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(WidgetTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(WidgetTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WidgetTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the num_bloc column
     *
     * Example usage:
     * <code>
     * $query->filterByNumbloc(1234); // WHERE num_bloc = 1234
     * $query->filterByNumbloc(array(12, 34)); // WHERE num_bloc IN (12, 34)
     * $query->filterByNumbloc(array('min' => 12)); // WHERE num_bloc > 12
     * </code>
     *
     * @param     mixed $numbloc The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWidgetQuery The current query, for fluid interface
     */
    public function filterByNumbloc($numbloc = null, $comparison = null)
    {
        if (is_array($numbloc)) {
            $useMinMax = false;
            if (isset($numbloc['min'])) {
                $this->addUsingAlias(WidgetTableMap::COL_NUM_BLOC, $numbloc['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numbloc['max'])) {
                $this->addUsingAlias(WidgetTableMap::COL_NUM_BLOC, $numbloc['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WidgetTableMap::COL_NUM_BLOC, $numbloc, $comparison);
    }

    /**
     * Filter the query on the num_art column
     *
     * Example usage:
     * <code>
     * $query->filterByNumarticle(1234); // WHERE num_art = 1234
     * $query->filterByNumarticle(array(12, 34)); // WHERE num_art IN (12, 34)
     * $query->filterByNumarticle(array('min' => 12)); // WHERE num_art > 12
     * </code>
     *
     * @see       filterByArticle()
     *
     * @param     mixed $numarticle The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWidgetQuery The current query, for fluid interface
     */
    public function filterByNumarticle($numarticle = null, $comparison = null)
    {
        if (is_array($numarticle)) {
            $useMinMax = false;
            if (isset($numarticle['min'])) {
                $this->addUsingAlias(WidgetTableMap::COL_NUM_ART, $numarticle['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numarticle['max'])) {
                $this->addUsingAlias(WidgetTableMap::COL_NUM_ART, $numarticle['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WidgetTableMap::COL_NUM_ART, $numarticle, $comparison);
    }

    /**
     * Filter the query by a related \Article object
     *
     * @param \Article|ObjectCollection $article The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWidgetQuery The current query, for fluid interface
     */
    public function filterByArticle($article, $comparison = null)
    {
        if ($article instanceof \Article) {
            return $this
                ->addUsingAlias(WidgetTableMap::COL_NUM_ART, $article->getNumart(), $comparison);
        } elseif ($article instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WidgetTableMap::COL_NUM_ART, $article->toKeyValue('PrimaryKey', 'Numart'), $comparison);
        } else {
            throw new PropelException('filterByArticle() only accepts arguments of type \Article or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Article relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWidgetQuery The current query, for fluid interface
     */
    public function joinArticle($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Article');

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
            $this->addJoinObject($join, 'Article');
        }

        return $this;
    }

    /**
     * Use the Article relation Article object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ArticleQuery A secondary query class using the current class as primary query
     */
    public function useArticleQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinArticle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Article', '\ArticleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWidget $widget Object to remove from the list of results
     *
     * @return $this|ChildWidgetQuery The current query, for fluid interface
     */
    public function prune($widget = null)
    {
        if ($widget) {
            $this->addUsingAlias(WidgetTableMap::COL_ID, $widget->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the widget table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WidgetTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WidgetTableMap::clearInstancePool();
            WidgetTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(WidgetTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WidgetTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WidgetTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WidgetTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // WidgetQuery
