<?php

session_start();

$woorden = $_SESSION["woorden"];
$keuze = $_GET['keuze'];

$zoek = $woorden[$keuze];
$herhalingen = strlen($zoek);
$arrayzoek = str_split($zoek);

$aantal_regels = $_SESSION["aantal_regel"];
$aantal_kolommen = $_SESSION["aantal_kolommen"];
$woordzoeker = $_SESSION["woordzoeker"];
$uitgevoerd = 0;
$kolom = 0;
$regel = 0;
$einde = 0;
$keer = 0;

function regelplaats(&$regel, &$aantal_regels, &$kolom) {
    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel;
    
    while ($regel < $aantal_regels) {
        $kolom = 0;
        zoek($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
        $regel = $regel + 1;
    }
}

function zoek(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
    while ($kolom < $aantal_kolommen and $einde == 0) {
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            gevonden($regel, $aantal_kolommen, $kolom);
        } else {
            niet_gevonden($kolom, $uitgevoerd, $cel);
        }
    }
}

function gevonden(&$regel, &$aantal_kolommen, &$kolom) {
    $cel = $regel * $aantal_kolommen + $kolom;
    $vorige_cel = $cel;
    kleurCel($cel, 'yellow');
    $kolom = $kolom + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

function niet_gevonden(&$kolom, &$uitgevoerd, &$cel) {
    $kolom = $kolom + 1;
    $uitgevoerd = 0;
    $cel = 0;
    herstel($cel, $aantal_klommen, $aantal_regels);
}

function uitvoeringen(&$uitgevoerd, &$herhalingen, &$einde) {
    global $uitgevoerd, $herhalingen, $einde;

    if ($uitgevoerd < $herhalingen) {
        $uitgevoerd = $uitgevoerd + 1;
    }
    if ($uitgevoerd == $herhalingen) {
        $einde = 1;
    }
}

function herstel(&$cel, &$aantal_klommen, &$aantal_regels) {
    global $cel, $aantal_kolommen, $aantal_regels;

    while ($cel < $aantal_kolommen * $aantal_regels) {
        kleurCel($cel, 'white');
        $cel = $cel + 1;
    }
}

function kleurCel($cel, $kleur) {
    echo '<script type="text/javascript">';
    echo ' $(".cel' . $cel . '").css("background-color", "' . $kleur . '");';
    echo '</script>';
}

//print "<pre>";print_r($_SESSION); 
//print "</pre>";
//print "herhalingen $herhalingen";
//exit;


while ($uitgevoerd < $herhalingen and $keer <= 1) {
    $regel = 0;
    $keer = $keer + 1;
    regelplaats($regel, $aantal_regels, $kolom);
}

$keer = 0;
$zoek = strrev($zoek);
$herhalingen = strlen($zoek);
$arrayzoek = str_split($zoek);

while ($uitgevoerd < $herhalingen and $keer <= 1) {
    $regel = 0;
    $keer = $keer + 1;
    regelplaats($regel, $aantal_regels, $kolom);
}


echo $keuze;

echo '<script type="text/javascript">';
echo '$("#loading_spinner").hide()';
echo '</script>';
?>