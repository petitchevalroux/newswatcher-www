<?php

namespace NwWebsite;

use Slim\Slim;
use NwWebsite\Controllers\Auth\Twitter as AuthTwitterController;
use NwWebsite\Controllers\Home as HomeController;
use NwWebsite\Controllers\Auth\Authentifier as AuthentifierController;

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

$app->get('/auth/login', function () use ($app) {
    $app->render('auth/login');
});

$app->get('/auth/twitter/login', function () {
    AuthTwitterController::getInstance()->login();
});

$app->get('/auth/twitter/callback', function () {
    AuthTwitterController::getInstance()->callback();
});

$app->get('/auth/logout', function () {
    AuthentifierController::getInstance()->logout();
});

$app->get('/home', function () {
    HomeController::getInstance()->home();
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
