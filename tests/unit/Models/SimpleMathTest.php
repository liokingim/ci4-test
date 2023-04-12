<?php
namespace Tests\Models;

use App\Models\SimpleMath;
use CodeIgniter\Test\CIUnitTestCase;

class SimpleMathTest extends CIUnitTestCase
{
    protected $simpleMath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->simpleMath = new SimpleMath();
    }

    public function testAdd()
    {
        $result = $this->simpleMath->add(3, 5);
        $this->assertEquals(8, $result);
    }

    public function testSubtract()
    {
        $result = $this->simpleMath->subtract(10, 3);
        $this->assertEquals(7, $result);
    }
}