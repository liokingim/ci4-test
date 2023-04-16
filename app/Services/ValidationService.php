<?php
namespace App\Services;

class ValidationService
{
    public function validateAge(int $age): void
    {
        if ($age < 0 || $age > 150) {
            throw new \InvalidArgumentException("Invalid age: {$age}");
        }
    }
}