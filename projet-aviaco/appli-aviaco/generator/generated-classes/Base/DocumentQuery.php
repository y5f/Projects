<?php

namespace Base;

use \Document as ChildDocument;
use \DocumentQuery as ChildDocumentQuery;
use \Exception;
use \PDO;
use Map\DocumentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'document' table.
 *
 *
 *
 * @method     ChildDocumentQuery orderByDocnumber($order = Criteria::ASC) Order by the doc_num column
 * @method     ChildDocumentQuery orderByDoc($order = Criteria::ASC) Order by the doc_lien column
 * @method     ChildDocumentQuery orderByNDoc($order = Criteria::ASC) Order by the doc_name column
 * @method     ChildDocumentQuery orderByIDFRS_FK($order = Criteria::ASC) Order by the id_fournisseur_FK column
 * @method     ChildDocumentQuery orderByDTESave_FK($order = Criteria::ASC) Order by the date_enreg_FK column
 *
 * @method     ChildDocumentQuery groupByDocnumber() Group by the doc_num column
 * @method     ChildDocumentQuery groupByDoc() Group by the doc_lien column
 * @method     ChildDocumentQuery groupByNDoc() Group by the doc_name column
 * @method     ChildDocumentQuery groupByIDFRS_FK() Group by the id_fournisseur_FK column
 * @method     ChildDocumentQuery groupByDTESave_FK() Group by the date_enreg_FK column
 *
 * @method     ChildDocumentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDocumentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDocumentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDocumentQuery leftJoinFournisseur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fournisseur relation
 * @method     ChildDocumentQuery rightJoinFournisseur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fournisseur relation
 * @method     ChildDocumentQuery innerJoinFournisseur($relationAlias = null) Adds a INNER JOIN clause to the query using the Fournisseur relation
 *
 * @method     \FournisseurQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDocument findOne(ConnectionInterface $con = null) Return the first ChildDocument matching the query
 * @method     ChildDocument findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDocument matching the query, or a new ChildDocument object populated from the query conditions when no match is found
 *
 * @method     ChildDocument findOneByDocnumber(int $doc_num) Return the first ChildDocument filtered by the doc_num column
 * @method     ChildDocument findOneByDoc(string $doc_lien) Return the first ChildDocument filtered by the doc_lien column
 * @method     ChildDocument findOneByNDoc(string $doc_name) Return the first ChildDocument filtered by the doc_name column
 * @method     ChildDocument findOneByIDFRS_FK(int $id_fournisseur_FK) Return the first ChildDocument filtered by the id_fournisseur_FK column
 * @method     ChildDocument findOneByDTESave_FK(string $date_enreg_FK) Return the first ChildDocument filtered by the date_enreg_FK column *

 * @method     ChildDocument requirePk($key, ConnectionInterface $con = null) Return the ChildDocument by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOne(ConnectionInterface $con = null) Return the first ChildDocument matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDocument requireOneByDocnumber(int $doc_num) Return the first ChildDocument filtered by the doc_num column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOneByDoc(string $doc_lien) Return the first ChildDocument filtered by the doc_lien column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOneByNDoc(string $doc_name) Return the first ChildDocument filtered by the doc_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOneByIDFRS_FK(int $id_fournisseur_FK) Return the first ChildDocument filtered by the id_fournisseur_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOneByDTESave_FK(string $date_enreg_FK) Return the first ChildDocument filtered by the date_enreg_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDocument[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDocument objects based on current ModelCriteria
 * @method     ChildDocument[]|ObjectCollection findByDocnumber(int $doc_num) Return ChildDocument objects filtered by the doc_num column
 * @method     ChildDocument[]|ObjectCollection findByDoc(string $doc_lien) Return ChildDocument objects filtered by the doc_lien column
 * @method     ChildDocument[]|ObjectCollection findByNDoc(string $doc_name) Return ChildDocument objects filtered by the doc_name column
 * @method     ChildDocument[]|ObjectCollection findByIDFRS_FK(int $id_fournisseur_FK) Return ChildDocument objects filtered by the id_fournisseur_FK column
 * @method     ChildDocument[]|ObjectCollection findByDTESave_FK(string $date_enreg_FK) Return ChildDocument objects filtered by the date_enreg_FK column
 * @method     ChildDocument[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DocumentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DocumentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Document', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDocumentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDocumentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDocumentQuery) {
            return $criteria;
        }
        $query = new ChildDocumentQuery();
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
     * @return ChildDocument|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DocumentTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DocumentTableMap::DATABASE_NAME);
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
     * @return ChildDocument A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT doc_num, doc_lien, doc_name, id_fournisseur_FK, date_enreg_FK FROM document WHERE doc_num = :p0';
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
            /** @var ChildDocument $obj */
            $obj = new ChildDocument();
            $obj->hydrate($row);
            DocumentTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildDocument|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DocumentTableMap::COL_DOC_NUM, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DocumentTableMap::COL_DOC_NUM, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the doc_num column
     *
     * Example usage:
     * <code>
     * $query->filterByDocnumber(1234); // WHERE doc_num = 1234
     * $query->filterByDocnumber(array(12, 34)); // WHERE doc_num IN (12, 34)
     * $query->filterByDocnumber(array('min' => 12)); // WHERE doc_num > 12
     * </code>
     *
     * @param     mixed $docnumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByDocnumber($docnumber = null, $comparison = null)
    {
        if (is_array($docnumber)) {
            $useMinMax = false;
            if (isset($docnumber['min'])) {
                $this->addUsingAlias(DocumentTableMap::COL_DOC_NUM, $docnumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($docnumber['max'])) {
                $this->addUsingAlias(DocumentTableMap::COL_DOC_NUM, $docnumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentTableMap::COL_DOC_NUM, $docnumber, $comparison);
    }

    /**
     * Filter the query on the doc_lien column
     *
     * Example usage:
     * <code>
     * $query->filterByDoc('fooValue');   // WHERE doc_lien = 'fooValue'
     * $query->filterByDoc('%fooValue%'); // WHERE doc_lien LIKE '%fooValue%'
     * </code>
     *
     * @param     string $doc The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByDoc($doc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($doc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $doc)) {
                $doc = str_replace('*', '%', $doc);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentTableMap::COL_DOC_LIEN, $doc, $comparison);
    }

    /**
     * Filter the query on the doc_name column
     *
     * Example usage:
     * <code>
     * $query->filterByNDoc('fooValue');   // WHERE doc_name = 'fooValue'
     * $query->filterByNDoc('%fooValue%'); // WHERE doc_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nDoc The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByNDoc($nDoc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nDoc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nDoc)) {
                $nDoc = str_replace('*', '%', $nDoc);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentTableMap::COL_DOC_NAME, $nDoc, $comparison);
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
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByIDFRS_FK($iDFRS_FK = null, $comparison = null)
    {
        if (is_array($iDFRS_FK)) {
            $useMinMax = false;
            if (isset($iDFRS_FK['min'])) {
                $this->addUsingAlias(DocumentTableMap::COL_ID_FOURNISSEUR_FK, $iDFRS_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iDFRS_FK['max'])) {
                $this->addUsingAlias(DocumentTableMap::COL_ID_FOURNISSEUR_FK, $iDFRS_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentTableMap::COL_ID_FOURNISSEUR_FK, $iDFRS_FK, $comparison);
    }

    /**
     * Filter the query on the date_enreg_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByDTESave_FK('2011-03-14'); // WHERE date_enreg_FK = '2011-03-14'
     * $query->filterByDTESave_FK('now'); // WHERE date_enreg_FK = '2011-03-14'
     * $query->filterByDTESave_FK(array('max' => 'yesterday')); // WHERE date_enreg_FK > '2011-03-13'
     * </code>
     *
     * @param     mixed $dTESave_FK The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByDTESave_FK($dTESave_FK = null, $comparison = null)
    {
        if (is_array($dTESave_FK)) {
            $useMinMax = false;
            if (isset($dTESave_FK['min'])) {
                $this->addUsingAlias(DocumentTableMap::COL_DATE_ENREG_FK, $dTESave_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dTESave_FK['max'])) {
                $this->addUsingAlias(DocumentTableMap::COL_DATE_ENREG_FK, $dTESave_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentTableMap::COL_DATE_ENREG_FK, $dTESave_FK, $comparison);
    }

    /**
     * Filter the query by a related \Fournisseur object
     *
     * @param \Fournisseur|ObjectCollection $fournisseur The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByFournisseur($fournisseur, $comparison = null)
    {
        if ($fournisseur instanceof \Fournisseur) {
            return $this
                ->addUsingAlias(DocumentTableMap::COL_ID_FOURNISSEUR_FK, $fournisseur->getID(), $comparison);
        } elseif ($fournisseur instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentTableMap::COL_ID_FOURNISSEUR_FK, $fournisseur->toKeyValue('PrimaryKey', 'ID'), $comparison);
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
     * @return $this|ChildDocumentQuery The current query, for fluid interface
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
     * @param   ChildDocument $document Object to remove from the list of results
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function prune($document = null)
    {
        if ($document) {
            $this->addUsingAlias(DocumentTableMap::COL_DOC_NUM, $document->getDocnumber(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the document table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DocumentTableMap::clearInstancePool();
            DocumentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DocumentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DocumentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DocumentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DocumentQuery
