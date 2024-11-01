<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use CodeIgniter\HTTP\ResponseInterface;

class TransactionController extends BaseController
{
    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user()->jsonSerialize();
            $user['role'] = auth()->user()->getGroups();
        }
    }

    public function shipping()
    {
        $addressModel = new AddressModel();
        $addresses = $addressModel->getAddressDetail(user_id());
        $data = [
            'title' => 'Transaction',
            'address' => $addresses,
        ];
        return view('transaction/shipping', $data);
    }
}
