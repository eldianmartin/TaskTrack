var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster']);
app.config(['$routeProvider',function ($routeProvider) {
    $routeProvider.
    when('/', {
        title: 'Login',
        templateUrl: 'partials/login.html',
        controller: 'authCtrl'
    })
    .when('/logout', {
        title: 'Logout',
        templateUrl: 'partials/login.html',
        controller: 'logoutCtrl'
    })
    .when('/dashboard', {
        title: 'Dashboard',
        templateUrl: 'partials/dashboard.html',
        controller: 'authCtrl'
    })
  
    .otherwise({
        redirectTo: '/login'
    });
}]);