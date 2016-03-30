{{#html.addJs}}angular.js{{/html.addJs}}
{{#html.addJs}}app/controllers.js{{/html.addJs}}
<div ng-app="nwApp">
    {{=<% %>=}}
    <div ng-controller="ArticleListCtrl">
        <ul class="nav nav-tabs">
            <li ng-class="{active:getStatus() == 0}"><a href="#" ng-click="setStatus(0)">New</a></li>
            <li ng-class="{active:getStatus() == 1}"><a href="#" ng-click="setStatus(1)">Read</a></li>
            <li ng-class="{active:getStatus() == 2}"><a href="#" ng-click="setStatus(2)">Trash</a></li>
        </ul>
        <ul>
            <li ng-repeat="article in articles">
                <div class="btn-group">
                    <button type="button" ng-hide="getStatus() == 1" class="btn btn-default" ng-click="updateArticleStatus(article.id, 1)">
                        <span class="glyphicon glyphicon-new-window"></span>
                    </button>
                    <button type="button" ng-hide="getStatus() == 2" class="btn btn-default" ng-click="updateArticleStatus(article.id, 2)">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </div>
                <a href="{{article.url}}">{{article.title}} </a>
            </li>
        </ul>
    </div>
    <%={{ }}=%>
</div>
