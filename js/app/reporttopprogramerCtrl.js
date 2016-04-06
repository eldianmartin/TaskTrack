app.controller('reporttopprogramerCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route, $filter) {
    navigationcheck($scope, $location, $route);
    $scope.filter = { 'from': '01 Jan ' + new Date().getFullYear(), 'to': '31 Dec ' + new Date().getFullYear() }

    $scope.gettopprogramer= function (filter) {
        var from = converttophpdate(filter.from);
        var to = converttophpdate(filter.to);
        var obj = { 'from': from, 'to': to };
        Data.post('gettopprogramer', obj).then(function (results) {

            $scope.programers = results;

        });
    }
    $scope.gettopprogramer($scope.filter);

    $scope.getHeader = function () {
        return ["Rank", "Developer", "On Progress", "Done", "Rejected", "Total"]
    }
    $scope.getCSV = function () {
        var csvs = [];
        var i = 1;
        angular.forEach($scope.programers, function (programer) {

            var newItem = {
                Rank: i,
                name: programer.name,
                onprogress: programer.onprogress,
                done: programer.done,
                reject: programer.reject,
                total: programer.total
            };
            i++;
            csvs.push(newItem);
        });

        return csvs;
    }
});

