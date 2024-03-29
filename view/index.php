<!DOCTYPE html>
<html lang="en" ng-app="registerUserApp">
<head>
	<base href="<?=$webRoot;?>"/>
	<title>app1</title>

	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="js/angularjs/angular.js"></script>
	<script src="js/angular-ui-bootstrap/ui-bootstrap-tpls.js"></script>
</head>

<body ng-controller="FormController">


<div class="container">

	Register new user:<br/>
<!-- ng-pattern="[a-zA-Z0-9]" -->
	<form name="signupForm" class="form-inline register-form" novalidate ng-submit="addUser(newUser)">

		<input type="text"
			   class="form-control"
               name="username"
               username-free="username"
               ng-model="newUser.username"
               required
               ng-minlength=3
               ng-maxlength=20
               placeholder="Your username"/>
		<input type="password"
			   class="form-control"
               name="password"
               ng-model="newUser.password"
               required
               ng-minlength=6
               placeholder="Password"/>

		<div class="input-group">
      		<div class="input-group-addon">@</div>
			<input type="email"
		       class="form-control"
               name="email"
               ng-model="newUser.email"
               required
               placeholder="Email Address"/>
		</div>
		<div class="checkbox">
			<label>
			<input type="checkbox"
               ng-model="newUser.agree"
               required/>
			I agree
			</label>
		</div>

		<button type="submit" class="btn btn-primary" ng-disabled="signupForm.$invalid">REGISTER</button>

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

	<link href="scss/register-form" rel="stylesheet" type="text/css"/>
	<script src="js/controller/register-user.js"></script>
</div>

<div class="container">
	<pre>The selected page no: {{pager.currentPage}}</pre>
    <pager total-items="pager.totalItems" ng-model="pager.currentPage"></pager>
	<div pagination total-items="pager.totalItems" ng-model="pager.currentPage"></div>
	<br/>
	<button class="btn btn-info" ng-click="pager.setPage(3)">Set current page to: 3</button>



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
    or <a href="horsemap">horse map</a><br/>

	or <a href="tor-map">tor map</a><br/>
</div>


</body>
</html>
