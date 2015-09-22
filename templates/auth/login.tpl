{{#html.setTitle}}Log in or sign up{{/html.setTitle}}
{{#unauthenticated}}
<p role="alert" class="alert alert-warning">
    <strong>Your are not logged in</strong>, please log in or sign up.
</p>
{{/unauthenticated}}
<h1>Log in</h1>
<p><a href="{{#html.appUrl}}/auth/twitter/login{{/html.appUrl}}">Log in with Twitter</a></p>
