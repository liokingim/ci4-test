<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
    public $facebook = [
        'app_id' => 'your_facebook_app_id',
        'app_secret' => 'your_facebook_app_secret',
        'graph_version' => 'v12.0',
        'redirect_url' => 'auth/facebook_callback',
        'permissions' => ['email']
    ];

    public $google = [
        'client_id' => 'your_google_client_id',
        'client_secret' => 'your_google_client_secret',
        'redirect_url' => 'auth/google_callback',
        'scopes' => [\Google\Service\Oauth2::USERINFO_EMAIL,
                    \Google\Service\Oauth2::USERINFO_PROFILE]
    ];
}