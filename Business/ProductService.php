<?php
declare(strict_types=1);

// Business/ProductService.php

namespace Business;

use Data\ProductDAO;
use Exceptions\Exception;

class ProductService {
    private $productDAO;

    public function __construct() {
        $this->productDAO = new ProductDAO();
    }

    public function getAllProducts() {
        try {
            return $this->productDAO->getAll();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van alle producten.");
        }
    }

    public function getProductById($productId) {
        try {
            return $this->productDAO->getById($productId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van product met ID $productId.");
        }
    }

    public function getProductByName($productName) {
        try {
            return $this->productDAO->getByName($productName);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van product met naam $productName.");
        }
    }

    public function getProductsByBeschikbaarheid($beschikbaar) {
        try {
            return $this->productDAO->getByBeschikbaarheid($beschikbaar);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van producten met beschikbaarheid $beschikbaar.");
        }
    }
}
