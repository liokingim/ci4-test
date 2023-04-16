<?php
namespace App\Controllers;

use App\Services\ValidationService;
use CodeIgniter\Controller;

class ValidationController extends Controller
{
    public function index()
    {
        $age = $this->request->getGet('age');

        if ($age === null) {
            return $this->fail("Age parameter is required", 400);
        }

        $validationService = new ValidationService();
        try {
            $validationService->validateAge($age);
        } catch (\InvalidArgumentException $e) {
            return $this->fail($e->getMessage(), 400);
        }

        return $this->respond("Valid age: {$age}");
    }
}