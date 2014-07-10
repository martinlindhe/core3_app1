<?php

// TODO slider

// TODO add json view for \ReaderCsvHagenPos::addMarkersToMap($map, __DIR__.'/pos4.csv');
// TODO show each line in polyline in different colors
?>
<!DOCTYPE html>
<html ng-app="horseMap" lang="en">

<head>
    <base href="<?=$webRoot;?>"/>

    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <script src="js/angularjs/angular.js"></script>
    <script src="js/angular-ui-bootstrap/ui-bootstrap-tpls.js"></script>

</head>

<body ng-controller="GoogleMapController">
    <div class="container-fluid" id="map_canvas">

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

        <!-- TODO gmaps libraries=weather,geometry,visualization -->
        <script src="https://maps.googleapis.com/maps/api/js?sensor=false&language=en&v=3.16"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.underscore.js"></script>
        <script src="js/angular-google-maps/angular-google-maps.js"></script>
        <script src="js/controller/horsemap.js" type="text/javascript"></script>

        <link href="scss/horsemap" rel="stylesheet" type="text/css"/>

    </div>


    <div class="container">
        <p>time {{ unixTime * 1000 | date:fullDate }}</p>

            <!-- TODO slider med unix timestamp date1, increment 24h, rendera med ng filter -->
             <!-- <input slider ng-model="unixTime" type="text" options="{ from: 1, to: 100, step: 1 }" /> -->
        <p>
            <pre>The selected page no: {{pager.currentPage}}</pre>
            <pager total-items="pager.totalItems" ng-model="pager.currentPage"></pager>

            <button class="btn btn-info" ng-click="pager.setPage(3)">Set current page to: 3</button>
        </p>


    </div>

</body>

</html>
