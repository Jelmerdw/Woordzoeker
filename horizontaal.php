<?php
session_start();

function onoff_horizontaal(&$horizontaal) {

    if ($horizontaal == 0) {
        $horizontaal = 1;
    } else {
        $horizontaal = 0;
    }
    $_SESSION["horizontaal"] = $horizontaal;

    echo '<script type="text/javascript">';
    echo '$("#loading_spinner").hide()';
    echo '</script>';
}

if (isset($_SESSION['horizontaal'])) {
    $horizontaal = $_SESSION["horizontaal"];
}
onoff_horizontaal($horizontaal);
?>