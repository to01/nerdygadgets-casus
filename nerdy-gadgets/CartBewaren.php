<?php
include "header.php";
include "cartfuncties.php";
$host = "localhost";
$user = "root";
$pass = "";
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);
$cart = getCart();
$bedrijfsnaam = "";
$naam = "";
$email = "";
$land = ' value="NAN">Kies een land';
$woonplaats = "";
$adres = "";
$postcode = "";
$telefoonnummer = "";
$telefooncode = "";
$status = "";
if(isset($_SESSION["WebCustomerID"])) {
    $query = "SELECT * FROM webshopklant WHERE WebCustomerID = " . $_SESSION["WebCustomerID"];
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $telarray = explode("-",$row[6]);
    $phonecode = $telarray[0];
    $phonenumber = $telarray[1];
    $naam = 'value="'.$row[1].'" disabled';
    $email = 'value="'.$row[7].'" disabled';
    $land = ' value="'.$row[2];
    $woonplaats = 'value="'.$row[3].'" disabled';
    $adres = 'value="'.$row[4].'" disabled';
    $postcode = 'value="'.$row[5].'" disabled';
    $telefooncode = 'value="'.$phonecode.'" disabled';
    $telefoonnummer = 'value="'.$phonenumber.'" disabled';
    $status = "disabled";
    $loginland = $row[2];
    $logincity = $row[3];
    $loginadres = $row[4];
    $loginpostcode = $row[5];
    $marketingemail = $row[7];
    $customername = $row[1];
}
?>
    <h1 class="TextMain" style="margin-left: 5px; margin-top: 5px">Winkelmand bewaren </h1>
    <form method="post">
        <table>
            <tr> <!--naam -->
                <td><div style="text-align: right">* Naam:</div></td>
                <td><input style="height: 10%; background-color:#23232F; color: white; border-color:#676EFF" name="BewarenNaam" type="text" <?php print($naam); ?> required></td>
            </tr>
            <tr> <!--e-mail -->
                <td><div style="text-align: right; width: 140px">* E-mail:</div></td>
                <td><input style="height: 10%; background-color:#23232F; color: white; border-color:#676EFF" name="E-mail" <?php print($email); ?> placeholder="example@gmail.com" type="email" required></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 160px"></td>
                <td><input style="height: 10%; width: 204.8px; background-color:#23232F; color: white; border-color:#676EFF"<?php if(empty($cart)) {print(' disabled="disabled"');} ?> type="submit" name="BewarenSubmit" value="Bewaren" ></td>
            </tr>
        </table>
    </form>
<?php
$cart = getCart();
$totaalprijs = 0;
foreach($cart as $id => $hoeveelheid) {
    $query = "SELECT StockItemName FROM stockitems WHERE StockItemID = ".$id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $name = $row[0];
    $query = "SELECT (RecommendedRetailPrice * (1+(TaxRate/100))) FROM stockitems WHERE StockItemID = " . $id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $prijs = $row[0];
    $prijs1 = $prijs * $hoeveelheid;
    $totaalprijs += $prijs1;

}
if (isset($_POST["BewarenSubmit"])){
    $naam = $_POST["BewarenNaam"];
    $email = $_POST["E-mail"];
}
if(empty($customername)) {
    $customername = $naam;
}
if(empty($marketingemail)) {
    $marketingemail = $email;
}

$message = "
        <body>
            <p>Geachte $customername<br><br>U heeft gekozen om uw winkelmand te bewaren,<br>hieronder staat een overzicht van uw producten</p><br>
            <table style='width: 1000px'>
            <tr style='text-align:left;'>
               <th>Artikelnummer</th><th>Productnaam</th><th>Aantal</th><th>Prijs/stuk</th><th>Subtotaal</th>
            </tr><br>
            ";
$totaalprijs=0;
if(isset($_POST["BewarenSubmit"])){
    foreach($cart as $id => $hoeveelheid) {
        $to = $marketingemail;
        $subject = 'Bewaarde producten NerdyGadgets';
        $query = "SELECT StockItemName FROM stockitems WHERE StockItemID = ".$id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $name = $row[0];
        $query = "SELECT (RecommendedRetailPrice * (1+(TaxRate/100))) FROM stockitems WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $prijs = $row[0];
        $prijs1 = $prijs * $hoeveelheid;
        $totaalprijs += $prijs1;
        $message .= "
            <tr>
               <td class='CartId nobreak'>".$id."</td><td>$name</td><td>$hoeveelheid</td><td class='CartId'>" . sprintf("€ %.2f", $prijs) . "</td><td class='StockItemPriceText'>" . sprintf("€ %.2f", $prijs1) . "</td>
            </tr>
        ";
    }
    $query = "SELECT MAX(WebOrderID) FROM webshoporders";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $ordernummer = $row[0];
    $message .= "
                <br><br>
                <tr>
                    <td>Ordernummer: $ordernummer</td><td> </td><td> </td><td> </td> <td class='StockItemPriceText'>Totaal: " . sprintf("€ %.2f", $totaalprijs) . "</td></td>
                </tr>
            </table>
            <br><br><p>Met vriendelijke groeten,<br>NerdyGadgets<br>---------------------------<br>+31 0612345678<br>NerdyGadgets@gmail.com<br></p>
        </body>";
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    mail($to, $subject, $message, implode("\r\n", $headers));

    print("<meta http-equiv='refresh' content='0; url=.'>");
}
