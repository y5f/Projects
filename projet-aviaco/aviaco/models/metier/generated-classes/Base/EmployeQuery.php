<?php

namespace Base;

use \Employe as ChildEmploye;
use \EmployeQuery as ChildEmployeQuery;
use \Exception;
use \PDO;
use Map\EmployeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'employe' table.
 *
 *
 *
 * @method     ChildEmployeQuery orderByIdEmploye($order = Criteria::ASC) Order by the id_emp column
 * @method     ChildEmployeQuery orderByNom($order = Criteria::ASC) Order by the nom column
 * @method     ChildEmployeQuery orderByPrenoom($order = Criteria::ASC) Order by the prenom column
 * @method     ChildEmployeQuery orderByAdresses($order = Criteria::ASC) Order by the adresses column
 * @method     ChildEmployeQuery orderByCodepostal($order = Criteria::ASC) Order by the cp column
 * @method     ChildEmployeQuery orderByFonction($order = Criteria::ASC) Order by the fonction column
 * @method     ChildEmployeQuery orderByTelephone($order = Criteria::ASC) Order by the telephone column
 * @method     ChildEmployeQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildEmployeQuery orderByPasse($order = Criteria::ASC) Order by the passe column
 * @method     ChildEmployeQuery orderByNiveaAcces($order = Criteria::ASC) Order by the acces column
 * @method     ChildEmployeQuery orderByAvatard($order = Criteria::ASC) Order by the avatard column
 * @method     ChildEmployeQuery orderByEtat($order = Criteria::ASC) Order by the etat column
 *
 * @method     ChildEmployeQuery groupByIdEmploye() Group by the id_emp column
 * @method     ChildEmployeQuery groupByNom() Group by the nom column
 * @method     ChildEmployeQuery groupByPrenoom() Group by the prenom column
 * @method     ChildEmployeQuery groupByAdresses() Group by the adresses column
 * @method     ChildEmployeQuery groupByCodepostal() Group by the cp column
 * @method     ChildEmployeQuery groupByFonction() Group by the fonction column
 * @method     ChildEmployeQuery groupByTelephone() Group by the telephone column
 * @method     ChildEmployeQuery groupByEmail() Group by the email column
 * @method     ChildEmployeQuery groupByPasse() Group by the passe column
 * @method     ChildEmployeQuery groupByNiveaAcces() Group by the acces column
 * @method     ChildEmployeQuery groupByAvatard() Group by the avatard column
 * @method     ChildEmployeQuery groupByEtat() Group by the etat column
 *
 * @method     ChildEmployeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEmployeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEmployeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEmployeQuery leftJoinSession($relationAlias = null) Adds a LEFT JOIN clause to the query using the Session relation
 * @method     ChildEmployeQuery rightJoinSession($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Session relation
 * @method     ChildEmployeQuery innerJoinSession($relationAlias = null) Adds a INNER JOIN clause to the query using the Session relation
 *
 * @method     ChildEmployeQuery leftJoinCV($relationAlias = null) Adds a LEFT JOIN clause to the query using the CV relation
 * @method     ChildEmployeQuery rightJoinCV($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CV relation
 * @method     ChildEmployeQuery innerJoinCV($relationAlias = null) Adds a INNER JOIN clause to the query using the CV relation
 *
 * @method     ChildEmployeQuery leftJoinArticle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Article relation
 * @method     ChildEmployeQuery rightJoinArticle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Article relation
 * @method     ChildEmployeQuery innerJoinArticle($relationAlias = null) Adds a INNER JOIN clause to the query using the Article relation
 *
 * @method     \SessionQuery|\CVQuery|\ArticleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEmploye findOne(ConnectionInterface $con = null) Return the first ChildEmploye matching the query
 * @method     ChildEmploye findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEmploye matching the query, or a new ChildEmploye object populated from the query conditions when no match is found
 *
 * @method     ChildEmploye findOneByIdEmploye(string $id_emp) Return the first ChildEmploye filtered by the id_emp column
 * @method     ChildEmploye findOneByNom(string $nom) Return the first ChildEmploye filtered by the nom column
 * @method     ChildEmploye findOneByPrenoom(string $prenom) Return the first ChildEmploye filtered by the prenom column
 * @method     ChildEmploye findOneByAdresses(string $adresses) Return the first ChildEmploye filtered by the adresses column
 * @method     ChildEmploye findOneByCodepostal(int $cp) Return the first ChildEmploye filtered by the cp column
 * @method     ChildEmploye findOneByFonction(string $fonction) Return the first ChildEmploye filtered by the fonction column
 * @method     ChildEmploye findOneByTelephone(string $telephone) Return the first ChildEmploye filtered by the telephone column
 * @method     ChildEmploye findOneByEmail(string $email) Return the first ChildEmploye filtered by the email column
 * @method     ChildEmploye findOneByPasse(string $passe) Return the first ChildEmploye filtered by the passe column
 * @method     ChildEmploye findOneByNiveaAcces(string $acces) Return the first ChildEmploye filtered by the acces column
 * @method     ChildEmploye findOneByAvatard(string $avatard) Return the first ChildEmploye filtered by the avatard column
 * @method     ChildEmploye findOneByEtat(boolean $etat) Return the first ChildEmploye filtered by the etat column *

 * @method     ChildEmploye requirePk($key, ConnectionInterface $con = null) Return the ChildEmploye by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOne(ConnectionInterface $con = null) Return the first ChildEmploye matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEmploye requireOneByIdEmploye(string $id_emp) Return the first ChildEmploye filtered by the id_emp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByNom(string $nom) Return the first ChildEmploye filtered by the nom column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByPrenoom(string $prenom) Return the first ChildEmploye filtered by the prenom column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByAdresses(string $adresses) Return the first ChildEmploye filtered by the adresses column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByCodepostal(int $cp) Return the first ChildEmploye filtered by the cp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByFonction(string $fonction) Return the first ChildEmploye filtered by the fonction column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByTelephone(string $telephone) Return the first ChildEmploye filtered by the telephone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByEmail(string $email) Return the first ChildEmploye filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByPasse(string $passe) Return the first ChildEmploye filtered by the passe column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByNiveaAcces(string $acces) Return the first ChildEmploye filtered by the acces column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByAvatard(string $avatard) Return the first ChildEmploye filtered by the avatard column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByEtat(boolean $etat) Return the first ChildEmploye filtered by the etat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEmploye[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEmploye objects based on current ModelCriteria
 * @method     ChildEmploye[]|ObjectCollection findByIdEmploye(string $id_emp) Return ChildEmploye objects filtered by the id_emp column
 * @method     ChildEmploye[]|ObjectCollection findByNom(string $nom) Return ChildEmploye objects filtered by the nom column
 * @method     ChildEmploye[]|ObjectCollection findByPrenoom(string $prenom) Return ChildEmploye objects filtered by the prenom column
 * @method     ChildEmploye[]|ObjectCollection findByAdresses(string $adresses) Return ChildEmploye objects filtered by the adresses column
 * @method     ChildEmploye[]|ObjectCollection findByCodepostal(int $cp) Return ChildEmploye objects filtered by the cp column
 * @method     ChildEmploye[]|ObjectCollection findByFonction(string $fonction) Return ChildEmploye objects filtered by the fonction column
 * @method     ChildEmploye[]|ObjectCollection findByTelephone(string $telephone) Return ChildEmploye objects filtered by the telephone column
 * @method     ChildEmploye[]|ObjectCollection findByEmail(string $email) Return ChildEmploye objects filtered by the email column
 * @method     ChildEmploye[]|ObjectCollection findByPasse(string $passe) Return ChildEmploye objects filtered by the passe column
 * @method     ChildEmploye[]|ObjectCollection findByNiveaAcces(string $acces) Return ChildEmploye objects filtered by the acces column
 * @method     ChildEmploye[]|ObjectCollection findByAvatard(string $avatard) Return ChildEmploye objects filtered by the avatard column
 * @method     ChildEmploye[]|ObjectCollection findByEtat(boolean $etat) Return ChildEmploye objects filtered by the etat column
 * @method     ChildEmploye[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EmployeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\EmployeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Employe', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEmployeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEmployeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEmployeQuery) {
            return $criteria;
        }
        $query = new ChildEmployeQuery();
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
     * @return ChildEmploye|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = EmployeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EmployeTableMap::DATABASE_NAME);
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
     * @return ChildEmploye A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_emp, nom, prenom, adresses, cp, fonction, telephone, email, passe, acces, avatard, etat FROM employe WHERE id_emp = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildEmploye $obj */
            $obj = new ChildEmploye();
            $obj->hydrate($row);
            EmployeTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildEmploye|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EmployeTableMap::COL_ID_EMP, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EmployeTableMap::COL_ID_EMP, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_emp column
     *
     * Example usage:
     * <code>
     * $query->filterByIdEmploye('fooValue');   // WHERE id_emp = 'fooValue'
     * $query->filterByIdEmploye('%fooValue%'); // WHERE id_emp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idEmploye The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByIdEmploye($idEmploye = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idEmploye)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $idEmploye)) {
                $idEmploye = str_replace('*', '%', $idEmploye);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_ID_EMP, $idEmploye, $comparison);
    }

    /**
     * Filter the query on the nom column
     *
     * Example usage:
     * <code>
     * $query->filterByNom('fooValue');   // WHERE nom = 'fooValue'
     * $query->filterByNom('%fooValue%'); // WHERE nom LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nom The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByNom($nom = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nom)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nom)) {
                $nom = str_replace('*', '%', $nom);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_NOM, $nom, $comparison);
    }

    /**
     * Filter the query on the prenom column
     *
     * Example usage:
     * <code>
     * $query->filterByPrenoom('fooValue');   // WHERE prenom = 'fooValue'
     * $query->filterByPrenoom('%fooValue%'); // WHERE prenom LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prenoom The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPrenoom($prenoom = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prenoom)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prenoom)) {
                $prenoom = str_replace('*', '%', $prenoom);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_PRENOM, $prenoom, $comparison);
    }

    /**
     * Filter the query on the adresses column
     *
     * Example usage:
     * <code>
     * $query->filterByAdresses('fooValue');   // WHERE adresses = 'fooValue'
     * $query->filterByAdresses('%fooValue%'); // WHERE adresses LIKE '%fooValue%'
     * </code>
     *
     * @param     string $adresses The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByAdresses($adresses = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($adresses)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $adresses)) {
                $adresses = str_replace('*', '%', $adresses);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_ADRESSES, $adresses, $comparison);
    }

    /**
     * Filter the query on the cp column
     *
     * Example usage:
     * <code>
     * $query->filterByCodepostal(1234); // WHERE cp = 1234
     * $query->filterByCodepostal(array(12, 34)); // WHERE cp IN (12, 34)
     * $query->filterByCodepostal(array('min' => 12)); // WHERE cp > 12
     * </code>
     *
     * @param     mixed $codepostal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByCodepostal($codepostal = null, $comparison = null)
    {
        if (is_array($codepostal)) {
            $useMinMax = false;
            if (isset($codepostal['min'])) {
                $this->addUsingAlias(EmployeTableMap::COL_CP, $codepostal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($codepostal['max'])) {
                $this->addUsingAlias(EmployeTableMap::COL_CP, $codepostal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_CP, $codepostal, $comparison);
    }

    /**
     * Filter the query on the fonction column
     *
     * Example usage:
     * <code>
     * $query->filterByFonction('fooValue');   // WHERE fonction = 'fooValue'
     * $query->filterByFonction('%fooValue%'); // WHERE fonction LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fonction The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByFonction($fonction = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fonction)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fonction)) {
                $fonction = str_replace('*', '%', $fonction);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_FONCTION, $fonction, $comparison);
    }

    /**
     * Filter the query on the telephone column
     *
     * Example usage:
     * <code>
     * $query->filterByTelephone('fooValue');   // WHERE telephone = 'fooValue'
     * $query->filterByTelephone('%fooValue%'); // WHERE telephone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telephone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByTelephone($telephone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telephone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $telephone)) {
                $telephone = str_replace('*', '%', $telephone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_TELEPHONE, $telephone, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the passe column
     *
     * Example usage:
     * <code>
     * $query->filterByPasse('fooValue');   // WHERE passe = 'fooValue'
     * $query->filterByPasse('%fooValue%'); // WHERE passe LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passe The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPasse($passe = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passe)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passe)) {
                $passe = str_replace('*', '%', $passe);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_PASSE, $passe, $comparison);
    }

    /**
     * Filter the query on the acces column
     *
     * Example usage:
     * <code>
     * $query->filterByNiveaAcces('fooValue');   // WHERE acces = 'fooValue'
     * $query->filterByNiveaAcces('%fooValue%'); // WHERE acces LIKE '%fooValue%'
     * </code>
     *
     * @param     string $niveaAcces The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByNiveaAcces($niveaAcces = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($niveaAcces)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $niveaAcces)) {
                $niveaAcces = str_replace('*', '%', $niveaAcces);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_ACCES, $niveaAcces, $comparison);
    }

    /**
     * Filter the query on the avatard column
     *
     * Example usage:
     * <code>
     * $query->filterByAvatard('fooValue');   // WHERE avatard = 'fooValue'
     * $query->filterByAvatard('%fooValue%'); // WHERE avatard LIKE '%fooValue%'
     * </code>
     *
     * @param     string $avatard The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByAvatard($avatard = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($avatard)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $avatard)) {
                $avatard = str_replace('*', '%', $avatard);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_AVATARD, $avatard, $comparison);
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
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByEtat($etat = null, $comparison = null)
    {
        if (is_string($etat)) {
            $etat = in_array(strtolower($etat), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(EmployeTableMap::COL_ETAT, $etat, $comparison);
    }

    /**
     * Filter the query by a related \Session object
     *
     * @param \Session|ObjectCollection $session the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterBySession($session, $comparison = null)
    {
        if ($session instanceof \Session) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_ID_EMP, $session->getId_emp_FK(), $comparison);
        } elseif ($session instanceof ObjectCollection) {
            return $this
                ->useSessionQuery()
                ->filterByPrimaryKeys($session->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySession() only accepts arguments of type \Session or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Session relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinSession($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Session');

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
            $this->addJoinObject($join, 'Session');
        }

        return $this;
    }

    /**
     * Use the Session relation Session object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SessionQuery A secondary query class using the current class as primary query
     */
    public function useSessionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSession($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Session', '\SessionQuery');
    }

    /**
     * Filter the query by a related \CV object
     *
     * @param \CV|ObjectCollection $cV the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByCV($cV, $comparison = null)
    {
        if ($cV instanceof \CV) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_ID_EMP, $cV->getId_emp_FK(), $comparison);
        } elseif ($cV instanceof ObjectCollection) {
            return $this
                ->useCVQuery()
                ->filterByPrimaryKeys($cV->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCV() only accepts arguments of type \CV or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CV relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinCV($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CV');

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
            $this->addJoinObject($join, 'CV');
        }

        return $this;
    }

    /**
     * Use the CV relation CV object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CVQuery A secondary query class using the current class as primary query
     */
    public function useCVQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCV($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CV', '\CVQuery');
    }

    /**
     * Filter the query by a related \Article object
     *
     * @param \Article|ObjectCollection $article the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByArticle($article, $comparison = null)
    {
        if ($article instanceof \Article) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_ID_EMP, $article->getIdEmpFk(), $comparison);
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
     * @return $this|ChildEmployeQuery The current query, for fluid interface
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
     * @param   ChildEmploye $employe Object to remove from the list of results
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function prune($employe = null)
    {
        if ($employe) {
            $this->addUsingAlias(EmployeTableMap::COL_ID_EMP, $employe->getIdEmploye(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the employe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EmployeTableMap::clearInstancePool();
            EmployeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EmployeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EmployeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EmployeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EmployeQuery
