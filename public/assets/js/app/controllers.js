var nwApp = angular.module("nwApp", []);

nwApp.controller("ArticleListCtrl", ["$scope", "$http", "$q",
    function ($scope, $http, $q) {
        $scope.params = {};
        $scope.loading = false;

        $scope.setStatus = function (status) {
            $scope.params["status"] = status;
            $scope.refresh();
        };

        $scope.getStatus = function () {
            return $scope.params["status"];
        };

        $scope.refresh = function () {
            if($scope.loading) {
                $scope.abortLoading.resolve();
            }
            $scope.loading = true;
            $scope.abortLoading = $q.defer();
            $scope.articles = [];
            $http.get(
                "/api/articles",
                {
                    "responseType": "json",
                    "params": $scope.params,
                    "timeout": $scope.abortLoading.promise
                }
            ).then(function (response) {
                $scope.loading = false;
                $scope.articles = response.data;
            }).catch(function (err) {
                $scope.loading = false;
            });
        };

        $scope.isLoading = function() {
            return $scope.loading === true;
        };

        $scope.updateArticleStatus = function (articleId, status) {
            $http.patch(
                "/api/articles/" + encodeURIComponent(articleId),
                {"status": status}
            ).then(function () {
                $scope.refresh();
            });
        };

        $scope.setStatus(0);
    }]);
