<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\TransactionDetailModel;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    protected $user;
    protected $cartData;

    public function __construct()
    {
        if (auth()->loggedIn()) {
            $this->user = auth()->user();
        }
    }

    public function index()
    {
        $menuModel = new MenuModel();

        $data = [
            'title' => 'Home',
            'user' => $this->user,
            'menu'  => $menuModel->get(false, 8, false),
            'bestseller'  => $menuModel->get(false, 6, false),
        ];

        return view('home', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'user' => $this->user,
        ];

        return view('contact', $data);
    }

    public function contactSend()
    {
        $validationRules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'message' => 'required|min_length[10]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $message = $this->request->getPost('message');

        $emailService = \Config\Services::email();
        $emailService->setFrom($email, $name);
        $emailService->setTo('info@waroengrindu.swmenteng.com');
        $emailService->setSubject('New Contact Form Submission');

        $emailContent = "
            <p>{$message}</p>
        ";
        $emailService->setMessage($emailContent);
        $emailService->setMailType('html');

        if ($emailService->send()) {
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to send your message. Please try again later.');
        }
    }

    public function invoice()
    {
        $id = $this->request->getGet('id');
        $transactionModel = new TransactionModel();
        $transactionDetailModel = new TransactionDetailModel();

        $transaction = $transactionModel->getByInvoice($id);

        $data = [
            'data' => $transaction,
            'items' => $transactionDetailModel->getById($transaction['id'])
        ];

        return view('invoice/index', $data);
    }
}
