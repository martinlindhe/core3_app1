'use strict';

Date.prototype.yyyymmdd = function() {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();

    return yyyy +
        (mm[1] ? mm : "0" + mm[0]) +
        (dd[1] ? dd : "0" + dd[0]); // padding
};

angular.module('horseMap', ['google-maps'])
    .controller('GoogleMapController', function($scope, $http, $log) {

        $scope.map = {
            center: { latitude: 59.7445, longitude: 17.675 },
            zoom: 15,
            options: { mapTypeId: google.maps.MapTypeId.HYBRID },
            events: {
                tilesloaded: function (map) {
                    $scope.$apply(function () {
                        if ($scope.loadedTiles) {
                            return;
                        }
                        $scope.loadedTiles = true;
                        map.data.loadGeoJson('api/geojson/hagen');
                        //map.data.loadGeoJson('api/geojson/stangsel');
                    });
                }
            }
        };

        $scope.unixTime = 1400623200; // 2014-05-21 00:00:00;
        var date = new Date($scope.unixTime * 1000);
        $log.info('yyyymmdd ' + date.yyyymmdd());

        /// TODO Start date 20140521, end 20140701

        // TODO slider med unix timestamp date1, increment 24h, rendera med ng filter

/*
        $http({method: 'GET', url: 'geojson/hagen'}).
            success(function(data, status, headers, config) {
                $log.info("got hagen");

                // XXX how to map geojson file into a shape?! this should be the un-hacky way
                // BUG https://github.com/nlaplante/angular-google-maps/issues/551
                $scope.shapeHagen = data.features;
                $log.info(data.features);
            });
*/
        $http({method: 'GET', url: 'api/coord-horses/4664/' + date.yyyymmdd()}).
            success(function(data, status, headers, config) {
                $scope.horseRedMarkers = data;
            });

        $http({method: 'GET', url: 'api/coord-horses/4665/' + date.yyyymmdd()}).
            success(function(data, status, headers, config) {
                $scope.horseBlueMarkers = data;
            });

    });
