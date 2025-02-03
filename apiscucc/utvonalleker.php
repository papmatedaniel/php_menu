<?php
    function keres_json_utvonal($json_obj, $keresett_kulcs, $utvonal = "")
    {
        if (is_array($json_obj) || is_object($json_obj)) {
            foreach ($json_obj as $kulcs => $ertek) {
                // Ha a kulcs egy szám (listában van), akkor szögletes zárójeles indexet használunk
                $uj_utvonal = is_numeric($kulcs) ? "{$utvonal}[{$kulcs}]" : "{$utvonal}['{$kulcs}']";

                // Ha megtaláltuk a keresett kulcsot
                if ($kulcs === $keresett_kulcs) {
                    return $uj_utvonal;
                }

                // Rekurzív keresés
                $eredmeny = keres_json_utvonal($ertek, $keresett_kulcs, $uj_utvonal);
                if ($eredmeny) {
                    return $eredmeny;
                }
            }
        }
        return null;
    }

    // $adatok = file_get_contents("https://randomuser.me/api/");
    // $adat = json_decode($adatok, true);
?>