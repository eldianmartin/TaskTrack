app.controller('issueCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route, $filter) {
    navigationcheck($scope, $location, $route);
    Data.post('getprogramers', {}).then(function (results) {
        $rootScope.programers = results;
    });
    Data.post('gettesters', {}).then(function (results) {
        $rootScope.testers = results;
    });
    Data.post('getcustomers', {}).then(function (results) {
        $rootScope.customers = results;
    });
  
});