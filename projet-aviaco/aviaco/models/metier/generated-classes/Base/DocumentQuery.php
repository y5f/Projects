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
 * @method     ChildDocumentQuery orderByReference_FK($order = Criteria::ASC) Order by the reference_FK column
 * @method     ChildDocumentQuery orderByPart_id_FK($order = Criteria::ASC) Order by the part_id_FK column
 * @method     ChildDocumentQuery orderByDateenreg_FK($order = Criteria::ASC) Order by the date_enreg_FK column
 *
 * @method     ChildDocumentQuery groupByDocnumber() Group by the doc_num column
 * @method     ChildDocumentQuery groupByDoc() Group by the doc_lien column
 * @method     ChildDocumentQuery groupByReference_FK() Group by the reference_FK column
 * @method     ChildDocumentQuery groupByPart_id_FK() Group by the part_id_FK column
 * @method     ChildDocumentQuery groupByDateenreg_FK() Group by the date_enreg_FK column
 *
 * @method     ChildDocumentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDocumentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDocumentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDocumentQuery leftJoinPartenairepiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenairepiece relation
 * @method     ChildDocumentQuery rightJoinPartenairepiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenairepiece relation
 * @method     ChildDocumentQuery innerJoinPartenairepiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenairepiece relation
 *
 * @method     ChildDocumentQuery leftJoinPiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Piece relation
 * @method     ChildDocumentQuery rightJoinPiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Piece relation
 * @method     ChildDocumentQuery innerJoinPiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Piece relation
 *
 * @method     ChildDocumentQuery leftJoinPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Partenaire relation
 * @method     ChildDocumentQuery rightJoinPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Partenaire relation
 * @method     ChildDocumentQuery innerJoinPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Partenaire relation
 *
 * @method     \PartenairepieceQuery|\PieceQuery|\PartenaireQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDocument findOne(ConnectionInterface $con = null) Return the first ChildDocument matching the query
 * @method     ChildDocument findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDocument matching the query, or a new ChildDocument object populated from the query conditions when no match is found
 *
 * @method     ChildDocument findOneByDocnumber(int $doc_num) Return the first ChildDocument filtered by the doc_num column
 * @method     ChildDocument findOneByDoc(string $doc_lien) Return the first ChildDocument filtered by the doc_lien column
 * @method     ChildDocument findOneByReference_FK(string $reference_FK) Return the first ChildDocument filtered by the reference_FK column
 * @method     ChildDocument findOneByPart_id_FK(int $part_id_FK) Return the first ChildDocument filtered by the part_id_FK column
 * @method     ChildDocument findOneByDateenreg_FK(string $date_enreg_FK) Return the first ChildDocument filtered by the date_enreg_FK column *

 * @method     ChildDocument requirePk($key, ConnectionInterface $con = null) Return the ChildDocument by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOne(ConnectionInterface $con = null) Return the first ChildDocument matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDocument requireOneByDocnumber(int $doc_num) Return the first ChildDocument filtered by the doc_num column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOneByDoc(string $doc_lien) Return the first ChildDocument filtered by the doc_lien column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOneByReference_FK(string $reference_FK) Return the first ChildDocument filtered by the reference_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOneByPart_id_FK(int $part_id_FK) Return the first ChildDocument filtered by the part_id_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocument requireOneByDateenreg_FK(string $date_enreg_FK) Return the first ChildDocument filtered by the date_enreg_FK column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDocument[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDocument objects based on current ModelCriteria
 * @method     ChildDocument[]|ObjectCollection findByDocnumber(int $doc_num) Return ChildDocument objects filtered by the doc_num column
 * @method     ChildDocument[]|ObjectCollection findByDoc(string $doc_lien) Return ChildDocument objects filtered by the doc_lien column
 * @method     ChildDocument[]|ObjectCollection findByReference_FK(string $reference_FK) Return ChildDocument objects filtered by the reference_FK column
 * @method     ChildDocument[]|ObjectCollection findByPart_id_FK(int $part_id_FK) Return ChildDocument objects filtered by the part_id_FK column
 * @method     ChildDocument[]|ObjectCollection findByDateenreg_FK(string $date_enreg_FK) Return ChildDocument objects filtered by the date_enreg_FK column
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
    public function __construct($dbName = 'aviaco', $modelName = '\\Document', $modelAlias = null)
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
        $sql = 'SELECT doc_num, doc_lien, reference_FK, part_id_FK, date_enreg_FK FROM document WHERE doc_num = :p0';
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
     * Filter the query on the reference_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByReference_FK('fooValue');   // WHERE reference_FK = 'fooValue'
     * $query->filterByReference_FK('%fooValue%'); // WHERE reference_FK LIKE '%fooValue%'
     * </code>
     *
     * @param     string $reference_FK The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByReference_FK($reference_FK = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($reference_FK)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $reference_FK)) {
                $reference_FK = str_replace('*', '%', $reference_FK);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentTableMap::COL_REFERENCE_FK, $reference_FK, $comparison);
    }

    /**
     * Filter the query on the part_id_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByPart_id_FK(1234); // WHERE part_id_FK = 1234
     * $query->filterByPart_id_FK(array(12, 34)); // WHERE part_id_FK IN (12, 34)
     * $query->filterByPart_id_FK(array('min' => 12)); // WHERE part_id_FK > 12
     * </code>
     *
     * @see       filterByPartenaire()
     *
     * @param     mixed $part_id_FK The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByPart_id_FK($part_id_FK = null, $comparison = null)
    {
        if (is_array($part_id_FK)) {
            $useMinMax = false;
            if (isset($part_id_FK['min'])) {
                $this->addUsingAlias(DocumentTableMap::COL_PART_ID_FK, $part_id_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($part_id_FK['max'])) {
                $this->addUsingAlias(DocumentTableMap::COL_PART_ID_FK, $part_id_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentTableMap::COL_PART_ID_FK, $part_id_FK, $comparison);
    }

    /**
     * Filter the query on the date_enreg_FK column
     *
     * Example usage:
     * <code>
     * $query->filterByDateenreg_FK('2011-03-14'); // WHERE date_enreg_FK = '2011-03-14'
     * $query->filterByDateenreg_FK('now'); // WHERE date_enreg_FK = '2011-03-14'
     * $query->filterByDateenreg_FK(array('max' => 'yesterday')); // WHERE date_enreg_FK > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateenreg_FK The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByDateenreg_FK($dateenreg_FK = null, $comparison = null)
    {
        if (is_array($dateenreg_FK)) {
            $useMinMax = false;
            if (isset($dateenreg_FK['min'])) {
                $this->addUsingAlias(DocumentTableMap::COL_DATE_ENREG_FK, $dateenreg_FK['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateenreg_FK['max'])) {
                $this->addUsingAlias(DocumentTableMap::COL_DATE_ENREG_FK, $dateenreg_FK['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentTableMap::COL_DATE_ENREG_FK, $dateenreg_FK, $comparison);
    }

    /**
     * Filter the query by a related \Partenairepiece object
     *
     * @param \Partenairepiece|ObjectCollection $partenairepiece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByPartenairepiece($partenairepiece, $comparison = null)
    {
        if ($partenairepiece instanceof \Partenairepiece) {
            return $this
                ->addUsingAlias(DocumentTableMap::COL_DATE_ENREG_FK, $partenairepiece->getDateenregistrement(), $comparison);
        } elseif ($partenairepiece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentTableMap::COL_DATE_ENREG_FK, $partenairepiece->toKeyValue('PrimaryKey', 'Dateenregistrement'), $comparison);
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
     * @return $this|ChildDocumentQuery The current query, for fluid interface
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
     * Filter the query by a related \Piece object
     *
     * @param \Piece|ObjectCollection $piece The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByPiece($piece, $comparison = null)
    {
        if ($piece instanceof \Piece) {
            return $this
                ->addUsingAlias(DocumentTableMap::COL_REFERENCE_FK, $piece->getReference(), $comparison);
        } elseif ($piece instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentTableMap::COL_REFERENCE_FK, $piece->toKeyValue('Reference', 'Reference'), $comparison);
        } else {
            throw new PropelException('filterByPiece() only accepts arguments of type \Piece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Piece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function joinPiece($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Piece');

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
            $this->addJoinObject($join, 'Piece');
        }

        return $this;
    }

    /**
     * Use the Piece relation Piece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PieceQuery A secondary query class using the current class as primary query
     */
    public function usePieceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Piece', '\PieceQuery');
    }

    /**
     * Filter the query by a related \Partenaire object
     *
     * @param \Partenaire|ObjectCollection $partenaire The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDocumentQuery The current query, for fluid interface
     */
    public function filterByPartenaire($partenaire, $comparison = null)
    {
        if ($partenaire instanceof \Partenaire) {
            return $this
                ->addUsingAlias(DocumentTableMap::COL_PART_ID_FK, $partenaire->getPartenaire(), $comparison);
        } elseif ($partenaire instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentTableMap::COL_PART_ID_FK, $partenaire->toKeyValue('PrimaryKey', 'Partenaire'), $comparison);
        } else {
            throw new PropelException('filterByPartenaire() only accepts arguments of type \Partenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Partenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDocumentQuery The current query, for fluid interface
     */
    public function joinPartenaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Partenaire');

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
            $this->addJoinObject($join, 'Partenaire');
        }

        return $this;
    }

    /**
     * Use the Partenaire relation Partenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PartenaireQuery A secondary query class using the current class as primary query
     */
    public function usePartenaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Partenaire', '\PartenaireQuery');
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
