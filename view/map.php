<?php

$doc = new \Writer\DocumentHtml5();

$map = new \JsMap\Google();
$map->setCenter(new \JsMap\Coordinate(59.742656, 17.675384));
$map->setZoom(15);
$map->setMapType('HYBRID');

$map->loadGeoJson('geojson/hagen');
//$map->loadGeoJson('geojson/stangsel');

\ReaderCsvHagenPos::addMarkersToMap($map, __DIR__.'/pos4.csv');


$doc->embedCss(
    'html,body{'.
        'height:100%;'.
        'margin:0;'.
        'padding:0;'.
    '}'.
    '#'.$map->getDivId().'{'.
        //'width:1000px;'.
        //'height:600px;'.
        'width:100%;'.
        'height:100%;'.
        'border:1px solid #000;'.
    '}'.
    '.mapInfoWnd{'.
        //'color:#eeaa11;'.
        'font-size:9px;'.
        'line-height:9px;'.
    '}'
);

$map->attachToDocument($doc);


echo $doc->render();
