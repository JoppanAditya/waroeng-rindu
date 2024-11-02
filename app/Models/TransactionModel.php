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
    protected $allowedFields    = ['id', 'user_id', 'address_id', 'courier', 'courier_service', 'delivery_fee', 'total_price', 'status', 'token', 'invoice'];

    protected bool $allowEmptyInserts = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    public function get($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function add($data)
    {
        return $this->insert($data);
    }
}
