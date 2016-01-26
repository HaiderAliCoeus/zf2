/**
 * Created by coeus on 1/18/2016.
 */
var UserApp = angular.module('user-app', []);

UserApp.controller('userController', function($scope, $http){

    $scope.users = [];
    $scope.fname = "";
    $scope.password = "";
    $scope.addUser = function(){
        var data  = {fname: $scope.firstName, password: $scope.password, save: true};



/*
        $http.post('http://localhost:90/untitled/create.php', data).success(function(response){
            console.log(response);
        });*/
    }


    $scope.addUser = function () {
        // use $.param jQuery function to serialize data from JSON
        var data = $.param({
            fname: $scope.firstName,
            password: $scope.password,
            save: 'save'
        });

        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        $http.post('http://localhost:90/untitled/create.php', data, config)
            .success(function (data, status, headers, config) {
              if(data == 1){
                  $scope.users.push({
                      fname: $scope.firstName,
                      password: $scope.password
                  });

              }
                //  $scope.PostDataResponse = data;
            })
            .error(function (data, status, header, config) {
                $scope.ResponseDetails = "Data: " + data +
                    "<hr />status: " + status +
                    "<hr />headers: " + header +
                    "<hr />config: " + config;
            });
    };


    $http.get('http://localhost:90/untitled/crud.php').then(function(response){
        $scope.users = response.data;
    });

    $scope.removeUser = function(index){
        $scope.users.splice(index, 1);
    }


});
