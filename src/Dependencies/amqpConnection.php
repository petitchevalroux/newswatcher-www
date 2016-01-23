<?php

use Amqp\Connection;
use NwWebsite\Di;

$connection = new Connection();
$di = Di::getInstance();
$config = $di->config->get('amqp');
$connection->setConfig(['host' => $config->host, 'port' => $config->port]);

return $connection;
