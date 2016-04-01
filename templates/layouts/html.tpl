<!DOCTYPE html>
<html>
    <head>
        <title>{{htmlTitle}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link href="{{#html.cssUrl}}vendor/bootstrap/css/bootstrap.min.css{{/html.cssUrl}}" rel="stylesheet" type="text/css">
        {{#css}}
        <link href="{{.}}" rel="stylesheet" type="text/css">
        {{/css}}
        {{#js}}
        <script type="text/javascript" src="{{.}}"></script>
        {{/js}}
    </head>
    <body>
        <div class="container-fluid">
            {{{htmlBody}}}
        </div>
    </body>
</html>