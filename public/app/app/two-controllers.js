/**
 * Created by coeus on 1/19/2016.
 */

    var app = angular.module('two-controllers', []);

    app.factory('myService', function(){
        var data =  {
            firstName : "Haider",
            lastName : "Ali",
            fullName : function(){
               return this.firstName + " " + this.lastName;
            }
        };
        return data;
    });

    app.controller('FirstController', function($scope, myService){
        $scope.firstName = myService.firstName;
        $scope.lastName = myService.lastName;
        $scope.fullName = function(){
            return $scope.firstName + ' ' + $scope.lastName;
        }
        $scope.fullNameReset = function(){
            $scope.firstName = myService.firstName;
            $scope.lastName = myService.lastName;
        }
    });

    app.controller('SecondController', function($scope, myService){
        $scope.firstName = myService.firstName;
        $scope.lastName = myService.lastName;

        $scope.fullName = function(){
            return $scope.firstName + ' ' + $scope.lastName;
        }

        $scope.fullNameReset = function(){
            $scope.firstName = myService.firstName;
            $scope.lastName = myService.lastName;
        }


    });
