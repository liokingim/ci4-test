<?php
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class ExampleApiController extends ResourceController
{
    public function index()
    {
        return $this->respond([
            'status' => 'success',
            'message' => 'Hello, API!'
        ]);
    }
}