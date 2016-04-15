<?php

namespace Base;

use \Partenaire as ChildPartenaire;
use \PartenaireQuery as ChildPartenaireQuery;
use \Exception;
use \PDO;
use Map\PartenaireTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'partenaire' table.
 *
 *
 *
 * @method     ChildPartenaireQuery orderByID($order = Criteria::ASC) Order by the indx column
 * @method     ChildPartenaireQuery orderByPartenaire($order = Criteria::ASC) Order by the partenaire column
 * @method     ChildPartenaireQuery orderByIDPartenaire($order = Criteria::ASC) Order by the id_part column
 * @method     ChildPartenaireQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildPartenaireQuery orderByLienweb($order = Criteria::ASC) Order by the lien column
 * @method     ChildPartenaireQuery orderBymail($order = Criteria::ASC) Order by the mail column
 * @method     ChildPartenaireQuery orderByTypePart($order = Criteria::ASC) Order by the type_part column
 *
 * @method     ChildPartenaireQuery groupByID() Group by the indx column
 * @method     ChildPartenaireQuery groupByPartenaire() Group by the partenaire column
 * @method     ChildPartenaireQuery groupByIDPartenaire() Group by the id_part column
 * @method     ChildPartenaireQuery groupByCode() Group by the code column
 * @method     ChildPartenaireQuery groupByLienweb() Group by the lien column
 * @method     ChildPartenaireQuery groupBymail() Group by the mail column
 * @method     ChildPartenaireQuery groupByTypePart() Group by the type_part column
 *
 * @method     ChildPartenaireQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPartenaireQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPartenaireQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPartenaireQuery leftJoinAnnonceur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Annonceur relation
 * @method     ChildPartenaireQuery rightJoinAnnonceur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Annonceur relation
 * @method     ChildPartenaireQuery innerJoinAnnonceur($relationAlias = null) Adds a INNER JOIN clause to the query using the Annonceur relation
 *
 * @method     ChildPartenaireQuery leftJoinFPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the FPartenaire relation
 * @method     ChildPartenaireQuery rightJoinFPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FPartenaire relation
 * @method     ChildPartenaireQuery innerJoinFPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the FPartenaire relation
 *
 * @method     ChildPartenaireQuery leftJoinSPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the SPartenaire relation
 * @method     ChildPartenaireQuery rightJoinSPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SPartenaire relation
 * @method     ChildPartenaireQuery innerJoinSPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the SPartenaire relation
 *
 * @method     ChildPartenaireQuery leftJoinBPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the BPartenaire relation
 * @method     ChildPartenaireQuery rightJoinBPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BPartenaire relation
 * @method     ChildPartenaireQuery innerJoinBPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the BPartenaire relation
 *
 * @method     \AnnonceurQuery|\FPartenaireQuery|\SPartenaireQuery|\BPartenaireQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPartenaire findOne(ConnectionInterface $con = null) Return the first ChildPartenaire matching the query
 * @method     ChildPartenaire findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPartenaire matching the query, or a new ChildPartenaire object populated from the query conditions when no match is found
 *
 * @method     ChildPartenaire findOneByID(int $indx) Return the first ChildPartenaire filtered by the indx column
 * @method     ChildPartenaire findOneByPartenaire(string $partenaire) Return the first ChildPartenaire filtered by the partenaire column
 * @method     ChildPartenaire findOneByIDPartenaire(string $id_part) Return the first ChildPartenaire filtered by the id_part column
 * @method     ChildPartenaire findOneByCode(string $code) Return the first ChildPartenaire filtered by the code column
 * @method     ChildPartenaire findOneByLienweb(string $lien) Return the first ChildPartenaire filtered by the lien column
 * @method     ChildPartenaire findOneBymail(string $mail) Return the first ChildPartenaire filtered by the mail column
 * @method     ChildPartenaire findOneByTypePart(string $type_part) Return the first ChildPartenaire filtered by the type_part column *

 * @method     ChildPartenaire requirePk($key, ConnectionInterface $con = null) Return the ChildPartenaire by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOne(ConnectionInterface $con = null) Return the first ChildPartenaire matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPartenaire requireOneByID(int $indx) Return the first ChildPartenaire filtered by the indx column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByPartenaire(string $partenaire) Return the first ChildPartenaire filtered by the partenaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByIDPartenaire(string $id_part) Return the first ChildPartenaire filtered by the id_part column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByCode(string $code) Return the first ChildPartenaire filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByLienweb(string $lien) Return the first ChildPartenaire filtered by the lien column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneBymail(string $mail) Return the first ChildPartenaire filtered by the mail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByTypePart(string $type_part) Return the first ChildPartenaire filtered by the type_part column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPartenaire[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPartenaire objects based on current ModelCriteria
 * @method     ChildPartenaire[]|ObjectCollection findByID(int $indx) Return ChildPartenaire objects filtered by the indx column
 * @method     ChildPartenaire[]|ObjectCollection findByPartenaire(string $partenaire) Return ChildPartenaire objects filtered by the partenaire column
 * @method     ChildPartenaire[]|ObjectCollection findByIDPartenaire(string $id_part) Return ChildPartenaire objects filtered by the id_part column
 * @method     ChildPartenaire[]|ObjectCollection findByCode(string $code) Return ChildPartenaire objects filtered by the code column
 * @method     ChildPartenaire[]|ObjectCollection findByLienweb(string $lien) Return ChildPartenaire objects filtered by the lien column
 * @method     ChildPartenaire[]|ObjectCollection findBymail(string $mail) Return ChildPartenaire objects filtered by the mail column
 * @method     ChildPartenaire[]|ObjectCollection findByTypePart(string $type_part) Return ChildPartenaire objects filtered by the type_part column
 * @method     ChildPartenaire[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PartenaireQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PartenaireQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Partenaire', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPartenaireQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPartenaireQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPartenaireQuery) {
            return $criteria;
        }
        $query = new ChildPartenaireQuery();
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
     * @return ChildPartenaire|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PartenaireTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PartenaireTableMap::DATABASE_NAME);
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
     * @return ChildPartenaire A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT indx, partenaire, id_part, code, lien, mail, type_part FROM partenaire WHERE indx = :p0';
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
            /** @var ChildPartenaire $obj */
            $obj = new ChildPartenaire();
            $obj->hydrate($row);
            PartenaireTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPartenaire|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PartenaireTableMap::COL_INDX, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PartenaireTableMap::COL_INDX, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the indx column
     *
     * Example usage:
     * <code>
     * $query->filterByID(1234); // WHERE indx = 1234
     * $query->filterByID(array(12, 34)); // WHERE indx IN (12, 34)
     * $query->filterByID(array('min' => 12)); // WHERE indx > 12
     * </code>
     *
     * @param     mixed $iD The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(PartenaireTableMap::COL_INDX, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(PartenaireTableMap::COL_INDX, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_INDX, $iD, $comparison);
    }

    /**
     * Filter the query on the partenaire column
     *
     * Example usage:
     * <code>
     * $query->filterByPartenaire('fooValue');   // WHERE partenaire = 'fooValue'
     * $query->filterByPartenaire('%fooValue%'); // WHERE partenaire LIKE '%fooValue%'
     * </code>
     *
     * @param     string $partenaire The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByPartenaire($partenaire = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($partenaire)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $partenaire)) {
                $partenaire = str_replace('*', '%', $partenaire);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_PARTENAIRE, $partenaire, $comparison);
    }

    /**
     * Filter the query on the id_part column
     *
     * Example usage:
     * <code>
     * $query->filterByIDPartenaire('fooValue');   // WHERE id_part = 'fooValue'
     * $query->filterByIDPartenaire('%fooValue%'); // WHERE id_part LIKE '%fooValue%'
     * </code>
     *
     * @param     string $iDPartenaire The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByIDPartenaire($iDPartenaire = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($iDPartenaire)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $iDPartenaire)) {
                $iDPartenaire = str_replace('*', '%', $iDPartenaire);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_ID_PART, $iDPartenaire, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the lien column
     *
     * Example usage:
     * <code>
     * $query->filterByLienweb('fooValue');   // WHERE lien = 'fooValue'
     * $query->filterByLienweb('%fooValue%'); // WHERE lien LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lienweb The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByLienweb($lienweb = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lienweb)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lienweb)) {
                $lienweb = str_replace('*', '%', $lienweb);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_LIEN, $lienweb, $comparison);
    }

    /**
     * Filter the query on the mail column
     *
     * Example usage:
     * <code>
     * $query->filterBymail('fooValue');   // WHERE mail = 'fooValue'
     * $query->filterBymail('%fooValue%'); // WHERE mail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterBymail($mail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mail)) {
                $mail = str_replace('*', '%', $mail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_MAIL, $mail, $comparison);
    }

    /**
     * Filter the query on the type_part column
     *
     * Example usage:
     * <code>
     * $query->filterByTypePart('fooValue');   // WHERE type_part = 'fooValue'
     * $query->filterByTypePart('%fooValue%'); // WHERE type_part LIKE '%fooValue%'
     * </code>
     *
     * @param     string $typePart The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByTypePart($typePart = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($typePart)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $typePart)) {
                $typePart = str_replace('*', '%', $typePart);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_TYPE_PART, $typePart, $comparison);
    }

    /**
     * Filter the query by a related \Annonceur object
     *
     * @param \Annonceur|ObjectCollection $annonceur the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByAnnonceur($annonceur, $comparison = null)
    {
        if ($annonceur instanceof \Annonceur) {
            return $this
                ->addUsingAlias(PartenaireTableMap::COL_INDX, $annonceur->getIDPart(), $comparison);
        } elseif ($annonceur instanceof ObjectCollection) {
            return $this
                ->useAnnonceurQuery()
                ->filterByPrimaryKeys($annonceur->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAnnonceur() only accepts arguments of type \Annonceur or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Annonceur relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function joinAnnonceur($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Annonceur');

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
            $this->addJoinObject($join, 'Annonceur');
        }

        return $this;
    }

    /**
     * Use the Annonceur relation Annonceur object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AnnonceurQuery A secondary query class using the current class as primary query
     */
    public function useAnnonceurQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnnonceur($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Annonceur', '\AnnonceurQuery');
    }

    /**
     * Filter the query by a related \FPartenaire object
     *
     * @param \FPartenaire|ObjectCollection $fPartenaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByFPartenaire($fPartenaire, $comparison = null)
    {
        if ($fPartenaire instanceof \FPartenaire) {
            return $this
                ->addUsingAlias(PartenaireTableMap::COL_INDX, $fPartenaire->getIDPart(), $comparison);
        } elseif ($fPartenaire instanceof ObjectCollection) {
            return $this
                ->useFPartenaireQuery()
                ->filterByPrimaryKeys($fPartenaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFPartenaire() only accepts arguments of type \FPartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FPartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function joinFPartenaire($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FPartenaire');

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
            $this->addJoinObject($join, 'FPartenaire');
        }

        return $this;
    }

    /**
     * Use the FPartenaire relation FPartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FPartenaireQuery A secondary query class using the current class as primary query
     */
    public function useFPartenaireQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FPartenaire', '\FPartenaireQuery');
    }

    /**
     * Filter the query by a related \SPartenaire object
     *
     * @param \SPartenaire|ObjectCollection $sPartenaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterBySPartenaire($sPartenaire, $comparison = null)
    {
        if ($sPartenaire instanceof \SPartenaire) {
            return $this
                ->addUsingAlias(PartenaireTableMap::COL_INDX, $sPartenaire->getPPlaigante(), $comparison);
        } elseif ($sPartenaire instanceof ObjectCollection) {
            return $this
                ->useSPartenaireQuery()
                ->filterByPrimaryKeys($sPartenaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySPartenaire() only accepts arguments of type \SPartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SPartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function joinSPartenaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SPartenaire');

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
            $this->addJoinObject($join, 'SPartenaire');
        }

        return $this;
    }

    /**
     * Use the SPartenaire relation SPartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPartenaireQuery A secondary query class using the current class as primary query
     */
    public function useSPartenaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SPartenaire', '\SPartenaireQuery');
    }

    /**
     * Filter the query by a related \BPartenaire object
     *
     * @param \BPartenaire|ObjectCollection $bPartenaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByBPartenaire($bPartenaire, $comparison = null)
    {
        if ($bPartenaire instanceof \BPartenaire) {
            return $this
                ->addUsingAlias(PartenaireTableMap::COL_INDX, $bPartenaire->getIDPart(), $comparison);
        } elseif ($bPartenaire instanceof ObjectCollection) {
            return $this
                ->useBPartenaireQuery()
                ->filterByPrimaryKeys($bPartenaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBPartenaire() only accepts arguments of type \BPartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BPartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function joinBPartenaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BPartenaire');

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
            $this->addJoinObject($join, 'BPartenaire');
        }

        return $this;
    }

    /**
     * Use the BPartenaire relation BPartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BPartenaireQuery A secondary query class using the current class as primary query
     */
    public function useBPartenaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BPartenaire', '\BPartenaireQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPartenaire $partenaire Object to remove from the list of results
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function prune($partenaire = null)
    {
        if ($partenaire) {
            $this->addUsingAlias(PartenaireTableMap::COL_INDX, $partenaire->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the partenaire table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PartenaireTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PartenaireTableMap::clearInstancePool();
            PartenaireTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PartenaireTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PartenaireTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PartenaireTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PartenaireTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PartenaireQuery
