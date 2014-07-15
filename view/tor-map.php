<?php

$doc = new \Writer\DocumentHtml5();

$map = new \JsMap\Google();
$map->setCenter(new \JsMap\Coordinate(59.742656, 17.675384));
$map->setZoom(5);
//$map->setMapType('HYBRID');

$doc->embedCss(
    'html,body{'.
        'height:100%;'.
        'margin:0;'.
        'padding:0;'.
    '}'.
    '#'.$map->getDivId().'{'.
        'width:100%;'.
        'height:100%;'.
        'border:1px solid #000;'.
    '}'.
    '.mapInfoWnd{'.
        'font-size:9px;'.
        'line-height:9px;'.
    '}'
);



 $reader = new ReaderTorNodes();
 $nodes = $reader->parse();

$geoip = new \Web\GeoIp();

foreach ($nodes->routers as $router) {

    $rec = $geoip->getRecord($router->ip);

    $mark = new \JsMap\GoogleMapMarker($rec->latitude, $rec->longitude);

    $infoStr = $router->nickname;
    $info = '<div class=\"mapInfoWnd\">'.$infoStr.'</div>';
    $mark->setInfoWindow($info);
    $map->addMarker($mark);
}

$map->attachToDocument($doc);


echo $doc->render();
