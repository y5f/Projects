<?php

namespace Base;

use \Categorie as ChildCategorie;
use \CategorieQuery as ChildCategorieQuery;
use \Exception;
use \PDO;
use Map\CategorieTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'categorie' table.
 *
 *
 *
 * @method     ChildCategorieQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildCategorieQuery orderByCategorie($order = Criteria::ASC) Order by the categorie column
 * @method     ChildCategorieQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 * @method     ChildCategorieQuery orderByNiveau($order = Criteria::ASC) Order by the niveau column
 * @method     ChildCategorieQuery orderByOrdre($order = Criteria::ASC) Order by the ordre column
 * @method     ChildCategorieQuery orderByURL($order = Criteria::ASC) Order by the url column
 *
 * @method     ChildCategorieQuery groupByID() Group by the id column
 * @method     ChildCategorieQuery groupByCategorie() Group by the categorie column
 * @method     ChildCategorieQuery groupByCommentaire() Group by the commentaire column
 * @method     ChildCategorieQuery groupByNiveau() Group by the niveau column
 * @method     ChildCategorieQuery groupByOrdre() Group by the ordre column
 * @method     ChildCategorieQuery groupByURL() Group by the url column
 *
 * @method     ChildCategorieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCategorieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCategorieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCategorieQuery leftJoinMedia($relationAlias = null) Adds a LEFT JOIN clause to the query using the Media relation
 * @method     ChildCategorieQuery rightJoinMedia($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Media relation
 * @method     ChildCategorieQuery innerJoinMedia($relationAlias = null) Adds a INNER JOIN clause to the query using the Media relation
 *
 * @method     ChildCategorieQuery leftJoinSouscategorie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Souscategorie relation
 * @method     ChildCategorieQuery rightJoinSouscategorie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Souscategorie relation
 * @method     ChildCategorieQuery innerJoinSouscategorie($relationAlias = null) Adds a INNER JOIN clause to the query using the Souscategorie relation
 *
 * @method     ChildCategorieQuery leftJoinArticle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Article relation
 * @method     ChildCategorieQuery rightJoinArticle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Article relation
 * @method     ChildCategorieQuery innerJoinArticle($relationAlias = null) Adds a INNER JOIN clause to the query using the Article relation
 *
 * @method     \MediaQuery|\SouscategorieQuery|\ArticleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCategorie findOne(ConnectionInterface $con = null) Return the first ChildCategorie matching the query
 * @method     ChildCategorie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCategorie matching the query, or a new ChildCategorie object populated from the query conditions when no match is found
 *
 * @method     ChildCategorie findOneByID(int $id) Return the first ChildCategorie filtered by the id column
 * @method     ChildCategorie findOneByCategorie(string $categorie) Return the first ChildCategorie filtered by the categorie column
 * @method     ChildCategorie findOneByCommentaire(string $commentaire) Return the first ChildCategorie filtered by the commentaire column
 * @method     ChildCategorie findOneByNiveau(int $niveau) Return the first ChildCategorie filtered by the niveau column
 * @method     ChildCategorie findOneByOrdre(int $ordre) Return the first ChildCategorie filtered by the ordre column
 * @method     ChildCategorie findOneByURL(string $url) Return the first ChildCategorie filtered by the url column *

 * @method     ChildCategorie requirePk($key, ConnectionInterface $con = null) Return the ChildCategorie by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategorie requireOne(ConnectionInterface $con = null) Return the first ChildCategorie matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCategorie requireOneByID(int $id) Return the first ChildCategorie filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategorie requireOneByCategorie(string $categorie) Return the first ChildCategorie filtered by the categorie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategorie requireOneByCommentaire(string $commentaire) Return the first ChildCategorie filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategorie requireOneByNiveau(int $niveau) Return the first ChildCategorie filtered by the niveau column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategorie requireOneByOrdre(int $ordre) Return the first ChildCategorie filtered by the ordre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategorie requireOneByURL(string $url) Return the first ChildCategorie filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCategorie[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCategorie objects based on current ModelCriteria
 * @method     ChildCategorie[]|ObjectCollection findByID(int $id) Return ChildCategorie objects filtered by the id column
 * @method     ChildCategorie[]|ObjectCollection findByCategorie(string $categorie) Return ChildCategorie objects filtered by the categorie column
 * @method     ChildCategorie[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildCategorie objects filtered by the commentaire column
 * @method     ChildCategorie[]|ObjectCollection findByNiveau(int $niveau) Return ChildCategorie objects filtered by the niveau column
 * @method     ChildCategorie[]|ObjectCollection findByOrdre(int $ordre) Return ChildCategorie objects filtered by the ordre column
 * @method     ChildCategorie[]|ObjectCollection findByURL(string $url) Return ChildCategorie objects filtered by the url column
 * @method     ChildCategorie[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CategorieQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CategorieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Categorie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCategorieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCategorieQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCategorieQuery) {
            return $criteria;
        }
        $query = new ChildCategorieQuery();
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
     * @return ChildCategorie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CategorieTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CategorieTableMap::DATABASE_NAME);
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
     * @return ChildCategorie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, categorie, commentaire, niveau, ordre, url FROM categorie WHERE id = :p0';
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
            /** @var ChildCategorie $obj */
            $obj = new ChildCategorie();
            $obj->hydrate($row);
            CategorieTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCategorie|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CategorieTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CategorieTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(CategorieTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(CategorieTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CategorieTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the categorie column
     *
     * Example usage:
     * <code>
     * $query->filterByCategorie('fooValue');   // WHERE categorie = 'fooValue'
     * $query->filterByCategorie('%fooValue%'); // WHERE categorie LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categorie The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function filterByCategorie($categorie = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categorie)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categorie)) {
                $categorie = str_replace('*', '%', $categorie);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CategorieTableMap::COL_CATEGORIE, $categorie, $comparison);
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
     * @return $this|ChildCategorieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CategorieTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
    }

    /**
     * Filter the query on the niveau column
     *
     * Example usage:
     * <code>
     * $query->filterByNiveau(1234); // WHERE niveau = 1234
     * $query->filterByNiveau(array(12, 34)); // WHERE niveau IN (12, 34)
     * $query->filterByNiveau(array('min' => 12)); // WHERE niveau > 12
     * </code>
     *
     * @param     mixed $niveau The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function filterByNiveau($niveau = null, $comparison = null)
    {
        if (is_array($niveau)) {
            $useMinMax = false;
            if (isset($niveau['min'])) {
                $this->addUsingAlias(CategorieTableMap::COL_NIVEAU, $niveau['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($niveau['max'])) {
                $this->addUsingAlias(CategorieTableMap::COL_NIVEAU, $niveau['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CategorieTableMap::COL_NIVEAU, $niveau, $comparison);
    }

    /**
     * Filter the query on the ordre column
     *
     * Example usage:
     * <code>
     * $query->filterByOrdre(1234); // WHERE ordre = 1234
     * $query->filterByOrdre(array(12, 34)); // WHERE ordre IN (12, 34)
     * $query->filterByOrdre(array('min' => 12)); // WHERE ordre > 12
     * </code>
     *
     * @param     mixed $ordre The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function filterByOrdre($ordre = null, $comparison = null)
    {
        if (is_array($ordre)) {
            $useMinMax = false;
            if (isset($ordre['min'])) {
                $this->addUsingAlias(CategorieTableMap::COL_ORDRE, $ordre['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ordre['max'])) {
                $this->addUsingAlias(CategorieTableMap::COL_ORDRE, $ordre['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CategorieTableMap::COL_ORDRE, $ordre, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByURL('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByURL('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uRL The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCategorieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CategorieTableMap::COL_URL, $uRL, $comparison);
    }

    /**
     * Filter the query by a related \Media object
     *
     * @param \Media|ObjectCollection $media the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCategorieQuery The current query, for fluid interface
     */
    public function filterByMedia($media, $comparison = null)
    {
        if ($media instanceof \Media) {
            return $this
                ->addUsingAlias(CategorieTableMap::COL_CATEGORIE, $media->getCategorie_FK(), $comparison);
        } elseif ($media instanceof ObjectCollection) {
            return $this
                ->useMediaQuery()
                ->filterByPrimaryKeys($media->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMedia() only accepts arguments of type \Media or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Media relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function joinMedia($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Media');

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
            $this->addJoinObject($join, 'Media');
        }

        return $this;
    }

    /**
     * Use the Media relation Media object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MediaQuery A secondary query class using the current class as primary query
     */
    public function useMediaQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMedia($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Media', '\MediaQuery');
    }

    /**
     * Filter the query by a related \Souscategorie object
     *
     * @param \Souscategorie|ObjectCollection $souscategorie the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCategorieQuery The current query, for fluid interface
     */
    public function filterBySouscategorie($souscategorie, $comparison = null)
    {
        if ($souscategorie instanceof \Souscategorie) {
            return $this
                ->addUsingAlias(CategorieTableMap::COL_ID, $souscategorie->getIDCategorie_FK(), $comparison);
        } elseif ($souscategorie instanceof ObjectCollection) {
            return $this
                ->useSouscategorieQuery()
                ->filterByPrimaryKeys($souscategorie->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCategorieQuery The current query, for fluid interface
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
     * Filter the query by a related \Article object
     *
     * @param \Article|ObjectCollection $article the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCategorieQuery The current query, for fluid interface
     */
    public function filterByArticle($article, $comparison = null)
    {
        if ($article instanceof \Article) {
            return $this
                ->addUsingAlias(CategorieTableMap::COL_CATEGORIE, $article->getCategorie_FK(), $comparison);
        } elseif ($article instanceof ObjectCollection) {
            return $this
                ->useArticleQuery()
                ->filterByPrimaryKeys($article->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function joinArticle($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useArticleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArticle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Article', '\ArticleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCategorie $categorie Object to remove from the list of results
     *
     * @return $this|ChildCategorieQuery The current query, for fluid interface
     */
    public function prune($categorie = null)
    {
        if ($categorie) {
            $this->addUsingAlias(CategorieTableMap::COL_ID, $categorie->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the categorie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CategorieTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CategorieTableMap::clearInstancePool();
            CategorieTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CategorieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CategorieTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CategorieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CategorieTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CategorieQuery