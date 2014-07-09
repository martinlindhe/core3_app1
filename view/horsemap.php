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



// TODO show each line in polyline in different colors
?>
<!DOCTYPE html>
<html ng-app="horseMap">

<head>
    <base href="<?=$webRoot;?>"/>
    <script src="js/angularjs/angular.js"></script>
    <!-- TODO gmaps libraries=weather,geometry,visualization -->
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&language=en&v=3.16"></script>

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
            events="map.events"
        >
            <polyline
                ng-if="horseRedMarkers.length > 1"
                path="horseRedMarkers"
                coords="'self'"
                stroke="{ color: '#d04f4f', weight: 3}"
                static="true" />

            <!-- FIXME due to bug, if array is initally empty view never get populated,
                 we work around with ng-if,
                 https://github.com/nlaplante/angular-google-maps/issues/522
             -->
            <polyline
                ng-if="horseBlueMarkers.length > 1"
                path="horseBlueMarkers"
                stroke="{ color: '#5139af', weight: 3}"
                static="true" />


        </div>
        <script src="js/angular-google-maps/angular-google-maps.js"></script>
        <script src="js/controller/horsemap.js" type="text/javascript"></script>

        <link href="scss/horsemap" rel="stylesheet" type="text/css"/>

    </div>

</body>

</html>
