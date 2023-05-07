<?php 
namespace App\Controllers;

use App\Services\JapaneseDocumentService;
use CodeIgniter\RESTful\ResourceController;

class JapaneseDocumentApiController extends ResourceController
{
    protected $japaneseDocumentService;

    public function __construct()
    {
        $this->japaneseDocumentService = new JapaneseDocumentService();
    }

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $results = $this->japaneseDocumentService->searchDocuments($keyword);

        return $this->respond($results);
    }
}