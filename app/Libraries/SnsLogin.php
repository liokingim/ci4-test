<?php

namespace App\Libraries;

use App\Enums\SnsProvider;

/**
 *
 */
class SnsLogin
{
    /**
     *
     */
    public function login(SnsProvider $provider, $accessToken, $accessTokenSecret = null)
    {
        switch ($provider) {
            case SnsProvider::Facebook:
                return $this->loginWithFacebook($accessToken);
            case SnsProvider::Google:
                return $this->loginWithGoogle($accessToken);
            case SnsProvider::Twitter:
                return $this->loginWithTwitter($accessToken, $accessTokenSecret);
            default:
                throw new \InvalidArgumentException('Invalid SNS provider.');
        }
    }

    // 기존의 SNS 로그인 메서드들은 여기에 남겨둡니다.
    public function loginWithFacebook($accessToken)
    {
        // Facebook 인증 및 사용자 정보 가져오기
        // https://developers.facebook.com/docs/facebook-login
        // 여기에 Facebook API를 사용하여 사용자 인증 및 정보를 가져오는 코드를 추가합니다.
        // 이 예제에서는 간단한 배열을 반환합니다.
        return [
            'provider' => 'facebook',
            'id' => '1234567890',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ];
    }

    public function loginWithGoogle($accessToken)
    {
        // Google 인증 및 사용자 정보 가져오기
        // https://developers.google.com/identity
        // 여기에 Google API를 사용하여 사용자 인증 및 정보를 가져오는 코드를 추가합니다.
        // 이 예제에서는 간단한 배열을 반환합니다.
        return [
            'provider' => 'google',
            'id' => '1234567890',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ];
    }

    public function loginWithTwitter($accessToken, $accessTokenSecret)
    {
        // Twitter 인증 및 사용자 정보 가져오기
        // https://developer.twitter.com/en/docs/authentication/oauth-1-0a
        // 여기에 Twitter API를 사용하여 사용자 인증 및 정보를 가져오는 코드를 추가합니다.
        // 이 예제에서는 간단한 배열을 반환합니다.
        return [
            'provider' => 'twitter',
            'id' => '1234567890',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ];
    }
}