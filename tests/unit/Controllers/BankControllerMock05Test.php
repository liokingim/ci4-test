<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class BankControllerMock05Test extends CIUnitTestCase
{
    use FeatureTestTrait;

    private $curlrequest;

    public function setUp(): void
    {
        parent::setUp();

        $this->curlrequest = $this->getMockBuilder('CodeIgniter\HTTP\CURLRequest')
            ->disableOriginalConstructor()
            ->setMethods(['request'])
            ->getMock();

        Services::injectMock('curlrequest', $this->curlrequest);
    }

    public function testBalance()
    {
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
                "interestRate" => 7,
                "monthlyPayment" => 856.07
            ],
        ];

        // Mock the request responses
        $this->curlrequest->expects($this->exactly(3))
            ->method('request')
            ->withConsecutive(
                [$this->equalTo('get')],  // First call with 'param1'
                [$this->equalTo('get')],  // Second call with 'param2'
                [$this->equalTo('get')]   // Third call with 'param3'
            )
            ->willReturnOnConsecutiveCalls(
                $this->createMockResponse(ResponseInterface::HTTP_OK, $expected['account']),
                $this->createMockResponse(ResponseInterface::HTTP_OK, $expected['transactions']),
                $this->createMockResponse(ResponseInterface::HTTP_OK, $expected['loan'])
            );

        $response = $this->call('get', '/bank/balance', ['accountId' => '123456']);

        $this->assertEquals(200, $response->response()->getStatusCode());
        $this->assertEquals($expected, json_decode($response->response()->getBody(), true));
    }

    private function createMockResponse(int $status, array $body)
    {
        $response = $this->getMockBuilder('CodeIgniter\HTTP\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $response->method('getStatusCode')->willReturn($status);
        $response->method('getBody')->willReturn(json_encode($body));

        return $response;
    }
}
