<?php

namespace App\Services;

use App\Models\BankModel;
use App\Services\Resource\RequestResource;
use App\Services\Resource\ResponseResource;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

class BankService
{
    protected $model;
    protected $request;
    protected $client;
    protected $requestResource;
    protected $responseResource;

    public function __construct(
        RequestResource $requestResource,
        ResponseResource $responseResource
    ) {
        $this->requestResource = $requestResource;
        $this->responseResource = $responseResource;

        // $this->request = service('curlrequest');
        $this->client = \Config\Services::curlrequest();
        $this->client->setHeader('Content-Type', 'application/json');
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

    public function balance(string $accountId)
    {
        //
        $response1 = $this->client->get('http://localhost/ci4-test/public/bank/account?accountId=' . $accountId);

        if ($response1->getStatusCode() !== ResponseInterface::HTTP_OK) {
            // Handle error
            throw new \Exception("Error while fetching API: account " . $response1->getReason());
        }

        //
        $response2 = $this->client->get('http://localhost/ci4-test/public/bank/transactions?accountId=' . $accountId);

        if ($response2->getStatusCode() !== ResponseInterface::HTTP_OK) {
            // Handle error
            throw new \Exception("Error while fetching API: transactions " . $response2->getReason());
        }

        //
        $response3 = $this->client
            ->request('post', 'http://localhost/ci4-test/public/bank/loan', ['json' => ['accountId' => $accountId]]);

        if ($response3->getStatusCode() !== ResponseInterface::HTTP_OK) {
            // Handle error
            throw new \Exception("Error while fetching API: loan " . $response3->getReason());
        }

        $accounts = json_decode($response1->getJSON(), true);
        $transactions = json_decode($response2->getJSON(), true);
        $loan = json_decode($response3->getJSON(), true);

        // 첫 번째 API 응답 처리
        if (
            json_last_error() === JSON_ERROR_NONE
        ) {
            if (
                (is_array($accounts) || $accounts instanceof \Countable)
                && $accounts && count($accounts) > 0
            ) {
                foreach ($accounts as $item) {
                    // 각 항목에 대한 처리
                }
            } else {
                echo "Error: No valid data received from the first API.";
            }
        } else {
            echo "Error: Failed to decode JSON from the first API1.";
        }

        // 두 번째 API 응답 처리
        if (
            json_last_error() === JSON_ERROR_NONE
        ) {
            if ((is_array($transactions) || $transactions instanceof \Countable)
                && $transactions && count($transactions) > 0
            ) {
                foreach ($transactions as $item) {
                    // 각 항목에 대한 처리
                }
            } else {
                echo "Error: No valid data received from the second API.";
            }
        } else {
            echo "Error: Failed to decode JSON from the second API2.";
        }

        // 3 번째 API 응답 처리
        if (
            json_last_error() === JSON_ERROR_NONE
        ) {
            if ((is_array($loan) || $loan instanceof \Countable)
                && $loan && count($loan) > 0
            ) {
                foreach ($loan as $item) {
                    // 각 항목에 대한 처리
                }
            } else {
                echo "Error: No valid data received from the second API.";
            }
        } else {
            echo "Error: Failed to decode JSON from the second API3.";
        }

        $this->responseResource->setBody([
            'account' => $accounts,
            'transactions' => $transactions,
            'loan' => $loan,
        ]);

        // return [
        //     'account' => $accounts,
        //     'transactions' => $transactions,
        //     'loan' => $loan,
        // ];
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
