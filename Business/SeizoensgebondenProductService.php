<?php
declare(strict_types=1);
//Business/SeizoensgebondenProductService.php
namespace Business;

use Data\SeizoensgebondenProductDAO;
use Entities\SeizoensgebondenProduct;
use Exceptions\Exception;

class SeizoensgebondenProductService {
    private $seizoensgebondenProductDAO;

    public function __construct() {
        $this->seizoensgebondenProductDAO = new SeizoensgebondenProductDAO();
    }

    public function getAllSeizoensgebondenProducten(): array {
        try {
            return $this->seizoensgebondenProductDAO->getAllSeizoensgebondenProducten();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van alle seizoensgebonden producten.");
        }
    }

    public function getSeizoensgebondenProduct(int $productId, int $seizoenId): SeizoensgebondenProduct {
        try {
            return $this->seizoensgebondenProductDAO->getSeizoensgebondenProduct($productId, $seizoenId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van seizoensgebonden product met product ID $productId en seizoen ID $seizoenId.");
        }
    }
}
