<?php
include "header.php";
$connection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin pagina</title>
</head>
<body>
<h1>Toevoegen aanbieding</h1>

<form method="post">
    Aanbieding toevoegen <input style="width: 200px;" type="text" name="AanbiedingToevoegen">
    Korting op aanbieding <input style="width: 200px; type=text" name="Korting"><br>
    Aanbieding weghalen <input style="width: 200px;" type="text" name="AanbiedingWeghalen"><br>
    <input style="width: 200px;" type="submit" name="AanbiedingSubmit" value="Aanbieding toevoegen">
    <input style="width: 200px;" type="submit" name="AanbiedingWeghalenSubmit" value="Aanbieding weghalen">
</form><br><br><br>
<form method="post" action="index.php">
    <input style="width: 200px;" type="submit" name="NaarAanbiedingen" value="Naar aanbiedingen gaan">
</form>
</body>
</html>

<?php
if(isset($_POST["AanbiedingSubmit"])) {
    $stockitemid = $_POST["AanbiedingToevoegen"];
    $korting = $_POST["Korting"];

    $query = "SELECT StockItemID FROM aanbevolen WHERE StockItemID = " . $stockitemid;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    if (!empty($row)) {
        print("Dit item is al een aanbieding!");
    } else {

        $query = "SELECT StockItemID FROM stockitems WHERE StockItemID = " . $stockitemid;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if (empty($row)) {
            print("Dit item bestaat niet!");
        } else {
            if ($korting > 100 || $korting <= 0) {
                print("De korting moet tussen 1 en 100 zijn!");
            } else {
                $query = mysqli_prepare($connection, "INSERT INTO Aanbevolen (StockItemID, Korting) VALUES (?, ?)");
                mysqli_stmt_bind_param($query, 'ii', $stockitemid, $korting);
                mysqli_stmt_execute($query);
                print("Het item is toegevoegd aan aanbiedingen!");
            }
        }
    }
}

if(isset($_POST["AanbiedingWeghalenSubmit"])) {
    $stockitemid = $_POST["AanbiedingWeghalen"];

    $query = "SELECT StockItemID FROM stockitems WHERE StockItemID = " . $stockitemid;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (empty($row)) {
        print("Dit item bestaat niet!");
    } else {
        $query = mysqli_prepare($connection, "DELETE FROM Aanbevolen WHERE StockItemID = " . $stockitemid);
        mysqli_stmt_execute($query);
        print("Product is verwijderd van aanbiedingen!");
    }
}
?>