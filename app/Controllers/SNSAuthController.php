<?php
namespace App\Controllers;

use App\Services\SNSAuth\FacebookAuthProvider;
use App\Services\SNSAuth\GoogleAuthProvider;
use App\Services\SNSUserService;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * SNS 인증 기능을 분리한 클래스를 호출하는 Controller
 */
class SNSAuthController extends BaseController
{
    public function authenticateWithFacebook(string $code)
    {
        $code = $this->request->getGet('code');
        if (!$code) {
            return $this->fail('Missing authentication code', ResponseInterface::HTTP_BAD_REQUEST);
        }

        $authProvider = new FacebookAuthProvider();
        $userService = new SNSUserService($authProvider);
        $result = $userService->authenticateUserWithSNS($code);

        return $this->respond($result);
    }

    public function authenticateWithGoogle(string $code)
    {
        $code = $this->request->getGet('code');
        if (!$code) {
            return $this->fail('Missing authentication code', ResponseInterface::HTTP_BAD_REQUEST);
        }

        $authProvider = new GoogleAuthProvider();
        $userService = new SNSUserService($authProvider);
        $result = $userService->authenticateUserWithSNS($code);

        return $this->respond($result);
    }
}