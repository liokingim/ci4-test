<?php

namespace App\Controllers;

use CodeIgniter\Test\FeatureTestTrait;
use App\Services\BankService;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Services;

class BankController10Test extends CIUnitTestCase
{
    use FeatureTestTrait;

    private $bankService;
    private $bankController;
    private $curlRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->curlRequest = $this->getMockBuilder('CodeIgniter\HTTP\CURLRequest')
            ->onlyMethods(['request'])
            ->getMock();

        Services::injectMock('curlrequest', $this->curlRequest);

        $this->bankService = new BankService();

        $this->bankController = new BankController($this->bankService);
    }

    public function testGetBankInfo()
    {
        $params = ['param1' => 'value1', 'param2' => 'value2'];

        $this->curlRequest->expects($this->at(0))
            ->method('request')
            ->willReturn(json_encode(['combinInfo' => 'Mock CombinInfo']));

        $this->curlRequest->expects($this->at(1))
            ->method('request')
            ->willReturn(json_encode(['bankName' => 'Mock BankName']));

        $this->curlRequest->expects($this->at(2))
            ->method('request')
            ->willReturn(json_encode(['branchName' => 'Mock BranchName']));

        $this->curlRequest->expects($this->at(3))
            ->method('request')
            ->willReturn(json_encode(['cardInfo' => 'Mock CardInfo']));

        // BankController를 테스트합니다.
        $result = $this->call('get', '/get_bank_info', $params);

        // 반환값이 예상대로인지 확인합니다.
        $this->assertJson($result->getBody());
    }
}
