<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class SessionController extends Controller
{
    public function index()
    {
        $session = session();

        // 세션에 값을 설정합니다.
        $session->set('user_id', 1);
        $session->set('username', 'John Doe :'.date("Y-m-d H:i:s"));

        // 세션에서 값을 가져옵니다.
        $userId = $session->get('user_id');
        $username = $session->get('username');

        // 가져온 값을 출력합니다.
        echo "User ID: {$userId}<br>";
        echo "Username: {$username}<br>";

        // // 세션에서 값을 삭제합니다.
        // $session->remove('user_id');
        // $session->remove('username');

        // // 세션을 완전히 파기합니다.
        // $session->destroy();
    }

    public function setSessionData()
    {
        $session = session();
        $session->set('test_key', 'test_value');

        return $this->response->setJSON(['message' => 'Session data has been set.']);
    }

    public function getSessionData()
    {
        $session = session();
        $value = $session->get('test_key');

        return $this->response->setJSON(['test_key' => $value]);
    }
}