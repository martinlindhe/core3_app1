'use strict';

// registerFormSubmit
angular.module('registerUserApp', [])
	.controller('RegisterController', function($scope, $http) {

	})

	/**
	 * See if username is available
	 */
	.directive('usernameCheck', function($http) {
		var toId;
		return {
			require: 'ngModel',
			link: function(scope, elm, attrs, ctrl) {
				console.log('hello');
				ctrl.$parsers.unshift(function(viewValue) {

					if (viewValue.length < 3) {
						return; // FIXME check shouldnt be needed, this should not trigger because of ng-minlength=3
					}

					if (toId) {
						clearTimeout(toId);
					}

					toId = setTimeout(function() {
						$http({
							method: 'POST',
							url: '/app1/api-core-username-free',
							data: {'username': viewValue}
						}).success(function(data,status,headers,cfg) {
							ctrl.$setValidity('unique', data.isAvailable);
						});
					}, 300);
				});
			}
		}
	});
