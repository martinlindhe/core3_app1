<!doctype html>
<html lang="en">
<head>
	<title>app1</title>

	<script src="/app1/js/angularjs/angular.js"></script>
	<script src="/app1/js/angularjs/angular-route.js"></script>
	<script src="/app1/js/angularjs/i18n/angular-locale_sv-se.js"></script>

</head>

<body ng-app="registerUserApp">
<div ng-controller="RegisterController">
	<link href="/app1/scss/ng-register-form" rel="stylesheet" type="text/css"/>
	<script src="/app1/js/ng-register-user.js"></script>

	Register new user:<br/>
	<form name="signup_form" class="register-form" novalidate ng-submit="registerFormSubmit()">
		<input type="text" ng-model="signup.name" name="userName" required ng-minlength=3 ng-maxlength=20 username-check placeholder="Your username"/>
		<input type="password" ng-model="signup.pass" name="userPass" required ng-minlength=6 placeholder="Password"/>
		<input type="email" ng-model="signup.email" name="userEmail" required placeholder="Email Address"/>

 		<input type="checkbox" ng-model="signup.agree" name="userAgree" required/>
		I agree

		<button type="submit" ng-disabled="signup_form.$invalid">REGISTER</button>
	</form>

	<div ng-show="!signup.agree">Please agree.</div>

	<div ng-show="signup_form.userName.$dirty && signup_form.userName.$invalid">USER:
		<span ng-show="signup_form.userName.$error.required">Username required.</span>

		<!-- TODO: error.minlenght and maxlength dont work for username ... -->
		<span ng-show="signup_form.userName.$error.minlength">Username is too short.</span>
		<span ng-show="signup_form.userName.$error.maxlength">Username is too long.</span>
		<span ng-show="signup_form.userName.$error.unique">Username is taken.</span>
	</div>

	<div ng-show="signup_form.userEmail.$dirty && signup_form.userEmail.$invalid">EMAIL:
		<span ng-show="signup_form.userEmail.$error.email">This is not a valid email.</span>
	</div>

	<div ng-show="signup_form.userPass.$dirty && signup_form.userPass.$invalid">PWD:
		<span ng-show="signup_form.userPass.$error.minlength">Password must be at least 6 letters.</span>
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
