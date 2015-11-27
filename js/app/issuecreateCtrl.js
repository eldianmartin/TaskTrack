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
    
    if (!$rootScope.group_id) {
        Data.post('session', {}).then(function (results) {
            if (results.group_id == 7) {
                $scope.issue.customer_id = $rootScope.id;
            }
        });
    }
    else {
        if ($rootScope.group_id == 7) {
            $scope.issue.customer_id = $rootScope.id;
        }
    }
   
    $scope.formtype = "Create";
    if ($routeParams.issueid != undefined) {
        $scope.formtype = "Edit";
        Data.post('getissuebyid', $routeParams.issueid).then(function (results) {
            $scope.issue = results;
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
            Data.post('updateissue', issue).then(function (results) {
                Data.toast(results);
                if (results.status == "success") {
                    $location.path('/issue');
                }
            });
        }
    }
});