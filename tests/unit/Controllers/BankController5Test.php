<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Controllers\BankController;
use App\Services\BankService;

class BankController5Test extends TestCase
{
    protected $bankController;

    protected function setUp(): void
    {
        // BankService mock 객체 생성
        $mockBankService = $this->createMock(BankService::class);

        // 각 API 메소드에 대해 원하는 값을 반환하도록 설정
        $mockBankService->method('getCombiniApi')
            ->willReturn(['combinInfo' => 'Mock CombinInfo']);

        $mockBankService->method('getBankNameApi')
            ->willReturn(['bankName' => 'Mock BankName']);

        $mockBankService->method('getBranchNameApi')
            ->willReturn(['branchName' => 'Mock BranchName']);

        $mockBankService->method('getCardInfoApi')
            ->willReturn(['cardInfo' => 'Mock CardInfo']);

        $this->bankController = new BankController($mockBankService);
    }

    public function testIndex()
    {
        $response = $this->bankController->index();
        $this->assertIsArray($response);

        // 각 API 메소드에 대한 반환값 확인
        $this->assertEquals('Mock CombinInfo', $response['combinInfo']);
        $this->assertEquals('Mock BankName', $response['bankName']);
        $this->assertEquals('Mock BranchName', $response['branchName']);
        $this->assertEquals('Mock CardInfo', $response['cardInfo']);
    }
}
