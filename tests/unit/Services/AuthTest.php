<?php
namespace Tests\Services;

use App\Services\EmailService;
use CodeIgniter\Email\Email;
use CodeIgniter\Test\CIUnitTestCase;

class AuthTest extends CIUnitTestCase
{
    public function testAuthenticateWithGoogle(): void
    {
        // create mock objects for dependencies
        $authProviderMock = $this->createMock(GoogleAuthProvider::class);
        $internalCallerMock = $this->createMock(InternalCallerService::class);

        // set up expectations for mock object methods
        $authProviderMock
            ->expects($this->once())
            ->method('authenticate')
            ->with($this->equalTo($code))
            ->willReturn($userInfo);

        $internalCallerMock
            ->expects($this->once())
            ->method('authenticateUserWithSNS')
            ->with($this->equalTo($code))
            ->willReturn($userInfo);

        // create instance of class under test and inject mock dependencies
        $auth = new Auth();
        $auth->setAuthProvider($authProviderMock);
        $auth->setInternalCallerService($internalCallerMock);

        // call method under test
        $result = $auth->authenticateWithGoogle($code);

        // assert result
        $this->assertEquals($userInfo, $result);
    }
}