<?php

// FIXME should be $param[0]; currently 0 holds "coord-horse" ie view name
$displayDate = $param[1]; // TODO FIXME core3: since this is routed from core3 view/api.php, params are not re-initialized properly


// TODO: cache this output to disk, parsing of 400k csv is expensive
$markers = \ReaderHorseData::parseIntoMarkers(__DIR__.'/4664.csv', $displayDate);

echo \Writer\Json::encode($markers);
