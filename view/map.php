<?php
    
$doc = new \Writer\DocumentHtml5();

$map = new \JsMap\Google();
$map->setLatitude(59.742656);
$map->setLongitude(17.675384);
$map->setZoom(14);
$map->setMapType('HYBRID');

$mapCss =
    '#'.$map->getDivId().'{'.
        'width:500px;'.
        'height:500px;'.
    '}';
$doc->attachToBody('<style>'.$mapCss.'</style>');

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

$map->renderToDocument($doc);


echo $doc->render();
