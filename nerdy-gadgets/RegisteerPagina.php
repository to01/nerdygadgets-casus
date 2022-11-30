<?php
include "header.php";
?>
<table style="width: 100%">
    <tr>
        <h1 class="TextMain" style="margin-left: 5px; margin-top: 5px">Registreren </h1>
    </tr>
</table>
<form method="post">
    <table>
        <tr> <!--naam -->
            <td><div style="text-align: right">* Naam:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelNaam" type="text" required></td>
        </tr>
        <tr> <!--Wachtwoord -->
            <td><div style="text-align: right">* Wachtwoord:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="wachtwoord" type="password" required></td>
        </tr>
        <tr> <!--e-mail -->
            <td><div style="text-align: right">* E-mail:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="E-mail" type="email" required></td>
        </tr>
        <tr> <!--Land -->
            <td><div style="text-align: right">* Land:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="Land" type="country" required></td>
        </tr>
        <tr> <!-- adres -->
            <td><div style="text-align: right">* Adres:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelAdres" type="text" required></td>
        </tr>
        <tr> <!-- postcode -->
            <td><div style="text-align: right">* Postcode:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelPostcode" type="text" required></td>
        </tr>
        <tr> <!-- telefoonnummer -->
            <td><div style="text-align: right">* Telefoonnummer:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" type="tel" id="phone" name="phone" minlength="10" maxlength="15" pattern="[0,9]{3}[0-9]{8,15}\[0,9]{3} [0-9]{8,15}" required></td>
        </tr>
        <tr>
            <td style="width: 160px"></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" type="submit" name="Inlogsubmit" value="Registreren" onclick="return confirm('Zijn alle gegevens goed ingevuld en gecontroleerd?')"></td>
        </tr>
    </table>
</form>
</table>
</table>
