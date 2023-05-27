<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Services\BankService;
use App\Models\BankModel;

class BankServiceTest extends CIUnitTestCase
{
    protected $bankService;
    protected $bankModel;

    public function setUp(): void
    {
        parent::setUp();

        $this->bankModel = $this->createMock(BankModel::class);
        $this->bankService = new BankService($this->bankModel);
    }

    public function testDeposit()
    {
        // Mock the `deposit` method
        $this->bankModel->expects($this->once())
            ->method('deposit')
            ->with($this->equalTo(1), $this->equalTo(100))
            ->willReturn(true);

        // Test the `deposit` method
        $result = $this->bankService->deposit(1, 100);
        $this->assertTrue($result);
    }

    public function testWithdraw()
    {
        // Mock the `withdraw` method
        $this->bankModel->expects($this->once())
            ->method('withdraw')
            ->with($this->equalTo(1), $this->equalTo(50))
            ->willReturn(true);

        // Test the `withdraw` method
        $result = $this->bankService->withdraw(1, 50);
        $this->assertTrue($result);
    }
}