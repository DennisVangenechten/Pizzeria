<?php
declare(strict_types=1);
// Business/BestellingService.php

namespace Business;

use Data\BestellingDAO;
use Entities\Bestelling;
use Exceptions\Exception;

class BestellingService {
    private $bestellingDAO;

    public function __construct() {
        $this->bestellingDAO = new BestellingDAO();
    }

    public function getAllBestellingen(): array {
        try {
            return $this->bestellingDAO->getAllBestellingen();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van alle bestellingen.");
        }
    }

    public function getBestellingById(int $bestellingId): Bestelling {
        try {
            return $this->bestellingDAO->getBestellingById($bestellingId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van bestelling met ID $bestellingId.");
        }
    }

    public function createBestelling(int $klantId, string $bestellingDatum, int $plaatsId, string $status): int {
        try {
            $bestelling = new Bestelling();
            $bestelling->setKlantId($klantId);
            $bestelling->setBestellingDatum($bestellingDatum);
            $bestelling->setPlaatsId($plaatsId);
            $bestelling->setStatus($status);

            $bestellingId = $this->bestellingDAO->insert($bestelling);
            if (!$bestellingId) {
                throw new \Exception("Fout bij het toevoegen van de bestelling");
            }
            return $bestellingId;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het aanmaken van de bestelling.");
        }
    }

    public function updateBestelling(int $bestellingId, int $klantId, string $bestellingDatum, int $plaatsId, string $status): void {
        try {
            $bestelling = new Bestelling();
            $bestelling->setBestellingId($bestellingId);
            $bestelling->setKlantId($klantId);
            $bestelling->setBestellingDatum($bestellingDatum);
            $bestelling->setPlaatsId($plaatsId);
            $bestelling->setStatus($status);

            $this->bestellingDAO->updateBestelling($bestelling);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het bijwerken van bestelling met ID $bestellingId.");
        }
    }
}
