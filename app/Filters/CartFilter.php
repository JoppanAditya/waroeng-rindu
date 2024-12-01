<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CartModel;
use App\Models\TransactionModel;

class CartFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (auth()->loggedIn()) {
            $cartModel = new CartModel();
            $cartItems = $cartModel->getCartItems(user_id());
            $cartTotal = count($cartItems);
            session()->set('cart', $cartItems);
            session()->set('cartTotal', $cartTotal);

            // Pengecekan transaksi yang sudah expired dan update statusnya
            $transactionModel = new TransactionModel();
            $expiredTransactions = $transactionModel->where('expiry_time <', date('Y-m-d H:i:s'))
                ->where('status', 'Pending Payment')
                ->findAll();

            // Update status transaksi yang sudah expired
            foreach ($expiredTransactions as $transaction) {
                $transactionModel->update($transaction['id'], ['status' => 'Cancelled by System']);
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
