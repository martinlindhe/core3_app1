<?php

//TODO: fill a rectangular area of the spreadsheet with svg/spin.svg and "loading" text
//TODO: with css, mark the currently sorted-by column
//TODO: pagination, request eg 10 items/load using json api
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?=$webRoot;?>"/>
	<title>spreadsheet</title>

	<script src="js/angularjs/angular.js"></script>
	<script src="js/angularjs/angular-route.js"></script>
	<script src="js/angularjs/i18n/angular-locale_sv-se.js"></script>
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
				<td>{{r.decimalNumber | currency:"sek"}}</td>
				<td>{{r.datestamp | date:'medium' }} is a {{r.datestamp | date:'EEEE'}}</td>
			</tr>
		</table>

		<link href="scss/spreadsheet" rel="stylesheet" type="text/css"/>
		<script src="js/controller/spreadsheet.js"></script>
	</div>

</div>

</body>
</html>
