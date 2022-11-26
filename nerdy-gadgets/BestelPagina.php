<?php
include "header.php";
?>
<h1 class="TextMain" style="margin-left: 5px; margin-top: 5px">Bestellen</h1>
<form>
    <table>
        <tr> <!-- checkboxes -->
            <td style="width: 150px"></td>
            <td><div style="text-align: right">Particulier</div></td>
            <td><input style="height: 10%" type="checkbox"></td>
            <td><div style="text-align: right">Zakelijk:</div></td>
            <td><input style="height: 10%" type="checkbox"></td>
        </tr>
    </table>
    <table>
        <tr> <!--naam -->
            <td><div style="text-align: right">Naam:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelNaam" type="text"></td>
        </tr>
        <tr> <!-- adres -->
            <td><div style="text-align: right">Adres:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelAdres" type="text"></td>
        </tr>
        <tr> <!-- postcode -->
            <td><div style="text-align: right">Postcode:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelPostcode" type="text"></td>
        </tr>
        <tr> <!-- telefoonnummer -->
            <td><div style="text-align: right">Telefoonnummer:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelTelefoonnummer" type="tel"></td>
        </tr>
        <tr>
            <td style="width: 150px"></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" type="submit" name="BestelSubmit" value="Bestellen"></td>
        </tr>
    </table>
</form>
