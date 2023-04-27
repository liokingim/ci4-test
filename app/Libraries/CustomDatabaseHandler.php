<?php
namespace App\Libraries;

use CodeIgniter\Session\Handlers\DatabaseHandler;

class CustomDatabaseHandler extends DatabaseHandler
{
    public function read($sessionID)
    {
        $maxLifetime = (int) ini_get('session.gc_maxlifetime');
        $currentTime = time();
        $session = config('Session');

        $builder = $this->db->table($this->table);
        $row = $builder->select('id, data')
            ->where('id', $session->cookieName . ':' . $sessionID)
            ->where('timestamp >=', $currentTime - $maxLifetime)
            ->get()
            ->getRow();

        if ($row) {
            return $row->data;
        } else {
            $this->fail();
        }

        // return false;
        return parent::read($sessionID);
    }
}