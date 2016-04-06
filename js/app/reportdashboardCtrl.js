app.controller('reportdashboardCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route, $filter) {
    navigationcheck($scope, $location, $route);
    var issues = [];
    $scope.state = 1;
    
    
    Data.post('getissues', {}).then(function (results) {
        issues = results;
        $scope.updatestate($scope.state)
       
    });
    Data.post('getstatereport', {}).then(function (results) {
        $scope.statereports = results;
        $scope.title = $filter('filter')($scope.statereports, { 'id': 1 })[0].name;
    });
    $scope.updatestate = function (state) {
        var filterIssue = issues;
        filterIssue = $filter('issuefilter')(filterIssue, { 'state': state })
       
        $scope.issues = filterIssue;
        if ($scope.statereports != undefined){
            $scope.title = $filter('filter')($scope.statereports, { 'id': state })[0].name;
        }
    }
    $scope.getHeader = function () {
        return ["Issue", "Creator","Created"]
    }

    $scope.getCSV = function () {
        var csvs = [];
        angular.forEach($scope.issues, function (issue) {
            var newItem = {
                Issue: issue.title,
                Creator: issue.creatorname,
                Created: issue.created,
            };
            csvs.push(newItem);
        });
       
        return csvs;
    }

});

