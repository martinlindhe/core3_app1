<?php

// FIXME should be param[0], core api view routing should fix param
$jsonFile = __DIR__.'/../geojson/'.$param[1].'.geojson'; // TODO isValidViewName

if (!file_exists($jsonFile)) {
    http_response_code(404);
    die;
}

include $jsonFile;
