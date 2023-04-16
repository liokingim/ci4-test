<?php
namespace App\Controllers;

use App\Exceptions\TransactionException;
use App\Services\OrderService;
use CodeIgniter\Controller;

class OrderController extends Controller
{
    public function create()
    {
        $input = $this->request->getPost();
        $orderService = new OrderService($this->db);

        try {
            $orderId = $orderService->createOrderWithItems($input['user_id'], $input['product_id'], $input['quantity'], $input['force_error'] ?? false);
        } catch (TransactionException $e) {
            return $this->fail($e->getMessage(), 500);
        }

        return $this->respondCreated(['order_id' => $orderId, 'message' => 'Order created successfully']);
    }
}