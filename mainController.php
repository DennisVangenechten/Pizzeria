<?php
// MainController.php
declare(strict_types=1);

spl_autoload_register();

use Business\KlantService;
use Business\PlaatsService;
use Business\ProductService;
use Business\BestellingService;
use Business\BestelregelService;
use Business\SeizoensgebondenProductService;
use Business\SeizoenService;
use Exceptions\Exception;

session_start();

$action = $_GET['action'] ?? 'index';

try {
    switch ($action) {
        case 'index':
            handleIndex();
            break;
        case 'bestel':
            handleBestel();
            break;
        case 'klantgegevens':
            handleKlantgegevens();
            break;
        case 'login':
            handleLogin();
            break;
        case 'verwerkKlantgegevens':
            handleVerwerkKlantgegevens();
            break;
        case 'besteloverzicht':
            handleBesteloverzicht();
            break;
        case 'bevestiging':
            handleBevestiging();
            break;
        case 'toonBevestiging':
            handleToonBevestiging();
            break;
        case 'logout':
            handleLogout();
            break;
        case 'error':
            handleError();
            break;
        default:
            handleIndex();
    }
} catch (Exception $e) {
    // Bewaar de foutmelding in de sessie en stuur de gebruiker naar een foutpagina
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: MainController.php?action=error');
    exit();
}

function handleError() {
    $errorMessage = $_SESSION['error_message'] ?? 'Er is een fout opgetreden.';
    unset($_SESSION['error_message']); // Verwijder de foutmelding uit de sessie na weergave
    include('Presentation/error.php');
}

function handleIndex()
{
    include ("Presentation/homepage.php");
    includeFooter();
}

function handleBestel()
{
    $productService = new ProductService();
    $seizoensgebondenProductService = new SeizoensgebondenProductService();
    $seizoenService = new SeizoenService();

    $pizzas = $productService->getAllProducts();
    $currentDate = new \DateTime();

    // Controleer of er al een winkelmandje in de sessie is, zo niet, maak er een aan
    if (!isset($_SESSION['cartItems'])) {
        $_SESSION['cartItems'] = [];
    }

    // Laad de gegevens van het winkelmandje
    $cartItems = $_SESSION['cartItems'];

    // Als het formulier is ingediend, verwerk de invoer
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Voeg het geselecteerde product toe aan het winkelmandje
        if (isset($_POST['addToCart']) && isset($_POST['productId']) && isset($_POST['productName']) && isset($_POST['productPrice'])) {
            $productId = (int) $_POST['productId']; // Converteer naar int
            $productName = $_POST['productName'];
            $productPrice = (float) $_POST['productPrice']; // Converteer naar float

            // Voeg het product toe aan het winkelmandje
            if (!isset($_SESSION['cartItems'][$productId])) {
                $_SESSION['cartItems'][$productId] = [
                    'product_id' => $productId, // Voeg product_id toe aan het item
                    'name' => $productName,
                    'price' => $productPrice,
                    'quantity' => 1
                ];
            } else {
                $_SESSION['cartItems'][$productId]['quantity'] += 1;
            }
        }

        // Werk het winkelmandje bij
        if (isset($_POST['updateCart']) && isset($_POST['quantities']) && is_array($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $productId => $quantity) {
                if ($quantity == 0) {
                    unset($_SESSION['cartItems'][$productId]);
                } else {
                    $_SESSION['cartItems'][$productId]['quantity'] = (int) $quantity;
                }
            }
        }
    }

    include ("Presentation/bestel.php");
    includeFooter();
}


