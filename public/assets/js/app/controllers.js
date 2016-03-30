var nwApp = angular.module("nwApp", []);

nwApp.controller("ArticleListCtrl", ["$scope", "$http",
    function ($scope, $http) {
        $scope.params = {};

        $scope.setStatus = function (status) {
            $scope.params["status"] = status;
            $scope.refresh();
        };

        $scope.getStatus = function () {
            return $scope.params["status"];
        };

        $scope.refresh = function () {
            $http.get(
                "/api/articles",
                {"responseType": "json", "params": $scope.params}
            ).then(function (response) {
                $scope.articles = response.data;
            });
        };

        $scope.updateArticleStatus = function (articleId, status) {
            $http.patch(
                "/api/articles/" + encodeURIComponent(articleId),
                {"status": status}
            ).then(function (response) {
                $scope.refresh();
            });
        };

        $scope.setStatus(0);
    }]);
