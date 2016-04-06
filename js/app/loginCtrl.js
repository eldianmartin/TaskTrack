app.controller('loginCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {       
    navigationcheck($scope, $location);
    $scope.doLogin = function (customer) {
        Data.post('login', customer).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('issue');
            }
            else {
                $scope.login.password = '';
            }
        });
    };
   
    
});