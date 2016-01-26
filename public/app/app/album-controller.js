/*


app.controller('albumController', ['$scope', '$http', '$rootScope', '$location','$cookieStore',
    function ($scope, $http, $rootScope, $location, $cookieStore ) {
       // alert($cookies.get('user'));
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    $http.defaults.headers.put = {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Ajax-call": $rootScope.user.id,
    };
    $http.defaults.headers.post['X-Ajax-call'] = $rootScope.user.id;
    $http.defaults.headers.delete = {
        "Content-Type": "application/x-www-form-urlencoded",
            "X-Ajax-call": $rootScope.user.id,
    };
    $http.defaults.headers.get = {
        "X-Ajax-call": $rootScope.user.id
    };

    $scope.url = 'http://dev:90/album';

    $scope.checkLogin = function(){
        $http.get('http://dev:90' + "/auth/check-login").then(function(responce){

            console.log('check login album', responce);
            if(responce.data.logged_in){
                $rootScope.isActiveUser = 1;
            }else{
                $location.path('/');
            }
        });
    }
    $scope.checkLogin();


    $scope.id = 0;
    $scope.title = '';
    $scope.artist = '';
    $scope.albums = [];


    $scope.reLoadGrid = function(){
        console.log($rootScope.isActiveUser);
        $http.get($scope.url).then(function (responce) {
            console.log(responce);
            if(responce.data.data){
                $scope.albums = responce.data.data;
            }
        });
    }
    $scope.reLoadGrid();

    $scope.albumEdit = function (id) {
        $http.get($scope.url + "/" + id).then(function (responce) {
              console.log(responce.data);
            var data = responce.data.data;
            //console.log('data',data);
            $scope.title = data[0].title;
            $scope.id = data[0].id;
            $scope.artist = data[0].artist;

        });
    };


    $scope.albumDelete = function (id) {
        if(confirm('do you want to delete')){
            $http({
                url: $scope.url + "/" + id,
                method: 'DELETE',

            }).then(function (response) {
                    var index = -1;
                    var albumsArr = eval($scope.albums);
                    for (var i = 0; i < albumsArr.length; i++) {
                        if (albumsArr[i].id === id) {
                            index = i;
                            break;
                        }
                    }
                    if (index === -1) {
                        alert("Something gone wrong");
                    }
                    $scope.albums.splice(index, 1);
                },
                function (response) { // optional
                    console.log('error', response);
                });
        }

    };
    $scope.albumReset = function () {
        $scope.title = '';
        $scope.id = 0;
        $scope.artist = '';

    };
    $scope.getAlbum = function (id) {

    }



    $scope.saveAlbum = function () {

        var type = 'POST';
        var url = '';
        if($scope.id !== 0)
        {
            type = 'PUT'
            url = "/" + $scope.id;
        }
        var album = $.param({title: $scope.title, artist: $scope.artist});
        console.log(album);
        $http({
            url: $scope.url+url,
            method: type,
            data: album
        })
            .then(function (response) {
                    console.log('save', response);
                    $scope.albumReset();
                    $scope.reLoadGrid();
                },
                function (response) { // optional
                    console.log('error', response);
                });


        //$scope.albums.push(album);
        //console.log($scope.albums);
    };
}]);
*/
