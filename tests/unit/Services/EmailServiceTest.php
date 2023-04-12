<?php
namespace Tests\Services;

use App\Services\EmailService;
use CodeIgniter\Email\Email;
use CodeIgniter\Test\CIUnitTestCase;

class EmailServiceTest extends CIUnitTestCase
{
    public function testSendWelcomeEmail()
    {
        $to = 'test@example.com';
        $name = 'Test User';

        // Create a mock object for the Email class
        $mockEmail = $this->createMock(Email::class);

        // Configure the stub methods
        $mockEmail->expects($this->once())
                  ->method('setTo')
                  ->with($this->equalTo($to))
                  ->willReturnSelf();

        $mockEmail->expects($this->once())
                  ->method('setSubject')
                  ->with($this->equalTo('Welcome to Our Service'))
                  ->willReturnSelf();

        $mockEmail->expects($this->once())
                  ->method('setMessage')
                  ->willReturnSelf();

        $mockEmail->expects($this->once())
                  ->method('send')
                  ->willReturn(true);

        // Inject the mock object into the EmailService
        $emailService = new EmailService($mockEmail);

        // Call the sendWelcomeEmail method and check the result
        $result = $emailService->sendWelcomeEmail($to, $name);
        $this->assertTrue($result);
    }
}