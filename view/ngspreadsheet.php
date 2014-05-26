<!doctype html>
<html>
<!--

TODO wrap this in a module
TODO: with css, mark the currently sorted-by column

TODO load table data with json

TODO pagination
-->

<head>
    <title>My ng App</title>
    <script src="js/angular.js/angular.js"></script>
    <script src="js/angular.js/i18n/angular-locale_sv-se.js"></script>
    <script src="js/ng-spreadsheet.js"></script>

    <style>
    body { font-family: sans-serif; }

    tr > td {
        border: 1px solid #EEE;
    }

    tr > th {
        text-align: center;
        font-size: 20px;
        background: #EEE;
        cursor: pointer;
    }
    </style>
</head>

<body>

<div ng-app="myApp" ng-controller="SpreadsheetController">
<table>
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

</body>
</html>
