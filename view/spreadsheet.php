<!doctype html>
<html lang="en">
<!--
TODO: with css, mark the currently sorted-by column
TODO: wrap this in a module
TODO: load table data with json
TODO: pagination
-->
<head>
	<title>spreadsheet</title>

	<script src="/app1/js/angular.js/angular.js"></script>
	<script src="/app1/js/angular.js/angular-route.js"></script>
	<script src="/app1/js/angular.js/i18n/angular-locale_sv-se.js"></script>


	<script src="/app1/js/ng-spreadsheet.js"></script>
	<link href="/app1/css/ng-spreadsheet.css" rel="stylesheet" type="text/css"/>
</head>

<body>

<div ng-app="coreSpreadsheet">
	<div ng-controller="SpreadsheetController">
		<table class="coreSpreadsheet">
			<tr>
				<th ng-repeat="key in headerOrder" ng-click="$parent.sortKey = key; $parent.sortReverse = !sortReverse">{{headers[key]}}</th>
			</tr>
			<tr ng-repeat="r in result | orderBy:sortKey:sortReverse">
				<td>{{r.id}}</td>
				<td>{{r.name}}</td>
				<td>{{r.decimalNumber | currency:"kr"}}</td>
				<td>{{r.datestamp | date:'medium'}}</td>
			</tr>
		</table>
	</div>
</div>

</body>
</html>
