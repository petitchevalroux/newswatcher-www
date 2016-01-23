<?php

namespace NwWebsite;

/**
 * @property int $env define current environment using ENV_DEVELOPMENT|ENV_PRODUCTION
 * @property \Slim\Slim $slim framework object
 * @property string $rootPath directory containing the whole project
 * @property \ConfigurationFactory\Factory $config configuration factory
 * @property string $templatePath directory containing templates
 * @property \Mustache_Engine $mustache mustache template engine
 * @property Layouts\Html $layoutHtml html layout
 * @property string $assetsPath directory containing assets
 * @property string $checksumsPath directory containing checksums files
 * @property \Abraham\TwitterOAuth\TwitterOAuth $twitterOAuth directory containing checksums files
 * @property NwWebsite\Helpers\Session $session php session wrapper
 * @property NwWebsite\Helpers\Http $http http helper
 * @property JsonApi\Client $api newswatcher api client
 * @property \AMQPConnection $amqpConnection amqp connection
 * @property \AMQPExchange $twitterIndexerExchange twitter indexer exchange
 */
class Di extends \Di\Di
{
    protected function __construct()
    {
        parent::__construct();
        $this->setDependenciesDirectory(__DIR__.DIRECTORY_SEPARATOR.'Dependencies');
    }
}
