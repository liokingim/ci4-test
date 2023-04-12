<?php
namespace Tests\Controllers;

use App\Controllers\GreetingController;
use App\Services\GreetingService;
use CodeIgniter\Test\CIUnitTestCase;

class GreetingControllerTest extends CIUnitTestCase
{
    public function testGreet()
    {
        $name = 'John';

        // Create a mock object for the GreetingService
        $mockGreetingService = $this->createMock(GreetingService::class);

        // Configure the stub to return a specific value
        $mockGreetingService->method('greet')
                            ->with($this->equalTo($name))
                            ->willReturn("Hello, {$name}!");

        // Inject the mock object into the GreetingController
        $greetingController = new GreetingController($mockGreetingService);

        // Call the greet method and check the returned view
        $response = $greetingController->greet($name);
        $this->assertStringContainsString("Hello, {$name}!", $response);
    }
}