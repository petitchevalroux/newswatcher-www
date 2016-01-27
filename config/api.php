<?php

/**
 * Api Configuration.
 */
$di = \NwWebsite\Di::getInstance();

if ($di->env === ENV_TEST) {
    $endPoint = 'http://192.168.99.100:8080/';
} else {
    $endPoint = 'http://api:80/';
}
