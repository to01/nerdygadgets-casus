<?php
include "header.php";
include "cartfuncties.php";
include "ISO codes.php";
$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databasename = "nerdygadgets";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databasename, $port);
$cart = getCart();
$bedrijfsnaam = "";
$naam = "";
$email = "";
$land = ' value="NAN">Kies een land';
$woonplaats = "";
$adres = "";
$postcode = "";
$telefoonnummer = "";
$telefooncode = "";
$status = "";
$iso_array = isocodes();
if(isset($_SESSION["WebCustomerID"])) {
    $query = "SELECT * FROM webshopklant WHERE WebCustomerID = " . $_SESSION["WebCustomerID"];
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $telarray = explode("-",$row[6]);
    $phonecode = $telarray[0];
    $phonenumber = $telarray[1];
    $naam = 'value="'.$row[1].'" disabled';
    $email = 'value="'.$row[7].'" disabled';
    $land = ' value="'.$row[2].'">'.$iso_array[$row[2]];
    $woonplaats = 'value="'.$row[3].'" disabled';
    $adres = 'value="'.$row[4].'" disabled';
    $postcode = 'value="'.$row[5].'" disabled';
    $telefooncode = 'value="'.$phonecode.'" disabled';
    $telefoonnummer = 'value="'.$phonenumber.'" disabled';
    $status = "disabled";
    $loginland = $row[2];
    $logincity = $row[3];
    $loginadres = $row[4];
    $loginpostcode = $row[5];
    $marketingemail = $row[7];
    $customername = $row[1];
}
?>
    <h1 class="TextMain" style="margin-left: 5px; margin-top: 5px">Bestellen </h1>
    <form method="post">
        <table>
            <script type="text/javascript">
                function ShowHideDiv() {
                    var zakelijk = document.getElementById("zakelijk");
                    var bedrijfnaam = document.getElementById("bedrijfnaam");
                    bedrijfnaam.style.display = zakelijk.checked ? "block" : "none";
                }
            </script>
            <tr> <!-- Radio -->
                <td style="width: 160px"></td>
                <td>Particulier:</td>
                <td><input style="height: 10%" type="radio" id="particulier" name="besteller" value="0" checked required onload="ShowHideDiv()" onclick="ShowHideDiv()" ></td>
                <td>Zakelijk:</td>
                <td><input style="height: 10%" type="radio" id="zakelijk" name="besteller" value="1" onclick="ShowHideDiv()"></td>
            </tr>
        </table>
        <div id="bedrijfnaam" style="display: none" >
            <table style="margin-left: 35px">
                <tr> <!--bedrijfsnaam -->
                    <td>* Bedrijfsnaam:</td>
                    <td><input style="height: 10%; background-color:#23232F; color: white; border-color:#676EFF" name="BedrijfsNaam" id="Bedrijfsnaam" type="text" <?php if(isset($_POST['besteller'])) { if($_POST['besteller']=='1'){ ?> required <?php }} ?></td>
                </tr>
            </table>
        </div>
        <table>
            <tr> <!--naam -->
                <td><div style="text-align: right">* Naam:</div></td>
                <td><input style="height: 10%; background-color:#23232F; color: white; border-color:#676EFF" name="BestelNaam" type="text" <?php print($naam); ?> required></td>
            </tr>
            <tr> <!--e-mail -->
                <td><div style="text-align: right; width: 140px">* E-mail:</div></td>
                <td><input style="height: 10%; background-color:#23232F; color: white; border-color:#676EFF" name="E-mail" <?php print($email); ?> placeholder="example@gmail.com" type="email" required></td>
            </tr>
        </table>
        <table>
            <tr> <!--Land -->
                <td><div style="text-align: right; width: 140px">* Land:</div></td>
                <td><select name="Land" style="height: 7%; width: 55%;background-color:#23232F; color: white; border-color:#676EFF"<?php print($status) ?>><option<?php print($land) ?></option><option value="NLD">Netherlands</option><option value="AFG">Afghanistan</option><option value="ALA">Åland Islands</option><option value="ALB">Albania</option><option value="DZA">Algeria</option><option value="ASM">American Samoa</option><option value="AND">Andorra</option><option value="AGO">Angola</option><option value="AIA">Anguilla</option><option value="ATA">Antarctica</option><option value="ATG">Antigua and Barbuda</option><option value="ARG">Argentina</option><option value="ARM">Armenia</option><option value="ABW">Aruba</option><option value="AUS">Australia</option><option value="AUT">Austria</option><option value="AZE">Azerbaijan</option><option value="BHS">Bahamas</option><option value="BHR">Bahrain</option><option value="BGD">Bangladesh</option><option value="BRB">Barbados</option><option value="BLR">Belarus</option><option value="BEL">Belgium</option><option value="BLZ">Belize</option><option value="BEN">Benin</option><option value="BMU">Bermuda</option><option value="BTN">Bhutan</option><option value="BOL">Bolivia, Plurinational State of</option><option value="BES">Bonaire, Sint Eustatius and Saba</option><option value="BIH">Bosnia and Herzegovina</option><option value="BWA">Botswana</option><option value="BVT">Bouvet Island</option><option value="BRA">Brazil</option><option value="IOT">British Indian Ocean Territory</option><option value="BRN">Brunei Darussalam</option><option value="BGR">Bulgaria</option><option value="BFA">Burkina Faso</option><option value="BDI">Burundi</option><option value="KHM">Cambodia</option><option value="CMR">Cameroon</option><option value="CAN">Canada</option><option value="CPV">Cape Verde</option><option value="CYM">Cayman Islands</option><option value="CAF">Central African Republic</option><option value="TCD">Chad</option><option value="CHL">Chile</option><option value="CHN">China</option><option value="CXR">Christmas Island</option><option value="CCK">Cocos (Keeling) Islands</option><option value="COL">Colombia</option><option value="COM">Comoros</option><option value="COG">Congo</option><option value="COD">Congo, the Democratic Republic of the</option><option value="COK">Cook Islands</option><option value="CRI">Costa Rica</option><option value="CIV">Côte d'Ivoire</option><option value="HRV">Croatia</option><option value="CUB">Cuba</option><option value="CUW">Curaçao</option><option value="CYP">Cyprus</option><option value="CZE">Czech Republic</option><option value="DNK">Denmark</option><option value="DJI">Djibouti</option><option value="DMA">Dominica</option><option value="DOM">Dominican Republic</option><option value="ECU">Ecuador</option><option value="EGY">Egypt</option><option value="SLV">El Salvador</option><option value="GNQ">Equatorial Guinea</option><option value="ERI">Eritrea</option><option value="EST">Estonia</option><option value="ETH">Ethiopia</option><option value="FLK">Falkland Islands (Malvinas)</option><option value="FRO">Faroe Islands</option><option value="FJI">Fiji</option><option value="FIN">Finland</option><option value="FRA">France</option><option value="GUF">French Guiana</option><option value="PYF">French Polynesia</option><option value="ATF">French Southern Territories</option><option value="GAB">Gabon</option><option value="GMB">Gambia</option><option value="GEO">Georgia</option><option value="DEU">Germany</option><option value="GHA">Ghana</option><option value="GIB">Gibraltar</option><option value="GRC">Greece</option><option value="GRL">Greenland</option><option value="GRD">Grenada</option><option value="GLP">Guadeloupe</option><option value="GUM">Guam</option><option value="GTM">Guatemala</option><option value="GGY">Guernsey</option><option value="GIN">Guinea</option><option value="GNB">Guinea-Bissau</option><option value="GUY">Guyana</option><option value="HTI">Haiti</option><option value="HMD">Heard Island and McDonald Islands</option><option value="VAT">Holy See (Vatican City State)</option><option value="HND">Honduras</option><option value="HKG">Hong Kong</option><option value="HUN">Hungary</option><option value="ISL">Iceland</option><option value="IND">India</option><option value="IDN">Indonesia</option><option value="IRN">Iran, Islamic Republic of</option><option value="IRQ">Iraq</option><option value="IRL">Ireland</option><option value="IMN">Isle of Man</option><option value="ISR">Israel</option><option value="ITA">Italy</option><option value="JAM">Jamaica</option><option value="JPN">Japan</option><option value="JEY">Jersey</option><option value="JOR">Jordan</option><option value="KAZ">Kazakhstan</option><option value="KEN">Kenya</option><option value="KIR">Kiribati</option><option value="PRK">Korea, Democratic People's Republic of</option><option value="KOR">Korea, Republic of</option><option value="KWT">Kuwait</option><option value="KGZ">Kyrgyzstan</option><option value="LAO">Lao People's Democratic Republic</option><option value="LVA">Latvia</option><option value="LBN">Lebanon</option><option value="LSO">Lesotho</option><option value="LBR">Liberia</option><option value="LBY">Libya</option><option value="LIE">Liechtenstein</option><option value="LTU">Lithuania</option><option value="LUX">Luxembourg</option><option value="MAC">Macao</option><option value="MKD">Macedonia, the former Yugoslav Republic of</option><option value="MDG">Madagascar</option><option value="MWI">Malawi</option><option value="MYS">Malaysia</option><option value="MDV">Maldives</option><option value="MLI">Mali</option><option value="MLT">Malta</option><option value="MHL">Marshall Islands</option><option value="MTQ">Martinique</option><option value="MRT">Mauritania</option><option value="MUS">Mauritius</option><option value="MYT">Mayotte</option><option value="MEX">Mexico</option><option value="FSM">Micronesia, Federated States of</option><option value="MDA">Moldova, Republic of</option><option value="MCO">Monaco</option><option value="MNG">Mongolia</option><option value="MNE">Montenegro</option><option value="MSR">Montserrat</option><option value="MAR">Morocco</option><option value="MOZ">Mozambique</option><option value="MMR">Myanmar</option><option value="NAM">Namibia</option><option value="NRU">Nauru</option><option value="NPL">Nepal</option><option value="NLD">Netherlands</option><option value="NCL">New Caledonia</option><option value="NZL">New Zealand</option><option value="NIC">Nicaragua</option><option value="NER">Niger</option><option value="NGA">Nigeria</option><option value="NIU">Niue</option><option value="NFK">Norfolk Island</option><option value="MNP">Northern Mariana Islands</option><option value="NOR">Norway</option><option value="OMN">Oman</option><option value="PAK">Pakistan</option><option value="PLW">Palau</option><option value="PSE">Palestinian Territory, Occupied</option><option value="PAN">Panama</option><option value="PNG">Papua New Guinea</option><option value="PRY">Paraguay</option><option value="PER">Peru</option><option value="PHL">Philippines</option><option value="PCN">Pitcairn</option><option value="POL">Poland</option><option value="PRT">Portugal</option><option value="PRI">Puerto Rico</option><option value="QAT">Qatar</option><option value="REU">Réunion</option><option value="ROU">Romania</option><option value="RUS">Russian Federation</option><option value="RWA">Rwanda</option><option value="BLM">Saint Barthélemy</option><option value="SHN">Saint Helena, Ascension and Tristan da Cunha</option><option value="KNA">Saint Kitts and Nevis</option><option value="LCA">Saint Lucia</option><option value="MAF">Saint Martin (French part)</option><option value="SPM">Saint Pierre and Miquelon</option><option value="VCT">Saint Vincent and the Grenadines</option><option value="WSM">Samoa</option><option value="SMR">San Marino</option><option value="STP">Sao Tome and Principe</option><option value="SAU">Saudi Arabia</option><option value="SEN">Senegal</option><option value="SRB">Serbia</option><option value="SYC">Seychelles</option><option value="SLE">Sierra Leone</option><option value="SGP">Singapore</option><option value="SXM">Sint Maarten (Dutch part)</option><option value="SVK">Slovakia</option><option value="SVN">Slovenia</option><option value="SLB">Solomon Islands</option><option value="SOM">Somalia</option><option value="ZAF">South Africa</option><option value="SGS">South Georgia and the South Sandwich Islands</option><option value="SSD">South Sudan</option><option value="ESP">Spain</option><option value="LKA">Sri Lanka</option><option value="SDN">Sudan</option><option value="SUR">Suriname</option><option value="SJM">Svalbard and Jan Mayen</option><option value="SWZ">Swaziland</option><option value="SWE">Sweden</option><option value="CHE">Switzerland</option><option value="SYR">Syrian Arab Republic</option><option value="TWN">Taiwan, Province of China</option><option value="TJK">Tajikistan</option><option value="TZA">Tanzania, United Republic of</option><option value="THA">Thailand</option><option value="TLS">Timor-Leste</option><option value="TGO">Togo</option><option value="TKL">Tokelau</option><option value="TON">Tonga</option><option value="TTO">Trinidad and Tobago</option><option value="TUN">Tunisia</option><option value="TUR">Turkey</option><option value="TKM">Turkmenistan</option><option value="TCA">Turks and Caicos Islands</option><option value="TUV">Tuvalu</option><option value="UGA">Uganda</option><option value="UKR">Ukraine</option><option value="ARE">United Arab Emirates</option><option value="GBR">United Kingdom</option><option value="USA">United States</option><option value="UMI">United States Minor Outlying Islands</option><option value="URY">Uruguay</option><option value="UZB">Uzbekistan</option><option value="VUT">Vanuatu</option><option value="VEN">Venezuela, Bolivarian Republic of</option><option value="VNM">Viet Nam</option><option value="VGB">Virgin Islands, British</option><option value="VIR">Virgin Islands, U.S.</option><option value="WLF">Wallis and Futuna</option><option value="ESH">Western Sahara</option><option value="YEM">Yemen</option><option value="ZMB">Zambia</option><option value="ZWE">Zimbabwe</option>
                    </select ></td>
            </tr>
        </table>
        <table>
            <tr> <!--woonplaats -->
                <td><div style="text-align: right">* Woonplaats: </div></td>
                <td><input style="height: 10%; background-color:#23232F; color: white; border-color:#676EFF" name="Woonplaats" <?php print($woonplaats); ?> placeholder="Amsterdam" type="text" required></td>
            </tr>
            <tr> <!-- adres -->
                <td><div style="text-align: right">* Adres:</div></td>
                <td><input style="height: 10%; background-color:#23232F; color: white; border-color:#676EFF" name="BestelAdres" <?php print($adres); ?> placeholder="Straatnaam 123" type="text" required></td>
            </tr>
            <tr> <!-- postcode -->
                <td><div style="text-align: right; width:140px">* Postcode:</div></td>
                <td><input style="height: 10%; background-color:#23232F; color: white; border-color:#676EFF" name="BestelPostcode" <?php print($postcode); ?> type="text" placeholder="1234 AB" required pattern="[0-9]{4}[A-Z]{2}|[0-9]{4} [A-Z]{2}"></td>
            </tr>
        </table>
        <table>
            <tr> <!-- telefoonnummer -->
                <td><div style="text-align: right; width: 140px">* Telefoonnummer:</div></td>
                <td><input style="height: 10%; width: 60px; background-color:#23232F; color: white; border-color:#676EFF" type="text" id="phone" name="phonecode" <?php print($telefooncode); ?> placeholder="+31" maxlength="4" pattern="+[0,9]{2,3}\[0,9]{2,3}" required></td>
                <td><input style="height: 10%; width: 125px;background-color:#23232F; color: white; border-color:#676EFF" type="tel" id="phone" placeholder="06 12345678" name="phone" <?php print($telefoonnummer); ?> minlength="10" maxlength="15" pattern="[0-9]{8,15}\[0-9]{8,15}\[0-6]{1,2} [0-9]{8,15}" required></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 160px"></td>
                <td><input style="height: 10%; width: 204.8px; background-color:#23232F; color: white; border-color:#676EFF"<?php if(empty($cart)) {print(' disabled="disabled"');} ?> type="submit" name="BestelSubmit" value="Bestellen" onclick="return confirm('Zijn alle gegevens goed ingevuld en gecontroleerd?')"></td>
            </tr>
        </table>
    </form>
