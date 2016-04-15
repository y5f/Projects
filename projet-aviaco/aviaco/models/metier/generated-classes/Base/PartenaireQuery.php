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
 * @method     ChildPartenaireQuery orderByPartenaire($order = Criteria::ASC) Order by the part_id column
 * @method     ChildPartenaireQuery orderByNompartenaire($order = Criteria::ASC) Order by the part_nom column
 * @method     ChildPartenaireQuery orderByAdresses($order = Criteria::ASC) Order by the part_adresse column
 * @method     ChildPartenaireQuery orderByTelephone($order = Criteria::ASC) Order by the part_tel column
 * @method     ChildPartenaireQuery orderByEmail($order = Criteria::ASC) Order by the part_mail column
 * @method     ChildPartenaireQuery orderByLogo($order = Criteria::ASC) Order by the part_logo column
 *
 * @method     ChildPartenaireQuery groupByPartenaire() Group by the part_id column
 * @method     ChildPartenaireQuery groupByNompartenaire() Group by the part_nom column
 * @method     ChildPartenaireQuery groupByAdresses() Group by the part_adresse column
 * @method     ChildPartenaireQuery groupByTelephone() Group by the part_tel column
 * @method     ChildPartenaireQuery groupByEmail() Group by the part_mail column
 * @method     ChildPartenaireQuery groupByLogo() Group by the part_logo column
 *
 * @method     ChildPartenaireQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPartenaireQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPartenaireQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPartenaireQuery leftJoinPartenairepiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenairepiece relation
 * @method     ChildPartenaireQuery rightJoinPartenairepiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenairepiece relation
 * @method     ChildPartenaireQuery innerJoinPartenairepiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenairepiece relation
 *
 * @method     ChildPartenaireQuery leftJoinDoc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Doc relation
 * @method     ChildPartenaireQuery rightJoinDoc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Doc relation
 * @method     ChildPartenaireQuery innerJoinDoc($relationAlias = null) Adds a INNER JOIN clause to the query using the Doc relation
 *
 * @method     ChildPartenaireQuery leftJoinDepotpartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Depotpartenaire relation
 * @method     ChildPartenaireQuery rightJoinDepotpartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Depotpartenaire relation
 * @method     ChildPartenaireQuery innerJoinDepotpartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Depotpartenaire relation
 *
 * @method     \PartenairepieceQuery|\DocumentQuery|\DepotpartenaireQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPartenaire findOne(ConnectionInterface $con = null) Return the first ChildPartenaire matching the query
 * @method     ChildPartenaire findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPartenaire matching the query, or a new ChildPartenaire object populated from the query conditions when no match is found
 *
 * @method     ChildPartenaire findOneByPartenaire(int $part_id) Return the first ChildPartenaire filtered by the part_id column
 * @method     ChildPartenaire findOneByNompartenaire(string $part_nom) Return the first ChildPartenaire filtered by the part_nom column
 * @method     ChildPartenaire findOneByAdresses(string $part_adresse) Return the first ChildPartenaire filtered by the part_adresse column
 * @method     ChildPartenaire findOneByTelephone(string $part_tel) Return the first ChildPartenaire filtered by the part_tel column
 * @method     ChildPartenaire findOneByEmail(string $part_mail) Return the first ChildPartenaire filtered by the part_mail column
 * @method     ChildPartenaire findOneByLogo(string $part_logo) Return the first ChildPartenaire filtered by the part_logo column *

 * @method     ChildPartenaire requirePk($key, ConnectionInterface $con = null) Return the ChildPartenaire by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOne(ConnectionInterface $con = null) Return the first ChildPartenaire matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPartenaire requireOneByPartenaire(int $part_id) Return the first ChildPartenaire filtered by the part_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByNompartenaire(string $part_nom) Return the first ChildPartenaire filtered by the part_nom column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByAdresses(string $part_adresse) Return the first ChildPartenaire filtered by the part_adresse column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByTelephone(string $part_tel) Return the first ChildPartenaire filtered by the part_tel column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByEmail(string $part_mail) Return the first ChildPartenaire filtered by the part_mail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPartenaire requireOneByLogo(string $part_logo) Return the first ChildPartenaire filtered by the part_logo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPartenaire[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPartenaire objects based on current ModelCriteria
 * @method     ChildPartenaire[]|ObjectCollection findByPartenaire(int $part_id) Return ChildPartenaire objects filtered by the part_id column
 * @method     ChildPartenaire[]|ObjectCollection findByNompartenaire(string $part_nom) Return ChildPartenaire objects filtered by the part_nom column
 * @method     ChildPartenaire[]|ObjectCollection findByAdresses(string $part_adresse) Return ChildPartenaire objects filtered by the part_adresse column
 * @method     ChildPartenaire[]|ObjectCollection findByTelephone(string $part_tel) Return ChildPartenaire objects filtered by the part_tel column
 * @method     ChildPartenaire[]|ObjectCollection findByEmail(string $part_mail) Return ChildPartenaire objects filtered by the part_mail column
 * @method     ChildPartenaire[]|ObjectCollection findByLogo(string $part_logo) Return ChildPartenaire objects filtered by the part_logo column
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
    public function __construct($dbName = 'aviaco', $modelName = '\\Partenaire', $modelAlias = null)
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
        $sql = 'SELECT part_id, part_nom, part_adresse, part_tel, part_mail, part_logo FROM partenaire WHERE part_id = :p0';
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

        return $this->addUsingAlias(PartenaireTableMap::COL_PART_ID, $key, Criteria::EQUAL);
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

        return $this->addUsingAlias(PartenaireTableMap::COL_PART_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the part_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPartenaire(1234); // WHERE part_id = 1234
     * $query->filterByPartenaire(array(12, 34)); // WHERE part_id IN (12, 34)
     * $query->filterByPartenaire(array('min' => 12)); // WHERE part_id > 12
     * </code>
     *
     * @param     mixed $partenaire The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByPartenaire($partenaire = null, $comparison = null)
    {
        if (is_array($partenaire)) {
            $useMinMax = false;
            if (isset($partenaire['min'])) {
                $this->addUsingAlias(PartenaireTableMap::COL_PART_ID, $partenaire['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($partenaire['max'])) {
                $this->addUsingAlias(PartenaireTableMap::COL_PART_ID, $partenaire['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_PART_ID, $partenaire, $comparison);
    }

    /**
     * Filter the query on the part_nom column
     *
     * Example usage:
     * <code>
     * $query->filterByNompartenaire('fooValue');   // WHERE part_nom = 'fooValue'
     * $query->filterByNompartenaire('%fooValue%'); // WHERE part_nom LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nompartenaire The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByNompartenaire($nompartenaire = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nompartenaire)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nompartenaire)) {
                $nompartenaire = str_replace('*', '%', $nompartenaire);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartenaireTableMap::COL_PART_NOM, $nompartenaire, $comparison);
    }

    /**
     * Filter the query on the part_adresse column
     *
     * Example usage:
     * <code>
     * $query->filterByAdresses('fooValue');   // WHERE part_adresse = 'fooValue'
     * $query->filterByAdresses('%fooValue%'); // WHERE part_adresse LIKE '%fooValue%'
     * </code>
     *
     * @param     string $adresses The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PartenaireTableMap::COL_PART_ADRESSE, $adresses, $comparison);
    }

    /**
     * Filter the query on the part_tel column
     *
     * Example usage:
     * <code>
     * $query->filterByTelephone('fooValue');   // WHERE part_tel = 'fooValue'
     * $query->filterByTelephone('%fooValue%'); // WHERE part_tel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telephone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PartenaireTableMap::COL_PART_TEL, $telephone, $comparison);
    }

    /**
     * Filter the query on the part_mail column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE part_mail = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE part_mail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PartenaireTableMap::COL_PART_MAIL, $email, $comparison);
    }

    /**
     * Filter the query on the part_logo column
     *
     * Example usage:
     * <code>
     * $query->filterByLogo('fooValue');   // WHERE part_logo = 'fooValue'
     * $query->filterByLogo('%fooValue%'); // WHERE part_logo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $logo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PartenaireTableMap::COL_PART_LOGO, $logo, $comparison);
    }

    /**
     * Filter the query by a related \Partenairepiece object
     *
     * @param \Partenairepiece|ObjectCollection $partenairepiece the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByPartenairepiece($partenairepiece, $comparison = null)
    {
        if ($partenairepiece instanceof \Partenairepiece) {
            return $this
                ->addUsingAlias(PartenaireTableMap::COL_PART_ID, $partenairepiece->getPartenaire_PK(), $comparison);
        } elseif ($partenairepiece instanceof ObjectCollection) {
            return $this
                ->usePartenairepieceQuery()
                ->filterByPrimaryKeys($partenairepiece->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPartenairepiece() only accepts arguments of type \Partenairepiece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Partenairepiece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function joinPartenairepiece($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Partenairepiece');

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
            $this->addJoinObject($join, 'Partenairepiece');
        }

        return $this;
    }

    /**
     * Use the Partenairepiece relation Partenairepiece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PartenairepieceQuery A secondary query class using the current class as primary query
     */
    public function usePartenairepieceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPartenairepiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Partenairepiece', '\PartenairepieceQuery');
    }

    /**
     * Filter the query by a related \Document object
     *
     * @param \Document|ObjectCollection $document the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByDoc($document, $comparison = null)
    {
        if ($document instanceof \Document) {
            return $this
                ->addUsingAlias(PartenaireTableMap::COL_PART_ID, $document->getPart_id_FK(), $comparison);
        } elseif ($document instanceof ObjectCollection) {
            return $this
                ->useDocQuery()
                ->filterByPrimaryKeys($document->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDoc() only accepts arguments of type \Document or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Doc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function joinDoc($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Doc');

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
            $this->addJoinObject($join, 'Doc');
        }

        return $this;
    }

    /**
     * Use the Doc relation Document object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DocumentQuery A secondary query class using the current class as primary query
     */
    public function useDocQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDoc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Doc', '\DocumentQuery');
    }

    /**
     * Filter the query by a related \Depotpartenaire object
     *
     * @param \Depotpartenaire|ObjectCollection $depotpartenaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPartenaireQuery The current query, for fluid interface
     */
    public function filterByDepotpartenaire($depotpartenaire, $comparison = null)
    {
        if ($depotpartenaire instanceof \Depotpartenaire) {
            return $this
                ->addUsingAlias(PartenaireTableMap::COL_PART_ID, $depotpartenaire->getPart_id_PK(), $comparison);
        } elseif ($depotpartenaire instanceof ObjectCollection) {
            return $this
                ->useDepotpartenaireQuery()
                ->filterByPrimaryKeys($depotpartenaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDepotpartenaire() only accepts arguments of type \Depotpartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Depotpartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPartenaireQuery The current query, for fluid interface
     */
    public function joinDepotpartenaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Depotpartenaire');

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
            $this->addJoinObject($join, 'Depotpartenaire');
        }

        return $this;
    }

    /**
     * Use the Depotpartenaire relation Depotpartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DepotpartenaireQuery A secondary query class using the current class as primary query
     */
    public function useDepotpartenaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDepotpartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Depotpartenaire', '\DepotpartenaireQuery');
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
            $this->addUsingAlias(PartenaireTableMap::COL_PART_ID, $partenaire->getPartenaire(), Criteria::NOT_EQUAL);
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
