<?php
declare(strict_types=1);
//Entities/SeizoensgebondenProduct.php
namespace Entities;

class SeizoensgebondenProduct {
    private int $product_id;
    private int $seizoen_id;


    public function getProductId(): int {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void {
        $this->product_id = $product_id;
    }

    public function getSeizoenId(): int {
        return $this->seizoen_id;
    }

    public function setSeizoenId(int $seizoen_id): void {
        $this->seizoen_id = $seizoen_id;
    }
}
