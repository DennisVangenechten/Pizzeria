<?php
declare(strict_types=1);
// Entities/Klant.php
namespace Entities;

class Klant {
    private int $klant_id;
    private string $voornaam;
    private string $naam;
    private string $straat;
    private string $huisnummer;
    private int $plaats_id;
    private string $telefoon;
    private ?string $promotie;
    private int $bestaande_gebruiker;
    private ?string $emailadres;
    private ?string $wachtwoord;

    public function getKlantId(): int {
        return $this->klant_id;
    }

    public function setKlantId(int $klant_id): void {
        $this->klant_id = $klant_id;
    }

    public function getVoornaam(): string {
        return $this->voornaam;
    }

    public function setVoornaam(string $voornaam): void {
        $this->voornaam = $voornaam;
    }

    public function getNaam(): string {
        return $this->naam;
    }

    public function setNaam(string $naam): void {
        $this->naam = $naam;
    }

    public function getStraat(): string {
        return $this->straat;
    }

    public function setStraat(string $straat): void {
        $this->straat = $straat;
    }

    public function getHuisnummer(): string {
        return $this->huisnummer;
    }

    public function setHuisnummer(string $huisnummer): void {
        $this->huisnummer = $huisnummer;
    }

    public function getPlaatsId(): int {
        return $this->plaats_id;
    }

    public function setPlaatsId(int $plaats_id): void {
        $this->plaats_id = $plaats_id;
    }

    public function getTelefoon(): string {
        return $this->telefoon;
    }

    public function setTelefoon(string $telefoon): void {
        $this->telefoon = $telefoon;
    }

    public function getPromotie(): ?string {
        return $this->promotie;
    }

    public function setPromotie(?string $promotie): void {
        $this->promotie = $promotie;
    }

    public function getBestaandeGebruiker(): int {
        return $this->bestaande_gebruiker;
    }

    public function setBestaandeGebruiker(int $bestaande_gebruiker): void {
        $this->bestaande_gebruiker = $bestaande_gebruiker;
    }

    public function getEmailadres(): ?string {
        return $this->emailadres;
    }

    public function setEmailadres(?string $emailadres): void {
        $this->emailadres = $emailadres;
    }

    public function getWachtwoord(): ?string {
        return $this->wachtwoord;
    }

    public function setWachtwoord(?string $wachtwoord): void {
        $this->wachtwoord = $wachtwoord;
    }
}
