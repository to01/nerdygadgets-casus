<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
if(empty($_SESSION['inlogstatus'])) {
    $_SESSION['inlogstatus'] = False;
}
include "database.php";
function countCart() {
    if (isset($_SESSION['cart'])) { //volledigheid van getCart() hier omdat je m anders 2 keer aanroept en glitches krijgt
        $cart = $_SESSION['cart'];
    } else {
        $cart = array();
    } // eind getCart()
    $i = 0;
    foreach($cart as $id => $amount) {
        $i += $amount;
    }
    return $i; // $i is het totaal aantal producten in de cart
}
$databaseConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css">
</head>
<body>
<style>
    .badge:after{
        content:attr(value);
        font-size:10px;
        color: #fff;
        background: #676EFF;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
        border-radius:50%;
        padding: 0 5px;
        position:relative;
        left:-8px;
        top:-10px;
        opacity:0.9;
    }

</style>
<div class="Background">
    <div class="row" id="Header">
        <div class="col-2"><a href="./" id="LogoA">
                <div id="LogoImage"></div>
            </a></div>
        <div class="col-8" id="CategoriesBar">
            <ul id="ul-class">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <li>
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </li>
            </ul>
        </div>
        <!-- code voor US3: zoeken -->
        <ul id="ul-class-navigation">
            <li><?php
                if(isset($_SESSION["inlogstatus"])) {
                    if($_SESSION["inlogstatus"] == True) {
                        $webCustomerID = $_SESSION["WebCustomerID"];
                        $query = "SELECT isAdmin FROM webshopklant WHERE WebCustomerID = " . $webCustomerID;
                        $result = mysqli_query($databaseConnection, $query);
                        $row = mysqli_fetch_array($result);
                        if(empty($row)){
                        } else {
                            $isAdmin = $row[0];
                            if($isAdmin == 1){
                                print('<a href="Admin.php"><i class="fas fa-cogs"></i> Admin </a> &nbsp');
                            }
                        }
                        print('<a href="InlogPagina.php" style="color: lawngreen" class="HrefDecoration"><i class="fas fa-user"></i>&nbsp&nbsp&nbsp&nbsp&nbsp');
                        print('<a href="UitlogPagina.php" class="HrefDecoration"><i class="fa-solid fa-right-from-bracket"></i>');
                    } else {
                        print('<a href="InlogPagina.php" class="HrefDecoration"><i class="fas fa-user"></i>');
                    }
                } else {
                    print('<a href="InlogPagina.php" class="HrefDecoration"><i class="fas fa-user"></i>');
                }
                ?>
                &nbsp
                <a href="cart.php"><i class="fa badge fa-lg" value="<?php print(countCart());?>" style="color: #FFFFFF">&#xf07a;</i></a>
                &nbsp&nbsp&nbsp
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken </a>
            </li>
        </ul>
        <!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">
