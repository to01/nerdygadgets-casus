<?php
include "header.php";
?>
<h1 class="TextMain" style="margin-left: 5px; margin-top: 5px">Bestellen</h1>
<form method="post" action="https://www.ideal.nl/demo/qr/?app=ideal">
    <table>
        <tr> <!-- Radio -->
            <td style="width: 160px"></td>
            <td>Particulier:</td>
            <td><input style="height: 10%" type="radio" name="besteller" value="particulier" required></td>
            <td>Zakelijk:</td>
            <td><input style="height: 10%" type="radio" name="besteller" value="zakelijk"></td>
        </tr>
    </table>
    <table>
        <tr> <!--naam -->
            <td><div style="text-align: right">* Naam:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelNaam" type="text" required></td>
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
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" type="tel" id="phone" name="phone" minlength="10" maxlength="15" pattern="06[0-9]{8,10}\06 [0-9]{8}" required></td>
        </tr>
        <tr>
            <td style="width: 160px"></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" type="submit" name="BestelSubmit" value="Bestellen" onclick="return confirm('Zijn alle gegevens goed ingevuld en gecontroleerd?')"></td>
        </tr>
    </table>
</form>
