<?php
declare(strict_types=1);
// Business/BestelregelService.php

namespace Business;

use Data\BestelregelDAO;
use Entities\Bestelregel;
use Exceptions\Exception;

class BestelregelService {
    private $bestelregelDAO;

    public function __construct() {
        $this->bestelregelDAO = new BestelregelDAO();
    }

    public function getAllBestelregels(): array {
        try {
            return $this->bestelregelDAO->getAllBestelregels();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van alle bestelregels.");
        }
    }

    public function getBestelregelsByBestellingId(int $bestellingId): array {
        try {
            return $this->bestelregelDAO->getBestelregelsByBestellingId($bestellingId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van bestelregels voor bestelling met ID $bestellingId.");
        }
    }

    public function createBestelregel(int $bestellingId, int $productId, int $aantal): void {
        try {
            $bestelregel = new Bestelregel();
            $bestelregel->setBestellingId($bestellingId);
            $bestelregel->setProductId($productId);
            $bestelregel->setAantal($aantal);

            $this->bestelregelDAO->insert($bestelregel);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het aanmaken van de bestelregel.");
        }
    }
}
