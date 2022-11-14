<!DOCTYPE html>
<html lang="nl">
<head><meta charset="UTF-8"><title>Klant bewerken</title></head>
<body>
<?php
include 'klantfuncties.php';
$gegevens["nummer"] = isset($_GET["nummer"]) ? $_GET["nummer"] : 0;
if (isset($_GET["bewerken"])) {
    $gegevens["naam"] = isset($_GET["naam"]) ? $_GET["naam"] : "";
    $gegevens["woonplaats"] = isset($_GET["woonplaats"]) ? $_GET["woonplaats"] : "";
    $gegevens = klantGegevensBewerken($gegevens);
}
?>

<h1>Klant bewerken</h1><br><br>
<form method="get" action="BewerkenKlant.php">
    <label>Naam</label>
    <input type="text" name="naam" value="<?php print($gegevens["naam"]); ?>" />
    <label>Woonplaats</label>
    <input type="text" name="woonplaats" value="<?php print($gegevens["woonplaats"]); ?>" />
    <label>Nummer</label>
    <input tupe="number" name="nummer" value="<?php print($gegevens["nummer"]); ?>">
    <input type="submit" name="bewerken" value="Bewerken" />
</form>
<br><?php print($gegevens["melding"]); ?><br>
<a href="bekijkenoverzicht.php">Terug naar het overzicht</a>
</body>
</html>