'use strict';

Date.prototype.horseDateTime = function() {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    var hour = this.getHours().toString();
    var min = this.getMinutes().toString();

    return yyyy +
        (mm[1] ? mm : "0" + mm[0]) +
        (dd[1] ? dd : "0" + dd[0]) +
        (hour[1] ? hour : "0" + hour[0]) +
        (min[1] ? min : "0" + min[0]) +
        '00';
};


angular.module('horseMap', ['google-maps'])
    .controller('GoogleMapController', function($scope, $http, $log) {

        $scope.pager = {
            totalItems: 64,
            currentPage: 0,
            increaseSeconds: 60 * 60 * 1, // 1h
            setPage: function (pageNo) {
                $scope.pager.currentPage = pageNo;

                $scope.pager.unixCurrentTime = $scope.unixStartTime + (pageNo * $scope.pager.increaseSeconds);

                var date = new Date($scope.pager.unixCurrentTime * 1000);

                // 4664-äskil
                $http({method: 'GET', url: 'api/horse-data/4664-' + date.horseDateTime() + '-' + $scope.pager.increaseSeconds}).
                    success(function(data, status, headers, config) {
                        $scope.horseRedMarkers = data;
                    });

                // 4665-messer
                $http({method: 'GET', url: 'api/horse-data/4665-' + date.horseDateTime() + '-' + $scope.pager.increaseSeconds}).
                    success(function(data, status, headers, config) {
                        $scope.horseBlueMarkers = data;
                    });
            },
            setPeriod: function (hours) {
                $scope.pager.increaseSeconds = hours * 60 * 60;
                $scope.pager.setPage($scope.pager.currentPage); // HACK forces reload
            }
        }

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

        $scope.unixStartTime = 1400709600; // 2014-05-22 00:00:00;
        $scope.unixCurrentTime = $scope.unixStartTime;

        $scope.pager.setPage(0); // XXX INITIAL load

        // https://github.com/nlaplante/angular-google-maps/issues/522



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


    });
