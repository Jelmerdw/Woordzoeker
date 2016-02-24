<?php

session_start();

//De woorden die in de woordzoeker staan worden opgehaald:
$woorden = $_SESSION["woorden"];
//De gemaakte keuze, naar welk woord er gezocht moet worden, wordt opgehaald:
$keuze = $_GET['keuze'];

//$zoek wordt het woord dat gezocht moet worden:
$zoek = $woorden[$keuze];
//Er wordt gekeken hoeveel letters het woord heeft, dit is het aantal herhalingen:
$herhalingen = strlen($zoek);
//Het woord wat gezocht moet worden wordt in losse letters gesplitst en in een array gezet:
$arrayzoek = str_split($zoek);

//Het aantal regels en kolommen wordt opgehaald:
$aantal_regels = $_SESSION["aantal_regels"];
$aantal_kolommen = $_SESSION["aantal_kolommen"];
//De gemaakte woordzoeker wordt weer opgehaald en de beginwaardes worden gezet:
$woordzoeker = $_SESSION["woordzoeker"];
$uitgevoerd = 0;
$kolom = 0;
$regel = 0;
$einde = 0;
$keer = 0;
$kolom_s = 0;
$regel_s = 0;
$regel_v = -1;
$kolom_v = -1;

$boven = 0;
$onder = 0;
$links = 0;
$rechts = 0;
$boven_d = 0;
$onder_d = 0;
$links_d = 0;
$rechts_d = 0;

//Er wordt opgehaald of horizontaal, verticaal en diagionaal zoeken aan of uit staat:
$horizontaal = $_SESSION["horizontaal"];
$verticaal = $_SESSION["verticaal"];
$diagonaal = $_SESSION["diagonaal"];

///////////////////////////////////
//De functie die horizontaal zoekt:
///////////////////////////////////
function zoek_horizontaal(&$regel, &$aantal_regels, &$kolom) {
    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel, $regel_v, $kolom_v;
    $regel = 0;
    $kolom = 0;
    $regel_v = -1;
    $kolom_v = -1;

    //Zolang hij niet alle regels heeft doorzocht, blijft hij zoeken:
    //Bij elke nieuwe regel wordt de kolom weer op nul gezet:
    while ($regel < $aantal_regels) {
        $kolom = 0;
        controleer_horizontaal($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
        $regel = $regel + 1;
    }
}

//Er wordt in een regel gezocht:
function controleer_horizontaal(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
    global $regel_v;
    //Zo lang hij niet alle kolommen heeft doorzocht, blijft hij zoeken:
    while ($kolom < $aantal_kolommen and $einde == 0) {
        //Er wordt gekeken of de letter overeenkomt met de gezochte letter:
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            //Als dit de eerste letter is die gevonden is, wordt de regel van deze letter bewaard:
            if ($regel_v == -1) {
                $regel_v = $regel;
                gevonden_horizontaal($regel, $aantal_kolommen, $kolom);
            } else {
                //Als er al eerder een letter is gevoden, wordt er gekeken of 
                //de letter op de zelfde regel staat als de vorige gevonden letter:
                if ($regel == $regel_v) {
                    gevonden_horizontaal($regel, $aantal_kolommen, $kolom);
                } else {
                    niet_gevonden_horizontaal($kolom, $uitgevoerd, $cel);
                }
            }
        } else {
            niet_gevonden_horizontaal($kolom, $uitgevoerd, $cel);
        }
    }
}

