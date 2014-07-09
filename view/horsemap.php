<?php
/*
$doc = new \Writer\DocumentHtml5();

//$map = new \JsMap\Google(); // XXX to pure js file
//$map->setCenter(new \JsMap\Coordinate(59.742656, 17.675384));
//$map->setZoom(15);
//$map->setMapType('HYBRID');



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



// TODO: show red horses markers in red, blue in blue!

?>
<!DOCTYPE html>
<html ng-app="horseMap">

<head>
    <base href="<?=$webRoot;?>"/>
    <script src="js/angularjs/angular.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization&sensor=false&language=en&v=3.14"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.underscore.js"></script>
</head>

<body>
    <div id="map_canvas" ng-controller="GoogleMapController">
        <div
            google-map
            draggable="true"
            center="map.center"
            zoom="map.zoom"
            options="map.options"
        >
            <markers models="horseRedMarkers" coords="'self'" icon="'icon'" click="'onClick'">
            </markers>

            <markers models="horseBlueMarkers" coords="'self'" icon="'icon'" click="'onClick'">
            </markers>

        </div>
        <script src="js/angular-google-maps/angular-google-maps.js"></script>
        <script src="js/controller/horsemap.js" type="text/javascript"></script>

        <link href="scss/horsemap" rel="stylesheet" type="text/css"/>

    </div>

</body>

</html>
