<?php
declare(strict_types=1);
//Data/KlantDAO.php
namespace Data;

use \PDO;
use Entities\Klant;
use Data\DBConfig as DBConfig;
use Exceptions\Exception;


class KlantDAO
{
    private $dbConn;

    public function __construct()
    {
        try {
            $this->dbConn = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->dbConn = null; // Verbreek de databaseverbinding wanneer het object wordt vernietigd
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM klant";
            $stmt = $this->dbConn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $klanten = [];
            foreach ($result as $row) {
                $klant = new Klant();
                $klant->setKlantId($row['klant_id']);
                $klant->setVoornaam($row['voornaam']);
                $klant->setNaam($row['naam']);
                $klant->setStraat($row['straat']);
                $klant->setHuisnummer($row['huisnummer']);
                $klant->setPlaatsId($row['plaats_id']);
                $klant->setTelefoon($row['telefoon']);
                $klant->setPromotie($row['promotie']);
                $klant->setBestaandeGebruiker($row['bestaande_gebruiker']);
                $klant->setEmailadres($row['emailadres']);
                $klant->setWachtwoord($row['wachtwoord']);
                $klanten[] = $klant;
            }

            return $klanten;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching all customers: " . $e->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM klant WHERE klant_id = ?";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $klant = new Klant();
                $klant->setKlantId($row['klant_id']);
                $klant->setVoornaam($row['voornaam']);
                $klant->setNaam($row['naam']);
                $klant->setStraat($row['straat']);
                $klant->setHuisnummer($row['huisnummer']);
                $klant->setPlaatsId($row['plaats_id']);
                $klant->setTelefoon($row['telefoon']);
                $klant->setPromotie($row['promotie']);
                $klant->setBestaandeGebruiker($row['bestaande_gebruiker']);
                $klant->setEmailadres($row['emailadres']);
                $klant->setWachtwoord($row['wachtwoord']);
                return $klant;
            }

            return null;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching customer by ID: " . $e->getMessage());
        }
    }

    public function getByEmail($email)
    {
        try {
            $sql = "SELECT * FROM klant WHERE emailadres = ?";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $klant = new Klant();
                $klant->setKlantId($row['klant_id']);
                $klant->setVoornaam($row['voornaam']);
                $klant->setNaam($row['naam']);
                $klant->setStraat($row['straat']);
                $klant->setHuisnummer($row['huisnummer']);
                $klant->setPlaatsId($row['plaats_id']);
                $klant->setTelefoon($row['telefoon']);
                $klant->setPromotie($row['promotie']);
                $klant->setBestaandeGebruiker($row['bestaande_gebruiker']);
                $klant->setEmailadres($row['emailadres']);
                $klant->setWachtwoord($row['wachtwoord']);
                return $klant;
            }

            return null;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching customer by email: " . $e->getMessage());
        }
    }

    public function insert(Klant $klant): int
    {
        try {
            $sql = "INSERT INTO klant (voornaam, naam, straat, huisnummer, plaats_id, telefoon, promotie, bestaande_gebruiker, emailadres, wachtwoord) 
                    VALUES (:voornaam, :naam, :straat, :huisnummer, :plaats_id, :telefoon, :promotie, :bestaande_gebruiker, :emailadres, :wachtwoord)";
            $stmt = $this->dbConn->prepare($sql);

            // Variabelen toewijzen aan waarden
            $voornaam = $klant->getVoornaam();
            $naam = $klant->getNaam();
            $straat = $klant->getStraat();
            $huisnummer = $klant->getHuisnummer();
            $plaatsId = $klant->getPlaatsId();
            $telefoon = $klant->getTelefoon();
            $promotie = $klant->getPromotie();
            $bestaandeGebruiker = $klant->getBestaandeGebruiker();
            $emailadres = $klant->getEmailadres();
            $wachtwoord = $klant->getWachtwoord();

            // Variabelen binden aan parameters
            $stmt->bindParam(":voornaam", $voornaam);
            $stmt->bindParam(":naam", $naam);
            $stmt->bindParam(":straat", $straat);
            $stmt->bindParam(":huisnummer", $huisnummer);
            $stmt->bindParam(":plaats_id", $plaatsId);
            $stmt->bindParam(":telefoon", $telefoon);
            $stmt->bindParam(":promotie", $promotie);
            $stmt->bindParam(":bestaande_gebruiker", $bestaandeGebruiker);
            $stmt->bindParam(":emailadres", $emailadres);
            $stmt->bindParam(":wachtwoord", $wachtwoord);

            $stmt->execute();

            return (int) $this->dbConn->lastInsertId();
        } catch (\PDOException $e) {
            throw new Exception("Error inserting customer: " . $e->getMessage());
        }
    }

    public function update(Klant $klant)
    {
        try {
            $sql = "UPDATE klant SET voornaam = ?, naam = ?, straat = ?, huisnummer = ?, plaats_id = ?, telefoon = ?, promotie = ?, bestaande_gebruiker = ?, emailadres = ?, wachtwoord = ? WHERE klant_id = ?";
            $stmt = $this->dbConn->prepare($sql);

            // Bepaal de waarde van bestaande_gebruiker op basis van emailadres en wachtwoord
            $bestaandeGebruiker = ($klant->getEmailadres() && $klant->getWachtwoord()) ? 1 : 0;

            $stmt->execute([
                $klant->getVoornaam(),
                $klant->getNaam(),
                $klant->getStraat(),
                $klant->getHuisnummer(),
                $klant->getPlaatsId(),
                $klant->getTelefoon(),
                $klant->getPromotie(),
                $bestaandeGebruiker,
                $klant->getEmailadres(),
                $klant->getWachtwoord(),
                $klant->getKlantId()
            ]);
        } catch (\PDOException $e) {
            throw new Exception("Error updating customer: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM klant WHERE klant_id = ?";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute([$id]);
        } catch (\PDOException $e) {
            throw new Exception("Error deleting customer: " . $e->getMessage());
        }
    }
}
