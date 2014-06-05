<!doctype html>

<!--
TODO: fill a rectangular area of the spreadsheet with svg/spin.svg and "loading" text
TODO: with css, mark the currently sorted-by column
TODO: pagination
-->

<html lang="en">
<head>
	<title>spreadsheet</title>

	<script src="/app1/js/angularjs/angular.js"></script>
	<script src="/app1/js/angularjs/angular-route.js"></script>
	<script src="/app1/js/angularjs/i18n/angular-locale_sv-se.js"></script>
</head>

<body>
<div ng-app="coreSpreadsheet">
	<link href="/app1/scss/ng-spreadsheet" rel="stylesheet" type="text/css"/>
	<script src="/app1/js/ng-spreadsheet.js"></script>

	<div ng-controller="SpreadsheetController">
		<table class="coreSpreadsheet">
			<tr>
				<th ng-repeat="key in headerOrder" ng-click="$parent.sortKey = key; $parent.sortReverse = !sortReverse">{{headers[key]}}</th>
			</tr>
			<tr ng-repeat="r in result | orderBy:sortKey:sortReverse">
				<td>{{r.id}}</td>
				<td>{{r.name}}</td>
				<td>{{r.decimalNumber | currency:"sek"}}</td>
				<td>{{r.datestamp | date:'medium' | json}} is a {{r.datestamp | date:'EEEE' | json}}</td>
			</tr>
		</table>
	</div>
</div>

</body>
</html>
