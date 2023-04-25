<?php
namespace App\Models;

use CodeIgniter\Model;

class SampleModel5 extends Model
{
    protected $table = 'sample_table5';

    public function insertData(array $data)
    {
        // Insert data
        $this->insert($data);
    }
}