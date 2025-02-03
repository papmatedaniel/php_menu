<?php
for ($i = 0; $i < 6; $i++) {
    $adatok = file_get_contents("https://dog.ceo/api/breeds/image/random");
    $adat = json_decode($adatok, true);
    echo "<image src='".$adat['message']."' width='300' height='300'>";
}

?>

