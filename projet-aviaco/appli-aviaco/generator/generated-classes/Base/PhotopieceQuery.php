<?php

namespace Base;

use \Photopiece as ChildPhotopiece;
use \PhotopieceQuery as ChildPhotopieceQuery;
use \Exception;
use \PDO;
use Map\PhotopieceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'photo_piece' table.
 *
 *
 *
 * @method     ChildPhotopieceQuery orderByID($order = Criteria::ASC) Order by the id column
 * @method     ChildPhotopieceQuery orderByPiecephoto($order = Criteria::ASC) Order by the url_photo column
 * @method     ChildPhotopieceQuery orderByDatephoto($order = Criteria::ASC) Order by the date_photo column
 * @method     ChildPhotopieceQuery orderByTitre($order = Criteria::ASC) Order by the titre_photo column
 * @method     ChildPhotopieceQuery orderByCommentaire($order = Criteria::ASC) Order by the commentaire column
 * @method     ChildPhotopieceQuery orderByIDFRS_FK($order = Criteria::ASC) Order by the id_fournisseur_FK column
 *
 * @method     ChildPhotopieceQuery groupByID() Group by the id column
 * @method     ChildPhotopieceQuery groupByPiecephoto() Group by the url_photo column
 * @method     ChildPhotopieceQuery groupByDatephoto() Group by the date_photo column
 * @method     ChildPhotopieceQuery groupByTitre() Group by the titre_photo column
 * @method     ChildPhotopieceQuery groupByCommentaire() Group by the commentaire column
 * @method     ChildPhotopieceQuery groupByIDFRS_FK() Group by the id_fournisseur_FK column
 *
 * @method     ChildPhotopieceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPhotopieceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPhotopieceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPhotopieceQuery leftJoinFournisseur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fournisseur relation
 * @method     ChildPhotopieceQuery rightJoinFournisseur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fournisseur relation
 * @method     ChildPhotopieceQuery innerJoinFournisseur($relationAlias = null) Adds a INNER JOIN clause to the query using the Fournisseur relation
 *
 * @method     \FournisseurQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPhotopiece findOne(ConnectionInterface $con = null) Return the first ChildPhotopiece matching the query
 * @method     ChildPhotopiece findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPhotopiece matching the query, or a new ChildPhotopiece object populated from the query conditions when no match is found
 *
 * @method     ChildPhotopiece findOneByID(int $id) Return the first ChildPhotopiece filtered by the id column
 * @method     ChildPhotopiece findOneByPiecephoto(string $url_photo) Return the first ChildPhotopiece filtered by the url_photo column
 * @method     ChildPhotopiece findOneByDatephoto(string $date_photo) Return the first ChildPhotopiece filtered by the date_photo column
 * @method     ChildPhotopiece findOneByTitre(string $titre_photo) Return the first ChildPhotopiece filtered by the titre_photo column
 * @method     ChildPhotopiece findOneByCommentaire(string $commentaire) Return the first ChildPhotopiece filtered by the commentaire column
 * @method     ChildPhotopiece findOneByIDFRS_FK(int $id_fournisseur_FK) Return the first ChildPhotopiece filtered by the id_fournisseur_FK column *

 * @method     ChildPhotopiece requirePk($key, ConnectionInterface $con = null) Return the ChildPhotopiece by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotopiece requireOne(ConnectionInterface $con = null) Return the first ChildPhotopiece matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPhotopiece requireOneByID(int $id) Return the first ChildPhotopiece filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotopiece requireOneByPiecephoto(string $url_photo) Return the first ChildPhotopiece filtered by the url_photo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotopiece requireOneByDatephoto(string $date_photo) Return the first ChildPhotopiece filtered by the date_photo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotopiece requireOneByTitre(string $titre_photo) Return the first ChildPhotopiece filtered by the titre_photo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotopiece requireOneByCommentaire(string $commentaire) Return the first ChildPhotopiece filtered by the commentaire column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPhotopiece requireOneByIDFRS_FK(int $id_fournisseur_FK) Return the first ChildPhotopiece filtered by the id_fournisseur_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPhotopiece[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPhotopiece objects based on current ModelCriteria
 * @method     ChildPhotopiece[]|ObjectCollection findByID(int $id) Return ChildPhotopiece objects filtered by the id column
 * @method     ChildPhotopiece[]|ObjectCollection findByPiecephoto(string $url_photo) Return ChildPhotopiece objects filtered by the url_photo column
 * @method     ChildPhotopiece[]|ObjectCollection findByDatephoto(string $date_photo) Return ChildPhotopiece objects filtered by the date_photo column
 * @method     ChildPhotopiece[]|ObjectCollection findByTitre(string $titre_photo) Return ChildPhotopiece objects filtered by the titre_photo column
 * @method     ChildPhotopiece[]|ObjectCollection findByCommentaire(string $commentaire) Return ChildPhotopiece objects filtered by the commentaire column
 * @method     ChildPhotopiece[]|ObjectCollection findByIDFRS_FK(int $id_fournisseur_FK) Return ChildPhotopiece objects filtered by the id_fournisseur_FK column
 * @method     ChildPhotopiece[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PhotopieceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PhotopieceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Photopiece', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPhotopieceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPhotopieceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPhotopieceQuery) {
            return $criteria;
        }
        $query = new ChildPhotopieceQuery();
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
     * @return ChildPhotopiece|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PhotopieceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PhotopieceTableMap::DATABASE_NAME);
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
     * @return ChildPhotopiece A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, url_photo, date_photo, titre_photo, commentaire, id_fournisseur_FK FROM photo_piece WHERE id = :p0';
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
            /** @var ChildPhotopiece $obj */
            $obj = new ChildPhotopiece();
            $obj->hydrate($row);
            PhotopieceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPhotopiece|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PhotopieceTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PhotopieceTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(PhotopieceTableMap::COL_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(PhotopieceTableMap::COL_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PhotopieceTableMap::COL_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the url_photo column
     *
     * Example usage:
     * <code>
     * $query->filterByPiecephoto('fooValue');   // WHERE url_photo = 'fooValue'
     * $query->filterByPiecephoto('%fooValue%'); // WHERE url_photo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $piecephoto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
     */
    public function filterByPiecephoto($piecephoto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($piecephoto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $piecephoto)) {
                $piecephoto = str_replace('*', '%', $piecephoto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PhotopieceTableMap::COL_URL_PHOTO, $piecephoto, $comparison);
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
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
     */
    public function filterByDatephoto($datephoto = null, $comparison = null)
    {
        if (is_array($datephoto)) {
            $useMinMax = false;
            if (isset($datephoto['min'])) {
                $this->addUsingAlias(PhotopieceTableMap::COL_DATE_PHOTO, $datephoto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datephoto['max'])) {
                $this->addUsingAlias(PhotopieceTableMap::COL_DATE_PHOTO, $datephoto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PhotopieceTableMap::COL_DATE_PHOTO, $datephoto, $comparison);
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
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PhotopieceTableMap::COL_TITRE_PHOTO, $titre, $comparison);
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
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PhotopieceTableMap::COL_COMMENTAIRE, $commentaire, $comparison);
    }

    /**
     * Filter the query on the id_fournisseur_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByIDFRS_FK(1234); // WHERE id_fournisseur_FK = 1234
     * $query->filterByIDFRS_FK(array(12, 34)); // WHERE id_fournisseur_FK IN (12, 34)
     * $query->filterByIDFRS_FK(array('min' => 12)); // WHERE id_fournisseur_FK > 12
     * </code>
     *
     * @see       filterByFournisseur()
     *
     * @param     mixed $iDFRS_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
     */
    public function filterByIDFRS_FK($iDFRS_FK = null, $comparison = null)
    {
        if (is_array($iDFRS_FK)) {
            $useMinMax = false;
            if (isset($iDFRS_FK['min'])) {
                $this->addUsingAlias(PhotopieceTableMap::COL_ID_FOURNISSEUR_FK, $iDFRS_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDFRS_FK['max'])) {
                $this->addUsingAlias(PhotopieceTableMap::COL_ID_FOURNISSEUR_FK, $iDFRS_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PhotopieceTableMap::COL_ID_FOURNISSEUR_FK, $iDFRS_FK, $comparison);
    }

    /**
     * Filter the query by a related \Fournisseur object
     *
     * @param \Fournisseur|ObjectCollection $fournisseur The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPhotopieceQuery The current query, for fluid interface
     */
    public function filterByFournisseur($fournisseur, $comparison = null)
    {
        if ($fournisseur instanceof \Fournisseur) {
            return $this
                ->addUsingAlias(PhotopieceTableMap::COL_ID_FOURNISSEUR_FK, $fournisseur->getID(), $comparison);
        } elseif ($fournisseur instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PhotopieceTableMap::COL_ID_FOURNISSEUR_FK, $fournisseur->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildPhotopiece $photopiece Object to remove from the list of results
     *
     * @return $this|ChildPhotopieceQuery The current query, for fluid interface
     */
    public function prune($photopiece = null)
    {
        if ($photopiece) {
            $this->addUsingAlias(PhotopieceTableMap::COL_ID, $photopiece->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the photo_piece table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PhotopieceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PhotopieceTableMap::clearInstancePool();
            PhotopieceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PhotopieceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PhotopieceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PhotopieceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PhotopieceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PhotopieceQuery
