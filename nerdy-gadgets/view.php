<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/header.php";
$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);

$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
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
            <div class="QuantityText"><?php print $StockItem['QuantityOnHand']; ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <br>
                        <br>
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b></p>
                        <h6 class="nobreak"> Inclusief BTW </h6><br><br>

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
                            <input type="number" name="amount" value="1" style="height:30px; width:250px; background-color:#23232F; color:#FFFFFF; border-color:#676EFF">
                        </form>
                        <?php

                        if (isset($_POST["submit"])) {              // zelfafhandelend formulier
                            $query = "SELECT QuantityOnHand FROM stockitemholdings WHERE StockItemID = " . $stockItemID;
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_fetch_array($result);
                            $hoeveelheid = $row[0];
                            $cart = getCart();
                            if(empty($cart["$stockItemID"])) {
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
                                    print("<a href='cart.php'> Winkelmand bekijken</a>");
                                } elseif ($_POST["amount"] >= 1) {
                                    addProductAmountToCart($stockItemID, $_POST["amount"]);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
                                    print("Product toegevoegd");
                                    print("<a href='cart.php'> Winkelmand bekijken</a>");
                                } else {
                                    print("Voer een geldig cijfer in!");
                                }
                            }
                        }
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
                <th>Naam:</th>
                <th>Data:</th>
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
