<?php
declare(strict_types=1);
// Entities/Bestelling.php
namespace Entities;

class Bestelling {
    private int $bestelling_id;
    private int $klant_id;
    private string $bestellingdatum;
    private int $plaats_id;
    private string $status;

    public function getBestellingId(): int {
        return $this->bestelling_id;
    }

    public function setBestellingId(int $bestelling_id): void {
        $this->bestelling_id = $bestelling_id;
    }

    public function getKlantId(): int {
        return $this->klant_id;
    }

    public function setKlantId(int $klant_id): void {
        $this->klant_id = $klant_id;
    }

    public function getBestellingDatum(): string {
        return $this->bestellingdatum;
    }

    public function setBestellingDatum(string $bestellingdatum): void {
        $this->bestellingdatum = $bestellingdatum;
    }

    public function getPlaatsId(): int {
        return $this->plaats_id;
    }

    public function setPlaatsId(int $plaats_id): void {
        $this->plaats_id = $plaats_id;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }
}
