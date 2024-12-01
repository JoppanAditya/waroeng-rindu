<?php

namespace App\Models;

use App\Controllers\RajaOngkir;
use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'user_id', 'address_id', 'courier', 'courier_service', 'delivery_fee', 'total_price', 'payment_method', 'status', 'invoice', 'is_reviewed', 'expiry_time', 'created_at'];

    protected bool $allowEmptyInserts = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $updatedField  = 'updated_at';

    // public function get($userId)
    // {
    //     return $this->where('user_id', $userId)->first();
    // }

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
        return $this->select('transactions.*, u.username, u.fullname, u.mobile_number AS user_phone, u.date_of_birth, u.gender, u.image, a.name AS address_name, a.label, a.city, a.province, a.postal_code, a.full_address, a.notes')
            ->join('addresses a', 'a.id = transactions.address_id')
            ->join('users u', 'u.id = transactions.user_id')
            ->orderBy('transactions.created_at', 'DESC')
            ->findAll();
    }

    public function getByInvoice($invoiceId)
    {
        $data = $this->select('transactions.*, u.fullname, a.name AS address_name, a.phone, a.city, a.province, a.postal_code, a.full_address, a.notes')
            ->join('addresses a', 'a.id = transactions.address_id')
            ->join('users u', 'u.id = transactions.user_id')
            ->where('transactions.invoice', $invoiceId)
            ->first();

        $rajaongkir = new RajaOngkir();
        $data['province_name'] = $rajaongkir->getProvinceName($data['province']);
        $data['city_name'] = $rajaongkir->getCityName($data['city'], $data['province']);

        return $data;
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

    public function getTotalRevenue()
    {
        return $this->selectSum('total_price', 'total_revenue')
            ->where('status', 'Finished')
            ->get()
            ->getRow()
            ->total_revenue;
    }

    public function getSalesData()
    {
        return $this->select("DATE(created_at) as date, COUNT(id) as sales")
            ->groupBy("DATE(created_at)")
            ->orderBy("date", "ASC")
            ->findAll();
    }
}
