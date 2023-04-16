<?php
namespace App\Controllers;

use App\Exceptions\DatabaseException;
use App\Services\DatabaseErrorService;
use CodeIgniter\Controller;

class DatabaseErrorController extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $databaseErrorService = new DatabaseErrorService($db);
        try {
            $databaseErrorService->doSomething();
        } catch (DatabaseException $e) {
            return $this->fail($e->getMessage(), 500);
        }

        return $this->respond("Success");
    }
}