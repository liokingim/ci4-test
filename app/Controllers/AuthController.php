<?php

namespace App\Controllers;

use App\Enums\SnsProvider;
use App\Libraries\Auth\FacebookAuthProvider;
use App\Libraries\Auth\GoogleAuthProvider;
use App\Libraries\Session\SessionWriter;
use App\Libraries\SnsLogin;
use App\Services\AuthService;

/**
 *
 */
class AuthController extends BaseController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService(new SessionWriter(session()));
    }

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


    public function facebook() {
        // $config = [
        //     'app_id' => 'your_facebook_app_id',
        //     'app_secret' => 'your_facebook_app_secret',
        //     'graph_version' => 'v12.0',
        //     'redirect_url' => site_url('auth/facebook_callback'),
        //     'permissions' => ['email']
        // ];

        $config = config('Auth')->facebook;
        $config['redirect_url'] = site_url($config['redirect_url']);

        $provider = new FacebookAuthProvider($config);
        return redirect()->to($provider->getLoginUrl());
    }

    public function facebookCallback() {
        // $config = [
        //     'app_id' => 'your_facebook_app_id',
        //     'app_secret' => 'your_facebook_app_secret',
        //     'graph_version' => 'v12.0',
        //     'redirect_url' => site_url('auth/facebook_callback'),
        //     'permissions' => ['email']
        // ];

        $config = config('Auth')->facebook;
        $config['redirect_url'] = site_url($config['redirect_url']);

        $provider = new FacebookAuthProvider($config);

        if ($this->authService->authenticate($provider, $this->request->getGet('code'))) {
        // if ($provider->authenticate($this->request->getGet('code'))) {
            $userInfo = $provider->getUserInfo();

            // 로그인 성공, 세션에 사용자 정보 저장
            // $session = session();
            // $session->set('user', $userInfo);

            $sessionWriter = new SessionWriter(session());
            $sessionWriter->setUser($userInfo);

            // 로그인 후 원하는 페이지로 리다이렉트
            return redirect()->to('/');
        } else {
            // 로그인 실패, 에러 처리
            return redirect()->to('/login')->with('error', 'Facebook 로그인 실패');
        }
    }

    public function google() {
        // $config = [
        //     'client_id' => 'your_google_client_id',
        //     'client_secret' => 'your_google_client_secret',
        //     'redirect_url' => site_url('auth/google_callback'),
        //     'scopes' => [\Google\Service\Oauth2::USERINFO_EMAIL, \Google\Service\Oauth2::USERINFO_PROFILE]
        // ];

        $config = config('Auth')->google;
        $config['redirect_url'] = site_url($config['redirect_url']);

        $provider = new GoogleAuthProvider($config);
        return redirect()->to($provider->getLoginUrl());
    }

    public function googleCallback() {
        // $config = [
        //     'client_id' => 'your_google_client_id',
        //     'client_secret' => 'your_google_client_secret',
        //     'redirect_url' => site_url('auth/google_callback'),
        //     'scopes' => [\Google\Service\Oauth2::USERINFO_EMAIL,
        //                 \Google\Service\Oauth2::USERINFO_PROFILE]
        // ];

        $config = config('Auth')->google;
        $config['redirect_url'] = site_url($config['redirect_url']);

        $provider = new GoogleAuthProvider($config);

        if ($this->authService->authenticate($provider, $this->request->getGet('code'))) {
        // if ($provider->authenticate($this->request->getGet('code'))) {
            $userInfo = $provider->getUserInfo();

            // 로그인 성공, 세션에 사용자 정보 저장
            // $session = session();
            // $session->set('user', $userInfo);

            $sessionWriter = new SessionWriter(session());
            $sessionWriter->setUser($userInfo);

            // 로그인 후 원하는 페이지로 리다이렉트
            return redirect()->to('/');
        } else {
            // 로그인 실패, 에러 처리
            return redirect()->to('/login')->with('error', 'Google 로그인 실패');
        }
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $authService = new AuthService();
        try {
            $authService->authenticate($username, $password);
            $user = $authService->getUser();
            // 로그인 성공 처리 및 세션 등록
        } catch (AuthenticationException $e) {
            return $this->fail($e->getMessage(), 401);
        }

        return $this->respond("Logged in: {$user['username']}");
    }

    // 로그아웃 처리
    public function logout() {
        $sessionWriter = new SessionWriter(session());
        $sessionWriter->removeUser();

        return redirect()->to('/login');
    }
}