<?php
namespace App\Services;

use App\Models\SampleModel1;
use App\Models\SampleModel2;

/**
 * 트랜젝션 소스 모델 2개
 */
class SampleService2
{
    protected $sampleModel1;
    protected $sampleModel2;

    public function __construct(SampleModel1 $sampleModel1, SampleModel2 $sampleModel2)
    {
        $this->sampleModel1 = $sampleModel1;
        $this->sampleModel2 = $sampleModel2;
    }

    public function insertDataWithTransaction(array $data1, array $data2)
    {
        // Get the shared database connection
        $db = \Config\Database::connect();

        // Begin transaction
        $db->transBegin();

        // Call the insertData method in SampleModel1 and SampleModel2
        $this->sampleModel1->insertData($data1);
        $this->sampleModel2->insertData($data2);

        // Check if the transaction was successful
        if ($db->transStatus() === FALSE) {
            // Rollback the transaction
            $db->transRollback();
            return false;
        } else {
            // Commit the transaction
            $db->transCommit();
            return true;
        }
    }
}