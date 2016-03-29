<!DOCTYPE html>
<html>
    <head>
        <title>{{htmlTitle}}</title>
        <link href="{{#html.cssUrl}}bootstrap.min.css{{/html.cssUrl}}" rel="stylesheet" type="text/css">
        {{#css}}
        <link href="{{.}}" rel="stylesheet" type="text/css">
        {{/css}}
        {{#js}}
        <script type="text/javascript" src="{{.}}"></script>
        {{/js}}
    </head>
    <body>
        <div class="container">
            {{{htmlBody}}}
        </div>
    </body>
</html>