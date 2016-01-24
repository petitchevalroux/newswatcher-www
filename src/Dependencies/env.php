<?php

define('ENV_DEVELOPMENT', 0);
define('ENV_TEST', 1);
define('ENV_PRODUCTION', 2);

$env = getenv('NEWSWATCHER_ENV');
if ($env === 'test') {
    $environment = ENV_TEST;
} else {
    $environment = ENV_DEVELOPMENT;
}

if ($environment === ENV_DEVELOPMENT || $environment === ENV_TEST) {
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);
} else {
    ini_set('display_errors', 0);
    // As reported in https://github.com/slimphp/Slim/issues/1454#issuecomment-132623409
    // Slim stop script execution based on error_reporting settings.
    // It can be dangerous in production
    ini_set('error_reporting', E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE & E_DEPRECATED);
}

return $environment;
