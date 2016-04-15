<?php

namespace Base;

use \Model as ChildModel;
use \ModelQuery as ChildModelQuery;
use \Exception;
use \PDO;
use Map\ModelTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'modele' table.
 *
 *
 *
 * @method     ChildModelQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildModelQuery orderByModele($order = Criteria::ASC) Order by the modele column
 * @method     ChildModelQuery orderByMarque_FK($order = Criteria::ASC) Order by the marque_FK column
 *
 * @method     ChildModelQuery groupByID() Group by the id column
 * @method     ChildModelQuery groupByModele() Group by the modele column
 * @method     ChildModelQuery groupByMarque_FK() Group by the marque_FK column
 *
 * @method     ChildModelQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildModelQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildModelQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildModelQuery leftJoinMarque($relationAlias = null) Adds a LEFT JOIN clause to the query using the Marque relation
 * @method     ChildModelQuery rightJoinMarque($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Marque relation
 * @method     ChildModelQuery innerJoinMarque($relationAlias = null) Adds a INNER JOIN clause to the query using the Marque relation
 *
 * @method     ChildModelQuery leftJoinAppareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Appareil relation
 * @method     ChildModelQuery rightJoinAppareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Appareil relation
 * @method     ChildModelQuery innerJoinAppareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Appareil relation
 *
 * @method     ChildModelQuery leftJoinPieceApp($relationAlias = null) Adds a LEFT JOIN clause to the query using the PieceApp relation
 * @method     ChildModelQuery rightJoinPieceApp($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PieceApp relation
 * @method     ChildModelQuery innerJoinPieceApp($relationAlias = null) Adds a INNER JOIN clause to the query using the PieceApp relation
 *
 * @method     ChildModelQuery leftJoinPhotoappareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Photoappareil relation
 * @method     ChildModelQuery rightJoinPhotoappareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Photoappareil relation
 * @method     ChildModelQuery innerJoinPhotoappareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Photoappareil relation
 *
 * @method     \MarqueQuery|\AppareilQuery|\PieceAppQuery|\PhotoappareilQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildModel findOne(ConnectionInterface $con = null) Return the first ChildModel matching the query
 * @method     ChildModel findOneOrCreate(ConnectionInterface $con = null) Return the first ChildModel matching the query, or a new ChildModel object populated from the query conditions when no match is found
 *
 * @method     ChildModel findOneByID(int $id) Return the first ChildModel filtered by the id column
 * @method     ChildModel findOneByModele(string $modele) Return the first ChildModel filtered by the modele column
 * @method     ChildModel findOneByMarque_FK(string $marque_FK) Return the first ChildModel filtered by the marque_FK column *

 * @method     ChildModel requirePk($key, ConnectionInterface $con = null) Return the ChildModel by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildModel requireOne(ConnectionInterface $con = null) Return the first ChildModel matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildModel requireOneByID(int $id) Return the first ChildModel filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildModel requireOneByModele(string $modele) Return the first ChildModel filtered by the modele column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildModel requireOneByMarque_FK(string $marque_FK) Return the first ChildModel filtered by the marque_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildModel[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildModel objects based on current ModelCriteria
 * @method     ChildModel[]|ObjectCollection findByID(int $id) Return ChildModel objects filtered by the id column
 * @method     ChildModel[]|ObjectCollection findByModele(string $modele) Return ChildModel objects filtered by the modele column
 * @method     ChildModel[]|ObjectCollection findByMarque_FK(string $marque_FK) Return ChildModel objects filtered by the marque_FK column
 * @method     ChildModel[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ModelQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ModelQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Model', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildModelQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildModelQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildModelQuery) {
            return $criteria;
        }
        $query = new ChildModelQuery();
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
     * @return ChildModel|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ModelTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ModelTableMap::DATABASE_NAME);
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
     * @return ChildModel A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, modele, marque_FK FROM modele WHERE id = :p0';
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
            /** @var ChildModel $obj */
            $obj = new ChildModel();
            $obj->hydrate($row);
            ModelTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildModel|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ModelTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ModelTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(ModelTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(ModelTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ModelTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the modele column
     *
     * Example usage:
     * <code>
     * $query->filterByModele('fooValue');   // WHERE modele = 'fooValue'
     * $query->filterByModele('%fooValue%'); // WHERE modele LIKE '%fooValue%'
     * </code>
     *
     * @param     string $modele The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function filterByModele($modele = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($modele)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $modele)) {
                $modele = str_replace('*', '%', $modele);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ModelTableMap::COL_MODELE, $modele, $comparison);
    }

    /**
     * Filter the query on the marque_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByMarque_FK('fooValue');   // WHERE marque_FK = 'fooValue'
     * $query->filterByMarque_FK('%fooValue%'); // WHERE marque_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $marque_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function filterByMarque_FK($marque_FK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($marque_FK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $marque_FK)) {
                $marque_FK = str_replace('*', '%', $marque_FK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ModelTableMap::COL_MARQUE_FK, $marque_FK, $comparison);
    }

    /**
     * Filter the query by a related \Marque object
     *
     * @param \Marque|ObjectCollection $marque The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildModelQuery The current query, for fluid interface
     */
    public function filterByMarque($marque, $comparison = null)
    {
        if ($marque instanceof \Marque) {
            return $this
                ->addUsingAlias(ModelTableMap::COL_MARQUE_FK, $marque->getMarque(), $comparison);
        } elseif ($marque instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ModelTableMap::COL_MARQUE_FK, $marque->toKeyValue('PrimaryKey', 'Marque'), $comparison);
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
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function joinMarque($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useMarqueQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMarque($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Marque', '\MarqueQuery');
    }

    /**
     * Filter the query by a related \Appareil object
     *
     * @param \Appareil|ObjectCollection $appareil the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildModelQuery The current query, for fluid interface
     */
    public function filterByAppareil($appareil, $comparison = null)
    {
        if ($appareil instanceof \Appareil) {
            return $this
                ->addUsingAlias(ModelTableMap::COL_MODELE, $appareil->getModele_PK(), $comparison);
        } elseif ($appareil instanceof ObjectCollection) {
            return $this
                ->useAppareilQuery()
                ->filterByPrimaryKeys($appareil->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildModelQuery The current query, for fluid interface
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
     * Filter the query by a related \PieceApp object
     *
     * @param \PieceApp|ObjectCollection $pieceApp the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildModelQuery The current query, for fluid interface
     */
    public function filterByPieceApp($pieceApp, $comparison = null)
    {
        if ($pieceApp instanceof \PieceApp) {
            return $this
                ->addUsingAlias(ModelTableMap::COL_MODELE, $pieceApp->getModele_PK(), $comparison);
        } elseif ($pieceApp instanceof ObjectCollection) {
            return $this
                ->usePieceAppQuery()
                ->filterByPrimaryKeys($pieceApp->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPieceApp() only accepts arguments of type \PieceApp or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PieceApp relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function joinPieceApp($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PieceApp');

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
            $this->addJoinObject($join, 'PieceApp');
        }

        return $this;
    }

    /**
     * Use the PieceApp relation PieceApp object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PieceAppQuery A secondary query class using the current class as primary query
     */
    public function usePieceAppQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPieceApp($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PieceApp', '\PieceAppQuery');
    }

    /**
     * Filter the query by a related \Photoappareil object
     *
     * @param \Photoappareil|ObjectCollection $photoappareil the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildModelQuery The current query, for fluid interface
     */
    public function filterByPhotoappareil($photoappareil, $comparison = null)
    {
        if ($photoappareil instanceof \Photoappareil) {
            return $this
                ->addUsingAlias(ModelTableMap::COL_MODELE, $photoappareil->getmodele_PK(), $comparison);
        } elseif ($photoappareil instanceof ObjectCollection) {
            return $this
                ->usePhotoappareilQuery()
                ->filterByPrimaryKeys($photoappareil->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPhotoappareil() only accepts arguments of type \Photoappareil or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Photoappareil relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function joinPhotoappareil($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Photoappareil');

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
            $this->addJoinObject($join, 'Photoappareil');
        }

        return $this;
    }

    /**
     * Use the Photoappareil relation Photoappareil object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PhotoappareilQuery A secondary query class using the current class as primary query
     */
    public function usePhotoappareilQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPhotoappareil($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Photoappareil', '\PhotoappareilQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildModel $model Object to remove from the list of results
     *
     * @return $this|ChildModelQuery The current query, for fluid interface
     */
    public function prune($model = null)
    {
        if ($model) {
            $this->addUsingAlias(ModelTableMap::COL_ID, $model->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the modele table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ModelTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ModelTableMap::clearInstancePool();
            ModelTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ModelTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ModelTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ModelTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ModelTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ModelQuery