//Als de letter gevonden is, wordt de bijbehorende cel berekend en deze cel 
//wordt in een array opgeslagen. De kolom wordt een verder gezet, om naar de
//volgende letter te zoeken:
function gevonden_horizontaal(&$regel, &$aantal_kolommen, &$kolom) {
    global $a_gevonden;
    $cel = $regel * $aantal_kolommen + $kolom;
    $a_gevonden[] = $cel;
    $kolom = $kolom + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

//Als de letter niet gevonden is, wordt de eventuele opgeslagen regel weer uit (-1) gezet.
//De kolom wordt een verder gezet, om verder te zoeken. Uitgevoerd wordt naar 0 gezet, zodat
//er weer naar de eerste letter van het woord gezocht gaat worden:
function niet_gevonden_horizontaal(&$kolom, &$uitgevoerd, &$cel) {
    global $regel_v, $a_gevonden;
    unset($a_gevonden);
    $regel_v = -1;
    $kolom = $kolom + 1;
    $uitgevoerd = 0;
    $cel = 0;
}



/////////////////////////////////
//De functie die verticaal zoekt:
/////////////////////////////////
function zoek_verticaal(&$kolom, &$aantal_kolommen, &$regel) {
    global $aantal_regels, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel, $regel_v, $kolom_v;
    $regel = 0;
    $kolom = 0;
    $regel_v = -1;
    $kolom_v = -1;

    //Zolang hij niet alle kolommen heeft doorzocht, blijft hij zoeken:
    //Bij elke nieuwe kolom wordt de regel weer op nul gezet:
    while ($kolom < $aantal_kolommen) {
        $regel = 0;
        controleer_verticaal($regel, $aantal_regels, $einde, $woordzoeker, $kolom, $arrayzoek, $uitgevoerd, $cel, $aantal_kolommen);
        $kolom = $kolom + 1;
    }
}

//Er wordt in een kolom gezocht:
function controleer_verticaal(&$regel, &$aantal_regels, &$einde, &$woordzoeker, &$kolom, &$arrayzoek, &$uitgevoerd, &$cel, &$aantal_kolommen) {
    global $kolom_v;
    //Zo lang hij niet alle regels heeft doorzocht, blijft hij zoeken:
    while ($regel < $aantal_regels and $einde == 0) {
        //Er wordt gekeken of de letter overeenkomt met de gezochte letter:
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            //Als dit de eerste letter is die gevonden is, wordt de kolom van deze letter bewaard:
            if ($kolom_v == -1) {
                $kolom_v = $kolom;
                gevonden_verticaal($kolom, $aantal_kolommen, $regel);
            } else {
                //Als er al eerder een letter is gevoden, wordt er gekeken of 
                //de letter in dezelfde kolom staat als de vorige gevonden letter:
                if ($kolom == $kolom_v) {
                    gevonden_verticaal($kolom, $aantal_kolommen, $regel);
                } else {
                    niet_gevonden_verticaal($regel, $uitgevoerd, $cel);
                }
            }
        } else {
            niet_gevonden_verticaal($regel, $uitgevoerd, $cel);
        }
    }
}

