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
                    console.log(Class);

                    var Class2 = 'zoeker.php?keuze=' + Class + ''
                    //alert(Class2);
                    console.log(Class2);


                    //$('.' + Class).hover(function () {
                    $("#div_loader").load(Class2);
                    $('#loading_spinner').show();
                    //$("#div_loader").load("zoeker.php?keuze=3");})
                    //$("#div_loader").load("zoeker.php?keuze=1");
                    //$("#div_loader").load("zoeker.php?keuze=3");
                });

                $("p").mouseout(function () {
                    $("#div_loader").stop();
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
                        $_SESSION["aantal_regel"] = $aantal_regels;
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
                    $getal1 = $getal1 + 1;
                    $gegeven_woorden = $gegeven_woorden + 1;
                }
                echo "</div>";
                //print"<pre>";
                //print_r($letter);
            } else {
                if (isset($_FILES) && $_FILES['file']['type'] == '')
                    echo "<span>Please Choose a file by click on 'Browse' or 'Choose File' button.</span>";
            }
        }
        ?>

        <div id="div_loader"></div>
        <img id="loading_spinner" src="loading_spinner.gif">
        <div class="my_update_panel"></div>
        <div id="copyright">
            <h4>&#169; Jelmer, Luna en Stijn.</h4>
        </div>
    </body>
</html>