<!-- dit is het bestand dat wordt geladen zodra je naar de website gaat -->
<?php
include __DIR__ . "/header.php";

$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);

$aanbevolen = array();

$query = "SELECT StockItemID, Korting FROM aanbevolen";
$result = mysqli_query($connection, $query);
while($row = mysqli_fetch_array($result)) {
    $aanbevolen[$row["StockItemID"]] = $row["Korting"];
}

?>
<!DOCTYPE html>
<html lang="nl" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Aanbiedingen</title>
</head>
<body>
<center>
    <?php
    if(empty($aanbevolen)){
        print("<br<br><br><br><br<br><br><br><br<br><br><br><br<br><br><br><br<br><br<br><h1 class='Aanbiedingen' style='color: #676EFF'>Er zijn momenteel geen aanbiedingen!</h1>");
    } else {
        print("<h1 class='Aanbiedingen' style='color: #676EFF'>Aanbiedingen!</h1>");
    }
    ?>
</center>
<?php

if(!empty($aanbevolen)) {
    foreach ($aanbevolen as $id => $korting) {

        if ($id === "") continue;

        $query = "SELECT ImagePath FROM stockitemimages WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);

        if (empty($row[0])) {
            $query = "SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = " . $id;
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_row($result);
            $path = "Public/StockGroupIMG/$row[0]";
        } else {
            $path = "Public/StockItemIMG/" . $row[0];
        }

        $query = "SELECT StockItemName FROM stockitems WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $name = $row[0];

        $query = "SELECT (RecommendedRetailPrice * (1+(TaxRate/100))) FROM stockitems WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $prijs = $row[0];
        $korting1 = $prijs * ($korting / 100);
        $prijs1 = $prijs - $korting1;

        $query = "SELECT QuantityOnHand FROM stockitemholdings WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        $voorraad = $row[0];
        print("
    <table style='float: left; width: 300px'>
    <tr>
    <td colspan='3'><img style='width: 200px; margin-top: 10px' src='$path'></td>
    </tr>
    <tr>
    <td colspan='3'><a href='view.php?id=" . $id . "' style='color: &#xf1f8'>Artikelnummer: $id</td>
    </tr>
    <tr>
    <td colspan='3'>Naam: $name<td>
    </td>
    <tr>
    <td colspan='3'>Voorraad: $voorraad</td>
    </tr>
    <tr>
    <td colspan='3'>Prijs inclusief BTW: " . sprintf('€ %.2f', $prijs1) . "</td>
    </tr>
    <tr>
    <td colspan='3' style='color: gold'>Korting: $korting%</td>
    </tr>
    ");
    }
}
?>
</table>
<hr style='background-color: #676EFF'>
</body>
</html>
<?php
include __DIR__ . "/footer.php";
?>