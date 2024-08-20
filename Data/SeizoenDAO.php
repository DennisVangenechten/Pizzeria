<?php
declare(strict_types=1);
//Data/SeizoenDAO.php
namespace Data;

use Entities\Seizoen;
use PDO;
use Exceptions\Exception;
use Data\DBConfig as DBConfig;


class SeizoenDAO {
    private $dbConn;

    public function __construct() {
        try {
            $this->dbConn = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public function __destruct() {
        $this->dbConn = null; // Verbreek de databaseverbinding wanneer het object wordt vernietigd
    }

    public function getAllSeizoenen(): array {
        try {
            $sql = "SELECT * FROM seizoenen";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute();
        
            $seizoenen = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $seizoen = new Seizoen();
                $seizoen->setSeizoenId($row["seizoen_id"]);
                $seizoen->setNaam($row["naam"]);
                $seizoen->setStartDatum($row["vanaf_datum"]);  
                $seizoen->setTotDatum($row["tot_datum"]);
        
                $seizoenen[] = $seizoen;
            }
        
            return $seizoenen;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching all seasons: " . $e->getMessage());
        }
    }

    public function getSeizoenById(int $seizoenId): Seizoen {
        try {
            $sql = "SELECT * FROM seizoenen WHERE seizoen_id = :seizoen_id";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam(":seizoen_id", $seizoenId, PDO::PARAM_INT);
            $stmt->execute();
        
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                throw new Exception("Seizoen met ID $seizoenId niet gevonden");
            }
        
            $seizoen = new Seizoen();
            $seizoen->setSeizoenId($row["seizoen_id"]);
            $seizoen->setNaam($row["naam"]);
            $seizoen->setStartDatum($row["vanaf_datum"]);  
            $seizoen->setTotDatum($row["tot_datum"]);
        
            return $seizoen;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching season by ID: " . $e->getMessage());
        }
    }
}
