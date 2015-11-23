app.controller('issuecreateCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route, $filter) {
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
   
    $scope.issue = { state: "1", priority: "1" };
    $scope.formtype = "Create";
    if ($routeParams.userid != undefined) {
        $scope.formtype = "Edit";
        Data.post('getuserbyid', $routeParams.userid).then(function (results) {
            $scope.user = results;
        });
    }
    $scope.createissue = function (issue) {
        if (issue.id == undefined) {
            Data.post('createissue', issue).then(function (results) {
                Data.toast(results);
                if (results.status == "success") {
                    $location.path('/issue');
                }
            });
        } else {
            Data.post('editissue', issue).then(function (results) {
                Data.toast(results);
                if (results.status == "success") {
                    $location.path('/issue');
                }
            });
        }
    }
});