function handleKlantgegevens()
{
    // Controleer of de gebruiker ingelogd is
    $isLoggedIn = isset($_SESSION['user_id']);

    // Als de gebruiker ingelogd is, stuur ze door naar het besteloverzicht
    if ($isLoggedIn) {
        header('Location: MainController.php?action=besteloverzicht');
        exit();
    }

    // Laad de gegevens van het winkelmandje
    $cartItems = $_SESSION['cartItems'] ?? [];

    // Converteer de prijzen naar floats
    foreach ($cartItems as &$item) {
        if (!is_float($item['price'])) {
            $item['price'] = (float) $item['price'];
        }
    }

    // Controleer of het winkelmandje leeg is
    if (empty($cartItems)) {
        // Stuur de gebruiker terug naar de bestelpagina als het winkelmandje leeg is
        header('Location: MainController.php?action=bestel');
        exit();
    }

    // Laad de plaatsen voor het formulier
    $plaatsService = new PlaatsService();
    $plaatsen = $plaatsService->getAllPlaatsen();

    // Sorteer de plaatsen op postcode
    usort($plaatsen, function ($a, $b) {
        return $a->getPostcode() <=> $b->getPostcode();
    });

    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $klantService = new KlantService();

        // Verwerk het inloggen
        if (isset($_POST['login'])) {
            $emailadres = $_POST['emailadres'];
            $wachtwoord = $_POST['wachtwoord'];

            try {
                $klant = $klantService->authenticate($emailadres, $wachtwoord);
                if ($klant) {
                    // Sla de klantgegevens op in de sessie
                    $_SESSION['user_id'] = $klant->getKlantId();
                    $_SESSION['klantgegevens'] = [
                        'voornaam' => $klant->getVoornaam(),
                        'naam' => $klant->getNaam(),
                        'straat' => $klant->getStraat(),
                        'huisnummer' => $klant->getHuisnummer(),
                        'plaats_id' => $klant->getPlaatsId(),
                        'telefoon' => $klant->getTelefoon(),
                        'promotie' => $klant->getPromotie(),
                        'bestaande_gebruiker' => $klant->getBestaandeGebruiker(),
                        'emailadres' => $klant->getEmailadres(),
                        'wachtwoord' => $klant->getWachtwoord()
                    ];

                    // Laad het winkelmandje opnieuw in de sessie
                    $_SESSION['cartItems'] = $cartItems;

                    // Stuur de gebruiker door naar de besteloverzicht pagina
                    header('Location: MainController.php?action=besteloverzicht');
                    exit();
                }
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
                $_SESSION['errors'] = $errors;
                header('Location: MainController.php?action=klantgegevens');
                exit();
            }
        }

        // Verwerk het aanmaken of bijwerken van een klant
        if (isset($_POST['updateKlantgegevens'])) {
            // Controleer of de klant al bestaat op basis van e-mailadres
            $klant = null;
            if (isset($_POST['emailadres'])) {
                $klant = $klantService->getByEmail($_POST['emailadres']);
            }

            if ($klant) {
                // Update de bestaande klantgegevens
                $klantId = $klant->getKlantId();
                $klantService->updateKlant(
                    $klantId,
                    $_POST['voornaam'],
                    $_POST['naam'],
                    $_POST['straat'],
                    $_POST['huisnummer'],
                    (int) $_POST['plaats_id'],
                    $_POST['telefoon'],
                    null,
                    isset($_POST['createAccount']) ? 1 : 0,
                    $_POST['emailadres'],
                    $_POST['wachtwoord']
                );
            } else {
                // Voeg de klant toe met behulp van de KlantService en verkrijg het klantId
                $klantId = $klantService->addKlant(
                    $_POST['voornaam'],
                    $_POST['naam'],
                    $_POST['straat'],
                    $_POST['huisnummer'],
                    (int) $_POST['plaats_id'],
                    $_POST['telefoon'],
                    null,
                    isset($_POST['createAccount']) ? 1 : 0,
                    $_POST['emailadres'] ?? null,
                    $_POST['wachtwoord'] ?? null
                );
            }

            // Update klantgegevens in de sessie
            $_SESSION['user_id'] = $klantId;
            $_SESSION['klantgegevens'] = [
                'voornaam' => $_POST['voornaam'],
                'naam' => $_POST['naam'],
                'straat' => $_POST['straat'],
                'huisnummer' => $_POST['huisnummer'],
                'plaats_id' => (int) $_POST['plaats_id'],
                'telefoon' => $_POST['telefoon'],
                'promotie' => null,
                'bestaande_gebruiker' => isset($_POST['createAccount']) ? 1 : 0,
                'emailadres' => $_POST['emailadres'] ?? null,
                'wachtwoord' => $_POST['wachtwoord'] ?? null
            ];

            // Stuur de gebruiker door naar de besteloverzicht pagina
            header('Location: MainController.php?action=besteloverzicht');
            exit();
        }
    }

    include ("Presentation/klantgegevens.php");
}

