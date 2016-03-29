{{#html.addJs}}angular.js{{/html.addJs}}
{{#html.addJs}}app/controllers.js{{/html.addJs}}
<div ng-app="nwApp">
    {{=<% %>=}}
    <ul ng-controller="ArticleListCtrl">
        <li ng-repeat="article in articles">
            <a href="{{article.url}}">{{article.title}}</a>
        </li>
    </ul>
    <%={{ }}=%>
</div>