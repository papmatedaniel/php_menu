<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menü</title>
</head>
<style>
    body{
        margin: 0;
        font-family: Arial;
        font-size: 20px;
    }
    div#menu{
        background-color: lightgrey;
        text-align: center;
    }
    div#menu a{
        width: 120px;
        display: inline-block;
        text-decoration: none;
        color: #666;
        text-align: center;
    }
    div#menu a:hover{
        color: #000;
        background-color: #ddd;
    }
    div#tartalom{
        margin-left: 200px;
        min-height: 480px;
    }
    div#lablec{
        background-color: #000;
        color: #fff;
    }
    form.szavazodoboz{
        height: 200px;
        width: 600px;
        margin-top: 100px;
        left: 50%;
        padding: 20px;
        border: 1px solid #000;
        background-color: lightgreen;
        border-radius: 7px;
    }
    span#elso{
        width: $bab/$ossz*100 *2px;
        height: 10px;
        background-color: blue;
    }
    span#masodik{
        width: $gulyas/$ossz*100 *2px;
        height: 10px;
        background-color: blue;
    }
    span#harmadik{
        width: $para/$ossz*100 *2px;
        height: 10px;
        background-color: blue;
    }
    span#negyedik{
        width: $tojas/$ossz*100 *2px;
        height: 10px;
        background-color: blue;
    }
    form.kommentdoboz{
        background: linear-gradient(45deg, #aa7722, #721149);
        color: #fff;
        width: 400px;
        height: 300px;
        margin: 70px;
        padding: 20px;
        border-radius: 7px;
    }
    form input{
        border-radius: 5px;
        border: none;
        height: 15px;
        padding: 10px;
        float: right;
        margin-right: 10px;
    }
    form input[type='submit']{
        background-color: green;
        color: #fff;
        height: 50px;
        width: 100px;
        font-size: 20px;
        border-radius: 7px;
    }
    form input[type='submit']:hover{
        background-color: #4b6f44;
    }
    
</style>
<body>
    <div id='menu'>
        [
        <a href='./'>Kezdőlap</a>            |
        <a href='./?p=termekek'>Termékek</a> |
        <a href='./?p=help'>Segítség</a>     |
        <a href='./?p=gyik'>GY.I.K</a>       |
        <a href='./?p=rolunk'>Rólunk</a>     |
        <a href='./?p=szavazas'>Szavazás</a> |
        <a href='./?p=vendegkonyv'>Vendégkönyv</a> |


        ]
    </div>
    <div id='tartalom'>

<?php
    if( isset($_GET['p']) ) $p = $_GET['p'];
    else                   $p = ""         ;

    if( $p==""        ) print "<h2> Akciók </h2>"                    ; else
    if( $p=="termekek") print "<h2> Termékek, szolgáltatások </h2>"  ; else
    if( $p=="help"    ) print "<h2> Terméktámogatás</h2>"            ; else
    if( $p=="gyik"    ) include("gyik.php")                          ; else
    if( $p=="rolunk"  ) include("rolunk.php")                        ; else
    if( $p=="szavazas"  ) include("szavazas.php")                        ; else
    if( $p=="vendegkonyv"  ) include("vendegkonyv.php")                        ; else
                        include("404.php")                           ;

?>

    </div>
    <div id="lablec">
        &copy; enoldalam.hu - 2024.
<?php
    $fajlnev = "szamlalo.txt";
    if(!file_exists($fajlnev))
    {
        $fp = fopen($fajlnev, "w");
        fwrite($fp, "0");
        fclose($fp);
    }
    $fp = fopen($fajlnev, "r");
    $n = fread($fp, filesize($fajlnev));
    fclose($fp);
    
    if(!isset($_SESSION['ittjártam']))
    {
        $n++;
        $_SESSION['ittjártam'] = 1;
        $fp = fopen($fajlnev, "w");
        fwrite($fp, $n);
        fclose($fp);
    }
    print" - Te vagy a(z) $n. látogató"
?>
        <div style='float:right;'>
<?php
    
    $honapok = array( "", "Január", "Február", "Március", "Április", "Május", "Június", "Július", "Augusztus", "Szeptember", "Október", "November", "December");
    $napok = array( "", "Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat", "Vasárnap");
    //include("nevnapok.php");
    print date("Y. ") . $honapok[date("n")]  . date(" d. ") . $napok[date("N")];
?>
        </div>
    </div>
    
</body>
</html>