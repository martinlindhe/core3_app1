'use strict';

angular.module('horseMap', ['google-maps'])
    .controller('GoogleMapController', function($scope, $http) {

        $scope.map = {
            center: {latitude: 59.742656, longitude: 17.675384 },
            zoom: 15,
            options: {mapTypeId: google.maps.MapTypeId.HYBRID }
        };

        $http({method: 'GET', url: 'api/coord-horses/4664/20140629'}).
            success(function(data, status, headers, config) {
                $scope.horseRedMarkers = data;
            });

        $http({method: 'GET', url: 'api/coord-horses/4665/20140629'}).
            success(function(data, status, headers, config) {
                $scope.horseBlueMarkers = data;
            });


    });
