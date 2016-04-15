<?php

namespace Base;

use \Media as ChildMedia;
use \MediaQuery as ChildMediaQuery;
use \Exception;
use \PDO;
use Map\MediaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'media' table.
 *
 *
 *
 * @method     ChildMediaQuery orderByMedianum($order = Criteria::ASC) Order by the media_num column
 * @method     ChildMediaQuery orderByMediadate($order = Criteria::ASC) Order by the media_date column
 * @method     ChildMediaQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildMediaQuery orderByURL($order = Criteria::ASC) Order by the media_url column
 * @method     ChildMediaQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 * @method     ChildMediaQuery orderByCategorie_FK($order = Criteria::ASC) Order by the cat_FK column
 * @method     ChildMediaQuery orderBySouscategorie_FK($order = Criteria::ASC) Order by the s_cat_FK column
 *
 * @method     ChildMediaQuery groupByMedianum() Group by the media_num column
 * @method     ChildMediaQuery groupByMediadate() Group by the media_date column
 * @method     ChildMediaQuery groupByDescription() Group by the description column
 * @method     ChildMediaQuery groupByURL() Group by the media_url column
 * @method     ChildMediaQuery groupByCommentaire() Group by the commentaire column
 * @method     ChildMediaQuery groupByCategorie_FK() Group by the cat_FK column
 * @method     ChildMediaQuery groupBySouscategorie_FK() Group by the s_cat_FK column
 *
 * @method     ChildMediaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMediaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMediaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMediaQuery leftJoinCategorie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Categorie relation
 * @method     ChildMediaQuery rightJoinCategorie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Categorie relation
 * @method     ChildMediaQuery innerJoinCategorie($relationAlias = null) Adds a INNER JOIN clause to the query using the Categorie relation
 *
 * @method     ChildMediaQuery leftJoinSouscategorie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Souscategorie relation
 * @method     ChildMediaQuery rightJoinSouscategorie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Souscategorie relation
 * @method     ChildMediaQuery innerJoinSouscategorie($relationAlias = null) Adds a INNER JOIN clause to the query using the Souscategorie relation
 *
 * @method     \CategorieQuery|\SouscategorieQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMedia findOne(ConnectionInterface $con = null) Return the first ChildMedia matching the query
 * @method     ChildMedia findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMedia matching the query, or a new ChildMedia object populated from the query conditions when no match is found
 *
 * @method     ChildMedia findOneByMedianum(int $media_num) Return the first ChildMedia filtered by the media_num column
 * @method     ChildMedia findOneByMediadate(string $media_date) Return the first ChildMedia filtered by the media_date column
 * @method     ChildMedia findOneByDescription(string $description) Return the first ChildMedia filtered by the description column
 * @method     ChildMedia findOneByURL(string $media_url) Return the first ChildMedia filtered by the media_url column
 * @method     ChildMedia findOneByCommentaire(string $commentaire) Return the first ChildMedia filtered by the commentaire column
 * @method     ChildMedia findOneByCategorie_FK(string $cat_FK) Return the first ChildMedia filtered by the cat_FK column
 * @method     ChildMedia findOneBySouscategorie_FK(string $s_cat_FK) Return the first ChildMedia filtered by the s_cat_FK column *

 * @method     ChildMedia requirePk($key, ConnectionInterface $con = null) Return the ChildMedia by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedia requireOne(ConnectionInterface $con = null) Return the first ChildMedia matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMedia requireOneByMedianum(int $media_num) Return the first ChildMedia filtered by the media_num column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedia requireOneByMediadate(string $media_date) Return the first ChildMedia filtered by the media_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedia requireOneByDescription(string $description) Return the first ChildMedia filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedia requireOneByURL(string $media_url) Return the first ChildMedia filtered by the media_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedia requireOneByCommentaire(string $commentaire) Return the first ChildMedia filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedia requireOneByCategorie_FK(string $cat_FK) Return the first ChildMedia filtered by the cat_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedia requireOneBySouscategorie_FK(string $s_cat_FK) Return the first ChildMedia filtered by the s_cat_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMedia[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMedia objects based on current ModelCriteria
 * @method     ChildMedia[]|ObjectCollection findByMedianum(int $media_num) Return ChildMedia objects filtered by the media_num column
 * @method     ChildMedia[]|ObjectCollection findByMediadate(string $media_date) Return ChildMedia objects filtered by the media_date column
 * @method     ChildMedia[]|ObjectCollection findByDescription(string $description) Return ChildMedia objects filtered by the description column
 * @method     ChildMedia[]|ObjectCollection findByURL(string $media_url) Return ChildMedia objects filtered by the media_url column
 * @method     ChildMedia[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildMedia objects filtered by the commentaire column
 * @method     ChildMedia[]|ObjectCollection findByCategorie_FK(string $cat_FK) Return ChildMedia objects filtered by the cat_FK column
 * @method     ChildMedia[]|ObjectCollection findBySouscategorie_FK(string $s_cat_FK) Return ChildMedia objects filtered by the s_cat_FK column
 * @method     ChildMedia[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MediaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MediaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Media', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMediaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMediaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMediaQuery) {
            return $criteria;
        }
        $query = new ChildMediaQuery();
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
     * @return ChildMedia|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MediaTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MediaTableMap::DATABASE_NAME);
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
     * @return ChildMedia A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT media_num, media_date, description, media_url, commentaire, cat_FK, s_cat_FK FROM media WHERE media_num = :p0';
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
            /** @var ChildMedia $obj */
            $obj = new ChildMedia();
            $obj->hydrate($row);
            MediaTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMedia|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MediaTableMap::COL_MEDIA_NUM, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MediaTableMap::COL_MEDIA_NUM, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the media_num column
     *
     * Example usage:
     * <code>
     * $query->filterByMedianum(1234); // WHERE media_num = 1234
     * $query->filterByMedianum(array(12, 34)); // WHERE media_num IN (12, 34)
     * $query->filterByMedianum(array('min' => 12)); // WHERE media_num > 12
     * </code>
     *
     * @param     mixed $medianum The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function filterByMedianum($medianum = null, $comparison = null)
    {
        if (is_array($medianum)) {
            $useMinMax = false;
            if (isset($medianum['min'])) {
                $this->addUsingAlias(MediaTableMap::COL_MEDIA_NUM, $medianum['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($medianum['max'])) {
                $this->addUsingAlias(MediaTableMap::COL_MEDIA_NUM, $medianum['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MediaTableMap::COL_MEDIA_NUM, $medianum, $comparison);
    }

    /**
     * Filter the query on the media_date column
     *
     * Example usage:
     * <code>
     * $query->filterByMediadate('2011-03-14'); // WHERE media_date = '2011-03-14'
     * $query->filterByMediadate('now'); // WHERE media_date = '2011-03-14'
     * $query->filterByMediadate(array('max' => 'yesterday')); // WHERE media_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $mediadate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function filterByMediadate($mediadate = null, $comparison = null)
    {
        if (is_array($mediadate)) {
            $useMinMax = false;
            if (isset($mediadate['min'])) {
                $this->addUsingAlias(MediaTableMap::COL_MEDIA_DATE, $mediadate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mediadate['max'])) {
                $this->addUsingAlias(MediaTableMap::COL_MEDIA_DATE, $mediadate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MediaTableMap::COL_MEDIA_DATE, $mediadate, $comparison);
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
     * @return $this|ChildMediaQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MediaTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the media_url column
     *
     * Example usage:
     * <code>
     * $query->filterByURL('fooValue');   // WHERE media_url = 'fooValue'
     * $query->filterByURL('%fooValue%'); // WHERE media_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uRL The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function filterByURL($uRL = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uRL)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $uRL)) {
                $uRL = str_replace('*', '%', $uRL);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MediaTableMap::COL_MEDIA_URL, $uRL, $comparison);
    }

    /**
     * Filter the query on the commentaire column
     *
     * Example usage:
     * <code>
     * $query->filterByCommentaire('fooValue');   // WHERE commentaire = 'fooValue'
     * $query->filterByCommentaire('%fooValue%'); // WHERE commentaire LIKE '%fooValue%'
     * </code>
     *
     * @param     string $commentaire The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MediaTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
    }

    /**
     * Filter the query on the cat_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByCategorie_FK('fooValue');   // WHERE cat_FK = 'fooValue'
     * $query->filterByCategorie_FK('%fooValue%'); // WHERE cat_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categorie_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function filterByCategorie_FK($categorie_FK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categorie_FK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categorie_FK)) {
                $categorie_FK = str_replace('*', '%', $categorie_FK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MediaTableMap::COL_CAT_FK, $categorie_FK, $comparison);
    }

    /**
     * Filter the query on the s_cat_FK column
     *
     * Example usage:
     * <code>
     * $query->filterBySouscategorie_FK('fooValue');   // WHERE s_cat_FK = 'fooValue'
     * $query->filterBySouscategorie_FK('%fooValue%'); // WHERE s_cat_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $souscategorie_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function filterBySouscategorie_FK($souscategorie_FK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($souscategorie_FK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $souscategorie_FK)) {
                $souscategorie_FK = str_replace('*', '%', $souscategorie_FK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MediaTableMap::COL_S_CAT_FK, $souscategorie_FK, $comparison);
    }

    /**
     * Filter the query by a related \Categorie object
     *
     * @param \Categorie|ObjectCollection $categorie The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMediaQuery The current query, for fluid interface
     */
    public function filterByCategorie($categorie, $comparison = null)
    {
        if ($categorie instanceof \Categorie) {
            return $this
                ->addUsingAlias(MediaTableMap::COL_CAT_FK, $categorie->getCategorie(), $comparison);
        } elseif ($categorie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MediaTableMap::COL_CAT_FK, $categorie->toKeyValue('PrimaryKey', 'Categorie'), $comparison);
        } else {
            throw new PropelException('filterByCategorie() only accepts arguments of type \Categorie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Categorie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function joinCategorie($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Categorie');

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
            $this->addJoinObject($join, 'Categorie');
        }

        return $this;
    }

    /**
     * Use the Categorie relation Categorie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CategorieQuery A secondary query class using the current class as primary query
     */
    public function useCategorieQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCategorie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Categorie', '\CategorieQuery');
    }

    /**
     * Filter the query by a related \Souscategorie object
     *
     * @param \Souscategorie|ObjectCollection $souscategorie The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMediaQuery The current query, for fluid interface
     */
    public function filterBySouscategorie($souscategorie, $comparison = null)
    {
        if ($souscategorie instanceof \Souscategorie) {
            return $this
                ->addUsingAlias(MediaTableMap::COL_S_CAT_FK, $souscategorie->getSouscategorie(), $comparison);
        } elseif ($souscategorie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MediaTableMap::COL_S_CAT_FK, $souscategorie->toKeyValue('PrimaryKey', 'Souscategorie'), $comparison);
        } else {
            throw new PropelException('filterBySouscategorie() only accepts arguments of type \Souscategorie or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Souscategorie relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function joinSouscategorie($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Souscategorie');

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
            $this->addJoinObject($join, 'Souscategorie');
        }

        return $this;
    }

    /**
     * Use the Souscategorie relation Souscategorie object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SouscategorieQuery A secondary query class using the current class as primary query
     */
    public function useSouscategorieQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSouscategorie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Souscategorie', '\SouscategorieQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMedia $media Object to remove from the list of results
     *
     * @return $this|ChildMediaQuery The current query, for fluid interface
     */
    public function prune($media = null)
    {
        if ($media) {
            $this->addUsingAlias(MediaTableMap::COL_MEDIA_NUM, $media->getMedianum(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the media table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MediaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MediaTableMap::clearInstancePool();
            MediaTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MediaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MediaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MediaTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MediaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MediaQuery
