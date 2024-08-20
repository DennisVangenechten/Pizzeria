<?php
//Data/PlaatsDAO.php
namespace Data;

use Entities\Plaats;
use PDO;
use Exceptions\Exception;
use Data\DBConfig as DBConfig;
require_once __DIR__ . "/DBConfig.php";


class PlaatsDAO {
    private $dbConn;

    public function __construct() {
        $this->dbConn = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct() {
        $this->dbConn = null; // Verbreek de databaseverbinding wanneer het object wordt vernietigd
    }

    public function getAllPlaatsen(): array {
        $sql = "SELECT * FROM plaats";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute();

        $plaatsen = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plaats = new Plaats();
            $plaats->setPlaatsId($row["plaats_id"]);
            $plaats->setPostcode($row["postcode"]);
            $plaats->setWoonplaats($row["woonplaats"]);
            $plaats->setLeveringMogelijk($row["levering_mogelijk"]); // Voeg levering_mogelijk toe

            $plaatsen[] = $plaats;
        }

        return $plaatsen;
    }

    public function getPlaatsById(int $plaatsId): Plaats {
        $sql = "SELECT * FROM plaats WHERE plaats_id = :plaats_id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(":plaats_id", $plaatsId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new Exception("Plaats met ID $plaatsId niet gevonden");
        }

        $plaats = new Plaats();
        $plaats->setPlaatsId($row["plaats_id"]);
        $plaats->setPostcode($row["postcode"]);
        $plaats->setWoonplaats($row["woonplaats"]);
        $plaats->setLeveringMogelijk($row["levering_mogelijk"]); // Voeg levering_mogelijk toe

        return $plaats;
    }
    public function getPlaatsByLeveringMogelijk(bool $levering_mogelijk): array {
        $sql = "SELECT * FROM plaats WHERE levering_mogelijk = :levering_mogelijk";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(":levering_mogelijk", $levering_mogelijk);
        $stmt->execute();

        $plaatsen = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plaats = new Plaats();
            $plaats->setPlaatsId($row["plaats_id"]);
            $plaats->setPostcode($row["postcode"]);
            $plaats->setWoonplaats($row["woonplaats"]);
            $plaats->setLeveringMogelijk($row["levering_mogelijk"]);

            $plaatsen[] = $plaats;
        }

        return $plaatsen;
    }
}