function handleLogin()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $emailadres = $_POST['emailadres'] ?? '';
        $wachtwoord = $_POST['wachtwoord'] ?? '';

        $klantService = new KlantService();
        $klant = $klantService->authenticate($emailadres, $wachtwoord);

        if ($klant) {
            // Sla de klantgegevens op in de sessie
            $_SESSION['user_id'] = $klant->getKlantId();
            $_SESSION['klantgegevens'] = [
                'voornaam' => $klant->getVoornaam(),
                'naam' => $klant->getNaam(),
                'straat' => $klant->getStraat(),
                'huisnummer' => $klant->getHuisnummer(),
                'plaats_id' => $klant->getPlaatsId(),
                'telefoon' => $klant->getTelefoon(),
                'promotie' => $klant->getPromotie(),
                'bestaande_gebruiker' => $klant->getBestaandeGebruiker(),
                'emailadres' => $klant->getEmailadres(),
                'wachtwoord' => $klant->getWachtwoord()
            ];

            // Laad het winkelmandje opnieuw in de sessie
            $_SESSION['cartItems'] = $_SESSION['cartItems'] ?? [];

            // Stuur de gebruiker door naar de vorige pagina
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $errors[] = "Ongeldig e-mailadres of wachtwoord.";
            $_SESSION['errors'] = $errors;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}

function handleVerwerkKlantgegevens()
{
    // Laad de gegevens van het winkelmandje
    $cartItems = $_SESSION['cartItems'] ?? [];

    // Controleer of het winkelmandje leeg is
    if (empty($cartItems)) {
        // Stuur de gebruiker terug naar de bestelpagina als het winkelmandje leeg is
        header('Location: MainController.php?action=bestel');
        exit();
    }

    // Als het formulier is ingediend, verwerk de gegevens
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Valideer verplichte velden
        $errors = [];
        $requiredFields = ['voornaam', 'naam', 'straat', 'huisnummer', 'plaats_id', 'telefoon'];

        // Voeg emailadres en wachtwoord toe aan vereiste velden als createAccount is aangevinkt
        if (isset($_POST['createAccount']) && $_POST['createAccount'] == 'on') {
            $requiredFields[] = 'emailadres';
            $requiredFields[] = 'wachtwoord';
        }

        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "Het veld {$field} is verplicht.";
            }
        }

        // Controleer of de plaats_id geldig is
        $plaatsService = new PlaatsService();
        $plaatsen = $plaatsService->getAllPlaatsen();
        $plaatsIds = array_map(fn($plaats) => $plaats->getPlaatsId(), $plaatsen);
        if (!in_array($_POST['plaats_id'], $plaatsIds)) {
            $errors[] = "De geselecteerde plaats is ongeldig.";
        }

        // Als er geen fouten zijn, sla de klantgegevens op in de sessie
        if (empty($errors)) {
            $klantService = new KlantService();

            // Controleer of de klant al bestaat op basis van e-mailadres
            $klant = null;
            if (isset($_POST['emailadres'])) {
                $klant = $klantService->getByEmail($_POST['emailadres']);
            }

            if ($klant) {
                // Als de klant al bestaat, gebruik het bestaande klant_id
                $klantId = $klant->getKlantId();
            } else {
                // Voeg de klant toe met behulp van de KlantService en verkrijg het klantId
                $klantId = $klantService->addKlant(
                    $_POST["voornaam"],
                    $_POST["naam"],
                    $_POST["straat"],
                    $_POST["huisnummer"],
                    (int) $_POST["plaats_id"],
                    $_POST["telefoon"],
                    null,
                    isset($_POST["createAccount"]) && $_POST["createAccount"] == 'on' ? 1 : 0,
                    $_POST["emailadres"] ?? null,
                    $_POST["wachtwoord"] ?? null
                );
            }

            // Sla de klant ID en klantgegevens op in de sessie
            $_SESSION['user_id'] = $klantId;
            $_SESSION['klantgegevens'] = [
                'voornaam' => $_POST["voornaam"],
                'naam' => $_POST["naam"],
                'straat' => $_POST["straat"],
                'huisnummer' => $_POST["huisnummer"],
                'plaats_id' => (int) $_POST["plaats_id"], // Type cast naar integer
                'telefoon' => $_POST["telefoon"],
                'promotie' => null,
                'bestaande_gebruiker' => isset($_POST["createAccount"]) && $_POST["createAccount"] == 'on' ? 1 : 0,
                'emailadres' => $_POST["emailadres"] ?? null,
                'wachtwoord' => $_POST["wachtwoord"] ?? null
            ];

            // Stuur de gebruiker door naar de bestelOverzichtController
            header("Location: MainController.php?action=besteloverzicht");
            exit();
        } else {
            // Bewaar de foutmeldingen in de sessie en stuur de gebruiker terug naar het klantgegevensformulier
            $_SESSION['errors'] = $errors;
            header("Location: MainController.php?action=klantgegevens");
            exit();
        }
    }
}


