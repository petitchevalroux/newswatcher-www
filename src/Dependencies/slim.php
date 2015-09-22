<?php

namespace NwWebsite;

use Slim\Slim;

$di = Di::getInstance();
if ($di->env === ENV_DEVELOPMENT) {
    $slimMode = 'development';
    $debug = true;
} else {
    $slimMode = 'production';
    $debug = true;
}

$app = new Slim([
    'mode' => $slimMode,
    'debug' => $debug,
    'view' => $di->layoutHtml,
        ]);

$app->get('/hello/:name', function ($name) use ($app) {
    $app->render("Hello, $name", false);
});

$app->notFound(function () use ($app) {
    $status = 404;
    $app->response->setStatus($status);
    $app->render('error', [
        'errno' => $status,
        'message' => $app->response->getMessageForCode($status),
    ]);
});

return $app;
