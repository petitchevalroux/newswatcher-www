{{#html.addJs}}vendor/angular/angular.js{{/html.addJs}}
{{#html.addJs}}vendor/angular-animate/angular-animate.js{{/html.addJs}}
{{#html.addJs}}vendor/angular-touch/angular-touch.js{{/html.addJs}}
{{#html.addJs}}vendor/angular-ui-bootstrap/ui-bootstrap-tpls.js{{/html.addJs}}
{{#html.addJs}}js/app.js{{/html.addJs}}
<div ng-app="nwApp" class="container" ng-controller="ArticleListCtrl">
    {{=<% %>=}}
    <div class="row">
        <ul class="nav nav-tabs">
            <li ng-class="{active:getStatus() == 0}"><a href="#" ng-click="setStatus(0)"><span class="glyphicon glyphicon-fire"></span> Hot</a></li>
            <li ng-class="{active:getStatus() == 3}"><a href="#" ng-click="setStatus(3)"><span class="glyphicon glyphicon-star"></span> To read</a></li>
            <li ng-class="{active:getStatus() == 1}"><a href="#" ng-click="setStatus(1)"><span class="glyphicon glyphicon-ok"></span> Read</a></li>
            <li ng-class="{active:getStatus() == 2}"><a href="#" ng-click="setStatus(2)"><span class="glyphicon glyphicon-trash"></span> Trash</a></li>
        </ul>
    </div>
    <div class="row" ng-repeat="article in articles">
        <div class="btn-group">
            <button type="button" ng-hide="getStatus() == 3" class="btn btn-default" ng-click="updateArticleStatus($index, 3)" title="Read it later">
                <span class="glyphicon glyphicon-star"></span>
            </button>
            <button type="button" ng-hide="getStatus() == 1" class="btn btn-default" ng-click="updateArticleStatus($index, 1)" title="Mark as read">
                <span class="glyphicon glyphicon-ok"></span>
            </button>
            <button type="button" ng-hide="getStatus() == 2" class="btn btn-default" ng-click="updateArticleStatus($index, 2)" title="Move to trash">
                <span class="glyphicon glyphicon-trash"></span>
            </button>
        </div>
        <a href="{{article.url}}">{{article.title}}</a> {{article.host}}
    </div>
    <%={{ }}=%>
</div>
