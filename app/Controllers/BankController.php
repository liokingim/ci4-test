<?php

namespace App\Controllers;

use App\Services\BankService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;

class BankController extends BaseController
{
    protected $bankService;

    public function __construct()
    {
        $this->bankService = new BankService();
    }

    // public function deposit(IncomingRequest $request): ResponseInterface
    // {
    //     $amount = $request->getPost('amount');

    //     // Here, we are calling the deposit method in the service.
    //     $this->bankService->deposit($amount);

    //     // ...
    // }

    public function deposit(IncomingRequest $request): ResponseInterface
    {
        $validation =  \Config\Services::validation();

        $validation->setRules([
            'bank_code' => 'required|numeric|exact_length[4]',
            'branch_number' => 'permit_empty|numeric|exact_length[3]',
        ]);

        if (!$validation->withRequest($request)->run()) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $amount = $request->getPost('amount');
        $bankCode = $request->getPost('bank_code');
        $branchNumber = $request->getPost('branch_number');

        $this->bankService->deposit($amount, $bankCode, $branchNumber);

        // ...
    }

    public function withdraw(IncomingRequest $request): ResponseInterface
    {
        $amount = $request->getPost('amount');

        // Here, we are calling the withdraw method in the service.
        $this->bankService->withdraw($amount);

        // ...
    }
}