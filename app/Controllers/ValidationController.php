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

    public function __construct() {
        $this->service = new ValidationService();
        $this->request = \Config\Services::request();
    }

    /**
     *
     */
    public function index()
    {
        $age = $this->request->getGet('age');

        if ($age === null) {
            return $this->fail("Age parameter is required", 400);
        }

        try {
            $this->service->validateAge($age);
        } catch (\InvalidArgumentException $e) {
            return $this->fail($e->getMessage(), 400);
        }

        return $this->respond("Valid age: {$age}");
    }

    public function setService($service)
    {
        $this->service = $service;
    }
}