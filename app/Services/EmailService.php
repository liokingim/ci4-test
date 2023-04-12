<?php
namespace App\Services;

use CodeIgniter\Email\Email;

class EmailService
{
    protected $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function sendWelcomeEmail(string $to, string $name)
    {
        $this->email->setTo($to);
        $this->email->setSubject('Welcome to Our Service');
        $message = "Hello, {$name}! Welcome to our service. We're glad to have you!";
        $this->email->setMessage($message);

        return $this->email->send();
    }
}