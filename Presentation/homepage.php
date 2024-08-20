<?php
declare(strict_types=1);
//Presentation/homepage.php
namespace Presentation;

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="Presentation/style.css">
    <link rel="icon" href="Presentation/Images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

</head>

<body>
    <!-- Navigatiebalk -->
    <div class="navbar">
        <button><a href="MainController.php?action=index" class="btn2"><span class="spn2">Home</span></a></button>
        <button><a href="MainController.php?action=bestel" class="btn2"><span class="spn2">Bestel</span></a></button>
    </div>


    <div class="hero">
        <img src="Presentation/Images/pizza1.jpg" alt="Hero" class="hero-image">
        <div class="hero-text">
            <h2>Welkom bij La Bella Napoli</h2>
            <p>Ontdek onze heerlijke Italiaanse gerechten</p>
        </div>
    </div>

    <!-- Over Ons Sectie -->
    <div class="over-ons">
        <h1>Over Ons</h1>
        <p class="roboto-light">Welkom bij La Bella Napoli, waar passie voor heerlijk eten samensmelt met Italiaanse
            traditie en
            gastvrijheid. Bij ons draait alles om het creëren van memorabele momenten rond de tafel, gevuld met
            smaakvolle gerechten en warme gesprekken.

            Onze reis begon met een diepgewortelde liefde voor authentieke Italiaanse keuken. Met verse ingrediënten van
            hoge kwaliteit en ambachtelijk vakmanschap, brengen we de essentie van Italië naar uw bord. Elke pizza wordt
            zorgvuldig samengesteld, met de perfecte balans tussen knapperige korst, smeuïge kaas en verrukkelijke
            toppings.

            Bij La Bella Napoli streven we naar excellentie in alles wat we doen. Naast onze traditionele dine-in
            ervaring, bieden we ook een handige online bestelservice aan, zodat u onze heerlijke gerechten kunt genieten
            in het comfort van uw eigen huis. Blader door ons uitgebreide menu, kies uw favoriete pizza's en gerechten,
            en plaats eenvoudig uw bestelling met slechts een paar klikken.

            Of u nu geniet van een klassieke Margherita, een verrassende vegetarische optie, of een gedurfde nieuwe
            smaakcombinatie, bij La Bella Napoli vindt u altijd iets dat uw smaakpapillen prikkelt en uw hart verwarmt.
            Dompel uzelf onder in de levendige smaken en geuren van Italië, en laat ons uw zintuigen verwennen met een
            onvergetelijke culinaire reis.

            We kijken ernaar uit om u te verwelkomen bij La Bella Napoli, waar elke hap een verhaal vertelt en elke
            maaltijd een viering is van vriendschap, goed eten en het gemak van online bestellen. Buon appetito!</p>
    </div>

</body>

</html>