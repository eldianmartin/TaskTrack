app.controller('reportbugagingCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route, $filter) {
    navigationcheck($scope, $location, $route);
    Data.post('getprogramers', {}).then(function (results) {
        $rootScope.programers = results;
    });
    
    Data.post('getcustomers', {}).then(function (results) {
        $rootScope.customers = results;
    });
    var issues = [];
    Data.post('getissueaging', {}).then(function (results) {
        issues = results;
        $scope.issueagings = results;

    });

   
    $scope.filter = {customer_id: "", from: "", to: "", programer_id: "" }
    $scope.filterupdate = function (filter) {
        var filterIssue = issues;
        if (filter != undefined) {
            
            filterIssue = $filter('issuefilter')(filterIssue, filter)


        }
        $scope.issueagings = filterIssue;
    }
    $scope.getHeader = function () {
        return ["No", "Customer", "Developer", "Bug", "Days"]
    }
    $scope.getCSV = function () {
        var csvs = [];
        var i = 1;
        angular.forEach($scope.issueagings, function (issueaging) {

            var newItem = {
                No: i,
                customer_name: issueaging.customer_name,
                programer_name: issueaging.programer_name,
                title: issueaging.title,
                days: issueaging.days,
               
            };
            i++;
            csvs.push(newItem);
        });

        return csvs;
    }
});

