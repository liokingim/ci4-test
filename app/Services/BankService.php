<?php

namespace App\Services;

use App\Models\BankModel;

class BankService
{
    protected $model;

    public function setModel(BankModel $model)
    {
        $this->model = $model;
    }

    public function deposit($amount)
    {
        // Implement the logic to deposit the amount here.
    }

    public function withdraw($amount)
    {
        // Implement the logic to withdraw the amount here.
    }
}
