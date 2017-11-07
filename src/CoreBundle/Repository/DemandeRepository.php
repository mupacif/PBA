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

    public static $TABLENAME = "description";
    public static $DESCRIPTION = "description";
    public static $ID = "_ID";
    public static $POIDS = "poids";
    public static $DATE = "date";
    public static $USERID = "idUser";

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
        $row = $this->db->fetchAssoc($sql, array($userId));

        if ($row)
            return $this->buildDomainObject($row);
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