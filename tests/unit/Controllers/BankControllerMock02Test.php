<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Controllers\BankController;
use App\Services\BankService;
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

    private $http;

    protected function setUp(): void
    {
        parent::setUp();
        $this->http = $this->getMockBuilder('CodeIgniter\HTTP\CURLRequest')
            ->disableOriginalConstructor()
            ->getMock();

        Services::injectMock('request', $this->http);
    }

    public function testBalance2()
    {
        $accountId = '123456';
        $expected = [
            'account' => ['balance' => 1000],
            'transactions' => ['list' => []],
            'loan' => ['amount' => 500],
        ];

        // Mock the request responses
        $this->http->expects($this->at(0))
            ->method('get')
            ->willReturn($this->createMockResponse(ResponseInterface::HTTP_OK, $expected['account']));
        $this->http->expects($this->at(1))
            ->method('get')
            ->willReturn($this->createMockResponse(ResponseInterface::HTTP_OK, $expected['transactions']));
        $this->http->expects($this->at(2))
            ->method('get')
            ->willReturn($this->createMockResponse(ResponseInterface::HTTP_OK, $expected['loan']));

        // Create an instance of BankService
        $bankService = new BankService();

        $result = $bankService->balance2($accountId);

        // Verify the results
        $this->assertEquals($expected, $result);
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
