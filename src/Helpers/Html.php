<?php

namespace NwWebsite\Helpers;

use NwWebsite\Di;

class Html
{
    /**
     * Set page title.
     *
     * @return callable
     */
    public function setTitle()
    {
        return function ($title, $mustache) {
            $di = Di::getInstance();
            $di->layoutHtml->setTitle($mustache->render($title));
        };
    }

    /**
     * Add css to the head.
     *
     * @return callable
     */
    public function addCss()
    {
        return function ($path) {
            $di = Di::getInstance();
            $di->layoutHtml->addCss($this->getCssUrl($path));
        };
    }

    /**
     * Add css to the head.
     *
     * @return callable
     */
    public function cssUrl()
    {
        return function ($path) {
            return $this->getCssUrl($path);
        };
    }

    /**
     * Return css url.
     *
     * @param string $path
     *
     * @return string
     */
    public function getCssUrl($path)
    {
        return $this->getAssetUrl(ltrim($path, '/'));
    }

    /**
     * Return asset url.
     *
     * @param string $path
     *
     * @return string
     */
    private function getAssetUrl($path)
    {
        return '/assets/'.$this->getPathWithChecksum($path);
    }

    /**
     * Return path with checksum.
     *
     * @staticvar array $checksums
     *
     * @param string $path
     *
     * @return string
     */
    private function getPathWithChecksum($path)
    {
        static $checksums;
        if (!isset($checksums)) {
            $di = Di::getInstance();
            $checksums = array_merge(
                    require($di->checksumsPath.'css.php'), require($di->checksumsPath.'without-css.php')
            );
        }
        if (isset($checksums[$path])) {
            return $path.'?'.$checksums[$path];
        }

        return $path;
    }

    /**
     * Return valid url for html.
     *
     * @return callable
     */
    public function appUrl()
    {
        return function ($url) {
            return $url;
        };
    }

    /**
     * Add js to the head.
     *
     * @return callable
     */
    public function addJs()
    {
        return function ($path) {
            $di = Di::getInstance();
            $di->layoutHtml->addJs($this->getJsUrl($path));
        };
    }

    /**
     * Return css url.
     *
     * @param string $path
     *
     * @return string
     */
    public function getJsUrl($path)
    {
        return $this->getAssetUrl(ltrim($path, '/'));
    }
}
