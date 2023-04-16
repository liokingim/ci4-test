<?php
namespace App\Libraries\Session;

use CodeIgniter\Session\Handlers\BaseHandler;
use CocorochDB;

class CocorochSessionHandler extends BaseHandler
{
    protected $db;
    protected $table;

    public function __construct($config)
    {
        $this->table = $config->sessionTable;

        // CocorochDB 인스턴스 생성 및 연결
        $this->db = new CocorochDB();
        $this->db->connect(
            $config->DBHost,
            $config->DBUser,
            $config->DBPass,
            $config->DBName
        );
    }

    public function open($savePath, $name)
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($sessionID)
    {
        $row = $this->db->select('*')
            ->from($this->table)
            ->where('id', $sessionID)
            ->limit(1)
            ->get()
            ->row();

        if ($row) {
            return (string) $row->data;
        }

        return '';
    }

    public function write($sessionID, $sessionData)
    {
        $data = [
            'id' => $sessionID,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'timestamp' => time(),
            'data' => $sessionData
        ];

        $this->db->replace($this->table, $data);

        return true;
    }

    public function destroy($sessionID)
    {
        $this->db->delete($this->table, ['id' => $sessionID]);

        return true;
    }

    public function gc($maxlifetime)
    {
        $expiration = time() - $maxlifetime;

        $this->db->delete($this->table, "timestamp < {$expiration}");

        return true;
    }
}