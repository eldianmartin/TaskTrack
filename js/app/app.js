var reportSubLinks =  [{ 'name': "Dashboard", 'link': "reportdashboard" }, { 'name': "Top Customer", 'link': "reporttopcustomer" },
            { 'name': "Top Developer", 'link': "reporttopprogramer" }, { 'name': "Bug Aging", 'link': "reportbugaging" }]

var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster', '720kb.datepicker', "ngSanitize", "ngCsv"]);
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
        activetab: 'User',
        permissions: {
            only: ['user']
        }
    })
    .when('/user/create', {
        title: 'User',
        templateUrl: 'partials/usercreate.html',
        controller: 'usercreateCtrl',
        activetab: 'User',
        permissions: {
            only: ['user']
        }
    })
    .when('/useredit/:userid', {
        title: 'User',
        templateUrl: 'partials/usercreate.html',
        controller: 'usercreateCtrl',
        activetab: 'User',
        permissions: {
            only: ['user']
        }

    })
    .when('/reportdashboard', {
        title: 'Report',
        templateUrl: 'partials/reportdashboard.html',
        controller: 'reportdashboardCtrl',
        activetab: 'Report',
        permissions: {
            only: ['user']
        },
        sublinks: reportSubLinks,
        activesubtab: 'Dashboard',
    })
    .when('/reporttopcustomer', {
        title: 'Report',
        templateUrl: 'partials/reporttopcustomer.html',
        controller: 'reporttopcustomerCtrl',
        activetab: 'Report',
        permissions: {
            only: ['user']
        },
        sublinks: reportSubLinks,
        activesubtab: 'Top Customer',
    })
    .when('/reporttopprogramer', {
        title: 'Report',
        templateUrl: 'partials/reporttopprogramer.html',
        controller: 'reporttopprogramerCtrl',
        activetab: 'Report',
        permissions: {
            only: ['user']
        },
        sublinks: reportSubLinks,
        activesubtab: 'Top Developer',
    })
    .when('/reportbugaging', {
        title: 'Report',
        templateUrl: 'partials/reportbugaging.html',
        controller: 'reportbugagingCtrl',
        activetab: 'Report',
        permissions: {
            only: ['user']
        },
        sublinks: reportSubLinks,
        activesubtab: 'Bug Aging',
    })
    .when('/issue', {
        title: 'Issue',
        templateUrl: 'partials/issue.html',
        controller: 'issueCtrl',
        activetab: 'Issue'
    })
    .when('/issue/create', {
        title: 'Issue',
        templateUrl: 'partials/issuecreate.html',
        controller: 'issuecreateCtrl',
        activetab: 'Issue'
    })
    .when('/issueedit/:issueid', {
        title: 'Issue',
        templateUrl: 'partials/issuecreate.html',
        controller: 'issuecreateCtrl',
        activetab: 'Issue',
        permissions: {
            only: ['issueedit']
        }

    })
    .otherwise({
        redirectTo: '/'
    });
}]).run(function ($rootScope, $location, Data, $filter) {
    $rootScope.$on("$routeChangeStart", function (event, next) {
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
                    $rootScope.links = [{ 'name': 'Bug', 'link': 'issue' }, { 'name': 'Report', 'link': 'reportdashboard' }, { 'name': 'User', 'link': 'user' }];

                } else {
                    $rootScope.links = [{ 'name': 'Bug', 'link': 'issue' }];
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
    $scope.$parent.sublinks = [];
    if ($route != undefined) {
        $scope.$parent.activetab = $route.current.activetab;
        if ($route.current.sublinks != undefined) {
            $scope.$parent.sublinks = $route.current.sublinks;
            if ($route != undefined) {
                $scope.$parent.activesubtab = $route.current.activesubtab;
            }
        }
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
    return new Date(obj.getFullYear(), obj.getMonth(), obj.getDate());
}
function converttophpdate(dateString) {
    var date = new Date(dateString);
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    month = PadLeft(month, 2, "0");
    var day = date.getDate();
    day = PadLeft(day, 2, "0");
    return year + "-" + month + "-" + day;

}
function PadLeft(value, width, padChar) {
    var val = value.toString();
    if (!padChar) { padChar = '0'; }
    while (val.length < width) {
        val = padChar + val;
    }
    return val;
}