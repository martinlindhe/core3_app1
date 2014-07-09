<?php

if (!is_numeric($param[1])) {
    throw new \Exception('bad input');
}
$fileName = __DIR__.'/'.$param[1].'.csv';  // FIXME should be 0
if (!file_exists($fileName)) {
    throw new \Exception('not found '.$fileName);
}

// FIXME should be $param[1]; currently  holds "coord-horse" ie view name
$displayDate = $param[2]; // TODO FIXME core3: since this is routed from core3 view/api.php, params are not re-initialized properly
if ($displayDate && !is_numeric($displayDate)) {
    throw new \Exception('bad input');
}

$cacheFileName = __DIR__.'/horse-cache/'.basename($fileName).$displayDate;
if (file_exists($cacheFileName)) {
    echo file_get_contents($cacheFileName);
} else {
    $markers = \ReaderHorseData::parseIntoMarkers($fileName, $displayDate);

    $data = \Writer\Json::encode($markers);
    file_put_contents($cacheFileName, $data);
    echo $data;
}
