<?php
namespace App\Services;

use App\Services\SNSAuth\AuthProviderInterface;

/**
 * SNS 인증 기능을 분리한 클래스
 */
class InternalCallerService
{
    private $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function authenticateUserWithSNS(string $code): array
    {
        return $this->authProvider->authenticate($code);
    }

    public function getAuthUrl(): string
    {
        return $this->authProvider->getAuthUrl();
    }
}