<?php
$cart = getCart();
$totaalprijs = 0;
foreach($cart as $id => $hoeveelheid) {
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
        $korting = "";
    } else {
        $korting = $row[0];
    }

    $query = "SELECT (RecommendedRetailPrice * (1+(TaxRate/100))) FROM stockitems WHERE StockItemID = " . $id;
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $prijs = $row[0];

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
    ?>
    <td style='width:40%'>
        <a class='CartName' href='view.php?id=<?php ".$id." ?>'> <?php print($name) ?></a>
        <!--    <h3 class='CartAmount'>hoeveelheid: ".$hoeveelheid."</h3>-->
        <br>
        <h2 class='CartId nobreak'>Artikelnummer: <?php print($id) ?></h2>
    </td>
    <form method='post'>
        <td style='width:10%'>
            <h3> Aantal: <?php print($hoeveelheid) ?></h3>
        </td>
        <td>
            <h4 class='StockItemPriceText'> <?php print(sprintf("€ %.2f", $prijs1)) ?></h4>
            <h4 class='CartId'> <?php print(sprintf("€ %.2f", $prijs)) ?> per stuk</h4>
            <h4 style='font-size: 1rem'>Inclusief BTW</h4>
        </td>
        <?php
        if($korting != ""){
            ?>
            <td>
                <h5 style="color: gold">Korting: <?php print($korting)?>%</h5>
            </td>
            <?php
        }
        ?>
        <body>
        <hr style='background-color: #676EFF'>
        </body>
    </form>
    </table>

    <?php