//Als de letter gevonden is, wordt de bijbehorende cel berekend en deze cel 
//wordt in een array opgeslagen. De regel wordt een verder gezet, om naar de
//volgende letter te zoeken:
function gevonden_verticaal(&$kolom, &$aantal_kolommen, &$regel) {
    global $a_gevonden;
    $cel = $regel * $aantal_kolommen + $kolom;
    $a_gevonden[] = $cel;
    $regel = $regel + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

//Als de letter niet gevonden is, wordt de eventuele opgeslagen kolom weer uit (-1) gezet.
//De regel wordt een verder gezet, om verder te zoeken. Uitgevoerd wordt naar 0 gezet, zodat
//er weer naar de eerste letter van het woord gezocht gaat worden:
function niet_gevonden_verticaal(&$regel, &$uitgevoerd, &$cel) {
    global $kolom_v;
    $kolom_v = -1;
    $regel = $regel + 1;
    $uitgevoerd = 0;
    $cel = 0;
}



////////////////////////////////////////////////////////
//De functie die diagonaal zoekt, van links naar rechts:
////////////////////////////////////////////////////////
function zoek_diagonaal1(&$regel, &$aantal_regels, &$kolom) {
    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel, $regel_v, $kolom_v;
    $regel = 0;
    $kolom = 0;
    $regel_v = -1;
    $kolom_v = -1;

    //Zolang hij niet alle regels heeft doorzocht, blijft hij zoeken:
    //Bij elke nieuwe regel wordt de kolom weer op nul gezet:
    while ($regel < $aantal_regels) {
        $kolom = 0;
        controleer_diagonaal1($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
        $regel = $regel + 1;
    }
}

//Er wordt in een regel gezocht:
function controleer_diagonaal1(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
    global $aantal_regels, $diagonaal, $regel_v;
    //Zo lang hij niet alle kolommen heeft doorzocht, blijft hij zoeken:
    while ($kolom < $aantal_kolommen and $kolom > -1 and $regel < $aantal_regels and $regel > -1 and $einde == 0) {
        //Er wordt gekeken of de letter overeenkomt met de gezochte letter:
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            //Als dit de eerste letter is die gevonden is, wordt de regel van deze letter bewaard:
            if ($regel_v == -1) {
                $regel_v = $regel;
                gevonden_diagonaal1($regel, $aantal_kolommen, $kolom, $diagonaal);
            } else {
                //Als er al eerder een letter is gevoden, wordt er gekeken of 
                //de letter in de volgende regel staat als de vorige gevonden letter:
                if ($regel == $regel_v + 1) {
                    $regel_v = $regel_v + 1;
                    gevonden_diagonaal1($regel, $aantal_kolommen, $kolom, $diagonaal);
                } else {
                    niet_gevonden_diagonaal1($kolom, $uitgevoerd, $cel, $diagonaal);
                }
            }
        } else {
            niet_gevonden_diagonaal1($kolom, $uitgevoerd, $cel, $diagonaal);
        }
    }
}

//Als de letter gevonden is, wordt de bijbehorende cel berekend en deze cel 
//wordt in een array opgeslagen. De regel en de kolom wordt een verder gezet, om naar de
//volgende letter te zoeken:
function gevonden_diagonaal1(&$regel, &$aantal_kolommen, &$kolom, &$diagonaal) {
    global $regel_s, $kolom_s, $a_gevonden;

    $cel = $regel * $aantal_kolommen + $kolom;
    $a_gevonden[] = $cel;
    $kolom_s = $kolom_s + 1;
    $regel_s = $regel_s + 1;
    $kolom = $kolom + 1;
    $regel = $regel + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

//Als de letter niet gevonden is, wordt de eventuele opgeslagen regel weer uit (-1) gezet.
//De kolom en de regel wordt eerst weer teruggezet naar waar de eerste letter gevonden was. 
//Daarna wordt de kolom een verder gezet, om verder te zoeken. Uitgevoerd wordt naar 0 gezet, zodat
//er weer naar de eerste letter van het woord gezocht gaat worden:
function niet_gevonden_diagonaal1(&$kolom, &$uitgevoerd, &$cel, &$diagonaal) {
    global $regel_s, $kolom_s, $regel, $regel_v;

    $regel_v = -1;
    $kolom = $kolom - $kolom_s;
    $regel = $regel - $regel_s;
    $kolom = $kolom + 1;
    $kolom_s = 0;
    $regel_s = 0;
    $uitgevoerd = 0;
    $cel = 0;
}



////////////////////////////////////////////////////////
//De functie die diagonaal zoekt, van rechts naar links:
////////////////////////////////////////////////////////
function zoek_diagonaal2(&$regel, &$aantal_regels, &$kolom) {
    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel, $regel_v, $kolom_v;
    $regel = 0;
    $kolom = 0;
    $regel_v = -1;
    $kolom_v = -1;

    //Zolang hij niet alle regels heeft doorzocht, blijft hij zoeken:
    //Bij elke nieuwe regel wordt de kolom weer op nul gezet:
    while ($regel < $aantal_regels) {
        $kolom = 0;
        controleer_diagonaal2($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
        $regel = $regel + 1;
    }
}

//Er wordt in een regel gezocht:
function controleer_diagonaal2(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
    global $aantal_regels, $diagonaal;
    while ($kolom < $aantal_kolommen and $kolom > -1 and $regel < $aantal_regels and $regel > -1 and $einde == 0) {
        //Zo lang hij niet alle kolommen heeft doorzocht, blijft hij zoeken:
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            gevonden_diagonaal2($regel, $aantal_kolommen, $kolom, $diagonaal);
        } else {
            niet_gevonden_diagonaal2($kolom, $uitgevoerd, $cel, $diagonaal);
        }
    }
}

//Als de letter gevonden is, wordt de bijbehorende cel berekend en deze cel 
//wordt in een array opgeslagen. De regel wordt een verder gezet en de kolom wordt een terug gezet, 
//om naar de volgende letter te zoeken:
function gevonden_diagonaal2(&$regel, &$aantal_kolommen, &$kolom, &$diagonaal) {
    global $regel_s, $kolom_s, $a_gevonden;

    $cel = $regel * $aantal_kolommen + $kolom;
    $a_gevonden[] = $cel;
    $kolom_s = $kolom_s + 1;
    $regel_s = $regel_s + 1;
    $kolom = $kolom - 1;
    $regel = $regel + 1;
    uitvoeringen($uitgevoerd, $herhalingen, $einde);
}

//Als de letter niet gevonden is, wordt de eventuele opgeslagen regel weer uit (-1) gezet.
//De kolom en de regel wordt eerst weer teruggezet naar waar de eerste letter gevonden was. 
//Daarna wordt de kolom een verder gezet, om verder te zoeken. Uitgevoerd wordt naar 0 gezet, zodat
//er weer naar de eerste letter van het woord gezocht gaat worden:
function niet_gevonden_diagonaal2(&$kolom, &$uitgevoerd, &$cel, &$diagonaal) {
    global $regel_s, $kolom_s, $regel;

    $kolom = $kolom + $kolom_s;
    $regel = $regel - $regel_s;
    $kolom = $kolom + 1;
    $kolom_s = 0;
    $regel_s = 0;
    $uitgevoerd = 0;
    $cel = 0;
}



/////////////////////
//Algemene functies:
////////////////////

//Als een letter gevonden is, wordt uitgevoerd een groter gemaakt, 
//waardoor er naar de voglende volgende letter kan worden gezocht.
//Als de laatste letter gezocht is, is het einde bereikt en wordt einde = 1.
function uitvoeringen(&$uitgevoerd, &$herhalingen, &$einde) {
    global $uitgevoerd, $herhalingen, $einde;

    if ($uitgevoerd < $herhalingen) {
        $uitgevoerd = $uitgevoerd + 1;
    }
    if ($uitgevoerd == $herhalingen) {
        $einde = 1;
    }
}

//Nadat naar het woord gezocht is, worden de berekende cellen gekleurd:
function kleuren(&$a_gevonden, &$done, &$cel, &$zoek, &$einde) {
    $a_gevonden = array_reverse($a_gevonden);
    $done = 0;
    while ($done < strlen($zoek) and $einde == 1) {
        $cel = $a_gevonden[$done];
        kleurCel($cel, 'yellow');
        $done = $done + 1;
    }
}

//Een cel wordt gekleurd:
function kleurCel($cel, $kleur) {
    echo '<script type="text/javascript">';
    echo ' $("#over .cel' . $cel . '").css("background-color", "' . $kleur . '");';
    echo '</script>';
}



/////////////////////////////////////////////////////////////////
//We hebben een poging gewaagt aan de woordslang,////////////////
//maar hebben het niet kunnen afmaken, dus het werkt helaas niet:
/////////////////////////////////////////////////////////////////

function zoek_woordslang(&$regel, &$aantal_regels, &$kolom) {
    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel, $regel_v, $kolom_v;
    $regel = 0;
    $kolom = 0;
    $regel_v = -1;
    $kolom_v = -1;

    while ($regel < $aantal_regels) {
        $kolom = 0;
        controleer_woordslang($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
        $regel = $regel + 1;
    }
}

function controleer_woordslang(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
    while ($kolom < $aantal_kolommen and $einde == 0) {
        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
            gevonden_woordslang($regel, $aantal_kolommen, $kolom);
        } else {
            niet_gevonden_woordslang($kolom, $uitgevoerd, $cel);
        }
    }
}

function gevonden_woordslang(&$regel, &$aantal_kolommen, &$kolom) {
    global $a_gevonden, $aantal_regels, $boven_d, $onder_d, $links_d, $rechts_d, $boven, $onder, $links, $rechts, $verplaatsing;
    $cel = $regel * $aantal_kolommen + $kolom;
    $a_gevonden[] = $cel;
    if ($regel > 0 and $boven_d == 0) {
        $regel = $regel - 1;
        $boven = $boven + 1;
        $verplaatsing[] = 'b';
        $onder_d = 1;
        //echo 'boven';
    } else {
        if ($regel < $aantal_regels - 1 and $onder_d == 0) {
            $regel = $regel + 1;
            $onder = $onder + 1;
            $verplaatsing[] = 'o';
            $boven_d = 1;
            //echo 'onder';
        } else {
            if ($kolom > 0 and $rechts_d == 0) {
                $kolom = $kolom + 1;
                $rechts = $rechts + 1;
                $verplaatsing[] = 'r';
                $links_d = 1;
                //echo 'rechts';
            } else {
                if ($kolom < $aantal_kolommen - 1 and $links_d == 0) {
                    $kolom = $kolom - 1;
                    $links = $links + 1;
                    $verplaatsing[] = 'l';
                    $rechts_d = 1;
                    //echo 'links';
                }
            }
        }
        uitvoeringen($uitgevoerd, $herhalingen, $einde);
    }
}

function niet_gevonden_woordslang(&$kolom, &$uitgevoerd, &$cel) {
    global $a_gevonden, $aantal_regels, $boven_d, $onder_d, $links_d, $rechts_d, $boven, $onder, $links, $rechts, $einde, $verplaatsing, $regel;
    //if (isset($verplaatsing)) {
    $laatste = end($verplaatsing);
    echo $laatste;
    if ($laatste == 'b') {
        $regel = $regel - 1;
        $boven_d = 1;
        $uitgevoerd = $uitgevoerd - 1;
        array_pop($verplaatsing);
    } else {
        if ($laatste == 'o') {
            $regel = $regel + 1;
            $onder_d = 1;
            $uitgevoerd = $uitgevoerd - 1;
            array_pop($verplaatsing);
        } else {
            if ($laatste == 'r') {
                $kolom = $kolom - 1;
                $rechts_d = 1;
                $uitgevoerd = $uitgevoerd - 1;
                array_pop($verplaatsing);
            } else {
                if ($laatste == 'l') {
                    $kolom = $kolom + 1;
                    $links_d = 1;
                    $uitgevoerd = $uitgevoerd - 1;
                    array_pop($verplaatsing);
                } else {
                    $kolom = $kolom + 1;
                    $boven_d = 0;
                    $onder_d = 0;
                    $links_d = 0;
                    $rechts_d = 0;
                }
            }
        }
    }
    //}
    //else $kolom = $kolom + 1;
}

//echo $laatste;
//$einde = 1;

/////////////////////////
//EINDE POGING WOORDSLANG
/////////////////////////



//Er wordt alleen gezocht, als de bijbehorende zoekrichting aan staat:
if ($horizontaal == 1) {
    zoek_horizontaal($regel, $aantal_regels, $kolom);
}
if ($verticaal == 1) {
    zoek_verticaal($regel, $aantal_kolommen, $kolom);
}
if ($diagonaal == 1) {
    zoek_diagonaal1($regel, $aantal_regels, $kolom);
    zoek_diagonaal2($regel, $aantal_regels, $kolom);
}

//Het woord wordt omgedraaid en worrdt nog een keer gezocht,
//zodat ook de andere kant op gezocht wordt:
$zoek = strrev($zoek);
$herhalingen = strlen($zoek);
$arrayzoek = str_split($zoek);

//Er wordt alleen gezocht, als de bijbehorende zoekrichting aan staat:
if ($horizontaal == 1) {
    zoek_horizontaal($regel, $aantal_regels, $kolom);
}
if ($verticaal == 1) {
    zoek_verticaal($regel, $aantal_kolommen, $kolom);
}
if ($diagonaal == 1) {
    zoek_diagonaal1($regel, $aantal_regels, $kolom);
    zoek_diagonaal2($regel, $aantal_regels, $kolom);
}

//Er wordt alleen gekleurd als tenminste één van de zoekrichtingen aan staat:
if ($horizontaal == 0 and $verticaal == 0 and $diagonaal == 0){
}
else{
kleuren($a_gevonden, $done, $cel, $zoek, $einde);
}

/////Nog een stukje van de woordslang, wat niet werkt:////
//zoek_woordslang($regel, $aantal_regels, $kolom);
//print"<pre>";
//print_r($a_gevonden);
//echo '<br>';
//print_r($verplaatsing);

//Het ladingslogo wordt weer uitgezet:
echo '<script type="text/javascript">';
echo '$("#loading_spinner").hide()';
echo '</script>';
?> 