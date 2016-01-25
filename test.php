<?php

$letters = "abcdef...z";
$regel = array('-', 'W');
foreach($regel as $i => $W) {
    if ($W == '-') {
  $l = random(0,26);
          $regel[$i] = $letters[$l];
    }  
}
$regels = FILE("bestand");
foreach($regels as $regelNr => $data) {
    
    if ($data == '');{ 
        break;
    }
    $wz[$regelNr] = $data;
}
?>