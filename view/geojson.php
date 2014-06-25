<?php
/*
For Geojson export from qgis, the target CRS must be EPSG:4326.
You have to set that manually when using Rightclick->Save As....
*/
$jsonFile = __DIR__.'/../geojson/'.$param[0].'.geojson';

if (!file_exists($jsonFile)) {
    http_response_code(404);
    die;
}

header('Content-Type: text/json');
include $jsonFile;
