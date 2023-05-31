<?php

namespace App\Controllers;

use App\Services\ValidationService;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Request;

class ValidationController extends Controller
{
    use ResponseTrait;

    protected $request;
    private $service;

    public function __construct()
    {
        $this->service = new ValidationService();
        $this->request = \Config\Services::request();
    }

    /**
     *
     */
    public function index()
    {
        $age = "";

        if (isset($this->request->getPost()['json']['age'])) {
            $age = $this->request->getPost()['json']['age'];
        }

        if (!$age or $age === null) {
            return $this->respond("Age parameter is required", 400);
        }

        try {
            $this->service->validateAge($age);
        } catch (\InvalidArgumentException $e) {
            return $this->respond('Age must be a positive integer', 400);
        }

        return $this->respond("Valid age: {$age}", 200);
    }

    public function setService($service)
    {
        $this->service = $service;
    }
}
