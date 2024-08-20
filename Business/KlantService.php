<?php
declare(strict_types=1);

// Business/KlantService.php

namespace Business;

use Data\KlantDAO;
use Entities\Klant;
use Exceptions\Exception;

class KlantService
{
    private $klantDAO;

    public function __construct()
    {
        $this->klantDAO = new KlantDAO();
    }

    public function getAllKlanten()
    {
        try {
            return $this->klantDAO->getAll();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van alle klanten.");
        }
    }

    public function getKlantById($id)
    {
        try {
            return $this->klantDAO->getById($id);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van klant met ID $id.");
        }
    }

    public function getKlantByEmail($email)
    {
        try {
            return $this->klantDAO->getByEmail($email);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van klant met email $email.");
        }
    }

    public function addKlant(
        string $voornaam,
        string $naam,
        string $straat,
        string $huisnummer,
        int $plaatsId,
        string $telefoon,
        ?string $promotie,
        int $bestaandeGebruiker,
        ?string $emailadres,
        ?string $wachtwoord
    ): int {
        try {
            $klant = new Klant();
            $klant->setVoornaam($voornaam);
            $klant->setNaam($naam);
            $klant->setStraat($straat);
            $klant->setHuisnummer($huisnummer);
            $klant->setPlaatsId($plaatsId);
            $klant->setTelefoon($telefoon);
            $klant->setPromotie($promotie);
            $klant->setBestaandeGebruiker($bestaandeGebruiker);
            $klant->setEmailadres($emailadres);

            // Encrypt het wachtwoord alleen als het niet null is
            if ($wachtwoord !== null && $wachtwoord !== '') {
                $encryptedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);
                $klant->setWachtwoord($encryptedPassword);
            } else {
                $klant->setWachtwoord(null);
            }

            return $this->klantDAO->insert($klant);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het toevoegen van klant.");
        }
    }

    public function updateKlant($id, $voornaam, $naam, $straat, $huisnummer, $plaatsId, $telefoon, $promotie, $bestaandeGebruiker, $emailadres, $wachtwoord)
    {
        try {
            $klant = $this->klantDAO->getById($id);
            if ($klant) {
                $klant->setVoornaam($voornaam);
                $klant->setNaam($naam);
                $klant->setStraat($straat);
                $klant->setHuisnummer($huisnummer);
                $klant->setPlaatsId($plaatsId);
                $klant->setTelefoon($telefoon);
                $klant->setPromotie($promotie);
                $klant->setBestaandeGebruiker($bestaandeGebruiker);
                $klant->setEmailadres($emailadres);
                $klant->setWachtwoord($wachtwoord);
                $this->klantDAO->update($klant);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het bijwerken van klant met ID $id.");
        }
    }

    public function deleteKlant($id)
    {
        try {
            $this->klantDAO->delete($id);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het verwijderen van klant met ID $id.");
        }
    }

    public function authenticate($emailadres, $wachtwoord): ?Klant {
        try {
            $klant = $this->klantDAO->getByEmail($emailadres);
            if ($klant && password_verify($wachtwoord, $klant->getWachtwoord())) {
                return $klant;
            }
            throw new Exception("Ongeldig e-mailadres of wachtwoord.");
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw $e; 
        }
    }

    public function getByEmail($emailadres)
    {
        try {
            return $this->klantDAO->getByEmail($emailadres);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception("Fout bij het ophalen van klant met email $emailadres.");
        }
    }
}
