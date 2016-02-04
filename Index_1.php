<?php
session_start();
?>

<html>
    <head>
        <title>Woordzoeker</title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link href="opmaak.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script>
            $(document).ready(function ()
            {
                $("p").mouseenter(function () {
                    var Class = $(this).attr("class");

                    var Class2 = 'zoeker.php?keuze=' + Class + ''

                    $("#div_loader").load(Class2);
                    $('#loading_spinner').show();
                });

                $("p").mouseout(function () {
                    window.stop();
                    $("td").css("background-color", "white");
                    $("#div_loader").empty();
                    $('#loading_spinner').hide();
                });
            });
        </script>


    </head>
    <body> 
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="file" size="60" />
            <input type="submit" value="Lees" />
        </form>



        <?php
        if ($_FILES) {

            //Checking if file is selected or not

            if ($_FILES['file']['name'] != "") {


                //Checking if the file is plain text or not

                if (isset($_FILES) && $_FILES['file']['type'] != 'text/plain') {

                    echo "<span>Woordzoeker ondersteunt alleen .txt files! Kies een text bestand.</span>";

                    exit();
                }

                //Getting and storing the temporary file name of the uploaded file
                $fileName = $_FILES['file']['tmp_name'];

                //Throw an error message if the file could not be open
                $file = fopen($fileName, "r") or exit("Unable to open file!");



// Reading a .txt file
                $aantal_regels = 0;
                $einde = 0;
                $aantal_woorden = 0;

                while (!feof($file)) {
                    $lijn = fgets($file);
                    $karakters = strlen($lijn);
                    if ($karakters == 2) {
                        $einde = 1;
                    }

                    if ($einde == 0) {
                        $lijn_trim = rtrim($lijn, "\n");
                        $lijn_trim_trim = rtrim($lijn_trim, "\r");
                        $aantal_kolommen = strlen($lijn_trim_trim);
                        $_SESSION["aantal_kolommen"] = $aantal_kolommen;
                        $teken = str_split($lijn_trim_trim);
                        $woordzoeker[] = $teken;
                        $_SESSION["woordzoeker"] = $woordzoeker;
                        $aantal_regels = $aantal_regels + 1;
                        $_SESSION["aantal_regels"] = $aantal_regels;
                    } else {
                        $lijn_trim = rtrim($lijn, "\n");
                        $lijn_trim_trim = rtrim($lijn_trim, "\r");
                        $woorden[] = $lijn_trim_trim;
                        $_SESSION["woorden"] = $woorden;
                        $aantal_woorden = $aantal_woorden + 1;
                    }
                }

                fclose($file);

                //Streepjes worden letters:
                $letters = "abcdefghijklmnopqrstuvwxyz";
                $lettersArray = str_split($letters);
                foreach ($woordzoeker as $rij => $regel) {
                    foreach ($regel as $kolom => $letter) {
                        if ($letter == '-') {
                            $pos = rand(0, strlen($letters) - 1);
                            $woordzoeker[$rij][$kolom] = $lettersArray[$pos];
                        }
                    }
                }

                function build_table($woordzoeker) {
                    // start table
                    $html = '<table>';
                    $getal0 = 0;
                    // data rows
                    foreach ($woordzoeker as $key => $value) {
                        $html .= '<tr>';
                        foreach ($value as $key2 => $value2) {

                            $html .= "<td class='cel$getal0'>" . $value2 . '</td>';
                            $getal0 = $getal0 + 1;
                        }
                        $html .= '</tr>';
                    }

                    // finish table and return it

                    $html .= '</table>';
                    return $html;
                }

                echo build_table($woordzoeker);

                $gegeven_woorden = 1;
                $getal1 = 1;
                echo "<div id='woordjes'>";
                while ($gegeven_woorden < $aantal_woorden) {
                    echo "<p class=" . $getal1 . ">" . $woorden[$gegeven_woorden] . "</p>";
                    echo '<br>';
                    $keuze[] = $getal1;
                    $getal1 = $getal1 + 1;
                    $gegeven_woorden = $gegeven_woorden + 1;
                }
                echo "</div>";
                
                print"<pre>";
                print_r($keuze);

                $woorden = $_SESSION["woorden"];
                $woord = 0;
                //foreach($keuze as $value){
                
                function zoek_horizontaal(&$regel, &$aantal_regels, &$kolom) {
                    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel;

                    while ($regel < $aantal_regels) {
                        $kolom = 0;
                        controleer_horizontaal($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
                        $regel = $regel + 1;
                    }
                }

                function zoek_verticaal(&$kolom, &$aantal_kolommen, &$regel) {
                    global $aantal_regels, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel;

                    while ($kolom < $aantal_kolommen) {
                        $regel = 0;
                        controleer_verticaal($regel, $aantal_regels, $einde, $woordzoeker, $kolom, $arrayzoek, $uitgevoerd, $cel, $aantal_kolommen);
                        $kolom = $kolom + 1;
                    }
                }

                function zoek_diagonaal(&$regel, &$aantal_regels, &$kolom) {
                    global $aantal_kolommen, $einde, $woordzoeker, $arrayzoek, $uitgevoerd, $cel;

                    while ($regel < $aantal_regels) {
                        $kolom = 0;
                        controleer_diagonaal($kolom, $aantal_kolommen, $einde, $woordzoeker, $regel, $arrayzoek, $uitgevoerd, $cel);
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

                function controleer_diagonaal(&$kolom, &$aantal_kolommen, &$einde, &$woordzoeker, &$regel, &$arrayzoek, &$uitgevoerd, &$cel) {
                    global $aantal_regels, $diagonaal;
                    while ($kolom < $aantal_kolommen and $kolom > -1 and $regel < $aantal_regels and $regel > -1 and $einde == 0) {
                        if ($woordzoeker[$regel][$kolom] == $arrayzoek[$uitgevoerd]) {
                            gevonden_diagonaal($regel, $aantal_kolommen, $kolom, $diagonaal);
                        } else {
                            niet_gevonden_diagonaal($kolom, $uitgevoerd, $cel, $diagonaal);
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

                function gevonden_diagonaal(&$regel, &$aantal_kolommen, &$kolom, &$diagonaal) {
                    global $regel_s, $kolom_s;

                    $cel = $regel * $aantal_kolommen + $kolom;
                    kleurCel($cel, 'yellow');
                    $kolom_s = $kolom_s + 1;
                    $regel_s = $regel_s + 1;
                    $kolom = $kolom + 1;
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

                function niet_gevonden_diagonaal(&$kolom, &$uitgevoerd, &$cel, &$diagonaal) {
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
                    global $cel, $aantal_kolommen, $aantal_regels, $woord;
                    echo '<script type="text/javascript">';
                    echo '$("div id=' . $woord . '">.empty()';
                    echo '</script>';
                }

                function kleurCel($cel, $kleur) {
                    global $woord;
                    echo '<div id=' . $woord . '>';
                    echo '<script type="text/javascript">';
                    echo ' $(".cel' . $cel . '").css("background-color", "' . $kleur . '");';
                    echo '</script>';
                    echo '</div>';
                }
                
               
                $woord = 1;
                while ($woord < count($keuze) + 1){
                echo $woord;
                $zoek = $woorden[$woord];
                $herhalingen = strlen($zoek);
                $arrayzoek = str_split($zoek);
                
                print"<pre>";
                print_r($arrayzoek);

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

           

                $regel = 0;
                $kolom = 0;
                zoek_horizontaal($regel, $aantal_regels, $kolom);

                $regel = 0;
                $kolom = 0;
                zoek_verticaal($regel, $aantal_kolommen, $kolom);

                $regel = 0;
                $kolom = 0;
                zoek_diagonaal($regel, $aantal_regels, $kolom);

                $zoek = strrev($zoek);
                $herhalingen = strlen($zoek);
                $arrayzoek = str_split($zoek);

                $regel = 0;
                $kolom = 0;
                zoek_horizontaal($regel, $aantal_regels, $kolom);

                $regel = 0;
                $kolom = 0;
                zoek_verticaal($regel, $aantal_kolommen, $kolom);

                $uitgevoerd = 0;
                $regel = 0;
                $kolom = 0;
                zoek_diagonaal($regel, $aantal_regels, $kolom);
                
                $woord = $woord + 1;
                echo $woord;
                }


                //echo $keuze;

                echo '<script type="text/javascript">';
                echo '$("#loading_spinner").hide()';
                echo '</script>';



        } else {
        if (isset($_FILES) && $_FILES['file']['type'] == '')
        echo "<span>Please Choose a file by click on 'Browse' or 'Choose File' button.</span>";
        }
        }
        ?>

        <img id="loading_spinner" src="loading_spinner.gif">
        <div class="my_update_panel"></div>
        <div id="copyright">
            <h4>&#169; Jelmer, Luna en Stijn.</h4>
        </div>
    </body>
</html>