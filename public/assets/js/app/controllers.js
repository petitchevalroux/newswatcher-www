var nwApp = angular.module("nwApp", []);

nwApp.controller('ArticleListCtrl', ['$scope', '$http',
    function ($scope, $http) {
        $http.get('/api/articles.json', {"responseType": "json"}).success(function (data) {
            $scope.articles = data;
        });
    }]);