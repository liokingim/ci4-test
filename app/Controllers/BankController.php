<?php

namespace App\Controllers;

use App\Services\BankService;
use App\Services\Resource\RequestResource;
use App\Services\Resource\ResponseResource;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Request;
use CodeIgniter\RESTful\ResourceController;

class BankController extends ResourceController
{
    protected $bankService;
    // protected $request;
    protected $requestResource;
    protected $responseResource;

    public function __construct()
    {
        $this->requestResource = new RequestResource();
        $this->responseResource = new ResponseResource();

        $this->bankService = new BankService(
            $this->requestResource,
            $this->responseResource
        );
        // $this->request = Services::request();
    }

    // public function deposit(IncomingRequest $request): ResponseInterface
    // {
    //     $amount = $request->getPost('amount');

    //     // Here, we are calling the deposit method in the service.
    //     $this->bankService->deposit($amount);

    //     // ...
    // }

    public function index()
    {
        $this->bankService->index();

        return view('welcome_message');
    }

    public function deposit(Request $request)
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

    public function withdraw(IncomingRequest $request)
    {
        $amount = $request->getGet('amount');

        // Here, we are calling the withdraw method in the service.
        $this->bankService->withdraw($amount);

        return view('welcome_message');
    }

    public function setBankService($mockService)
    {
        $this->bankService = $mockService;
    }

    public function balance()
    {
        // $request = Services::request();

        $req = $this->request->getGet();

        // $result = $this->bankService->balance($req['accountId']);
        $this->bankService->balance($req['accountId']);

        $result = $this->responseResource->getBody();

        // log_message('error', "result => " . var_export($result, true));

        return $this->respond($result, ResponseInterface::HTTP_OK);
    }

    public function accountInfo()
    {
        $req = $this->request->getGet();
        // log_message('error', "accountInfo => " . var_export($req, true));

        $data = $this->bankService->getAccountInfo($req['accountId']);

        return $this->respond($data);
    }

    public function transactionHistory()
    {
        $req = $this->request->getGet();
        // log_message('error', "transactionHistory => " . var_export($req, true));

        $data = $this->bankService->getTransactionHistory($req['accountId']);

        return $this->respond($data);
    }

    public function loan()
    {
        $req = get_object_vars($this->request->getJSON());
        // log_message('error', "loanDetails request => " . var_export($this->request, true));
        log_message('error', "loanDetails => " . var_export($req, true));

        $data = $this->bankService->getLoanDetails($req['accountId']);

        // var_dump($data);

        return $this->respond($data);
    }
}
