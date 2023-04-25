<?php namespace App\Services;

use App\Models\SampleModel5;
use App\Models\SampleModel6;
use App\Models\SampleModel7;

/**
 * 트랜젝션 소스 모델 3개에서 한개의 모델에서 디비 컨넥션을 가져와서 처리
 */
class SampleService4
{
    protected $sampleModel5;
    protected $sampleModel6;
    protected $sampleModel7;

    public function __construct(
        SampleModel5 $sampleModel5,
        SampleModel6 $sampleModel6,
        SampleModel7 $sampleModel7
        )
    {
        $this->sampleModel5 = $sampleModel5;
        $this->sampleModel6 = $sampleModel6;
        $this->sampleModel7 = $sampleModel7;
    }

    public function insertDataWithTransaction(array $data1, array $data2, array $data3)
    {
        // Get the shared database connection
        $db = \Config\Database::connect();

        // Assign the shared database connection to all models
        $this->sampleModel5->setDatabase($db);
        $this->sampleModel6->setDatabase($db);
        $this->sampleModel7->setDatabase($db);

        // Begin transaction
        $db->transBegin();

        // Call the insertData method in sampleModel5, sampleModel6, and sampleModel7
        $this->sampleModel5->insertData($data1);
        $this->sampleModel6->insertData($data2);
        $this->sampleModel7->insertData($data3);

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