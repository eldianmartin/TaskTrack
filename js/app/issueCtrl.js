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
    
   
    
    
    var issues = [];
    Data.post('getissues', {}).then(function (results) {
        issues = results;
        $scope.issues = results;

    });

    $scope.update = function (issue) {
        Data.post('updateissue', issue).then(function (results) {

        });
    }
    $scope.filter = { title: "", customer_id: "", from: "", to: "", programer_id: "", tester_id: "", state: "", priority: "" }
   
  
    $scope.filterupdate = function (filter) {
        var filterIssue = issues;
        if (filter != undefined) {
            if (IsNotEmpty(filter.title)) {
                filterIssue = $filter('filter')(filterIssue, { title: filter.title })
            }


            filterIssue = $filter('issuefilter')(filterIssue, filter)


        }
        $scope.issues = filterIssue;
    }
    Data.post('session', {}).then(function (results) {
        if (results.group_id == "4") {
            $scope.filter.programer_id = $rootScope.id;
            $scope.filterupdate($scope.filter);
            $scope.disabledeveloperfilter = true;
        } else if (results.group_id == "5") {
            $scope.filter.tester_id = $rootScope.id;
            $scope.filterupdate($scope.filter);
            $scope.disabletesterfilter = true;
        }
    });
});
app.filter('issuefilter', function () {
    return function (items, filter) {
        var filtered = [];

        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var matchProgramer = true;
            if (IsNotEmpty(filter.programer_id)) {
                var filterprogramer = filter.programer_id == "null" ? null : filter.programer_id;
                matchProgramer = filterprogramer == item.programer_id;

            }
            var matchCustomer = true;
            if (IsNotEmpty(filter.customer_id)) {
                var filtercustomer= filter.customer_id == "null" ? null : filter.customer_id;
                matchCustomer = filtercustomer == item.customer_id;

            }
            var matchTester= true;
            if (IsNotEmpty(filter.tester_id)) {
                var filtertester= filter.tester_id == "null" ? null : filter.tester_id;
                matchTester = filtertester == item.tester_id;

            }
            var matchPriority= true;
            if (IsNotEmpty(filter.priority)) {
                matchPriority = filter.priority == item.priority;

            }
            var matchState = true;
            if (IsNotEmpty(filter.state)) {
                matchState = filter.state == item.state;

            }
            var matchFrom= true;
            if (IsNotEmpty(filter.from)) {
                var createddate = item.created.split(" ")[0];
                matchFrom = new Date(filter.from) <= DateOnly(new Date(createddate));

            }
            var matchTo= true;
            if (IsNotEmpty(filter.to)) {
                var createddate = item.created.split(" ")[0];
                matchTo = new Date(filter.to) >= DateOnly(new Date(createddate));

            }
            if (matchProgramer && matchCustomer && matchTester && matchPriority && matchState && matchFrom && matchTo) {
                filtered.push(item);
            }
        }
        return filtered;
    };
});

