var app = angular.module('directives', []);

app.directive('myDirective', function(){
    var linkFunction = function(scope, element, attributes){
        element.on('click', function(){
            alert('in my directive');
        });
    }
    return {
        restrict: 'E',
        link: linkFunction
    };
});



