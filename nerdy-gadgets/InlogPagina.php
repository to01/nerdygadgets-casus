<?php
include "header.php";
?>
<table style="width: 100%">
    <tr>
        <h1 class="TextMain" style="margin-left: 5px; margin-top: 5px">Inloggen </h1>
    </tr>
</table>
    <form method="post">
        <table>
            <tr> <!--e-mail -->
                <td><div style="text-align: right">* E-mail:</div></td>
                <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="E-mail" type="email" required></td>
            </tr>
            <tr> <!--Wachtwoord -->
                <td><div style="text-align: right">* Wachtwoord:</div></td>
                <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="wachtwoord" type="password" required></td>
            </tr>
            <tr>
                <td style="width: 160px"></td>
                <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" type="submit" name="BestelSubmit" value="Inloggen" ></td>
            </tr>
        </table>
    </form>
</table>
<a href="RegisteerPagina.php" style="color:#3366CC;" class="HrefDecoration"> <u> Geen account? Klik hier </u> </a>
