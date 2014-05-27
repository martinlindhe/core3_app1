<!doctype html>
<html lang="en">
<head>
	<title>books</title>

	<script src="/app1/js/angular.js/angular.js"></script>
	<script src="/app1/js/angular.js/angular-route.js"></script>
	<script src="/app1/js/angular.js/i18n/angular-locale_sv-se.js"></script>
</head>

<body>

<div ng-app="bookApp">
	<div ng-controller="MainController">
		<script src="/app1/js/ng-books.js"></script>

		<input ng-model="person.name" type="text" placeholder="Your name">
		<h1>Hello {{ person.name }}</h1>

		<a href="/app1/books/Book/Moby">Moby</a> |
		<a href="/app1/books/Book/Moby/ch/1">Moby: Ch1</a> |
		<a href="/app1/books/Book/Gatsby">Gatsby</a> |
		<a href="/app1/books/Book/Gatsby/ch/4?key=value">Gatsby: Ch4</a> |
		<a href="/app1/books/Book/Scarlet">Scarlet Letter</a><br/>

		<div ng-view></div>

		<hr/>

		<pre>$location.path() = {{$location.path()}}</pre>
		<pre>$route.current.templateUrl = {{$route.current.templateUrl}}</pre>
		<pre>$route.current.params = {{$route.current.params}}</pre>
		<pre>$route.current.scope.name = {{$route.current.scope.name}}</pre>
		<pre>$routeParams = {{$routeParams}}</pre>
	</div>
</div>

</body>
</html>
