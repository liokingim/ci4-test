<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use App\Services\ValidationService;
use App\Controllers\ValidationController;
use CodeIgniter\HTTP\Request;

class ValidationController3Test extends CIUnitTestCase
{
    use ControllerTestTrait;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testValidAge()
    {
        $postData = ['age' => 25];
        $json = json_encode($postData);
        $result = $this->withJson($postData)
            ->controller('ValidationController')
            ->execute('index');

        $this->assertTrue($result->isOK());
        $this->assertEquals('Valid age: 25', (string) $result->getBody());
    }

    public function testMissingAgeParameter()
    {
        $result = $this->controller('ValidationController')
            ->execute('index');

        $this->assertFalse($result->isOK());
        $this->assertEquals('Age parameter is required', (string) $result->getBody());
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function testInvalidAge()
    {
        $postData = ['age' => -5];
        $result = $this->withJson($postData)
            ->controller('ValidationController')
            ->execute('index');

        $this->assertFalse($result->isOK());
        $this->assertEquals("Age must be a positive integer", (string) $result->getBody());
        $this->assertEquals(400, $result->getStatusCode());
    }
}
