<?php

use NwWebsite\Di;
use Amqp\Exchange as AmqpExchange;

$di = Di::getInstance();
$config = $di->config->get('twitterIndexerExchange');
$channel = new AMQPChannel($di->amqpConnection->get());
$exchange = new AmqpExchange($channel);
$exchange->setPublishRoutingKey($config->queueName);

return $exchange;
