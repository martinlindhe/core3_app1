'use strict';

angular.module('bookApp', ['ngRoute'])
	.controller('MainController', function($scope, $route, $routeParams, $location) {
		$scope.$route = $route;
		$scope.$location = $location;
		$scope.$routeParams = $routeParams;
	})

	.controller('BookController', function($scope, $routeParams) {
		$scope.name = "BookController";
		$scope.params = $routeParams;
	})

	.controller('ChapterController', function($scope, $routeParams) {
		$scope.name = "ChapterController";
		$scope.params = $routeParams;
	})

	.config(function($routeProvider, $locationProvider) {
		var root = '/app1/';
		$routeProvider
		.when(root + 'books/Book/:bookId', {
			templateUrl: root + 'partials/book.html',
			controller: 'BookController'
		})
		.when(root + 'books/Book/:bookId/ch/:chapterId', {
			templateUrl: root + 'partials/chapter.html',
			controller: 'ChapterController'
		});

		// configure html5 to get links working on jsfiddle
		$locationProvider.html5Mode(true);
	});
