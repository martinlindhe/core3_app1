<!doctype html>
<html lang="en">
<head>
	<title>app1</title>

	<script src="/app1/js/angularjs/angular.js"></script>
	<script src="/app1/js/angularjs/angular-route.js"></script>
	<script src="/app1/js/angularjs/i18n/angular-locale_sv-se.js"></script>

<style type="text/css">
  .css-form input.ng-invalid.ng-dirty {
    background-color: #FA787E;
  }

  .css-form input.ng-valid.ng-dirty {
    background-color: #78FA89;
  }
</style>
<script>


angular.module('loginApp', [])
	.controller('RegisterController', function($scope, $http) {
		// FIXME reset with custom directive "username" dont seem to work!?
		// FIXME also reset wont empty input in failed validation-form like email
		$scope.master = {};
		$scope.update = function(user) {
			$scope.master = angular.copy(user);
		};

		$scope.reset = function() {
			$scope.user = angular.copy($scope.master);
		};

		$scope.isUnchanged = function(user) {
			return angular.equals(user, $scope.master);
		};
	})
	.directive('username', function($http) {
		return {
			require: 'ngModel',
			link: function(scope, elm, attrs, ctrl) {
				console.log('hello');
				ctrl.$parsers.unshift(function(viewValue) {
					console.log("VAL " + viewValue);
					$http({
						method: 'POST',
						url: '/app1/api/core-username-free',
						data: {'username': viewValue}
					}).success(function(data,status,headers,cfg) {
						ctrl.$setValidity('unique', data.isAvailable);
					}).error(function(data,status,headers,cfg) {
						ctrl.$setValidity('unique', false);
					});
				});
			}
		}
	});

</script>
</head>

<body ng-app="loginApp">
<div ng-controller="RegisterController">
<!-- WIP login widget
TODO hook username inpout with custom code to validate if username is taken

TODO check if username is free when no input for 1s
-->
	<form name="form" class="css-form" novalidate>
		<input type="text" username ng-model="user.name" name="userName" required placeholder="Your username"/>
		<input type="email" ng-model="user.email" name="userEmail" required placeholder="Email Address"/>

 		<input type="checkbox" ng-model="user.agree" name="userAgree" required/>
		I agree
		<div ng-show="!user.agree">Please agree.</div>

		<button ng-click="reset()" ng-disabled="isUnchanged(user)">RESET</button>
		<button ng-click="update(user)" ng-disabled="form.$invalid || isUnchanged(user)">SAVE</button>
	</form>

	<div ng-show="form.userEmail.$dirty && form.userEmail.$invalid">Invalid:
		<span ng-show="form.userEmail.$error.required">Tell us your email.</span>
		<span ng-show="form.userEmail.$error.email">This is not a valid email.</span>
	</div>
</div>


<div>
	hello world<br/>
	<br/>

<?php
	// these vars are always available to the core3 views
	echo 'request: '.$request.'<br/>';
	echo 'view: '.$view.'<br/>';
	echo 'param: '.implode(', ', $param).'<br/>';
?>

	<hr/>
	check out <a href="books/Book/Gatsby">books</a><br/>
	or <a href="spreadsheet">spreadsheet</a><br/>
</div>


</body>
</html>
