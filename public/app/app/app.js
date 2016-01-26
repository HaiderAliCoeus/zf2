var app = angular.module('myApp', ['ngCookies']);

app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
        when('/', {
            templateUrl: 'templates/login.html',
            controller: 'loginController'
        }).
        when('/list', {
            templateUrl: 'templates/table.html',
            controller: 'albumController'
        }).
        otherwise({
            redirectTo: '/'
        });
    }]);




