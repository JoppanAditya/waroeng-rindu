<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MenuModel;
use App\Models\ReviewModel;
use App\Models\CartModel;
use App\Models\CategoryModel;

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
        $categoryModel = new CategoryModel();

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $menu = $this->menuModel->search($keyword);
        } else {
            $menu = $this->menuModel->get(false, 9, false);
        }

        $data = [
            'title' => 'Shop',
            'menus' => $menu,
            'pager' => $this->menuModel->pager,
            'categories' => $categoryModel->get(),
        ];

        if (auth()->loggedIn()) {
            $data['user'] = $this->user;
        }

        return view('shop/index', $data);
    }

    public function detail($slug)
    {
        $menu = $this->menuModel->get($slug);
        $related = $this->menuModel->get(false, 8);
        $review = $this->reviewModel->get($menu['id']);
        $comments = [];
        $replies = [];
        $favorite = $this->cartModel->checkFavorite(user_id(), $menu['id']);

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
            'favorite' => $favorite
        ];

        if (auth()->loggedIn()) {
            $data['user'] = $this->user;
        }

        return view('shop/detail', $data);
    }
}
