<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $transactionModel = new TransactionModel();
        $transactionDetailModel = new TransactionDetailModel();
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title' => 'Dashboard',
            'menuTitle' => 'Dashboard',
            'user' => $user,
            'totalRevenue' => $transactionModel->getTotalRevenue(),
            'topMenus' => $transactionDetailModel->getTopSellingMenus(),
            'recentSales' => $transactionModel->getAllData(),
        ];

        return view('dashboard/index', $data);
    }

    public function profile()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title' => 'Profile',
            'menuTitle' => 'Profile',
            'user' => $user
        ];

        return view('dashboard/profile/index', $data);
    }

    public function getSalesData()
    {
        if ($this->request->isAJAX()) {
            $transactionModel = new TransactionModel();

            $salesData = $transactionModel->getSalesData();

            $categories = [];
            $sales = [];

            foreach ($salesData as $data) {
                $categories[] = $data['date'];
                $sales[] = (int)$data['sales'];
            }

            return $this->response->setJSON([
                'categories' => $categories,
                'series' => [
                    [
                        'name' => 'Sales',
                        'data' => $sales
                    ],
                ]
            ]);
        }

        throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
    }
}
