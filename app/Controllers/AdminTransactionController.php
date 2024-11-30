<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\MenuModel;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminTransactionController extends BaseController
{
    protected $menuModel;
    protected $categoryModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->categoryModel = new CategoryModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {

        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title'         => 'Transaction',
            'menuTitle'     => 'Transaction',
            'user'          => $user,
        ];

        return view('dashboard/transaction/index', $data);
    }

    public function get()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'transactions'    => $this->transactionModel->findAll(),
            ];

            return $this->response->setJSON([
                'data' => view('dashboard/transaction/data', $data)
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function editForm()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $status = $this->transactionModel->getStatus($id);
            $data = [
                'id'        => $id,
                'status'    => $status['status'],
            ];

            return $this->response->setJSON([
                'success' => view('dashboard/transaction/modal/edit', $data),
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function detail($id)
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $transactionDetailModel = new TransactionDetailModel();

        $details = $transactionDetailModel->getById($id);

        $data = [
            'title'         => 'Transaction',
            'menuTitle'     => 'Transaction',
            'user'          => $user,
            'details'       => $details
        ];

        return view('dashboard/transaction/detail', $data);
    }

    public function getDetail()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getPost('data');
            $transaction = $this->transactionModel->getById($data[0]['transaction_id']);

            $data = [
                'details'    =>  $data,
                'transaction' => $transaction
            ];

            return $this->response->setJSON([
                'data' => view('dashboard/transaction/detailData', $data)
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $status = $this->request->getPost('status');

            if ($this->transactionModel->updateStatus($id, $status)) {
                return $this->response->setJSON(['success' => 'Transaction status has been updated successfully.']);
            } else {
                return $this->response->setJSON(['error' => 'Failed tp update transaction status.']);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }
}
