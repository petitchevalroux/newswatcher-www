<?php

use NwWebsite\Di;
use Abraham\TwitterOAuth\TwitterOAuth;

$di = Di::getInstance();

$config = $di->config->get('twitterConsumer');

return new TwitterOAuth($config->consumerKey, $config->consumerSecret);
