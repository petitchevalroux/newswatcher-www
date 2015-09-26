<?php

use JsonApi\Client;
use NwWebsite\Di;

$di = Di::getInstance();
$config = $di->config->get('api');
$client = new Client();
$client->setEndPoint($config->endPoint);

return $client;
