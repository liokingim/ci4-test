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
use Exception;

class BankControllerMock04Test extends CIUnitTestCase
{
    // use DatabaseTestTrait;
    use FeatureTestTrait;

    private $request;
    private $bankService;
    private $controller;

    public function setUp(): void
    {
        // create mock objects for dependencies
        $this->request = $this->getMockBuilder(CI_Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bankService = $this->getMockBuilder(BankService::class)
            ->disableOriginalConstructor()
            ->getMock();

        // create instance of controller to be tested, injecting mock dependencies
        $this->controller = new BankController($this->request, $this->bankService);
    }

    public function testBalanceWithValidAccountId(): void
    {
        // set up mock objects for this test case
        $accountId = 12345;
        $reqMock = ['accountId' => $accountId];
        $this->request->expects($this->once())
            ->method('getGet')
            ->willReturn($reqMock);

        $resultMock = ['balance' => 1000];
        $this->bankService->expects($this->once())
            ->method('balance2')
            ->with($accountId)
            ->willReturn($resultMock);

        // call the function being tested
        $response = $this->controller->balance();

        // make assertions about the response
        $expectedResponse = json_encode($resultMock);
        $this->assertEquals($expectedResponse, $response->getBody()->__toString());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testBalanceWithMissingAccountId(): void
    {
        // set up mock objects for this test case
        $reqMock = [];
        $this->request->expects($this->once())
            ->method('getGet')
            ->willReturn($reqMock);

        // call the function being tested
        $response = $this->controller->balance();

        // make assertions about the response
        $expectedResponse = '{"error":"Missing accountId parameter"}';
        $this->assertEquals($expectedResponse, $response->getBody()->__toString());
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testBalanceWithBankServiceError(): void
    {
        // set up mock objects for this test case
        $accountId = 12345;
        $reqMock = ['accountId' => $accountId];
        $this->request->expects($this->once())
            ->method('getGet')
            ->willReturn($reqMock);

        $errorMessage = 'Invalid account ID';
        $this->bankService->expects($this->once())
            ->method('balance2')
            ->with($accountId)
            ->willThrowException(new Exception($errorMessage));

        // call the function being tested
        $response = $this->controller->balance();

        // make assertions about the response
        $expectedResponse = '{"error":"' . $errorMessage . '"}';
        $this->assertEquals($expectedResponse, $response->getBody()->__toString());
        $this->assertEquals(500, $response->getStatusCode());
    }
}
