<?php
namespace App\Libraries\Auth;

use Google\Client;

class GoogleAuthProvider extends AbstractAuthProvider {

    private $client;

    public function __construct(array $config) {
        parent::__construct($config);
        $this->client = new Client();
        $this->client->setClientId($config['client_id']);
        $this->client->setClientSecret($config['client_secret']);
        $this->client->setRedirectUri($config['redirect_url']);
        $this->client->setScopes($config['scopes']);
    }

    public function getLoginUrl(): string {
        return $this->client->createAuthUrl();
    }

    public function authenticate(string $code): bool {
        try {
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
        } catch (\Exception $e) {
            // Handle API error
            return false;
        }

        if (!isset($accessToken['access_token'])) {
            return false;
        }

        $this->client->setAccessToken($accessToken);

        return true;
    }

    public function getUserInfo(): array {
        try {
            $oauth2 = new \Google\Service\Oauth2($this->client);
            return $oauth2->userinfo->get();
        } catch (\Exception $e) {
            // Handle API error
            return [];
        }
    }
}