function handleBesteloverzicht()
{
    // Controleer of de gebruiker ingelogd is
    $isLoggedIn = isset($_SESSION['user_id']);

    // Laad de gegevens van het winkelmandje
    $cartItems = $_SESSION['cartItems'] ?? [];

    // Controleer of het winkelmandje leeg is
    if (empty($cartItems)) {
        // Stuur de gebruiker terug naar de bestelpagina als het winkelmandje leeg is
        header('Location: MainController.php?action=bestel');
        exit();
    }

    // Laad de klantgegevens uit de sessie
    $klantgegevens = $_SESSION['klantgegevens'] ?? null;

    $plaatsService = new PlaatsService();
    $plaatsen = $plaatsService->getAllPlaatsen();

    // Als het formulier voor het bijwerken van het winkelmandje is ingediend
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['updateCart'])) {
            // Update het winkelmandje in de sessie
            foreach ($_POST['quantities'] as $index => $quantity) {
                if ($quantity == 0) {
                    unset($cartItems[$index]);
                } else {
                    $cartItems[$index]['quantity'] = (int) $quantity;
                }
            }
            $_SESSION['cartItems'] = array_values($cartItems); // Herindexeer de array

            // Stuur de gebruiker terug naar de besteloverzicht pagina
            header('Location: MainController.php?action=besteloverzicht');
            exit();
        }

        if (isset($_POST['updateKlantgegevens'])) {
            // Update klantgegevens in de sessie
            $_SESSION['klantgegevens'] = [
                'voornaam' => $_POST['voornaam'],
                'naam' => $_POST['naam'],
                'straat' => $_POST['straat'],
                'huisnummer' => $_POST['huisnummer'],
                'plaats_id' => (int) $_POST['plaats_id'], // Converteer naar int
                'telefoon' => $_POST['telefoon'],
                'promotie' => $klantgegevens['promotie'] ?? null, // Zorg ervoor dat de bestaande waarde behouden blijft
                'bestaande_gebruiker' => $klantgegevens['bestaande_gebruiker'],
                'emailadres' => $klantgegevens['emailadres'],
                'wachtwoord' => $klantgegevens['wachtwoord']
            ];

            // Update klantgegevens in de database
            $klantService = new KlantService();
            $klantService->updateKlant(
                $_SESSION['user_id'],
                $_POST['voornaam'],
                $_POST['naam'],
                $_POST['straat'],
                $_POST['huisnummer'],
                (int) $_POST['plaats_id'],
                $_POST['telefoon'],
                $klantgegevens['promotie'] ?? null,
                $klantgegevens['bestaande_gebruiker'],
                $klantgegevens['emailadres'],
                $klantgegevens['wachtwoord']
            );

            // Stuur de gebruiker terug naar de besteloverzicht pagina
            header('Location: MainController.php?action=besteloverzicht');
            exit();
        }

        if (isset($_POST['bevestigBestelling'])) {
            // Controleer of de klantgegevens aanwezig zijn
            if ($klantgegevens) {
                // Sla klantgegevens op in de sessie voor gebruik in BevestigingsPaginaController
                $_SESSION['klantgegevens'] = $klantgegevens;

                // Stuur de gebruiker door naar de BevestigingsPaginaController
                header("Location: MainController.php?action=bevestiging");
                exit();
            } else {
                // Als de klantgegevens niet aanwezig zijn, stuur de gebruiker terug naar het klantgegevensformulier
                header("Location: MainController.php?action=klantgegevens");
                exit();
            }
        }
    }

    // Laad het besteloverzicht (HTML) inclusief een formulier om de bestelling te bevestigen
    include ("Presentation/besteloverzicht.php");
}

