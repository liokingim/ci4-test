<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use App\Services\ValidationService;
use App\Controllers\ValidationController;
use PHPUnit\Framework\TestCase;
use CodeIgniter\HTTP\Request;

class ValidationControllerTest extends TestCase
{
    use ControllerTestTrait;

    /**
     *
     */
    // public function testIndex()
    // {
    //     // Test with no age parameter
    //     $response = $this->get('/validation/index');
    //     $response->assertStatus(400);
    //     $response->assertSee("Age parameter is required");

    //     // Test with invalid age parameter
    //     $response = $this->get('/validation/index?age=-5');
    //     $response->assertStatus(400);
    //     $response->assertSee("Invalid age");

    //     // Test with valid age parameter
    //     $response = $this->get('/validation/index?age=25');
    //     $response->assertStatus(200);
    //     $response->assertSee("Valid age: 25");
    // }

    // public function testIndex2()
    // {
    //     // Mock ValidationService
    //     $mockValidationService = $this->getMockBuilder(ValidationService::class)
    //         ->setMethods(['validateAge'])
    //         ->getMock();

    //     // Test with invalid age parameter
    //     $mockValidationService->method('validateAge')
    //         ->willThrowException(new \InvalidArgumentException("Invalid age"));

    //     $controller = new ValidationController();
    //     $controller->setResponse($this->getMockBuilder(ResponseInterface::class)->getMock());

    //     $controller->setValidationService($mockValidationService);

    //     $response = $this->get('/validation/index?age=-5');
    //     $response->assertStatus(400);
    //     $response->assertSee("Invalid age");
    // }


    public function testIndexValidAge()
    {
        // Arrange
        $controller = new ValidationController();
        $mockService = $this->getMockBuilder(ValidationService::class)
                            ->disableOriginalConstructor()
                            ->getMock();

        // The service should not throw any exceptions for a valid age
        $mockService->expects($this->once())
                    ->method('validateAge')
                    ->with($this->equalTo(18));

        $controller->setService($mockService);

        // create a fake request
        $_GET = ['age' => 18];

        // Act
        $response = $controller->index();

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Valid age: 18", $response->getBody());
    }

    public function testIndexMissingAge()
    {
        // Arrange
        $controller = new ValidationController();
        $mockService = $this->getMockBuilder(ValidationService::class)
                            ->disableOriginalConstructor()
                            ->getMock();

        $controller->setService($mockService);

        // create a fake request with no age parameter
        $_GET = [];

        // Act
        $response = $controller->index();

        // Assert
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("Age parameter is required", $response->getBody());
    }

    public function testIndexInvalidAge()
    {
        // Arrange
        $controller = new ValidationController();
        $mockService = $this->getMockBuilder(ValidationService::class)
                            ->disableOriginalConstructor()
                            ->getMock();
        $mockService->method('validateAge')
                    ->willThrowException(new InvalidArgumentException());

        $controller->setService($mockService);

        // create a fake request with an invalid age parameter
        $_GET = ['age' => -5];

        // Act
        $response = $controller->index();

        // Assert
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertMatchesRegularExpression('/Invalid age/i', $response->getBody());
    }

    public function testIndexMethodFailsWhenAgeParameterIsMissing()
    {
        $controller = new ValidationController();

        // Mock the request object to return null for the age parameter
        $requestMock = $this->getMockBuilder(Request::class)
            ->getMock();
        $requestMock->method('getGet')
            ->with('age')
            ->willReturn(null);

        // Set the mock request object on the controller
        $controller->setRequest($requestMock);

        // Call the index method and verify that it fails with the expected error message and status code
        $response = $controller->index();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("Age parameter is required", $response->getBody());
    }

    public function testIndexMethodFailsWhenAgeParameterIsInvalid()
    {
        $controller = new ValidationController();

        // Mock the request object to return an invalid age parameter
        $requestMock = $this->getMockBuilder(Request::class)
            ->getMock();
        $requestMock->method('getGet')
            ->with('age')
            ->willReturn('abc');

        // Set the mock request object on the controller
        $controller->setRequest($requestMock);

        // Call the index method and verify that it fails with the expected error message and status code
        $response = $controller->index();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("Invalid age value: abc", $response->getBody());
    }

    public function testIndexMethodSucceedsWhenAgeParameterIsValid()
    {
        $controller = new ValidationController();

        // Mock the request object to return a valid age parameter
        $requestMock = $this->getMockBuilder(Request::class)
            ->getMock();
        $requestMock->method('getGet')
            ->with('age')
            ->willReturn('25');

        // Set the mock request object on the controller
        $controller->setRequest($requestMock);

        // Call the index method and verify that it succeeds with the expected response message
        $response = $controller->index();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Valid age: 25", $response->getBody());
    }
}