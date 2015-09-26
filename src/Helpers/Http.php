<?php

namespace NwWebsite\Helpers;

class Http
{
    /**
     * Return absolute url.
     *
     * @param string $relativePath
     *
     * @return string
     */
    public function getAbsoluteUrl($relativePath)
    {
        return 'http://'.(!empty($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']).$relativePath;
    }
}
