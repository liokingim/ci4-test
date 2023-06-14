<?php

namespace App\Test;

use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\CIUnitTestCase;
use App\Controllers\BankController;
use CodeIgniter\HTTP\ResponseInterface;

class BankController6Test extends CIUnitTestCase
{
    use ControllerTester;

    public function testIndex()
    {
        // curlRequest를 mock
        $mockService = $this->getMockBuilder('App\Services\BankService')
            ->setMethods(['curlRequest'])
            ->getMock();

        // 각 메소드 호출에 대한 반환값 설정
        $mockService->expects($this->at(0))
            ->method('curlRequest')
            ->willReturn(['combinInfo' => 'Mock CombinInfo']);

        $mockService->expects($this->at(1))
            ->method('curlRequest')
            ->willReturn(['bankName' => 'Mock BankName']);

        $mockService->expects($this->at(2))
            ->method('curlRequest')
            ->willReturn(['branchName' => 'Mock BranchName']);

        $mockService->expects($this->at(3))
            ->method('curlRequest')
            ->willReturn(['cardInfo' => 'Mock CardInfo']);

        // BankController에 mock service를 주입
        $controller = new BankController();
        $controller->initController(request(), new \CodeIgniter\HTTP\Response(), \Config\Services::logger());
        $controller->setService($mockService);

        // 메소드 호출
        $result = $controller->index();

        // Assertions
        $this->assertTrue($result instanceof ResponseInterface);
        $this->assertEquals(200, $result->getStatusCode());
    }
}
