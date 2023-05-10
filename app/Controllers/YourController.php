<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

class YourController extends Controller
{
    public function checkInput()
    {
        $validation =  \Config\Services::validation();

        $inputData = $this->request->getPost('input'); // form에서 'input' 이름으로 전달받은 데이터

        $validation->setRules([
            'input' => [
                'rules' => 'regex_match[/^[0-9]{4}$/]', // 정규 표현식으로 4자리 숫자 패턴 검사
                'errors' => [
                    'regex_match' => 'Input should be a 4-digit number.'
                ]
            ]
        ]);

        if ($validation->run(['input' => $inputData]) == FALSE)
        {
            var_dump($validation->getErrors());
        }
        else
        {
            echo "Input is valid.";
        }
    }
}