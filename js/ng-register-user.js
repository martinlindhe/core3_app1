'use strict';

// registerFormSubmit
angular.module('registerUserApp', [])
	.controller('RegisterController', function($scope, $http) {

		$scope.formSubmit = function() {
			console.log("trying to register");

			// TODO call api with register attempt

			$http({
				method: 'POST',
				url: '/app1/api-core-register',
				data: {'username': viewValue}  // TODO Rest of the params
			}).success(function(data,status,headers,cfg) {
				ctrl.$setValidity('unique', data.isAvailable);
				// TODO STORE session auth token & change state to logged in

			}); // TODO on failure, show ui error message
		};

		$scope.getFormName = function() {
			console.log($scope.signupForm.$userName);
		}
	})



	/**
	 * See if username is available
	 */
	.directive('usernameCheck', function($http) {
		var toId;
		return {
			restrict: 'A',
			require: 'ngModel',
			link: function(scope, elm, attrs, ctrl) {
				ctrl.$parsers.unshift(function(viewValue) {
					// TODO can we inherit checks from normal "text" checking somehow?
console.log("minlen " + attrs.ngMinlength);

console.log("name = " + scope.signupForm.userName.value);

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
