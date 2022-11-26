<?php
include "header.php";
?>
<table style="width: 100%">
    <tr>
        <th colspan="3" style="width: 50%">Registreren</th>
    </tr>
    <form method="post">
        <tr>
            <td style="width: 3%">
                <label for="RegisterEmail">Email:</label>
            </td>
            <td>
                <input style="height: 10%" name="RegisterEmail" type="email" required>
            </td>
        </tr>
        <tr>
            <td style="width: 3%">
                <label for="RegisterWachtwoord">Wachtwoord:</label>
            </td>
            <td>
                <input style="height: 10%" name="RegisterWachtwoord" type="password" minlength="8" required>
            </td>
            <td style="width: 22%"></td>
            <td style="width: 3%">
        </tr>
        <tr>
            <td></td>
            <td>
                <input style="height: 10%" type="submit" value="Registreren">
            <td></td>
        </tr>
    </form>
</table>