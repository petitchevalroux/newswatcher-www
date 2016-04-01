var nwApp = angular.module("nwApp", ['ui.bootstrap', 'ngTouch', 'ngAnimate']);

nwApp.controller("ArticleListCtrl", ["$scope", "$http", "$q",
    function ($scope, $http, $q) {
        $scope.params = {};
        $scope.loading = false;

        $scope.setStatus = function (status) {
            $scope.params["status"] = status;
            $scope.articles = [];
            $scope.refresh(0, 10);
        };

        $scope.getStatus = function () {
            return $scope.params["status"];
        };

        $scope.refresh = function (offset, count) {
            if($scope.loading) {
                $scope.abortLoading.resolve();
            }
            $scope.loading = true;
            $scope.abortLoading = $q.defer();

            var params = $scope.params;
            params["offset"] = offset;
            params["count"] = count;
            $http.get(
                "/api/articles",
                {
                    "responseType": "json",
                    "params": params,
                    "timeout": $scope.abortLoading.promise
                }
            ).then(function (response) {
                $scope.loading = false;
                response.data.forEach(function(article) {
                    $scope.articles.push(article);
                });
            }).catch(function (err) {
                $scope.loading = false;
            });
        };

        $scope.isLoading = function() {
            return $scope.loading === true;
        };

        $scope.updateArticleStatus = function (articleIndex, status) {
            if(!$scope.articles[articleIndex]) {
                return;
            }
            var article = $scope.articles[articleIndex];
            $http.patch(
                "/api/articles/" + encodeURIComponent(article.id),
                {"status": status}
            ).then(function () {
                $scope.articles.splice(articleIndex, 1);
                $scope.refresh($scope.articles.length, 1);
            });
        };

        $scope.setStatus(0);
    }]);
