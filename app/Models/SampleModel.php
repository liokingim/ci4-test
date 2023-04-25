<?php
namespace App\Models;

use CodeIgniter\Model;

class SampleModel extends Model
{
    protected $table = 'sample_table';

    public function insertAndUpdate(array $data, int $updateId)
    {
        // Begin transaction
        $this->db->transBegin();

        // Insert new data
        $this->insert($data);

        // Update data with the specified ID
        $this->update($updateId, ['field' => 'new_value']);

        // Check if the transaction was successful
        if ($this->db->transStatus() === FALSE) {
            // Rollback the transaction
            $this->db->transRollback();
            return false;
        } else {
            // Commit the transaction
            $this->db->transCommit();
            return true;
        }
    }

    public function insertData(array $data1, array $data2)
    {
        // Insert first data
        $this->insert($data1);

        // Insert second data
        $this->insert($data2);
    }
}