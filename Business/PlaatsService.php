<?php
declare(strict_types=1);

// Business/PlaatsService.php

namespace Business;

use Data\PlaatsDAO;
use Entities\Plaats;
use Exceptions\Exception;

class PlaatsService {
    private $plaatsDAO;

    public function __construct() {
        $this->plaatsDAO = new PlaatsDAO();
    }

    public function getAllPlaatsen(): array {
        try {
            return $this->plaatsDAO->getAllPlaatsen();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van alle plaatsen.");
        }
    }

    public function getPlaatsById(int $plaatsId): Plaats {
        try {
            return $this->plaatsDAO->getPlaatsById($plaatsId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van plaats met ID $plaatsId.");
        }
    }

    public function getPlaatsenByLeveringMogelijk(bool $leveringMogelijk): array {
        try {
            return $this->plaatsDAO->getPlaatsByLeveringMogelijk($leveringMogelijk);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van plaatsen met levering mogelijk.");
        }
    }
}
