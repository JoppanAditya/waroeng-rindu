<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    protected $table            = 'transaction_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['transaction_id', 'menu_id', 'menu_name', 'menu_image', 'slug', 'menu_price', 'quantity', 'notes'];

    protected bool $allowEmptyInserts = true;

    public function add($items, $transactionId)
    {
        foreach ($items as $item) {
            $data = [
                'transaction_id' => $transactionId,
                'menu_id' => $item['id'],
                'menu_name' => $item['name'],
                'menu_image' => $item['image'],
                'slug' => $item['slug'],
                'menu_price' => $item['price'],
                'quantity' => $item['quantity'],
                'notes' => $item['notes'] ?? null
            ];
            if ($this->insert($data)) {
                $results[] = $this->insertID();
            } else {
                $results[] = false;
            }
        }

        return $results;
    }

    public function getById($transId)
    {
        return $this->where('transaction_id', $transId)
            ->findAll();
    }

    public function getTopSellingMenus($limit = 5)
    {
        return $this->select('menu_name, menu_image, menu_price, slug, SUM(quantity) AS total_sold')
            ->groupBy('menu_name, menu_image, menu_price, slug')
            ->orderBy('total_sold', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}
