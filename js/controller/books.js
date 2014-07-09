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
        $locationProvider.html5Mode(true);

        $routeProvider
        .when('/books/Book/:bookId', {
            templateUrl: 'partials/books/book.html',
            controller: 'BookController'
        })
        .when('/books/Book/:bookId/ch/:chapterId', {
            templateUrl:'partials/books/chapter.html',
            controller: 'ChapterController'
        });
    });
