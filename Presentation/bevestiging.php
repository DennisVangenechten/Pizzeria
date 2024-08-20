<?php
declare(strict_types=1);
//Presentation/bevestiging.php
namespace Presentation;


?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestel</title>
    <link rel="stylesheet" href="Presentation/style.css">
    <link rel="icon" href="Presentation/Images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="content-wrap klantgegevens-container">
        <h1>Bestelling Bevestiging</h1>
        <div class="bestelling-details">
            <h2>Uw Bestelling</h2>
            <ul>
                <?php
                $totalPrice = 0;
                foreach ($cartItems as $item):
                    $totalItemPrice = $item['price'] * $item['quantity'];
                    $totalPrice += $totalItemPrice;
                    ?>
                    <li><?php echo htmlspecialchars($item['name']); ?> - €<?php echo number_format($totalItemPrice, 2); ?>
                        (<?php echo $item['quantity']; ?> stuks)</li>
                <?php endforeach; ?>
            </ul>
            <p>Totaal: €<?php echo number_format($totalPrice, 2); ?></p>
        </div>

        <div class="leveringsadres">
            <h2>Leveringsadres</h2>
            <p><?php echo htmlspecialchars($klantgegevens['voornaam']) . ' ' . htmlspecialchars($klantgegevens['naam']); ?>
            </p>
            <p><?php echo htmlspecialchars($klantgegevens['straat']) . ' ' . htmlspecialchars($klantgegevens['huisnummer']); ?>
            </p>
            <p><?php echo htmlspecialchars($klantgegevens['postcode']) . ' ' . htmlspecialchars($klantgegevens['woonplaats']); ?>
            </p> <!-- Gebruik postcode en woonplaats -->
            <p><?php echo htmlspecialchars($klantgegevens['telefoon']); ?></p>
        </div>

        <div class="center-button-container">
            <button onclick="window.location.href='MainController.php?action=index'" class="btn3"><span
                    class="spn3">Terug naar Homepage</span></button>
        </div>
    </div>

</body>

</html>