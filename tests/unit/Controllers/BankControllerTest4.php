<?php

namespace Tests\Controllers;

use CodeIgniter\Test\FeatureResponse;
use CodeIgniter\Test\ControllerTester;

class BankControllerTest extends \CodeIgniter\Test\CIUnitTestCase
{
    use ControllerTester;

    /**
     * @dataProvider validationProvider
     */
    public function testValidation($data, $expected)
    {
        $result = $this->withRequest($this->request)
            ->controller(\App\Controllers\BankController::class)
            ->execute('validate', $data);

        $this->assertEquals($expected, $result->getBody());
    }

    public function validationProvider()
    {
        return [
            [
                [
                    'depositor' => 'Test Depositor',
                    'bank_code' => '1234',
                    'branch_code' => '123',
                    'account_number' => '1234567',
                    'account_type' => '1'
                ],
                'validation passed'
            ],
            [
                [
                    'depositor' => 'Test Depositor',
                    'bank_code' => '12345',  // 5 digits, not 4
                    'branch_code' => '123',
                    'account_number' => '1234567',
                    'account_type' => '1'
                ],
                'validation failed'
            ],
            // ... add more data sets here ...
        ];
    }
}