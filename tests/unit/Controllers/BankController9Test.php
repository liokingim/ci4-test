<?php

namespace App\Controllers;

use CodeIgniter\Test\FeatureTestTrait;
use App\Services\BankService;
use CodeIgniter\Test\CIUnitTestCase;

class BankController9Test extends CIUnitTestCase
{
    use FeatureTestTrait;

    private $bankService;
    private $bankController;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock BankService를 생성합니다.
        $this->bankService = $this->getMockBuilder(BankService::class)
            ->onlyMethods(['index'])
            ->getMock();

        // Mock BankService를 BankController에 주입합니다.
        $this->bankController = new BankController($this->bankService);
    }

    public function testGetBankInfo()
    {
        // BankService의 index() 메소드가 호출되었을 때 반환할 값을 설정합니다.
        $this->bankService->expects($this->once())
            ->method('index')
            ->willReturn('expected value');

        // BankController를 테스트합니다.
        $params = ['param1' => 'value1', 'param2' => 'value2'];
        $result = $this->call('get', '/get_bank_info', $params);

        // 반환값이 예상대로인지 확인합니다.
        $this->assertEquals('expected value', $result);
    }
}
