#!/usr/bin/env php
<?php
require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
// add checksum to url(...) in css files
$di = NwWebsite\Di::getInstance();
$files = explode(' ', trim(file_get_contents('php://stdin')));
$assetsPathLength = mb_strlen($di->assetsPath);
$checksums = require $di->rootPath.'checksums'.DIRECTORY_SEPARATOR.'without-css.php';
foreach ($files as $f) {
    $content = file_get_contents($f);
    $replace = [];
    // Warning to this type of urls
    // ../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular
    // ../fonts/glyphicons-halflings-regular.eot?#iefix
    if (preg_match_all('~(url\((["\']?))(.*?)(?:\?.*?|)((?:#.*?|)\2\))~', $content, $matches)) {
        foreach ($matches[3] as $k => $url) {
            $realPath = realpath(dirname($f).DIRECTORY_SEPARATOR.$url);
            if ($realPath !== false && strpos($realPath, $di->assetsPath) === 0) {
                $path = mb_substr($realPath, $assetsPathLength);
                if (isset($checksums[$path])) {
                    $replace[$matches[0][$k]] = $matches[1][$k].$url.'?'.$checksums[$path].$matches[4][$k];
                }
            }
        }
    }
    file_put_contents($f, strtr($content, $replace));
}
