<?php
//Data/BestellingDAO.php
declare(strict_types=1);

namespace Data;

use Entities\Bestelling;
use PDO;
use Exceptions\Exception;

require_once __DIR__ . "/DBConfig.php";


class BestellingDAO {
    private $dbConn;

    public function __construct() {
        $this->dbConn = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct() {
        $this->dbConn = null; // Verbreek de databaseverbinding wanneer het object wordt vernietigd
    }

    public function getAllBestellingen(): array {
        $sql = "SELECT * FROM bestelling";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute();

        $bestellingen = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bestelling = new Bestelling();
            $bestelling->setBestellingId($row["bestelling_id"]);
            $bestelling->setKlantId($row["klant_id"]);
            $bestelling->setBestellingDatum($row["bestellingdatum"]);
            $bestelling->setPlaatsId($row["plaats_id"]);
            $bestelling->setStatus($row["status"]);

            $bestellingen[] = $bestelling;
        }

        return $bestellingen;
    }

    public function getBestellingById(int $bestellingId): Bestelling {
        $sql = "SELECT * FROM bestelling WHERE bestelling_id = :bestelling_id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(":bestelling_id", $bestellingId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new Exception("Bestelling met ID $bestellingId niet gevonden");
        }

        $bestelling = new Bestelling();
        $bestelling->setBestellingId($row["bestelling_id"]);
        $bestelling->setKlantId($row["klant_id"]);
        $bestelling->setBestellingDatum($row["bestellingdatum"]);
        $bestelling->setPlaatsId($row["plaats_id"]);
        $bestelling->setStatus($row["status"]);

        return $bestelling;
    }

    public function createBestelling(Bestelling $bestelling): void {
        $klantId = $bestelling->getKlantId();
        $bestellingDatum = $bestelling->getBestellingDatum();
        $plaatsId = $bestelling->getPlaatsId();
        $status = $bestelling->getStatus();

        $sql = "INSERT INTO bestelling (klant_id, bestellingdatum, plaats_id, status) VALUES (:klant_id, :bestellingdatum, :plaats_id, :status)";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(":klant_id", $klantId);
        $stmt->bindParam(":bestellingdatum", $bestellingDatum);
        $stmt->bindParam(":plaats_id", $plaatsId);
        $stmt->bindParam(":status", $status);
        $stmt->execute();
    }

    public function updateBestelling(Bestelling $bestelling): void {
        $bestellingId = $bestelling->getBestellingId();
        $klantId = $bestelling->getKlantId();
        $bestellingDatum = $bestelling->getBestellingDatum();
        $plaatsId = $bestelling->getPlaatsId();
        $status = $bestelling->getStatus();
    
        $sql = "UPDATE bestelling SET klant_id = :klant_id, bestellingdatum = :bestellingdatum, plaats_id = :plaats_id, status = :status WHERE bestelling_id = :bestelling_id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(":bestelling_id", $bestellingId, PDO::PARAM_INT);
        $stmt->bindParam(":klant_id", $klantId);
        $stmt->bindParam(":bestellingdatum", $bestellingDatum);
        $stmt->bindParam(":plaats_id", $plaatsId);
        $stmt->bindParam(":status", $status);
        $stmt->execute();
    }
    public function insert(Bestelling $bestelling): int {
        $sql = "INSERT INTO bestelling (klant_id, bestellingdatum, plaats_id, status) VALUES (:klant_id, :bestellingdatum, :plaats_id, :status)";
        $stmt = $this->dbConn->prepare($sql);
        
       
        $klantId = $bestelling->getKlantId();
        $bestellingDatum = $bestelling->getBestellingDatum();
        $plaatsId = $bestelling->getPlaatsId();
        $status = $bestelling->getStatus();

        
        $stmt->bindParam(":klant_id", $klantId);
        $stmt->bindParam(":bestellingdatum", $bestellingDatum);
        $stmt->bindParam(":plaats_id", $plaatsId);
        $stmt->bindParam(":status", $status);

        $stmt->execute();
        
        $lastInsertId = (int) $this->dbConn->lastInsertId();
        return $lastInsertId;
    }
}