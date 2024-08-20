<?php
declare(strict_types=1);
//Business/SeizoenService.php
namespace Business;

use Data\SeizoenDAO;
use Entities\Seizoen;
use Exceptions\Exception;

class SeizoenService {
    private $seizoenDAO;

    public function __construct() {
        $this->seizoenDAO = new SeizoenDAO();
    }

    public function getAllSeizoenen(): array {
        try {
            return $this->seizoenDAO->getAllSeizoenen();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van alle seizoenen.");
        }
    }

    public function getSeizoenById(int $seizoenId): Seizoen {
        try {
            return $this->seizoenDAO->getSeizoenById($seizoenId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van seizoen met ID $seizoenId.");
        }
    }
}
