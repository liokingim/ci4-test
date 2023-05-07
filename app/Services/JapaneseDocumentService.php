<?php 
namespace App\Services;

use App\Models\JapaneseDocumentModel;

class JapaneseDocumentService
{
    protected $japaneseDocumentModel;

    public function __construct()
    {
        $this->japaneseDocumentModel = new JapaneseDocumentModel();
    }

    public function searchDocuments($keyword)
    {
        return $this->japaneseDocumentModel->searchByKeyword($keyword);
    }
}