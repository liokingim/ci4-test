<?php
namespace App\Services\SNSAuth;

/**
 * FacebookAuth용 클래스
 */
class FacebookAuthProvider implements AuthProviderInterface
{
    public function authenticate(string $code): array
    {
        // Facebook API를 사용하여 사용자 정보를 가져옵니다.
        // 실제 구현에서는 Facebook SDK 또는 HTTP 요청을 사용하여 인증 코드를 전달하고 사용자 정보를 가져옵니다.

        // 예제 코드에서는 더미 사용자 정보를 반환합니다.
        return [
            'id' => '12345',
            'email' => 'user@example.com'
        ];
    }

    public function getAuthUrl(): string
    {
        // Facebook 인증 URL을 반환합니다.
        // 실제 구현에서는 Facebook SDK 또는 앱 설정에 따른 인증 URL을 생성합니다.
        return 'https://www.facebook.com/v11.0/dialog/oauth';
    }
}