<?php
    
$doc = new \Writer\DocumentHtml5();

$map = new \JsMap\Google();
$coord = new \JsMap\Coordinate(59.742656, 17.675384);
$map->setCenter($coord);
$map->setZoom(14);
$map->setMapType('HYBRID');

//$map->addKmlLayer('http://app1.dev/app1/kml'); // XXX dont work because google maps include file from servers,need public url

//$map->addKmlLayer('http://api.flickr.com/services/feeds/geo/?g=322338@N20&lang=en-us&format=feed-georss');

$doc->embedCss(
    '#'.$map->getDivId().'{'.
        'width:500px;'.
        'height:300px;'.
        'border:1px solid #000;'.
    '}'
);

$csvReader = new \Reader\Csv();
$rows = $csvReader->parseFile('/Users/ml/dev/core3_app1/view/pos3.csv');

foreach ($rows as $row) {
    $coord = \JsMap\CoordinateConverter::SWEREF99TM_to_WGS84($row[2], $row[1]);
    $mark = new \JsMap\GoogleMapMarker($coord->latitude, $coord->longitude);
    $mark->setTooltip($row[0]);
   	$map->addMarker($mark);
}

$map->attachToDocument($doc);


echo $doc->render();
