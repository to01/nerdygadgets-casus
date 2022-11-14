<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Klantenoverzicht</title></head>
<body>
<?php include 'klantfuncties.php'; $klanten = alleKlantenOpvragen(); include 'header.php';?>
<h1>Klanten overzicht</h1>
<br>
<p><a href="toevoegenklant.php">Nieuwe klant toevoegen</a></p>
<table>
  <thead >
  <tr><th>Nr</th><th>Naam</th><th>Woonplaats</th><th></th><th></th></tr>
  </thead>
  <tbody>
  <?php toonKlantenOpHetScherm($klanten); ?>
  </tbody>
</table>
</body>
</html>