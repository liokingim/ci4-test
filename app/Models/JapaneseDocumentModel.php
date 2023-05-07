<?php 
namespace App\Models;

use CodeIgniter\Model;

class JapaneseDocumentModel extends Model
{
    protected $table = 'japanese_documents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content'];

    public function searchByKeyword($keyword)
    {
        return $this->like('title', $keyword)
            ->orLike('content', $keyword)
            ->findAll();
    }
}
