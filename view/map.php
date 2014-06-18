<?php
/*
map div:
    protected $width  = 500;
    protected $height = 300;
*/
    
$doc = new \Writer\DocumentXhtml();

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

    // XXX convert
    if (count($cols) == 2) {
        $xx = \JsMap\CoordinateConverter::SWEREF99_TM_toWGS84($cols[1], $cols[0]);
        //var_dump($xx);
        $mark = new \JsMap\GoogleMapMarker($xx->latitude, $xx->longitude);
        $mark->setTooltip($rowCount);
        $map->addMarker($mark);
    }
}

$map->renderToDocument($doc);


echo $doc->render();
