<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use App\Models\CartModel;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;
use Midtrans\Config;

class TransactionController extends BaseController
{
    protected $addressModel;
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        $this->addressModel = new AddressModel();
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user()->jsonSerialize();
            $user['role'] = auth()->user()->getGroups();
        }
    }

    public function shipping()
    {
        $addresses = $this->addressModel->getAddressDetail(user_id());
        $data = [
            'title' => 'Transaction',
            'address' => $addresses,
        ];
        return view('transaction/shipping', $data);
    }

    public function payment()
    {
        helper('text');
        Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $input = [
            'id' => random_string('alnum', 20),
            'user_id' => $this->request->getPost('userId'),
            'address_id' => $this->request->getPost('addressId'),
            'courier' => $this->request->getPost('courier'),
            'courier_service' => $this->request->getPost('courierService'),
            'delivery_fee' => $this->request->getPost('deliveryFee'),
            'total_price' => $this->request->getPost('shoppingTotal'),
            'status' => 'Pending Payment'
        ];

        $users = auth()->getProvider();
        $user = $users->findById($input['user_id']);
        $items = $this->request->getPost('items');

        $date = date("Ymd");
        $randomNumber = rand(1, 9999);
        $input['invoice'] = 'INV/' . $date . '/' . $randomNumber;

        $params = [
            'transaction_details' => [
                'order_id' => $input['id'],
                'gross_amount' => $input['total_price'],
            ],
            'customer_details' => [
                'first_name' => $user->fullname,
                'email' => $user->email,
                'phone' => $user->mobile_number,
            ],
        ];
        foreach ($items as $item) {
            $params['item_details'][] = [
                'id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'name' => $item['name']
            ];
        }
        $params['item_details'][] = [
            'id' => 'F01',
            'price' => $input['delivery_fee'],
            'quantity' => 1,
            'name' => 'Delivery Fee'
        ];
        $params['item_details'][] = [
            'id' => 'F02',
            'price' => 1000,
            'quantity' => 1,
            'name' => 'Service Fee'
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $input['token'] = $snapToken;

        $added = $this->transactionModel->add($input);
        $detailAdded = $this->transactionDetailModel->add($items, $input['id']);

        $cartModel = new CartModel();

        if ($added && $detailAdded) {
            $cartModel->deleteCart($input['user_id']);
            return $this->response->setJSON([
                'success' => true,
                'snapToken' => $snapToken,
                'url' => base_url()
            ]);
        } else {
            return $this->response->setJSON(['error' => true, 'message' => 'Unable to add transaction data.']);
        }
    }

    public function paymentMethod()
    {
        $transaction = $this->transactionModel->get(user_id());
        $token = $transaction['token'];
        $data = [
            'title' => 'Transaction',
            'token' => $token,
        ];
        return view('transaction/payment', $data);
    }
}
