<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CartModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CartController extends BaseController
{
    protected $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        session();
    }

    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
        }

        $data = [
            'title' => 'Cart',
            'user'  => $user,
        ];

        return view('cart/index', $data);
    }

    public function get()
    {
        if ($this->request->isAJAX()) {
            $cart = $this->cartModel->getCartItems(user_id());

            return $this->response->setJSON([
                'data' => view('cart/data', ['cart' => $cart])
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function getFavorite()
    {
        if ($this->request->isAJAX()) {
            $menu = $this->cartModel->getFavoriteItems(user_id());

            $data = [
                'menus' => $menu,
                'pager' => $this->cartModel->pager,
            ];

            return $this->response->setJSON([
                'data' => view('settings/favoriteData', $data)
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function getTotal()
    {
        $userId = user_id();
        $totalItems = $this->cartModel->where('user_id', $userId)->countAllResults();

        return $this->response->setJSON(['totalItems' => $totalItems]);
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $userId = $this->request->getPost('user_id');
            $menuId = $this->request->getPost('menu_id');
            $quantity = $this->request->getPost('quantity');
            $price = $this->request->getPost('price');
            $notes = $this->request->getPost('notes');
            $type = $this->request->getPost('type');

            $favoriteCheck = $this->cartModel->checkFavorite($userId, $menuId);

            if ($type == 'Shopping' || ($type == 'Favorite' && !$favoriteCheck)) {
                $added = $this->cartModel->addCartItem($type, $userId, $menuId, $quantity, $price, $notes);
                $cartItems = $this->cartModel->getCartItems($userId);
                $cartTotal = count($cartItems);

                session()->set('cart', $cartItems);
                session()->set('cartTotal', $cartTotal);

                $response = [
                    'cart' => $cartItems,
                    'cartTotal' => $cartTotal,
                ];

                if ($added && $type == 'Shopping') {
                    $response['success'] = 'Successfully added menu to cart.';
                } elseif ($added && $type == 'Favorite') {
                    $response['favorite'] = 'added';
                    $response['success'] = 'Successfully added menu to favorite.';
                } else {
                    return $this->response->setJSON(['error' => 'Failed to add menu to cart.']);
                }

                return $this->response->setJSON($response);
            } elseif ($favoriteCheck) {
                $this->cartModel->deleteCart($type, $userId);
                return $this->response->setJSON([
                    'favorite' => 'removed',
                    'success' => 'Menu has been removed from favorite.'
                ]);
            }
            return $this->response->setJSON(['error' => 'Failed to add menu to cart or favorite.']);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $quantity = $this->request->getPost('quantity');
            $notes = $this->request->getPost('notes');
            $notes = empty($notes) ? null : $notes;

            if ($quantity < 1 || $quantity > 5) {
                return $this->response->setJSON(['error' => 'Quantity not allowed']);
            }

            $updated = $this->cartModel->updateCartItem($id, $quantity, $notes);

            $cartItems = $this->cartModel->getCartItems(user_id());
            $cartTotal = count($cartItems);

            session()->set('cart', $cartItems);
            session()->set('cartTotal', $cartTotal);

            if ($updated) {
                return $this->response->setJSON([
                    'success' => 'Menu updated.',
                    'quantity' => $quantity,
                    'notes' => $notes,
                    'cart' => $cartItems,
                    'cartTotal' => $cartTotal,
                ]);
            }
            return $this->response->setJSON(['error' => 'Unable to update menu.']);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function remove()
    {
        if ($this->request->isAJAX()) {
            $menuId = $this->request->getPost('menu_id');
            $userId = $this->request->getPost('user_id');
            $deleted = $this->cartModel->deleteCart('Shopping', $userId, $menuId);

            $cartItems = $this->cartModel->getCartItems($userId);
            $cartTotal = count($cartItems);

            session()->set('cart', $cartItems);
            session()->set('cartTotal', $cartTotal);

            if ($deleted) {
                return $this->response->setJSON([
                    'success' => 'Menu removed from cart',
                    'cart' => $cartItems,
                    'cartTotal' => $cartTotal,
                ]);
            }
            return $this->response->setJSON(['error' => 'Unable to remove menu from cart']);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }
}
