<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['menu_id', 'user_id', 'quantity', 'price', 'subtotal', 'notes'];

    public function getCartItems($userId)
    {
        return $this->select('cart.*, menus.slug, menus.image, menus.name, menus.weight')
            ->join('menus', 'menus.id = cart.menu_id')
            ->where('cart.user_id', $userId)
            ->findAll();
    }

    public function addCartItem($userId, $menuId, $quantity, $price, $notes = null)
    {
        $item = $this->where([
            'user_id' => $userId,
            'menu_id' => $menuId,
            'notes' => $notes,
        ])->first();

        if ($item) {
            $quantity += $item['quantity'];
            $subtotal = $quantity * $price;
            return $this->update($item['id'], [
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'notes' => $notes,
            ]);
        } else {
            return $this->insert([
                'user_id' => $userId,
                'menu_id' => $menuId,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $quantity * $price,
                'notes' => $notes,
            ]);
        }
    }

    public function updateCartItem($id, $quantity, $notes = null)
    {
        $item = $this->where('id', $id)->first();

        if ($item) {
            $subtotal = $quantity * $item['price'];
            return $this->update($id, [
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'notes' => $notes,
            ]);
        }
    }

    public function deleteCart($userId, $menuId = null)
    {
        if ($menuId !== null) {
            $this->where('menu_id', $menuId);
        }
        $this->where('user_id', $userId)
            ->delete();
    }
}
