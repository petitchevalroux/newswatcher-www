var nwApp = angular.module("nwApp", []);

nwApp.controller("ArticleListCtrl", ["$scope", "$http",
    function ($scope, $http) {
        $scope.params = {};

        $scope.setStatus = function (status) {
            $scope.params["status"] = status;
            $scope.update();
        };

        $scope.getStatus = function () {
            return $scope.params["status"];
        };

        $scope.update = function () {
            $http.get(
                "/api/articles.json",
                {"responseType": "json", "params": $scope.params}
            ).then(function (response) {
                $scope.articles = response.data;
            });
        };

        $scope.setStatus(0);
    }]);
