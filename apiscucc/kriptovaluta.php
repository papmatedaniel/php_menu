<?php

    function atvaltas($egyik, $masik){

        if ($egyik > $masik) {
            return $egyik / $masik;
        } else {
            return $masik / $egyik;
        }
    }


    $adatok = file_get_contents("https://api.coingecko.com/api/v3/exchange_rates");
    $adat = json_decode($adatok, true);
    $forint = $adat['rates']['huf']['value'];
    $euro = $adat['rates']['eur']['value'];
    $dollar = $adat['rates']['usd']['value'];
    $font = $adat['rates']['gbp']['value'];
    $frank = $adat['rates']['chf']['value'];
    $jen = $adat['rates']['jpy']['value'];
    $korona = $adat['rates']['czk']['value'];
    $zloty = $adat['rates']['pln']['value'];

    echo "<h1> Időpont: " . date("Y-m-d H:i:s") . "</h1>";
    echo "
            <table border='1'>
                <thead>
                    <tr>
                        <th>Valuta</th>
                        <th>Forint</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Euro</td>
                        <td>" . atvaltas($forint, $euro) . "</td>
                    </tr>
                    <tr>
                        <td>Usadollár</td>
                        <td>" . atvaltas($forint, $dollar) . "</td>
                    </tr>
                    <tr>
                        <td>Angol font</td>
                        <td>" . atvaltas($forint, $font) . "</td>
                    </tr>
                    <tr>
                        <td>Svájci Frank</td>
                        <td>" . atvaltas($forint, $frank) . "</td>
                    </tr>
                    <tr>
                        <td>Japán Jen</td>
                        <td>" . atvaltas($forint, $jen) . "</td>
                    </tr>
                    <tr>
                        <td>Cseh Korona</td>
                        <td>" . atvaltas($forint, $korona) ."</td>
                    </tr>
                    <tr>
                        <td>Lengyel Zloty</td>
                        <td>" . atvaltas($forint, $zloty) ."</td>
                    </tr>

                </tbody>
    ";
?>