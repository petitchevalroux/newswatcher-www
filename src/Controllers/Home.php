<?php

namespace NwWebsite\Controllers;

use NwWebsite\Controllers\Auth\Authenticated;

class Home extends Authenticated
{
    public function home()
    {
        var_dump($this->user);
    }
}
