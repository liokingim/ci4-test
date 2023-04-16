<?php
namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Services\DataValidationService;
use CodeIgniter\Controller;

class DataValidationController extends Controller
{
    public function index()
    {
        $email = $this->request->getGet('email');
        $phoneNumber = $this->request->getGet('phone');

        if ($email === null || $phoneNumber === null) {
            return $this->fail("Email and phone parameters are required", 400);
        }

        $dataValidationService = new DataValidationService();
        try {
            $dataValidationService->validateEmail($email);
            $dataValidationService->validatePhoneNumber($phoneNumber);
        } catch (ValidationException $e) {
            return $this->fail($e->getMessage(), 400);
        }

        return $this->respond("Valid email and phone number");
    }
}