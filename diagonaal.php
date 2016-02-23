<?php
session_start();

//Deze functie zet diagonaal zoeken aan (1) als het uit staat
//en zet het uit (0) als het aan staat:
function onoff_diagonaal(&$diagonaal) {

    if ($diagonaal == 0) {
        $diagonaal = 1;
    } else {
        $diagonaal = 0;
    }
    $_SESSION["diagonaal"] = $diagonaal;

    echo '<script type="text/javascript">';
    echo '$("#loading_spinner").hide()';
    echo '</script>';
}

if (isset($_SESSION['diagonaal'])) {
    $diagonaal = $_SESSION["diagonaal"];
}
onoff_diagonaal($diagonaal);
?>