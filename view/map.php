<?php
/*
$doc = new \Writer\DocumentHtml5();

$map = new \JsMap\Google(); // XXX to pure js file
$map->setCenter(new \JsMap\Coordinate(59.742656, 17.675384));
$map->setZoom(15);
$map->setMapType('HYBRID');

$map->loadGeoJson('geojson/hagen');
//$map->loadGeoJson('geojson/stangsel');

//\ReaderCsvHagenPos::addMarkersToMap($map, __DIR__.'/pos4.csv');

\ReaderHorseData::addMarkersToMap($map, __DIR__.'/4664.csv', $param[0]);


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
*/

?>
<!DOCTYPE html>
<html ng-app="appMaps">

<head>
    <base href="<?=$webRoot;?>"/>
    <link href="assets/stylesheets/example.css" rel="stylesheet" type="text/css">
    <script src="https://maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization&sensor=false&language=en&v=3.14"></script>
    <script src="https://code.angularjs.org/1.2.16/angular.js" data-semver="1.2.16"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.underscore.js"></script>
    <script src="js/angular-google-maps/angular-google-maps.js"></script>
    <script src="js/controller/googlemap.js" type="text/javascript"></script>

    <link href="scss/googlemap" rel="stylesheet" type="text/css"/>
</head>

<body>
    <div id="map_canvas" ng-controller="mainCtrl">
    <google-map center="map.center" zoom="map.zoom" draggable="true" options="options" bounds="map.bounds">
        <markers models="randomMarkers" coords="'self'" icon="'icon'" click="'onClick'">
            <windows show="'show'">
                <div ng-non-bindable>{{title}}</div>
            </windows>
        </markers>
    </google-map>
</div>

</body>

</html>
