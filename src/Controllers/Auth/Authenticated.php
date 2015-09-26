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
        $request = $di->slim->request();
        $clientIp = $request->getIp();
        $clientUserAgent = $request->getUserAgent();
        if (empty($this->user) || $clientIp !== $di->session->get('clientIp') || $clientUserAgent !== $di->session->get('clientUserAgent')) {
            $di->slim->render('auth'.DIRECTORY_SEPARATOR.'login', ['unauthenticated' => true]);
            $di->slim->response->setStatus(401);
            $di->slim->stop();
        }
    }
}
