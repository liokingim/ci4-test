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

    public function deposit()
    {
        return false;
    }

    public function withdraw($amount)
    {
        // Implement the logic to withdraw the amount here.
    }

    private function makeAddress($res1, $res2, $res3, $res4)
    {
        return $res1 . $res2 . $res3 . $res4;
    }

    public function processBankData($res1, $res2, $res3, $res4)
    {
        return $this->makeAddress($res1, $res2, $res3, $res4);
    }
}
