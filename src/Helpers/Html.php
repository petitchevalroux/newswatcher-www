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
}
