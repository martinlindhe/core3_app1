<!doctype html>
<html lang="en" ng-app>
<head>
    <title>My ng App</title>
    <link rel="stylesheet" href="css/app.css"/>
</head>
<body>
    <script src="js/angular.js/angular.min.js"></script>

    Current temperature:
    <input ng-model='temp' type='number'/> Celcius
    <p ng-show="temp >= 17">Not too bad! {{ temp }} degrees, {{ temp - 10 }} would be a little cold</p>
    <p ng-show="temp < 17">{{ temp }} degrees, is a little chilly, {{ temp + 10 }} would be a nicer</p>
</body>
</html>
