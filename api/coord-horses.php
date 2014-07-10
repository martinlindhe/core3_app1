<?php

// FIXME should be $param[0]; currently  holds "coord-horse" ie view name
// TODO FIXME core3: since this is routed from core3 view/api.php, params are not re-initialized properly
$tokens = explode('-', $param[1]);   // FIXME should be 0

$cacheFileName = __DIR__.'/../horse-data/cache/'.$param[1];
if (!file_exists($cacheFileName)) {
    throw new \Exception('no such file');
}

echo file_get_contents($cacheFileName);
