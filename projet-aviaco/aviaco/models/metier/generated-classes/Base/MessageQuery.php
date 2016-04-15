<?php

namespace Base;

use \Message as ChildMessage;
use \MessageQuery as ChildMessageQuery;
use \Exception;
use \PDO;
use Map\MessageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'message' table.
 *
 *
 *
 * @method     ChildMessageQuery orderByIdmsg($order = Criteria::ASC) Order by the id_msg column
 * @method     ChildMessageQuery orderByObjet($order = Criteria::ASC) Order by the objet column
 * @method     ChildMessageQuery orderByVisiteur($order = Criteria::ASC) Order by the nom_visiteur column
 * @method     ChildMessageQuery orderByEmail($order = Criteria::ASC) Order by the mail_visiteur column
 * @method     ChildMessageQuery orderByTelephone($order = Criteria::ASC) Order by the telephone column
 * @method     ChildMessageQuery orderByMsg($order = Criteria::ASC) Order by the msg column
 * @method     ChildMessageQuery orderByEtat($order = Criteria::ASC) Order by the etat column
 *
 * @method     ChildMessageQuery groupByIdmsg() Group by the id_msg column
 * @method     ChildMessageQuery groupByObjet() Group by the objet column
 * @method     ChildMessageQuery groupByVisiteur() Group by the nom_visiteur column
 * @method     ChildMessageQuery groupByEmail() Group by the mail_visiteur column
 * @method     ChildMessageQuery groupByTelephone() Group by the telephone column
 * @method     ChildMessageQuery groupByMsg() Group by the msg column
 * @method     ChildMessageQuery groupByEtat() Group by the etat column
 *
 * @method     ChildMessageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMessageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMessageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMessage findOne(ConnectionInterface $con = null) Return the first ChildMessage matching the query
 * @method     ChildMessage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMessage matching the query, or a new ChildMessage object populated from the query conditions when no match is found
 *
 * @method     ChildMessage findOneByIdmsg(int $id_msg) Return the first ChildMessage filtered by the id_msg column
 * @method     ChildMessage findOneByObjet(string $objet) Return the first ChildMessage filtered by the objet column
 * @method     ChildMessage findOneByVisiteur(string $nom_visiteur) Return the first ChildMessage filtered by the nom_visiteur column
 * @method     ChildMessage findOneByEmail(string $mail_visiteur) Return the first ChildMessage filtered by the mail_visiteur column
 * @method     ChildMessage findOneByTelephone(string $telephone) Return the first ChildMessage filtered by the telephone column
 * @method     ChildMessage findOneByMsg(string $msg) Return the first ChildMessage filtered by the msg column
 * @method     ChildMessage findOneByEtat(boolean $etat) Return the first ChildMessage filtered by the etat column *

 * @method     ChildMessage requirePk($key, ConnectionInterface $con = null) Return the ChildMessage by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOne(ConnectionInterface $con = null) Return the first ChildMessage matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMessage requireOneByIdmsg(int $id_msg) Return the first ChildMessage filtered by the id_msg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOneByObjet(string $objet) Return the first ChildMessage filtered by the objet column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOneByVisiteur(string $nom_visiteur) Return the first ChildMessage filtered by the nom_visiteur column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOneByEmail(string $mail_visiteur) Return the first ChildMessage filtered by the mail_visiteur column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOneByTelephone(string $telephone) Return the first ChildMessage filtered by the telephone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOneByMsg(string $msg) Return the first ChildMessage filtered by the msg column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessage requireOneByEtat(boolean $etat) Return the first ChildMessage filtered by the etat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMessage[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMessage objects based on current ModelCriteria
 * @method     ChildMessage[]|ObjectCollection findByIdmsg(int $id_msg) Return ChildMessage objects filtered by the id_msg column
 * @method     ChildMessage[]|ObjectCollection findByObjet(string $objet) Return ChildMessage objects filtered by the objet column
 * @method     ChildMessage[]|ObjectCollection findByVisiteur(string $nom_visiteur) Return ChildMessage objects filtered by the nom_visiteur column
 * @method     ChildMessage[]|ObjectCollection findByEmail(string $mail_visiteur) Return ChildMessage objects filtered by the mail_visiteur column
 * @method     ChildMessage[]|ObjectCollection findByTelephone(string $telephone) Return ChildMessage objects filtered by the telephone column
 * @method     ChildMessage[]|ObjectCollection findByMsg(string $msg) Return ChildMessage objects filtered by the msg column
 * @method     ChildMessage[]|ObjectCollection findByEtat(boolean $etat) Return ChildMessage objects filtered by the etat column
 * @method     ChildMessage[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MessageQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MessageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'aviaco', $modelName = '\\Message', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMessageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMessageQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMessageQuery) {
            return $criteria;
        }
        $query = new ChildMessageQuery();
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
     * @return ChildMessage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MessageTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MessageTableMap::DATABASE_NAME);
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
     * @return ChildMessage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_msg, objet, nom_visiteur, mail_visiteur, telephone, msg, etat FROM message WHERE id_msg = :p0';
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
            /** @var ChildMessage $obj */
            $obj = new ChildMessage();
            $obj->hydrate($row);
            MessageTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMessage|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMessageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MessageTableMap::COL_ID_MSG, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMessageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MessageTableMap::COL_ID_MSG, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_msg column
     *
     * Example usage:
     * <code>
     * $query->filterByIdmsg(1234); // WHERE id_msg = 1234
     * $query->filterByIdmsg(array(12, 34)); // WHERE id_msg IN (12, 34)
     * $query->filterByIdmsg(array('min' => 12)); // WHERE id_msg > 12
     * </code>
     *
     * @param     mixed $idmsg The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessageQuery The current query, for fluid interface
     */
    public function filterByIdmsg($idmsg = null, $comparison = null)
    {
        if (is_array($idmsg)) {
            $useMinMax = false;
            if (isset($idmsg['min'])) {
                $this->addUsingAlias(MessageTableMap::COL_ID_MSG, $idmsg['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idmsg['max'])) {
                $this->addUsingAlias(MessageTableMap::COL_ID_MSG, $idmsg['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessageTableMap::COL_ID_MSG, $idmsg, $comparison);
    }

    /**
     * Filter the query on the objet column
     *
     * Example usage:
     * <code>
     * $query->filterByObjet('fooValue');   // WHERE objet = 'fooValue'
     * $query->filterByObjet('%fooValue%'); // WHERE objet LIKE '%fooValue%'
     * </code>
     *
     * @param     string $objet The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessageQuery The current query, for fluid interface
     */
    public function filterByObjet($objet = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($objet)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $objet)) {
                $objet = str_replace('*', '%', $objet);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MessageTableMap::COL_OBJET, $objet, $comparison);
    }

    /**
     * Filter the query on the nom_visiteur column
     *
     * Example usage:
     * <code>
     * $query->filterByVisiteur('fooValue');   // WHERE nom_visiteur = 'fooValue'
     * $query->filterByVisiteur('%fooValue%'); // WHERE nom_visiteur LIKE '%fooValue%'
     * </code>
     *
     * @param     string $visiteur The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessageQuery The current query, for fluid interface
     */
    public function filterByVisiteur($visiteur = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($visiteur)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $visiteur)) {
                $visiteur = str_replace('*', '%', $visiteur);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MessageTableMap::COL_NOM_VISITEUR, $visiteur, $comparison);
    }

    /**
     * Filter the query on the mail_visiteur column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE mail_visiteur = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE mail_visiteur LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessageQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MessageTableMap::COL_MAIL_VISITEUR, $email, $comparison);
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
     * @return $this|ChildMessageQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MessageTableMap::COL_TELEPHONE, $telephone, $comparison);
    }

    /**
     * Filter the query on the msg column
     *
     * Example usage:
     * <code>
     * $query->filterByMsg('fooValue');   // WHERE msg = 'fooValue'
     * $query->filterByMsg('%fooValue%'); // WHERE msg LIKE '%fooValue%'
     * </code>
     *
     * @param     string $msg The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessageQuery The current query, for fluid interface
     */
    public function filterByMsg($msg = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($msg)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $msg)) {
                $msg = str_replace('*', '%', $msg);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MessageTableMap::COL_MSG, $msg, $comparison);
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
     * @return $this|ChildMessageQuery The current query, for fluid interface
     */
    public function filterByEtat($etat = null, $comparison = null)
    {
        if (is_string($etat)) {
            $etat = in_array(strtolower($etat), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MessageTableMap::COL_ETAT, $etat, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMessage $message Object to remove from the list of results
     *
     * @return $this|ChildMessageQuery The current query, for fluid interface
     */
    public function prune($message = null)
    {
        if ($message) {
            $this->addUsingAlias(MessageTableMap::COL_ID_MSG, $message->getIdmsg(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the message table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessageTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MessageTableMap::clearInstancePool();
            MessageTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MessageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MessageTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MessageTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MessageTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MessageQuery
