<?php
    
$doc = new \Writer\DocumentHtml5();

$map = new \JsMap\Google();
$map->setCenter(new \JsMap\Coordinate(59.742656, 17.675384));
$map->setZoom(14);
$map->setMapType('HYBRID');

$map->loadGeoJson('geojson/hagen');
$map->loadGeoJson('geojson/stangsel');

$doc->embedCss(
    '#'.$map->getDivId().'{'.
        'width:500px;'.
        'height:300px;'.
        'border:1px solid #000;'.
    '}'
);

$csvReader = new \Reader\Csv();
$rows = $csvReader->parseFile(__DIR__.'/pos3.csv');

foreach ($rows as $row) {
    $coord = \JsMap\CoordinateConverter::SWEREF99TM_to_WGS84($row[2], $row[1]);
    $mark = new \JsMap\GoogleMapMarker($coord->latitude, $coord->longitude);
    $mark->setTooltip($row[0]);
    $mark->setIcon(
        '{'.
            'path: google.maps.SymbolPath.CIRCLE,'.
            'scale: 2,'.
            'strokeColor: "red"'.
        '}'
    );
    $map->addMarker($mark);
}

$map->attachToDocument($doc);


echo $doc->render();
