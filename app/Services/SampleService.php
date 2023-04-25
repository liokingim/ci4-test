<?php
namespace App\Services;

use App\Models\SampleModel;

class SampleService
{
    protected $sampleModel;

    public function __construct(SampleModel $sampleModel)
    {
        $this->sampleModel = $sampleModel;
    }

    public function doSomething(): void
    {
        throw new \Exception("Sample exception");
    }

    // 트랜젝션 소스 모델 1개
    public function insertDataWithTransaction(array $data1, array $data2)
    {
        // Begin transaction
        $this->sampleModel->db->transBegin();

        // Call the insertData method in SampleModel
        $this->sampleModel->insertData($data1, $data2);

        // Check if the transaction was successful
        if ($this->sampleModel->db->transStatus() === FALSE) {
            // Rollback the transaction
            $this->sampleModel->db->transRollback();
            return false;
        } else {
            // Commit the transaction
            $this->sampleModel->db->transCommit();
            return true;
        }
    }



}