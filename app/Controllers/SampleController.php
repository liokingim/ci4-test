<?php
namespace App\Controllers;

use App\Services\SampleService;
use CodeIgniter\Controller;

class SampleController extends Controller
{
    public function index()
    {
        $sampleService = new SampleService();
        try {
            $sampleService->doSomething();
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 500);
        }

        return $this->respond("Success");
    }
}