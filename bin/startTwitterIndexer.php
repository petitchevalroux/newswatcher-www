<?php

/**
 * Start indexer on all twitter sources.
 *
 * Start it outside of docker :
 * docker exec newswatcher-www /usr/bin/php /data/http/bin/startTwitterIndexer.php
 */
require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

use NwWebsite\Models\Sources\Twitter as TwitterSource;

$sources = TwitterSource::each(function ($source) {
            echo 'Starting indexer for '.$source."\n";
            $source->startIndexer();
        });
