<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class SettingController extends BaseController
{
    protected $client;

    public function __construct()
    {
        if (auth()->loggedIn()) {
            $this->user = auth()->user();
        }
        $this->client = service('curlrequest');
    }

    public function index()
    {
        $data = [
            'title' => 'My Profile',
            'user' => $this->user
        ];
        return view('Settings/index', $data);
    }

    public function orderList()
    {
        $transactionModel = new TransactionModel();
        $transactionDetailModel = new TransactionDetailModel();
        $transaction = $transactionModel->getOrder(user_id(), false);

        foreach ($transaction as &$t) {
            $transactionDetails = $transactionDetailModel->getById($t['id']);

            if (!empty($transactionDetails)) {
                $t['menu_name'] = $transactionDetails[0]['menu_name'];
                $t['menu_price'] = $transactionDetails[0]['menu_price'];
                $t['quantity'] = $transactionDetails[0]['quantity'];
                $t['menu_image'] = $transactionDetails[0]['menu_image'];
                $t['slug'] = $transactionDetails[0]['slug'];
            }
        }
        unset($t);

        $data = [
            'title' => 'Order List',
            'user' => $this->user,
            'transactions' => $transaction,
        ];
        return view('Settings/order', $data);
    }


    public function paymentList()
    {
        $transactionModel = new TransactionModel();
        $transactionDetailModel = new TransactionDetailModel();
        $transaction = $transactionModel->getOrder(user_id(), true);

        foreach ($transaction as &$t) {
            $transactionDetails = $transactionDetailModel->getById($t['id']);

            if (!empty($transactionDetails)) {
                $t['menu_name'] = $transactionDetails[0]['menu_name'];
                $t['menu_price'] = $transactionDetails[0]['menu_price'];
                $t['quantity'] = $transactionDetails[0]['quantity'];
                $t['menu_image'] = $transactionDetails[0]['menu_image'];
                $t['slug'] = $transactionDetails[0]['slug'];
            }
        }
        unset($t);

        $data = [
            'title' => 'Payment List',
            'user' => $this->user,
            'transactions' => $transaction
        ];
        return view('Settings/payment', $data);
    }

    public function favorite()
    {
        $data = [
            'title' => 'Favorite',
            'user' => $this->user
        ];
        return view('Settings/favorite', $data);
    }

    public function address()
    {
        $data = [
            'title' => 'Address List',
            'user' => $this->user
        ];
        return view('Settings/address', $data);
    }

    public function security()
    {
        $data = [
            'title' => 'Security',
            'user' => $this->user
        ];
        return view('Settings/security', $data);
    }
}
