<?php

namespace Base;

use \Infos as ChildInfos;
use \InfosQuery as ChildInfosQuery;
use \Exception;
use \PDO;
use Map\InfosTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'infos_box' table.
 *
 *
 *
 * @method     ChildInfosQuery orderByIDInfos($order = Criteria::ASC) Order by the ibox_id column
 * @method     ChildInfosQuery orderByTitre($order = Criteria::ASC) Order by the titre column
 * @method     ChildInfosQuery orderByLogo($order = Criteria::ASC) Order by the logo column
 * @method     ChildInfosQuery orderBySlogan($order = Criteria::ASC) Order by the slogan column
 * @method     ChildInfosQuery orderByTelephone($order = Criteria::ASC) Order by the telephone column
 * @method     ChildInfosQuery orderByEmail($order = Criteria::ASC) Order by the mail column
 * @method     ChildInfosQuery orderByNumrue($order = Criteria::ASC) Order by the num_rue column
 * @method     ChildInfosQuery orderByNomrue($order = Criteria::ASC) Order by the nom_rue column
 * @method     ChildInfosQuery orderByCodepostal($order = Criteria::ASC) Order by the cp column
 * @method     ChildInfosQuery orderByVille($order = Criteria::ASC) Order by the ville column
 * @method     ChildInfosQuery orderByTextslider($order = Criteria::ASC) Order by the txt_slider column
 *
 * @method     ChildInfosQuery groupByIDInfos() Group by the ibox_id column
 * @method     ChildInfosQuery groupByTitre() Group by the titre column
 * @method     ChildInfosQuery groupByLogo() Group by the logo column
 * @method     ChildInfosQuery groupBySlogan() Group by the slogan column
 * @method     ChildInfosQuery groupByTelephone() Group by the telephone column
 * @method     ChildInfosQuery groupByEmail() Group by the mail column
 * @method     ChildInfosQuery groupByNumrue() Group by the num_rue column
 * @method     ChildInfosQuery groupByNomrue() Group by the nom_rue column
 * @method     ChildInfosQuery groupByCodepostal() Group by the cp column
 * @method     ChildInfosQuery groupByVille() Group by the ville column
 * @method     ChildInfosQuery groupByTextslider() Group by the txt_slider column
 *
 * @method     ChildInfosQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInfosQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInfosQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInfos findOne(ConnectionInterface $con = null) Return the first ChildInfos matching the query
 * @method     ChildInfos findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInfos matching the query, or a new ChildInfos object populated from the query conditions when no match is found
 *
 * @method     ChildInfos findOneByIDInfos(int $ibox_id) Return the first ChildInfos filtered by the ibox_id column
 * @method     ChildInfos findOneByTitre(string $titre) Return the first ChildInfos filtered by the titre column
 * @method     ChildInfos findOneByLogo(string $logo) Return the first ChildInfos filtered by the logo column
 * @method     ChildInfos findOneBySlogan(string $slogan) Return the first ChildInfos filtered by the slogan column
 * @method     ChildInfos findOneByTelephone(string $telephone) Return the first ChildInfos filtered by the telephone column
 * @method     ChildInfos findOneByEmail(string $mail) Return the first ChildInfos filtered by the mail column
 * @method     ChildInfos findOneByNumrue(string $num_rue) Return the first ChildInfos filtered by the num_rue column
 * @method     ChildInfos findOneByNomrue(string $nom_rue) Return the first ChildInfos filtered by the nom_rue column
 * @method     ChildInfos findOneByCodepostal(string $cp) Return the first ChildInfos filtered by the cp column
 * @method     ChildInfos findOneByVille(string $ville) Return the first ChildInfos filtered by the ville column
 * @method     ChildInfos findOneByTextslider(string $txt_slider) Return the first ChildInfos filtered by the txt_slider column *

 * @method     ChildInfos requirePk($key, ConnectionInterface $con = null) Return the ChildInfos by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOne(ConnectionInterface $con = null) Return the first ChildInfos matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInfos requireOneByIDInfos(int $ibox_id) Return the first ChildInfos filtered by the ibox_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByTitre(string $titre) Return the first ChildInfos filtered by the titre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByLogo(string $logo) Return the first ChildInfos filtered by the logo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneBySlogan(string $slogan) Return the first ChildInfos filtered by the slogan column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByTelephone(string $telephone) Return the first ChildInfos filtered by the telephone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByEmail(string $mail) Return the first ChildInfos filtered by the mail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByNumrue(string $num_rue) Return the first ChildInfos filtered by the num_rue column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByNomrue(string $nom_rue) Return the first ChildInfos filtered by the nom_rue column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByCodepostal(string $cp) Return the first ChildInfos filtered by the cp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByVille(string $ville) Return the first ChildInfos filtered by the ville column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInfos requireOneByTextslider(string $txt_slider) Return the first ChildInfos filtered by the txt_slider column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInfos[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInfos objects based on current ModelCriteria
 * @method     ChildInfos[]|ObjectCollection findByIDInfos(int $ibox_id) Return ChildInfos objects filtered by the ibox_id column
 * @method     ChildInfos[]|ObjectCollection findByTitre(string $titre) Return ChildInfos objects filtered by the titre column
 * @method     ChildInfos[]|ObjectCollection findByLogo(string $logo) Return ChildInfos objects filtered by the logo column
 * @method     ChildInfos[]|ObjectCollection findBySlogan(string $slogan) Return ChildInfos objects filtered by the slogan column
 * @method     ChildInfos[]|ObjectCollection findByTelephone(string $telephone) Return ChildInfos objects filtered by the telephone column
 * @method     ChildInfos[]|ObjectCollection findByEmail(string $mail) Return ChildInfos objects filtered by the mail column
 * @method     ChildInfos[]|ObjectCollection findByNumrue(string $num_rue) Return ChildInfos objects filtered by the num_rue column
 * @method     ChildInfos[]|ObjectCollection findByNomrue(string $nom_rue) Return ChildInfos objects filtered by the nom_rue column
 * @method     ChildInfos[]|ObjectCollection findByCodepostal(string $cp) Return ChildInfos objects filtered by the cp column
 * @method     ChildInfos[]|ObjectCollection findByVille(string $ville) Return ChildInfos objects filtered by the ville column
 * @method     ChildInfos[]|ObjectCollection findByTextslider(string $txt_slider) Return ChildInfos objects filtered by the txt_slider column
 * @method     ChildInfos[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InfosQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\InfosQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Infos', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInfosQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInfosQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInfosQuery) {
            return $criteria;
        }
        $query = new ChildInfosQuery();
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
     * @return ChildInfos|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InfosTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InfosTableMap::DATABASE_NAME);
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
     * @return ChildInfos A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ibox_id, titre, logo, slogan, telephone, mail, num_rue, nom_rue, cp, ville, txt_slider FROM infos_box WHERE ibox_id = :p0';
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
            /** @var ChildInfos $obj */
            $obj = new ChildInfos();
            $obj->hydrate($row);
            InfosTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildInfos|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InfosTableMap::COL_IBOX_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InfosTableMap::COL_IBOX_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ibox_id column
     *
     * Example usage:
     * <code>
     * $query->filterByIDInfos(1234); // WHERE ibox_id = 1234
     * $query->filterByIDInfos(array(12, 34)); // WHERE ibox_id IN (12, 34)
     * $query->filterByIDInfos(array('min' => 12)); // WHERE ibox_id > 12
     * </code>
     *
     * @param     mixed $iDInfos The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByIDInfos($iDInfos = null, $comparison = null)
    {
        if (is_array($iDInfos)) {
            $useMinMax = false;
            if (isset($iDInfos['min'])) {
                $this->addUsingAlias(InfosTableMap::COL_IBOX_ID, $iDInfos['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDInfos['max'])) {
                $this->addUsingAlias(InfosTableMap::COL_IBOX_ID, $iDInfos['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InfosTableMap::COL_IBOX_ID, $iDInfos, $comparison);
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
     * @return $this|ChildInfosQuery The current query, for fluid interface
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

        return $this->addUsingAlias(InfosTableMap::COL_TITRE, $titre, $comparison);
    }

    /**
     * Filter the query on the logo column
     *
     * Example usage:
     * <code>
     * $query->filterByLogo('fooValue');   // WHERE logo = 'fooValue'
     * $query->filterByLogo('%fooValue%'); // WHERE logo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $logo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByLogo($logo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($logo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $logo)) {
                $logo = str_replace('*', '%', $logo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InfosTableMap::COL_LOGO, $logo, $comparison);
    }

    /**
     * Filter the query on the slogan column
     *
     * Example usage:
     * <code>
     * $query->filterBySlogan('fooValue');   // WHERE slogan = 'fooValue'
     * $query->filterBySlogan('%fooValue%'); // WHERE slogan LIKE '%fooValue%'
     * </code>
     *
     * @param     string $slogan The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterBySlogan($slogan = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slogan)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $slogan)) {
                $slogan = str_replace('*', '%', $slogan);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InfosTableMap::COL_SLOGAN, $slogan, $comparison);
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
     * @return $this|ChildInfosQuery The current query, for fluid interface
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

        return $this->addUsingAlias(InfosTableMap::COL_TELEPHONE, $telephone, $comparison);
    }

    /**
     * Filter the query on the mail column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE mail = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE mail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
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

        return $this->addUsingAlias(InfosTableMap::COL_MAIL, $email, $comparison);
    }

    /**
     * Filter the query on the num_rue column
     *
     * Example usage:
     * <code>
     * $query->filterByNumrue('fooValue');   // WHERE num_rue = 'fooValue'
     * $query->filterByNumrue('%fooValue%'); // WHERE num_rue LIKE '%fooValue%'
     * </code>
     *
     * @param     string $numrue The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByNumrue($numrue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($numrue)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $numrue)) {
                $numrue = str_replace('*', '%', $numrue);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InfosTableMap::COL_NUM_RUE, $numrue, $comparison);
    }

    /**
     * Filter the query on the nom_rue column
     *
     * Example usage:
     * <code>
     * $query->filterByNomrue('fooValue');   // WHERE nom_rue = 'fooValue'
     * $query->filterByNomrue('%fooValue%'); // WHERE nom_rue LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nomrue The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByNomrue($nomrue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nomrue)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nomrue)) {
                $nomrue = str_replace('*', '%', $nomrue);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InfosTableMap::COL_NOM_RUE, $nomrue, $comparison);
    }

    /**
     * Filter the query on the cp column
     *
     * Example usage:
     * <code>
     * $query->filterByCodepostal('fooValue');   // WHERE cp = 'fooValue'
     * $query->filterByCodepostal('%fooValue%'); // WHERE cp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codepostal The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByCodepostal($codepostal = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codepostal)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $codepostal)) {
                $codepostal = str_replace('*', '%', $codepostal);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InfosTableMap::COL_CP, $codepostal, $comparison);
    }

    /**
     * Filter the query on the ville column
     *
     * Example usage:
     * <code>
     * $query->filterByVille('fooValue');   // WHERE ville = 'fooValue'
     * $query->filterByVille('%fooValue%'); // WHERE ville LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ville The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByVille($ville = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ville)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ville)) {
                $ville = str_replace('*', '%', $ville);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InfosTableMap::COL_VILLE, $ville, $comparison);
    }

    /**
     * Filter the query on the txt_slider column
     *
     * Example usage:
     * <code>
     * $query->filterByTextslider('fooValue');   // WHERE txt_slider = 'fooValue'
     * $query->filterByTextslider('%fooValue%'); // WHERE txt_slider LIKE '%fooValue%'
     * </code>
     *
     * @param     string $textslider The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function filterByTextslider($textslider = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($textslider)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $textslider)) {
                $textslider = str_replace('*', '%', $textslider);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InfosTableMap::COL_TXT_SLIDER, $textslider, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildInfos $infos Object to remove from the list of results
     *
     * @return $this|ChildInfosQuery The current query, for fluid interface
     */
    public function prune($infos = null)
    {
        if ($infos) {
            $this->addUsingAlias(InfosTableMap::COL_IBOX_ID, $infos->getIDInfos(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the infos_box table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InfosTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InfosTableMap::clearInstancePool();
            InfosTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InfosTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InfosTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InfosTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InfosTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InfosQuery
