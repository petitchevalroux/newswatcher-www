<?php

namespace NwWebsite\Controllers\Auth;

use NwWebsite\Di;
use NwWebsite\Controllers\Controller;

/**
 * Authenticated base controller.
 */
abstract class Authenticated extends Controller
{
    public function __construct()
    {
        $di = Di::getInstance();
        $this->user = $di->session->get('user');
        if (empty($this->user)) {
            $di->slim->render('auth'.DIRECTORY_SEPARATOR.'login', ['unauthenticated' => true]);
            $di->slim->response->setStatus(401);
            $di->slim->stop();
        }
    }
}
