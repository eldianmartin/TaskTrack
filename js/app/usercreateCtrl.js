app.controller('usercreateCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route) {
    navigationcheck($scope, $location, $route);
    $scope.createuser = function (user) {
        if (user.type_id != undefined) {
            Data.post('createuser', user).then(function (results) {
                Data.toast(results);
                if (results.status == "success") {
                    $location.path('/user');
                }
            });

        } else {
            Data.toast({'status':'warning','msg':'Please Select User Group'});
        }
       
    }
    


}).directive('selectUserType', function () {
    return {
        controller: function ($scope, $rootScope, $routeParams, $location, $http, Data, $route) {
            Data.post('getusertype', {}).then(function (results) {
                $scope.options = results;
            });

        },

    };
});