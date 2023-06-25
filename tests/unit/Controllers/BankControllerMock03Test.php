<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Controllers\BankController;
use App\Services\BankService;
use App\Services\TestableBankService;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\Request;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
// use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class BankControllerMock03Test extends CIUnitTestCase
{
    // use DatabaseTestTrait;
    use FeatureTestTrait;

    private $bankService;

    public function setUp(): void
    {
        parent::setUp();
        // $this->bankService = new BankService();
        $this->bankService = new TestableBankService();
    }

    public function testBalance2()
    {
        $accountId = '123456';

        // Mock the request service
        $mockRequest = $this->getMockBuilder('CodeIgniter\HTTP\IncomingRequest')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $mockRequest->method('get')
            ->will($this->returnCallback([$this, 'mockedAPIResponses']));

        // $this->bankService->request = $mockRequest;
        $this->bankService->setRequest($mockRequest);

        $response = $this->bankService->balance2($accountId);

        // Perform assertions here
        $this->assertIsArray($response);
        $this->assertArrayHasKey('account', $response);
        $this->assertArrayHasKey('transactions', $response);
        $this->assertArrayHasKey('loan', $response);
    }

    public function mockedAPIResponses($url)
    {
        $mockedResponse = $this->getMockBuilder('CodeIgniter\HTTP\ResponseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockedResponse->method('getStatusCode')
            ->willReturn(ResponseInterface::HTTP_OK);

        if (strpos($url, 'bank/account') !== false) {
            $mockedResponse->method('getBody')->willReturn(json_encode([[
                "accountNumber" => "123456789",
                "accountHolderName" => "John Doe",
                "accountType" => "Savings",
                "balance" => 5000.00,
                "currency" => "USD"
            ]]));
        } else if (strpos($url, 'bank/transactions') !== false) {
            $mockedResponse->method('getBody')->willReturn(json_encode([
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
            ]));
        } else if (strpos($url, 'bank/loan') !== false) {
            $mockedResponse->method('getBody')->willReturn(json_encode([
                "loanId" => "L1",
                "loanAmount" => 10000.00,
                "currency" => "USD",
                "loanDurationInMonths" => 12,
                "interestRate" => 5.0,
                "monthlyPayment" => 856.07
            ]));
        }

        return $mockedResponse;
    }
}
