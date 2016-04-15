<?php

namespace Base;

use \Souscategorie as ChildSouscategorie;
use \SouscategorieQuery as ChildSouscategorieQuery;
use \Exception;
use \PDO;
use Map\SouscategorieTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sous_categorie' table.
 *
 *
 *
 * @method     ChildSouscategorieQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildSouscategorieQuery orderBySouscategorie($order = Criteria::ASC) Order by the sous_categorie column
 * @method     ChildSouscategorieQuery orderByIDCategorie_FK($order = Criteria::ASC) Order by the id_categorie_FK column
 * @method     ChildSouscategorieQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 * @method     ChildSouscategorieQuery orderByOrdre($order = Criteria::ASC) Order by the ordre column
 * @method     ChildSouscategorieQuery orderByURL($order = Criteria::ASC) Order by the url column
 *
 * @method     ChildSouscategorieQuery groupByID() Group by the id column
 * @method     ChildSouscategorieQuery groupBySouscategorie() Group by the sous_categorie column
 * @method     ChildSouscategorieQuery groupByIDCategorie_FK() Group by the id_categorie_FK column
 * @method     ChildSouscategorieQuery groupByCommentaire() Group by the commentaire column
 * @method     ChildSouscategorieQuery groupByOrdre() Group by the ordre column
 * @method     ChildSouscategorieQuery groupByURL() Group by the url column
 *
 * @method     ChildSouscategorieQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSouscategorieQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSouscategorieQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSouscategorieQuery leftJoinCategorie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Categorie relation
 * @method     ChildSouscategorieQuery rightJoinCategorie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Categorie relation
 * @method     ChildSouscategorieQuery innerJoinCategorie($relationAlias = null) Adds a INNER JOIN clause to the query using the Categorie relation
 *
 * @method     ChildSouscategorieQuery leftJoinMedia($relationAlias = null) Adds a LEFT JOIN clause to the query using the Media relation
 * @method     ChildSouscategorieQuery rightJoinMedia($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Media relation
 * @method     ChildSouscategorieQuery innerJoinMedia($relationAlias = null) Adds a INNER JOIN clause to the query using the Media relation
 *
 * @method     ChildSouscategorieQuery leftJoinArticle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Article relation
 * @method     ChildSouscategorieQuery rightJoinArticle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Article relation
 * @method     ChildSouscategorieQuery innerJoinArticle($relationAlias = null) Adds a INNER JOIN clause to the query using the Article relation
 *
 * @method     \CategorieQuery|\MediaQuery|\ArticleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSouscategorie findOne(ConnectionInterface $con = null) Return the first ChildSouscategorie matching the query
 * @method     ChildSouscategorie findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSouscategorie matching the query, or a new ChildSouscategorie object populated from the query conditions when no match is found
 *
 * @method     ChildSouscategorie findOneByID(int $id) Return the first ChildSouscategorie filtered by the id column
 * @method     ChildSouscategorie findOneBySouscategorie(string $sous_categorie) Return the first ChildSouscategorie filtered by the sous_categorie column
 * @method     ChildSouscategorie findOneByIDCategorie_FK(int $id_categorie_FK) Return the first ChildSouscategorie filtered by the id_categorie_FK column
 * @method     ChildSouscategorie findOneByCommentaire(string $commentaire) Return the first ChildSouscategorie filtered by the commentaire column
 * @method     ChildSouscategorie findOneByOrdre(int $ordre) Return the first ChildSouscategorie filtered by the ordre column
 * @method     ChildSouscategorie findOneByURL(string $url) Return the first ChildSouscategorie filtered by the url column *

 * @method     ChildSouscategorie requirePk($key, ConnectionInterface $con = null) Return the ChildSouscategorie by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSouscategorie requireOne(ConnectionInterface $con = null) Return the first ChildSouscategorie matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSouscategorie requireOneByID(int $id) Return the first ChildSouscategorie filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSouscategorie requireOneBySouscategorie(string $sous_categorie) Return the first ChildSouscategorie filtered by the sous_categorie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSouscategorie requireOneByIDCategorie_FK(int $id_categorie_FK) Return the first ChildSouscategorie filtered by the id_categorie_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSouscategorie requireOneByCommentaire(string $commentaire) Return the first ChildSouscategorie filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSouscategorie requireOneByOrdre(int $ordre) Return the first ChildSouscategorie filtered by the ordre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSouscategorie requireOneByURL(string $url) Return the first ChildSouscategorie filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSouscategorie[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSouscategorie objects based on current ModelCriteria
 * @method     ChildSouscategorie[]|ObjectCollection findByID(int $id) Return ChildSouscategorie objects filtered by the id column
 * @method     ChildSouscategorie[]|ObjectCollection findBySouscategorie(string $sous_categorie) Return ChildSouscategorie objects filtered by the sous_categorie column
 * @method     ChildSouscategorie[]|ObjectCollection findByIDCategorie_FK(int $id_categorie_FK) Return ChildSouscategorie objects filtered by the id_categorie_FK column
 * @method     ChildSouscategorie[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildSouscategorie objects filtered by the commentaire column
 * @method     ChildSouscategorie[]|ObjectCollection findByOrdre(int $ordre) Return ChildSouscategorie objects filtered by the ordre column
 * @method     ChildSouscategorie[]|ObjectCollection findByURL(string $url) Return ChildSouscategorie objects filtered by the url column
 * @method     ChildSouscategorie[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SouscategorieQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SouscategorieQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Souscategorie', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSouscategorieQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSouscategorieQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSouscategorieQuery) {
            return $criteria;
        }
        $query = new ChildSouscategorieQuery();
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
     * @return ChildSouscategorie|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SouscategorieTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SouscategorieTableMap::DATABASE_NAME);
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
     * @return ChildSouscategorie A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, sous_categorie, id_categorie_FK, commentaire, ordre, url FROM sous_categorie WHERE id = :p0';
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
            /** @var ChildSouscategorie $obj */
            $obj = new ChildSouscategorie();
            $obj->hydrate($row);
            SouscategorieTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSouscategorie|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SouscategorieTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SouscategorieTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(SouscategorieTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(SouscategorieTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SouscategorieTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the sous_categorie column
     *
     * Example usage:
     * <code>
     * $query->filterBySouscategorie('fooValue');   // WHERE sous_categorie = 'fooValue'
     * $query->filterBySouscategorie('%fooValue%'); // WHERE sous_categorie LIKE '%fooValue%'
     * </code>
     *
     * @param     string $souscategorie The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterBySouscategorie($souscategorie = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($souscategorie)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $souscategorie)) {
                $souscategorie = str_replace('*', '%', $souscategorie);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SouscategorieTableMap::COL_SOUS_CATEGORIE, $souscategorie, $comparison);
    }

    /**
     * Filter the query on the id_categorie_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIDCategorie_FK(1234); // WHERE id_categorie_FK = 1234
     * $query->filterByIDCategorie_FK(array(12, 34)); // WHERE id_categorie_FK IN (12, 34)
     * $query->filterByIDCategorie_FK(array('min' => 12)); // WHERE id_categorie_FK > 12
     * </code>
     *
     * @see       filterByCategorie()
     *
     * @param     mixed $iDCategorie_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterByIDCategorie_FK($iDCategorie_FK = null, $comparison = null)
    {
        if (is_array($iDCategorie_FK)) {
            $useMinMax = false;
            if (isset($iDCategorie_FK['min'])) {
                $this->addUsingAlias(SouscategorieTableMap::COL_ID_CATEGORIE_FK, $iDCategorie_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDCategorie_FK['max'])) {
                $this->addUsingAlias(SouscategorieTableMap::COL_ID_CATEGORIE_FK, $iDCategorie_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SouscategorieTableMap::COL_ID_CATEGORIE_FK, $iDCategorie_FK, $comparison);
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
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SouscategorieTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
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
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterByOrdre($ordre = null, $comparison = null)
    {
        if (is_array($ordre)) {
            $useMinMax = false;
            if (isset($ordre['min'])) {
                $this->addUsingAlias(SouscategorieTableMap::COL_ORDRE, $ordre['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ordre['max'])) {
                $this->addUsingAlias(SouscategorieTableMap::COL_ORDRE, $ordre['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SouscategorieTableMap::COL_ORDRE, $ordre, $comparison);
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
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SouscategorieTableMap::COL_URL, $uRL, $comparison);
    }

    /**
     * Filter the query by a related \Categorie object
     *
     * @param \Categorie|ObjectCollection $categorie The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterByCategorie($categorie, $comparison = null)
    {
        if ($categorie instanceof \Categorie) {
            return $this
                ->addUsingAlias(SouscategorieTableMap::COL_ID_CATEGORIE_FK, $categorie->getID(), $comparison);
        } elseif ($categorie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SouscategorieTableMap::COL_ID_CATEGORIE_FK, $categorie->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
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
     * Filter the query by a related \Media object
     *
     * @param \Media|ObjectCollection $media the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterByMedia($media, $comparison = null)
    {
        if ($media instanceof \Media) {
            return $this
                ->addUsingAlias(SouscategorieTableMap::COL_SOUS_CATEGORIE, $media->getSouscategorie_FK(), $comparison);
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
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
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
     * Filter the query by a related \Article object
     *
     * @param \Article|ObjectCollection $article the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSouscategorieQuery The current query, for fluid interface
     */
    public function filterByArticle($article, $comparison = null)
    {
        if ($article instanceof \Article) {
            return $this
                ->addUsingAlias(SouscategorieTableMap::COL_SOUS_CATEGORIE, $article->getSouscategorie_FK(), $comparison);
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
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
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
     * @param   ChildSouscategorie $souscategorie Object to remove from the list of results
     *
     * @return $this|ChildSouscategorieQuery The current query, for fluid interface
     */
    public function prune($souscategorie = null)
    {
        if ($souscategorie) {
            $this->addUsingAlias(SouscategorieTableMap::COL_ID, $souscategorie->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sous_categorie table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SouscategorieTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SouscategorieTableMap::clearInstancePool();
            SouscategorieTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SouscategorieTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SouscategorieTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SouscategorieTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SouscategorieTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SouscategorieQuery
