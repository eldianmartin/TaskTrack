var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster']);
app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.
    when('/', {
        title: 'Login',
        templateUrl: 'partials/login.html',
        controller: 'loginCtrl',

    })
    .when('/login', {
        title: 'Login',
        templateUrl: 'partials/login.html',
        controller: 'loginCtrl',
        activetab: ''
    })
    .when('/user', {
        title: 'User',
        templateUrl: 'partials/user.html',
        controller: 'userCtrl',
        activetab: 'user'
    })
    .when('/user/create', {
        title: 'User',
        templateUrl: 'partials/usercreate.html',
        controller: 'usercreateCtrl',
        activetab: 'user'
    })
    .when('/report', {
        title: 'Report',
        templateUrl: 'partials/report.html',
        controller: 'reportCtrl',
        activetab: 'report'
    })
    .when('/issue', {
        title: 'Issue',
        templateUrl: 'partials/issue.html',
        controller: 'issueCtrl',
        activetab: 'issue'
    })
    .otherwise({
        redirectTo: '/'
    });
}]).run(function ($rootScope, $location, Data) {
    $rootScope.$on("$routeChangeStart", function (event, next, current) {
        Data.post('session', {}).then(function (results) {
            var nextUrl = next.$$route.originalPath;
            $rootScope.authenticated = false;
            if (results.id) {
                $rootScope.authenticated = true;
                $rootScope.id = results.id;
                $rootScope.name = results.name;
                $rootScope.type_id = results.type_id;
                if (nextUrl == '/' || nextUrl == '/login') {
                    $location.path("/issue");
                }
            } else {

                if (nextUrl != '/' && nextUrl != '/login') {
                    $location.path("/");
                }
            }
        });
    });
});

app.controller('mainCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {

    $scope.logout = function () {
        Data.post('logout').then(function (results) {
            $location.path('/');
        });
    }
    Data.post('getusertype', {}).then(function (results) {
        $scope.usertypes = results;
    });
});

function navigationcheck($scope, $location, $route) {
    if ($location.$$url != '/' && $location.$$url != '/login') {
        $scope.$parent.islogin = false;
    } else {
        $scope.$parent.islogin = true;
    }
    if ($route != undefined) {
        $scope.$parent.activetab = $route.current.activetab;
    }
}