<?php

namespace Base;

use \Article as ChildArticle;
use \ArticleQuery as ChildArticleQuery;
use \Exception;
use \PDO;
use Map\ArticleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'article' table.
 *
 *
 *
 * @method     ChildArticleQuery orderByNumart($order = Criteria::ASC) Order by the art_num column
 * @method     ChildArticleQuery orderByTitre($order = Criteria::ASC) Order by the titre column
 * @method     ChildArticleQuery orderByIdEmpFk($order = Criteria::ASC) Order by the id_emp_FK column
 * @method     ChildArticleQuery orderByDateEdit($order = Criteria::ASC) Order by the date_edit column
 * @method     ChildArticleQuery orderByContenu($order = Criteria::ASC) Order by the contenu column
 * @method     ChildArticleQuery orderByResume($order = Criteria::ASC) Order by the resume column
 * @method     ChildArticleQuery orderByImgLaune($order = Criteria::ASC) Order by the img_laune column
 * @method     ChildArticleQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildArticleQuery orderByCategorie_FK($order = Criteria::ASC) Order by the categorie_FK column
 * @method     ChildArticleQuery orderBySouscategorie_FK($order = Criteria::ASC) Order by the sous_categorie_FK column
 *
 * @method     ChildArticleQuery groupByNumart() Group by the art_num column
 * @method     ChildArticleQuery groupByTitre() Group by the titre column
 * @method     ChildArticleQuery groupByIdEmpFk() Group by the id_emp_FK column
 * @method     ChildArticleQuery groupByDateEdit() Group by the date_edit column
 * @method     ChildArticleQuery groupByContenu() Group by the contenu column
 * @method     ChildArticleQuery groupByResume() Group by the resume column
 * @method     ChildArticleQuery groupByImgLaune() Group by the img_laune column
 * @method     ChildArticleQuery groupByUrl() Group by the url column
 * @method     ChildArticleQuery groupByCategorie_FK() Group by the categorie_FK column
 * @method     ChildArticleQuery groupBySouscategorie_FK() Group by the sous_categorie_FK column
 *
 * @method     ChildArticleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildArticleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildArticleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildArticleQuery leftJoinEmploye($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employe relation
 * @method     ChildArticleQuery rightJoinEmploye($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employe relation
 * @method     ChildArticleQuery innerJoinEmploye($relationAlias = null) Adds a INNER JOIN clause to the query using the Employe relation
 *
 * @method     ChildArticleQuery leftJoinCategorie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Categorie relation
 * @method     ChildArticleQuery rightJoinCategorie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Categorie relation
 * @method     ChildArticleQuery innerJoinCategorie($relationAlias = null) Adds a INNER JOIN clause to the query using the Categorie relation
 *
 * @method     ChildArticleQuery leftJoinSouscategorie($relationAlias = null) Adds a LEFT JOIN clause to the query using the Souscategorie relation
 * @method     ChildArticleQuery rightJoinSouscategorie($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Souscategorie relation
 * @method     ChildArticleQuery innerJoinSouscategorie($relationAlias = null) Adds a INNER JOIN clause to the query using the Souscategorie relation
 *
 * @method     ChildArticleQuery leftJoinPublication($relationAlias = null) Adds a LEFT JOIN clause to the query using the Publication relation
 * @method     ChildArticleQuery rightJoinPublication($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Publication relation
 * @method     ChildArticleQuery innerJoinPublication($relationAlias = null) Adds a INNER JOIN clause to the query using the Publication relation
 *
 * @method     ChildArticleQuery leftJoinWidget($relationAlias = null) Adds a LEFT JOIN clause to the query using the Widget relation
 * @method     ChildArticleQuery rightJoinWidget($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Widget relation
 * @method     ChildArticleQuery innerJoinWidget($relationAlias = null) Adds a INNER JOIN clause to the query using the Widget relation
 *
 * @method     \EmployeQuery|\CategorieQuery|\SouscategorieQuery|\PublicationQuery|\WidgetQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildArticle findOne(ConnectionInterface $con = null) Return the first ChildArticle matching the query
 * @method     ChildArticle findOneOrCreate(ConnectionInterface $con = null) Return the first ChildArticle matching the query, or a new ChildArticle object populated from the query conditions when no match is found
 *
 * @method     ChildArticle findOneByNumart(int $art_num) Return the first ChildArticle filtered by the art_num column
 * @method     ChildArticle findOneByTitre(string $titre) Return the first ChildArticle filtered by the titre column
 * @method     ChildArticle findOneByIdEmpFk(string $id_emp_FK) Return the first ChildArticle filtered by the id_emp_FK column
 * @method     ChildArticle findOneByDateEdit(string $date_edit) Return the first ChildArticle filtered by the date_edit column
 * @method     ChildArticle findOneByContenu(string $contenu) Return the first ChildArticle filtered by the contenu column
 * @method     ChildArticle findOneByResume(string $resume) Return the first ChildArticle filtered by the resume column
 * @method     ChildArticle findOneByImgLaune(string $img_laune) Return the first ChildArticle filtered by the img_laune column
 * @method     ChildArticle findOneByUrl(string $url) Return the first ChildArticle filtered by the url column
 * @method     ChildArticle findOneByCategorie_FK(string $categorie_FK) Return the first ChildArticle filtered by the categorie_FK column
 * @method     ChildArticle findOneBySouscategorie_FK(string $sous_categorie_FK) Return the first ChildArticle filtered by the sous_categorie_FK column *

 * @method     ChildArticle requirePk($key, ConnectionInterface $con = null) Return the ChildArticle by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOne(ConnectionInterface $con = null) Return the first ChildArticle matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArticle requireOneByNumart(int $art_num) Return the first ChildArticle filtered by the art_num column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByTitre(string $titre) Return the first ChildArticle filtered by the titre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByIdEmpFk(string $id_emp_FK) Return the first ChildArticle filtered by the id_emp_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByDateEdit(string $date_edit) Return the first ChildArticle filtered by the date_edit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByContenu(string $contenu) Return the first ChildArticle filtered by the contenu column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByResume(string $resume) Return the first ChildArticle filtered by the resume column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByImgLaune(string $img_laune) Return the first ChildArticle filtered by the img_laune column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByUrl(string $url) Return the first ChildArticle filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByCategorie_FK(string $categorie_FK) Return the first ChildArticle filtered by the categorie_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneBySouscategorie_FK(string $sous_categorie_FK) Return the first ChildArticle filtered by the sous_categorie_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArticle[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildArticle objects based on current ModelCriteria
 * @method     ChildArticle[]|ObjectCollection findByNumart(int $art_num) Return ChildArticle objects filtered by the art_num column
 * @method     ChildArticle[]|ObjectCollection findByTitre(string $titre) Return ChildArticle objects filtered by the titre column
 * @method     ChildArticle[]|ObjectCollection findByIdEmpFk(string $id_emp_FK) Return ChildArticle objects filtered by the id_emp_FK column
 * @method     ChildArticle[]|ObjectCollection findByDateEdit(string $date_edit) Return ChildArticle objects filtered by the date_edit column
 * @method     ChildArticle[]|ObjectCollection findByContenu(string $contenu) Return ChildArticle objects filtered by the contenu column
 * @method     ChildArticle[]|ObjectCollection findByResume(string $resume) Return ChildArticle objects filtered by the resume column
 * @method     ChildArticle[]|ObjectCollection findByImgLaune(string $img_laune) Return ChildArticle objects filtered by the img_laune column
 * @method     ChildArticle[]|ObjectCollection findByUrl(string $url) Return ChildArticle objects filtered by the url column
 * @method     ChildArticle[]|ObjectCollection findByCategorie_FK(string $categorie_FK) Return ChildArticle objects filtered by the categorie_FK column
 * @method     ChildArticle[]|ObjectCollection findBySouscategorie_FK(string $sous_categorie_FK) Return ChildArticle objects filtered by the sous_categorie_FK column
 * @method     ChildArticle[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ArticleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ArticleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Article', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildArticleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildArticleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildArticleQuery) {
            return $criteria;
        }
        $query = new ChildArticleQuery();
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
     * @return ChildArticle|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ArticleTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ArticleTableMap::DATABASE_NAME);
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
     * @return ChildArticle A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT art_num, titre, id_emp_FK, date_edit, contenu, resume, img_laune, url, categorie_FK, sous_categorie_FK FROM article WHERE art_num = :p0';
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
            /** @var ChildArticle $obj */
            $obj = new ChildArticle();
            $obj->hydrate($row);
            ArticleTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildArticle|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ArticleTableMap::COL_ART_NUM, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ArticleTableMap::COL_ART_NUM, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the art_num column
     *
     * Example usage:
     * <code>
     * $query->filterByNumart(1234); // WHERE art_num = 1234
     * $query->filterByNumart(array(12, 34)); // WHERE art_num IN (12, 34)
     * $query->filterByNumart(array('min' => 12)); // WHERE art_num > 12
     * </code>
     *
     * @param     mixed $numart The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByNumart($numart = null, $comparison = null)
    {
        if (is_array($numart)) {
            $useMinMax = false;
            if (isset($numart['min'])) {
                $this->addUsingAlias(ArticleTableMap::COL_ART_NUM, $numart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numart['max'])) {
                $this->addUsingAlias(ArticleTableMap::COL_ART_NUM, $numart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_ART_NUM, $numart, $comparison);
    }

    /**
     * Filter the query on the titre column
     *
     * Example usage:
     * <code>
     * $query->filterByTitre('fooValue');   // WHERE titre = 'fooValue'
     * $query->filterByTitre('%fooValue%'); // WHERE titre LIKE '%fooValue%'
     * </code>
     *
     * @param     string $titre The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByTitre($titre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($titre)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $titre)) {
                $titre = str_replace('*', '%', $titre);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_TITRE, $titre, $comparison);
    }

    /**
     * Filter the query on the id_emp_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIdEmpFk('fooValue');   // WHERE id_emp_FK = 'fooValue'
     * $query->filterByIdEmpFk('%fooValue%'); // WHERE id_emp_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idEmpFk The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByIdEmpFk($idEmpFk = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idEmpFk)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $idEmpFk)) {
                $idEmpFk = str_replace('*', '%', $idEmpFk);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_ID_EMP_FK, $idEmpFk, $comparison);
    }

    /**
     * Filter the query on the date_edit column
     *
     * Example usage:
     * <code>
     * $query->filterByDateEdit('2011-03-14'); // WHERE date_edit = '2011-03-14'
     * $query->filterByDateEdit('now'); // WHERE date_edit = '2011-03-14'
     * $query->filterByDateEdit(array('max' => 'yesterday')); // WHERE date_edit > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateEdit The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByDateEdit($dateEdit = null, $comparison = null)
    {
        if (is_array($dateEdit)) {
            $useMinMax = false;
            if (isset($dateEdit['min'])) {
                $this->addUsingAlias(ArticleTableMap::COL_DATE_EDIT, $dateEdit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateEdit['max'])) {
                $this->addUsingAlias(ArticleTableMap::COL_DATE_EDIT, $dateEdit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_DATE_EDIT, $dateEdit, $comparison);
    }

    /**
     * Filter the query on the contenu column
     *
     * Example usage:
     * <code>
     * $query->filterByContenu('fooValue');   // WHERE contenu = 'fooValue'
     * $query->filterByContenu('%fooValue%'); // WHERE contenu LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contenu The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByContenu($contenu = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contenu)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $contenu)) {
                $contenu = str_replace('*', '%', $contenu);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_CONTENU, $contenu, $comparison);
    }

    /**
     * Filter the query on the resume column
     *
     * Example usage:
     * <code>
     * $query->filterByResume('fooValue');   // WHERE resume = 'fooValue'
     * $query->filterByResume('%fooValue%'); // WHERE resume LIKE '%fooValue%'
     * </code>
     *
     * @param     string $resume The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByResume($resume = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($resume)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $resume)) {
                $resume = str_replace('*', '%', $resume);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_RESUME, $resume, $comparison);
    }

    /**
     * Filter the query on the img_laune column
     *
     * Example usage:
     * <code>
     * $query->filterByImgLaune('fooValue');   // WHERE img_laune = 'fooValue'
     * $query->filterByImgLaune('%fooValue%'); // WHERE img_laune LIKE '%fooValue%'
     * </code>
     *
     * @param     string $imgLaune The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByImgLaune($imgLaune = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imgLaune)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $imgLaune)) {
                $imgLaune = str_replace('*', '%', $imgLaune);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_IMG_LAUNE, $imgLaune, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_URL, $url, $comparison);
    }

    /**
     * Filter the query on the categorie_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByCategorie_FK('fooValue');   // WHERE categorie_FK = 'fooValue'
     * $query->filterByCategorie_FK('%fooValue%'); // WHERE categorie_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categorie_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArticleTableMap::COL_CATEGORIE_FK, $categorie_FK, $comparison);
    }

    /**
     * Filter the query on the sous_categorie_FK column
     *
     * Example usage:
     * <code>
     * $query->filterBySouscategorie_FK('fooValue');   // WHERE sous_categorie_FK = 'fooValue'
     * $query->filterBySouscategorie_FK('%fooValue%'); // WHERE sous_categorie_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $souscategorie_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArticleTableMap::COL_SOUS_CATEGORIE_FK, $souscategorie_FK, $comparison);
    }

    /**
     * Filter the query by a related \Employe object
     *
     * @param \Employe|ObjectCollection $employe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildArticleQuery The current query, for fluid interface
     */
    public function filterByEmploye($employe, $comparison = null)
    {
        if ($employe instanceof \Employe) {
            return $this
                ->addUsingAlias(ArticleTableMap::COL_ID_EMP_FK, $employe->getIdEmploye(), $comparison);
        } elseif ($employe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArticleTableMap::COL_ID_EMP_FK, $employe->toKeyValue('PrimaryKey', 'IdEmploye'), $comparison);
        } else {
            throw new PropelException('filterByEmploye() only accepts arguments of type \Employe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Employe relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function joinEmploye($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Employe');

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
            $this->addJoinObject($join, 'Employe');
        }

        return $this;
    }

    /**
     * Use the Employe relation Employe object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EmployeQuery A secondary query class using the current class as primary query
     */
    public function useEmployeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEmploye($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Employe', '\EmployeQuery');
    }

    /**
     * Filter the query by a related \Categorie object
     *
     * @param \Categorie|ObjectCollection $categorie The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildArticleQuery The current query, for fluid interface
     */
    public function filterByCategorie($categorie, $comparison = null)
    {
        if ($categorie instanceof \Categorie) {
            return $this
                ->addUsingAlias(ArticleTableMap::COL_CATEGORIE_FK, $categorie->getCategorie(), $comparison);
        } elseif ($categorie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArticleTableMap::COL_CATEGORIE_FK, $categorie->toKeyValue('PrimaryKey', 'Categorie'), $comparison);
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
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function joinCategorie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useCategorieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @return ChildArticleQuery The current query, for fluid interface
     */
    public function filterBySouscategorie($souscategorie, $comparison = null)
    {
        if ($souscategorie instanceof \Souscategorie) {
            return $this
                ->addUsingAlias(ArticleTableMap::COL_SOUS_CATEGORIE_FK, $souscategorie->getSouscategorie(), $comparison);
        } elseif ($souscategorie instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArticleTableMap::COL_SOUS_CATEGORIE_FK, $souscategorie->toKeyValue('PrimaryKey', 'Souscategorie'), $comparison);
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
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function joinSouscategorie($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useSouscategorieQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSouscategorie($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Souscategorie', '\SouscategorieQuery');
    }

    /**
     * Filter the query by a related \Publication object
     *
     * @param \Publication|ObjectCollection $publication the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPublication($publication, $comparison = null)
    {
        if ($publication instanceof \Publication) {
            return $this
                ->addUsingAlias(ArticleTableMap::COL_ART_NUM, $publication->getArt_num_PK(), $comparison);
        } elseif ($publication instanceof ObjectCollection) {
            return $this
                ->usePublicationQuery()
                ->filterByPrimaryKeys($publication->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublication() only accepts arguments of type \Publication or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Publication relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function joinPublication($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Publication');

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
            $this->addJoinObject($join, 'Publication');
        }

        return $this;
    }

    /**
     * Use the Publication relation Publication object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PublicationQuery A secondary query class using the current class as primary query
     */
    public function usePublicationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPublication($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Publication', '\PublicationQuery');
    }

    /**
     * Filter the query by a related \Widget object
     *
     * @param \Widget|ObjectCollection $widget the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArticleQuery The current query, for fluid interface
     */
    public function filterByWidget($widget, $comparison = null)
    {
        if ($widget instanceof \Widget) {
            return $this
                ->addUsingAlias(ArticleTableMap::COL_ART_NUM, $widget->getNumarticle(), $comparison);
        } elseif ($widget instanceof ObjectCollection) {
            return $this
                ->useWidgetQuery()
                ->filterByPrimaryKeys($widget->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWidget() only accepts arguments of type \Widget or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Widget relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function joinWidget($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Widget');

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
            $this->addJoinObject($join, 'Widget');
        }

        return $this;
    }

    /**
     * Use the Widget relation Widget object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \WidgetQuery A secondary query class using the current class as primary query
     */
    public function useWidgetQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWidget($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Widget', '\WidgetQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildArticle $article Object to remove from the list of results
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function prune($article = null)
    {
        if ($article) {
            $this->addUsingAlias(ArticleTableMap::COL_ART_NUM, $article->getNumart(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the article table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ArticleTableMap::clearInstancePool();
            ArticleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ArticleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ArticleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ArticleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ArticleQuery
