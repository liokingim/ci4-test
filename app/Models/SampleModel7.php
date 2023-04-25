<?php
namespace App\Models;

use CodeIgniter\Model;

class SampleModel7 extends Model
{
    protected $table = 'sample_table7';

    public function insertData(array $data)
    {
        // Insert data
        $this->insert($data);
    }
}