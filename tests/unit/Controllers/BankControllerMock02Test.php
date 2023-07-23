<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Controllers\BankController;
use App\Services\BankService;
use App\Services\Resource\RequestResource;
use App\Services\Resource\ResponseResource;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\Request;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
// use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class BankControllerMock02Test extends CIUnitTestCase
{
    // use DatabaseTestTrait;
    use FeatureTestTrait;

    private $curlrequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->curlrequest = $this->getMockBuilder('CodeIgniter\HTTP\CURLRequest')
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        Services::injectMock('curlrequest', $this->curlrequest);
    }


    // $mock = $this->getMockBuilder(SomeClass::class)
    //              ->setMethods(['someMethod'])
    //              ->getMock();

    // $mock->expects($this->exactly(3))
    //      ->method('someMethod')
    //      ->withConsecutive(
    //          ['first', 'call'],  // The expected arguments for the first call
    //          ['second', 'call'], // The expected arguments for the second call
    //          ['third', 'call']   // The expected arguments for the third call
    //      );

    public function testBalance2()
    {
        $accountId = '123456';
        $expected = [
            'account' => [
                "accountNumber" => "123456789",
                "accountHolderName" => "John Doe",
                "accountType" => "Savings",
                "balance" => 5000,
                "currency" => "USD"
            ],
            'transactions' => [
                "accountNumber" => "123456789",
                "transactions" => [
                    [
                        "transactionId" => "T1",
                        "type" => "DEBIT",
                        "amount" => 100,
                        "currency" => "USD",
                        "timestamp" => "2023-05-17T10:00:00Z"
                    ],
                    [
                        "transactionId" => "T2",
                        "type" => "CREDIT",
                        "amount" => 200,
                        "currency" => "USD",
                        "timestamp" => "2023-05-17T11:00:00Z"
                    ]
                ]
            ],
            'loan' => [
                "loanId" => "L1",
                "loanAmount" => 10000,
                "currency" => "USD",
                "loanDurationInMonths" => 12,
                "interestRate" => 5,
                "monthlyPayment" => 856.07
            ],
        ];

        // Mock the request responses
        $this->curlrequest->expects($this->exactly(3))
            ->method('request')
            ->withConsecutive(
                [$this->equalTo('get')],  // First call with 'param1'
                [$this->equalTo('get')],  // Second call with 'param2'
                [$this->equalTo('post')]   // Third call with 'param3'
            )
            ->willReturnOnConsecutiveCalls(
                $this->createMockResponse(ResponseInterface::HTTP_OK, $expected['account']),
                $this->createMockResponse(ResponseInterface::HTTP_OK, $expected['transactions']),
                $this->createMockResponse(ResponseInterface::HTTP_OK, $expected['loan'])
            );

        $requestResource = new RequestResource();
        $responseResource = new ResponseResource();

        // Create an instance of BankService
        $bankService = new BankService($requestResource, $responseResource);

        $bankService->balance($accountId);
        $result = $responseResource->getBody();

        // Verify the results
        $this->assertSame($expected, $result);
    }

    public function testBalance3()
    {
        $accountId = '123456';
        $expected = [
            'account' => [
                "accountNumber" => "123456789",
                "accountHolderName" => "John Doe",
                "accountType" => "Savings",
                "balance" => 5000,
                "currency" => "USD"
            ],
            'transactions' => [
                "accountNumber" => "123456789",
                "transactions" => [
                    [
                        "transactionId" => "T1",
                        "type" => "DEBIT",
                        "amount" => 100,
                        "currency" => "USD",
                        "timestamp" => "2023-05-17T10:00:00Z"
                    ],
                    [
                        "transactionId" => "T2",
                        "type" => "CREDIT",
                        "amount" => 200,
                        "currency" => "USD",
                        "timestamp" => "2023-05-17T11:00:00Z"
                    ]
                ]
            ],
            'loan' => [
                "loanId" => "L122",
                "loanAmount" => 10000,
                "currency" => "USD",
                "loanDurationInMonths" => 12,
                "interestRate" => 5,
                "monthlyPayment" => 856.07
            ],
        ];

        // Mock the request responses
        $this->curlrequest->expects($this->exactly(3))
            ->method('request')
            ->withConsecutive(
                [$this->equalTo('get')],
                [$this->equalTo('get')],
                [$this->equalTo('post')]
            )
            ->willReturnOnConsecutiveCalls(
                $this->createMockResponse2(ResponseInterface::HTTP_OK, $expected['account']),
                $this->createMockResponse2(ResponseInterface::HTTP_OK, $expected['transactions']),
                $this->createMockResponse2(ResponseInterface::HTTP_OK, $expected['loan'])
            );

        $result = $this->call('get', '/bank/balance', [
            'accountId'  => '12345'
        ]);
        $resultArray = json_decode($result->getJSON(), true);

        var_dump($result->getJSON());

        // Verify the results
        $this->assertSame($expected, $resultArray);
    }

    private function createMockResponse(int $status, array $body)
    {
        $response = $this->getMockBuilder('CodeIgniter\HTTP\CURLResponse')
            ->disableOriginalConstructor()
            ->setMethods(['getStatusCode', 'getBody'])
            ->getMock();

        $response->method('getStatusCode')->willReturn($status);
        $response->method('getBody')->willReturn(json_encode($body));

        return $response;
    }

    private function createMockResponse2(int $status, array $body): ResponseInterface
    {
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $response->method('getStatusCode')->willReturn($status);
        $response->method('getJSON')->willReturn(json_encode($body));

        return $response;
    }
}
