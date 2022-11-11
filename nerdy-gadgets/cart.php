<?php
include "cartfuncties.php";
include "header.php";
$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);
/*$sql = "SELECT StockItemName, UnitPrice FROM stockitems WHERE UnitPrice < 2.50";
$result = mysqli_query($connection, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $stockItem = $row["StockItemName"];
    $prijs = $row["UnitPrice"];
    print($stockItem . " " . $prijs . "<br>");
}*/
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
</head>
<body>
<h1>Inhoud Winkelwagen</h1>
<?php
$cart = getCart();
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
    print("
    <table style='width:100%'>
    <tr>
    <td style='width:200px'>
    <img width=\"200\" src=\"$path\">
    </td>
    ");
    $query = "SELECT StockItemName FROM stockitems WHERE StockItemID = ".$id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $name = $row[0];
    $query = "SELECT (RecommendedRetailPrice * (1+(TaxRate/100))) FROM stockitems WHERE StockItemID = " . $id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $prijs = $row[0];
    print("
    <td style='width:30%'>
    <a class='StockItemName' href='view.php?id=".$id."'>".$name."</a>
    <br>
    <h3 class='StockItemID'>hoeveelheid: ".$hoeveelheid."</h3>
    <h2 class='StockItemID nobreak'>id: ".$id."</h2>
    </td>
    <form method='post'>
    <td style='width:5%'>
    <input name='+".$id."' value='+' type='submit'>
    </td>
    <td style='width:5%'>
    <input name='min".$id."' value='-' type='submit'>
    </td>
    </form>
    ");
    if (isset($_POST["+".$id])) {              // zelfafhandelend formulier
        addProductToCart($id);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
    } elseif (isset($_POST["min".$id])) {              // zelfafhandelend formulier
        removeProductFromCart($id);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
    }
    print("
    <td>
    <h4 class='StockItemPriceText'>".round($prijs,2)."</h4>
    </td>
    ");
}
print("</table>");
//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.

?>
</body>
</html>