<?php
namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTester;

class SampleControllerTest extends CIUnitTestCase
{
    use ControllerTester;

    public function testExceptionHandling()
    {
        $result = $this->controller(SampleController::class)
                       ->execute('index');

        $this->assertTrue($result->isFailure());
        $this->assertEquals(500, $result->response()->getStatusCode());
        $this->assertEquals('Sample exception', $result->response()->getBody());
    }
}