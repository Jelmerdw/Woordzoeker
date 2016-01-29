<?php

// Start the session
session_start();
?>
<?php

$woorden = $_SESSION["woorden"];
$keuze = $_GET['keuze'];

if ($keuze == 3) {
    $keuze = 3;
} else {
    if ($keuze == 2) {
        $keuze = 2;
    } else {
        $keuze = 1;
    }
}

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

function gevonden($regel, $aantal_kolommen, $kolom) {
    global $regel, $aantal_kolommen, $kolom;
    
    $cel = $regel * $aantal_kolommen + $kolom;
    kleurCel($cel, 'yellow');
    $kolom = $kolom + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

function niet_gevonden($kolom, $uitgevoerd, $cel) {
    global $kolom, $uitgevoerd, $cel;
    
    $kolom = $kolom + 1;
    $uitgevoerd = 0;
    $cel = 0;
    herstel($cel, $aantal_klommen, $aantal_regels);
}

function uitvoeringen($uitgevoerd, $herhalingen, $einde) {
    global $uitgevoerd, $herhalingen, $einde;
    
    if ($uitgevoerd < $herhalingen) {
        $uitgevoerd = $uitgevoerd + 1;
    }
    if ($uitgevoerd == $herhalingen) {
        $einde = 1;
    }
}

function herstel($cel, $aantal_klommen, $aantal_regels) {
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

$teller = 0;
while ($uitgevoerd < $herhalingen) {
    $regel = 0;
    while ($regel < $aantal_regels) {
        $kolom = 0;
        while ($kolom < $aantal_kolommen and $einde == 0) {
            if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
                gevonden($regel, $aantal_kolommen, $kolom);
                //$cel = $regel * $aantal_kolommen + $kolom;
                //kleurCel($cel, 'yellow');
                //$kolom = $kolom + 1;
                //uitvoeringen($uitgevoerd, $herhalingen, $einde);
                //if ($uitgevoerd < $herhalingen) {
                //$uitgevoerd = $uitgevoerd + 1;
                //}
                //if ($uitgevoerd == $herhalingen) {
                //$einde = 1;
                //}
            } else {
                niet_gevonden($kolom, $uitgevoerd, $cel);
                ///$kolom = $kolom + 1;
                //$uitgevoerd = 0;
                //$cel = 0;
                //herstel($cel, $aantal_klommen, $aantal_regels);
                //while ($cel < $aantal_kolommen * $aantal_regels) {
                //kleurCel($cel, 'white');
                //$cel = $cel + 1;
                //}
            }
        }
        $regel = $regel + 1;
    }
    $uitgevoerd = $uitgevoerd + 1;
}

echo $keuze;
?>