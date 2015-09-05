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
        ]);

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

return $app;
