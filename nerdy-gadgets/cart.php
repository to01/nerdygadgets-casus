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
<h1 class="CartHeader">Inhoud Winkelwagen</h1>
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
    <td style='width:40%'>
    <a class='CartName' href='view.php?id=".$id."'>".$name."</a>
<!--    <h3 class='CartAmount'>hoeveelheid: ".$hoeveelheid."</h3>-->
    <br>
    <h2 class='CartId nobreak'>Artikelnummer: ".$id."</h2>
    </td>
    <form method='post'>
    <td style='width:5%'>
    <input style='font-family: FontAwesome; background: none; border: none; font-size: xx-large; color: #676EFF' name='submit".$id."' value='&#xf0c7' type='submit'>
    </td>
    <td style='width:10%'>
    <input class='CartAmount' name='amount".$id."' value='".$hoeveelheid."' type='number'>
    </td>
    <td style='width:5%'>
    <input style='font-family: FontAwesome; background: none; border: none; font-size: xx-large; color: #676EFF' name='Verwijderen".$id."' value='&#xf1f8' type='submit'>
    </td>
    <td>
    <h4 class='StockItemPriceText'>" . sprintf("€ %.2f", $prijs1) . "</h4>
    <h4 class='CartId'>" . sprintf("€ %.2f", $prijs) . " per stuk</h4>
    <h4 style='font-size: 1rem'>Inclusief BTW</h4>
    </td>
    </form>
    ");
    if (isset($_POST["Verwijderen".$id])) {
        deleteProductFromCart($id);
        print("<meta http-equiv='refresh' content='0'>");
    } elseif (isset($_POST["submit".$id])) {              // zelfafhandelend formulier
        if(!($_POST["amount".$id] <= 0)) {
            setProductAmount($id, $_POST["amount" . $id]);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
        }
        print("<meta http-equiv='refresh' content='0'>");
    }
    print("

    ");
}
print("</table><br>");
print("<h5 class='StockItemPriceText'>" . "Totaalprijs: " . sprintf("€ %.2f", $totaalprijs) . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . "<a href='BestelPagina.php' class='HrefDecoration' style='color:#676EFF'><button class='bestellen'>Verder Naar Bestellen</button></a>" . "</h5>");
?>
</body>
</html>
