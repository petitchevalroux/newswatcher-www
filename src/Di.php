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
 */
class Di extends \Di\Di
{
    protected function __construct()
    {
        parent::__construct();
        $this->setDependenciesDirectory(__DIR__.DIRECTORY_SEPARATOR.'Dependencies');
    }
}
