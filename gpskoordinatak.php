<?php


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $szoveg1 = $_POST['szoveg1'];

        $api1 = "https://nominatim.openstreetmap.org/search?q=" . $szoveg1 . "=&format=json";
        echo $api1;
        

    }




// $adatok = file_get_contents("https://nominatim.openstreetmap.org/search?q=&format=json");
// $adat = json_decode($adatok, true);


?>

<form method="post" action="gpskoordinatak.php">
    <label for='Adj meg egy helyet'>Adj meg egy helyet: </label>
    <input type='text' name='szoveg1' id='szoveg1'>
    <br>
    <br>
    <label for='Adj meg egy másik helyet'>Adj meg egy másik helyet: </label>
    <input type='text' name='szoveg2' id='szoveg2'>
    <br>
    <input type="submit" value="Küldés">
</form>