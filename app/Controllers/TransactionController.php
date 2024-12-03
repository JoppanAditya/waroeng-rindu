<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use App\Models\CartModel;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;
use Midtrans;
use CodeIgniter\Exceptions\PageNotFoundException;

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
        $date = date("Ymd");
        $randomNumber = rand(1, 9999);

        $data = [
            'user_id' => $this->request->getPost('userId'),
            'address_id' => $this->request->getPost('addressId'),
            'courier' => $this->request->getPost('courier'),
            'courier_service' => $this->request->getPost('courierService'),
            'delivery_fee' => $this->request->getPost('deliveryFee'),
            'total_price' => $this->request->getPost('shoppingTotal'),
        ];
        $data['invoice'] = 'INV/' . $date . '/' . $randomNumber;
        $items = $this->request->getPost('items');

        $users = auth()->getProvider();
        $user = $users->findById($data['user_id']);
        $address = $this->addressModel->getSelected($data['user_id']);

        Midtrans\Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
        Midtrans\Config::$isProduction = false;
        Midtrans\Config::$isSanitized = true;
        Midtrans\Config::$is3ds = true;
        $id = random_string('alnum', 20);

        $params = [
            'transaction_details' => [
                'order_id' => $id,
                'gross_amount' => $data['total_price'],
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
            'price' => $data['delivery_fee'],
            'quantity' => 1,
            'name' => 'Delivery Fee'
        ];
        $params['item_details'][] = [
            'id' => 'F02',
            'price' => 1000,
            'quantity' => 1,
            'name' => 'Service Fee'
        ];

        $params['customer_details']['shipping_address'] = [
            'first_name' => $address['name'],
            'phone' => $address['phone'],
            'address' => $address['full_address'],
            'city' => $address['city_name'] . ', ' . $address['province_name'],
            'postal_code' => $address['postal_code'],
            'country_code' => 'IDN'
        ];

        $snapToken = Midtrans\Snap::getSnapToken($params);

        if ($snapToken) {
            return $this->response->setJSON([
                'success' => true,
                'snapToken' => $snapToken,
                'transactionData' => $data,
                'transactionItems' => $items,
            ]);
        } else {
            return $this->response->setJSON(['error' => 'Payment Error']);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getPost('transactionData');
            $data['id'] = $this->request->getPost('transactionId');
            $data['payment_method'] = $this->request->getPost('paymentType');
            $data['created_at'] = $this->request->getPost('transactionTime');
            $data['is_reviewed'] = 0;
            $items = $this->request->getPost('transactionItems');
            $status = $this->request->getPost('transactionStatus');

            $midtransResponse = $this->_fetchExpiryTime($data['id']);
            if ($midtransResponse && isset($midtransResponse->expiry_time)) {
                $data['expiry_time'] = $midtransResponse->expiry_time;
            } else {
                return $this->response->setJSON(['error' => 'Failed to retrieve expiry time from Midtrans']);
            }

            if ($status == 'capture' || $status == 'settlement') {
                $data['status'] = 'Awaiting Confirmation';
            } elseif ($status == 'pending') {
                $data['status'] = 'Pending Payment';
            } else {
                $data['status'] = 'Payment Failed';
            }

            $added = $this->transactionModel->add($data);
            $detailAdded = $this->transactionDetailModel->add($items, $data['id']);
            $cartModel = new CartModel();

            if ($added && $detailAdded) {
                if ($status == 'capture' || $status == 'settlement' || $status == 'pending') {
                    $cartModel->deleteCart('Shopping', $data['user_id']);
                    return $this->response->setJSON(['success' => true]);
                } else {
                    return $this->response->setJSON(['error' => 'Sorry, we had an issue confirming your payment']);
                }
            } else {
                return $this->response->setJSON(['error' => 'Unable to save transaction details.']);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function updateStatus()
    {
        if ($this->request->isAJAX()) {
            $transactionId = $this->request->getPost('transaction_id');
            $status = $this->request->getPost('status');

            $updated = $this->transactionModel->update($transactionId, ['status' => $status]);

            if ($updated) {
                return $this->response->setJSON(['success' => 'Your order has been completed.']);
            } else {
                return $this->response->setJSON(['error' => 'There was an error updating the order status.']);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    private function _fetchExpiryTime($transactionId)
    {
        $url = 'https://api.sandbox.midtrans.com/v2/' . $transactionId . '/status';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: ' . getenv('MINTRANS_API_KEY')
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
