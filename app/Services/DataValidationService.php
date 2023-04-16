<?php
namespace App\Services;

use App\Exceptions\ValidationException;

class DataValidationService
{
    public function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Invalid email address: {$email}");
        }
    }

    public function validatePhoneNumber(string $phoneNumber): void
    {
        if (!preg_match('/^\+?[1-9]\d{1,14}$/', $phoneNumber)) {
            throw new ValidationException("Invalid phone number: {$phoneNumber}");
        }
    }
}