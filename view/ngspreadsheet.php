

<div ng-app="coreSpreadsheet" ng-controller="SpreadsheetController">
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