date_default_timezone_set('Europe/Amsterdam');
if(empty($cart)) {print("<h1 style='color: red'>Uw winkelwagen is nog leeg!</h1>");} // checkt of de winkelwagen leeg is en als dit het geval is print het text uit en stopt het je van bestellen
else {
if(isset($_POST["BestelSubmit"])) { // if submit is pressed
    if ($_SESSION["inlogstatus"] == True) { // if logged in
        $id = $_SESSION["WebCustomerID"];
        $query = "SELECT * FROM webshopklant WHERE WebCustomerID = ".$id; // select all customer data
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $sqlemail = $row[6]; // email belonging to customerID
        $date = date("Y-m-d"); // sets date in the format of MYSQL
        $business = $_POST["besteller"]; // checks if customer is a business or a person
        $WebOrderBusiness = $_POST["BedrijfNaam"];
        $WebOrderPostalcode = $loginpostcode;
        $WebOrderCity = $logincity;
        $WebOrderAdress = $loginadres;
        $WebOrderCountry = $loginland;
        $OrderTotalPrice = $totaalprijs;
        $query = "INSERT INTO webshoporders VALUES ((SELECT max(WebOrderID)+1 FROM webshoporders w)," . $id . ",'" . $date . "'," . $business . ",'" . $WebOrderCountry ."','" . $WebOrderAdress ."','" . $WebOrderPostalcode ."')"; // creates new order for customer
        $result = mysqli_query($connection, $query);
        $query = "SELECT MAX(weborderid) FROM webshoporders"; // gets orderid to fill orderlines later
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $orderid = $row[0];
        foreach($cart as $id => $hoeveelheid) {
            $query = "INSERT INTO weborderlines VALUES ((SELECT MAX(OrderLineID)+1 FROM weborderlines w),".$orderid.",".$id.",".$hoeveelheid.")";
            $result = mysqli_query($connection, $query);
        }
        print("<script> 
        window.onload = function(){
        window.open('https://www.ideal.nl/demo/qr/?app=ideal', '_blank'); // will open new tab on window.onload
        }
        </script><meta http-equiv='refresh' content='1; url=.'>"); // javascript to open payment page in new tab
    } else { // if not logged in
        // maakt nieuwe klant aan
        $naam = $_POST["BestelNaam"];
        $email = $_POST["E-mail"];
        $land = $_POST["Land"];
        $adres = str_replace(" ","",$_POST["BestelAdres"]);
        $postcode = str_replace(" ","",$_POST["BestelPostcode"]);
        $tel = str_replace(" ","",$_POST["phonecode"]."-".$_POST["phone"]);
        $query = "SELECT CustomerEmail FROM webshopklant WHERE CustomerEmail = '" . $email . "' AND isloggable = 1";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        if (isset($row[0])) {
            print("<br><h5 style='color:red'> &nbsp Deze e-mail heeft al een account!</h5>");
        } else {
        $query = "INSERT INTO webshopklant VALUES ((SELECT max(WebCustomerID)+1 FROM webshopklant w),'".$naam."','".$land."','".$adres."','".$postcode."','".$tel."','".$email."',0,0)";
        $result = mysqli_query($connection, $query);
        // haalt ID van nieuwe klant op
        $query = "SELECT WebCustomerID FROM webshopklant WHERE WebCustomerID = (SELECT MAX(WebCustomerID) FROM webshopklant w)";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $id = $row[0];
        $date = date("Y-m-d");
        $business = $_POST["besteller"];
        $WebOrderPostalcode = $_POST["BestelPostcode"];
        $WebOrderAdress = $_POST["BestelAdres"];
        $WebOrderCountry = $_POST["Land"];
        $query = "INSERT INTO webshoporders VALUES ((SELECT max(WebOrderID)+1 FROM webshoporders w)," . $id . ",'" . $date . "'," . $business . ",'" . $WebOrderCountry ."','" . $WebOrderAdress ."','" . $WebOrderPostalcode ."')"; // creates new order for customer
        $result = mysqli_query($connection, $query);
        $query = "SELECT MAX(weborderid) FROM webshoporders"; // gets orderid to fill orderlines later
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $orderid = $row[0];
        foreach($cart as $id => $hoeveelheid) {
            $query = "INSERT INTO weborderlines VALUES ((SELECT MAX(OrderLineID)+1 FROM weborderlines w),".$orderid.",".$id.",".$hoeveelheid.")";
            $result = mysqli_query($connection, $query);
        }
        }
        print("<script> 
        window.onload = function(){
        window.open('https://www.ideal.nl/demo/qr/?app=ideal', '_blank'); // will open new tab on window.onload
        }
        </script><meta http-equiv='refresh' content='1; url=.'>");
    }
}}
?>
<br>
    <head>
        <meta charset="UTF-8">
        <title>Winkelwagen</title>
    </head>
    <body>
    <h1 class="CartHeader">Overzicht Winkelwagen</h1>
    <hr style="background-color:#676EFF">
    </body>
<?php


if(empty($customername)) {
    $customername = $naam;
}
if(empty($marketingemail)) {
    $marketingemail = $email;
}
$message = "
        <body>
            <p>Geachte $customername<br><br>Uw bestelling is aangekomen,<br>hieronder staat een overzicht van uw bestelling</p><br>
            <table style='width: 1000px'>
            <tr style='text-align:left;'>
               <th>Artikelnummer</th><th>Productnaam</th><th>Aantal</th><th>Prijs/stuk</th><th>Subtotaal</th>
            </tr><br>
            ";
$totaalprijs=0;
if(isset($_POST["BestelSubmit"])){
    foreach($cart as $id => $hoeveelheid) {
        // Multiple recipients
        $to = $marketingemail; // note the comma
        // Subject
        $subject = 'Bestelling NerdyGadgets';
        // Message
        $query = "SELECT StockItemName FROM stockitems WHERE StockItemID = ".$id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $name = $row[0];
        $query = "SELECT (RecommendedRetailPrice * (1+(TaxRate/100))) FROM stockitems WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_row($result);
        $prijs = $row[0];
        $prijs1 = $prijs * $hoeveelheid;
        $totaalprijs += $prijs1;
        $message .= "
            <tr>
               <td class='CartId nobreak'>".$id."</td><td>$name</td><td>$hoeveelheid</td><td class='CartId'>" . sprintf("€ %.2f", $prijs) . "</td><td class='StockItemPriceText'>" . sprintf("€ %.2f", $prijs1) . "</td>
            </tr>
        ";
        // To send HTML mail, the Content-type header must be set
        $query = "
                UPDATE stockitemholdings
                SET QuantityOnHand = (QuantityOnHand - " . $hoeveelheid . ")  
                WHERE StockItemID = " . $id;
        $result = mysqli_query($connection, $query);
        deleteProductFromCart($id);
    }
    $query = "SELECT MAX(WebOrderID) FROM webshoporders";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $ordernummer = $row[0];
    $message .= "
                <br><br>
                <tr>
                    <td>Ordernummer: $ordernummer</td><td> </td><td> </td><td> </td> <td class='StockItemPriceText'>Totaal: " . sprintf("€ %.2f", $totaalprijs) . "</td></td>
                </tr>
            </table>
            <br><br><p>Met vriendelijke groeten,<br>NerdyGadgets<br>---------------------------<br>+31 0612345678<br>NerdyGadgets@gmail.com<br></p>
        </body>";
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    // Mail it
    mail($to, $subject, $message, implode("\r\n", $headers));

    print("<meta http-equiv='refresh' content='0; url=.'>");
}}