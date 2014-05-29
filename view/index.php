<!doctype html>
<html lang="en" ng-app="registerUserApp">
<head>
	<title>app1</title>

	<script src="/app1/js/angularjs/angular.js"></script>
	<script src="/app1/js/angularjs/angular-route.js"></script>
	<script src="/app1/js/angularjs/i18n/angular-locale_sv-se.js"></script>

</head>

<body>
<div ng-controller="FormController">
	<link href="/app1/scss/ng-register-form" rel="stylesheet" type="text/css"/>
	<script src="/app1/js/ng-register-user.js"></script>

	Register new user:<br/>

	<form name="signupForm" class="register-form" novalidate ng-submit="addUser(newUser)">
		<input type="text"  name="userName" ng-model="newUser.username" required ng-minlength=3 ng-maxlength=8 placeholder="Your username"/>
		<input type="password" name="userPass" ng-model="newUser.password" required ng-minlength=6 placeholder="Password"/>
		<input type="email" name="userEmail" ng-model="newUser.email" required placeholder="Email Address"/>

		<input type="checkbox" ng-model="newUser.agree" required/>
		I agree

		<button type="submit" ng-disabled="signupForm.$invalid">REGISTER</button>

		typed name is {{ newUser.username }}
	</form>

	<div ng-show="!newUser.agree">Please agree.</div>

	<div class="errors">
		<div ng-show="signupForm.userName.$dirty && signupForm.userName.$invalid">USER:
			<span ng-show="signupForm.userName.$error.required">Username required.</span>
			<span ng-show="signupForm.userName.$error.minlength">Username is too short.</span>
			<span ng-show="signupForm.userName.$error.maxlength">Username is too long.</span>
			<span ng-show="signupForm.userName.$error.unique">Username is taken.</span>
		</div>

		<div ng-show="signupForm.userEmail.$dirty && signupForm.userEmail.$invalid">EMAIL:
			<span ng-show="signupForm.userEmail.$error.email">This is not a valid email.</span>
		</div>

		<div ng-show="signupForm.userPass.$dirty && signupForm.userPass.$invalid">PWD:
			<span ng-show="signupForm.userPass.$error.minlength">Password must be at least 6 letters.</span>
		</div>
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
