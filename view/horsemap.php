<?php

// TODO show each line in polyline in different colors

//TODO slider med unix timestamp date1, increment 24h, rendera med ng filter
//  <input slider ng-model="unixTime" type="text" options="{ from: 1, to: 100, step: 1 }" />

//TODO reset button: reset zoom and focus

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
    <script src="js/angularjs/i18n/angular-locale_sv-se.js"></script>
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
            events="map.events" >

            <polyline
                ng-if="horseRedMarkers.length > 1"
                path="horseRedMarkers"
                stroke="{ color: '#d04f4f', weight: 3}"
                />

            <circle
                    ng-if="horseBlueMarkers.length > 1"
                    ng-repeat="mark in horseBlueMarkers"
                    center="mark"
                    radius="10"
                    stroke="{ color: '#5139af', weight: 3, opacity: 0.8 }"
                    fill="{ color: '#5139af', opacity: 0.8 }"
                    />

<!--
            <polyline
                ng-if="horseBlueMarkers.length > 1"
                path="horseBlueMarkers"
                stroke="{ color: '#5139af', weight: 3}"
                />
-->
            <markers
                ng-if="showGroundMarkers"
                models="horseGroundMarkers"
                coords="'self'"
                />
        </div>
    </div>

    <div class="container">

        <pre>{{ pager.unixCurrentTime * 1000 | date:'medium' }} to {{ (pager.unixCurrentTime + pager.increaseSeconds) * 1000 | date:'medium' }} - {{ pager.increaseSeconds / 3600 }} hours</pre>
        <pre>red {{ horseRedMarkers.length }}, blue {{ horseBlueMarkers.length }}</pre>
        <!--
        <pager total-items="pager.totalItems" ng-model="pager.currentPage"></pager>
        <br/>

        <div pagination total-items="pager.totalItems" ng-model="pager.currentPage"></div>
        <br/>
        -->

        <button class="btn btn-info" ng-click="pager.setPeriod(1); pager.setPage(-24)">21 maj</button>
<!-- these because pagination dont show up due to ??? NO IDEA! -->
        <button class="btn btn-info" ng-click="pager.setPage(pager.currentPage-1)">dec</button>
        <button class="btn btn-info" ng-click="pager.setPage(pager.currentPage+1)">inc</button>
        <br/>

        <button class="btn btn-info" ng-click="pager.setPeriod(1)">1 hour</button>
        <button class="btn btn-info" ng-click="pager.setPeriod(4)">4 hour</button>
        <button class="btn btn-info" ng-click="pager.setPeriod(8)">8 hour</button>
        <button class="btn btn-info" ng-click="pager.setPeriod(24)">24 hour</button>

        <button class="btn btn-info" ng-click="pager.setPeriod(24*7)">7 days</button>
        <button class="btn btn-info" ng-click="pager.setPeriod(24*14)">14 days</button>
        <button class="btn btn-info" ng-click="pager.setPeriod(24*30)">30 days</button>

        <label>
            <input type="checkbox" ng-model="showGroundMarkers" />
            Show ground markers
        </label>

    </div>

    <!-- TODO gmaps libraries=weather,geometry,visualization -->

    <script src="//maps.googleapis.com/maps/api/js?sensor=false&language=en&v=3.16"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.underscore.js"></script>
    <script src="js/angular-google-maps/angular-google-maps.js"></script>

    <script src="js/controller/horsemap.js" type="text/javascript"></script>

    <link href="scss/horsemap" rel="stylesheet" type="text/css"/>

</body>

</html>
