<?php
// Start the session
session_start();
?>
<?php
$woorden = $_SESSION["woorden"];
$keuze = $_GET['keuze'];

if ($keuze == 3) {
    $keuze = 3;
} 
else {
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

function kleurCel($cel, $kleur) {
    echo '<script type="text/javascript">';
    echo ' $(".cel' . $cel . '").css("background-color", "' . $kleur . '");';
    echo '</script>';
}

//print "<pre>";print_r($_SESSION); print "</pre>";
print "herhalingen $herhalingen";
//exit;
$teller = 0;
while ($uitgevoerd < $herhalingen || $teller < 10) {
    $teller++;
    $regel = 0;
    //unset($array_cel);
    while ($regel < $aantal_regels) {
        $kolom = 0;
        while ($kolom < $aantal_kolommen and $einde == 0) {
            if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
                //echo $regel;
                //echo $kolom;
                $cel = $regel * $aantal_kolommen + $kolom;
                // $array_cel[] = $cel;
                kleurCel($cel, 'yellow');
                //<script type="text/javascript">
                //    $(".cel<?php echo $cel; ? >").css("background-color", "yellow");
                //</ script>
                $kolom = $kolom + 1;
                if ($uitgevoerd < $herhalingen) {
                    $uitgevoerd = $uitgevoerd + 1;
                }
                if ($uitgevoerd == $herhalingen) {
                    $einde = 1;
                    break;  // leave inner while loop
                }
            } else {
                $kolom = $kolom + 1;
                $uitgevoerd = 0;
                $cel = 0;
                while ($cel < $aantal_kolommen * $aantal_regels) {
                    ?>
                    <script type="text/javascript">
                        $(".cel<?php echo $cel; ?>").css("background-color", "white");
                    </script>
                    <?php
                    $cel = $cel + 1;
                }
            }
        }
        $regel = $regel + 1;
    }
    $uitgevoerd = $uitgevoerd + 1;
    //$letter[] = $array_cel;
}

echo $keuze;
?>