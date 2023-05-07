<?php 
namespace App\Controllers;

use App\Services\JapaneseDocumentService;

class JapaneseDocumentController extends BaseController
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

        return view('search_results', ['results' => $results]);
    }
}