<?php
namespace Tests\Services;

use App\Models\UserModel;
use App\Services\UserService;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Model;

class UserServiceTest extends CIUnitTestCase
{
    public function testGetUserByEmail()
    {
        // Sample user data
        $sampleUser = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ];

        // 1-----------------
        // // Create a mock object for the UserModel
        // $mockUserModel = $this->createMock(UserModel::class);

        // // Configure the stub to return a specific value
        // $mockUserModel->method('where')
        //               ->with($this->equalTo('email'), $this->equalTo($sampleUser['email']))
        //               ->willReturnSelf();

        // $mockUserModel->method('first')
        //               ->willReturn($sampleUser);

        // // Inject the mock object into the UserService
        // $userService = new UserService($mockUserModel);

        // // Call the getUserByEmail method and check the returned data
        // $user = $userService->getUserByEmail($sampleUser['email']);
        // $this->assertEquals($sampleUser, $user);

        // 2---------
        // Create a mock object for the UserModel, extending the CodeIgniter\Model class
        // $mockUserModel = $this->getMockBuilder(UserModel::class)
        //                       ->onlyMethods(['where', 'first'])
        //                       ->getMock();

        // // Configure the stub to return a specific value
        // $mockUserModel->method('where')
        //               ->with($this->equalTo('email'), $this->equalTo($sampleUser['email']))
        //               ->willReturnSelf();

        // $mockUserModel->method('first')
        //               ->willReturn($sampleUser);

        // // Inject the mock object into the UserService
        // $userService = new UserService($mockUserModel);

        // // Call the getUserByEmail method and check the returned data
        // $user = $userService->getUserByEmail($sampleUser['email']);
        // $this->assertEquals($sampleUser, $user);

        // 3 ----------------
        // Create a mock object for the UserModel
        // $mockUserModel = $this->getMockBuilder(UserModel::class)
        //                       ->addMethods(['where', 'first'])
        //                       ->getMock();

        // // Configure the stub to return a specific value
        // $mockUserModel->method('where')
        //               ->with($this->equalTo('email'), $this->equalTo($sampleUser['email']))
        //               ->willReturnSelf();

        // $mockUserModel->method('first')
        //               ->willReturn($sampleUser);

        // // Inject the mock object into the UserService
        // $userService = new UserService($mockUserModel);

        // // Call the getUserByEmail method and check the returned data
        // $user = $userService->getUserByEmail($sampleUser['email']);
        // $this->assertEquals($sampleUser, $user);

        // 4 ----
        // Create a mock object for the UserModel, extending the CodeIgniter\Model class
        // $mockUserModel = $this->getMockBuilder(Model::class)
        //                       ->onlyMethods(['where', 'first'])
        //                       ->getMockForAbstractClass();

        // // Configure the stub to return a specific value
        // $mockUserModel->method('where')
        //               ->with($this->equalTo('email'), $this->equalTo($sampleUser['email']))
        //               ->willReturnSelf();

        // $mockUserModel->method('first')
        //               ->willReturn($sampleUser);

        // // Inject the mock object into the UserService
        // $userService = new UserService($mockUserModel);

        // // Call the getUserByEmail method and check the returned data
        // $user = $userService->getUserByEmail($sampleUser['email']);
        // $this->assertEquals($sampleUser, $user);

        // 5 ------------
        // Create a mock object for the UserModel by extending the UserModel class
        $mockUserModel = $this->getMockBuilder(UserModel::class)
                              ->addMethods(['where'])
                              ->getMock();

        // Configure the stub to return a specific value
        $mockUserModel->method('where')
                      ->with($this->equalTo('email'), $this->equalTo($sampleUser['email']))
                      ->willReturnSelf();

        $mockUserModel->method('where')
                      ->willReturn($sampleUser);

        // Inject the mock object into the UserService
        $userService = new UserService($mockUserModel);

        // Call the getUserByEmail method and check the returned data
        $user = $userService->getUserByEmail($sampleUser['email']);

        $this->assertEquals($sampleUser, $user);
    }
}