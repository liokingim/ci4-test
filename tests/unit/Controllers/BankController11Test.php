<?php

namespace App\Controllers;

use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

class ExampleControllerFeatureTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    public function setUp(): void
    {
        // Extra code to run before each test
    }

    public function tearDown(): void
    {
        // Extra code to run after each test
    }

    public function testIndexReturnsCorrectStatusCode()
    {
        // Call the controller method
        $result = $this->get('/example/index');

        // Check that the response has a 200 status code
        $result->assertStatus(200);
    }

    public function testIndexReturnsErrorMessageForInvalidData()
    {
        // Prepare the data that will fail validation
        $data = ['field1' => '', 'field2' => ''];

        // Call the controller method
        $result = $this->withBody($data)->post('/example/index');

        // Check that the response has a 400 status code
        $result->assertStatus(400);

        // Check that the response includes an error message
        $result->assertSee('The field1 field is required.');
        $result->assertSee('The field2 field is required.');
    }

    public function testIndexReturnsErrorMessageForInvalidGetParameters()
    {
        // Prepare the data that will fail validation
        $data = ['field1' => '', 'field2' => ''];

        // Convert the data array to a query string
        $queryString = http_build_query($data);

        // Call the controller method with the query string
        $result = $this->get('/example/index?' . $queryString);

        // Check that the response has a 400 status code
        $result->assertStatus(400);

        // Check that the response includes an error message
        $result->assertSee('The field1 field is required.');
        $result->assertSee('The field2 field is required.');
    }

    public function testShowMethodFetchesFromDatabaseAndReturnsCorrectResponse()
    {
        // Prepare the data to be saved
        $data = ['field1' => 'value1', 'field2' => 'value2'];

        // Save the data to the database
        $this->getPrivateProperty($this->controller, 'model')
            ->insert($data);

        // Get the ID of the last inserted record
        $insertedId = $this->getPrivateProperty($this->controller, 'model')
            ->getInsertID();

        // Call the controller method
        $result = $this->get('/example/show/' . $insertedId);

        // Check that the response has a 200 status code
        $result->assertStatus(200);

        // Check that the response includes the correct data
        $result->assertSee('value1');
        $result->assertSee('value2');
    }

    public function testShowMethodFetchesFromDatabaseAndReturnsCorrectResponse2()
    {
        // Prepare the data to be saved
        $data = ['field1' => 'value1', 'field2' => 'value2'];

        // Save the data to the database
        $this->getPrivateProperty($this->controller, 'model')
            ->insert($data);

        // Get the ID of the last inserted record
        $insertedId = $this->getPrivateProperty($this->controller, 'model')
            ->getInsertID();

        // Call the controller method
        $result = $this->get('/example/show/' . $insertedId);

        // Check that the response has a 200 status code
        $result->assertStatus(200);

        // Check that the response includes the correct data
        $result->assertSee('value1');
        $result->assertSee('value2');
    }

    public function testCreateMethodSavesToDatabaseAndReturnsCorrectResponse()
    {
        // Prepare the data to be saved
        $data = ['field1' => 'value1', 'field2' => 'value2'];

        // Call the controller method
        $result = $this->withBody($data)->post('/example/create');

        // Check that the response has a 201 status code
        $result->assertStatus(201);

        // Check that the response includes a success message
        $result->assertSee('Record created successfully.');

        // Fetch the saved record from the database
        $savedRecord = $this->getPrivateProperty($this->controller, 'model')
            ->where($data)
            ->first();

        // Check that the saved record matches the data
        $this->assertEquals($data['field1'], $savedRecord['field1']);
        $this->assertEquals($data['field2'], $savedRecord['field2']);
    }
}
