<?php

namespace NwWebsite;

/**
 * @property int $env define current environment using ENV_DEVELOPMENT|ENV_PRODUCTION
 * @property \Slim\Slim $slim framework object
 * @property string $rootPath directory containing the whole project
 * @property \ConfigurationFactory\Factory $config configuration factory
 */
class Di extends \Di\Di
{
    protected function __construct()
    {
        parent::__construct();
        $this->setDependenciesDirectory(__DIR__.DIRECTORY_SEPARATOR.'Dependencies');
    }
}
