<?php

session_start();

$woorden = $_SESSION["woorden"];
$keuze = $_GET['keuze'];

$zoek = $woorden[$keuze];
$herhalingen = strlen($zoek);
$arrayzoek = str_split($zoek);

$aantal_regels = $_SESSION["aantal_regels"];
$aantal_kolommen = $_SESSION["aantal_kolommen"];
$woordzoeker = $_SESSION["woordzoeker"];
$uitgevoerd = 0;
$kolom = 0;
$regel = 0;
$einde = 0;
$keer = 0;
$kolom_s = 0;
$regel_s = 0;

function zoek_horizontaal(&$regel, &$aantal_regels, &$kolom) {
    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel;
    $regel = 0;
    $kolom = 0;

    while ($regel < $aantal_regels) {
        $kolom = 0;
        controleer_horizontaal($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
        $regel = $regel + 1;
    }
}

function zoek_verticaal(&$kolom, &$aantal_kolommen, &$regel) {
    global $aantal_regels, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel;
    $regel = 0;
    $kolom = 0;

    while ($kolom < $aantal_kolommen) {
        $regel = 0;
        controleer_verticaal($regel, $aantal_regels, $einde, $woordzoeker, $kolom, $arrayzoek, $uitgevoerd, $cel, $aantal_kolommen);
        $kolom = $kolom + 1;
    }
}

function zoek_diagonaal1(&$regel, &$aantal_regels, &$kolom) {
    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel;
    $regel = 0;
    $kolom = 0;

    while ($regel < $aantal_regels) {
        $kolom = 0;
        controleer_diagonaal1($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
        $regel = $regel + 1;
    }
}

function zoek_diagonaal2(&$regel, &$aantal_regels, &$kolom) {
    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel;
    $regel = 0;
    $kolom = 0;

    while ($regel < $aantal_regels) {
        $kolom = 0;
        controleer_diagonaal2($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
        $regel = $regel + 1;
    }
}

function controleer_horizontaal(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
    while ($kolom < $aantal_kolommen and $einde == 0) {
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            gevonden_horizontaal($regel, $aantal_kolommen, $kolom);
        } else {
            niet_gevonden_horizontaal($kolom, $uitgevoerd, $cel);
        }
    }
}

function controleer_verticaal(&$regel, &$aantal_regels, &$einde, &$woordzoeker, &$kolom, &$arrayzoek, &$uitgevoerd, &$cel, &$aantal_kolommen) {
    while ($regel < $aantal_regels and $einde == 0) {
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            gevonden_verticaal($kolom, $aantal_kolommen, $regel);
        } else {
            niet_gevonden_verticaal($regel, $uitgevoerd, $cel);
        }
    }
}

function controleer_diagonaal1(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
    global $aantal_regels, $diagonaal;
    while ($kolom < $aantal_kolommen and $kolom > -1 and $regel < $aantal_regels and $regel > -1 and $einde == 0) {
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            gevonden_diagonaal1($regel, $aantal_kolommen, $kolom, $diagonaal);
        } else {
            niet_gevonden_diagonaal1($kolom, $uitgevoerd, $cel, $diagonaal);
        }
    }
}

function controleer_diagonaal2(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
    global $aantal_regels, $diagonaal;
    while ($kolom < $aantal_kolommen and $kolom > -1 and $regel < $aantal_regels and $regel > -1 and $einde == 0) {
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            gevonden_diagonaal2($regel, $aantal_kolommen, $kolom, $diagonaal);
        } else {
            niet_gevonden_diagonaal2($kolom, $uitgevoerd, $cel, $diagonaal);
        }
    }
}

function gevonden_horizontaal(&$regel, &$aantal_kolommen, &$kolom) {
    $cel = $regel * $aantal_kolommen + $kolom;
    kleurCel($cel, 'yellow');
    $kolom = $kolom + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

function gevonden_verticaal(&$kolom, &$aantal_kolommen, &$regel) {
    $cel = $regel * $aantal_kolommen + $kolom;
    kleurCel($cel, 'yellow');
    $regel = $regel + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

function gevonden_diagonaal1(&$regel, &$aantal_kolommen, &$kolom, &$diagonaal) {
    global $regel_s, $kolom_s;
    
    $cel = $regel * $aantal_kolommen + $kolom;
    kleurCel($cel, 'yellow');
    $kolom_s = $kolom_s + 1;
    $regel_s = $regel_s + 1;
    $kolom = $kolom + 1;
    $regel = $regel + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

function gevonden_diagonaal2(&$regel, &$aantal_kolommen, &$kolom, &$diagonaal) {
    global $regel_s, $kolom_s;
    
    $cel = $regel * $aantal_kolommen + $kolom;
    kleurCel($cel, 'yellow');
    $kolom_s = $kolom_s + 1;
    $regel_s = $regel_s + 1;
    $kolom = $kolom - 1;
    $regel = $regel + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

function niet_gevonden_horizontaal(&$kolom, &$uitgevoerd, &$cel) {
    $kolom = $kolom + 1;
    $uitgevoerd = 0;
    $cel = 0;
    herstel($cel);
}

function niet_gevonden_verticaal(&$regel, &$uitgevoerd, &$cel) {
    $regel = $regel + 1;
    $uitgevoerd = 0;
    $cel = 0;
    herstel($cel);
}

function niet_gevonden_diagonaal1(&$kolom, &$uitgevoerd, &$cel, &$diagonaal) {
    global $regel_s, $kolom_s, $regel;
    
    $kolom = $kolom - $kolom_s;
    $regel = $regel - $regel_s;
    $kolom = $kolom + 1;
    $kolom_s = 0;
    $regel_s = 0;
    $uitgevoerd = 0;
    $cel = 0;
    herstel($cel);
}

function niet_gevonden_diagonaal2(&$kolom, &$uitgevoerd, &$cel, &$diagonaal) {
    global $regel_s, $kolom_s, $regel;
    
    $kolom = $kolom + $kolom_s;
    $regel = $regel - $regel_s;
    $kolom = $kolom + 1;
    $kolom_s = 0;
    $regel_s = 0;
    $uitgevoerd = 0;
    $cel = 0;
    herstel($cel);
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

function herstel(&$cel) {
    echo '<script type="text/javascript">';
    echo '$("td").css("background-color", "white");';
    echo '</script>';
}

function kleurCel($cel, $kleur) {
    echo '<script type="text/javascript">';
    echo ' $(".cel' . $cel . '").css("background-color", "' . $kleur . '");';
    echo '</script>';
}

zoek_horizontaal($regel, $aantal_regels, $kolom);
zoek_verticaal($regel, $aantal_kolommen, $kolom);
zoek_diagonaal1($regel, $aantal_regels, $kolom);
zoek_diagonaal2($regel, $aantal_regels, $kolom);

$zoek = strrev($zoek);
$herhalingen = strlen($zoek);
$arrayzoek = str_split($zoek);

zoek_horizontaal($regel, $aantal_regels, $kolom);
zoek_verticaal($regel, $aantal_kolommen, $kolom);
zoek_diagonaal1($regel, $aantal_regels, $kolom);
zoek_diagonaal2($regel, $aantal_regels, $kolom);

echo '<script type="text/javascript">';
echo '$("#loading_spinner").hide()';
echo '</script>';
?> 