<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\ConnectionInterface;

class DeleteOldSessions extends BaseCommand
{
    protected $group       = 'Tasks';
    protected $name        = 'tasks:deleteoldsessions';
    protected $description = 'Deletes sessions older than 1 hour.';

    public function run(array $params)
    {
        // 데이터베이스 연결
        $db = \Config\Database::connect();

        // 1시간 이상된 세션 삭제
        $db->query("DELETE FROM ci_sessions WHERE now() - INTERVAL '1 hour' > last_activity");

        CLI::write('Old sessions deleted.', 'green');
    }
}




