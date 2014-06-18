'use strict';

angular.module('coreSpreadsheet', [])
	.controller('SpreadsheetController', function($scope, $http) {
		$scope.headers = {'id':'ID', 'name':'Name', 'decimalNumber':'Number', 'datestamp':'Date'};
		$scope.headerOrder = ['id', 'name', 'decimalNumber', 'datestamp'];
		$scope.sortKey = $scope.headerOrder[0];
		$scope.sortReverse = false;

		$http({method: 'GET', url: '/app1/api-spreadsheet/123'}). // TODO inject $webRoot
			success(function(data, status, headers, config) {
				$scope.result = data;
			}).
			error(function(data, status, headers, config) {
				// TODO raise UI error that communication failed
			});
	});
