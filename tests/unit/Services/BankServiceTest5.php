<?php

use ReflectionClass;
use ReflectionException;
use App\Services\BankService;

class BankServiceTest5 extends \CodeIgniter\Test\CIUnitTestCase
{

    private $bankService;
    private $makeAddressReflection;

    protected function setUp(): void
    {
        $this->bankService = new BankService();

        try {
            // ReflectionClass 객체를 만듭니다.
            $reflection = new ReflectionClass(BankService::class);

            // makeAddress 메서드에 대한 ReflectionMethod 객체를 가져옵니다.
            $this->makeAddressReflection = $reflection->getMethod('makeAddress');

            // 메서드를 임시로 public으로 만듭니다.
            $this->makeAddressReflection->setAccessible(true);
        } catch (ReflectionException $e) {
            $this->fail('Failed to create ReflectionClass: ' . $e->getMessage());
        }
    }

    public function testMakeAddress()
    {
        // 테스트 케이스를 설정합니다.
        $res1 = '서울';
        $res2 = '강남구';
        $res3 = '역삼동';
        $res4 = '123-456';

        // 예상되는 결과를 설정합니다.
        $expected = "서울 강남구 역삼동 123-456";

        try {
            // makeAddress 메서드를 호출하고 결과를 얻습니다.
            $actual = $this->makeAddressReflection->invoke($this->bankService, $res1, $res2, $res3, $res4);
        } catch (ReflectionException $e) {
            $this->fail('Failed to invoke makeAddress method: ' . $e->getMessage());
        }

        // 결과를 검증합니다.
        $this->assertSame($expected, $actual);
    }
}
