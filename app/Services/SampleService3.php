<?php

namespace App\Services;

use App\Models\SampleModel3;
use App\Models\SampleModel4;

/**
 * 트랜젝션 소스 모델 2개에서 한개의 모델에서 디비 컨넥션을 가져와서 처리
 */
class SampleService3
{
    protected $sampleModel3;
    protected $sampleModel4;

    public function __construct(SampleModel3 $sampleModel3, SampleModel4 $sampleModel4)
    {
        $this->sampleModel3 = $sampleModel3;
        $this->sampleModel4 = $sampleModel4;
    }

    public function insertDataWithTransaction(array $data1, array $data2)
    {
        // Get the database connection from sampleModel3
        $db = $this->sampleModel3->getDbConnection();

        // Set the database connection for sampleModel4
        $this->sampleModel4->setDbConnection($db);

        // Begin transaction
        $db->transBegin();

        // Call the insertData method in sampleModel3 and sampleModel4
        $this->sampleModel3->insertData($data1);
        $this->sampleModel4->insertData($data2);

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
