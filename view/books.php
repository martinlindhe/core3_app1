<!doctype html>
<html lang="en" ng-app="indexApp">
<!--
TODO: wrap this in a module
TODO: map all of this into a <spreadsheet> tag!?
TODO: with css, mark the currently sorted-by column
TODO: load table data with json
TODO: pagination
-->
<head>
	<title>My ng App</title>
<!--
	<script src="js/angular.js/angular.js"></script>
	<script src="js/angular.js/angular-route.js"></script>

	FIXME the routing stuff works on 1.2.16 and is broken somehow on 1.3-alpha!!!
		so set a dependency on right stable version in composer!
		ALSO TODO - look up changes in angular 1.3-...
-->
	<script src="js/ng1.2.16/angular.min.js"></script>
	<script src="js/ng1.2.16/angular-route.js"></script>

	<!-- <script src="js/angular.js/i18n/angular-locale_sv-se.js"></script> -->
	<script src="js/app.js"></script>
	<!--
	<script src="js/ng-spreadsheet.js"></script>
	<link href="css/ng-spreadsheet.css" rel="stylesheet" type="text/css"/>
	-->
</head>

<body>

<div ng-controller="MainController">

	<a href="/Book/Moby">Moby</a> |
	<a href="/Book/Moby/ch/1">Moby: Ch1</a> |
	<a href="/Book/Gatsby">Gatsby</a> |
	<a href="/Book/Gatsby/ch/4?key=value">Gatsby: Ch4</a> |
	<a href="/Book/Scarlet">Scarlet Letter</a><br/>

	<div ng-view></div>

	<hr />

	<pre>$location.path() = {{$location.path()}}</pre>
	<pre>$route.current.templateUrl = {{$route.current.templateUrl}}</pre>
	<pre>$route.current.params = {{$route.current.params}}</pre>
	<pre>$route.current.scope.name = {{$route.current.scope.name}}</pre>
	<pre>$routeParams = {{$routeParams}}</pre>

</div>

</body>
</html>
