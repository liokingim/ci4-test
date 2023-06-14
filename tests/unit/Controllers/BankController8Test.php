<?php

namespace App\Controllers;

use CodeIgniter\Test\FeatureTestTrait;
use App\Services\BankService;
use CodeIgniter\Test\CIUnitTestCase;

class BankControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function setUp(): void
    {
        parent::setUp();

        // Create a mock of BankService
        $bankService = $this->createMock(BankService::class);

        // Define the behavior of the index method, assuming that it returns a combined result of the four methods.
        $bankService->method('index')->willReturn('your_mock_data');

        // Replace the BankService in the service container with the mock
        $this->mockService('bankService', $bankService, 'index');
    }

    public function testGetBankInfo()
    {
        // Call the route
        $result = $this->get('/get_bank_info');

        // Check the response
        $this->assertTrue($result->isOK());
        $this->see('your_expected_data_in_the_response');
    }
}
