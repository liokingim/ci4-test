<?php
namespace App\Services;

use App\Exceptions\TransactionException;
use CodeIgniter\Database\BaseConnection;

class OrderService
{
    protected $db;

    public function __construct(BaseConnection $db)
    {
        $this->db = $db;
    }

    public function createOrderWithItems(int $userId, int $productId, int $quantity, bool $forceError = false)
    {
        $this->db->transBegin();

        $orderData = [
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity
        ];

        $this->db->table('orders')->insert($orderData);
        $orderId = $this->db->insertID();

        $orderItemData = [
            'order_id' => $orderId,
            'product_id' => $productId,
            'quantity' => $quantity
        ];

        $this->db->table('order_items')->insert($orderItemData);

        if ($forceError) {
            $this->db->transRollback();
            throw new TransactionException("Forced error, transaction rolled back.");
        }

        $result = $this->db->transCommit();

        if (!$result) {
            throw new TransactionException("Transaction failed and has been rolled back.");
        }

        return $orderId;
    }
}