<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\CartModel;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    protected $user;
    protected $cartData;

    public function __construct()
    {
        if (auth()->loggedIn()) {
            $this->user = auth()->user();
        }
    }

    public function index()
    {
        $menuModel = new MenuModel();

        $data = [
            'title' => 'Home',
            'user' => $this->user,
            'carts' => \Config\Services::cart(),
            'menu'  => $menuModel->get(false, 8, false),
            'bestseller'  => $menuModel->get(false, 6, false),
        ];

        return view('home', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'user' => $this->user,
            'carts' => \Config\Services::cart(),
        ];

        return view('contact', $data);
    }
}
