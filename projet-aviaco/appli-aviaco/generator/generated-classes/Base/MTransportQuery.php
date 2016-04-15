<?php

namespace Base;

use \MTransport as ChildMTransport;
use \MTransportQuery as ChildMTransportQuery;
use \Exception;
use \PDO;
use Map\MTransportTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'transport' table.
 *
 *
 *
 * @method     ChildMTransportQuery orderByMTransport($order = Criteria::ASC) Order by the transport column
 * @method     ChildMTransportQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 *
 * @method     ChildMTransportQuery groupByMTransport() Group by the transport column
 * @method     ChildMTransportQuery groupByCommentaire() Group by the commentaire column
 *
 * @method     ChildMTransportQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMTransportQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMTransportQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMTransportQuery leftJoinFournisseur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fournisseur relation
 * @method     ChildMTransportQuery rightJoinFournisseur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fournisseur relation
 * @method     ChildMTransportQuery innerJoinFournisseur($relationAlias = null) Adds a INNER JOIN clause to the query using the Fournisseur relation
 *
 * @method     ChildMTransportQuery leftJoinCommande($relationAlias = null) Adds a LEFT JOIN clause to the query using the Commande relation
 * @method     ChildMTransportQuery rightJoinCommande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Commande relation
 * @method     ChildMTransportQuery innerJoinCommande($relationAlias = null) Adds a INNER JOIN clause to the query using the Commande relation
 *
 * @method     \FournisseurQuery|\CommandeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMTransport findOne(ConnectionInterface $con = null) Return the first ChildMTransport matching the query
 * @method     ChildMTransport findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMTransport matching the query, or a new ChildMTransport object populated from the query conditions when no match is found
 *
 * @method     ChildMTransport findOneByMTransport(string $transport) Return the first ChildMTransport filtered by the transport column
 * @method     ChildMTransport findOneByCommentaire(string $commentaire) Return the first ChildMTransport filtered by the commentaire column *

 * @method     ChildMTransport requirePk($key, ConnectionInterface $con = null) Return the ChildMTransport by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMTransport requireOne(ConnectionInterface $con = null) Return the first ChildMTransport matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMTransport requireOneByMTransport(string $transport) Return the first ChildMTransport filtered by the transport column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMTransport requireOneByCommentaire(string $commentaire) Return the first ChildMTransport filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMTransport[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMTransport objects based on current ModelCriteria
 * @method     ChildMTransport[]|ObjectCollection findByMTransport(string $transport) Return ChildMTransport objects filtered by the transport column
 * @method     ChildMTransport[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildMTransport objects filtered by the commentaire column
 * @method     ChildMTransport[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MTransportQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MTransportQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\MTransport', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMTransportQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMTransportQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMTransportQuery) {
            return $criteria;
        }
        $query = new ChildMTransportQuery();
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
     * @return ChildMTransport|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MTransportTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MTransportTableMap::DATABASE_NAME);
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
     * @return ChildMTransport A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT transport, commentaire FROM transport WHERE transport = :p0';
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
            /** @var ChildMTransport $obj */
            $obj = new ChildMTransport();
            $obj->hydrate($row);
            MTransportTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMTransport|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMTransportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MTransportTableMap::COL_TRANSPORT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMTransportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MTransportTableMap::COL_TRANSPORT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the transport column
     *
     * Example usage:
     * <code>
     * $query->filterByMTransport('fooValue');   // WHERE transport = 'fooValue'
     * $query->filterByMTransport('%fooValue%'); // WHERE transport LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mTransport The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMTransportQuery The current query, for fluid interface
     */
    public function filterByMTransport($mTransport = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mTransport)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mTransport)) {
                $mTransport = str_replace('*', '%', $mTransport);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MTransportTableMap::COL_TRANSPORT, $mTransport, $comparison);
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
     * @return $this|ChildMTransportQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MTransportTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
    }

    /**
     * Filter the query by a related \Fournisseur object
     *
     * @param \Fournisseur|ObjectCollection $fournisseur the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMTransportQuery The current query, for fluid interface
     */
    public function filterByFournisseur($fournisseur, $comparison = null)
    {
        if ($fournisseur instanceof \Fournisseur) {
            return $this
                ->addUsingAlias(MTransportTableMap::COL_TRANSPORT, $fournisseur->getTMode(), $comparison);
        } elseif ($fournisseur instanceof ObjectCollection) {
            return $this
                ->useFournisseurQuery()
                ->filterByPrimaryKeys($fournisseur->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFournisseur() only accepts arguments of type \Fournisseur or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Fournisseur relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMTransportQuery The current query, for fluid interface
     */
    public function joinFournisseur($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Fournisseur');

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
            $this->addJoinObject($join, 'Fournisseur');
        }

        return $this;
    }

    /**
     * Use the Fournisseur relation Fournisseur object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FournisseurQuery A secondary query class using the current class as primary query
     */
    public function useFournisseurQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFournisseur($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Fournisseur', '\FournisseurQuery');
    }

    /**
     * Filter the query by a related \Commande object
     *
     * @param \Commande|ObjectCollection $commande the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMTransportQuery The current query, for fluid interface
     */
    public function filterByCommande($commande, $comparison = null)
    {
        if ($commande instanceof \Commande) {
            return $this
                ->addUsingAlias(MTransportTableMap::COL_TRANSPORT, $commande->getTMode(), $comparison);
        } elseif ($commande instanceof ObjectCollection) {
            return $this
                ->useCommandeQuery()
                ->filterByPrimaryKeys($commande->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCommande() only accepts arguments of type \Commande or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Commande relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMTransportQuery The current query, for fluid interface
     */
    public function joinCommande($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Commande');

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
            $this->addJoinObject($join, 'Commande');
        }

        return $this;
    }

    /**
     * Use the Commande relation Commande object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CommandeQuery A secondary query class using the current class as primary query
     */
    public function useCommandeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCommande($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Commande', '\CommandeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMTransport $mTransport Object to remove from the list of results
     *
     * @return $this|ChildMTransportQuery The current query, for fluid interface
     */
    public function prune($mTransport = null)
    {
        if ($mTransport) {
            $this->addUsingAlias(MTransportTableMap::COL_TRANSPORT, $mTransport->getMTransport(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the transport table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MTransportTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MTransportTableMap::clearInstancePool();
            MTransportTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MTransportTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MTransportTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MTransportTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MTransportTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MTransportQuery
