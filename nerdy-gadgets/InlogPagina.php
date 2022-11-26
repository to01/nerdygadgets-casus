<?php
include "header.php";
?>
<table style="width: 100%">
    <tr>
        <th colspan="3" style="width: 50%">Inloggen</th>
    </tr>
    <form method="post">
        <tr>
            <td style="width: 3%">
                <label for="LoginEmail">Email:</label>
            </td>
            <td>
                <input style="height: 10%" name="LoginEmail" type="email" required>
            </td>
        </tr>
        <tr>
            <td style="width: 3%">
                <label for="LoginWachtwoord">Wachtwoord:</label>
            </td>
            <td>
                <input style="height: 10%" name="LoginWachtwoord" type="password" minlength="8" required>
            </td>
            <td style="width: 22%"></td>
            <td style="width: 3%">
        </tr>
        <tr>
            <td></td>
            <td>
                <input style="height: 10%" type="submit" value="Inloggen">
            <td></td>
        </tr>
    </form>
</table>
<a href="RegisteerPagina.php" style="color:#3366CC;" class="HrefDecoration"> <u> Geen account? Klik hier </u> </a>