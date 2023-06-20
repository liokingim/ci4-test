<?php

namespace App\Services;

use App\Models\BankModel;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

class BankService
{
    protected $model;

    protected $request;

    public function __construct()
    {
        $this->request = service('curlrequest');
    }

    public function setModel(BankModel $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return false;
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

    private function balance($res1, $res2, $res3, $res4)
    {
        return $res1 . $res2 . $res3 . $res4;
    }



    public function balance2(string $accountId): array
    {
        //
        $response1 = $this->request->get('http://localhost/ci4-test/public/bank/account?accountId=' . $accountId);

        if ($response1->getStatusCode() !== ResponseInterface::HTTP_OK) {
            // Handle error
            throw new \Exception("Error while fetching API: account " . $response1->getReason());
        }

        //
        $response2 = $this->request->get('http://localhost/ci4-test/public/bank/transactions?accountId=' . $accountId);

        if ($response2->getStatusCode() !== ResponseInterface::HTTP_OK) {
            // Handle error
            throw new \Exception("Error while fetching API: transactions " . $response2->getReason());
        }

        //
        $response3 = $this->request->get('http://localhost/ci4-test/public/bank/loan?accountId=' . $accountId);

        if ($response3->getStatusCode() !== ResponseInterface::HTTP_OK) {
            // Handle error
            throw new \Exception("Error while fetching API: loan " . $response3->getReason());
        }

        return [
            'account' => json_decode($response1->getBody(), true),
            'transactions' => json_decode($response2->getBody(), true),
            'loan' => json_decode($response3->getBody(), true),
        ];
    }


    public function getAccountInfo($accountId)
    {
        // $url = "http://api.bank.com/accounts/$accountNumber";
        // return $this->getJsonData($url);
        return
            [
                "accountNumber" => "123456789",
                "accountHolderName" => "John Doe",
                "accountType" => "Savings",
                "balance" => 5000.00,
                "currency" => "USD"
            ];
    }

    public function getTransactionHistory($accountId)
    {
        // $url = "http://api.bank.com/accounts/$accountNumber/transactions";
        // return $this->getJsonData($url);

        return
            [
                "accountNumber" => "123456789",
                "transactions" => [
                    [
                        "transactionId" => "T1",
                        "type" => "DEBIT",
                        "amount" => 100.00,
                        "currency" => "USD",
                        "timestamp" => "2023-05-17T10:00:00Z"
                    ],
                    [
                        "transactionId" => "T2",
                        "type" => "CREDIT",
                        "amount" => 200.00,
                        "currency" => "USD",
                        "timestamp" => "2023-05-17T11:00:00Z"
                    ]
                ]
            ];
    }

    public function getLoanDetails($accountId)
    {
        // $url = "http://api.bank.com/loans/$loanId";
        // return $this->getJsonData($url);

        return
            [
                "loanId" => "L1",
                "loanAmount" => 10000.00,
                "currency" => "USD",
                "loanDurationInMonths" => 12,
                "interestRate" => 5.0,
                "monthlyPayment" => 856.07
            ];
    }

    private function getJsonData($url)
    {
        $response = $this->request->get($url);

        if ($response->hasError()) {
            throw new \Exception("Error while fetching API: " . $response->getReason());
        }

        $body = $response->getBody();

        return json_decode($body, true);
    }
}
