<?php

namespace NwWebsite\Controllers\Auth;

use NwWebsite\Controllers\Controller;
use NwWebsite\Di;

/**
 * Authentifier base controller.
 */
class Authentifier extends Controller
{
    /**
     * Authentify current user.
     *
     * @param array $user
     */
    protected function authentify($user)
    {
        $di = Di::getInstance();
        $di->session->set('user', $user);
        $request = $di->slim->request();
        $di->session->set('clientIp', $request->getIp());
        $di->session->set('clientUserAgent', $request->getUserAgent());
    }

    /**
     * Logout user.
     */
    public function logout()
    {
        $di = Di::getInstance();
        $di->session->delete('user');
    }
}
