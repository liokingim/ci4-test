<?php namespace App\Controllers;

use App\Exceptions\DatabaseUpdateException;
use App\Services\UsersService;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function update(int $id)
    {
        $userService = new UsersService();

        $user = $userService->find($id);
        if ($user === null) {
            return $this->failNotFound("User not found");
        }

        $input = $this->request->getPost();
        try {
            $userService->updateUser($id, $input['name'], $input['email'], $user['version']);
        } catch (DatabaseUpdateException $e) {
            return $this->fail($e->getMessage(), 409);
        }

        return $this->respond("User updated successfully");
    }
}