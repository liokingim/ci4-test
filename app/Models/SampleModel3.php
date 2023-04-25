<?php
namespace App\Models;

use CodeIgniter\Model;

class SampleModel3 extends Model
{
    protected $table = 'sample_table1';

    public function insertData(array $data)
    {
        // Insert data
        $this->insert($data);
    }

    public function getDbConnection()
    {
        // Return the database connection
        return $this->db;
    }
}