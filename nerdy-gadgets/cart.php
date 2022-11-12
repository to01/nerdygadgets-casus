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
<hr style="background-color:#676EFF">
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
    $prijs1 = $prijs * $hoeveelheid;
    $totaalprijs += $prijs1;
    print("
    <td style='width:30%'>
    <a class='StockItemName' href='view.php?id=".$id."'>".$name."</a>
    <br>
    <h3 class='StockItemID'>hoeveelheid: ".$hoeveelheid."</h3>
    <h2 class='StockItemID nobreak'>id: ".$id."</h2>
    </td>
    <form method='post'>
    <td style='width:5%'>
    <input name='Verwijderen".$id."' value='Verwijderen' type='submit' Style='Height: 50px; width:100px;'>
    </td>
    <td style='width:5%'>
    <input name='+".$id."' value='+' type='submit'>
    </td>
    <td style='width:5%'>
    <input name='-".$id."' value='-' type='submit'>
    </td>
    </form>
    ");
    if (isset($_POST["Verwijderen".$id])) {
        deleteProductFromCart($id);
        print("<meta http-equiv='refresh' content='0'>");
    }
    if (isset($_POST["+".$id])) {              // zelfafhandelend formulier
        addProductToCart($id);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
        print("<meta http-equiv='refresh' content='0'>");
    } elseif (isset($_POST["-".$id])) {              // zelfafhandelend formulier
        removeProductFromCart($id);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
        print("<meta http-equiv='refresh' content='0'>");
    }
    print("
    <td>
    <h4 class='StockItemPriceText'>" . sprintf("€ %.2f", $prijs1) . "</h4>
    </td>
    ");
}
print("</table><br>");
print("<h5 class='StockItemPriceText'>" . "Totaalprijs: " . sprintf("€ %.2f", $totaalprijs) .  "</h5>");
?>
</body>
</html>
