<?php
session_start();
//Horizontaal, verticaal en diagonaal staat standaard aan (1):
$_SESSION["horizontaal"] = 1;
$_SESSION["verticaal"] = 1;
$_SESSION["diagonaal"] = 1;
?>

<html>
    <head>
        <title>Woordzoeker</title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link href="opmaak.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script>
            $(document).ready(function ()
            {

                // Laadt het php zoek-script voor mouse-over van het woord waarover je muis gaat:
                $("p").mouseenter(function () {
                    var Class = $(this).attr("class");

                    var Class2 = 'zoeker_over.php?keuze=' + Class + ''

                    $("#div_loader").load(Class2);
                    $('#loading_spinner').show();
                });

                // Laadt het php zoek-script voor mouse-klik van het woord waarop geklikt is:
                $("p").click(function () {
                    var Class = $(this).attr("class");

                    var Class2 = 'zoeker_klik.php?keuze=' + Class + ''

                    // Als het woord al gekleurd was, wordt het weer ontkleurd, zo niet dan wordt het gekleurd:
                    if ($('#woord' + Class + '').length) {
                        $('#woord' + Class + '').remove();
                    }
                    else {
                        $("#body").append("<div id='woord" + Class + "'></div>");
                        $.ajax({
                            url: Class2
                        }).done(function (data) {
                            $('#woord' + Class + '').append(data);
                        });

                        $('#loading_spinner').show();
                    }
                });

                //Als je de muis weer van het woord haalt wordt het woord weer ontkleurd:
                $("p").mouseout(function () {
                    window.stop();
                    $("#over td").css("background-color", "white");
                    $("#div_loader").empty();
                    $('#loading_spinner').hide();
                });

                // Als horizontaal, verticaal of diagonaal wordt uitgevinkt wordt deze zoekmethode uitgezet:
                $('#horizontaal').change(function () {
                    $("#div_loader").load('horizontaal.php');
                });

                $('#verticaal').change(function () {
                    $("#div_loader").load('verticaal.php');
                });

                $('#diagonaal').change(function () {
                    $("#div_loader").load('diagonaal.php');
                });

            });
        </script>


    </head>
    <body> 
        <div id="body">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="file" size="60" />
                <input type="submit" value="Lees" />
            </form>

            <form>
                <input id="horizontaal" type="checkbox" name="zoekmethode" checked="on" value="horizontaal"/> Horizontaal
                <input id="verticaal" type="checkbox" name="zoekmethode" checked="on" value="verticaal"/> Verticaal
                <input id="diagonaal" type="checkbox" name="zoekmethode" checked="on" value="diagonaal"/> Diagonaal
            </form>

            <?php
            if ($_FILES) {

                //Er wordt gekeken of het bestand geselecteerd is:

                if ($_FILES['file']['name'] != "") {


                    //Er wordt gekeken of het bestand een text-bestand is:

                    if (isset($_FILES) && $_FILES['file']['type'] != 'text/plain') {

                        echo "<span>Woordzoeker ondersteunt alleen .txt files! Kies een text bestand.</span>";

                        exit();
                    }

                    //De bestandsnaam wordt tijdelijk opgeslagen:
                    $fileName = $_FILES['file']['tmp_name'];

                    //Bericht wanneer het bestand niet geopend kon worden:
                    $file = fopen($fileName, "r") or exit("Het bestand kon niet geopend worden. Probeer het opnieuw.");



                    // Lees het textbestand naar een array:
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

                    //Zet de streepjes om naar random letters:
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

                    //De gemaakte woordzoeker wordt in een session gezet:
                    $_SESSION["woordzoeker"] = $woordzoeker;

                    //Functie: van de gemaakte woordzoeker wordt een mooie tabel gemaakt:
                    function build_table1($woordzoeker) {
                        $html = '<table id="over">';
                        $getal0 = 0;
                        foreach ($woordzoeker as $key => $value) {
                            $html .= '<tr>';
                            foreach ($value as $key2 => $value2) {
                                $html .= "<td class='cel$getal0'>" . $value2 . '</td>';
                                $getal0 = $getal0 + 1;
                            }
                            $html .= '</tr>';
                        }
                        $html .= '</table>';
                        return $html;
                    }

                    //Functie: Maak de tabel nog een keer, naar nu met id=transparent:
                    function build_table_transparent($woordzoeker) {
                        $html = '<table id="transparent">';
                        $getal0 = 0;
                        foreach ($woordzoeker as $key => $value) {
                            $html .= '<tr>';
                            foreach ($value as $key2 => $value2) {
                                $html .= "<td class='cel$getal0'>" . $value2 . '</td>';
                                $getal0 = $getal0 + 1;
                            }
                            $html .= '</tr>';
                        }
                        $html .= '</table>';
                        return $html;
                    }

                    //De tabellen worden gemaakt:
                    echo build_table_transparent($woordzoeker);
                    echo build_table1($woordzoeker);

                    $gegeven_woorden = 1;
                    $getal1 = 1;

                    // De woorden die gezocht moeten worden, worden onder elkaar in een div gezet:
                    echo "<div id='woordjes'>";

                    while ($gegeven_woorden < $aantal_woorden) {
                        echo "<p class=" . $getal1 . ">" . $woorden[$gegeven_woorden] . "</p>";
                        echo '<br>';
                        $getal1 = $getal1 + 1;
                        $gegeven_woorden = $gegeven_woorden + 1;
                    }
                    echo "</div>";
                    
                    //Als er geen bestand is geselecteerd bij het inlezen, wordt een melding weergegeven:
                } else {
                    if (isset($_FILES) && $_FILES['file']['type'] == '')
                        echo "<span>Selecteer eerst een text-bestand.</span>";
                }
            }
            ?>
            <div id="div_loader"></div>
            <div id="div_loader1"></div>
            <img id="loading_spinner" src="loading_spinner.gif">
            <div class="my_update_panel"></div>
            <div id="copyright">
                <h4>&#169; Jelmer, Stijn en Luna.</h4>
            </div>
        </div>
    </body>
</html>