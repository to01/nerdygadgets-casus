<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Klant toevoegen</title></head>
<body>
<?php
include 'klantfuncties.php';
include 'header.php'; // voegt de standaard header toe, dit is niet nodig maar het ziet er goed uit
if (isset($_GET["toevoegen"])) { // dit checkt of de submit knop ingetikt is
    $gegevens["naam"] = isset($_GET["naam"]) ? $_GET["naam"] : "";
    $gegevens["woonplaats"] = isset($_GET["woonplaats"]) ? $_GET["woonplaats"] : "";
    $gegevens = klantGegevensToevoegen($gegevens);
}
?>
// html code bevind zich hieronder
<h1>Klant toevoegen</h1><br><br>
<form method="get" action="toevoegenklant.php">
    <label>Naam</label>
    <input type="text" name="naam" value="<?php print($gegevens["naam"]); ?>" />
    <label>Woonplaats</label>
    <input type="text" name="woonplaats" value="<?php print($gegevens["woonplaats"]); ?>" />
    <input type="submit" name="toevoegen" value="Toevoegen" />
</form>
<br><?php print($gegevens["melding"]); ?><br> <!-- print de melding: "De klant is toegevoegd" of "Het toevoegen is mislukt" -->
<a href="bekijkenoverzicht.php">Terug naar het overzicht</a> <!-- link naar het overzicht -->
</body>
</html>