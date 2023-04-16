<?php
namespace App\Controllers;

use App\Services\InternalCallerService;
use App\Services\SNSAuth\FacebookAuthProvider;
use App\Services\SNSAuth\GoogleAuthProvider;

/**
 * SNS 인증 기능을 분리한 클래스를 호출하는 Controller
 */
class SNSAuthController extends BaseController
{
    public function authenticateWithFacebook(string $code)
    {
        $authProvider = new FacebookAuthProvider();
        $internalCallerService = new InternalCallerService($authProvider);

        $userInfo = $internalCallerService->authenticateUserWithSNS($code);

        // 사용자 정보를 처리하는 로직
    }

    public function authenticateWithGoogle(string $code)
    {
        $authProvider = new GoogleAuthProvider();
        $internalCallerService = new InternalCallerService($authProvider);

        $userInfo = $internalCallerService->authenticateUserWithSNS($code);

        // 사용자 정보를 처리하는 로직
    }
}