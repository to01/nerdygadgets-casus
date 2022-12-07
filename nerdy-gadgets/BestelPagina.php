<?php
include "header.php";
include "cartfuncties.php";
$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);
?>
<h1 class="TextMain" style="margin-left: 5px; margin-top: 5px">Bestellen </h1>
<form method="post">
    <table>
        <tr> <!-- Radio -->
            <td style="width: 160px"></td>
            <td>Particulier:</td>
            <td><input style="height: 10%" type="radio" name="besteller" value="0" required checked></td>
            <td>Zakelijk:</td>
            <td><input style="height: 10%" type="radio" name="besteller" value="1"></td>
        </tr>
    </table>
    <table>
        <tr> <!--naam -->
            <td><div style="text-align: right">* Naam:</div></td>
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" name="BestelNaam" type="text" required></td>
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
            <td><input style="height: 10%; background-color:#23232F; color:#676EFF; border-color:#676EFF" type="submit" name="BestelSubmit" value="Bestellen" onclick="return confirm('Zijn alle gegevens goed ingevuld en gecontroleerd?')"></td>
        </tr>
    </table>
</form>
<?php
date_default_timezone_set('Europe/Amsterdam');
if(isset($_POST["BestelSubmit"])) {
    if (isset($_SESSION["WebCustomerID"])) {
        $id = $_SESSION["WebCustomerID"];
        $query = "SELECT * FROM webshopklant WHERE WebCustomerID = ".$id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $sqlemail = $row[6];
        if($sqlemail == $_POST["E-mail"]) {
            $date = date("Y-m-d");
            $business = $_POST["besteller"];
            $query = "INSERT INTO webshoporders VALUES ((SELECT max(WebOrderID)+1 FROM webshoporders w)," . $id . ",'" . $date . "'," . $business . ")";
            $result = mysqli_query($connection, $query);
            print("<meta http-equiv='refresh' content='0; url=https://www.ideal.nl/demo/qr/?app=ideal'>");
        } else {
            // hier komt later een query
        }
    }
}
?>
<br>
    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <title>Winkelwagen</title>
    </head>
    <body>
    <h1 class="CartHeader">Overzicht Winkelwagen</h1>
    <hr style="background-color:#676EFF">
    </body>
<?php
$cart = getCart();
$totaalprijs = 0;
foreach($cart as $id => $hoeveelheid) {
    $query = "SELECT ImagePath FROM stockitemimages WHERE StockItemID = ".$id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);

    if(empty($row[0])){
        $query = "SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $path = "Public/StockGroupIMG/$row[0]";
    } else {
        $path = "Public/StockItemIMG/".$row[0];
    }

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
    print("
<td style='width:40%'>
    <a class='CartName' href='view.php?id=".$id."'>".$name."</a>
    <!--    <h3 class='CartAmount'>hoeveelheid: ".$hoeveelheid."</h3>-->
    <br>
    <h2 class='CartId nobreak'>Artikelnummer: ".$id."</h2>
</td>
<form method='post'>
    <td style='width:10%'>
        <h3> Aantal: $hoeveelheid </h3>
    </td>
    <td>
        <h4 class='StockItemPriceText'>" . sprintf("€ %.2f", $prijs1) . "</h4>
        <h4 class='CartId'>" . sprintf("€ %.2f", $prijs) . " per stuk</h4>
        <h4 style='font-size: 1rem'>Inclusief BTW</h4>
            <body>
    <hr style='background-color: #676EFF'>
    </body>
    </td>
</form>
            ");
}

if(isset($_POST["BestelSubmit"])){
    $cart = getCart();
    foreach($cart as $id => $hoeveelheid) {
        $query = "
                UPDATE stockitemholdings
                SET QuantityOnHand = (QuantityOnHand - " . $hoeveelheid . ")  
                WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        deleteProductFromCart($id);
        print("<meta http-equiv='refresh' content='0'>");
    }
}
