<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use Tests\Support\FeatureTestCase;

class BankController7Test extends CIUnitTestCase
{
    use FeatureTestCase;

    private $bankService;
    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        // Create a mock of BankService
        $this->bankService = $this->createMock(BankService::class);

        // Define the behavior of the mock methods
        $this->bankService->method('getCombiniApi')->willReturn('your_mock_data');
        $this->bankService->method('getBankNameApi')->willReturn('your_mock_data');
        $this->bankService->method('getBranchNameApi')->willReturn('your_mock_data');
        $this->bankService->method('getCardInfoApi')->willReturn('your_mock_data');

        // Assign the mock to the service in the controller
        $this->controller = new BankController($this->bankService);
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
