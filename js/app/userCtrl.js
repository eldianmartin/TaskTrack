app.controller('userCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route, $filter) {
    navigationcheck($scope, $location, $route);

    Data.post('binddatauser', {}).then(function (results) {
        angular.forEach(results, function (user) {
            var group = $filter('filter')($rootScope.usergroups, { id: user.group_id })[0];
            user.group = group == undefined ? "" : group.name;
            user.selected = false;
        });

        $scope.users = results;

    });
    $scope.delete = function () {
        var selected = $filter('filter')($scope.users, { selected: true });
        var unselected = $filter('filter')($scope.users, { selected: false });
        var listUserID = [];
        angular.forEach(selected, function (user) {
            listUserID.push(user.id);
        });
        if (confirm("Press a button!")) {
            Data.post('deleteuser', listUserID).then(function (results) {
                Data.toast(results);
                $scope.users = unselected;
            });
        }
    }
    $scope.tooglecheckall = function (checkall) {
        var filtered = $filter('filter')($scope.users, $scope.searchtext);
        angular.forEach(filtered, function (user) {
            user.selected = checkall;
        });
        $scope.selected = $filter('filter')($scope.users, { selected: true }).length;

    }
    $scope.tooglecheck = function () {
        $scope.selected = $filter('filter')($scope.users, { selected: true }).length;
    }

});