<?php
session_start();
$diagonaal = $_SESSION["diagonaal"];
if ($diagonaal == 0){
    $diagonaal = 1;
}
else{
    $diagonaal = 0;
}
$_SESSION["diagonaal"] = $diagonaal;

echo '<script type="text/javascript">';
echo '$("#loading_spinner").hide()';
echo '</script>';
?>

