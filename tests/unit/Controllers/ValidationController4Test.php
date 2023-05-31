<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Services\ValidationService;
use App\Controllers\ValidationController;
use CodeIgniter\HTTP\Request;
use PHPUnit\Framework\TestCase;

class ValidationController4Test extends CIUnitTestCase
{
    // use ControllerTestTrait;
    use FeatureTestTrait;

    public function setUp(): void
    {
        parent::setUp();

        // Load in any required dependencies...
    }

    public function testValidAge()
    {
        $postData = ['age' => 25];
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['HTTP_ACCEPT'] = 'application/json';
        $headers = [
            'CONTENT_TYPE' => 'application/json',
        ];
        $response = $this->call('post', '/validate', ['json' => $postData]);

        $this->assertSame(200, $response->response()->getStatusCode());
        $this->assertEquals('Valid age: 25', (string)trim(strip_tags($response->getBody())));
    }

    public function testMissingAgeParameter()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['HTTP_ACCEPT'] = 'application/json';
        $response = $this->call('post', '/validate');

        $this->assertSame(400, $response->response()->getStatusCode());
        $this->assertEquals('Age parameter is required', (string)trim(strip_tags($response->getBody())));
    }

    public function testInvalidAge()
    {
        $postData = ['age' => -5];
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['HTTP_ACCEPT'] = 'application/json';
        $response = $this->call('post', '/validate', ['json' => $postData]);

        $this->assertSame(400, $response->response()->getStatusCode());
        $this->assertEquals('Age must be a positive integer', (string)trim(strip_tags($response->getBody())));
    }
}
