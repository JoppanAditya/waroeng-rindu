<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'user_id', 'address_id', 'courier', 'courier_service', 'delivery_fee', 'total_price', 'payment_method', 'status', 'invoice'];

    protected bool $allowEmptyInserts = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function get($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getByUser($userId)
    {
        return $this->select('transactions.*, transaction_details.menu_name, transaction_details.menu_price, transaction_details.quantity, menus.image as menu_image, menus.slug as slug')
            ->join('transaction_details', 'transaction_details.transaction_id = transactions.id')
            ->join('menus', 'menus.id = transaction_details.menu_id')
            ->where('transactions.user_id', $userId)
            ->orderBy('transactions.created_at', 'DESC')
            ->findAll();
    }

    public function getById($transId)
    {
        return $this->where('id', $transId)->first();
    }

    public function getAllData()
    {
        return $this->select('transactions.*, addresses.*, users.*')
            ->join('addresses', 'addresses.id = transactions.address_id')
            ->join('users', 'users.id = transactions.user_id')
            ->findAll();
    }

    public function getOrder($userId, $pending)
    {
        $this->where('user_id', $userId);
        if ($pending) {
            $this->where('status', 'Pending Payment');
        } else {
            $this->where('status !=', 'Pending Payment');
        }
        return $this->orderBy('created_at', 'DESC')
            ->findAll();
    }


    public function getStatus($id)
    {
        return $this->select('status')->where('id', $id)->first();
    }

    public function add($data)
    {
        return $this->insert($data);
    }

    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}
