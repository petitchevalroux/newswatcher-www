<?php

namespace NwWebsite\Helpers;

use NwWebsite\Di;

class Session
{
    public function __construct()
    {
        // Change session name
        session_name('sha1');
    }

    /**
     * Enable session only if not already enabled.
     *
     * @staticvar boolean $enabled
     */
    private function enable()
    {
        static $enabled;
        if (empty($enabled)) {
            session_cache_limiter('');
            session_start();
            $enabled = true;
        }
    }

    /**
     * Disable session.
     */
    public function disable()
    {
        // If session if active
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        // If cookie exists delete it
        $di = Di::getInstance();
        $cookie = $di->slim->getCookie(session_name());
        if (!is_null($cookie)) {
            $di = Di::getInstance();
            // Path is needed in order to delete session cookie
            $di->slim->response->deleteCookie(session_name(), ['path' => '/']);
        }
    }

    /**
     * Set session value.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        $this->enable();
        $_SESSION[$name] = $value;
    }

    /**
     * Return session value for $name.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        $di = Di::getInstance();
        // Check if cookie is on the client in order to avoid useless session start
        $cookie = $di->slim->getCookie(session_name());
        if (empty($cookie)) {
            return;
        }
        $this->enable();

        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    /**
     * Delete value for $name.
     *
     * @param string $name
     */
    public function delete($name)
    {
        if (isset($_SESSION)) {
            unset($_SESSION[$name]);
            if (empty($_SESSION)) {
                $this->disable();
            }
        } else {
            $this->disable();
        }
    }
}
