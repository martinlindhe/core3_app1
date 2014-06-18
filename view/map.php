<?php
    
$doc = new \Writer\DocumentHtml5();

$map = new \JsMap\Google();
$coord = new \JsMap\Coordinate(59.742656, 17.675384);
$map->setCenter($coord);
$map->setZoom(14);
$map->setMapType('HYBRID');

$doc->embedCss(
    '#'.$map->getDivId().'{'.
        'width:500px;'.
        'height:300px;'.
        'border:1px solid #000;'.
    '}'
);

$rawData = file_get_contents('/Users/ml/dev/core3_app1/view/pos.csv');

$rows = explode("\n", $rawData);
$rowCount = 0;

foreach ($rows as $row) {
    $rowCount++;
    $cols = explode(',', $row);

    if (count($cols) == 2) {
        $coord = \JsMap\CoordinateConverter::SWEREF99TM_to_WGS84($cols[1], $cols[0]);
        $mark = new \JsMap\GoogleMapMarker($coord->latitude, $coord->longitude);
        $mark->setTooltip($rowCount);
        $map->addMarker($mark);
    }
}

$map->attachToDocument($doc);


echo $doc->render();
