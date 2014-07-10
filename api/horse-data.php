<?php

// FIXME should be $param[0]; currently  holds "coord-horse" ie view name
// TODO FIXME core3: since this is routed from core3 view/api.php, params are not re-initialized properly
// FIXME param1 should be 0

WriterHorseDataCache::passThru($param[1]);
