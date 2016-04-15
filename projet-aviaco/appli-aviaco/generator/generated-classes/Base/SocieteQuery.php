<?php

namespace Base;

use \Societe as ChildSociete;
use \SocieteQuery as ChildSocieteQuery;
use \Exception;
use \PDO;
use Map\SocieteTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'societe' table.
 *
 *
 *
 * @method     ChildSocieteQuery orderByID($order = Criteria::ASC) Order by the soc_id column
 * @method     ChildSocieteQuery orderBySociete($order = Criteria::ASC) Order by the societe column
 * @method     ChildSocieteQuery orderByDirigeant($order = Criteria::ASC) Order by the dirigeant column
 * @method     ChildSocieteQuery orderByEmail($order = Criteria::ASC) Order by the mail column
 * @method     ChildSocieteQuery orderByWebsite($order = Criteria::ASC) Order by the website column
 * @method     ChildSocieteQuery orderByTelephone($order = Criteria::ASC) Order by the tel column
 * @method     ChildSocieteQuery orderByFax($order = Criteria::ASC) Order by the fax column
 * @method     ChildSocieteQuery orderByAdresses($order = Criteria::ASC) Order by the adresse column
 * @method     ChildSocieteQuery orderByCP($order = Criteria::ASC) Order by the cp column
 * @method     ChildSocieteQuery orderByVille($order = Criteria::ASC) Order by the ville column
 * @method     ChildSocieteQuery orderByPays($order = Criteria::ASC) Order by the pays column
 * @method     ChildSocieteQuery orderByNotes($order = Criteria::ASC) Order by the notes column
 * @method     ChildSocieteQuery orderByNotesactivite($order = Criteria::ASC) Order by the notes_activite column
 * @method     ChildSocieteQuery orderBySourceRIB($order = Criteria::ASC) Order by the scrRIB column
 * @method     ChildSocieteQuery orderByFabricant($order = Criteria::ASC) Order by the fabricant column
 * @method     ChildSocieteQuery orderByLogo($order = Criteria::ASC) Order by the logo column
 * @method     ChildSocieteQuery orderByisFraude($order = Criteria::ASC) Order by the fraude column
 * @method     ChildSocieteQuery orderByDateMAJSOC($order = Criteria::ASC) Order by the dte_maj_soc column
 * @method     ChildSocieteQuery orderByDte_MAJACT($order = Criteria::ASC) Order by the dte_maj_act column
 * @method     ChildSocieteQuery orderByDte_MAJGEN($order = Criteria::ASC) Order by the dte_maj_gen column
 * @method     ChildSocieteQuery orderByisACTIF($order = Criteria::ASC) Order by the actif column
 *
 * @method     ChildSocieteQuery groupByID() Group by the soc_id column
 * @method     ChildSocieteQuery groupBySociete() Group by the societe column
 * @method     ChildSocieteQuery groupByDirigeant() Group by the dirigeant column
 * @method     ChildSocieteQuery groupByEmail() Group by the mail column
 * @method     ChildSocieteQuery groupByWebsite() Group by the website column
 * @method     ChildSocieteQuery groupByTelephone() Group by the tel column
 * @method     ChildSocieteQuery groupByFax() Group by the fax column
 * @method     ChildSocieteQuery groupByAdresses() Group by the adresse column
 * @method     ChildSocieteQuery groupByCP() Group by the cp column
 * @method     ChildSocieteQuery groupByVille() Group by the ville column
 * @method     ChildSocieteQuery groupByPays() Group by the pays column
 * @method     ChildSocieteQuery groupByNotes() Group by the notes column
 * @method     ChildSocieteQuery groupByNotesactivite() Group by the notes_activite column
 * @method     ChildSocieteQuery groupBySourceRIB() Group by the scrRIB column
 * @method     ChildSocieteQuery groupByFabricant() Group by the fabricant column
 * @method     ChildSocieteQuery groupByLogo() Group by the logo column
 * @method     ChildSocieteQuery groupByisFraude() Group by the fraude column
 * @method     ChildSocieteQuery groupByDateMAJSOC() Group by the dte_maj_soc column
 * @method     ChildSocieteQuery groupByDte_MAJACT() Group by the dte_maj_act column
 * @method     ChildSocieteQuery groupByDte_MAJGEN() Group by the dte_maj_gen column
 * @method     ChildSocieteQuery groupByisACTIF() Group by the actif column
 *
 * @method     ChildSocieteQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSocieteQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSocieteQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSocieteQuery leftJoinMPays($relationAlias = null) Adds a LEFT JOIN clause to the query using the MPays relation
 * @method     ChildSocieteQuery rightJoinMPays($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MPays relation
 * @method     ChildSocieteQuery innerJoinMPays($relationAlias = null) Adds a INNER JOIN clause to the query using the MPays relation
 *
 * @method     ChildSocieteQuery leftJoinMarque($relationAlias = null) Adds a LEFT JOIN clause to the query using the Marque relation
 * @method     ChildSocieteQuery rightJoinMarque($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Marque relation
 * @method     ChildSocieteQuery innerJoinMarque($relationAlias = null) Adds a INNER JOIN clause to the query using the Marque relation
 *
 * @method     ChildSocieteQuery leftJoinBFPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the BFPartenaire relation
 * @method     ChildSocieteQuery rightJoinBFPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BFPartenaire relation
 * @method     ChildSocieteQuery innerJoinBFPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the BFPartenaire relation
 *
 * @method     ChildSocieteQuery leftJoinBPPartenaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the BPPartenaire relation
 * @method     ChildSocieteQuery rightJoinBPPartenaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BPPartenaire relation
 * @method     ChildSocieteQuery innerJoinBPPartenaire($relationAlias = null) Adds a INNER JOIN clause to the query using the BPPartenaire relation
 *
 * @method     ChildSocieteQuery leftJoinMROCentre($relationAlias = null) Adds a LEFT JOIN clause to the query using the MROCentre relation
 * @method     ChildSocieteQuery rightJoinMROCentre($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MROCentre relation
 * @method     ChildSocieteQuery innerJoinMROCentre($relationAlias = null) Adds a INNER JOIN clause to the query using the MROCentre relation
 *
 * @method     ChildSocieteQuery leftJoinMROSociete($relationAlias = null) Adds a LEFT JOIN clause to the query using the MROSociete relation
 * @method     ChildSocieteQuery rightJoinMROSociete($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MROSociete relation
 * @method     ChildSocieteQuery innerJoinMROSociete($relationAlias = null) Adds a INNER JOIN clause to the query using the MROSociete relation
 *
 * @method     ChildSocieteQuery leftJoinFournisseur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fournisseur relation
 * @method     ChildSocieteQuery rightJoinFournisseur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fournisseur relation
 * @method     ChildSocieteQuery innerJoinFournisseur($relationAlias = null) Adds a INNER JOIN clause to the query using the Fournisseur relation
 *
 * @method     ChildSocieteQuery leftJoinCommande($relationAlias = null) Adds a LEFT JOIN clause to the query using the Commande relation
 * @method     ChildSocieteQuery rightJoinCommande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Commande relation
 * @method     ChildSocieteQuery innerJoinCommande($relationAlias = null) Adds a INNER JOIN clause to the query using the Commande relation
 *
 * @method     ChildSocieteQuery leftJoinSocieteappareil($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societeappareil relation
 * @method     ChildSocieteQuery rightJoinSocieteappareil($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societeappareil relation
 * @method     ChildSocieteQuery innerJoinSocieteappareil($relationAlias = null) Adds a INNER JOIN clause to the query using the Societeappareil relation
 *
 * @method     ChildSocieteQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method     ChildSocieteQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method     ChildSocieteQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method     ChildSocieteQuery leftJoinSocietecertificat($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societecertificat relation
 * @method     ChildSocieteQuery rightJoinSocietecertificat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societecertificat relation
 * @method     ChildSocieteQuery innerJoinSocietecertificat($relationAlias = null) Adds a INNER JOIN clause to the query using the Societecertificat relation
 *
 * @method     ChildSocieteQuery leftJoinSocietemetier($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societemetier relation
 * @method     ChildSocieteQuery rightJoinSocietemetier($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societemetier relation
 * @method     ChildSocieteQuery innerJoinSocietemetier($relationAlias = null) Adds a INNER JOIN clause to the query using the Societemetier relation
 *
 * @method     ChildSocieteQuery leftJoinSocietetypepiece($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societetypepiece relation
 * @method     ChildSocieteQuery rightJoinSocietetypepiece($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societetypepiece relation
 * @method     ChildSocieteQuery innerJoinSocietetypepiece($relationAlias = null) Adds a INNER JOIN clause to the query using the Societetypepiece relation
 *
 * @method     ChildSocieteQuery leftJoinSocietehistorique($relationAlias = null) Adds a LEFT JOIN clause to the query using the Societehistorique relation
 * @method     ChildSocieteQuery rightJoinSocietehistorique($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Societehistorique relation
 * @method     ChildSocieteQuery innerJoinSocietehistorique($relationAlias = null) Adds a INNER JOIN clause to the query using the Societehistorique relation
 *
 * @method     ChildSocieteQuery leftJoinFinanciere($relationAlias = null) Adds a LEFT JOIN clause to the query using the Financiere relation
 * @method     ChildSocieteQuery rightJoinFinanciere($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Financiere relation
 * @method     ChildSocieteQuery innerJoinFinanciere($relationAlias = null) Adds a INNER JOIN clause to the query using the Financiere relation
 *
 * @method     ChildSocieteQuery leftJoinChiffredaffaire($relationAlias = null) Adds a LEFT JOIN clause to the query using the Chiffredaffaire relation
 * @method     ChildSocieteQuery rightJoinChiffredaffaire($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Chiffredaffaire relation
 * @method     ChildSocieteQuery innerJoinChiffredaffaire($relationAlias = null) Adds a INNER JOIN clause to the query using the Chiffredaffaire relation
 *
 * @method     ChildSocieteQuery leftJoinWebsource($relationAlias = null) Adds a LEFT JOIN clause to the query using the Websource relation
 * @method     ChildSocieteQuery rightJoinWebsource($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Websource relation
 * @method     ChildSocieteQuery innerJoinWebsource($relationAlias = null) Adds a INNER JOIN clause to the query using the Websource relation
 *
 * @method     \MPaysQuery|\MarqueQuery|\SPartenaireQuery|\MROCentreQuery|\FournisseurQuery|\CommandeQuery|\SocieteappareilQuery|\ContactQuery|\SocietecertificatQuery|\SocietemetierQuery|\SocietetypepieceQuery|\SocietehistoriqueQuery|\FinanciereQuery|\ChiffredaffaireQuery|\WebsourceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSociete findOne(ConnectionInterface $con = null) Return the first ChildSociete matching the query
 * @method     ChildSociete findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSociete matching the query, or a new ChildSociete object populated from the query conditions when no match is found
 *
 * @method     ChildSociete findOneByID(int $soc_id) Return the first ChildSociete filtered by the soc_id column
 * @method     ChildSociete findOneBySociete(string $societe) Return the first ChildSociete filtered by the societe column
 * @method     ChildSociete findOneByDirigeant(string $dirigeant) Return the first ChildSociete filtered by the dirigeant column
 * @method     ChildSociete findOneByEmail(string $mail) Return the first ChildSociete filtered by the mail column
 * @method     ChildSociete findOneByWebsite(string $website) Return the first ChildSociete filtered by the website column
 * @method     ChildSociete findOneByTelephone(string $tel) Return the first ChildSociete filtered by the tel column
 * @method     ChildSociete findOneByFax(string $fax) Return the first ChildSociete filtered by the fax column
 * @method     ChildSociete findOneByAdresses(string $adresse) Return the first ChildSociete filtered by the adresse column
 * @method     ChildSociete findOneByCP(string $cp) Return the first ChildSociete filtered by the cp column
 * @method     ChildSociete findOneByVille(string $ville) Return the first ChildSociete filtered by the ville column
 * @method     ChildSociete findOneByPays(string $pays) Return the first ChildSociete filtered by the pays column
 * @method     ChildSociete findOneByNotes(string $notes) Return the first ChildSociete filtered by the notes column
 * @method     ChildSociete findOneByNotesactivite(string $notes_activite) Return the first ChildSociete filtered by the notes_activite column
 * @method     ChildSociete findOneBySourceRIB(string $scrRIB) Return the first ChildSociete filtered by the scrRIB column
 * @method     ChildSociete findOneByFabricant(string $fabricant) Return the first ChildSociete filtered by the fabricant column
 * @method     ChildSociete findOneByLogo(string $logo) Return the first ChildSociete filtered by the logo column
 * @method     ChildSociete findOneByisFraude(boolean $fraude) Return the first ChildSociete filtered by the fraude column
 * @method     ChildSociete findOneByDateMAJSOC(string $dte_maj_soc) Return the first ChildSociete filtered by the dte_maj_soc column
 * @method     ChildSociete findOneByDte_MAJACT(string $dte_maj_act) Return the first ChildSociete filtered by the dte_maj_act column
 * @method     ChildSociete findOneByDte_MAJGEN(string $dte_maj_gen) Return the first ChildSociete filtered by the dte_maj_gen column
 * @method     ChildSociete findOneByisACTIF(boolean $actif) Return the first ChildSociete filtered by the actif column *

 * @method     ChildSociete requirePk($key, ConnectionInterface $con = null) Return the ChildSociete by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOne(ConnectionInterface $con = null) Return the first ChildSociete matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSociete requireOneByID(int $soc_id) Return the first ChildSociete filtered by the soc_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneBySociete(string $societe) Return the first ChildSociete filtered by the societe column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByDirigeant(string $dirigeant) Return the first ChildSociete filtered by the dirigeant column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByEmail(string $mail) Return the first ChildSociete filtered by the mail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByWebsite(string $website) Return the first ChildSociete filtered by the website column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByTelephone(string $tel) Return the first ChildSociete filtered by the tel column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByFax(string $fax) Return the first ChildSociete filtered by the fax column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByAdresses(string $adresse) Return the first ChildSociete filtered by the adresse column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByCP(string $cp) Return the first ChildSociete filtered by the cp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByVille(string $ville) Return the first ChildSociete filtered by the ville column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByPays(string $pays) Return the first ChildSociete filtered by the pays column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByNotes(string $notes) Return the first ChildSociete filtered by the notes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByNotesactivite(string $notes_activite) Return the first ChildSociete filtered by the notes_activite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneBySourceRIB(string $scrRIB) Return the first ChildSociete filtered by the scrRIB column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByFabricant(string $fabricant) Return the first ChildSociete filtered by the fabricant column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByLogo(string $logo) Return the first ChildSociete filtered by the logo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByisFraude(boolean $fraude) Return the first ChildSociete filtered by the fraude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByDateMAJSOC(string $dte_maj_soc) Return the first ChildSociete filtered by the dte_maj_soc column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByDte_MAJACT(string $dte_maj_act) Return the first ChildSociete filtered by the dte_maj_act column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByDte_MAJGEN(string $dte_maj_gen) Return the first ChildSociete filtered by the dte_maj_gen column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSociete requireOneByisACTIF(boolean $actif) Return the first ChildSociete filtered by the actif column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSociete[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSociete objects based on current ModelCriteria
 * @method     ChildSociete[]|ObjectCollection findByID(int $soc_id) Return ChildSociete objects filtered by the soc_id column
 * @method     ChildSociete[]|ObjectCollection findBySociete(string $societe) Return ChildSociete objects filtered by the societe column
 * @method     ChildSociete[]|ObjectCollection findByDirigeant(string $dirigeant) Return ChildSociete objects filtered by the dirigeant column
 * @method     ChildSociete[]|ObjectCollection findByEmail(string $mail) Return ChildSociete objects filtered by the mail column
 * @method     ChildSociete[]|ObjectCollection findByWebsite(string $website) Return ChildSociete objects filtered by the website column
 * @method     ChildSociete[]|ObjectCollection findByTelephone(string $tel) Return ChildSociete objects filtered by the tel column
 * @method     ChildSociete[]|ObjectCollection findByFax(string $fax) Return ChildSociete objects filtered by the fax column
 * @method     ChildSociete[]|ObjectCollection findByAdresses(string $adresse) Return ChildSociete objects filtered by the adresse column
 * @method     ChildSociete[]|ObjectCollection findByCP(string $cp) Return ChildSociete objects filtered by the cp column
 * @method     ChildSociete[]|ObjectCollection findByVille(string $ville) Return ChildSociete objects filtered by the ville column
 * @method     ChildSociete[]|ObjectCollection findByPays(string $pays) Return ChildSociete objects filtered by the pays column
 * @method     ChildSociete[]|ObjectCollection findByNotes(string $notes) Return ChildSociete objects filtered by the notes column
 * @method     ChildSociete[]|ObjectCollection findByNotesactivite(string $notes_activite) Return ChildSociete objects filtered by the notes_activite column
 * @method     ChildSociete[]|ObjectCollection findBySourceRIB(string $scrRIB) Return ChildSociete objects filtered by the scrRIB column
 * @method     ChildSociete[]|ObjectCollection findByFabricant(string $fabricant) Return ChildSociete objects filtered by the fabricant column
 * @method     ChildSociete[]|ObjectCollection findByLogo(string $logo) Return ChildSociete objects filtered by the logo column
 * @method     ChildSociete[]|ObjectCollection findByisFraude(boolean $fraude) Return ChildSociete objects filtered by the fraude column
 * @method     ChildSociete[]|ObjectCollection findByDateMAJSOC(string $dte_maj_soc) Return ChildSociete objects filtered by the dte_maj_soc column
 * @method     ChildSociete[]|ObjectCollection findByDte_MAJACT(string $dte_maj_act) Return ChildSociete objects filtered by the dte_maj_act column
 * @method     ChildSociete[]|ObjectCollection findByDte_MAJGEN(string $dte_maj_gen) Return ChildSociete objects filtered by the dte_maj_gen column
 * @method     ChildSociete[]|ObjectCollection findByisACTIF(boolean $actif) Return ChildSociete objects filtered by the actif column
 * @method     ChildSociete[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SocieteQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SocieteQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'appliaviaco', $modelName = '\\Societe', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSocieteQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSocieteQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSocieteQuery) {
            return $criteria;
        }
        $query = new ChildSocieteQuery();
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
     * @return ChildSociete|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SocieteTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SocieteTableMap::DATABASE_NAME);
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
     * @return ChildSociete A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT soc_id, societe, dirigeant, mail, website, tel, fax, adresse, cp, ville, pays, notes, notes_activite, scrRIB, fabricant, logo, fraude, dte_maj_soc, dte_maj_act, dte_maj_gen, actif FROM societe WHERE soc_id = :p0';
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
            /** @var ChildSociete $obj */
            $obj = new ChildSociete();
            $obj->hydrate($row);
            SocieteTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSociete|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SocieteTableMap::COL_SOC_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SocieteTableMap::COL_SOC_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the soc_id column
     *
     * Example usage:
     * <code>
     * $query->filterByID(1234); // WHERE soc_id = 1234
     * $query->filterByID(array(12, 34)); // WHERE soc_id IN (12, 34)
     * $query->filterByID(array('min' => 12)); // WHERE soc_id > 12
     * </code>
     *
     * @param     mixed $iD The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByID($iD = null, $comparison = null)
    {
        if (is_array($iD)) {
            $useMinMax = false;
            if (isset($iD['min'])) {
                $this->addUsingAlias(SocieteTableMap::COL_SOC_ID, $iD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iD['max'])) {
                $this->addUsingAlias(SocieteTableMap::COL_SOC_ID, $iD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_SOC_ID, $iD, $comparison);
    }

    /**
     * Filter the query on the societe column
     *
     * Example usage:
     * <code>
     * $query->filterBySociete('fooValue');   // WHERE societe = 'fooValue'
     * $query->filterBySociete('%fooValue%'); // WHERE societe LIKE '%fooValue%'
     * </code>
     *
     * @param     string $societe The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterBySociete($societe = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($societe)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $societe)) {
                $societe = str_replace('*', '%', $societe);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_SOCIETE, $societe, $comparison);
    }

    /**
     * Filter the query on the dirigeant column
     *
     * Example usage:
     * <code>
     * $query->filterByDirigeant('fooValue');   // WHERE dirigeant = 'fooValue'
     * $query->filterByDirigeant('%fooValue%'); // WHERE dirigeant LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dirigeant The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByDirigeant($dirigeant = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dirigeant)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $dirigeant)) {
                $dirigeant = str_replace('*', '%', $dirigeant);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_DIRIGEANT, $dirigeant, $comparison);
    }

    /**
     * Filter the query on the mail column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE mail = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE mail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SocieteTableMap::COL_MAIL, $email, $comparison);
    }

    /**
     * Filter the query on the website column
     *
     * Example usage:
     * <code>
     * $query->filterByWebsite('fooValue');   // WHERE website = 'fooValue'
     * $query->filterByWebsite('%fooValue%'); // WHERE website LIKE '%fooValue%'
     * </code>
     *
     * @param     string $website The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByWebsite($website = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($website)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $website)) {
                $website = str_replace('*', '%', $website);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_WEBSITE, $website, $comparison);
    }

    /**
     * Filter the query on the tel column
     *
     * Example usage:
     * <code>
     * $query->filterByTelephone('fooValue');   // WHERE tel = 'fooValue'
     * $query->filterByTelephone('%fooValue%'); // WHERE tel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $telephone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SocieteTableMap::COL_TEL, $telephone, $comparison);
    }

    /**
     * Filter the query on the fax column
     *
     * Example usage:
     * <code>
     * $query->filterByFax('fooValue');   // WHERE fax = 'fooValue'
     * $query->filterByFax('%fooValue%'); // WHERE fax LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fax The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByFax($fax = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fax)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fax)) {
                $fax = str_replace('*', '%', $fax);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_FAX, $fax, $comparison);
    }

    /**
     * Filter the query on the adresse column
     *
     * Example usage:
     * <code>
     * $query->filterByAdresses('fooValue');   // WHERE adresse = 'fooValue'
     * $query->filterByAdresses('%fooValue%'); // WHERE adresse LIKE '%fooValue%'
     * </code>
     *
     * @param     string $adresses The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SocieteTableMap::COL_ADRESSE, $adresses, $comparison);
    }

    /**
     * Filter the query on the cp column
     *
     * Example usage:
     * <code>
     * $query->filterByCP('fooValue');   // WHERE cp = 'fooValue'
     * $query->filterByCP('%fooValue%'); // WHERE cp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cP The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByCP($cP = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cP)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cP)) {
                $cP = str_replace('*', '%', $cP);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_CP, $cP, $comparison);
    }

    /**
     * Filter the query on the ville column
     *
     * Example usage:
     * <code>
     * $query->filterByVille('fooValue');   // WHERE ville = 'fooValue'
     * $query->filterByVille('%fooValue%'); // WHERE ville LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ville The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByVille($ville = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ville)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ville)) {
                $ville = str_replace('*', '%', $ville);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_VILLE, $ville, $comparison);
    }

    /**
     * Filter the query on the pays column
     *
     * Example usage:
     * <code>
     * $query->filterByPays('fooValue');   // WHERE pays = 'fooValue'
     * $query->filterByPays('%fooValue%'); // WHERE pays LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pays The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByPays($pays = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pays)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pays)) {
                $pays = str_replace('*', '%', $pays);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_PAYS, $pays, $comparison);
    }

    /**
     * Filter the query on the notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes('fooValue');   // WHERE notes = 'fooValue'
     * $query->filterByNotes('%fooValue%'); // WHERE notes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByNotes($notes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notes)) {
                $notes = str_replace('*', '%', $notes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_NOTES, $notes, $comparison);
    }

    /**
     * Filter the query on the notes_activite column
     *
     * Example usage:
     * <code>
     * $query->filterByNotesactivite('fooValue');   // WHERE notes_activite = 'fooValue'
     * $query->filterByNotesactivite('%fooValue%'); // WHERE notes_activite LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notesactivite The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByNotesactivite($notesactivite = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notesactivite)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notesactivite)) {
                $notesactivite = str_replace('*', '%', $notesactivite);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_NOTES_ACTIVITE, $notesactivite, $comparison);
    }

    /**
     * Filter the query on the scrRIB column
     *
     * Example usage:
     * <code>
     * $query->filterBySourceRIB('fooValue');   // WHERE scrRIB = 'fooValue'
     * $query->filterBySourceRIB('%fooValue%'); // WHERE scrRIB LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sourceRIB The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterBySourceRIB($sourceRIB = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sourceRIB)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sourceRIB)) {
                $sourceRIB = str_replace('*', '%', $sourceRIB);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_SCRRIB, $sourceRIB, $comparison);
    }

    /**
     * Filter the query on the fabricant column
     *
     * Example usage:
     * <code>
     * $query->filterByFabricant('fooValue');   // WHERE fabricant = 'fooValue'
     * $query->filterByFabricant('%fooValue%'); // WHERE fabricant LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fabricant The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByFabricant($fabricant = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fabricant)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fabricant)) {
                $fabricant = str_replace('*', '%', $fabricant);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_FABRICANT, $fabricant, $comparison);
    }

    /**
     * Filter the query on the logo column
     *
     * Example usage:
     * <code>
     * $query->filterByLogo('fooValue');   // WHERE logo = 'fooValue'
     * $query->filterByLogo('%fooValue%'); // WHERE logo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $logo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SocieteTableMap::COL_LOGO, $logo, $comparison);
    }

    /**
     * Filter the query on the fraude column
     *
     * Example usage:
     * <code>
     * $query->filterByisFraude(true); // WHERE fraude = true
     * $query->filterByisFraude('yes'); // WHERE fraude = true
     * </code>
     *
     * @param     boolean|string $isFraude The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByisFraude($isFraude = null, $comparison = null)
    {
        if (is_string($isFraude)) {
            $isFraude = in_array(strtolower($isFraude), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SocieteTableMap::COL_FRAUDE, $isFraude, $comparison);
    }

    /**
     * Filter the query on the dte_maj_soc column
     *
     * Example usage:
     * <code>
     * $query->filterByDateMAJSOC('2011-03-14'); // WHERE dte_maj_soc = '2011-03-14'
     * $query->filterByDateMAJSOC('now'); // WHERE dte_maj_soc = '2011-03-14'
     * $query->filterByDateMAJSOC(array('max' => 'yesterday')); // WHERE dte_maj_soc > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateMAJSOC The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByDateMAJSOC($dateMAJSOC = null, $comparison = null)
    {
        if (is_array($dateMAJSOC)) {
            $useMinMax = false;
            if (isset($dateMAJSOC['min'])) {
                $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_SOC, $dateMAJSOC['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateMAJSOC['max'])) {
                $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_SOC, $dateMAJSOC['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_SOC, $dateMAJSOC, $comparison);
    }

    /**
     * Filter the query on the dte_maj_act column
     *
     * Example usage:
     * <code>
     * $query->filterByDte_MAJACT('2011-03-14'); // WHERE dte_maj_act = '2011-03-14'
     * $query->filterByDte_MAJACT('now'); // WHERE dte_maj_act = '2011-03-14'
     * $query->filterByDte_MAJACT(array('max' => 'yesterday')); // WHERE dte_maj_act > '2011-03-13'
     * </code>
     *
     * @param     mixed $dte_MAJACT The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByDte_MAJACT($dte_MAJACT = null, $comparison = null)
    {
        if (is_array($dte_MAJACT)) {
            $useMinMax = false;
            if (isset($dte_MAJACT['min'])) {
                $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_ACT, $dte_MAJACT['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dte_MAJACT['max'])) {
                $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_ACT, $dte_MAJACT['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_ACT, $dte_MAJACT, $comparison);
    }

    /**
     * Filter the query on the dte_maj_gen column
     *
     * Example usage:
     * <code>
     * $query->filterByDte_MAJGEN('2011-03-14'); // WHERE dte_maj_gen = '2011-03-14'
     * $query->filterByDte_MAJGEN('now'); // WHERE dte_maj_gen = '2011-03-14'
     * $query->filterByDte_MAJGEN(array('max' => 'yesterday')); // WHERE dte_maj_gen > '2011-03-13'
     * </code>
     *
     * @param     mixed $dte_MAJGEN The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByDte_MAJGEN($dte_MAJGEN = null, $comparison = null)
    {
        if (is_array($dte_MAJGEN)) {
            $useMinMax = false;
            if (isset($dte_MAJGEN['min'])) {
                $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_GEN, $dte_MAJGEN['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dte_MAJGEN['max'])) {
                $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_GEN, $dte_MAJGEN['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SocieteTableMap::COL_DTE_MAJ_GEN, $dte_MAJGEN, $comparison);
    }

    /**
     * Filter the query on the actif column
     *
     * Example usage:
     * <code>
     * $query->filterByisACTIF(true); // WHERE actif = true
     * $query->filterByisACTIF('yes'); // WHERE actif = true
     * </code>
     *
     * @param     boolean|string $isACTIF The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByisACTIF($isACTIF = null, $comparison = null)
    {
        if (is_string($isACTIF)) {
            $isACTIF = in_array(strtolower($isACTIF), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SocieteTableMap::COL_ACTIF, $isACTIF, $comparison);
    }

    /**
     * Filter the query by a related \MPays object
     *
     * @param \MPays|ObjectCollection $mPays The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByMPays($mPays, $comparison = null)
    {
        if ($mPays instanceof \MPays) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_PAYS, $mPays->getPays(), $comparison);
        } elseif ($mPays instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocieteTableMap::COL_PAYS, $mPays->toKeyValue('PrimaryKey', 'Pays'), $comparison);
        } else {
            throw new PropelException('filterByMPays() only accepts arguments of type \MPays or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MPays relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinMPays($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MPays');

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
            $this->addJoinObject($join, 'MPays');
        }

        return $this;
    }

    /**
     * Use the MPays relation MPays object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MPaysQuery A secondary query class using the current class as primary query
     */
    public function useMPaysQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMPays($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MPays', '\MPaysQuery');
    }

    /**
     * Filter the query by a related \Marque object
     *
     * @param \Marque|ObjectCollection $marque The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByMarque($marque, $comparison = null)
    {
        if ($marque instanceof \Marque) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_FABRICANT, $marque->getMarque(), $comparison);
        } elseif ($marque instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SocieteTableMap::COL_FABRICANT, $marque->toKeyValue('PrimaryKey', 'Marque'), $comparison);
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
     * @return $this|ChildSocieteQuery The current query, for fluid interface
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
     * Filter the query by a related \SPartenaire object
     *
     * @param \SPartenaire|ObjectCollection $sPartenaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByBFPartenaire($sPartenaire, $comparison = null)
    {
        if ($sPartenaire instanceof \SPartenaire) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOC_ID, $sPartenaire->getSFraude(), $comparison);
        } elseif ($sPartenaire instanceof ObjectCollection) {
            return $this
                ->useBFPartenaireQuery()
                ->filterByPrimaryKeys($sPartenaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBFPartenaire() only accepts arguments of type \SPartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BFPartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinBFPartenaire($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BFPartenaire');

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
            $this->addJoinObject($join, 'BFPartenaire');
        }

        return $this;
    }

    /**
     * Use the BFPartenaire relation SPartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPartenaireQuery A secondary query class using the current class as primary query
     */
    public function useBFPartenaireQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBFPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BFPartenaire', '\SPartenaireQuery');
    }

    /**
     * Filter the query by a related \SPartenaire object
     *
     * @param \SPartenaire|ObjectCollection $sPartenaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByBPPartenaire($sPartenaire, $comparison = null)
    {
        if ($sPartenaire instanceof \SPartenaire) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOC_ID, $sPartenaire->getSPlaigante(), $comparison);
        } elseif ($sPartenaire instanceof ObjectCollection) {
            return $this
                ->useBPPartenaireQuery()
                ->filterByPrimaryKeys($sPartenaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBPPartenaire() only accepts arguments of type \SPartenaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BPPartenaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinBPPartenaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BPPartenaire');

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
            $this->addJoinObject($join, 'BPPartenaire');
        }

        return $this;
    }

    /**
     * Use the BPPartenaire relation SPartenaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SPartenaireQuery A secondary query class using the current class as primary query
     */
    public function useBPPartenaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBPPartenaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BPPartenaire', '\SPartenaireQuery');
    }

    /**
     * Filter the query by a related \MROCentre object
     *
     * @param \MROCentre|ObjectCollection $mROCentre the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByMROCentre($mROCentre, $comparison = null)
    {
        if ($mROCentre instanceof \MROCentre) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $mROCentre->getSociete_FK(), $comparison);
        } elseif ($mROCentre instanceof ObjectCollection) {
            return $this
                ->useMROCentreQuery()
                ->filterByPrimaryKeys($mROCentre->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMROCentre() only accepts arguments of type \MROCentre or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MROCentre relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinMROCentre($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MROCentre');

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
            $this->addJoinObject($join, 'MROCentre');
        }

        return $this;
    }

    /**
     * Use the MROCentre relation MROCentre object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MROCentreQuery A secondary query class using the current class as primary query
     */
    public function useMROCentreQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMROCentre($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MROCentre', '\MROCentreQuery');
    }

    /**
     * Filter the query by a related \MROCentre object
     *
     * @param \MROCentre|ObjectCollection $mROCentre the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByMROSociete($mROCentre, $comparison = null)
    {
        if ($mROCentre instanceof \MROCentre) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $mROCentre->getMRO(), $comparison);
        } elseif ($mROCentre instanceof ObjectCollection) {
            return $this
                ->useMROSocieteQuery()
                ->filterByPrimaryKeys($mROCentre->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMROSociete() only accepts arguments of type \MROCentre or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MROSociete relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinMROSociete($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MROSociete');

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
            $this->addJoinObject($join, 'MROSociete');
        }

        return $this;
    }

    /**
     * Use the MROSociete relation MROCentre object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MROCentreQuery A secondary query class using the current class as primary query
     */
    public function useMROSocieteQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMROSociete($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MROSociete', '\MROCentreQuery');
    }

    /**
     * Filter the query by a related \Fournisseur object
     *
     * @param \Fournisseur|ObjectCollection $fournisseur the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByFournisseur($fournisseur, $comparison = null)
    {
        if ($fournisseur instanceof \Fournisseur) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOC_ID, $fournisseur->getIDSoc_FK(), $comparison);
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
     * @return $this|ChildSocieteQuery The current query, for fluid interface
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
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByCommande($commande, $comparison = null)
    {
        if ($commande instanceof \Commande) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOC_ID, $commande->getIDSociete_FK(), $comparison);
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
     * @return $this|ChildSocieteQuery The current query, for fluid interface
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
     * Filter the query by a related \Societeappareil object
     *
     * @param \Societeappareil|ObjectCollection $societeappareil the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterBySocieteappareil($societeappareil, $comparison = null)
    {
        if ($societeappareil instanceof \Societeappareil) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $societeappareil->getSociete_FK(), $comparison);
        } elseif ($societeappareil instanceof ObjectCollection) {
            return $this
                ->useSocieteappareilQuery()
                ->filterByPrimaryKeys($societeappareil->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySocieteappareil() only accepts arguments of type \Societeappareil or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societeappareil relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinSocieteappareil($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societeappareil');

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
            $this->addJoinObject($join, 'Societeappareil');
        }

        return $this;
    }

    /**
     * Use the Societeappareil relation Societeappareil object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocieteappareilQuery A secondary query class using the current class as primary query
     */
    public function useSocieteappareilQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocieteappareil($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societeappareil', '\SocieteappareilQuery');
    }

    /**
     * Filter the query by a related \Contact object
     *
     * @param \Contact|ObjectCollection $contact the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof \Contact) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $contact->getsociete_FK(), $comparison);
        } elseif ($contact instanceof ObjectCollection) {
            return $this
                ->useContactQuery()
                ->filterByPrimaryKeys($contact->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContact() only accepts arguments of type \Contact or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contact relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinContact($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contact');

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
            $this->addJoinObject($join, 'Contact');
        }

        return $this;
    }

    /**
     * Use the Contact relation Contact object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ContactQuery A secondary query class using the current class as primary query
     */
    public function useContactQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContact($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contact', '\ContactQuery');
    }

    /**
     * Filter the query by a related \Societecertificat object
     *
     * @param \Societecertificat|ObjectCollection $societecertificat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterBySocietecertificat($societecertificat, $comparison = null)
    {
        if ($societecertificat instanceof \Societecertificat) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $societecertificat->getsociete_PK(), $comparison);
        } elseif ($societecertificat instanceof ObjectCollection) {
            return $this
                ->useSocietecertificatQuery()
                ->filterByPrimaryKeys($societecertificat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySocietecertificat() only accepts arguments of type \Societecertificat or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societecertificat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinSocietecertificat($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societecertificat');

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
            $this->addJoinObject($join, 'Societecertificat');
        }

        return $this;
    }

    /**
     * Use the Societecertificat relation Societecertificat object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocietecertificatQuery A secondary query class using the current class as primary query
     */
    public function useSocietecertificatQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocietecertificat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societecertificat', '\SocietecertificatQuery');
    }

    /**
     * Filter the query by a related \Societemetier object
     *
     * @param \Societemetier|ObjectCollection $societemetier the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterBySocietemetier($societemetier, $comparison = null)
    {
        if ($societemetier instanceof \Societemetier) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $societemetier->getSociete_PK(), $comparison);
        } elseif ($societemetier instanceof ObjectCollection) {
            return $this
                ->useSocietemetierQuery()
                ->filterByPrimaryKeys($societemetier->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySocietemetier() only accepts arguments of type \Societemetier or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societemetier relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinSocietemetier($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societemetier');

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
            $this->addJoinObject($join, 'Societemetier');
        }

        return $this;
    }

    /**
     * Use the Societemetier relation Societemetier object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocietemetierQuery A secondary query class using the current class as primary query
     */
    public function useSocietemetierQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocietemetier($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societemetier', '\SocietemetierQuery');
    }

    /**
     * Filter the query by a related \Societetypepiece object
     *
     * @param \Societetypepiece|ObjectCollection $societetypepiece the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterBySocietetypepiece($societetypepiece, $comparison = null)
    {
        if ($societetypepiece instanceof \Societetypepiece) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $societetypepiece->getSociete_PK(), $comparison);
        } elseif ($societetypepiece instanceof ObjectCollection) {
            return $this
                ->useSocietetypepieceQuery()
                ->filterByPrimaryKeys($societetypepiece->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySocietetypepiece() only accepts arguments of type \Societetypepiece or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societetypepiece relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinSocietetypepiece($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societetypepiece');

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
            $this->addJoinObject($join, 'Societetypepiece');
        }

        return $this;
    }

    /**
     * Use the Societetypepiece relation Societetypepiece object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocietetypepieceQuery A secondary query class using the current class as primary query
     */
    public function useSocietetypepieceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocietetypepiece($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societetypepiece', '\SocietetypepieceQuery');
    }

    /**
     * Filter the query by a related \Societehistorique object
     *
     * @param \Societehistorique|ObjectCollection $societehistorique the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterBySocietehistorique($societehistorique, $comparison = null)
    {
        if ($societehistorique instanceof \Societehistorique) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $societehistorique->getSociete_PK(), $comparison);
        } elseif ($societehistorique instanceof ObjectCollection) {
            return $this
                ->useSocietehistoriqueQuery()
                ->filterByPrimaryKeys($societehistorique->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySocietehistorique() only accepts arguments of type \Societehistorique or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Societehistorique relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinSocietehistorique($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Societehistorique');

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
            $this->addJoinObject($join, 'Societehistorique');
        }

        return $this;
    }

    /**
     * Use the Societehistorique relation Societehistorique object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SocietehistoriqueQuery A secondary query class using the current class as primary query
     */
    public function useSocietehistoriqueQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSocietehistorique($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Societehistorique', '\SocietehistoriqueQuery');
    }

    /**
     * Filter the query by a related \Financiere object
     *
     * @param \Financiere|ObjectCollection $financiere the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByFinanciere($financiere, $comparison = null)
    {
        if ($financiere instanceof \Financiere) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $financiere->getSociete_FK(), $comparison);
        } elseif ($financiere instanceof ObjectCollection) {
            return $this
                ->useFinanciereQuery()
                ->filterByPrimaryKeys($financiere->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFinanciere() only accepts arguments of type \Financiere or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Financiere relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinFinanciere($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Financiere');

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
            $this->addJoinObject($join, 'Financiere');
        }

        return $this;
    }

    /**
     * Use the Financiere relation Financiere object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FinanciereQuery A secondary query class using the current class as primary query
     */
    public function useFinanciereQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFinanciere($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Financiere', '\FinanciereQuery');
    }

    /**
     * Filter the query by a related \Chiffredaffaire object
     *
     * @param \Chiffredaffaire|ObjectCollection $chiffredaffaire the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByChiffredaffaire($chiffredaffaire, $comparison = null)
    {
        if ($chiffredaffaire instanceof \Chiffredaffaire) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $chiffredaffaire->getsociete_FK(), $comparison);
        } elseif ($chiffredaffaire instanceof ObjectCollection) {
            return $this
                ->useChiffredaffaireQuery()
                ->filterByPrimaryKeys($chiffredaffaire->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByChiffredaffaire() only accepts arguments of type \Chiffredaffaire or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Chiffredaffaire relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinChiffredaffaire($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Chiffredaffaire');

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
            $this->addJoinObject($join, 'Chiffredaffaire');
        }

        return $this;
    }

    /**
     * Use the Chiffredaffaire relation Chiffredaffaire object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChiffredaffaireQuery A secondary query class using the current class as primary query
     */
    public function useChiffredaffaireQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinChiffredaffaire($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Chiffredaffaire', '\ChiffredaffaireQuery');
    }

    /**
     * Filter the query by a related \Websource object
     *
     * @param \Websource|ObjectCollection $websource the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSocieteQuery The current query, for fluid interface
     */
    public function filterByWebsource($websource, $comparison = null)
    {
        if ($websource instanceof \Websource) {
            return $this
                ->addUsingAlias(SocieteTableMap::COL_SOCIETE, $websource->getsociete_FK(), $comparison);
        } elseif ($websource instanceof ObjectCollection) {
            return $this
                ->useWebsourceQuery()
                ->filterByPrimaryKeys($websource->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWebsource() only accepts arguments of type \Websource or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Websource relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function joinWebsource($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Websource');

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
            $this->addJoinObject($join, 'Websource');
        }

        return $this;
    }

    /**
     * Use the Websource relation Websource object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \WebsourceQuery A secondary query class using the current class as primary query
     */
    public function useWebsourceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWebsource($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Websource', '\WebsourceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSociete $societe Object to remove from the list of results
     *
     * @return $this|ChildSocieteQuery The current query, for fluid interface
     */
    public function prune($societe = null)
    {
        if ($societe) {
            $this->addUsingAlias(SocieteTableMap::COL_SOC_ID, $societe->getID(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the societe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SocieteTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SocieteTableMap::clearInstancePool();
            SocieteTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SocieteTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SocieteTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SocieteTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SocieteTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SocieteQuery
