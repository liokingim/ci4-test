<?php
namespace App\Services;

use App\Exceptions\DatabaseException;
use CodeIgniter\Database\ConnectionInterface;

class DatabaseErrorService
{
    protected $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function doSomething(): void
    {
        try {
            $this->db->query("INVALID SQL QUERY");
        } catch (\Throwable $e) {
            throw new DatabaseException("Database error occurred: {$e->getMessage()}", 0, $e);
        }
    }
}