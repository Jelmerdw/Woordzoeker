<?php

$letters = "abcdefghijklmnopqrstuvwxyz";
$regel = array('-', 'W');
foreach($regel as $i => $W) {
$regel = str_split("-Wat----");
foreach ($regel as $i => $W) {
    if ($W == '-') {
  $l = random(0,26);
          $regel[$i] = $letters[$l];
    }  
        $l = rand(0, 3);
       // print_r($regel);
        $regel[$i] = $letters[$l];
        //print_r($regel);
    }
}
$regels = FILE("bestand");
foreach($regels as $regelNr => $data) {
    
    if ($data == '');{ 
print implode("", $regel);
//print_r($regel);
$regels = FILE("text.txt");
foreach ($regels as $regelNr => $data) {

    if ($data == '') {
        break;
    }
    $wz[$regelNr] = $data;
}
//print_r($wz);
?>
