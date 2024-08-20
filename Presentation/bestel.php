<?php
declare(strict_types=1);
//Presentation/bestel.php
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
    <!-- Navigatiebalk -->
    <div class="navbar">
        <button><a href="MainController.php?action=index" class="btn2"><span class="spn2">Home</span></a></button>
        <button><a href="MainController.php?action=bestel" class="btn2"><span class="spn2">Bestel</span></a></button>
    </div>
    
    <h1 class="bestel-header">Onze Pizza's</h1>

    <!-- Winkelmandje -->
    <div class="winkelmandje">
        <h2>Winkelmandje</h2>
        <form method="post" action="MainController.php?action=bestel">
            <ul id="cartItems">
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['cartItems'] as $productId => $item):
                    $totalItemPrice = $item['price'] * $item['quantity'];
                    $totalPrice += $totalItemPrice;
                    ?>
                    <li>
                        <?php echo htmlspecialchars($item['name']); ?> - €<?php echo number_format($totalItemPrice, 2); ?>
                        (<?php echo $item['quantity']; ?> stuks)
                        <input type="number" name="quantities[<?php echo $productId; ?>]"
                            value="<?php echo $item['quantity']; ?>" min="0">
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>Totaal: €<span id="total"><?php echo number_format($totalPrice, 2); ?></span></p>
            <button type="submit" name="updateCart" class="btn3"><span class="spn3">Winkelmandje
                    bijwerken</span></button>
        </form>
        <form method="post" action="MainController.php?action=klantgegevens">
            <button type="submit" name="checkout" class="btn3"><span class="spn3">Afrekenen</span></button>
        </form>
    </div>

    <!-- Bestelmenu met achtergrondafbeelding -->
    <div class="bestelmenu-container">
        <div class="bestel-background"></div> <!-- Achtergrondafbeelding -->
        <div class="bestelmenu">
            <?php foreach ($pizzas as $pizza):
                $isSeasonal = $pizza->getSeizoensgebonden();
                $isAvailable = true;

                if ($isSeasonal) {
                    $seizoensgebondenProducten = $seizoensgebondenProductService->getAllSeizoensgebondenProducten();
                    foreach ($seizoensgebondenProducten as $seizoensgebondenProduct) {
                        if ($seizoensgebondenProduct->getProductId() == $pizza->getProductId()) {
                            $seizoen = $seizoenService->getSeizoenById($seizoensgebondenProduct->getSeizoenId());
                            $startDatum = new \DateTime($seizoen->getStartDatum());
                            $totDatum = new \DateTime($seizoen->getTotDatum());

                            if ($currentDate < $startDatum || $currentDate > $totDatum) {
                                $isAvailable = false;
                                break;
                            }
                        }
                    }
                }
            ?>
                <div class="pizza<?php echo $isAvailable ? '' : ' greyed-out'; ?>">
                    <h2><?php echo $pizza->getNaam(); ?></h2>
                    <p><?php echo $pizza->getIngredienten(); ?></p>
                    <p>Prijs: €<?php echo number_format((float) $pizza->getPrijs(), 2); ?></p>
                    <?php if ($isAvailable): ?>
                        <form method="post" action="MainController.php?action=bestel">
                            <input type="hidden" name="addToCart" value="1">
                            <input type="hidden" name="productId" value="<?php echo $pizza->getProductId(); ?>">
                            <input type="hidden" name="productName" value="<?php echo $pizza->getNaam(); ?>">
                            <input type="hidden" name="productPrice" value="<?php echo $pizza->getPrijs(); ?>">
                            <button type="submit" class="btn3"><span class="spn3">Voeg toe</span></button>
                        </form>
                    <?php else: ?>
                        <p class="not-available">Niet beschikbaar</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
