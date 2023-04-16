<?php
namespace App\Libraries\Auth;

interface AuthInterface {
    public function getLoginUrl(): string;
    public function authenticate(string $code): bool;
    public function getUserInfo(): array;
}