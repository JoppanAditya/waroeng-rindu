<?php

namespace App\Models;

use App\Controllers\RajaOngkir;
use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table            = 'addresses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['user_id', 'name', 'phone', 'label', 'province', 'city', 'postal_code', 'full_address', 'notes', 'is_default', 'is_selected'];

    protected bool $allowEmptyInserts = true;

    public function get($userId)
    {
        return $this->where('user_id', $userId)->orderBy('is_selected', 'DESC')->findAll();
    }

    public function getAddressDetail($userId)
    {
        $rajaongkir = new RajaOngkir();
        $addresses = $this->get($userId);

        foreach ($addresses as &$address) {
            $address['province_name'] = $rajaongkir->getProvinceName($address['province']);
            $address['city_name'] = $rajaongkir->getCityName($address['city'], $address['province']);
        }

        return $addresses;
    }
}
