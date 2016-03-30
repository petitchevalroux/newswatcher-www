var nwApp = angular.module("nwApp", []);

nwApp.controller('ArticleListCtrl', ['$scope', '$http',
    function ($scope, $http) {
        $scope.setStatus = function(status) {
            $scope.status = status;
        };
        $scope.getStatus = function(status) {
            return $scope.status;
        };
        $scope.setStatus(0);
        $http.get('/api/articles.json', {"responseType": "json"}).success(function (data) {
            $scope.articles = data;
        });
    }]);