<?php
declare(strict_types=1);
//Presentation/footer_loggedout.php
namespace Presentation;

?>
<div class="footer">
    <div class="Pizzeria info">
        <div class="Contact">
            <h3>Adres:</h3>
            <p>Straatnaam 123, 1234 AB Plaatsnaam</p>
            <h3>Contact:</h3>
            <p>012-3456789 | info@pizzeria.nl</p>
        </div>
        <div class="Openingsuren">
            <h3>Openingsuren:</h3>
            <p>Maandag:.....11:00 - 22:00</p>
            <p>Dinsdag:.....11:00 - 22:00</p>
            <p>Woensdag:....11:00 - 22:00</p>
            <p>Donderdag:...11:00 - 22:00</p>
            <p>Vrijdag:.....11:00 - 23:00</p>
            <p>Zaterdag:....11:00 - 23:00</p>
            <p>Zondag:......11:00 - 23:00</p>
        </div>
    </div>
    <form action="MainController.php?action=login" method="POST" class="login-form">
    <label for="emailadres">E-mailadres:</label>
    <input type="email" id="emailadres" name="emailadres" required>
    <label for="wachtwoord">Wachtwoord:</label>
    <input type="password" id="wachtwoord" name="wachtwoord" required>
    <button type="submit" class="btn2"><span class="spn2">Login</span></button>
</form>
</div>
