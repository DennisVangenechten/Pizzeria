<?php
declare(strict_types=1);
//Data/BestelregelDAO.php
namespace Data;

use Entities\Bestelregel;
use PDO;
use Exceptions\Exception;

require_once __DIR__ . "/DBConfig.php";

class BestelregelDAO {
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

    public function getAllBestelregels(): array {
        try {
            $sql = "SELECT * FROM bestelregel";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute();

            $bestelregels = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $bestelregel = new Bestelregel();
                $bestelregel->setBestellingId($row["bestelling_id"]);
                $bestelregel->setProductId($row["product_id"]);
                $bestelregel->setAantal($row["aantal"]);

                $bestelregels[] = $bestelregel;
            }

            return $bestelregels;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching all order items: " . $e->getMessage());
        }
    }

    public function getBestelregelsByBestellingId(int $bestellingId): array {
        try {
            $sql = "SELECT * FROM bestelregel WHERE bestelling_id = :bestelling_id";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam(":bestelling_id", $bestellingId, PDO::PARAM_INT);
            $stmt->execute();

            $bestelregels = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $bestelregel = new Bestelregel();
                $bestelregel->setBestellingId($row["bestelling_id"]);
                $bestelregel->setProductId($row["product_id"]);
                $bestelregel->setAantal($row["aantal"]);

                $bestelregels[] = $bestelregel;
            }

            return $bestelregels;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching order items by order ID: " . $e->getMessage());
        }
    }

    public function insert(Bestelregel $bestelregel): void {
        try {
            $sql = "INSERT INTO bestelregel (bestelling_id, product_id, aantal) VALUES (:bestelling_id, :product_id, :aantal)";
            $stmt = $this->dbConn->prepare($sql);
            
            // Variabelen toewijzen aan waarden
            $bestellingId = $bestelregel->getBestellingId();
            $productId = $bestelregel->getProductId();
            $aantal = $bestelregel->getAantal();
            
            // Variabelen binden aan parameters
            $stmt->bindParam(":bestelling_id", $bestellingId);
            $stmt->bindParam(":product_id", $productId);
            $stmt->bindParam(":aantal", $aantal);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new Exception("Error inserting order item: " . $e->getMessage());
        }
    }
}
