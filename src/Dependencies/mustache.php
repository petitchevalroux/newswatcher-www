<?php

use NwWebsite\Di;

$di = Di::getInstance();

$cachePath = sys_get_temp_dir()
        .DIRECTORY_SEPARATOR
        .'mustache-'.md5($di->rootPath);

$mustache = new Mustache_Engine([
    'template_class_prefix' => '__MyTemplates_',
    'cache' => $cachePath,
    'cache_lambda_templates' => true,
    'loader' => new Mustache_Loader_FilesystemLoader(
            $di->templatePath, ['extension' => '.tpl',
            ]),
    'partials_loader' => new Mustache_Loader_FilesystemLoader(
            $di->templatePath.'partials', ['extension' => '.tpl']
    ),
    'strict_callables' => true,
        ]);

return $mustache;
