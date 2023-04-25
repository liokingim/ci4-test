<?php
namespace App\Models;

use CodeIgniter\Model;

class SampleModel4 extends Model
{
    protected $table = 'sample_table2';

    public function insertData(array $data)
    {
        // Insert data
        $this->insert($data);
    }

    public function setDbConnection($db)
    {
        // Set the database connection
        $this->db = $db;
    }
}