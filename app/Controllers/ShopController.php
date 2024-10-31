<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MenuModel;
use App\Models\ReviewModel;
use App\Models\CartModel;

class ShopController extends BaseController
{
    protected $menuModel;
    protected $reviewModel;
    protected $cartModel;
    protected $user;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->reviewModel = new ReviewModel();
        $this->cartModel = new CartModel();

        if (auth()->loggedIn()) {
            $this->user = auth()->user();
        }
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $menu = $this->menuModel->search($keyword);
        } else {
            $menu = $this->menuModel->get(false, 9, false);
        }

        $data = [
            'title' => 'Shop',
            'menu' => $menu,
            'pager' => $this->menuModel->pager,
            'carts' => \Config\Services::cart(),
        ];

        if (auth()->loggedIn()) {
            $data['user'] = $this->user;
        }

        return view('shop/index', $data);
    }

    public function detail($slug)
    {
        $menu = $this->menuModel->get($slug, 9, false);
        $related = $this->menuModel->get(false, 8, false);
        $review = $this->reviewModel->get($menu['id']);
        $comments = [];
        $replies = [];

        foreach ($review as $r) {
            if ($r['parent_id'] == 0) {
                $comments[] = $r;
            } else {
                $replies[$r['parent_id']][] = $r;
            }
        }

        $data = [
            'title' => 'Shop',
            'menu' => $menu,
            'related' => $related,
            'comment' => $comments,
            'reply' => $replies,
            'carts' => \Config\Services::cart(),
        ];

        if (auth()->loggedIn()) {
            $data['user'] = $this->user;
        }

        return view('shop/detail', $data);
    }

    // public function addCart()
    // {
    //     $data = $this->request->getPost();

    //     if ($this->cartModel->save($data)) {
    //         return redirect()->back()->with('message', 'Product added to cart successfully')->with('status', 'success');
    //     } else {
    //         return redirect()->back()->with('message', $this->cartModel->errors())->with('status', 'error')->withInput();
    //     }
    // }
}
