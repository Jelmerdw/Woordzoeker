<?php

function uitvoeringen(&$uitgevoerd, &$herhalingen, &$einde) {
   // global $uitgevoerd, $herhalingen, $einde;
    
    if ($uitgevoerd < $herhalingen) {
        $uitgevoerd = $uitgevoerd + 1;
    }
    if ($uitgevoerd == $herhalingen) {
        $einde = 1;
    }
}