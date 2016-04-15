<?php

namespace Base;

use \Rubrique as ChildRubrique;
use \RubriqueQuery as ChildRubriqueQuery;
use \Exception;
use \PDO;
use Map\RubriqueTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rubrique' table.
 *
 *
 *
 * @method     ChildRubriqueQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildRubriqueQuery orderByRubriqueCol($order = Criteria::ASC) Order by the rubrique column
 * @method     ChildRubriqueQuery orderByURL($order = Criteria::ASC) Order by the url column
 * @method     ChildRubriqueQuery orderByNiveau($order = Criteria::ASC) Order by the Niveau column
 *
 * @method     ChildRubriqueQuery groupByID() Group by the id column
 * @method     ChildRubriqueQuery groupByRubriqueCol() Group by the rubrique column
 * @method     ChildRubriqueQuery groupByURL() Group by the url column
 * @method     ChildRubriqueQuery groupByNiveau() Group by the Niveau column
 *
 * @method     ChildRubriqueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRubriqueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRubriqueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRubriqueQuery leftJoinRubriqueprimaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rubriqueprimaire relation
 * @method     ChildRubriqueQuery rightJoinRubriqueprimaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rubriqueprimaire relation
 * @method     ChildRubriqueQuery innerJoinRubriqueprimaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Rubriqueprimaire relation
 *
 * @method     ChildRubriqueQuery leftJoinRubriquesecondaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rubriquesecondaire relation
 * @method     ChildRubriqueQuery rightJoinRubriquesecondaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rubriquesecondaire relation
 * @method     ChildRubriqueQuery innerJoinRubriquesecondaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Rubriquesecondaire relation
 *
 * @method     \RubriqueprimaireQuery|\RubriquesecondaireQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRubrique findOne(ConnectionInterface $con = null) Return the first ChildRubrique matching the query
 * @method     ChildRubrique findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRubrique matching the query, or a new ChildRubrique object populated from the query conditions when no match is found
 *
 * @method     ChildRubrique findOneByID(int $id) Return the first ChildRubrique filtered by the id column
 * @method     ChildRubrique findOneByRubriqueCol(string $rubrique) Return the first ChildRubrique filtered by the rubrique column
 * @method     ChildRubrique findOneByURL(string $url) Return the first ChildRubrique filtered by the url column
 * @method     ChildRubrique findOneByNiveau(string $Niveau) Return the first ChildRubrique filtered by the Niveau column *

 * @method     ChildRubrique requirePk($key, ConnectionInterface $con = null) Return the ChildRubrique by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRubrique requireOne(ConnectionInterface $con = null) Return the first ChildRubrique matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRubrique requireOneByID(int $id) Return the first ChildRubrique filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRubrique requireOneByRubriqueCol(string $rubrique) Return the first ChildRubrique filtered by the rubrique column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRubrique requireOneByURL(string $url) Return the first ChildRubrique filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRubrique requireOneByNiveau(string $Niveau) Return the first ChildRubrique filtered by the Niveau column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRubrique[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRubrique objects based on current ModelCriteria
 * @method     ChildRubrique[]|ObjectCollection findByID(int $id) Return ChildRubrique objects filtered by the id column
 * @method     ChildRubrique[]|ObjectCollection findByRubriqueCol(string $rubrique) Return ChildRubrique objects filtered by the rubrique column
 * @method     ChildRubrique[]|ObjectCollection findByURL(string $url) Return ChildRubrique objects filtered by the url column
 * @method     ChildRubrique[]|ObjectCollection findByNiveau(string $Niveau) Return ChildRubrique objects filtered by the Niveau column
 * @method     ChildRubrique[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RubriqueQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RubriqueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Rubrique', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRubriqueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRubriqueQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRubriqueQuery) {
            return $criteria;
        }
        $query = new ChildRubriqueQuery();
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
     * @return ChildRubrique|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RubriqueTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RubriqueTableMap::DATABASE_NAME);
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
     * @return ChildRubrique A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, rubrique, url, Niveau FROM rubrique WHERE id = :p0';
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
            /** @var ChildRubrique $obj */
            $obj = new ChildRubrique();
            $obj->hydrate($row);
            RubriqueTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRubrique|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RubriqueTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RubriqueTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(RubriqueTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(RubriqueTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RubriqueTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the rubrique column
     *
     * Example usage:
     * <code>
     * $query->filterByRubriqueCol('fooValue');   // WHERE rubrique = 'fooValue'
     * $query->filterByRubriqueCol('%fooValue%'); // WHERE rubrique LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rubriqueCol The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
     */
    public function filterByRubriqueCol($rubriqueCol = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rubriqueCol)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rubriqueCol)) {
                $rubriqueCol = str_replace('*', '%', $rubriqueCol);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RubriqueTableMap::COL_RUBRIQUE, $rubriqueCol, $comparison);
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
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RubriqueTableMap::COL_URL, $uRL, $comparison);
    }

    /**
     * Filter the query on the Niveau column
     *
     * Example usage:
     * <code>
     * $query->filterByNiveau('fooValue');   // WHERE Niveau = 'fooValue'
     * $query->filterByNiveau('%fooValue%'); // WHERE Niveau LIKE '%fooValue%'
     * </code>
     *
     * @param     string $niveau The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
     */
    public function filterByNiveau($niveau = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($niveau)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $niveau)) {
                $niveau = str_replace('*', '%', $niveau);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RubriqueTableMap::COL_NIVEAU, $niveau, $comparison);
    }

    /**
     * Filter the query by a related \Rubriqueprimaire object
     *
     * @param \Rubriqueprimaire|ObjectCollection $rubriqueprimaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRubriqueQuery The current query, for fluid interface
     */
    public function filterByRubriqueprimaire($rubriqueprimaire, $comparison = null)
    {
        if ($rubriqueprimaire instanceof \Rubriqueprimaire) {
            return $this
                ->addUsingAlias(RubriqueTableMap::COL_RUBRIQUE, $rubriqueprimaire->getRubrique_FK(), $comparison);
        } elseif ($rubriqueprimaire instanceof ObjectCollection) {
            return $this
                ->useRubriqueprimaireQuery()
                ->filterByPrimaryKeys($rubriqueprimaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRubriqueprimaire() only accepts arguments of type \Rubriqueprimaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Rubriqueprimaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
     */
    public function joinRubriqueprimaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Rubriqueprimaire');

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
            $this->addJoinObject($join, 'Rubriqueprimaire');
        }

        return $this;
    }

    /**
     * Use the Rubriqueprimaire relation Rubriqueprimaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RubriqueprimaireQuery A secondary query class using the current class as primary query
     */
    public function useRubriqueprimaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRubriqueprimaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Rubriqueprimaire', '\RubriqueprimaireQuery');
    }

    /**
     * Filter the query by a related \Rubriquesecondaire object
     *
     * @param \Rubriquesecondaire|ObjectCollection $rubriquesecondaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRubriqueQuery The current query, for fluid interface
     */
    public function filterByRubriquesecondaire($rubriquesecondaire, $comparison = null)
    {
        if ($rubriquesecondaire instanceof \Rubriquesecondaire) {
            return $this
                ->addUsingAlias(RubriqueTableMap::COL_RUBRIQUE, $rubriquesecondaire->getRubrique_FK(), $comparison);
        } elseif ($rubriquesecondaire instanceof ObjectCollection) {
            return $this
                ->useRubriquesecondaireQuery()
                ->filterByPrimaryKeys($rubriquesecondaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRubriquesecondaire() only accepts arguments of type \Rubriquesecondaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Rubriquesecondaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
     */
    public function joinRubriquesecondaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Rubriquesecondaire');

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
            $this->addJoinObject($join, 'Rubriquesecondaire');
        }

        return $this;
    }

    /**
     * Use the Rubriquesecondaire relation Rubriquesecondaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RubriquesecondaireQuery A secondary query class using the current class as primary query
     */
    public function useRubriquesecondaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRubriquesecondaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Rubriquesecondaire', '\RubriquesecondaireQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRubrique $rubrique Object to remove from the list of results
     *
     * @return $this|ChildRubriqueQuery The current query, for fluid interface
     */
    public function prune($rubrique = null)
    {
        if ($rubrique) {
            $this->addUsingAlias(RubriqueTableMap::COL_ID, $rubrique->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the rubrique table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RubriqueTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RubriqueTableMap::clearInstancePool();
            RubriqueTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RubriqueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RubriqueTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RubriqueTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RubriqueTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RubriqueQuery
