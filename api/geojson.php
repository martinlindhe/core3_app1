<?php

function isValidViewName($key)
{
    if (preg_match('/^[a-zA-Z0-9-]+$/', $key) != 1) {
        return false;
    }
    return true;
}

$viewName = $param[0];
if (!isValidViewName($viewName)) {
    throw new \Exception('bad input');
}

$jsonFile = __DIR__.'/../geojson/'.$viewName.'.geojson';

if (!file_exists($jsonFile)) {
    http_response_code(404);
    die;
}

include $jsonFile;
