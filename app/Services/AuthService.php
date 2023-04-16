<?php
namespace App\Services;

use App\Libraries\Auth\OAuth2Provider;
use App\Libraries\Session\SessionWriter;

class AuthService
{
    protected $sessionWriter;
    protected $user;

    public function __construct(SessionWriter $sessionWriter)
    {
        $this->sessionWriter = $sessionWriter;
    }

    // public function authenticate(OAuth2Provider $provider, string $code): bool
    // {
    //     if ($provider->authenticate($code)) {
    //         $userInfo = $provider->getUserInfo();
    //         $this->sessionWriter->setUser($userInfo);
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function authenticate(string $username, string $password): void
    {
        // 여기서는 간단하게 예제를 위해 하드코딩으로 작성했습니다.
        // 실제로는 데이터베이스에서 사용자 정보를 조회하여 인증 과정을 수행해야 합니다.
        if ($username === 'admin' && $password === 'password') {
            $this->user = [
                'id' => 1,
                'username' => 'admin',
                'role' => 'admin',
            ];
        } else {
            throw new AuthenticationException("Invalid username or password");
        }
    }

    public function getUser()
    {
        return $this->user;
    }

    public function logout()
    {
        $this->sessionWriter->removeUser();
    }
}