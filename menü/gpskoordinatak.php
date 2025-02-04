<?php


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $szoveg1 = $_POST['szoveg1'];
        $szoveg2 = $_POST['szoveg2'];
        $tomb = array($szoveg1, $szoveg2);
        $koordinatak = array();
        for (i = 0; i <= $tomb.count(); i++){
            $url = "https://nominatim.openstreetmap.org/search?q=" . $tomb[i] . "=&format=json";
    
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
    
            $json = curl_exec($ch);
            curl_close($ch);
            $adat = json_decode( $json );
            $lat = $adat[1]->lat;
            $lon = $adat[1]->lon;
            koordinatak.add();

        }


        

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