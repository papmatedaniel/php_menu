<p>Kutya<p>
<?php
    for ($i = 0; $i < 5; $i++) {
        $djasooon = file_get_contents("https://dog.ceo/api/breeds/image/random");
        $dekodolt = json_decode($djasooon, true);
        $keplink = $dekodolt['message'];
        print '<img src="' . $keplink . '" width="250px;" height="250px;">';
    }
?>


