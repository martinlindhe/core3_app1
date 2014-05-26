'use strict';

angular.module('indexApp', ['ngRoute'])
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
		$routeProvider
		.when('/Book/:bookId', {
			templateUrl: '/app1/partials/book.html',
			controller: 'BookController'
		})
		.when('/Book/:bookId/ch/:chapterId', {
			templateUrl: '/app1/partials/chapter.html',
			controller: 'ChapterController'
		})/*
		.otherwise({
			redirectTo: '/?ERROR_IN_ROUTING'
		})*/;

		// configure html5 to get links working on jsfiddle
		$locationProvider.html5Mode(true);
	});
