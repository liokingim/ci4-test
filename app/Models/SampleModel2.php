<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * 트랜젝션 샘플 2
 */
class SampleModel2 extends Model
{
    protected $table = 'sample_table2';

    public function insertData(array $data)
    {
        // Insert data
        $this->insert($data);
    }
}