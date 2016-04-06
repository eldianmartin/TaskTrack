app.controller('reporttopcustomerCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route, $filter) {
    navigationcheck($scope, $location, $route);
    $scope.filter = { 'from': '01 Jan ' + new Date().getFullYear(), 'to': '31 Dec ' + new Date().getFullYear() }

    $scope.gettopcustomer = function (filter) {
        var from = converttophpdate(filter.from);
        var to = converttophpdate(filter.to);
        var obj = { 'from': from, 'to': to };
        Data.post('gettopcustomer', obj).then(function (results) {

            $scope.customers = results;

        });
    }
    $scope.gettopcustomer($scope.filter);

    $scope.getHeader = function () {
        return ["Rank", "Customer", "On Progress", "Done", "Rejected", "Total"]
    }
    $scope.getCSV = function () {
        var csvs = [];
        var i = 1;
        angular.forEach($scope.customers, function (customer) {
          
            var newItem = {
                Rank: i,
                name: customer.name,
                onprogress: customer.onprogress,
                done: customer.done,
                reject: customer.reject,
                total: customer.total
            };
            i++;
            csvs.push(newItem);
        });

        return csvs;
    }
});

