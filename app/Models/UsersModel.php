<?php

namespace app\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name', 'email'];
    protected $updatedField = 'updated_at';

    function create($data) {
        $this->insert($data);
        return $this->insertID();
    }

    function read($id) {
        return $this->find($id);
    }

    function updateUser($id, $data) {
        $this->update($id, $data);
        return $this->affectedRows() > 0;
    }

    function deleteUser($id) {
        $this->delete($id);
        return $this->affectedRows() > 0;
    }
}