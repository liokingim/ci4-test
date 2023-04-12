<?php
namespace App\Services;

class GreetingService
{
    public function greet(string $name): string
    {
        return "Hello, {$name}!";
    }
}