<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * 트랜젝션 샘플 1
 */
class SampleModel1 extends Model
{
    protected $table = 'sample_table1';

    public function insertData(array $data)
    {
        // Insert data
        $this->insert($data);
    }
}