<?php

namespace App\Services;

use Tests\Support\ProjectTestCase;
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\BankModel;

class BankServiceTest extends CIUnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Mocking BankModel
        $this->bankModel = $this->getMockBuilder(BankModel::class)
            ->onlyMethods(['insert', 'delete'])
            ->getMock();

        $this->bankService = new BankService();
        $this->bankService->setModel($this->bankModel);
    }

    public function testDeposit()
    {
        // Define the return value for the insert method.
        $this->bankModel->method('insert')
            ->willReturn(true);

        $result = $this->bankService->deposit(100);

        $this->assertTrue($result);
    }

    public function testWithdraw()
    {
        // Define the return value for the delete method.
        $this->bankModel->method('delete')
            ->willReturn(true);

        $result = $this->bankService->withdraw(100);

        $this->assertTrue($result);
    }

    public function testDeposit2()
    {
        $service = new BankService();

        // Assuming that the deposit method returns the new balance.
        $newBalance = $service->deposit(100);

        $this->assertEquals(100, $newBalance);
        // Add other assertions as needed.
    }

    public function testWithdraw2()
    {
        $service = new BankService();

        // Assuming that the deposit method has been called and the balance is now 100.
        $service->deposit(100);

        // Assuming that the withdraw method returns the new balance.
        $newBalance = $service->withdraw(50);

        $this->assertEquals(50, $newBalance);
        // Add other assertions as needed.
    }
}