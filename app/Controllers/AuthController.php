<?php

namespace App\Controllers;

use App\Enums\SnsProvider;
use App\Libraries\SnsLogin;

/**
 *
 */
class AuthController extends BaseController
{
    /**
     *
     */
    public function loginWithSns(SnsProvider $provider)
    {
        $snsLogin = new SnsLogin();
        $accessToken = 'your_access_token'; // 실제 구현에서는 사용자로부터 액세스 토큰을 가져옵니다.
        $accessTokenSecret = 'your_access_token_secret'; // 실제 구현에서는 사용자로부터 액세스 토큰 비밀번호를 가져옵니다 (Twitter 경우에만 필요).

        $user = $snsLogin->login($provider, $accessToken, $accessTokenSecret);

        // 여기에 사용자 정보를 처리하는 로직을 추가합니다.
    }

    /**
     *
     */
    public function loginWithFacebook()
    {
        $snsLogin = new SnsLogin();
        $accessToken = 'your_facebook_access_token'; // 실제 구현에서는 사용자로부터 액세스 토큰을 가져옵니다.
        $user = $snsLogin->loginWithFacebook($accessToken);

        // 여기에 사용자 정보를 처리하는 로직을 추가합니다.
    }

    /**
     *
     */
    public function loginWithGoogle()
    {
        $snsLogin = new SnsLogin();
        $accessToken = 'your_google_access_token'; // 실제 구현에서는 사용자로부터 액세스 토큰을 가져옵니다.
        $user = $snsLogin->loginWithGoogle($accessToken);

        // 여기에 사용자 정보를 처리하는 로직을 추가합니다.
    }

    /**
     *
     */
    public function loginWithTwitter()
    {
        $snsLogin = new SnsLogin();
        $accessToken = 'your_twitter_access_token'; // 실제 구현에서는 사용자로부터 액세스 토큰을 가져옵니다.
        $accessTokenSecret = 'your_twitter_access_token_secret'; // 실제 구현에서는 사용자로부터 액세스 토큰 비밀번호를 가져옵니다.
        $user = $snsLogin->loginWithTwitter($accessToken, $accessTokenSecret);

        // 여기에 사용자 정보를 처리하는 로직을 추가합니다.
    }
}