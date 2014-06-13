'use strict';

// registerFormSubmit
angular.module('registerUserApp', [])
	.controller('FormController', function($scope, $http) {

		$scope.addUser = function(userData) {
			console.log("trying to register " + userData.username);

			// TODO call api with register attempt

			// XXX fails to access form properties

			$http({
				method: 'POST',
				url: '/api-core-register',
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


	/**
	 * See if username is available
	 */
	.directive('usernameCheck', function($http) {
		var toId;
		// FIXME, using this usernmae check the register form dont work. "username" is not available on form subit for example
		return {
			restrict: 'A',
			require: 'ngModel',
			link: function(scope, elm, attrs, ctrl) {
				ctrl.$parsers.unshift(function(viewValue) {
					// TODO can we inherit checks from normal "text" checking somehow?
					console.log("minlen " + attrs.ngMinlength);

					if (attrs.ngMinlength) {
						if (viewValue.length < attrs.ngMinlength) {
							// FIXME the ui error dont show up..
							// XXX set dirty required also?
							scope.signupForm.$setValidity('minlength', false);

							console.log("not valid len");
							return;
						} else {
							scope.signupForm.$setValidity('minlength', true);
						}
					}

					if (attrs.ngMaxlength) {
						if (viewValue.length > attrs.ngMaxlength) {
							ctrl.$setValidity('maxlength', false);
							console.log("not valid max len");
							return;
						} else {
							ctrl.$setValidity('maxlength', true);
						}
					}


					if (toId) {
						clearTimeout(toId);
					}

					toId = setTimeout(function() {
						console.log('checking if username "'+viewValue+'" is in use');
						$http({
							method: 'POST',
							url: '/api-core-username-free',
							data: {'username': viewValue}
						}).success(function(data,status,headers,cfg) {
							ctrl.$setValidity('unique', data.isAvailable);
						});
					}, 300);
				});
			}
		}
	});
