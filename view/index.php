<!doctype html>
<html lang="en" ng-app="registerUserApp">
<head>
	<base href="<?=$webRoot;?>"/>
	<title>app1</title>
	<script src="js/angularjs/angular.js"></script>
	<script src="js/angularjs/angular-route.js"></script>
	<script src="js/angularjs/i18n/angular-locale_sv-se.js"></script>
</head>

<body>
<div ng-controller="FormController">
	<link href="scss/ng-register-form" rel="stylesheet" type="text/css"/>
	<script src="js/ng-register-user.js"></script>

	Register new user:<br/>
<!-- ng-pattern="[a-zA-Z0-9]" -->
	<form name="signupForm" class="register-form" novalidate ng-submit="addUser(newUser)">
		<input type="text"
               name="username"
               username-free="username"
               ng-model="newUser.username"
               required
               ng-minlength=3
               ng-maxlength=20
               placeholder="Your username"/>
		<input type="password"
               name="password"
               ng-model="newUser.password"
               required
               ng-minlength=6
               placeholder="Password"/>
		<input type="email"
               name="email"
               ng-model="newUser.email"
               required
               placeholder="Email Address"/>
		<input type="checkbox"
               ng-model="newUser.agree"
               required/>
		I agree

		<button type="submit" ng-disabled="signupForm.$invalid">REGISTER</button>

        form data {{ newUser }}
	</form>

	<div ng-show="!newUser.agree">Please agree.</div>

	<div class="errors">
		<div ng-show="signupForm.username.$dirty && signupForm.username.$invalid">USER:
			<span ng-show="signupForm.username.$error.required">Username required.</span>
			<span ng-show="signupForm.username.$error.minlength">Username is too short.</span>
			<span ng-show="signupForm.username.$error.maxlength">Username is too long.</span>
			<span ng-show="signupForm.username.$error.unique">Username is taken.</span>
		</div>

		<div ng-show="signupForm.email.$dirty && signupForm.email.$invalid">EMAIL:
			<span ng-show="signupForm.email.$error.email">This is not a valid email.</span>
		</div>

		<div ng-show="signupForm.password.$dirty && signupForm.password.$invalid">PWD:
			<span ng-show="signupForm.password.$error.minlength">Password must be at least 6 letters.</span>
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
    or <a href="map">map</a><br/>
</div>


</body>
</html>
