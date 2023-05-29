<?php

namespace Tests\Services;

use Tests\Support\ProjectTestCase;
use App\Services\BankService;
use CodeIgniter\Test\Mock\MockModel;

class BankServiceTest extends ProjectTestCase
{
    protected $bankService;

    public function setUp(): void
    {
        parent::setUp();

        // Create a new instance of the service to test
        $this->bankService = new BankService();

        // Mock the BankModel
        $this->bankModel = $this->getMockBuilder('App\Models\BankModel')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testDeposit()
    {
        // Prepare data
        $data = [
            'depositor' => 'Test Depositor',
            'bank_code' => '1234',
            'branch_code' => '123',
            'account_number' => '1234567',
            'account_type' => '1'
        ];

        // Configure the stub
        $this->bankModel->expects($this->once())
            ->method('insert')
            ->with($this->equalTo($data))
            ->willReturn(true);

        // Set model
        $this->bankService->setModel($this->bankModel);

        // Perform test
        $result = $this->bankService->deposit($data);

        $this->assertTrue($result);
    }
}