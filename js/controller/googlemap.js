'use strict';

angular.module('appMaps', ['google-maps'])
    .controller('GoogleMapController', function($scope) {

        $scope.map = {
            center: {latitude: 59.742656, longitude: 17.675384 },
            zoom: 15,
            options: {mapTypeId: google.maps.MapTypeId.HYBRID }
        };

/*
        var createRandomMarker = function (i, bounds, idKey) {
            var lat_min = bounds.southwest.latitude,
                lat_range = bounds.northeast.latitude - lat_min,
                lng_min = bounds.southwest.longitude,
                lng_range = bounds.northeast.longitude - lng_min;

            if (idKey == null) {
                idKey = "id";
            }

            var latitude = lat_min + (Math.random() * lat_range);
            var longitude = lng_min + (Math.random() * lng_range);
            var ret = {
                latitude: latitude,
                longitude: longitude,
                title: 'm' + i,
                show: false
            };
            ret.onClick = function() {
                console.log("Clicked!");
                ret.show = true;
                $scope.$apply();
            };
            ret[idKey] = i;
            return ret;
        };

        $scope.randomMarkers = [];
        // Get the bounds from the map once it's loaded
        $scope.$watch(function() { return $scope.map.bounds; }, function(nv, ov) {
            // Only need to regenerate once
            if (!ov.southwest && nv.southwest) {
                var markers = [];
                for (var i = 0; i < 50; i++) {
                    markers.push(createRandomMarker(i, $scope.map.bounds))
                }
                $scope.randomMarkers = markers;
            }
        }, true);
        */
    });
