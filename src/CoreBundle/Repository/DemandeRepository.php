<?php
namespace CoreBundle\Repository;
use Doctrine\DBAL\Connection;
use CoreBundle\Entity\Demande;


class DemandeRepository
{
    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public static $TABLENAME = "Demande";
    public static $DESCRIPTION = "description";
    public static $ID = "_ID";
    public static $POIDS = "poids";
    public static $DATE = "date";
    public static $USERID = "idUser";
    public static $ACCEPTED = "accepted";

    public function find($id) {
        $sql = "select * from ".DemandeRepository::$TABLENAME." where ".DemandeRepository::$ID."=?";
        $row = $this->db->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("Pas de demande pour id " . $id);
    }

    public function findDemandesOf($userId) {
        $sql = "select * from ".DemandeRepository::$TABLENAME." where ".DemandeRepository::$USERID."=?";
        $rows = $this->db->fetchAll($sql, array($userId));
        $demandes = array();
        if ($rows)
        {
            foreach ($rows as $row)
             $demandes[] = $this->buildDomainObject($row);


            return $demandes;
        }
        else
            throw new \Exception("Pas de demandes pour l'utilisateur " . $userId);
    }

    protected function buildDomainObject(array $row) {
        $demande = new Demande();
        $demande->setId($row[DemandeRepository::$ID]);
        $demande->setDescription($row[DemandeRepository::$DESCRIPTION]);
        $demande->setPoids($row[DemandeRepository::$POIDS]);
        $demande->setDate($row[DemandeRepository::$DATE]);
        $demande->setUserId($row[DemandeRepository::$USERID]);
        return $demande;
    }
}