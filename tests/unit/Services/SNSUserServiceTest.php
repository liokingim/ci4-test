<?php
namespace Tests\Services;

use CodeIgniter\Test\CIUnitTestCase;
use App\Services\SNSAuth\AuthProviderInterface;
use App\Services\SNSUserService;

class SNSUserServiceTest extends CIUnitTestCase
{
    public function testAuthenticateUserWithSNS()
    {
        // Stub 인스턴스 생성
        $authProviderStub = $this->createStub(AuthProviderInterface::class);

        // Stub 메소드의 반환값 설정
        $authProviderStub->method('authenticate')
            ->willReturn([
                'id' => '12345',
                'email' => 'test@example.com'
            ]);

        // UserService에 Stub을 주입
        $userService = new SNSUserService($authProviderStub);

        // 테스트 대상 메소드 호출 및 결과 검증
        $result = $userService->authenticateUserWithSNS('test_code');
        $this->assertEquals('12345', $result['id']);
        $this->assertEquals('test@example.com', $result['email']);
    }

    public function testGetAuthUrl()
    {
        // Mock 인스턴스 생성
        $authProviderMock = $this->createMock(AuthProviderInterface::class);

        // Mock 메소드의 반환값 설정 및 호출 횟수 검증
        $authProviderMock->expects($this->once())
            ->method('getAuthUrl')
            ->willReturn('https://example.com/auth-url');

        // UserService에 Mock을 주입
        $userService = new SNSUserService($authProviderMock);

        // 테스트 대상 메소드 호출 및 결과 검증
        $authUrl = $userService->getAuthUrl();
        $this->assertEquals('https://example.com/auth-url', $authUrl);
    }
}
