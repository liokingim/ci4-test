<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\Mock\MockServices;
use App\Controllers\BankController;
use App\Services\BankService;

class BankControllerTest extends CIUnitTestCase
{
    protected $bankController;
    protected $bankService;

    public function setUp(): void
    {
        parent::setUp();

        $this->bankService = new MockServices(new \Config\Services());

        // Controller 설정
        $this->bankController = new BankController();
        $this->bankController->setService($this->bankService);
    }

    public function testGetRequest()
    {
        $result = $this->bankController->get(1);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function testPostRequest()
    {
        $_POST['bank_code'] = '0001';
        $_POST['branch_number'] = '001';
        $result = $this->bankController->post();
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function testValidation()
    {
        // Valid Data
        $_POST['bank_code'] = '0001';
        $_POST['branch_number'] = '001';
        $result = $this->bankController->post();
        $this->assertEquals(200, $result->getStatusCode());

        // Invalid Data
        $_POST['bank_code'] = 'abc';
        $_POST['branch_number'] = '1234';
        $result = $this->bankController->post();
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function testResponseCheck()
    {
        $result = $this->bankController->get(1);
        $this->assertEquals('application/json', $result->getHeader('Content-Type')->getValue());
    }

    public function testDatabaseChangeCheck()
    {
        $initialCount = $this->getBankCount();
        $_POST['bank_code'] = '0002';
        $_POST['branch_number'] = '002';
        $this->bankController->post();
        $finalCount = $this->getBankCount();
        $this->assertEquals($initialCount + 1, $finalCount);
    }

    private function getBankCount()
    {
        // Count the current number of records in the bank database
        // Implement this method according to your database structure and need
    }
}
