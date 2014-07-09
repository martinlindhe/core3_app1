'use strict';

angular.module('coreSpreadsheet', [])
    .controller('SpreadsheetController', function($scope, $http) {
        $scope.headers = {'id':'ID', 'name':'Name', 'decimalNumber':'Number', 'datestamp':'Date'};
        $scope.headerOrder = ['id', 'name', 'decimalNumber', 'datestamp'];
        $scope.sortKey = $scope.headerOrder[0];
        $scope.sortReverse = false;

        $http({method: 'GET', url: 'api/spreadsheet/123'}).
            success(function(data, status, headers, config) {
                $scope.result = data;
            });
    });
