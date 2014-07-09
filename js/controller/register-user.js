'use strict';

// registerFormSubmit
angular.module('registerUserApp', [])
    .controller('FormController', function($scope, $http) {

        $scope.newUser = {};

        $scope.addUser = function(userData) {
            console.log("trying to register " + userData.username);

            $http({
                method: 'POST',
                url: 'api/core-register-user',
                data: {
                    'username': userData.username,
                    'password': userData.password,
                    'email': userData.email
                }
            }).success(function(data,status,headers,cfg) {
                console.log("FAKED register success!");
                // TODO STORE session auth token & change state to logged in

            }).error(function(data, status, headers, config) {
                // TODO raise UI error that communication failed
            });
        };
    })

    .directive('usernameFree', function($http, $timeout) {
        var checking = null;
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                scope.$watch(attrs.ngModel, function() {
                    console.log("usernameFree directive triggered");

                    var val = elm.val();
                    if (!val) {
                        return;
                    }
                    
                    if (checking != null) {
                        $timeout.cancel(checking);
                    }

                    checking = $timeout(function() {
                        console.log('checking if username "'+val+'" is in use');
                        $http({
                            method: 'POST',
                            url: 'api/core-username-free/',
                            data: {'username': val}
                        }).success(function(data, status, headers, cfg) {
                            ctrl.$setValidity('unique', data.isAvailable);
                        });
                    }, 200);
                });
            }
        }
    });
