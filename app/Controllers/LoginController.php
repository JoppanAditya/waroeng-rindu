<?php

namespace App\Controllers;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends ShieldLogin
{
    public function login()
    {
        $auth = service('authentication');

        if ($auth->check()) {
            $auth->logout();

            session()->destroy();
        }
    }
}
