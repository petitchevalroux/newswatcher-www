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
                <a href="{{article.url}}">{{article.title}}</a>
            </li>
        </ul>
    </div>
    <%={{ }}=%>
</div>
