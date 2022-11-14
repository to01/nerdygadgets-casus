<?php
include "databasefuncties.php";
$gegevens = array("nummer" => 0, "naam" => "", "woonplaats" => "", "melding" => "");
function alleKlantenOpvragen() {
    $connection = maakVerbinding();
    $klanten = selecteerKlanten($connection);
    sluitVerbinding($connection);
    return $klanten;
}
function toonKlantenOpHetScherm($klanten) {
    foreach ($klanten as $klant) {
        print("<tr>");
        print("<td>".$klant["nummer"]."</td>");
        print("<td>".$klant["naam"]."</td>");
        print("<td>".$klant["woonplaats"]."</td>");
        print("<td><a href=\"BewerkenKlant.php?nummer=".$klant["nummer"]."\">Bewerk</a></td>");
        print("<td><a href=\"VerwijderenKlant.php?nummer=".$klant["nummer"]."\">Verwijder</a></td>");
        print("</tr>");
    }
}
function voegKlantToe($connection, $naam, $woonplaats) {
    $statement = mysqli_prepare($connection, "INSERT INTO klant (naam, woonplaats) VALUES(?,?)");
    mysqli_stmt_bind_param($statement, 'ss', $naam, $woonplaats);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}
function klantGegevensToevoegen($gegevens) {
    $connection = maakVerbinding();
    if (voegKlantToe($connection, $gegevens["naam"], $gegevens["woonplaats"]) == True) {
        $gegevens["melding"] = "De klant is toegevoegd";
    } else {
        $gegevens["melding"] = "Het toevoegen is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}
function pasKlantAan($connection, $naam, $woonplaats, $nummer) {
    $statement = mysqli_prepare($connection, "UPDATE klantenservice.klant SET naam = ?, woonplaats = ? WHERE nummer = ?");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $woonplaats, $nummer);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}
function klantGegevensBewerken($gegevens) {
    $connection = maakVerbinding();
    if (pasKlantAan($connection, $gegevens["naam"], $gegevens["woonplaats"], $gegevens["nummer"])) {
        $gegevens["melding"] = "De klant is bewerkt";
    } else {
        $gegevens["melding"] = "Het bewerken is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}