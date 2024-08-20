<?php
declare(strict_types=1);
//Entities/Plaats.php
namespace Entities;

class Plaats {
    private int $plaats_id;
    private string $postcode;
    private string $woonplaats;
    private bool $levering_mogelijk;

    public function getPlaatsId(): int {
        return $this->plaats_id;
    }

    public function setPlaatsId(int $plaats_id): void {
        $this->plaats_id = $plaats_id;
    }

    public function getPostcode(): string {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): void {
        $this->postcode = $postcode;
    }

    public function getWoonplaats(): string {
        return $this->woonplaats;
    }

    public function setWoonplaats(string $woonplaats): void {
        $this->woonplaats = $woonplaats;
    }

    public function getLeveringMogelijk(): bool {
        return $this->levering_mogelijk;
    }

    public function setLeveringMogelijk(bool $levering_mogelijk): void {
        $this->levering_mogelijk = $levering_mogelijk;
    }
}
