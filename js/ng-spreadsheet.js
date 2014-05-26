'use strict';

var app = angular.module('coreSpreadsheet', []);

app.controller('SpreadsheetController', ['$scope', function($scope)
{
	$scope.headers = {'id':'ID', 'name':'Name', 'decimalNumber':'Number', 'datestamp':'Date'};
	$scope.headerOrder = ['id', 'name', 'decimalNumber', 'datestamp'];
	$scope.sortKey = $scope.headerOrder[0];
	$scope.sortReverse = false;

	$scope.result = [
		{"id":1,"name":"mr mr","decimalNumber":3.14,"datestamp":"1400078166806"},
		{"id":2,"name":"oteth","decimalNumber":5.559,"datestamp":"1300088166806"},
		{"id":3,"name":"smtmhm","decimalNumber":1,"datestamp":"1401098166806"},
		{"id":4,"name":"atlast","decimalNumber":55,"datestamp":"1101098166806"},
	];
}]);
