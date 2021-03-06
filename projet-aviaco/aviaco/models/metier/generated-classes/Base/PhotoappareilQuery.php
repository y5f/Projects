<?php

namespace Base;

use \Photoappareil as ChildPhotoappareil;
use \PhotoappareilQuery as ChildPhotoappareilQuery;
use \Exception;
use \PDO;
use Map\PhotoappareilTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'photo_appareil' table.
 *
 *
 *
 * @method     ChildPhotoappareilQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildPhotoappareilQuery orderByPhoto($order = Criteria::ASC) Order by the url_photo column
 * @method     ChildPhotoappareilQuery orderByDatephoto($order = Criteria::ASC) Order by the date_photo column
 * @method     ChildPhotoappareilQuery orderByTitre($order = Criteria::ASC) Order by the titre_photo column
 * @method     ChildPhotoappareilQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 * @method     ChildPhotoappareilQuery orderByEtat($order = Criteria::ASC) Order by the etat column
 * @method     ChildPhotoappareilQuery orderByIdAp_PK($order = Criteria::ASC) Order by the idAp_PK column
 * @method     ChildPhotoappareilQuery orderBymodele_PK($order = Criteria::ASC) Order by the modele_PK column
 * @method     ChildPhotoappareilQuery orderBymarque_PK($order = Criteria::ASC) Order by the marque_PK column
 *
 * @method     ChildPhotoappareilQuery groupByID() Group by the id column
 * @method     ChildPhotoappareilQuery groupByPhoto() Group by the url_photo column
 * @method     ChildPhotoappareilQuery groupByDatephoto() Group by the date_photo column
 * @method     ChildPhotoappareilQuery groupByTitre() Group by the titre_photo column
 * @method     ChildPhotoappareilQuery groupByCommentaire() Group by the commentaire column
 * @method     ChildPhotoappareilQuery groupByEtat() Group by the etat column
 * @method     ChildPhotoappareilQuery groupByIdAp_PK() Group by the idAp_PK column
 * @method     ChildPhotoappareilQuery groupBymodele_PK() Group by the modele_PK column
 * @method     ChildPhotoappareilQuery groupBymarque_PK() Group by the marque_PK column
 *
 * @method     ChildPhotoappareilQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPhotoappareilQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPhotoappareilQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPhotoappareilQuery leftJoinAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appareil relation
 * @method     ChildPhotoappareilQuery rightJoinAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appareil relation
 * @method     ChildPhotoappareilQuery innerJoinAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Appareil relation
 *
 * @method     ChildPhotoappareilQuery leftJoinModele($relationAlias = null) Adds a LEFT JOIN clause to the query using the Modele relation
 * @method     ChildPhotoappareilQuery rightJoinModele($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Modele relation
 * @method     ChildPhotoappareilQuery innerJoinModele($relationAlias = null) Adds a INNER JOIN clause to the query using the Modele relation
 *
 * @method     ChildPhotoappareilQuery leftJoinMarque($relationAlias = null) Adds a LEFT JOIN clause to the query using the Marque relation
 * @method     ChildPhotoappareilQuery rightJoinMarque($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Marque relation
 * @method     ChildPhotoappareilQuery innerJoinMarque($relationAlias = null) Adds a INNER JOIN clause to the query using the Marque relation
 *
 * @method     \AppareilQuery|\ModelQuery|\MarqueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPhotoappareil findOne(ConnectionInterface $con = null) Return the first ChildPhotoappareil matching the query
 * @method     ChildPhotoappareil findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPhotoappareil matching the query, or a new ChildPhotoappareil object populated from the query conditions when no match is found
 *
 * @method     ChildPhotoappareil findOneByID(int $id) Return the first ChildPhotoappareil filtered by the id column
 * @method     ChildPhotoappareil findOneByPhoto(string $url_photo) Return the first ChildPhotoappareil filtered by the url_photo column
 * @method     ChildPhotoappareil findOneByDatephoto(string $date_photo) Return the first ChildPhotoappareil filtered by the date_photo column
 * @method     ChildPhotoappareil findOneByTitre(string $titre_photo) Return the first ChildPhotoappareil filtered by the titre_photo column
 * @method     ChildPhotoappareil findOneByCommentaire(string $commentaire) Return the first ChildPhotoappareil filtered by the commentaire column
 * @method     ChildPhotoappareil findOneByEtat(boolean $etat) Return the first ChildPhotoappareil filtered by the etat column
 * @method     ChildPhotoappareil findOneByIdAp_PK(string $idAp_PK) Return the first ChildPhotoappareil filtered by the idAp_PK column
 * @method     ChildPhotoappareil findOneBymodele_PK(string $modele_PK) Return the first ChildPhotoappareil filtered by the modele_PK column
 * @method     ChildPhotoappareil findOneBymarque_PK(string $marque_PK) Return the first ChildPhotoappareil filtered by the marque_PK column *

 * @method     ChildPhotoappareil requirePk($key, ConnectionInterface $con = null) Return the ChildPhotoappareil by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOne(ConnectionInterface $con = null) Return the first ChildPhotoappareil matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPhotoappareil requireOneByID(int $id) Return the first ChildPhotoappareil filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOneByPhoto(string $url_photo) Return the first ChildPhotoappareil filtered by the url_photo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOneByDatephoto(string $date_photo) Return the first ChildPhotoappareil filtered by the date_photo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOneByTitre(string $titre_photo) Return the first ChildPhotoappareil filtered by the titre_photo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOneByCommentaire(string $commentaire) Return the first ChildPhotoappareil filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOneByEtat(boolean $etat) Return the first ChildPhotoappareil filtered by the etat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOneByIdAp_PK(string $idAp_PK) Return the first ChildPhotoappareil filtered by the idAp_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOneBymodele_PK(string $modele_PK) Return the first ChildPhotoappareil filtered by the modele_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotoappareil requireOneBymarque_PK(string $marque_PK) Return the first ChildPhotoappareil filtered by the marque_PK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPhotoappareil[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPhotoappareil objects based on current ModelCriteria
 * @method     ChildPhotoappareil[]|ObjectCollection findByID(int $id) Return ChildPhotoappareil objects filtered by the id column
 * @method     ChildPhotoappareil[]|ObjectCollection findByPhoto(string $url_photo) Return ChildPhotoappareil objects filtered by the url_photo column
 * @method     ChildPhotoappareil[]|ObjectCollection findByDatephoto(string $date_photo) Return ChildPhotoappareil objects filtered by the date_photo column
 * @method     ChildPhotoappareil[]|ObjectCollection findByTitre(string $titre_photo) Return ChildPhotoappareil objects filtered by the titre_photo column
 * @method     ChildPhotoappareil[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildPhotoappareil objects filtered by the commentaire column
 * @method     ChildPhotoappareil[]|ObjectCollection findByEtat(boolean $etat) Return ChildPhotoappareil objects filtered by the etat column
 * @method     ChildPhotoappareil[]|ObjectCollection findByIdAp_PK(string $idAp_PK) Return ChildPhotoappareil objects filtered by the idAp_PK column
 * @method     ChildPhotoappareil[]|ObjectCollection findBymodele_PK(string $modele_PK) Return ChildPhotoappareil objects filtered by the modele_PK column
 * @method     ChildPhotoappareil[]|ObjectCollection findBymarque_PK(string $marque_PK) Return ChildPhotoappareil objects filtered by the marque_PK column
 * @method     ChildPhotoappareil[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PhotoappareilQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PhotoappareilQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Photoappareil', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPhotoappareilQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPhotoappareilQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPhotoappareilQuery) {
            return $criteria;
        }
        $query = new ChildPhotoappareilQuery();
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
     * $obj = $c->findPk(array(12, 34, 56, 78), $con);
     * </code>
     *
     * @param array[$id, $idAp_PK, $modele_PK, $marque_PK] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPhotoappareil|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PhotoappareilTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2], (string) $key[3]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PhotoappareilTableMap::DATABASE_NAME);
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
     * @return ChildPhotoappareil A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, url_photo, date_photo, titre_photo, commentaire, etat, idAp_PK, modele_PK, marque_PK FROM photo_appareil WHERE id = :p0 AND idAp_PK = :p1 AND modele_PK = :p2 AND marque_PK = :p3';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_STR);
            $stmt->bindValue(':p3', $key[3], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPhotoappareil $obj */
            $obj = new ChildPhotoappareil();
            $obj->hydrate($row);
            PhotoappareilTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2], (string) $key[3])));
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
     * @return ChildPhotoappareil|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PhotoappareilTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PhotoappareilTableMap::COL_IDAP_PK, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(PhotoappareilTableMap::COL_MODELE_PK, $key[2], Criteria::EQUAL);
        $this->addUsingAlias(PhotoappareilTableMap::COL_MARQUE_PK, $key[3], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PhotoappareilTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PhotoappareilTableMap::COL_IDAP_PK, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(PhotoappareilTableMap::COL_MODELE_PK, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $cton3 = $this->getNewCriterion(PhotoappareilTableMap::COL_MARQUE_PK, $key[3], Criteria::EQUAL);
            $cton0->addAnd($cton3);
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
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(PhotoappareilTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(PhotoappareilTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PhotoappareilTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the url_photo column
     *
     * Example usage:
     * <code>
     * $query->filterByPhoto('fooValue');   // WHERE url_photo = 'fooValue'
     * $query->filterByPhoto('%fooValue%'); // WHERE url_photo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $photo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByPhoto($photo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($photo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $photo)) {
                $photo = str_replace('*', '%', $photo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PhotoappareilTableMap::COL_URL_PHOTO, $photo, $comparison);
    }

    /**
     * Filter the query on the date_photo column
     *
     * Example usage:
     * <code>
     * $query->filterByDatephoto('2011-03-14'); // WHERE date_photo = '2011-03-14'
     * $query->filterByDatephoto('now'); // WHERE date_photo = '2011-03-14'
     * $query->filterByDatephoto(array('max' => 'yesterday')); // WHERE date_photo > '2011-03-13'
     * </code>
     *
     * @param     mixed $datephoto The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByDatephoto($datephoto = null, $comparison = null)
    {
        if (is_array($datephoto)) {
            $useMinMax = false;
            if (isset($datephoto['min'])) {
                $this->addUsingAlias(PhotoappareilTableMap::COL_DATE_PHOTO, $datephoto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datephoto['max'])) {
                $this->addUsingAlias(PhotoappareilTableMap::COL_DATE_PHOTO, $datephoto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PhotoappareilTableMap::COL_DATE_PHOTO, $datephoto, $comparison);
    }

    /**
     * Filter the query on the titre_photo column
     *
     * Example usage:
     * <code>
     * $query->filterByTitre('fooValue');   // WHERE titre_photo = 'fooValue'
     * $query->filterByTitre('%fooValue%'); // WHERE titre_photo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $titre The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PhotoappareilTableMap::COL_TITRE_PHOTO, $titre, $comparison);
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
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PhotoappareilTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
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
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByEtat($etat = null, $comparison = null)
    {
        if (is_string($etat)) {
            $etat = in_array(strtolower($etat), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PhotoappareilTableMap::COL_ETAT, $etat, $comparison);
    }

    /**
     * Filter the query on the idAp_PK column
     *
     * Example usage:
     * <code>
     * $query->filterByIdAp_PK('fooValue');   // WHERE idAp_PK = 'fooValue'
     * $query->filterByIdAp_PK('%fooValue%'); // WHERE idAp_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idAp_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByIdAp_PK($idAp_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idAp_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $idAp_PK)) {
                $idAp_PK = str_replace('*', '%', $idAp_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PhotoappareilTableMap::COL_IDAP_PK, $idAp_PK, $comparison);
    }

    /**
     * Filter the query on the modele_PK column
     *
     * Example usage:
     * <code>
     * $query->filterBymodele_PK('fooValue');   // WHERE modele_PK = 'fooValue'
     * $query->filterBymodele_PK('%fooValue%'); // WHERE modele_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $modele_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterBymodele_PK($modele_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($modele_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $modele_PK)) {
                $modele_PK = str_replace('*', '%', $modele_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PhotoappareilTableMap::COL_MODELE_PK, $modele_PK, $comparison);
    }

    /**
     * Filter the query on the marque_PK column
     *
     * Example usage:
     * <code>
     * $query->filterBymarque_PK('fooValue');   // WHERE marque_PK = 'fooValue'
     * $query->filterBymarque_PK('%fooValue%'); // WHERE marque_PK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $marque_PK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterBymarque_PK($marque_PK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($marque_PK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $marque_PK)) {
                $marque_PK = str_replace('*', '%', $marque_PK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PhotoappareilTableMap::COL_MARQUE_PK, $marque_PK, $comparison);
    }

    /**
     * Filter the query by a related \Appareil object
     *
     * @param \Appareil|ObjectCollection $appareil The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByAppareil($appareil, $comparison = null)
    {
        if ($appareil instanceof \Appareil) {
            return $this
                ->addUsingAlias(PhotoappareilTableMap::COL_IDAP_PK, $appareil->getIdAppareil(), $comparison);
        } elseif ($appareil instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PhotoappareilTableMap::COL_IDAP_PK, $appareil->toKeyValue('IdAppareil', 'IdAppareil'), $comparison);
        } else {
            throw new PropelException('filterByAppareil() only accepts arguments of type \Appareil or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Appareil relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function joinAppareil($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Appareil');

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
            $this->addJoinObject($join, 'Appareil');
        }

        return $this;
    }

    /**
     * Use the Appareil relation Appareil object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AppareilQuery A secondary query class using the current class as primary query
     */
    public function useAppareilQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAppareil($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Appareil', '\AppareilQuery');
    }

    /**
     * Filter the query by a related \Model object
     *
     * @param \Model|ObjectCollection $model The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByModele($model, $comparison = null)
    {
        if ($model instanceof \Model) {
            return $this
                ->addUsingAlias(PhotoappareilTableMap::COL_MODELE_PK, $model->getModele(), $comparison);
        } elseif ($model instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PhotoappareilTableMap::COL_MODELE_PK, $model->toKeyValue('PrimaryKey', 'Modele'), $comparison);
        } else {
            throw new PropelException('filterByModele() only accepts arguments of type \Model or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Modele relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function joinModele($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Modele');

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
            $this->addJoinObject($join, 'Modele');
        }

        return $this;
    }

    /**
     * Use the Modele relation Model object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ModelQuery A secondary query class using the current class as primary query
     */
    public function useModeleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinModele($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Modele', '\ModelQuery');
    }

    /**
     * Filter the query by a related \Marque object
     *
     * @param \Marque|ObjectCollection $marque The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function filterByMarque($marque, $comparison = null)
    {
        if ($marque instanceof \Marque) {
            return $this
                ->addUsingAlias(PhotoappareilTableMap::COL_MARQUE_PK, $marque->getMarque(), $comparison);
        } elseif ($marque instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PhotoappareilTableMap::COL_MARQUE_PK, $marque->toKeyValue('PrimaryKey', 'Marque'), $comparison);
        } else {
            throw new PropelException('filterByMarque() only accepts arguments of type \Marque or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Marque relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function joinMarque($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Marque');

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
            $this->addJoinObject($join, 'Marque');
        }

        return $this;
    }

    /**
     * Use the Marque relation Marque object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MarqueQuery A secondary query class using the current class as primary query
     */
    public function useMarqueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMarque($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Marque', '\MarqueQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPhotoappareil $photoappareil Object to remove from the list of results
     *
     * @return $this|ChildPhotoappareilQuery The current query, for fluid interface
     */
    public function prune($photoappareil = null)
    {
        if ($photoappareil) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PhotoappareilTableMap::COL_ID), $photoappareil->getID(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PhotoappareilTableMap::COL_IDAP_PK), $photoappareil->getIdAp_PK(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(PhotoappareilTableMap::COL_MODELE_PK), $photoappareil->getmodele_PK(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond3', $this->getAliasedColName(PhotoappareilTableMap::COL_MARQUE_PK), $photoappareil->getmarque_PK(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2', 'pruneCond3'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the photo_appareil table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PhotoappareilTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PhotoappareilTableMap::clearInstancePool();
            PhotoappareilTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PhotoappareilTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PhotoappareilTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PhotoappareilTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PhotoappareilTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PhotoappareilQuery
