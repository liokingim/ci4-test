<?php
namespace App\Controllers;

use App\Exceptions\FileProcessingException;
use App\Services\FileService;
use CodeIgniter\Controller;

class FileController extends Controller
{
    public function index()
    {
        $filePath = $this->request->getGet('file');

        if ($filePath === null) {
            return $this->fail("File parameter is required", 400);
        }

        $fileService = new FileService();
        try {
            $content = $fileService->readFile($filePath);
        } catch (FileProcessingException $e) {
            return $this->fail($e->getMessage(), 500);
        }

        return $this->respond($content);
    }
}