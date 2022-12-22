<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/header.php";
include_once "database.php";
$databaseConnection = connectToDatabase();
$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);

?>

<?php
include "cartfuncties.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Artikelpagina (geef ?id=.. mee)</title>
</head>
<body>
</body>
</html>

<?php
$query = "
                SELECT ImagePath
                FROM stockitemimages
                WHERE StockItemID = ?";

$statement = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($statement, "i", $_GET["id"]);
mysqli_stmt_execute($statement);
$r = mysqli_stmt_get_result($statement);
$r = mysqli_fetch_all($r, MYSQLI_ASSOC);

if($r){
    $images = $r;
}
?>

<div id="CenteredContent">
    <?php
    if ($StockItem != null) {
        ?>
        <?php
        if (isset($StockItem['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $StockItem['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($images)) {
                // één plaatje laten zien
                if (count($images) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $images[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                } else if (count($images) >= 2) { ?>
                    <!-- meerdere plaatjes laten zien -->
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($images); $i++) {
                                    ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($images); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img src="Public/StockItemIMG/<?php print $images[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- knoppen 'vorige' en 'volgende' -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;"></div>
                <?php
            }
            ?>

            <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>
            <div id="refresh_me" >
                <?php
                if (isset($_GET["id"])) {
                    $stockItemID = $_GET["id"];
                    if($stockItemID>= 220 && $stockItemID <=227){
                        $query = "SELECT StockItemID FROM stockitems WHERE IsChillerStock = 1 ";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_array($result);
                        if(isset($row[0])){
                        ?> <input style="background-color:#23232F; color: white; border-color:#676EFF; width: 50px; height: 30px; margin-top: 130px" type="button" value="Live" onclick="window.location.reload()"><br> <?php
                        $query = "SELECT Temperature, ValidFrom FROM coldroomtemperatures WHERE ColdRoomSensorNumber = 5";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_array($result);
                        print ("Temperatuur Magazijn: ") . $row["Temperature"]."˚C <br>";
                        print ("Tijd van meting: ") . $row["ValidFrom"];
                    }}}?>
            </div>
            <div class="QuantityText"><?php print $StockItem['QuantityOnHand']; ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <br>
                        <br>
                        <?php
                        $query = "SELECT StockItemID FROM Aanbevolen WHERE StockItemID = " . $StockItem["StockItemID"];
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_array($result);
                        if(empty($row)){
                            ?>
                            <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem["SellPrice"]); ?></b></p>
                            <h6 class="nobreak"> Inclusief BTW </h6><br><br>
                            <?php
                        } else {
                            $aanbevolen = $row[0];

                            if(empty($aanbevolen)){
                                } else {
                                $query = "SELECT Korting FROM Aanbevolen WHERE StockItemID = " . $StockItem["StockItemID"];
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_array($result);
                                $korting = $row[0];
                                $prijs = $StockItem["SellPrice"];
                                $korting1 = $prijs * ($korting / 100);
                                $prijs1 = $prijs - $korting1;
                            ?>
                            <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $prijs1); ?></b></p>
                            <h6 class="nobreak"> Inclusief BTW </h6><br><br>
                                <p class="nobreak" style="color: gold; font-size: xx-large">Aanbieding!</p>
                            <?php
                            }
                        }
                        ?>
                        <?php
                        //?id=1 handmatig meegeven via de URL (gebeurt normaal gesproken als je via overzicht op artikelpagina terechtkomt)
                        if (isset($_GET["id"])) {
                            $stockItemID = $_GET["id"];
                        } else {
                            $stockItemID = 0;
                        }
                        ?>

                        <!-- formulier via POST en niet GET om te zorgen dat refresh van pagina niet het artikel onbedoeld toevoegt-->
                        <form method="post">
                            <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>
                            <input type="submit" name="submit" value="Voeg toe aan winkelmandje" style="height:30px; width:250px; background-color:#23232F; color:#676EFF; border-color:#676EFF">
                            <input type="number" name="amount" value="1" min="1" style="height:30px; width:250px; background-color:#23232F; color:#FFFFFF; border-color:#676EFF">
                        </form>
                        <?php
                        if (isset($_POST["submit"])) {              // zelfafhandelend formulier
                            $query = "SELECT QuantityOnHand FROM stockitemholdings WHERE StockItemID = " . $stockItemID;
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_fetch_array($result);
                            $hoeveelheid = $row[0];
                            $cart = getCart();
                            if(empty($cart["$stockItemID"])){
                                $cart["$stockItemID"] = 0;
                            }
                            if ($_POST["amount"] > $hoeveelheid || ($_POST["amount"] + $cart["$stockItemID"]) > $hoeveelheid) {
                                print("De gevraagde hoeveelheid ligt boven de voorraad!");
                            } else {
                                $stockItemID = $_POST["stockItemID"];
                                if ($_POST["amount"] >= 1 && $_POST["amount"] == number_format($_POST["amount"], 0, ',', '.')) {
                                    $_POST["amount"] = rtrim(rtrim(number_format($_POST["amount"], '0')));
                                    addProductAmountToCart($stockItemID, $_POST["amount"]);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
                                    print("Product toegevoegd");
                                    print("<meta http-equiv='refresh'  content='0'>");
                                } elseif ($_POST["amount"] >= 1) {
                                    addProductAmountToCart($stockItemID, $_POST["amount"]);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
                                    print("Product toegevoegd");
                                    print("<meta http-equiv='refresh'  content='0'>");
                                } else {
                                    print("Voer een geldig cijfer in!");
                                }
                            }
                        }print("<a href='cart.php'> Winkelmand bekijken</a>");
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $StockItem['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($StockItem['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                <thead>
                <th>Naam</th>
                <th>Data</th>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php print $SpecName; ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </table><?php
            } else { ?>

                <p><?php print $StockItem['CustomFields']; ?>.</p>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>
