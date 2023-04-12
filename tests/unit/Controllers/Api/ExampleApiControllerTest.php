<?php
namespace Tests\Controllers\Api;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\FeatureTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class ExampleApiControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    public function testIndex()
    {
        $result = $this->call("get", '/api/example');

        $result->assertStatus(200);
        $result->assertJSON([
            'status' => 'success',
            'message' => 'Hello, API!'
        ]);
    }
}