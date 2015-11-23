app.controller('usercreateCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $route) {
    navigationcheck($scope, $location, $route);
    $scope.formtype = "Create";
    if ($routeParams.userid != undefined) {
        $scope.formtype = "Edit";
        Data.post('getuserbyid', $routeParams.userid).then(function (results) {
            $scope.user = results;
        });
    }
    $scope.createuser = function (user) {
        if (user.group_id != undefined) {
            if (user.id == undefined) {
                Data.post('createuser', user).then(function (results) {
                    Data.toast(results);
                    if (results.status == "success") {
                        $location.path('/user');
                    }
                });
            } else {
                Data.post('edituser', user).then(function (results) {
                    Data.toast(results);
                    if (results.status == "success") {
                        $location.path('/user');
                    }
                });
            }
            

        } else {
            Data.toast({'status':'warning','msg':'Please Select User Group'});
        }
       
    }
    


})