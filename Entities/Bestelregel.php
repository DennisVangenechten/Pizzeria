<?php
declare(strict_types=1);
// Entities/Bestelregel.php
namespace Entities;

class Bestelregel {
    private int $bestelling_id;
    private int $product_id;
    private int $aantal;

    public function getBestellingId(): int {
        return $this->bestelling_id;
    }

    public function setBestellingId(int $bestelling_id): void {
        $this->bestelling_id = $bestelling_id;
    }

    public function getProductId(): int {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void {
        $this->product_id = $product_id;
    }

    public function getAantal(): int {
        return $this->aantal;
    }

    public function setAantal(int $aantal): void {
        $this->aantal = $aantal;
    }
}
