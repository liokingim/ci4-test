<?php
namespace App\Libraries\Auth;

abstract class AbstractAuthProvider implements AuthInterface {

    protected $config;

    public function __construct(array $config) {
        $this->config = $config;
    }

    abstract public function getLoginUrl(): string;
    abstract public function authenticate(string $code): bool;
    abstract public function getUserInfo(): array;
}