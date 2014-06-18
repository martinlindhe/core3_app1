<!doctype html>
<html lang="en">
<head>
	<base href="<?=$webRoot;?>/"/>
	<title>books</title>

	<script src="js/angularjs/angular.js"></script>
	<script src="js/angularjs/angular-route.js"></script>
	<script src="js/angularjs/i18n/angular-locale_sv-se.js"></script>
</head>

<body>

<div ng-app="bookApp">

	<div ng-controller="MainController">
		<script src="js/ng-books.js"></script>

		<input ng-model="person.name" type="text" placeholder="Your name">
		<h1>Hello {{ person.name }}</h1>

		<a href="books/Book/Moby">Moby</a> |
		<a href="books/Book/Moby/ch/1">Moby: Ch1</a> |
		<a href="books/Book/Gatsby">Gatsby</a> |
		<a href="books/Book/Gatsby/ch/4?key=value">Gatsby: Ch4</a> |
		<a href="books/Book/Scarlet">Scarlet Letter</a><br/>

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
