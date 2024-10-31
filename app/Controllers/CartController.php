<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CartModel;

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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
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

        $this->cartModel->saveCartItem($userId, $menuId, $quantity, $price, $notes);

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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function remove()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $deleted = $this->cartModel->removeCartItem($id);

            if ($deleted) {
                return $this->response->setJSON(['success' => 'Menu removed from cart']);
            }
            return $this->response->setJSON(['error' => 'Unable to remove menu from cart']);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }
}

    // public function add()
    // {
    //     $cart = \Config\Services::cart();
    //     $userId = (int) $this->request->getPost('user_id');

    //     $existingItems = $this->cartModel->where('user_id', $userId)->findAll();
    //     if (!empty($existingItems)) {
    //         $this->cartModel->where('user_id', $userId)->delete();
    //     }

    //     $cart->insert([
    //         'id'      => $this->request->getPost('menu_id'),
    //         'qty'     => $this->request->getPost('quantity'),
    //         'price'   => $this->request->getPost('price'),
    //         'name'    => $this->request->getPost('menu_name'),
    //         'options' => [
    //             'user_id' => $userId,
    //             'image'   => $this->request->getPost('image'),
    //             'slug'    => $this->request->getPost('slug'),
    //             'notes'   => $this->request->getPost('notes') ?: null,
    //         ]
    //     ]);

    //     $this->_databaseAdd();
    //     return redirect()->back()->with('success', 'Successfully added menu to cart.');
    //     // return redirect()->back()->with('success', $rowid . '<br>' . $data['rowid']);
    // }


    // private function _databaseAdd()
    // {
    //     $cart = \Config\Services::cart();
    //     $response = $cart->contents();

    //     foreach ($response as $rowid => $item) {
    //         $data = [
    //             'rowid'    => $rowid,
    //             'id'  => (int) $item['id'],
    //             'user_id'  => (int) $item['options']['user_id'],
    //             'quantity' => (int) $item['qty'],
    //             'price'    => (float) $item['price'],
    //             'subtotal' => (float) $item['subtotal'],
    //             'name'     => $item['name'],
    //             'image'    => $item['options']['image'],
    //             'slug'     => $item['options']['slug'],
    //             'notes'    => $item['options']['notes'],
    //         ];
    //         $this->cartModel->upsert($data);
    //     }
    // }

    // public function update()
    // {
    //     $carts = \Config\Services::cart();
    //     $rowId = $this->request->getPost('rowId');
    //     $quantity = $this->request->getPost('quantity');
    //     $notes = $this->request->getPost('notes') ?: null;

    //     $cart = $carts->getItem($rowId);

    //     $carts->update([
    //         'rowid'   => $rowId,
    //         'id'      => $cart['id'],
    //         'qty'     => $quantity,
    //         'price'   => $cart['price'],
    //         'name'    => $cart['name'],
    //         'options' => [
    //             'user_id' => $cart['options']['user_id'],
    //             'image'   => $cart['options']['image'],
    //             'slug'    => $cart['options']['slug'],
    //             'notes' => $notes
    //         ]
    //     ]);

    //     $item = $carts->getItem($rowId);

    //     if ($item) {
    //         $this->cartModel->updateCart($rowId, $item);
    //         return $this->response->setJSON(['success' => 'Cart item updated successfully']);
    //     } else {
    //         return $this->response->setJSON(['error' => 'Failed to update cart item.']);
    //     }
    // }

    // public function remove()
    // {
    //     $rowId = $this->request->getPost('rowId');
    //     $cart = \Config\Services::cart();
    //     $item = $cart->getItem($rowId);

    //     if ($item) {
    //         $this->cartModel->deleteCart($rowId, $item);
    //         $cart->remove($rowId);

    //         return $this->response->setJSON(['success' => 'Successfully deleted the selected menu from cart.']);
    //         // return redirect()->back()->with('success', 'Successfully deleted the selected menu from cart.');
    //     } else {
    //         return $this->response->setJSON(['error' => 'Failed to find the item in the cart.']);
    //         // return redirect()->back()->with('error', 'Failed to find the item in the cart.');
    //     }
    // }

    // public function clear()
    // {
    //     $cart = \Config\Services::cart();
    //     $cart->destroy();
    // }
