<?php

namespace NwWebsite\Models\Sources;

use NwWebsite\Models\Source;
use NwWebsite\Di;

class Twitter extends Source
{
    public function startIndexer()
    {
        $di = Di::getInstance();
        $twitterConsumerConfig = $di->config->get('twitterConsumer');
        $di->twitterIndexerExchange->publish(json_encode([
            'authentication' => [
                'consumer_key' => $twitterConsumerConfig->consumerKey,
                'consumer_secret' => $twitterConsumerConfig->consumerSecret,
                'access_token_key' => $this->accessTokenKey,
                'access_token_secret' => $this->accessTokenSecret,
            ],
            'method' => $this->method,
            'sourceId' => $this->getId(),
        ]));
    }
}
