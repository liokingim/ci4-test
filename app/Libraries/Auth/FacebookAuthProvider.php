<?php
namespace App\Libraries\Auth;

use Facebook\Facebook;

class FacebookAuthProvider extends AbstractAuthProvider {

    private $fb;

    public function __construct(array $config) {
        parent::__construct($config);
        $this->fb = new Facebook([
            'app_id' => $config['app_id'],
            'app_secret' => $config['app_secret'],
            'default_graph_version' => $config['graph_version']
        ]);
    }

    public function getLoginUrl(): string {
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = $this->config['permissions'];
        return $helper->getLoginUrl($this->config['redirect_url'], $permissions);
    }

    public function authenticate(string $code): bool {
        $helper = $this->fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken($this->config['redirect_url']);
        } catch (Facebook\Exception\ResponseException $e) {
            // Handle API error
            return false;
        }

        if (!isset($accessToken)) {
            return false;
        }

        $this->fb->setDefaultAccessToken($accessToken);

        return true;
    }

    public function getUserInfo(): array {
        try {
            $response = $this->fb->get('/me?fields=id,name,email');
            return $response->getDecodedBody();
        } catch (Facebook\Exception\ResponseException $e) {
            // Handle API error
            return [];
        }
    }
}