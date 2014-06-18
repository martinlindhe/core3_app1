'use strict';

// registerFormSubmit
angular.module('registerUserApp', [])
    .controller('FormController', function($scope, $http) {

        $scope.newUser = {};

        $scope.addUser = function(userData) {
            console.log("trying to register " + userData.username);

            // TODO call api with register attempt

            // XXX fails to access form properties

            $http({
                method: 'POST',
                url: 'api/core-register-user',
                data: {
                    'username': userData.username,
                    'password': userData.password,
                    'email': userData.email
                }
            }).success(function(data,status,headers,cfg) {
                ctrl.$setValidity('unique', data.isAvailable);
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
                    console.log("minlen " + attrs.ngMinlength);

                    // add a parser that will process each time the value is 
                    // parsed into the model when the user updates it.
                    ctrl.$parsers.unshift(function(value) {
                        // FIXME delayed checking is broken
                        // FIXME also validitiy is broken (dont get valid even when result is true)

                       // if (!checking) {
                            console.log('checking if username "'+value+'" is in use');

                      //      checking = $timeout(function() {
                                $http({
                                    method: 'POST',
                                    url: 'api/core-username-free/'+value,
                                    data: {'username': value}
                                }).success(function(data, status, headers, cfg) {
                                    ctrl.$setValidity('unique', data.isAvailable);
                                });
                        //    }, 500);
                        //}
                    });
                });
            }
        }
    });
