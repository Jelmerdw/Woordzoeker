<?php
session_start();
$horizontaal = $_SESSION["horizontaal"];
if ($horizontaal == 0){
    $horizontaal = 1;
}
else{
    $horizontaal = 0;
}
$_SESSION["horizontaal"] = $horizontaal;

echo '<script type="text/javascript">';
echo '$("#loading_spinner").hide()';
echo '</script>';
?>

