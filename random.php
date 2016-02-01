<?php
$letters = "abcdefghijklmnopqrstuvwxyz";
$regel = array('-');
foreach($regel as $i => $W) {
//$regel = str_split("---");
foreach ($regel as $i => $W) {
    if ($W == '-') {
      $l = rand(0,26);
      $regel[$i] = $letters[$l];
    }  
     }
}
$regels = FILE("text.txt");
foreach($regels as $regelNr => $data) {
       if ($data == ''){ 
        break;
    }
    $wz[$regelNr] = $data;
print implode("", $regel);
}
?>