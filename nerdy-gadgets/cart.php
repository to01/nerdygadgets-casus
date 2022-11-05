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
    print("<img width=\"200\" src=\"$path\">");
    $query = "SELECT StockItemName FROM stockitems WHERE StockItemID = ".$id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $name = $row[0];
    print("<a class='StockItemName' href='view.php?id=".$id."'>".$name."</a><h2 class='StockItemID nobreak'>".$hoeveelheid."</h2><br>".$id."<hr style=\"background-color:#676EFF\">");
}
//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.

?>
</body>
</html>