<?php

namespace App\Controllers;

use App\Services\BankService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Request;

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

    public function deposit(Request $request): ResponseInterface
    {
        // $validation =  \Config\Services::validation();

        // $validation->setRules([
        //     'bank_code' => 'required|numeric|exact_length[4]',
        //     'branch_number' => 'permit_empty|numeric|exact_length[3]',
        // ]);

        // if (!$validation->withRequest($request)->run()) {
        //     return $this->failValidationErrors($validation->getErrors());
        // }

        // $amount = $request->getGet('amount');
        // $bankCode = $request->getGet('bank_code');
        // $branchNumber = $request->getGet('branch_number');

        // $this->bankService->deposit($amount, $bankCode, $branchNumber);

        return view('welcome_message');
    }

    public function withdraw(Request $request): ResponseInterface
    {
        $amount = $request->getGet('amount');

        // Here, we are calling the withdraw method in the service.
        $this->bankService->withdraw($amount);

        return view('welcome_message');
    }
}