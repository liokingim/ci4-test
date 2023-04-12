<?php
namespace App\Services;

use App\Models\UserModel;

class UserService
{
    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getUserByEmail(string $email)
    {
        return $this->userModel->where('email', $email)->first();
    }
}