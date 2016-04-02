<?php

namespace NwWebsite\Controllers;

use NwWebsite\Controllers\Auth\Authenticated;
use NwWebsite\Di;

class Home extends Authenticated
{
    public function home()
    {
        $di = Di::getInstance();
        $di->slim->render('home', []);
    }
}
