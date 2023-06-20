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

class BankControllerMock01Test extends CIUnitTestCase
{
    // use DatabaseTestTrait;
    use FeatureTestTrait;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testBalance()
    {
        // Create a mock service object with a mock result.
        $mockResult = array('balance' => 100.0);
        $mockService = $this->getMockBuilder(BankService::class)
            ->getMock();
        $mockService->expects($this->once())
            ->method('balance2')
            ->with($this->equalTo('123456'))
            ->will($this->returnValue($mockResult));

        // Create a mock request object with a mocked `getGet()` method.
        $mockRequest = $this->getMockBuilder('CodeIgniter\HTTP\CURLRequest')
            ->disableOriginalConstructor()
            ->getMock();
        $mockRequest->expects($this->once())
            ->method('get')
            ->will($this->returnValue(array('accountId' => '123456')));

        $mockRequest = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor() // disable constructor for mocking
            ->setMethods(['getGet']) // set list of methods to mock
            ->getMock();
        $mockRequest->method('getGet')
            ->with($this->equalTo('accountId'))
            ->willReturn(['accountId' => '123456']);

        // Create a new instance of the controller and call the balance() method.
        $controller = new BankController($mockRequest);
        $controller->setBankService($mockService);

        // 테스트를 위해 call 메서드를 사용
        $result = $this->call('get', '/bank/balance?accountId=123456');

        // 응답 검증
        $response = json_decode(strip_tags($result->getBody()), true);

        // var_dump($response['account']['accountNumber']);

        $this->assertEquals('123456789', $response['account']['accountNumber']);
    }
}
