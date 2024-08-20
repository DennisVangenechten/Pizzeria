<?php
declare(strict_types=1);
//Presentation/klantgegevens.php
namespace Presentation;

$error = ""
    ?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klantgegevens</title>
    <link rel="stylesheet" href="Presentation/style.css">
    <script src="Presentation/script.js" defer></script>
    <link rel="icon" href="Presentation/Images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <h1 class="Persoonlijkegegevens">Persoonlijke gegevens</h1>
    <div class="accountbestaat">
        <h2>Ik heb een account</h2>
        <form action="MainController.php?action=klantgegevens" method="POST">
            <label for="emailadres">E-mailadres:</label>
            <input type="email" id="emailadres" name="emailadres" required>
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" id="wachtwoord" name="wachtwoord" required>
            <button type="submit" name="login" value="1" class="btn3"><span class="spn3">Inloggen</span></button>
        </form>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="accountbestaatniet">
        <h2>Ik heb geen account</h2>
        <form id="klantForm" action="MainController.php?action=klantgegevens" method="POST" onsubmit="return validateForm()">
            <label for="voornaam">Voornaam:</label>
            <input type="text" id="voornaam" name="voornaam" required>
            <label for="naam">Achternaam:</label>
            <input type="text" id="naam" name="naam" required>
            <label for="straat">Adres:</label>
            <input type="text" id="straat" name="straat" required>
            <label for="huisnummer">Huisnummer:</label>
            <input type="text" id="huisnummer" name="huisnummer" required>
            <label for="plaats_id">Woontplaats:</label>
            <select id="plaats_id" name="plaats_id" required>
                <?php foreach ($plaatsen as $plaats): ?>
                    <option value="<?php echo $plaats->getPlaatsId(); ?>" data-levering-mogelijk="<?php echo $plaats->getLeveringMogelijk() ? '1' : '0'; ?>">
                        <?php echo $plaats->getPostcode() . ' - ' . $plaats->getWoonplaats(); ?>
                        <?php if (!$plaats->getLeveringMogelijk()): ?>
                            (Levering niet mogelijk)
                        <?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="telefoon">Telefoonnummer:</label>
            <input type="text" id="telefoon" name="telefoon" required>
            <div class="checkbox-container">
                <input type="checkbox" id="createAccount" name="createAccount">
                <label for="createAccount">Maak een account aan</label>
            </div>
            <div id="accountDetails" style="display: none;">
                <label for="emailadres">E-mailadres:</label>
                <input type="email" id="accountEmail" name="emailadres">
                <label for="wachtwoord">Wachtwoord:</label>
                <input type="password" id="accountPassword" name="wachtwoord">
            </div>
            <input type="hidden" name="updateKlantgegevens" value="1"> <!-- Verborgen inputveld toegevoegd -->
            <button type="submit" class="btn3"><span class="spn3">Doorgaan</span></button>
        </form>
    </div>
</body>

</html>
