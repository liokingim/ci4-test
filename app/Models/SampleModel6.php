<?php
namespace App\Models;

use CodeIgniter\Model;

class SampleModel6 extends Model
{
    protected $table = 'sample_table6';

    public function insertData(array $data)
    {
        // Insert data
        $this->insert($data);
    }
}