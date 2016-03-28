<?php

namespace NwWebsite\Models;

class Articles extends Model
{
    protected function mergeResource($resource)
    {
        parent::mergeResource($resource);
        $this->host = parse_url($this->url, PHP_URL_HOST);
    }
}
