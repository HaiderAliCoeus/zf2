/*


app.controller('loginController', ['$scope',  '$http', '$rootScope', '$location','$cookieStore',
    function($scope, $http, $rootScope, $location, $cookieStore){
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
        $http.defaults.headers.put["Content-Type"] = "application/x-www-form-urlencoded";


        $scope.url = 'http://dev:90/login';
        $rootScope.checkLogin = function(){
        $http.get('http://dev:90' + "/auth/check-login").then(function(responce){

            console.log('check login', responce);
            if(responce.data.logged_in){
                $rootScope.isActiveUser = 1;
                $location.path('/list');
            }
        });
    }
    $rootScope.checkLogin();

    $scope.email = '';
    $scope.password = '';

    $scope.getLogin = function(){
        var user = $.param({email: $scope.email, password: $scope.password});
        $http({
            url: $scope.url,
            method: 'POST',
            data: user
        })
            .then(function (response) {
                    console.log('data', response);
                    $scope.text = response.data;
                    $rootScope.isActiveUser = response.data.user.isActive;
                    $rootScope.user = response.data.user;
                    $cookieStore.put('user', $rootScope.user.id);
                    console.log($rootScope.isActiveUser);
                    if($rootScope.isActiveUser == 1){
                        $location.path('/list')
                    }
                },
                function (response) { // optional
                    console.log('error', response);
                    $scope.text = response.data;
                });
    }

    $scope.logout = function(){
        $http.get($scope.url + "/logout").then(function(responce){
            if(responce.data.status == true){
                $rootScope.isActiveUser = undefined;
                $location.path('/');
            }
        });
    };
}]);
*/
