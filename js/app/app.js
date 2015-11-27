var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster', '720kb.datepicker']);
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
        activetab: 'user',
        permissions: {
            only: ['user']
        }
    })
    .when('/user/create', {
        title: 'User',
        templateUrl: 'partials/usercreate.html',
        controller: 'usercreateCtrl',
        activetab: 'user',
        permissions: {
            only: ['user']
        }
    })
    .when('/useredit/:userid', {
        title: 'User',
        templateUrl: 'partials/usercreate.html',
        controller: 'usercreateCtrl',
        activetab: 'user',
        permissions: {
            only: ['user']
        }

    })
    .when('/report', {
        title: 'Report',
        templateUrl: 'partials/report.html',
        controller: 'reportCtrl',
        activetab: 'report',
        permissions: {
            only: ['user']
        }
    })
    .when('/issue', {
        title: 'Issue',
        templateUrl: 'partials/issue.html',
        controller: 'issueCtrl',
        activetab: 'issue'
    })
    .when('/issue/create', {
        title: 'Issue',
        templateUrl: 'partials/issuecreate.html',
        controller: 'issuecreateCtrl',
        activetab: 'issue'
    })
    .when('/issueedit/:issueid', {
        title: 'Issue',
        templateUrl: 'partials/issuecreate.html',
        controller: 'issuecreateCtrl',
        activetab: 'issue',
        permissions: {
            only: ['issueedit']
        }

    })
    .otherwise({
        redirectTo: '/'
    });
}]).run(function ($rootScope, $location, Data, $filter) {
    $rootScope.$on("$routeChangeStart", function (event, next, current) {
        Data.post('session', {}).then(function (results) {
            var nextUrl = next.$$route.originalPath;
            var nextpermissions = next.$$route.permissions;
            $rootScope.authenticated = false;
            if (results.id) {
                $rootScope.authenticated = true;
                $rootScope.id = results.id;
                $rootScope.name = results.name;
                $rootScope.group_id = results.group_id;
                $rootScope.role = [];
                angular.forEach(results.role, function (user) {
                    $rootScope.role.push(user.name);
                });

                $rootScope.fullfilter = $rootScope.role.indexOf('fullfilter') != -1;

                $rootScope.updatestate = $rootScope.role.indexOf('updatestate') != -1;
                $rootScope.updatecustomer = $rootScope.role.indexOf('updatecustomer') != -1;
                $rootScope.updatepriority = $rootScope.role.indexOf('updatepriority') != -1;
                $rootScope.updateprogramer = $rootScope.role.indexOf('updateprogramer') != -1;
                $rootScope.updatetester = $rootScope.role.indexOf('updatetester') != -1;

                if ($rootScope.role.indexOf('user') != -1) {
                    $rootScope.links = [{ 'name': 'issue' }, { 'name': 'report' }, { 'name': 'user' }];

                } else {
                    $rootScope.links = [{ 'name': 'issue' }];
                }
                if (nextpermissions != undefined) {
                    if (nextpermissions.only != undefined) {
                        if (intersect(nextpermissions.only, $rootScope.role).length == 0) {
                            $location.path("/issue");
                        }
                    }
                }
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
    Data.post('getusergroups', {}).then(function (results) {
        $rootScope.usergroups = results;
    });
    Data.post('getstates', {}).then(function (results) {
        $rootScope.states = results;
    });
    Data.post('getpriorities', {}).then(function (results) {
        $rootScope.priorities = results;

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
function intersect(arr1, arr2) {
    return arr1.filter(function (n) {
        return arr2.indexOf(n) != -1
    });
}
function IsNotEmpty(obj) {
    return obj != undefined && obj != "";
}
function DateOnly(obj) {
    return new Date(obj.getFullYear(),obj.getMonth(), obj.getDate() );
}