function handleBevestiging()
{
    // Controleer of de gebruiker ingelogd is
    $isLoggedIn = isset($_SESSION['user_id']);

    // Laad de gegevens van het winkelmandje en klantgegevens
    $cartItems = $_SESSION['cartItems'] ?? [];
    $klantgegevens = $_SESSION['klantgegevens'] ?? null;

    // Controleer of het winkelmandje leeg is of klantgegevens ontbreken
    if (empty($cartItems) || !$klantgegevens) {
        // Stuur de gebruiker terug naar de bestelpagina als het winkelmandje leeg is of klantgegevens ontbreken
        error_log("Winkelmandje is leeg of klantgegevens ontbreken");
        header('Location: MainController.php?action=bestel');
        exit();
    }

    try {
        // Maak een nieuw PlaatsService object aan om de woonplaats op te halen
        $plaatsService = new PlaatsService();
        $plaats = $plaatsService->getPlaatsById((int) $klantgegevens['plaats_id']);
        $woonplaats = $plaats->getWoonplaats();

        // Maak een nieuw KlantService object aan
        $klantService = new KlantService();

        // Controleer of de klant al bestaat op basis van e-mailadres
        $klant = $klantService->getByEmail($klantgegevens['emailadres']);

        if (!$klant) {
            // Voeg de klant toe met behulp van de KlantService en verkrijg het klantId
            $klantId = $klantService->addKlant(
                $klantgegevens['voornaam'],
                $klantgegevens['naam'],
                $klantgegevens['straat'],
                $klantgegevens['huisnummer'],
                (int) $klantgegevens['plaats_id'],
                $klantgegevens['telefoon'],
                $klantgegevens['promotie'],
                $klantgegevens['bestaande_gebruiker'],
                $klantgegevens['emailadres'],
                $klantgegevens['wachtwoord']
            );
            error_log("Klant toegevoegd met ID: $klantId");
        } else {
            // Gebruik het bestaande klantId
            $klantId = $klant->getKlantId();
        }

        // Maak een nieuw BestellingService object aan
        $bestellingService = new BestellingService();

        // Voeg de bestelling toe met behulp van de BestellingService en verkrijg het bestellingId
        $bestellingId = $bestellingService->createBestelling(
            $klantId,
            date("Y-m-d H:i:s"),
            (int) $klantgegevens['plaats_id'],
            'in behandeling'
        );
        error_log("Bestelling toegevoegd met ID: $bestellingId");

        // Maak een nieuw BestelregelService object aan
        $bestelregelService = new BestelregelService();

        // Voeg elke bestelregel toe met behulp van de BestelregelService
        foreach ($cartItems as $item) {
            $bestelregelService->createBestelregel($bestellingId, $item['product_id'], $item['quantity']);
            error_log("Bestelregel toegevoegd voor product ID: {$item['product_id']} met aantal: {$item['quantity']}");
        }

        // Voeg de woonplaats toe aan de klantgegevens voor weergave
        $klantgegevens['woonplaats'] = $woonplaats;

        // Verwijder klantgegevens en winkelmandje uit de sessie na succesvolle opslag
        unset($_SESSION['cartItems']);

        // Controleer of er geen account is aangemaakt, wis dan de klantgegevens uit de sessie
        if (!$klantgegevens['bestaande_gebruiker']) {
            unset($_SESSION['klantgegevens']);
            unset($_SESSION['user_id']);
        }

        // Stuur de klantgegevens en het winkelmandje door naar de bevestigingspagina
        include ("Presentation/bevestiging.php");
        exit();
    } catch (Exception $e) {
        // Log de fout en stuur de gebruiker terug naar de besteloverzichtspagina
        error_log("Fout bij het verwerken van de bestelling: " . $e->getMessage());
        header("Location: MainController.php?action=besteloverzicht");
        exit();
    }
}



function handleToonBevestiging()
{
    $bestelling = $_SESSION['bestelling'] ?? null;

    if (!$bestelling) {
        // Als er geen bestelling is, stuur de gebruiker terug naar de bestelpagina
        header('Location: MainController.php?action=bestel');
        exit();
    }

    // Laad de bevestigingspagina
    include ("Presentation/bevestiging.php");
}


function handleLogout()
{
    // Verwijder alle sessiegegevens
    session_unset();
    session_destroy();

    // Stuur de gebruiker terug naar de homepage
    header('Location: MainController.php?action=index');
    exit();
}

function includeFooter()
{
    $isLoggedIn = isset($_SESSION['user_id']);
    if ($isLoggedIn) {
        include ("Presentation/footer_loggedin.php");
    } else {
        include ("Presentation/footer_loggedout.php");
    }
}
