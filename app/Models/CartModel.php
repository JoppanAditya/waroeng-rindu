<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['type', 'menu_id', 'user_id', 'quantity', 'price', 'subtotal', 'notes'];

    public function checkFavorite($userId, $menuId)
    {
        return $this->where(['user_id' => $userId, 'type' => 'Favorite', 'menu_id' => $menuId])->first();
    }

    public function getCartItems($userId)
    {
        return $this->select('cart.*, menus.slug, menus.image, menus.name, menus.weight')
            ->join('menus', 'menus.id = cart.menu_id')
            ->where(['cart.user_id' => $userId, 'cart.type' => 'Shopping'])
            ->findAll();
    }

    public function getFavoriteItems($userId)
    {
        return $this->select('cart.*, menus.slug, menus.image, menus.name, menus.weight, menus.description, c.name as category_name')
            ->join('menus', 'menus.id = cart.menu_id')
            ->join('menu_categories c', 'c.id = menus.category_id')
            ->where(['cart.user_id' => $userId, 'cart.type' => 'Favorite'])
            ->paginate(9, 'favorites');
    }

    public function addCartItem($type, $userId, $menuId, $quantity, $price, $notes = null)
    {
        $item = $this->where([
            'type' => $type,
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
                'type' => $type,
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

    public function deleteCart($type, $userId, $menuId = null)
    {
        if ($menuId !== null) {
            $this->where('menu_id', $menuId);
        }
        return $this->where([
            'type' => $type,
            'user_id' => $userId
        ])->delete();
    }
}
