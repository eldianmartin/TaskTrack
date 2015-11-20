app.controller('userCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route, $filter) {
    navigationcheck($scope, $location, $route);
    $scope.binddata = function (filter) {       
        
        Data.post('binddatauser', filter).then(function (results) {
            angular.forEach(results, function (user, key) {
                var group = $filter('filter')($scope.$parent.usertypes, { key: user.type_id })[0];
                results[key].group = group == undefined ? "" : group.value;
            });

            $scope.users = results;
            
        });
    }
   
    $scope.binddata({ 'name': '' });

});