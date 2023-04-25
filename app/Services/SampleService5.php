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

    public function __construct()
    {
        // Get the shared database connection
        $db = \Config\Database::connect();

        // Create instances of the models with the shared database connection
        $this->sampleModel5 = new SampleModel5($db);
        $this->sampleModel6 = new SampleModel6($db);
        $this->sampleModel7 = new SampleModel7($db);
    }

    public function insertDataWithTransaction2(array $data1, array $data2, array $data3)
    {
        // Begin transaction
        $this->sampleModel5->transBegin();

        // Call the insertData method in sampleModel5, sampleModel6, and sampleModel7
        $this->sampleModel5->insertData($data1);
        $this->sampleModel6->insertData($data2);
        $this->sampleModel7->insertData($data3);

        // Check if the transaction was successful
        if ($this->sampleModel5->transStatus() === FALSE) {
            // Rollback the transaction
            $this->sampleModel5->transRollback();
            return false;
        } else {
            // Commit the transaction
            $this->sampleModel5->transCommit();
            return true;
        }
    }
}