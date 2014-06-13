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
		var urlRoot = '/books';
		var templateRoot = '/partials/books';

		$routeProvider
		.when(urlRoot + '/Book/:bookId', {
			templateUrl: templateRoot + '/book.html',
			controller: 'BookController'
		})
		.when(urlRoot + '/Book/:bookId/ch/:chapterId', {
			templateUrl: templateRoot + '/chapter.html',
			controller: 'ChapterController'
		});

		// configure html5 to get links working on jsfiddle
		$locationProvider.html5Mode(true);
	});
