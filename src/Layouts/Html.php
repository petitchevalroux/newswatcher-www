<?php

namespace NwWebsite\Layouts;

use NwWebsite\Di;

// Extends from Slim\View otherwise slim build a new instance
class Html extends \Slim\View
{
    protected $data = [];
    private $htmlData = [];

    public function __construct()
    {
        $di = Di::getInstance();
        $di->mustache->addHelper('html', new \NwWebsite\Helpers\Html());
    }

    public function setTemplatesDirectory($directory)
    {
    }

    public function setData()
    {
    }

    public function appendData($data)
    {
        $this->data = $data;
    }

    /**
     * Set html page title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->htmlData['htmlTitle'] = $title;
    }

    /**
     * Add a css file to the head part.
     *
     * @param string $css
     */
    public function addCss($css)
    {
        if (!isset($this->htmlData['css'])) {
            $this->htmlData['css'] = [];
        }
        $this->htmlData['css'][] = $css;
    }

    public function display($template, $data = null)
    {
        $di = Di::getInstance();
        if ($this->data !== false) {
            $this->htmlData['htmlBody'] = $di->mustache
                    ->loadTemplate($template)
                    ->render($this->data);
        } else {
            $this->htmlData['htmlBody'] = $template;
        }
        // If not in dev, flush previous content
        if ($di->env !== ENV_DEVELOPMENT) {
            ob_end_clean();
        }
        echo $di->mustache->
                loadTemplate('layouts\html')
                ->render($this->htmlData);
    }
}
