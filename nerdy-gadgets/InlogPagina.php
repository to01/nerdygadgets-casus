<?php
include "header.php";
$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);
?>
<table style="width: 100%">
    <tr>
        <td>
        <h1 class="TextMain" style="margin-left: 5px; margin-top: 5px">Inloggen </h1>
        </td>
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
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" type="submit" name="InlogSubmit" value="Inloggen" ></td>
        </tr>
    </table>
</form>
<a href="RegistreerPagina.php" style="color:#3366CC;" class="HrefDecoration"> <u> Geen account? Klik hier </u> </a>
<br>
<br>
<a href="changeaddress.php" style="color:#3366CC;" class="HrefDecoration"> <u> Accountgegevens aanpassen? Klik hier (inlog vereist)</u> </a>
<?php
if(isset($_POST["InlogSubmit"])) {
    $email = $_POST["E-mail"];
    $wachtwoord = hash("SHA256", $_POST["wachtwoord"]);
    $query = "SELECT WebCustomerID FROM webshopklant WHERE CustomerEmail = '".$email."' AND CustomerPassword = '".$wachtwoord."' AND isloggable = 1";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    if(isset($row[0])) {
        print("<br>U bent ingelogd<br>");
        $_SESSION["inlogstatus"] = True;
        $_SESSION["WebCustomerID"] = $row[0];
        print("<meta http-equiv='refresh' content='1; url=\".\"' />");
    }
}