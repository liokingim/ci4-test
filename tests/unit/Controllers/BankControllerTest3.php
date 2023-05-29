<?php

namespace Tests\Controllers;

use Tests\Support\ProjectTestCase;
use CodeIgniter\Test\FeatureResponse;
use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\Mock\MockSession;

class BankControllerTest extends ProjectTestCase
{
    use ControllerTester;

    protected $refresh = true;

    public function setUp(): void
    {
        parent::setUp();

        // Mock the session for the controller
        $session = \Config\Services::session();
        $this->session = new MockSession($session->config);

        // Set the session service to use mock session
        $this->setPrivateProperty($session, 'session', $this->session);

        $this->controller(\App\Controllers\BankController::class);
    }

    public function testIndexGet()
    {
        $result = $this->get('bank/index');

        // Checking successful response
        $this->assertTrue($result->isOK());

        // Checking exception handling for page errors
        $this->expectException(\Exception::class);
        $this->get('non/existent/page');
    }

    public function testIndexPost()
    {
        // Prepare data
        $data = [
            'depositor' => 'Test Depositor',
            'bank_code' => '1234',
            'branch_code' => '123',
            'account_number' => '1234567',
            'account_type' => '1'
        ];

        // Mock the service
        $mockService = \Mockery::mock('App\Services\BankService');
        $mockService->shouldReceive('deposit')
            ->once()
            ->andReturn(true);

        // Replace service in the controller
        $this->controller(\App\Controllers\BankController::class)
             ->setService($mockService);

        // Test POST request
        $result = $this->post('bank/deposit', $data);

        // Checking for redirection after successful deposit
        $this->assertTrue($result->isRedirect());

        // Checking exception handling for database errors
        $this->expectException(\Exception::class);
        $mockService->shouldReceive('deposit')
            ->once()
            ->andThrow(\Exception::class);
        $this->post('bank/deposit', $data);

        // Checking exception handling for network errors
        $this->expectException(\Exception::class);
        $mockService->shouldReceive('deposit')
            ->once()
            ->andThrow(\Exception::class);
        $this->post('bank/deposit', $data);
    }
}