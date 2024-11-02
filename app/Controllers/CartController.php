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

    public function getTotal()
    {
        $userId = user_id();
        $totalItems = $this->cartModel->where('user_id', $userId)->countAllResults();

        return $this->response->setJSON(['totalItems' => $totalItems]);
    }

    public function add()
    {
        $userId = user_id();
        $menuId = $this->request->getPost('menu_id');
        $quantity = $this->request->getPost('quantity');
        $price = $this->request->getPost('price');
        $notes = $this->request->getPost('notes');

        $this->cartModel->addCartItem($userId, $menuId, $quantity, $price, $notes);

        $cartItems = $this->cartModel->getCartItems($userId);
        $cartTotal = count($cartItems);

        session()->set('cart', $cartItems);
        session()->set('cartTotal', $cartTotal);

        return redirect()->back()->with('success', 'Successfully added menu to cart.');
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

            if ($updated) {
                return $this->response->setJSON([
                    'success' => 'Menu updated.',
                    'quantity' => $quantity,
                    'notes' => $notes
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
            $id = $this->request->getPost('id');
            $deleted = $this->cartModel->deleteCart(user_id(), $id);

            if ($deleted) {
                return $this->response->setJSON(['success' => 'Menu removed from cart']);
            }
            return $this->response->setJSON(['error' => 'Unable to remove menu from cart']);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }
}
