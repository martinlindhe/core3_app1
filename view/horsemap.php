<?php

// TODO slider

// TODO add json view for \ReaderCsvHagenPos::addMarkersToMap($map, __DIR__.'/pos4.csv');
// TODO show each line in polyline in different colors

//TODO slider med unix timestamp date1, increment 24h, rendera med ng filter
//  <input slider ng-model="unixTime" type="text" options="{ from: 1, to: 100, step: 1 }" />


// FIXME <polyline> due to bug, if array is initally empty view never get populated,
//                 we work around with ng-if,
//                 https://github.com/nlaplante/angular-google-maps/issues/522

?>
<!DOCTYPE html>
<html lang="en" ng-app="horseMap">

<head>
    <base href="<?=$webRoot;?>"/>

    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <script src="js/angularjs/angular.js"></script>
    <script src="js/angular-ui-bootstrap/ui-bootstrap-tpls.js"></script>

    <!--
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.11.0/ui-bootstrap-tpls.js"></script>
    -->

</head>

<body ng-controller="GoogleMapController">

    <div class="container-fluid" id="map_canvas">

        <div
            google-map
            refresh="true"
            draggable="true"
            center="map.center"
            zoom="map.zoom"
            options="map.options"
            events="map.events"
        >
            <polyline
                ng-if="horseRedMarkers.length > 1"
                path="horseRedMarkers"
                stroke="{ color: '#d04f4f', weight: 3}"
                />

            <polyline
                ng-if="horseBlueMarkers.length > 1"
                path="horseBlueMarkers"
                stroke="{ color: '#5139af', weight: 3}"
                />
        </div>
    </div>

    <div class="container">

        <pre>{{ unixCurrentTime * 1000 | date:fullDate }}, page {{pager.currentPage}}</pre>
        <br/>
        <pager total-items="pager.totalItems" ng-model="pager.currentPage"></pager>
        <br/>

        <div pagination total-items="pager.totalItems" ng-model="pager.currentPage"></div>
        <br/>


        <button class="btn btn-info" ng-click="pager.setPage(0)">Oldest date</button>
<!-- these because pagination dont show up due to ??? NO IDEA! -->
        <button class="btn btn-info" ng-click="pager.setPage(pager.currentPage-1)">dec</button>
        <button class="btn btn-info" ng-click="pager.setPage(pager.currentPage+1)">inc</button>
    </div>

    <!-- TODO gmaps libraries=weather,geometry,visualization -->

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&language=en&v=3.16"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.underscore.js"></script>
    <script src="js/angular-google-maps/angular-google-maps.js"></script>

    <script src="js/controller/horsemap.js" type="text/javascript"></script>

    <link href="scss/horsemap" rel="stylesheet" type="text/css"/>

</body>

</html>
