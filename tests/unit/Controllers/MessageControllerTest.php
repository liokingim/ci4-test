<?php
namespace Tests\Controllers;

use App\Controllers\MessageController;
use App\Services\MessageInterface;
use CodeIgniter\Test\CIUnitTestCase;

class MessageControllerTest extends CIUnitTestCase
{
    public function testIndex()
    {
        // Create a mock object for the MessageInterface
        $mockMessageService = $this->createMock(MessageInterface::class);

        // Configure the stub to return a specific value
        $mockMessageService->method('getMessage')
                           ->willReturn('Hello, mock service!');

        // Inject the mock object into the MessageController
        $messageController = new MessageController($mockMessageService);

        // Call the index method and check the returned view
        $response = $messageController->index();
        $this->assertStringContainsString('Hello, mock service!', $response);
    }
}