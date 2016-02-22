<?php
session_start();

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