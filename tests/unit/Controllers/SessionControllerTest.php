<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTester;

class SessionControllerTest extends CIUnitTestCase
{
    use ControllerTester;

    public function testSessionData()
    {
        // Call the setSessionData method of SessionController
        $result = $this->controller(SessionController::class)
            ->execute('index');

        // Assert that the response status code is 200
        $this->assertTrue($result->isOK());

        // Get the response body as JSON and assert the message
        $response = json_decode($result->getJSON(), true);
        $this->assertEquals('Session data has been set.', $response['message']);
    }

    public function testSetSessionData()
    {
        // Call the setSessionData method of SessionController
        $result = $this->controller(SessionController::class)
            ->execute('setSessionData');

        // Assert that the response status code is 200
        $this->assertTrue($result->isOK());

        // Get the response body as JSON and assert the message
        $response = json_decode($result->getJSON(), true);
        $this->assertEquals('Session data has been set.', $response['message']);
    }

    public function testGetSessionData()
    {
        // Manually set the session data
        $session = session();
        $session->set('test_key', 'test_value');

        // Call the getSessionData method of SessionController
        $result = $this->controller(SessionController::class)
            ->execute('getSessionData');

        // Assert that the response status code is 200
        $this->assertTrue($result->isOK());

        // Get the response body as JSON and assert the session data
        $response = json_decode($result->getJSON(), true);
        $this->assertEquals('test_value', $response['test_key']);
    }
}