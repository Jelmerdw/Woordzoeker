<html>
    <head>
        <title>Woordzoeker</title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
        <link href="opmaak.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    </head>
    <body> 
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="file" size="60" />
            <input type="submit" value="Lees" />
        </form>
    </body>
</html>




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
        //$aantal_regels = 0;
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
                //$aantal_kolommen = strlen($lijn_trim_trim) ;
                $woordzoeker[] = str_split($lijn_trim_trim);
                //$aantal_regels = $aantal_regels + 1;
            } else {
                $lijn_trim = rtrim($lijn, "\n");
                $lijn_trim_trim = rtrim($lijn_trim, "\r");
                $woorden[] = $lijn_trim_trim;
                $aantal_woorden = $aantal_woorden + 1;
            }
        }

        fclose($file);

//print"<pre>";
        //print_r($woordzoeker);
        //$regel = 0 ;
        //$kolom = 0 ;
        //while ($regel < $aantal_regels)
        //{
        //while ($kolom < $aantal_kolommen)
        //{
        //echo $woordzoeker[$regel][$kolom] ;
        //$kolom = $kolom + 1 ;
        //}
        //echo "<br>" ;    
        //$kolom = 0 ;
        //$regel = $regel + 1 ;
        //}    

        function build_table($woordzoeker) {
            // start table
            $html = '<table>';

            // data rows
            foreach ($woordzoeker as $key => $value) {
                $html .= '<tr>';
                foreach ($value as $key2 => $value2) {
                    $html .= '<td>' . $value2 . '</td>';
                }
                $html .= '</tr>';
            }

            // finish table and return it

            $html .= '</table>';
            return $html;
        }

        echo build_table($woordzoeker);

        $gegeven_woorden = 1;
        while ($gegeven_woorden < $aantal_woorden) {
            echo $woorden[$gegeven_woorden];
            echo '<br>';
            $gegeven_woorden = $gegeven_woorden + 1;
        }

        //http://www.w3schools.com/JQuery/tryit.asp?filename=tryjquery_event_hover
    } else {
        if (isset($_FILES) && $_FILES['file']['type'] == '')
            echo "<span>Please Choose a file by click on 'Browse' or 'Choose File' button.</span>";
    }
}
?>
