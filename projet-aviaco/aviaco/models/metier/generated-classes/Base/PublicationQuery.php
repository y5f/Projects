<?php

namespace Base;

use \Publication as ChildPublication;
use \PublicationQuery as ChildPublicationQuery;
use \Exception;
use \PDO;
use Map\PublicationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'publication' table.
 *
 *
 *
 * @method     ChildPublicationQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildPublicationQuery orderByDatepublication($order = Criteria::ASC) Order by the date_pub column
 * @method     ChildPublicationQuery orderByEtat($order = Criteria::ASC) Order by the etat column
 * @method     ChildPublicationQuery orderByisSlider($order = Criteria::ASC) Order by the slider column
 * @method     ChildPublicationQuery orderByArt_num_PK($order = Criteria::ASC) Order by the art_num_PK column
 *
 * @method     ChildPublicationQuery groupByID() Group by the id column
 * @method     ChildPublicationQuery groupByDatepublication() Group by the date_pub column
 * @method     ChildPublicationQuery groupByEtat() Group by the etat column
 * @method     ChildPublicationQuery groupByisSlider() Group by the slider column
 * @method     ChildPublicationQuery groupByArt_num_PK() Group by the art_num_PK column
 *
 * @method     ChildPublicationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPublicationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPublicationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPublicationQuery leftJoinArticle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Article relation
 * @method     ChildPublicationQuery rightJoinArticle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Article relation
 * @method     ChildPublicationQuery innerJoinArticle($relationAlias = null) Adds a INNER JOIN clause to the query using the Article relation
 *
 * @method     \ArticleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPublication findOne(ConnectionInterface $con = null) Return the first ChildPublication matching the query
 * @method     ChildPublication findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPublication matching the query, or a new ChildPublication object populated from the query conditions when no match is found
 *
 * @method     ChildPublication findOneByID(int $id) Return the first ChildPublication filtered by the id column
 * @method     ChildPublication findOneByDatepublication(string $date_pub) Return the first ChildPublication filtered by the date_pub column
 * @method     ChildPublication findOneByEtat(boolean $etat) Return the first ChildPublication filtered by the etat column
 * @method     ChildPublication findOneByisSlider(boolean $slider) Return the first ChildPublication filtered by the slider column
 * @method     ChildPublication findOneByArt_num_PK(int $art_num_PK) Return the first ChildPublication filtered by the art_num_PK column *

 * @method     ChildPublication requirePk($key, ConnectionInterface $con = null) Return the ChildPublication by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOne(ConnectionInterface $con = null) Return the first ChildPublication matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPublication requireOneByID(int $id) Return the first ChildPublication filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByDatepublication(string $date_pub) Return the first ChildPublication filtered by the date_pub column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByEtat(boolean $etat) Return the first ChildPublication filtered by the etat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByisSlider(boolean $slider) Return the first ChildPublication filtered by the slider column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByArt_num_PK(int $art_num_PK) Return the first ChildPublication filtered by the art_num_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPublication[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPublication objects based on current ModelCriteria
 * @method     ChildPublication[]|ObjectCollection findByID(int $id) Return ChildPublication objects filtered by the id column
 * @method     ChildPublication[]|ObjectCollection findByDatepublication(string $date_pub) Return ChildPublication objects filtered by the date_pub column
 * @method     ChildPublication[]|ObjectCollection findByEtat(boolean $etat) Return ChildPublication objects filtered by the etat column
 * @method     ChildPublication[]|ObjectCollection findByisSlider(boolean $slider) Return ChildPublication objects filtered by the slider column
 * @method     ChildPublication[]|ObjectCollection findByArt_num_PK(int $art_num_PK) Return ChildPublication objects filtered by the art_num_PK column
 * @method     ChildPublication[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PublicationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PublicationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Publication', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPublicationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPublicationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPublicationQuery) {
            return $criteria;
        }
        $query = new ChildPublicationQuery();
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
     * @return ChildPublication|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PublicationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PublicationTableMap::DATABASE_NAME);
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
     * @return ChildPublication A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, date_pub, etat, slider, art_num_PK FROM publication WHERE id = :p0';
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
            /** @var ChildPublication $obj */
            $obj = new ChildPublication();
            $obj->hydrate($row);
            PublicationTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPublication|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PublicationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PublicationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the date_pub column
     *
     * Example usage:
     * <code>
     * $query->filterByDatepublication('2011-03-14'); // WHERE date_pub = '2011-03-14'
     * $query->filterByDatepublication('now'); // WHERE date_pub = '2011-03-14'
     * $query->filterByDatepublication(array('max' => 'yesterday')); // WHERE date_pub > '2011-03-13'
     * </code>
     *
     * @param     mixed $datepublication The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByDatepublication($datepublication = null, $comparison = null)
    {
        if (is_array($datepublication)) {
            $useMinMax = false;
            if (isset($datepublication['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_DATE_PUB, $datepublication['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datepublication['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_DATE_PUB, $datepublication['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_DATE_PUB, $datepublication, $comparison);
    }

    /**
     * Filter the query on the etat column
     *
     * Example usage:
     * <code>
     * $query->filterByEtat(true); // WHERE etat = true
     * $query->filterByEtat('yes'); // WHERE etat = true
     * </code>
     *
     * @param     boolean|string $etat The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByEtat($etat = null, $comparison = null)
    {
        if (is_string($etat)) {
            $etat = in_array(strtolower($etat), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PublicationTableMap::COL_ETAT, $etat, $comparison);
    }

    /**
     * Filter the query on the slider column
     *
     * Example usage:
     * <code>
     * $query->filterByisSlider(true); // WHERE slider = true
     * $query->filterByisSlider('yes'); // WHERE slider = true
     * </code>
     *
     * @param     boolean|string $isSlider The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByisSlider($isSlider = null, $comparison = null)
    {
        if (is_string($isSlider)) {
            $isSlider = in_array(strtolower($isSlider), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PublicationTableMap::COL_SLIDER, $isSlider, $comparison);
    }

    /**
     * Filter the query on the art_num_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByArt_num_PK(1234); // WHERE art_num_PK = 1234
     * $query->filterByArt_num_PK(array(12, 34)); // WHERE art_num_PK IN (12, 34)
     * $query->filterByArt_num_PK(array('min' => 12)); // WHERE art_num_PK > 12
     * </code>
     *
     * @see       filterByArticle()
     *
     * @param     mixed $art_num_PK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByArt_num_PK($art_num_PK = null, $comparison = null)
    {
        if (is_array($art_num_PK)) {
            $useMinMax = false;
            if (isset($art_num_PK['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_ART_NUM_PK, $art_num_PK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($art_num_PK['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_ART_NUM_PK, $art_num_PK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_ART_NUM_PK, $art_num_PK, $comparison);
    }

    /**
     * Filter the query by a related \Article object
     *
     * @param \Article|ObjectCollection $article The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByArticle($article, $comparison = null)
    {
        if ($article instanceof \Article) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_ART_NUM_PK, $article->getNumart(), $comparison);
        } elseif ($article instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PublicationTableMap::COL_ART_NUM_PK, $article->toKeyValue('PrimaryKey', 'Numart'), $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
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
     * @param   ChildPublication $publication Object to remove from the list of results
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function prune($publication = null)
    {
        if ($publication) {
            $this->addUsingAlias(PublicationTableMap::COL_ID, $publication->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the publication table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PublicationTableMap::clearInstancePool();
            PublicationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PublicationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PublicationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PublicationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PublicationQuery
