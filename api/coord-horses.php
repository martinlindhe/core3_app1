<?php

// FIXME should be $param[0]; currently  holds "coord-horse" ie view name
// TODO FIXME core3: since this is routed from core3 view/api.php, params are not re-initialized properly
$tokens = explode('-', $param[1]);   // FIXME should be 0
$horseId = $tokens[0];

$fileName = __DIR__.'/'.$horseId.'.csv';
$displayTs = $tokens[1];
$displayDuration = $tokens[2];



if (!file_exists($fileName)) {
    throw new \Exception('not found '.$fileName);
}

if ($displayTs && !is_numeric($displayTs)) {
    throw new \Exception('bad input');
}

if ($displayDuration && !is_numeric($displayDuration)) {
    throw new \Exception('bad input');
}


$cacheFileName = __DIR__.'/horse-cache/'.$horseId.'-'.$displayTs.'-'.$displayDuration;
if (file_exists($cacheFileName)) {
    echo file_get_contents($cacheFileName);
} else {
    $markers = \ReaderHorseData::parseIntoMarkers($fileName, $displayTs, $displayDuration);

    $data = \Writer\Json::encode($markers);
    file_put_contents($cacheFileName, $data);
    echo $data;
}
