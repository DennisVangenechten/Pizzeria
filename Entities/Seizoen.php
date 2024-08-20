<?php
declare(strict_types=1);
//Entities/Seizoen.php
namespace Entities;

class Seizoen {
    private int $seizoen_id;
    private string $naam;
    private string $start_datum;
    private string $tot_datum;

    public function getSeizoenId(): int {
        return $this->seizoen_id;
    }

    public function setSeizoenId(int $seizoen_id): void {
        $this->seizoen_id = $seizoen_id;
    }

    public function getNaam(): string {
        return $this->naam;
    }

    public function setNaam(string $naam): void {
        $this->naam = $naam;
    }

    public function getStartDatum(): string {
        return $this->start_datum;
    }

    public function setStartDatum(string $start_datum): void {
        $this->start_datum = $start_datum;
    }

    public function getTotDatum(): string {
        return $this->tot_datum;
    }

    public function setTotDatum(string $tot_datum): void {
        $this->tot_datum = $tot_datum;
    }
}

