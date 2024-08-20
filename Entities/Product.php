<?php
declare(strict_types=1);
// Entities/Product.php
namespace Entities;

class Product {
    private int $product_id;
    private string $naam;
    private float $prijs;
    private string $ingredienten;
    private bool $beschikbaarheid; // Verander naar bool
    private ?float $promotieprijs;
    private int $seizoensgebonden;

    public function getProductId(): int {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void {
        $this->product_id = $product_id;
    }

    public function getNaam(): string {
        return $this->naam;
    }

    public function setNaam(string $naam): void {
        $this->naam = $naam;
    }

    public function getPrijs(): float {
        return $this->prijs;
    }

    public function setPrijs(float $prijs): void {
        $this->prijs = $prijs;
    }

    public function getIngredienten(): string {
        return $this->ingredienten;
    }

    public function setIngredienten(string $ingredienten): void {
        $this->ingredienten = $ingredienten;
    }

    public function getBeschikbaarheid(): bool {
        return $this->beschikbaarheid;
    }

    public function setBeschikbaarheid(bool $beschikbaarheid): void {
        $this->beschikbaarheid = $beschikbaarheid;
    }

    public function getPromotieprijs(): ?float {
        return $this->promotieprijs;
    }

    public function setPromotieprijs(?float $promotieprijs): void {
        $this->promotieprijs = $promotieprijs;
    }

    public function getSeizoensgebonden(): int {
        return $this->seizoensgebonden;
    }

    public function setSeizoensgebonden(int $seizoensgebonden): void {
        $this->seizoensgebonden = $seizoensgebonden;
    }
}
