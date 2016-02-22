<?php
session_start();

function onoff_verticaal(&$verticaal) {

    if ($verticaal == 0) {
        $verticaal = 1;
    } else {
        $verticaal = 0;
    }
    $_SESSION["verticaal"] = $verticaal;

    echo '<script type="text/javascript">';
    echo '$("#loading_spinner").hide()';
    echo '</script>';
}

if (isset($_SESSION['verticaal'])) {
    $verticaal = $_SESSION["verticaal"];
}
onoff_verticaal($verticaal);
?>