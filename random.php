<?php
// ik heb array met daarin array van letters
// $woordzoeker[][]  'a' 'b' '-'
//                   'z' '-' 'd'
// als test
//$woordzoeker[] = str_split('ab-');
//$woordzoeker[] = str_split('z-d');

function replaceDash(Array $woordzoeker) {
    $letters = "abcdefghijklmnopqrstuvwxyz";
    $lettersArray = str_split($letters);
    print "<pre>";
    print_r($woordzoeker);
    foreach ($woordzoeker as $rij => $regel) {
        foreach ($regel as $kolom => $letter) {
            if ($letter == '-') {
                $pos = rand(0, strlen($letters));
                $woordzoeker[$rij][$kolom] = $lettersArray[$pos];
            }
        }
    }
    print_r($woordzoeker);
    return $woordzoeker;
}

// gebruik
//include_once 'random.php';
$woordzoeker = replaceDash($woordzoeker);
?>