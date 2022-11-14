<?php
function maakVerbinding() { // maakt verbinding met de database
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $databasename = "Klantenservice";
    $connection = mysqli_connect($host, $user, $pass, $databasename);
    return $connection;
}
function selecteerKlanten($connection) { // selecteert nummer, naam en woonplaats van alle klanten
    $sql = "SELECT nummer, naam, woonplaats FROM klant ORDER BY naam";
    $result = mysqli_fetch_all(mysqli_query($connection, $sql),MYSQLI_ASSOC);
    return $result;
}
function sluitVerbinding($connection) { // sluit de verbinding met SQL
    mysqli_close($connection);
}