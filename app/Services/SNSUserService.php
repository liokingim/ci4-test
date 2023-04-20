<?php
namespace App\Services;

use App\Services\SNSAuth\AuthProviderInterface;

class SNSUserService
{
    protected $authProvider;

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