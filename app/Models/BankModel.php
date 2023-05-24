<?php

namespace App\Models;

use CodeIgniter\Model;

class BankModel extends Model
{
    protected $table = 'bank';

    public function deposit(int $amount)
    {
        // Insert a new record to the bank table
        $data = [
            'amount' => $amount,
            'transaction_type' => 'deposit',
        ];

        return $this->insert($data);
    }

    public function withdraw(int $amount)
    {
        // Find the record with the given amount and delete it
        $record = $this->where('amount', $amount)->first();

        if ($record) {
            return $this->delete($record['id']);
        }

        return false;
    }
}