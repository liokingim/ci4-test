<?php

namespace App\Services;

class TestableBankService extends BankService
{
    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
