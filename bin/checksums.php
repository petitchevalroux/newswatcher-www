#!/usr/bin/env php
<?php
require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
$di = NwWebsite\Di::getInstance();
// Compute md5 from file in input and write it in php file in argument
$outputFile = isset($argv[1]) ? $argv[1] : false;
$stdin = file_get_contents('php://stdin');
$files = explode(' ', str_replace(["\n","\r"], ' ', trim($stdin)));
$checksums = [];
$assetsPathLength = mb_strlen($di->assetsPath);
foreach ($files as $f) {
    $realPath = realpath($f);
    if ($realPath !== false && strpos($realPath, $di->assetsPath) === 0) {
        $checksums[mb_substr($realPath, $assetsPathLength)] = md5_file($realPath);
    }
}
ob_start();
var_export($checksums);
$output = "<?php\nreturn ".ob_get_clean().";\n";
file_put_contents($outputFile, $output);
