<?php
// Data/ProductDAO.php

declare(strict_types=1);

namespace Data;

use \PDO;
use Entities\Product;
use Exceptions\Exception;

require_once __DIR__ . "/DBConfig.php";

class ProductDAO
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

    public function getAll(): array
    {
        try {
            $sql = "SELECT * FROM product";
            $stmt = $this->dbConn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($result as $row) {
                $product = new Product();
                $product->setProductId((int)$row['product_id']);
                $product->setNaam($row['naam']);
                $product->setPrijs((float)$row['prijs']);
                $product->setIngredienten($row['ingrediënten']);
                $product->setBeschikbaarheid((bool)$row['beschikbaarheid']); // Converteer naar bool
                $product->setPromotieprijs($row['promotieprijs'] !== null ? (float)$row['promotieprijs'] : null);
                $product->setSeizoensgebonden((int)$row['seizoensgebonden']);
                $products[] = $product;
            }

            return $products;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching all products: " . $e->getMessage());
        }
    }

    public function getById(int $productId): ?Product
    {
        try {
            $sql = "SELECT * FROM product WHERE product_id = ?";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute([$productId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $product = new Product();
                $product->setProductId((int)$row['product_id']);
                $product->setNaam($row['naam']);
                $product->setPrijs((float)$row['prijs']);
                $product->setIngredienten($row['ingrediënten']);
                $product->setBeschikbaarheid((bool)$row['beschikbaarheid']); // Converteer naar bool
                $product->setPromotieprijs($row['promotieprijs'] !== null ? (float)$row['promotieprijs'] : null);
                $product->setSeizoensgebonden((int)$row['seizoensgebonden']);
                return $product;
            }

            return null;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching product by ID: " . $e->getMessage());
        }
    }

    public function getByName(string $productName): ?Product
    {
        try {
            $sql = "SELECT * FROM product WHERE naam = ?";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute([$productName]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $product = new Product();
                $product->setProductId((int)$row['product_id']);
                $product->setNaam($row['naam']);
                $product->setPrijs((float)$row['prijs']);
                $product->setIngredienten($row['ingrediënten']);
                $product->setBeschikbaarheid((bool)$row['beschikbaarheid']); // Converteer naar bool
                $product->setPromotieprijs($row['promotieprijs'] !== null ? (float)$row['promotieprijs'] : null);
                $product->setSeizoensgebonden((int)$row['seizoensgebonden']);
                return $product;
            }

            return null;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching product by name: " . $e->getMessage());
        }
    }

    public function getByPromotie(): array
    {
        try {
            $sql = "SELECT * FROM product WHERE promotieprijs IS NOT NULL";
            $stmt = $this->dbConn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($result as $row) {
                $product = new Product();
                $product->setProductId((int)$row['product_id']);
                $product->setNaam($row['naam']);
                $product->setPrijs((float)$row['prijs']);
                $product->setIngredienten($row['ingrediënten']);
                $product->setBeschikbaarheid((bool)$row['beschikbaarheid']); // Converteer naar bool
                $product->setPromotieprijs((float)$row['promotieprijs']);
                $product->setSeizoensgebonden((int)$row['seizoensgebonden']);
                $products[] = $product;
            }

            return $products;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching products by promotion: " . $e->getMessage());
        }
    }

    public function getBySeizoensgebonden(): array
    {
        try {
            $sql = "SELECT * FROM product WHERE seizoensgebonden IS NOT NULL";
            $stmt = $this->dbConn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($result as $row) {
                $product = new Product();
                $product->setProductId((int)$row['product_id']);
                $product->setNaam($row['naam']);
                $product->setPrijs((float)$row['prijs']);
                $product->setIngredienten($row['ingrediënten']);
                $product->setBeschikbaarheid((bool)$row['beschikbaarheid']); // Converteer naar bool
                $product->setPromotieprijs($row['promotieprijs'] !== null ? (float)$row['promotieprijs'] : null);
                $product->setSeizoensgebonden((int)$row['seizoensgebonden']);
                $products[] = $product;
            }
            return $products;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching seasonal products: " . $e->getMessage());
        }
    }

    public function getByBeschikbaarheid(bool $beschikbaar): array
    {
        try {
            $sql = "SELECT * FROM product WHERE beschikbaarheid = ?";
            $stmt = $this->dbConn->prepare($sql);
            $stmt->execute([$beschikbaar]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($result as $row) {
                $product = new Product();
                $product->setProductId((int)$row['product_id']);
                $product->setNaam($row['naam']);
                $product->setPrijs((float)$row['prijs']);
                $product->setIngredienten($row['ingrediënten']);
                $product->setBeschikbaarheid((bool)$row['beschikbaarheid']); // Converteer naar bool
                $product->setPromotieprijs($row['promotieprijs'] !== null ? (float)$row['promotieprijs'] : null);
                $product->setSeizoensgebonden((int)$row['seizoensgebonden']);
                $products[] = $product;
            }

            return $products;
        } catch (\PDOException $e) {
            throw new Exception("Error fetching products by availability: " . $e->getMessage());
        }
    }
}
