<?php
include "cartfuncties.php";
include "header.php";
$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
</head>
<body>
<h1 class="CartHeader">Inhoud Winkelwagen</h1>
<?php
$cart = getCart();
$totaalprijs = 0;
foreach($cart as $id => $hoeveelheid) {
    if($id==="") continue;
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

    $query = "SELECT Korting FROM Aanbevolen WHERE StockItemID = " . $id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    if(empty($row)){
        $korting = 0;
    } else {
        $korting = $row[0];
    }

    $query = "SELECT (RecommendedRetailPrice * (1+(TaxRate/100))) FROM stockitems WHERE StockItemID = " . $id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $prijs = $row[0];

    $query = "SELECT QuantityOnHand FROM stockitemholdings WHERE StockItemID = " . $id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $voorraad = $row[0];

    if(empty($korting)){
        $prijs1 = $prijs * $hoeveelheid;
        $totaalprijs += $prijs1;
    } else {
        $korting1 = $prijs * ($korting / 100);
        $prijs0 = $prijs - $korting1;
        $prijs1 = $prijs0 * $hoeveelheid;
        $totaalprijs += $prijs0;
        $prijs = $prijs - $korting1;
    }
    if (isset($_POST["Verwijderen".$id])) {
        deleteProductFromCart($id);
        print("<meta http-equiv='refresh' content='0'>");
    } elseif (isset($_POST["submit".$id])) {              // zelfafhandelend formulier\
        if ($_POST["amount".$id] > $voorraad){
        } elseif($_POST["amount".$id] <= 0) {
        } elseif ($_POST["amount".$id] == number_format($_POST["amount".$id], 0, ',', '.')) {
            $_POST["amount".$id] = rtrim(rtrim(number_format($_POST["amount".$id], '0')));
            setProductAmount($id, $_POST["amount".$id]);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
        } else {
            setProductAmount($id, $_POST["amount" . $id]);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
        }
        print("<meta http-equiv='refresh' content='0'>");
    }
    print("
  
    ");
    ?>
    <td style='width:40%'>
        <?php
        if($korting != 0){
            ?>
            <a style="color: gold; font-size: xx-large">Aanbieding!</a><br>
            <?php
        }
        ?>
        <a class='CartName' href='view.php?id=<?php print($id)?>'> <?php print($name) ?></a>
        <!--    <h3 class='CartAmount'>hoeveelheid: ".$hoeveelheid."</h3>-->
        <br>
        <h2 class='CartId nobreak'>Artikelnummer: <?php print($id)?></h2>
    </td>
    <form method='post'>
        <hr style="background-color:#676EFF">
        <td style='width:5%'>
            <input style='font-family: FontAwesome; background: none; border: none; font-size: xx-large; color: #676EFF' name='submit<?php print($id) ?>' value='&#xf0c7' type='submit'>
        </td>
        <td style='width:10%'>
            <input class='CartAmount' name='amount<?php print($id)?>' value='<?php print($hoeveelheid) ?>' min='1' max='<?php print($voorraad)?>' type='number'>
        </td>
        <td style='width:5%'>
            <input style='font-family: FontAwesome; background: none; border: none; font-size: xx-large; color: #676EFF' name='Verwijderen<?php print($id) ?>' value='&#xf1f8' type='submit'>
        </td>
        <td>
            <h4 class='StockItemPriceText'><?php print(sprintf("€ %.2f", $prijs1)) ?></h4>
            <h4 class='CartId'><?php print(sprintf("€ %.2f", $prijs)) ?> per stuk</h4>
            <h4 style='font-size: 1rem'>Inclusief BTW</h4>
            <?php
            if($korting != 0){
                ?>
                <h4 style="font-size: 1rem; color: gold">Korting: <?php print($korting)?>%</h4>
                <?php
            }
            ?>
        </td>
    </form>
<?php
}
print("</table><br>");
print("<h5 class='StockItemPriceText'>" . "Totaalprijs: " . sprintf("€ %.2f", $totaalprijs) . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . "<a href='CartBewaren.php' class='HrefDecoration' style='color:#676EFF'> <button class='bewaren'>Winkelmand bewaren </button> </a>" . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . "<a href='BestelPagina.php' class='HrefDecoration' style='color:#676EFF'><button class='bestellen'>Verder Naar Bestellen</button></a>" . "</h5>");?>
</body>
</html>