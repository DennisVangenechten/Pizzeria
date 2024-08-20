<?php
declare(strict_types=1);
// Presentation/besteloverzicht.php
namespace Presentation;

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Besteloverzicht</title>
    <script src="Presentation/script.js" defer></script>
    <link rel="stylesheet" href="Presentation/style.css">
    <link rel="icon" href="Presentation/Images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700&display=swap" rel="stylesheet">
</head>

<body>

    <h1 class="Persoonlijkegegevens">Besteloverzicht</h1>

    <div class="winkelmandje">
        <h2>Winkelmandje</h2>
        <form method="POST" action="MainController.php?action=besteloverzicht&updateCart=1">
            <ul>
                <?php
                $totalPrice = 0;
                foreach ($cartItems as $index => $item):
                    $totalItemPrice = $item['price'] * $item['quantity'];
                    $totalPrice += $totalItemPrice;
                    ?>
                    <li>
                        <?php echo htmlspecialchars($item['name']); ?> - €<?php echo number_format($totalItemPrice, 2); ?> (<?php echo $item['quantity']; ?> stuks)
                        <input type="number" name="quantities[<?php echo $index; ?>]" value="<?php echo $item['quantity']; ?>" min="0">
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>Totaal: €<?php echo number_format($totalPrice, 2); ?></p>
            <button type="submit" name="updateCart" class="btn3"><span class="spn3">Winkelmandje bijwerken</span></button>
        </form>
    </div>

    <div class="klantgegevens-container">
        <h2>Klantgegevens</h2>
        <form id="klantForm" method="POST" action="MainController.php?action=besteloverzicht&updateKlantgegevens=1" onsubmit="return validateForm()">
            <label for="voornaam">Voornaam:</label>
            <input type="text" id="voornaam" name="voornaam" value="<?php echo htmlspecialchars($klantgegevens['voornaam']); ?>" required>

            <label for="naam">Achternaam:</label>
            <input type="text" id="naam" name="naam" value="<?php echo htmlspecialchars($klantgegevens['naam']); ?>" required>

            <label for="straat">Adres:</label>
            <input type="text" id="straat" name="straat" value="<?php echo htmlspecialchars($klantgegevens['straat']); ?>" required>

            <label for="huisnummer">Huisnummer:</label>
            <input type="text" id="huisnummer" name="huisnummer" value="<?php echo htmlspecialchars($klantgegevens['huisnummer']); ?>" required>

            <label for="plaats_id">Postcode:</label>
            <select id="plaats_id" name="plaats_id" required>
                <?php foreach ($plaatsen as $plaats): ?>
                    <option value="<?php echo $plaats->getPlaatsId(); ?>" data-levering-mogelijk="<?php echo $plaats->getLeveringMogelijk() ? '1' : '0'; ?>" <?php echo $plaats->getPlaatsId() == $klantgegevens['plaats_id'] ? 'selected' : ''; ?>>
                        <?php echo $plaats->getPostcode() . ' - ' . $plaats->getWoonplaats(); ?>
                        <?php if (!$plaats->getLeveringMogelijk()): ?>
                            (Levering niet mogelijk)
                        <?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="telefoon">Telefoonnummer:</label>
            <input type="text" id="telefoon" name="telefoon" value="<?php echo htmlspecialchars($klantgegevens['telefoon']); ?>" required>

            <button type="submit" name="updateKlantgegevens" class="btn3"><span class="spn3">Update</span></button>
        </form>
    </div>

    <div class="center-button-container">
        <form method="POST" action="MainController.php?action=bevestiging" onsubmit="return validateForm()">
            <button type="submit" name="bevestigBestelling" class="btn3"><span class="spn3">Bevestig Bestelling</span></button>
        </form>
    </div>
</body>

</html>
