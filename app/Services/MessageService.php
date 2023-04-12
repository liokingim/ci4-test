<?php
namespace App\Services;

class MessageService implements MessageInterface
{
    public function getMessage(): string
    {
        return "Hello, real service!";
    }
}