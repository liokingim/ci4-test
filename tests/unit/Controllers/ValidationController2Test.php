<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use App\Services\ValidationService;
use App\Controllers\ValidationController;
use Mockery;
use PHPUnit\Framework\TestCase;
use CodeIgniter\HTTP\Request;

class ValidationController2Test extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new ValidationController();
        $this->serviceMock = Mockery::mock('Service');
        $this->controller->setService($this->serviceMock);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->controller);
        unset($this->serviceMock);
    }

    public function testMissingAgeParameter()
    {
        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('getJson')->andReturn(null);

        $this->controller->setRequest($requestMock);

        $expectedResponse = ['message' => 'Age parameter is required'];
        $response = $this->controller->index();

        $this->assertSame(400, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getBody(), true));
    }

    public function testInvalidAge()
    {
        $ageData = ['age' => 'invalidAge'];

        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('getJson')->andReturn($ageData);

        $this->serviceMock->shouldReceive('validateAge')
            ->withArgs([$ageData])
            ->andThrow(new \InvalidArgumentException('Invalid age'));

        $this->controller->setRequest($requestMock);

        $expectedResponse = ['message' => 'Invalid age'];
        $response = $this->controller->index();

        $this->assertSame(400, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getBody(), true));
    }

    public function testValidAge()
    {
        $ageData = ['age' => 21];

        $requestMock = Mockery::mock(Request::class)->makePartial();
        $requestMock->shouldReceive('getJson')->andReturn($ageData);

        $this->serviceMock->shouldReceive('validateAge')
            ->withArgs([$ageData])
            ->once();

        $this->controller->setRequest($requestMock);

        $expectedResponse = ['message' => 'Valid age: 21'];
        $response = $this->controller->index();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertEquals($expectedResponse, json_decode($response->getBody(), true));
    }
}