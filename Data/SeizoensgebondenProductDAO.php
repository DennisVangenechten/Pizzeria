<?php
declare(strict_types=1);
namespace Data;

use Entities\SeizoensgebondenProduct;
use PDO;
use Exceptions\Exception;
use Data\DBConfig as DBConfig;
require_once __DIR__ . "/DBConfig.php";

class SeizoensgebondenProductDAO {
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

    public function getAllSeizoensgebondenProducten(): array {
        try {
            $sql = "SELECT * FROM seizoensgebonden_producten";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute();

            $seizoensgebondenProducten = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $seizoensgebondenProduct = new SeizoensgebondenProduct();
                $seizoensgebondenProduct->setProductId($row["product_id"]);
                $seizoensgebondenProduct->setSeizoenId($row["seizoen_id"]);

                $seizoensgebondenProducten[] = $seizoensgebondenProduct;
            }

            return $seizoensgebondenProducten;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching all seasonal products: " . $e->getMessage());
        }
    }

    public function getSeizoensgebondenProduct(int $productId, int $seizoenId): SeizoensgebondenProduct {
        try {
            $sql = "SELECT * FROM seizoensgebonden_producten WHERE product_id = :product_id AND seizoen_id = :seizoen_id";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam(":product_id", $productId, PDO::PARAM_INT);
            $stmt->bindParam(":seizoen_id", $seizoenId, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                throw new Exception("Seizoensgebonden product met product ID $productId en seizoen ID $seizoenId niet gevonden");
            }

            $seizoensgebondenProduct = new SeizoensgebondenProduct();
            $seizoensgebondenProduct->setProductId($row["product_id"]);
            $seizoensgebondenProduct->setSeizoenId($row["seizoen_id"]);

            return $seizoensgebondenProduct;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching seasonal product by product ID and season ID: " . $e->getMessage());
        }
    }
}
