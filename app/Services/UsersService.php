<?php
namespace App\Services;

use App\Exceptions\DatabaseUpdateException;
use CodeIgniter\Model;

class UsersService extends Model
{
    protected $table = 'users';

    public function updateUser(int $id, string $name, string $email, int $version): bool
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'version' => $version + 1
        ];

        $this->set($data);
        $this->where('id', $id);
        $this->where('version', $version);
        $result = $this->update();

        if ($this->affectedRows() === 0) {
            throw new DatabaseUpdateException("Failed to update user. The record has been modified by another user.");
        }

        return true;
    }
}