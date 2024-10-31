<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title' => 'Dashboard',
            'menuTitle' => 'Dashboard',
            'user' => $user
        ];

        return view('dashboard/index', $data);
    }

    public function profile()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title' => 'Profile',
            'menuTitle' => 'Profile',
            'user' => $user
        ];

        return view('dashboard/profile/index', $data);
    }
}
