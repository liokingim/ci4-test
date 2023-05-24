<?php

namespace App\Controllers;

use Tests\Support\ProjectTestCase;
use CodeIgniter\Test\FeatureTestCase;
use App\Services\BankService;

class BankControllerTest extends FeatureTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Mocking BankService
        $this->bankService = $this->getMockBuilder(BankService::class)
            ->onlyMethods(['deposit', 'withdraw'])
            ->getMock();
    }

    public function testDepositValidation()
    {
        // Define the return value for the deposit method.
        $this->bankService->method('deposit')
            ->willReturn(true);

        $data = ['amount' => 100, 'bank_code' => '0001', 'branch_number' => ''];
        $result = $this->withBody($data)
            ->post('/bank/deposit');

        $this->assertTrue($result->isOK());
    }

    public function testWithdrawValidation()
    {
        // Define the return value for the withdraw method.
        $this->bankService->method('withdraw')
            ->willReturn(true);

        $data = ['amount' => 100, 'bank_code' => '0001', 'branch_number' => ''];
        $result = $this->withBody($data)
            ->post('/bank/withdraw');

        $this->assertTrue($result->isOK());
    }

    public function testDeposit()
    {
        $data = ['amount' => 100];
        $result = $this->withBody($data)
            ->post('/bank/deposit');

        $this->assertTrue($result->isOK());
        // Add other assertions as needed.
    }

    public function testWithdraw()
    {
        $data = ['amount' => 100];
        $result = $this->withBody($data)
            ->post('/bank/withdraw');

        $this->assertTrue($result->isOK());
        // Add other assertions as needed.
    }

    public function testDepositValidation2()
    {
        $data = ['amount' => 100, 'bank_code' => '000', 'branch_number' => '00'];
        $result = $this->withBody($data)
            ->post('/bank/deposit');

        $this->assertTrue($result->isFail());

        $data = ['amount' => 100, 'bank_code' => '0001', 'branch_number' => ''];
        $result = $this->withBody($data)
            ->post('/bank/deposit');

        $this->assertTrue($result->isOK());
    }
}
