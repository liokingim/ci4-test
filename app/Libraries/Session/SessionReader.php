<?php
namespace App\Libraries\Session;

use CodeIgniter\Session\SessionInterface;

class SessionReader
{
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getUser()
    {
        return $this->session->get('user');
    }

    public function isLoggedIn(): bool
    {
        return $this->session->has('user');
    }
}