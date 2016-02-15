<?php
session_start();
$verticaal = $_SESSION["verticaal"];
if ($verticaal == 0){
    $verticaal = 1;
}
else{
    $verticaal = 0;
}
$_SESSION["verticaal"] = $verticaal;

echo '<script type="text/javascript">';
echo '$("#loading_spinner").hide()';
echo '</script>';
?>

