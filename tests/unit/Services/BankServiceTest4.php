<?php

use App\Services\BankService;

// 퍼블릭으로 오버라이드하는 방법
class BankServiceForTest extends BankService
{
    public function makeAddress($res1, $res2, $res3, $res4)
    {
        return parent::makeAddress($res1, $res2, $res3, $res4);
    }
}

class BankServiceTest4 extends \CodeIgniter\Test\CIUnitTestCase
{
    public function testMakeAddress()
    {
        $service = new BankServiceForTest();

        $res1 = 'Seoul';
        $res2 = 'Gangnam';
        $res3 = 'Seocho';
        $res4 = '4';

        $expected = 'Seoul Gangnam Seocho 4';  // Replace with the expected result.
        $actual = $service->makeAddress($res1, $res2, $res3, $res4);

        $this->assertEquals($expected, $actual);
    }

    public function testMakeAddress02()
    {
        $genie = new BankService(); // Assuming the makeAddress method belongs to a Genie class

        $res1 = '123 Main St.';
        $res2 = 'Apt 4B';
        $res3 = 'New York';
        $res4 = 'NY, USA';

        $expectedResult = $res1 . $res2 . $res3 . $res4;
        $actualResult = $genie->makeAddress($res1, $res2, $res3, $res4);

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testMakeAddress03()
    {
        $bankService = new BankService();

        $reflector = new ReflectionClass(BankService::class);
        $method = $reflector->getMethod('makeAddress');
        $method->setAccessible(true);

        $res1 = "sample_res1";
        $res2 = "sample_res2";
        $res3 = "sample_res3";
        $res4 = "sample_res4";

        $result = $method->invokeArgs($bankService, [$res1, $res2, $res3, $res4]);

        // assert your expectations here.
    }

    public function testProcessBankData()
    {
        $mockBankService = $this->createMock(BankService::class);

        // processBankData 메서드의 반환 값을 정의합니다.
        $mockBankService->method('processBankData')
            ->willReturn('Expected Result');

        // processBankData 메서드를 실행하고 결과를 확인합니다.
        $result = $mockBankService->processBankData('res1', 'res2', 'res3', 'res4');
        $this->assertEquals('Expected Result', $result);
    }

    public function testDeposit()
    {
        $mockBankService = $this->createMock(
            \App\Services\BankService::class
        );

        // 설정한 return 값이 반환되도록 deposit 메서드를 설정
        $mockBankService->method('deposit')->willReturn(true);

        $this->assertTrue($mockBankService->deposit());
    }
}
