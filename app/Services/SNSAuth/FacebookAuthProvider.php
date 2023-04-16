<?php
namespace App\Services\SNSAuth;

/**
 * FacebookAuth용 클래스
 */
class FacebookAuthProvider implements AuthProviderInterface
{
    public function getAuthUrl(): string
    {
        // Facebook 인증 URL 생성 및 반환
    }

    public function authenticate(string $code): array
    {
        // Facebook 인증 코드를 사용하여 사용자 정보를 가져오고 반환
    }
}