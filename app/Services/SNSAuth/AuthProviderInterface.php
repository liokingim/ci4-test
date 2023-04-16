<?php
namespace App\Services\SNSAuth;

interface AuthProviderInterface
{
    public function getAuthUrl(): string;
    public function authenticate(string $code): array;
}